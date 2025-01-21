<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ShipsGallery;
use Illuminate\Support\Facades\Log;

class ShipsGalleryController extends Controller
{
    public function destroy($id)
    {
        $ship = ShipsGallery::findOrFail($id);
        $ship->delete();
        return response()->json(['message' => 'ShipsGallery deleted successfully']);
    }

}