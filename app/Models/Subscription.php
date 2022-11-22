<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
  use HasFactory;

  protected $table = 'subscriptions';

  protected $fillable = [
    'topic',
    'url',
    'host'
  ];

  /*
  |--------------------------------------------------------------------------
  | RELATIONS
  |--------------------------------------------------------------------------
  */
  public function message()
  {
    return $this->hasMany(Message::class, 'subscription_id');
  }
}
