<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Street extends Model
{
   protected $fillable=[
       'street_no','block_id'
   ];
   public function block()
   {
       return $this->belongsTo('App\Block');
   }
}
