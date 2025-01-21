<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class A5Model extends Model
{

  public function __construct(array $attributes = [])
  {
      parent::__construct($attributes);
      $columns = Schema::getColumnListing($this->getTable());
      foreach ($columns as $column) {
          $this->setAttribute($column, $this->getAttribute($column) ?? null);
      }
  }


}