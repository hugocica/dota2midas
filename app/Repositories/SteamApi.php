<?php namespace App\Repositories;
use App\Item;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
const  APIKEY = "F42F496A56A79B2734CE5557612873CC";
const  GAMEID = 570;
class SteamApi {
    /**
     * Gets Steam info from given user id
     * @param $steam_id
     * @return mixed
     */
    public function getUserInfo($steam_id){
        $key = APIKEY;
        $userJson = file_get_contents("http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=$key&steamids=$steam_id");
        $userJson = json_decode($userJson);
        foreach ($userJson as $object) {
            $userObj=$object->players[0];
        }
        return($userObj);
    }

    /**
     *
     */
    public function getAllGameItems(){
        set_time_limit(60000);
        //addpart 1
        $key = APIKEY;
        $id  = GAMEID;
        $path = public_path().'\items\items_6.txt';
        $contents = $this->VDFtoJSON($path);
        $contents = json_decode($contents,true);
        $this->addToDB($contents);

        dd("DONE");
        //addpart 2
       /* $path = public_path().'\items\items_2.txt';

        $contents = $this->VDFtoJSON($path);

        $contents = json_decode($contents,true);
        $this->addToDB($contents);
        /* $itemsJson = file_get_contents(" ");
         $itemsJson = json_decode($itemsJson);
         dd($itemsJson);*/
    }
    public function getPlayerItems($steam_id){
        $key = "F42F496A56A79B2734CE5557612873CC";
        $game=570;
        //http://api.steampowered.com/IEconItems_570/GetPlayerItems/v0001/?key=F42F496A56A79B2734CE5557612873CC&SteamID=76561198044015941
        $json = file_get_contents("http://api.steampowered.com/IEconItems_$game/GetPlayerItems/v0001/?key=$key&SteamID=$steam_id");
        $json=json_decode($json);
        return $json;
    }
    public function getMarketHashNameFromItem($original_id){
        $key = "F42F496A56A79B2734CE5557612873CC";
        $game=570;
        $json = file_get_contents(" http://api.steampowered.com/ISteamEconomy/GetAssetClassInfo/v0001/?appid=$game&key=$key&classid0=$original_id&class_ count=1");
        $json = json_decode($json);
        return $json->market_hash_name;
    }
    public function getItemMarketInfo($market_hash_name){
        $game=570;
        $json = file_get_contents("http://steamcommunity.com/market/priceoverview/?country=us&currency=1&appid=$game&market_hash_name=$market_hash_name");
        $json = json_decode($json);
        return $json;
    }

    private function  addToDB($contents){
        $key_api = APIKEY;
        $result = "error"; //ficar mais facil de achar
        foreach ($contents as $key =>$value) {
            $item = Item::firstOrNew(['steam_item_id' => $key]);
            if (array_key_exists('static_attributes',$value)) {
                if (array_key_exists('cannot trade',$value['static_attributes'])) {
                    continue;
                }
                if (array_key_exists("tradable after date",$value['static_attributes'])) {
                    $item->tradable_at = $value['static_attributes']["tradable after date"]['value'];
                }

            }

            $item->name = $value['name'];
            if (array_key_exists('creation_date',$value) ) {
                $item->creation_date = $value['creation_date'];
            }
            if (array_key_exists('image_inventory',$value) ) {
                $pos = strrpos($value['image_inventory'],'/');
                $string = substr($value['image_inventory'], $pos);
                $string= str_replace('/', '', $string);
                if (!strrpos($value['image_inventory'],'DOTA')) {
                        $path =  @file_get_contents("https://api.steampowered.com/IEconDOTA2_570/GetItemIconPath/v1/?key=$key_api&format=json&iconname=$string");
                        if($path === FALSE) { // handle error here...
                            $result = "error";
                        }
                        else{
                            $path = json_decode($path);
                            $path = $path->result->path;
                            $result = "http://cdn.dota2.com/apps/570/".$path;
                        }



                }

                $item->image_inventory = $result;
            }
            if (array_key_exists('item_rarity',$value) ) {
                $item->item_rarity = $value['item_rarity'];
            }
            if (array_key_exists('item_type_name',$value) ) {

                $name = str_replace("#DOTA_WearableType_", "",  $value['item_type_name']);
                $name = str_replace('_', ' ', $name);
                $item->item_type_name = $name;
            }
            if (array_key_exists('used_by_heroes',$value) && $value['used_by_heroes']!=0 ) {
                if (is_array($value['used_by_heroes'])) {
                    $name = str_replace("npc_dota_hero_", "",  key($value['used_by_heroes']));
                    $name = str_replace('_', ' ', $name);
                    $name = ucwords($name);
                    $item->hero_name =  $name;
                }else{
                    $item->hero_name =  $value['used_by_heroes'];
                }
            }
            else{
                $item->hero_name = 0;
            }


            // dd($item);
            $item->save();
        }
    }
    public function VDFtoJSON($path){
        //load VDF data either from API call or fetching from file/url
        //no matter your method, $json must contain the VDF data to be parsed
        $json = file_get_contents($path);

        //encapsulate in braces
        $json = "{\n$json\n}";

        //replace open braces
        $pattern = '/"([^"]*)"(\s*){/';
        $replace = '"${1}": {';
        $json = preg_replace($pattern, $replace, $json);

        //replace values
        $pattern = '/"([^"]*)"\s*"([^"]*)"/';
        $replace = '"${1}": "${2}",';
        $json = preg_replace($pattern, $replace, $json);

        //remove trailing commas
        $pattern = '/,(\s*[}\]])/';
        $replace = '${1}';
        $json = preg_replace($pattern, $replace, $json);

        //add commas
        $pattern = '/([}\]])(\s*)("[^"]*":\s*)?([{\[])/';
        $replace = '${1},${2}${3}${4}';
        $json = preg_replace($pattern, $replace, $json);

        //object as value
        $pattern = '/}(\s*"[^"]*":)/';
        $replace = '},${1}';
        $json = preg_replace($pattern, $replace, $json);

        //we now have valid json which we can use and/or store it for later use
        return($json);
        //file_put_contents("items_game.json", $json);

        /* NB: this does not allow for creation of json arrays, however.
         * if you wish to keep working with the json data in PHP, you could
         * do something like this to get an array where needed. eg. for items
         */
       // $data->items_game->items = get_object_vars($data->items_game->items); //items object is now an array

    }
}