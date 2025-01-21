<?php

namespace App\Models;

use App\Models\Ships;

class CabinCategories extends A5Model
{
  public $timestamps = false;
  protected $fillable = ['id', 'ship_id', 'vendor_code', 'title', 'type', 'description', 'photos', 'ordering', 'state'];

  protected static function boot()
  {
      parent::boot();
      static::creating(function ($ship) {
          if (is_null($ship->ordering)) {
              $ship->ordering = CabinCategories::max('ordering') + 1;
          }
          if (is_null($ship->state)) {
            $ship->state = 0;
          }
      });
  }

  public function ship()
  {
      return $this->belongsTo(Ships::class);
  }
}
