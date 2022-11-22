<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
  use HasFactory;

  protected $table = 'messages';

  protected $fillable = [
    'publication_id',
    'subscriber_id',
    'seen'
  ];

  /*
	|--------------------------------------------------------------------------
	| RELATIONS
	|--------------------------------------------------------------------------
	*/
  public function publication()
  {
    return $this->belongsTo(Publication::class);
  }

  public function subscription()
  {
    return $this->belongsTo(Subscription::class);
  }
}
