<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShipFeed extends Model
{
    protected $guarded = [];

    public function ship(){
        return $this->belongsTo(Ship::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function comments(){
        return $this->hasMany(ShipFeedComment::class, 'feed_id')->where('reply_id', null);
    }
}
