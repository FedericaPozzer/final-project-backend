<?php

namespace App\Http\Controllers\admin;

use App\Models\Dish;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator; // validazione

class DishController extends Controller

{

    /**
     * Mostra il form per creare un nuovo piatto.
     */
    public function create()
    {
        if(!Auth::id()) {
            return view('welcome');
        } else {
            
            $dish = new Dish;
            // $dish->owner->id;
            return view('dishes.form', compact("dish"));
        }
    }

    /**
     * Salva la nuova risorsa 'piatto' dal form.
     */
    public function store(Request $request, Dish $dish)
    {
        $data=$request->all();

        if(isset($data['image'])){
            $img_path = Storage::disk('public')->put('uploads', $data['image']);
            $data['image'] = 'storage/' . $img_path;
        }
        else if(isset($data['defaultImage'])) {
            $data['image'] = $data['defaultImage'];
        }
        else{
            $data['image'] = '';
        }
        
        $this->validation($data);
        $dish = new Dish;
        $dish->restaurant()->associate($data['restaurant_id']);
            // se la richiesta contiene available metti 1 (true), altrimenti 0 (false)
        $data["available"] = $request->has("available") ? 1 : 0;
        $dish->fill($data);
        $dish->save();

        return to_route('dishes.show', compact('dish'))->with('message_content', "Creato $dish->name");
    }

    /**
     * Mostra la risorsa 'piatto'.
     */
    public function show(Dish $dish)
    {
        return view('dishes.show', compact('dish'));
    }

    /**
     * Mostra il form per modificare la risorsa 'piatto'.
     */
    public function edit(Dish $dish)
    {
        if(Auth::id() !== $dish->restaurant->owner->id) {
            return view('dashboard');
        } else {
            return view('dishes.form', compact('dish'));
        }
    }

    /**
     * Stai veramente leggendo tutti questi commenti? Comunque, salva le modifiche
     * alla risorsa 'piatto'.
     */
    public function update(Request $request, Dish $dish)
    {
        $data = $request->all();

        if(isset($data['image'])){
            $img_path = Storage::disk('public')->put('uploads', $data['image']);
            $data['image'] = 'storage/' . $img_path;
        }
        else if(isset($data['defaultImage'])) {
            $data['image'] = $data['defaultImage'];
        }
        else{
            $data['image'] = '';
        }
        $data["available"] = $request->has("available") ? 1 : 0;
        $this->validation($data);
        $dish->update($data);

        return to_route('dishes.show', compact('dish'))->with('message_content', "$dish->name modificato");
    }

    /**
     * Rimuove la risorsa 'piatto'.
     */
    public function destroy(Dish $dish)
    {   
        $name_dish = $dish->name;
        $dish->delete();
        return to_route('dashboard')
        ->with('message_type', "danger")
        ->with('message_content', "$name_dish inserito nel cestino");
    }

    /* 
    * Ripristina la risorsa 'piatto' cestinata.
    */
    public function restore(Int $id)
    {
        $dish = Dish::where('id',$id)->onlyTrashed()->first();
         $dish->restore();

        return to_route('dashboard')->with('message_content',"$dish->name ripristinato");
    }

    /* 
    * Rimuove definitivamente la risorsa 'piatto'.
    */
    public function forceDelete(Int $id)
    {   
        $dish = Dish::where('id',$id)->onlyTrashed()->first();
        $name_dish = $dish->name;
        $dish->forceDelete();
        return redirect()->route('dashboard')
        ->with('message_type', 'danger')
        ->with('message_content', "$name_dish rimosso definitivamente");
    }




    /* 
    * Validazione dati TOP!!
    */
    private function validation($data)
    {
        return  Validator::make(
            $data,
            [
                "name" => "required|string|max:50",
                "description" => "required|string",
                "image" => "string",
                "price" => "required|numeric|min:0.5|max:100", // TODO: la virgola!
                "available" => "boolean",
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