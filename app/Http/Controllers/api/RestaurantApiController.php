<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use Illuminate\Http\Request;

class RestaurantApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        $restaurants = Restaurant::where('name', '<>', null)
        ->with('types')
        ->get();
        return response()->json(
            $restaurants
        );
    }

    public function search($query)
    {
        $restaurants = Restaurant::where('name', 'like', '%'.$query.'%')->get();
        return response()->json($restaurants);
    }

    public function show($id)
    {
        $restaurant = Restaurant::with('dishes')->where('id', '=', $id)->first();
        return response()->json(
            $restaurant
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
