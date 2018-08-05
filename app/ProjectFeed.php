<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProjectFeed extends Model
{
    protected $guarded = [];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function comments(){
        return $this->hasMany(ProjectFeedComment::class, 'feed_id')->where('reply_id', NULL);
    }

}
