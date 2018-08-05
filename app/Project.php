<?php

namespace App;

use App\Database\Eloquent\Relations\Traits\eloquentRelation;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use eloquentRelation;

    protected $dates = ['eta', 'etb', 'etd', 'updated_at', 'created_at'];
    protected $guarded = [];
    protected $casts = [
        'main' => 'boolean',
        'view_files' => 'boolean',
        'upload_files' => 'boolean',
        'closed' => 'boolean',
    ];

    /*
     * RELATIONS
     */

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function invitations(){
        return $this->hasMany(ProjectInvitation::class);
    }

    public function files(){
        return $this->hasMany(ProjectFile::class);
    }

    /*
     * FUNCTIONS
     */
    public function canEdit(){
        $user = auth()->user();
        if($this->user_id === $user->id || $this->invitations()->where(['main' => true, 'status' => true, 'invited_user_id' => $user->id])->count()){
            return true;
        }
        return false;
    }

    public function canDelete(){
        $user = auth()->user();
        if($this->user_id === $user->id){
            return true;
        }
        return false;
    }

    public function canUploadFiles(){
        $user = auth()->user();
        $invited_used = $this->invitations()->where(['status' => true, 'invited_user_id' => $user->id, 'project_id' => $this->id])->first();
        if($invited_used && $invited_used->upload_files){
            return true;
        }
        return false;
    }

    public function canViewFiles(){
        $user = auth()->user();
        $invited_used = $this->invitations()->where(['status' => true, 'invited_user_id' => $user->id, 'project_id' => $this->id])->first();
        if($this->user_id === $user->id || $invited_used && $invited_used->view_files){
            return true;
        }
        return false;
    }

    public function canInvite(){
        $user = auth()->user();
        if($this->invitations()->where(['status' => true, 'invited_user_id' => $user->id])->count() || $this->user_id === $user->id){
            return true;
        }
        return false;
    }

    /*
     * MUTATORS
     */
    public function getClosedAttribute($value){
        return $value === 1 ? 'closed' : 'open';
    }

    public function getDateAttribute($value){
        if(!$value){
            return '';
        }
        if(($value instanceof Carbon) === false) {
            $value = Carbon::createFromFormat('Y-m-d', $value);
        }
        return $value->format('d/m/Y');
    }

    public function getEtaAttribute($value){
        if(!$value){
            return '';
        }
        if(($value instanceof Carbon) === false) {
            $value = Carbon::createFromFormat('Y-m-d H:i:s', $value);
        }
        return $value->format('d/m/Y H:i');
    }

    public function getEtbAttribute($value){
        if(!$value){
            return '';
        }
        if(($value instanceof Carbon) === false) {
            $value = Carbon::createFromFormat('Y-m-d H:i:s', $value);
        }
        return $value->format('d/m/Y H:i');
    }

    public function getEtdAttribute($value){
        if(!$value){
            return '';
        }
        if(($value instanceof Carbon) === false) {
            $value = Carbon::createFromFormat('Y-m-d H:i:s', $value);
        }
        return $value->format('d/m/Y H:i');
    }

    public function setDateAttribute($value){
        if(!$value){
            return '';
        }
        $this->attributes['date'] = Carbon::createFromFormat('d/m/Y', $value);
    }


    public function setEtaAttribute($value){
        if(!$value){
            return '';
        }
        $this->attributes['eta'] = Carbon::createFromFormat('d/m/Y H:i', $value);
    }

    public function setEtbAttribute($value){
        if(!$value){
            return '';
        }
        $this->attributes['etb'] = Carbon::createFromFormat('d/m/Y H:i', $value);
    }

    public function setEtdAttribute($value){
        if(!$value){
            return '';
        }
        $this->attributes['etd'] = Carbon::createFromFormat('d/m/Y H:i', $value);
    }
}
