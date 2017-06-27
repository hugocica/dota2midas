<?php

namespace App\Http\Controllers;

use App\Helpers\DotaHelper;
use App\Repositories\SteamApi;
use App\Transaction;
use App\User;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use Mockery\CountValidator\Exception;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\RedirectUrls;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    private  $steamapi;
    private $paypal;
    public function __construct(SteamApi $steamapi){
        $this->steamapi = $steamapi;
        $this->middleware('steam_login', ['except' => ['addToCart','clearCart']]);
        $this->paypal = new ApiContext(
            new OAuthTokenCredential(
                'ASVaCkal8vBdjz1s8xSGk-aG9PGz0vMxewMSFOkoaqEDIeBzzYlssBTWeE67g_n86kdIDRUqKbAJ5WG5',
                'EHbb9FvQv67zzf3VKZc_DuAMEsZKf0YI-hMcuGuR4NY6M0pNYGwy9afVxzeEYkZIft2U95n8aVLM2oqe'
            )
        );
    }
    public function index(){
        $user = Auth::user();
        return View::make('user.index')->with('user', $user);
    }
    public function transactions(){
        $user = Auth::user();
        $transactions = Transaction::whereSellerId($user->steam_id)->orWhere('buyer_id','=',$user->steam_id)->get();
        return View::make('user.transaction_info')->with('transactions', $transactions);
    }
    public function sales(){
        $user = Auth::user();
        $transactions = Transaction::whereSellerId($user->steam_id)->whereBuyerId(NULL)->get();
        return View::make('user.sales_info')->with('transactions', $transactions);
    }
    public function addToCart(){
        $transaction_id= Input::get('id');
        $transaction = Transaction::find($transaction_id);
        $count=0;
        if ($transaction) {
            if (Session::has('cart')) {
                $cart = Session::get('cart');
                end($cart['items']);
                $count = key($cart['items']);
                $count++;
            }
            if (isset($cart['items'])) {
                foreach ($cart['items'] as $item) {
                    if ($item['id'] == $transaction_id) {
                        Session::flash('flash_message_warning', 'Item already on cart');
                        return 0;
                    }
                }
            }
            $cart['items'][$count]['id'] = $transaction->id;
            $cart['items'][$count]['item'] = DotaHelper::getQuality($transaction->quality)." ".$transaction->item->name;
            $cart['items'][$count]['price'] = $transaction->price;
            $cart['items'][$count]['image'] = $transaction->item->image_inventory;
            if (isset($cart['item_count'])) {
                $cart['item_count']++;
            }else{
                $cart['item_count']=1;
            }
            if (isset($cart['total'])) {
                $cart['total']+=$transaction->price;

            }else{
                $cart['total']=$transaction->price;
            }
        }else{
            Session::flash('flash_message_error', 'An error has occurred, item not found!');
            return -1;
        }
        Session::flash('flash_message', 'Item added to cart!');
        Session::set('cart',$cart);

        $return = '<li id="'.$transaction->id.'">'.
                          '<span class="item">'.
                              '<span class="item-left">'.
                                '<img  class="center-block" style="height: 100px;" src="'.$transaction->item->image_inventory.'" alt="'.$transaction->item->name.'" />'.
                                '<span class="item-info">'.
                                    '<span>'. DotaHelper::getQuality($transaction->quality)." ".$transaction->item->name.'</span>'.
                                    '<span class="coin-color">'.$transaction->price.' coins</span>'.
                                '</span>'.
                              '</span>'.
                          '</span>'.
                      '</li>';
        return $return;
    }
    public  function  removeFromCart(){
        $cart_id= Input::get('id');
        $cart = Session::get('cart');
        $key_to_delete = -2;
        foreach($cart['items'] as $key=>$item){
            if ($item['id'] == $cart_id) {
                $key_to_delete = $key;
                break;
            }
        }
        $cart['total']-=$cart['items'][$key_to_delete]['price'];
        if ($key_to_delete>=0) {
            unset($cart['items'][$key_to_delete]);
        }
        $cart['item_count']--;
        Session::set('cart',$cart);

        return($key_to_delete);
    }
    public  function  clearCart(){
        Session::pull('cart');
    }
    public function checkout(){
        $cart = Session::get('cart',null);
        if ($cart != null) {
            if ($cart['total'] <= Auth::user()->coins) {
                Session::pull('cart');
                //usuario tem moedas pra comprar
                foreach($cart['items'] as $item){
                    $transaction = Transaction::find($item['id']);
                    $transaction->status = 'waiting';
                    $transaction->buyer_id = Auth::user()->steam_id;
                    $system_transaction= new SystemTransaction();
                    $system_transaction->user_id = Auth::user()->id;
                    $system_transaction->type= "transaction_fee";
                    $coins = $transaction->price;
                    $share = (int)$transaction->price/10;
                    $coins-=$share;
                    $system_transaction->coins = $share;
                    $system_transaction->save();
                    $seller = User::whereSteamId($transaction->seller_id)->first();
                    $seller->coins += $coins;
                    $seller->save();
                    $transaction->save();
                }
                $user = User::find(Auth::user()->id);
                $user->coins -= $cart['total'];
                $user->save();
                return View::make('user.purchase');
            }else{
                //redirecionar para compra de moeda
                Session::flash('flash_message_error', 'An error has occurred. You do not have enough coins!');
                return Redirect::to(action('UserController@coins'));
            }
        }else{
            Session::flash('flash_message_error', 'An error has occurred. No items on cart!');
            return Redirect::to(action('TransactionController@index'));
        }
    }
    public function cart(){
        $cart = Session::get('cart',null);
        return View::make('user.cart')->with('cart',$cart);
    }


    public function coins(){
        return View::make('user.coins');
    }

    /**
     * @param $value
     * @return mixed
     */
    public function coinPurchase($value){

        switch ($value){
            case 100:
                $product = "100 Coins";
                break;
            case 500:
                $product = "500 Coins";
                break;
            case 1000:
                $product = "1000 Coins";
                break;
            case 2000:
                $product = "2000 Coins";
                break;
            case 3500:
                $product = "3500 Coins";
                break;
            case 5000:
                $product = "5000 Coins";
                break;
            case 10000:
                $product = "10000 Coins";
                break;
            case 50000:
                $product = "50000 Coins";
                break;
            default:
                return  Redirect::to(action('UserController@coins'));
                break;
        }

        $shipping = 0;
        $price = (float) $value/100;
        $total = $price + $shipping;
        $payer = new Payer();
        $payer->setPaymentMethod("paypal");

        $item = new Item();
        $item->setName($product)
        ->setCurrency('BRL')
        ->setQuantity(1)
        ->setPrice($price);
        $itemList = new ItemList();
        $itemList->setItems([$item]);

        $details = new Details();
        $details->setShipping($shipping)
        ->setSubtotal($price);

        $amount = new Amount();

        $amount->setCurrency('BRL')
            ->setTotal($total)
            ->setDetails($details);
        $transaction =new \PayPal\Api\Transaction();
        $transaction->setItemList($itemList)
            ->setAmount($amount)
            ->setDescription($value."Coins to buy cosmetic items from Dota 2 Midas")
            ->setInvoiceNumber(uniqid());
        $redirectUrls = new RedirectUrls();
        $redirectUrls->setReturnUrl(action('UserController@confirmPurchase'))
            ->setCancelUrl(action('UserController@confirmPurchase'));

        $payment = new Payment();
        $payment->setIntent('sale')
            ->setPayer($payer)
            ->setRedirectUrls($redirectUrls)
            ->setTransactions([$transaction]);
        try{
            $payment->create($this->paypal);
        }catch (Exception $e){
            dd($e);
        }
        $approvalUrl = $payment->getApprovalLink();
        return Redirect::to($approvalUrl);
    }
    public function confirmPurchase(){
        $user = Auth::user();
        $input = Input::all();
        if ($input != null) {
            if (!isset($input['paymentId'] , $input['PayerID'])) {
                Session::flash('flash_message_error', 'An error has occurred, you were not charged');
            }else{
                //finish purchase
                $paymentId= $input['paymentId'];
                $payerID= $input['PayerID'];
                $payment = Payment::get($paymentId,$this->paypal);
                $execute = new PaymentExecution();
                $execute->setPayerId($payerID);
                try{
                    $result = $payment->execute($execute,$this->paypal);
                }catch (Exception $e){
                    Session::flash('flash_message_error', 'An error has occurred, you were not charged');
                }
                $result=$result->toJSON();
                $result = json_decode($result,true);
                Session::flash('flash_message', 'Coins added successfully! Thank you for your purchase!');
                $user_model = User::find($user->id);
                $user_model->coins = $user_model->coins + $result['transactions'][0]['amount']['total']*100;
                $user_model->save();
            }
        }
        return Redirect::to(action('UserController@index'));
    }
    public function coinRedeem(){
        return View::make('user.redeem');
    }
    public function sendCoinRedeem(Request $request){
        $input = Input::all();
        $input['quantity']=intval($input['quantity']);
        $user = User::find(Auth::user()->id);
        $this->validate($request, [
            'mail' => 'required|email',
            'quantity' => "required|integer|min:500|max:$user->coins",
        ]);

        $info['mail'] = $input['mail'];
        $info['quantity'] =$input['quantity'];
        $user->coins -= $input['quantity'];
        $user->save();
        Mail::send('email.redeem', ['info' =>  $info],function($message)
        {
            $message->from('d2midas@gmail.com', 'redeem')->subject('Coin redeem!');
            $message->to('gabrielfpaula@gmail.com');
        });
        Session::flash('flash_message', 'Money requested successfully!');
        return redirect('user/redeem');
    }


    public function updateTradeUrl(){

        if ( Session::token() !== Input::get( '_token' ) ) {
            return Response::json( array(
                'msg' => 'Unauthorized attempt to create setting'
            ) );
        }

        $url = Input::get( 'url' );

       $user = Auth::user();

        $steamid = $user->steam_id;
        $user = User::whereSteamId($steamid)->first();
        $url = parse_url($url);
        parse_str($url['query'], $output);
        $user->steam_trade_url = $output['token'];
        $user->save();

        $response = array(
            'status' => 'success',
            'msg' => 'Trade URL updated successfully',
        );

        return response()->json( $response );

    }
}
