<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    public function item()
    {
        return $this->belongsTo('App\Item','item_id','steam_item_id');
    }
    public function seller()
    {
        return $this->belongsTo('App\User','seller_id','steam_id');
    }
    public function buyer()
    {
        return $this->belongsTo('App\User','buyer_id','steam_id');
    }
    public function scopeQuality($query, $quality)
    {
        if ($quality) {
            return $query->whereIn('quality',$quality);
        }
        return $query;
    }
    public function scopeStatus($query)
    {
        return $query->where('status','=','waiting')->Orwhere('status','=','taken_by_bot');
    }
}
