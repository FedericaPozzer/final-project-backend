<?php

namespace App\Http\Controllers\admin;

use App\Models\Restaurant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Dish;
use App\Models\Order;
use App\Models\Type;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Termwind\Components\Dd;

class RestaurantController extends Controller
{


    /**
     * Crea una nuova risorsa 'ristorante'.
     */
    public function create()
    {
        if(!Auth::id()) {
            return view('welcome');
        } else {
            
            $restaurant = new Restaurant;
            $types = Type::all();
            return view('restaurant.form', compact("restaurant", 'types'));
        }
    }

    /**
     * Salva una nuova risorsa 'ristorantes'.
    */
    public function store(Request $request)
    {
        $data=$request->all();

        if(isset($data['image'])){

            if($data['image'] == 'upload_file'){
                $img_path = Storage::disk('public')->put('uploads', $data['uploaded_file']);
                $data['image'] = 'storage/' . $img_path;
            }
            else{
                $data['image'] = substr($data['image'], 1);
            }
        }

        /* Valido i dati inseriti*/
        $this->validation($data);
        $restaurant = new Restaurant;

        /* Associo il ristorante all'utente loggato */
        $restaurant->user_id = $request->user()->id;

        /* Salvo i dati  */
        $restaurant->fill($data);
        $restaurant->save();
        
        /** 
         * FUNZIONE PER ESTRARRE LE CATEGORIE CHECKATE DALL'UTENTE DALLA RICHIESTA
        */

        /* Per ogni campo della richiesta inviata */
        foreach ($data['types'] as $typeID){
                $type = Type::all()->where('id', '=', $typeID)->first();
                $restaurant->types()->save($type);

        }
        /* Ritorno alla rotta 'dashboard' con il messaggio di avvenuta creazione */

        return to_route('dashboard', $restaurant)->with('message_content', "Hai creato la tua attività! Diamo il benvenuto a $restaurant->name e al suo staff.");
        
    }

    /**
     * Mostro il form per modificare il ristorante.
     */
    public function edit(Restaurant $restaurant)
    {
        if(Auth::id() !== $restaurant->owner->id) {
            return view('dashboard');
        } else {
            $types = Type::all();
            return view('restaurant.form', compact("restaurant", 'types'));
        }
    }

    /**
     * Aggiorno i dati della risorsa 'ristorante'.
     */
    public function update(Request $request, Restaurant $restaurant)
    {
        $data = $request->all();
        
        if(isset($data['image'])){

            if($data['image'] == 'upload_file'){
                $img_path = Storage::disk('public')->put('uploads', $data['uploaded_file']);
                $data['image'] = 'storage/' . $img_path;
            }
            else{
                $data['image'] = substr($data['image'], 1);
            }
        }
        
        /* Valido */
        $this->validation($data);

        /* Dissocio tutti i 'tipi' della risorsa 'ristorante' */
        $restaurant->types()->detach();
        /* Riassocio tutti i nuovi tipi */
        foreach ($data['types'] as $typeID){
            $type = Type::all()->where('id', '=', $typeID)->first();
            $restaurant->types()->save($type);

        }
        $restaurant->update($data);

        /* Return alla view dashboard con il messaggio di avvenuta modifica */

        return to_route('dashboard', $restaurant)->with('message_content', "Hai modificato i dati della tua attività $restaurant->name.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Restaurant  $restaurant
     * @return \Illuminate\Http\Response
     */
    public function destroy(Restaurant $restaurant)
    {
        $name_restaurant = $restaurant->name;
        $restaurant->delete();

        /* Return alla view dashboard con il messaggio di avvenuta cancellazione */

        return to_route('dashboard')
        ->with('message_type', "danger")
        ->with('message_content', "La tua attività $name_restaurant è stata cancellata.");
    }

    private function validation($data)
    {
        return  Validator::make(
            $data,
            [
                "name" => "required|string|max:20",
                "address" => "required|string",
                "vat" => "required|string|max:30",
                "phone_number" => "required|string",
                "image" => "required|string",
                "types" => "required|min:1"
                
            ],
            [
                "name.required" => "Inserisci il nome.",
                "name.string" => "Il nome inserito non è corretto.",
                "name.max:100" => "Il nome è troppo lungo (max 20 caratteri).",

                "address.required" => "Inserisci l'indirizzo.",
                "address.string" => "L'indirizzo inserito non è corretto.",

                "vat.required" => "Inserisci partita IVA.",
                "vat.string" => "La partita IVA non è corretta.",
                "vat.max:30" => "La partita IVA è troppo lunga (max 30 caratteri).",

                "phone_number.required" => "Inserisci il numero di telefono",
                "phone_number.string" => "Il numero inserito non è corretto.",

                "image.required" => "Seleziona un'immagine.", 

                "types.required" => "Scegli almeno un tipo.",
                "types.min" => "Scegli almeno un tipo.",
            ]
        )->validate();
    }

    public function trash(){
        $dishes = Dish::onlyTrashed()->where('restaurant_id', '=', auth()->user()->restaurant->id)->get();
        return view('restaurant.trash', compact('dishes'));
    }

    public function orders(){
        $orders = Order::all();
        return view('restaurant.orders', compact('orders'));
    }

    
    
}