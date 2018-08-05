<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class ShipFeedComment extends Model
{

    public function feed(){
        return $this->belongsTo(ShipFeed::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function childComments(){
        return $this->hasMany(ShipFeedComment::class, 'reply_id');
    }

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope('orderByDate', function(Builder $builder) {
            $builder->orderby('created_at', 'desc');
        });
    }
}
