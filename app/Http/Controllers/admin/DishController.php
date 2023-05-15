<?php

namespace App\Http\Controllers\admin;

use App\Models\Dish;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use Illuminate\Support\Facades\Validator; // validazione

class DishController extends Controller

{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $dish = new Dish;
        return view('dishes.form', compact("dish"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function store(Request $request)
    {
        $data=$request->all();
        $this->validation($data);
        $dish = new Dish;
        $dish->restaurant()->associate($data['restaurant_id']);
            // se la richiesta contiene available metti 1 (true), altrimenti 0 (false)
        $data["available"] = $request->has("available") ? 1 : 0;
        $dish->fill($data);
        $dish->save();

        return view('dashboard');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Dish  $dish
     * @return \Illuminate\Http\Response
     */
    public function show(Dish $dish)
    {
        return view('dishes.show', compact('dish'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Dish  $dish
     * @return \Illuminate\Http\Response
     */
    public function edit(Dish $dish)
    {
        return view('dishes.form', compact('dish'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Dish  $dish
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Dish $dish)
    {
        $data = $request->all();
        $this->validation($data);
        $dish->update($data);
        return view('dishes.show', compact('dish'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Dish  $dish
     */
    public function destroy(Dish $dish)
    {
        $dish->delete();
        return to_route('dashboard');
    }

    public function restore($id)
    {
        Dish::withTrashed()->find($id)->restore();
        return to_route('dashboard');
    }

    public function delete($id)
    {
        Dish::withTrashed()->find($id)->forceDelete();
        return redirect()->back();
    }

    private function validation($data)
    {
        return  Validator::make(
            $data,
            [
                "name" => "required|string|max:50",
                "description" => "required|string",
                "image" => "string",
                "price" => "required|numeric|min:0.5|max:100", // TODO: la virgola!
                // "available" => "boolean",
                // "restaurant_id" => "required|string",
            ],
            [
                "name.required" => "Inserisci il nome.",
                "name.string" => "Il nome inserito non è corretto.",
                "name.max:50" => "Il nome è troppo lungo (max 50 caratteri).",

                "description.required" => "Inserisci la descrizione.",
                "description.string" => "La descrizione inserita non è corretta.",

                "image.string" => "STRING", // TODO: CHANGE THIS

                "price.required" => "Inserisci un prezzo.",
                "price.numeric" => "Il prezzo deve essere un numero",
                "price.min:0.5" => "Il prezzo minimo è 0,50",
                "price.max:100" => "Il prezzo massimo è 100",
            ]
        )->validate();
    }
    
}
