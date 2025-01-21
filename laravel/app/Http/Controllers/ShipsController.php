<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ships;
use App\Models\ShipsGallery;
use App\Models\CabinCategories;
use Illuminate\Support\Facades\Log;

class ShipsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
      return response()->json([
        'ships' => Ships::with(['cabinCategories', 'shipsGallery'])->orderBy('ordering')->get()
      ]);
    }

    public function show($id)
    {
      $ship = Ships::with(['cabinCategories', 'shipsGallery'])->find($id); 
      if (!$ship) {
        $ship = new Ships();
        $ship->setRawAttributes($ship->getAttributes());
        $ship->setRelation('cabinCategories', collect([]));
        $ship->setRelation('shipsGallery', collect([]));
        $ship->spec = [];
      }
      return response()->json(
        [
          'ship' => $ship, 
          'cabinCategories' => CabinCategories::orderBy('ordering')->get(),
          'shipsGallery' => ShipsGallery::orderBy('ordering')->get()
        ]
      );
    }

    public function update(Request $request, $id)
    {
Log::info($request);
      $ship = Ships::with(['cabinCategories', 'shipsGallery'])->find($id); 
      if (!$ship) {
        $ship = new Ships();
        $ship->setRelation('cabinCategories', collect([]));
        $ship->setRelation('shipsGallery', collect([]));
        //$ship->setRawAttributes($ship->getAttributes());
      }

      foreach($ship->getAttributes() as $key => $value){
        if($request->has($key)){
          $ship->{$key} = $request->get($key);
        }
      }
      foreach ($ship->getRelations() as $relation => $related) {
        if($request->has($relation)){
          //$ship->setRelation($relation, collect($request->get($relation)));
          $relationData = collect($request->get($relation));
          $ship->setRelation($relation, $relationData);
          foreach ($relationData as $item) {
              $ship->{$relation}()->updateOrCreate(
                  ['id' => $item['id'] ?? null],
                  $item
              );
          }

        }
      }

Log::info($ship->getAttributes());
Log::info($ship->getRelations());
      $ship->save();

      return response()->json([
        'ship' => $ship
      ]);
    }

    public function destroy($id)
    {
        $ship = Ships::findOrFail($id);
        $ship->delete();
        return response()->json(['message' => 'Ship deleted successfully']);
    }

  }