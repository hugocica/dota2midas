<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = [
      'steam_item_id',
    ];
    //
    public function transactions()
    {
        return $this->hasMany('App\Transaction', 'item_id', 'steam_item_id');
    }
    public function scopeItemRarity($query, $rarity)
    {
        if ($rarity) {
            return $query->whereIn('item_rarity',$rarity);
        }
        return $query;
    }
    public function scopeItemTypeName($query, $type)
    {
        if ($type) {
            return $query->whereIn('item_type_name',$type);
        }
        return $query;
    }
    public  function scopeItemName($query, $value){
        if ($value) {
        return $query->where('name', 'LIKE', "%$value%");
        }
    }
    public  function scopeHeroName($query, $value){
        if ($value) {
              return $query->where('hero_name', 'LIKE', "%$value%");
        }
    }
}
