<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Block extends Model
{
    public $timestamps = true;
    protected $fillable=['name','created_at','updated_at'];

    public function street(){
        return $this->belongsTo('App\Street');
    }
}
