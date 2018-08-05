<?php

namespace App;

use App\Database\Eloquent\Relations\Traits\eloquentRelation;
use Illuminate\Database\Eloquent\Model;

class ProjectInvitation extends Model
{
    protected $guarded = [];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function user_invited(){
        return $this->belongsTo(User::class, 'invited_user_id');
    }
}
