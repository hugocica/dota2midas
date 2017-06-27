<?php

namespace App\Helpers;
Class DotaHelper {

    /**
     * Returns the css class of the item quality
     * @param int $qualityNum
     * @return string
     */
    public static function getQualityCss($qualityNum = 0){

        switch ($qualityNum){
            case 1 :
                $quality = "genuine";
                break;
            case 2 :
                $quality = "elder";
                break;
            case 7 :
                $quality = "self-made";
                break;
            case 3 :
                $quality = "unusual";
                break;
            case 9:
                $quality = "inscribed";
                break;
            case 11 :
                $quality = "cursed";
                break;
            case 12 :
                $quality = "heroic";
                break;
            case 13 :
                $quality = "favored";
                break;
            case 14 :
                $quality = "ascendant";
                break;
            case 15 :
                $quality = "autographed";
                break;
            case 16 :
                $quality = "legacy";
                break;
            case 17 :
                $quality = "exalted";
                break;
            case 18 :
                $quality = "frozen";
                break;
            case 19 :
                $quality = "corrupted";
                break;
            case 20 :
                $quality = "auspicious";
                break;
            default :
                $quality = "normal";
                break;
        }
        return $quality;
    }

    /**
     * Returns the css class of the item quality
     * @param int $qualityNum
     * @return string
     */
    public static function getQuality($qualityNum = 0){
        switch ($qualityNum){
            case 1 :
                $quality = "Genuine";
                break;
            case 2 :
                $quality = "Elder";
                break;
            case 7 :
                $quality = "Self-made";
                break;
            case 3 :
                $quality = "Unusual";
                break;
            case 9:
                $quality = "Inscribed";
                break;
            case 11 :
                $quality = "Cursed";
                break;
            case 12 :
                $quality = "Heroic";
                break;
            case 13 :
                $quality = "Favored";
                break;
            case 14 :
                $quality = "Ascendant";
                break;
            case 15 :
                $quality = "Autographed";
                break;
            case 16 :
                $quality = "Legacy";
                break;
            case 17 :
                $quality = "Exalted";
                break;
            case 18 :
                $quality = "Frozen";
                break;
            case 19 :
                $quality = "Corrupted";
                break;
            case 20 :
                $quality = "Auspicious";
                break;
            default :
                $quality = "";
                break;
        }
        return $quality;
    }

    public static function getMarketHashNameFromItem($original_id){
        $key = "F42F496A56A79B2734CE5557612873CC";
        $game=570;
        $json = file_get_contents(" http://api.steampowered.com/ISteamEconomy/GetAssetClassInfo/v0001/?appid=$game&key=$key&classid=$original_id&class_ count=1");
        $json = json_decode($json);
        return $json->market_hash_name;
    }
    public static function getItemMarketInfo($original_id){
        $market_hash_name = DotaHelper::getMarketHashNameFromItem($original_id);
        $game=570;
        $json = file_get_contents("http://steamcommunity.com/market/priceoverview/?country=us&currency=1&appid=$game&market_hash_name=$market_hash_name");
        $json = json_decode($json);
        return $json;
    }


}








