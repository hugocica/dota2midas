<?php

namespace App\Http\Controllers;

use App\Transaction;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\View;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {

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
        return View::make('pages.home')->with(['adds'=>$transactions, 'input'=>$input]);
        //$json = file_get_contents("http://api.steampowered.com/IEconItems_205790/GetSchema/v0001/?key=F42F496A56A79B2734CE5557612873CC&format=VDF");
    }
    public function about(){
        return View::make('pages.about');
    }
    public function faq(){
        return View::make('pages.faq');
    }
    public function support(){
        return View::make('pages.support');
    }
    public function terms(){
        return View::make('pages.terms');
    }
    public function partners(){
        return View::make('pages.partners');
    }

}
