<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reserve extends Model
{
  //
  protected $fillable = [
    'user_id',
    'latitude',
    'longitude',
    'address',
    'date',
    'start_time',
    'end_time',
    'area',
    'drone',
    'cost',
  ];
  public function user()
  {
    return $this->belongsTo('App\User');
  }
}
