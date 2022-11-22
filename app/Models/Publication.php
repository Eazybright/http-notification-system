<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Publication extends Model
{
  use HasFactory;

  protected $table = 'publications';

  protected $fillable = [
    'topic',
    'body',
    'published'
  ];

    /*
	|--------------------------------------------------------------------------
	| RELATIONS
	|--------------------------------------------------------------------------
	*/
  public function message()
  {
    return $this->hasMany(Message::class, 'publication_id');
  }
}
