<?php

namespace App\Http\Controllers;

use App\Repositories\SteamApi;
use App\User;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Invisnik\LaravelSteamAuth\SteamAuth;
use Auth;
use Illuminate\Support\Facades\Redirect;

class SteamController extends Controller
{
    /**
     * @var SteamAuth
     */
    private $steam;
    private $steamid;
    private $steamapi;


    public function __construct(SteamAuth $steam , SteamApi $steamapi)
    {
        $this->steam = $steam;
        $this->steamapi = $steamapi;
    }
    /*This method grabs the user's Steam ID and checks if it's already in the DB. if it's not an entry is created */
    public function login()
    {
            if( $this->steam->validate()){
                $steamid =  $this->steam->getSteamId();  //returns the user steamid
                $userObj = $this->steamapi->getUserInfo($steamid);

                if(User::whereSteamId($steamid)->count()==0){// if there's no one with this steam id, create an entry at users table
                    $user =new User();
                    $user->name=$userObj->personaname;
                    $user->steam_id=$userObj->steamid;
                    $user->avatar=$userObj->avatar;
                    $user->avatar_medium=$userObj->avatarmedium;
                    $user->avatar_full=$userObj->avatarfull;
                    $user->communityvisibilitystate=$userObj->communityvisibilitystate;
                    $user->profileurl=$userObj->profileurl;
                    $user->personastate=$userObj->personastate;
                    $user->profilestate=$userObj->profilestate;
                    $user->lastlogoff=$userObj->lastlogoff;

                    $user->save();
                }else{ //user exists already, therefore get the user
                    $user=User::whereSteamId($steamid)->first();
                    $user->name=$userObj->personaname;
                    $user->steam_id=$userObj->steamid;
                    $user->avatar=$userObj->avatar;
                    $user->avatar_medium=$userObj->avatarmedium;
                    $user->avatar_full=$userObj->avatarfull;
                    $user->communityvisibilitystate=$userObj->communityvisibilitystate;
                    $user->profileurl=$userObj->profileurl;
                    $user->personastate=$userObj->personastate;
                    $user->profilestate=$userObj->profilestate;
                    $user->lastlogoff=$userObj->lastlogoff;
                    $user->save();
                }
                //since we are not using passwords to enter, we need to force the login
                Auth::login($user);
                if ($user->steam_trade_url=="") {
                    Session::flash('flash_message_warning',"Your trade URL is not set. Without it, you will not be able to sell nor buy.");
                }

                return Redirect::to(action('UserController@index'));
            }else{
                return  $this->steam->redirect(); //redirect to steam login page
            }
    }
    public function logout()
    {
        Auth::logout();
        Session::pull('cart');
        return Redirect::to('/');
    }
    public function registerSteamItems()
    {
        $items = $this->steamapi->getAllGameItems();
       // dd($items);
    }

}
