<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CabinCategories;
use Illuminate\Support\Facades\Log;

class CabinCategoriesController extends Controller
{
    public function destroy($id)
    {
        $ship = CabinCategories::findOrFail($id);
        $ship->delete();
        return response()->json(['message' => 'CabinCategories deleted successfully']);
    }

}