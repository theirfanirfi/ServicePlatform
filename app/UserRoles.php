<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserRoles extends Model
{
	public $timestamps=true;
    protected $table='roles_user';
	protected $fillable = [
        'roles_id', 'user_id','created_at','updated_at'
    ];
}
