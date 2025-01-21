<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShipsGallery extends A5Model
{
  public $timestamps = false;
  protected $table = 'ships_gallery';
  protected $fillable = ['id', 'url', 'title', 'ship_id', 'ordering'];

  protected static function boot()
  {
      parent::boot();
      static::creating(function ($ship) {
          if (is_null($ship->ordering)) {
              $ship->ordering = ShipsGallery::max('ordering') + 1;
          }
      });
  }


}
