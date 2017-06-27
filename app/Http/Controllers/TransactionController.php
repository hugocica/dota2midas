<?php

namespace App\Http\Controllers;

use App\Item;
use App\Repositories\SteamApi;
use App\SystemTransaction;
use App\Transaction;
use App\User;
use ArrayObject;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\Environment;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;

class TransactionController extends Controller
{
    private $steamapi;


    public function __construct(SteamApi $steamapi )
    {
        $this->middleware('steam_login', ['only'=>'backpack']);
        $this->steamapi = $steamapi;
    }
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //show items
        //items -> id
        //items -> name
        //items -> price
        //items -> quality

        $quality_filter = array();
        $rarity_filter = array();
        $type_filter = array();
        $name_filter =null;
        $hero_name_filter =null;
        $input = Input::all();

        if ($input) {
            //dd($input);
            //dd($transactions);

            if (isset($input['item'])) {
                if ($input['item'] != '') {
                    $name_filter = $input['item'];
                }
            }
            if (isset($input['hero'])) {
                if ($input['hero'] != 'any') {
                    $hero_name_filter = $input['hero'];
                }
            }
            if (isset($input['quality'])) {
                foreach ($input['quality'] as $quality) {
                    $quality_filter[] = $quality;
                }
            }
            if (isset($input['rarity'])) {
                foreach ($input['rarity'] as $rarity) {
                    $rarity_filter[] = $rarity;

                }
            }
            if (isset($input['type'])) {
                foreach ($input['type'] as $type) {
                    $type_filter[] = $type;
                }
            }
        }
        else{
            $input = array();
        }

        $transactions = Transaction::whereStatus("normal")->quality($quality_filter)->whereHas('item' , function($q) use ($name_filter,$hero_name_filter,$rarity_filter,$type_filter){
            $q->itemName($name_filter)->heroName($hero_name_filter)->itemRarity($rarity_filter)->itemTypeName($type_filter);
        })->orderBy('featured','desc')->get(); // get all items that have transactions
        $transactions = new Paginator($transactions,40);
        return View::make('transactions.index')->with(['adds'=>$transactions, 'input'=>$input]);

    }


    public function backpack()
    {
        //show all the user's items

       $user_items = $this->steamapi->getPlayerItems(Auth::user()->steam_id);
       $user_items =$user_items->result->items;
        $transactions_from_user = Transaction::whereSellerId(Auth::user()->steam_id)->get();
        foreach ($user_items as $item) {
            if (Item::whereSteamItemId($item->defindex)->first()!= null && !property_exists($item, 'flag_cannot_trade') ) {
                $already_a_transaction= false;
                foreach($transactions_from_user as $transaction){
                    if ($transaction->original_id == $item->original_id) {
                        $already_a_transaction=true;
                        break;
                    }
                }
                if (!$already_a_transaction) {
                    $aux_item = Item::whereSteamItemId($item->defindex)->first();
                    $aux_item['original_id'] = $item->original_id;
                    $aux_item['quality'] = $item->quality;
                    $items[]= $aux_item;
                }
            }
        }
        //Faltando Paginação
        $page=1;
        if (isset($items)) {
            $items= array_slice ($items,20*(Input::get('page',1)-1));
            $pagination = new Paginator($items,20);
            return View::make('transactions.backpack')->with( 'items',$pagination );
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //create transaction
        $id = Input::get('id');
        //pegando items do usuario
        $user_items = $this->steamapi->getPlayerItems(Auth::user()->steam_id);
        $user_items = $user_items->result->items;
        foreach ($user_items as $item) {
            if ($item->defindex == $id) {
                $ok = true;
                $user_item = $item;
                break;
            }else{
                $ok = false;
            }
        }
        //pegando informações do item na tabela de itens
        $item = Item::whereSteamItemId($id)->first();

        Session::put('user_item', $user_item);

        if ($ok) {
            return View::make('transactions.create')->with(['item'=>$item, 'user_item' => $user_item]);
        }

        else{
            return redirect('/backpack');
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {

        $input = Input::all();
        $user_item = Session::get('user_item');
        $input['seller_id'] = Auth::user()->steam_id;
        $input['status']="waiting";
        $transaction= new Transaction();

        if (isset($input['featured'])) {
            $system_transaction= new SystemTransaction();
            $system_transaction->user_id = $input['seller_id'];
            $system_transaction->type= "featured_fee";
            $user = User::find(Auth::user()->id);
            if ($user->coins <200) {
                Session::flash('flash_message_warning', 'You do not have enough coins!');
                return redirect(action('UserController@coins'));
            }
            $system_transaction->coins = 200;
            $user->coins-=200;
            $user->save();
            $system_transaction->save();
            $transaction->featured = true;

        }
        $transaction->seller_id = $input['seller_id'];
        $transaction->buyer_id = Null;
        $transaction->item_id = $user_item->defindex;
        $transaction->price = $input['price'];
        $transaction->status = $input['status'];
        $transaction->original_id = $user_item->original_id  ;
        $transaction->quality = $user_item->quality;
        //
        $transaction->save();
        Session::flash('flash_message', 'Sale created successfully!');
        return redirect('backpack');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */

    public function showSells()
    {
        $transaction = Transaction::whereBuyerId(Auth::user()->steam_id)->get();
        return View::make('transactions.showTransactions')->with('transaction' ,$transaction);
    }
    public function showPurchases()
    {
        $transaction = Transaction::whereSellerId(Auth::user()->steam_id)->get();
        return View::make('transactions.showTransactions')->with('transaction' ,$transaction);
    }
    public function show($id)
    {
        $transaction = Transaction::findOrFail($id)->get();
        return View::make('transactions.show')->with('transaction' ,$transaction);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $transaction = Transaction::find($id);
        return View::make('transactions.edit')->with('transaction' ,$transaction);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $transaction = Transaction::find($id);
        if ($transaction->status == 'normal') {
            $transaction->price = $request->input('price');
            $transaction->save();
            Session::flash('flash_message', 'Sale updated successfully!');
        }
        else{
            Session::flash('flash_message_error', 'You can\'t update this sale on it\'s current state!');
        }
        return  redirect('user/sales');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $transaction = Transaction::find($id);
        if ($transaction->status == 'normal') {
            $transaction->status = 'waiting';
            $transaction->buyer_id = Auth::user()->steam_id;
            $transaction->save();
            Session::flash('flash_message', 'Sale deleted successfully! you will receive a trade offer with your items.');
        }
        else{
            Session::flash('flash_message_error', 'You can\'t delete this sale on it\'s current state!');
        }

        return  redirect('user/sales');
    }
}
