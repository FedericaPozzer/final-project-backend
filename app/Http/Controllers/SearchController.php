<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SearchController extends Controller
{
    public function filter(Request $request, Restaurant $restaurant)
    {
        // Search for a user based on their name.
    if ($request->has('name')) {
        return $restaurant->where('name', $request->input('name'))->get();
    }

    // Search for a user based on their company.
    if ($request->has('types')) {
        return $restaurant->where('types', $request->input('types'))
            ->get();
    }

    return Restaurant::all();
    }
}
