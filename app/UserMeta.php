<?php

namespace App;
use App\User;
use Illuminate\Database\Eloquent\Model;

class UserMeta extends Model
{
    public $timestamps = true;
    protected $table = 'users_meta';

    public function users(){
        return $this->belongsTo('App\User');
     }
}
