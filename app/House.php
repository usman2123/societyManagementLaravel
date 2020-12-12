<?php
use App\User;
namespace App;

use Illuminate\Database\Eloquent\Model;

class House extends Model
{




    public function users(){
        return $this->hasMany('App\User');
       }
}
