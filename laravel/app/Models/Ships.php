<?php

namespace App\Models;

use App\Models\CabinCategories;
use App\Models\ShipsGallery;

class Ships extends A5Model
{

  public $timestamps = false;
  
  protected static function boot()
  {
      parent::boot();
      static::creating(function ($ship) {
          if (is_null($ship->ordering)) {
              $ship->ordering = Ships::max('ordering') + 1;
          }
          if (is_null($ship->state)) {
            $ship->state = 0;
          }
      });
  }

  protected function casts(): array
  {
      return [
          'spec' => 'array',
      ];
  }
  public function cabinCategories()
  {
     return $this->hasMany(CabinCategories::class, 'ship_id');
  }

  public function shipsGallery()
  {
     return $this->hasMany(ShipsGallery::class, 'ship_id');
  }
}
