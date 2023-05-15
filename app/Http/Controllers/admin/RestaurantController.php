<?php

namespace App\Http\Controllers\admin;

use App\Models\Restaurant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Dish;
use Illuminate\Support\Facades\Validator;

class RestaurantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $restaurant = Restaurant::orderBy('updated_at', 'DESC')->paginate(5);
        // return view('restaurant.index',compact('restaurant'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $restaurant = new Restaurant;
        return view('restaurant.form', compact("restaurant"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data=$request->all();
        $this->validation($data);
        $restaurant = new Restaurant;
        $restaurant->user_id = $request->user()->id;
        $restaurant->fill($data);
        $restaurant->save();

        return view('restaurant.show', compact("restaurant"));
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Restaurant  $restaurant
     * @return \Illuminate\Http\Response
     */
    public function show(Restaurant $restaurant)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Restaurant  $restaurant
     * @return \Illuminate\Http\Response
     */
    public function edit(Restaurant $restaurant)
    {
        return view('restaurant.form', compact("restaurant"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Restaurant  $restaurant
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Restaurant $restaurant)
    {
        $data = $request->all();
        $this->validation($data);
        $restaurant->update($data);
        return view('restaurant.show', compact("restaurant"));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Restaurant  $restaurant
     * @return \Illuminate\Http\Response
     */
    public function destroy(Restaurant $restaurant)
    {
        $restaurant->delete();
        return redirect('dashboard');
    }

    private function validation($data)
    {
        return  Validator::make(
            $data,
            [
                "name" => "required|string|max:100",
                "address" => "required|string",
                "vat" => "required|string|max:30",
                "phone_number" => "required|string",
                "image" => "string",
                
            ],
            [
                "name.required" => "Inserisci il nome.",
                "name.string" => "Il nome inserito non è corretto.",
                "name.max:100" => "Il nome è troppo lungo (max 100 caratteri).",

                "address.required" => "Inserisci l'indirizzo.",
                "address.string" => "L'indirizzo inserito non è corretto.",

                "vat.required" => "Inserisci partita IVA.",
                "vat.string" => "La partita IVA non è corretta.",
                "vat.max:30" => "La partita IVA è troppo lunga (max 30 caratteri).",

                "phone_number.required" => "Inserisci il numero di telefono",
                "phone_number.string" => "Il numero inserito non è corretto.",

                "image.string" => "STRING", // TODO: CHANGE THIS
            ]
        )->validate();
    }

    public function trash(){
        $dishes = Dish::onlyTrashed()->where('restaurant_id', '=', auth()->user()->restaurant->id)->get();
        return view('restaurant.trash', compact('dishes'));
    }
    
}