<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
use App\Item;
use Illuminate\Support\Facades\Storage;

Route::get('/', "PageController@index");
Route::get('/about', "PageController@about");
Route::get('/faq', "PageController@faq");
Route::get('/partners', "PageController@partners");
Route::get('/support', "PageController@support");
Route::get('/terms', "PageController@terms");
Route::get('/login', "SteamController@login");
Route::get('/logout', "SteamController@logout");
Route::get('/reg', "SteamController@registerSteamItems");
Route::get('/backpack', "TransactionController@backpack");
Route::get('/user', "UserController@index");
Route::get('/user/coins', "UserController@coins");
Route::get('/user/cart', "UserController@cart");
Route::get('/user/coins/purchase/{value}', "UserController@coinPurchase");
Route::get('/user/coins/confirm', "UserController@confirmPurchase");
Route::get('/user/transactions', "UserController@transactions");
Route::get('/user/addcart', "UserController@addToCart");
Route::get('/user/clearcart', "UserController@clearCart");
Route::get('/user/removecart', "UserController@removeFromCart");
Route::get('/user/redeem', "UserController@coinRedeem");
Route::post('/user/sendCoinRedeem', "UserController@sendCoinRedeem");
Route::get('/user/checkout', "UserController@checkout");
Route::get('/user/sales', "UserController@sales");
Route::resource('transactions', 'TransactionController');
Route::post( '/updateTradeUrl', "UserController@updateTradeUrl");
Route::get( '/robots/{password}', function($password){
    /*if ($password != "aMpl5v99hI125O8kn423b80525D3ea5MS15OrF8i27kCV9X02D3X374M03WQ") {
        return null;
    }*/
    //pegar a primeira transação que tiver no estado waiting
    $first_transaction = \App\Transaction::whereStatus("waiting")->first();
    //tem buyer id?
    if (!$first_transaction) {
        $transactions['exists'] = false;
        return json_encode($transactions);
    }else{

        $transactions['exists'] = true;
    }

    $buyer_id = $first_transaction->buyer_id;
    //se sim pegar todas as transações do comprador que estejam shipping
    $transactions['security_token'] = md5(uniqid(rand(), true));


    if ($buyer_id) {
        $transactions_of_buyer = \App\Transaction::whereStatus("waiting")->whereBuyerId($buyer_id)->get();
        $buyer = \App\User::whereSteamId($buyer_id)->first();
        if ($buyer->steam_trade_url==""){
            return false;
        }

        foreach($transactions_of_buyer as $key=>$transaction){
            //atualizar os status das transações
            //$transaction->status = 'taken_by_bot';
            $transactions['steam_id']=$transaction->buyer_id;
            $transactions['sell']=false;
            $transactions['token']=$buyer->steam_trade_url;
            $transactions['items'][$key]['assetid']=$transaction->original_id;
            $transactions['items'][$key]['appid']=570;
            $transactions['items'][$key]['contextid']=2;
            $transactions['items'][$key]['amount']=1;
            if (!isset($transactions['names'])) {
                $transactions['names']=$transaction->item()->first()->name;
            }
            else{
                $transactions['names'].=", ".$transaction->item()->first()->name;
            }
            //$transaction->save();
        }
        $user = \App\User::whereSteamId($buyer_id)->first();

    }else{
        //se não pegar todas as transações do vendedor que estejam waiting
        $seller_id = $first_transaction->seller_id;

        $transactions_of_seller = \App\Transaction::whereStatus("waiting")->whereSellerId($seller_id)->get();
        //get user token
        $seller = \App\User::whereSteamId($seller_id)->first();
        if ($seller->steam_trade_url==""){
            return false;
        }
        foreach($transactions_of_seller as $key=>$transaction){
            //atualizar os status das transações
            //$transaction->status = 'taken_by_bot';
            $transactions['steam_id']=$transaction->seller_id;
            $transactions['sell']=true;
            $transactions['token']=$seller->steam_trade_url;
            $transactions['items'][$key]['assetid']=$transaction->original_id;
            $transactions['items'][$key]['appid']=570;
            $transactions['items'][$key]['contextid']=2;
            $transactions['items'][$key]['amount']=1;
            if (!isset($transactions['names'])) {
                $transactions['names']=$transaction->item()->first()->name;
            }
            else{
                $transactions['names'].=", ".$transaction->item()->first()->name;
            }
            //$transaction->save();
            $user = \App\User::whereSteamId($seller_id)->first();

        }
    }
    $user->security_token = $transactions['security_token'];
    $user->save();

    //atualizar o security token
    //$transaction->security_string = md5(str_random(32));
    return json_encode($transactions);
});
Route::get('data/items',function(){
    $items = Item::has('transaction')->get(['name', 'hero_name']);
    $result = Storage::put('items.json', $items->toJson());
    return ((string)$result);
});
Route::get( '/robots/{password}/{type}/{user_id}/{status}',function($password,$type,$user_id,$status){
    //aMpl5v99hI125O8kn423b80525D3ea5MS15OrF8i27kCV9X02D3X374M03WQ
    if ($password!= "aMpl5v99hI125O8kn423b80525D3ea5MS15OrF8i27kCV9X02D3X374M03WQ") {
        return null;
    }

    if ($type=="sell") {
        $transactions = \App\Transaction::whereSellerId($user_id)->Status()->get();
    }
    else{
        $transactions = \App\Transaction::whereBuyerId($user_id)->Status()->get();
    }

    foreach($transactions as $transaction){
        if ($transaction->status == "taken_by_bot" && $status =="waiting") {
            $transaction->status = $status;

        }elseif( $status !="waiting"){
            $transaction->status = $status;
        }
        $transaction->save();
    }

    return ($type);
});
