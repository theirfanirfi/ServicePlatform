<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class ProjectFeedComment extends Model
{
    protected $guarded = [];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function feed(){
        return $this->belongsTo(ProjectFeed::class);
    }

    public function childComments(){
        return $this->hasMany(ProjectFeedComment::class, 'reply_id');
    }

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope('orderByDate', function(Builder $builder) {
            $builder->orderby('created_at', 'desc');
        });
    }

}
