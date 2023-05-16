<?php

namespace App\Http\Controllers\admin;

use App\Models\Restaurant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Dish;
use App\Models\Order;
use App\Models\Type;
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
        $types = Type::all();
        return view('restaurant.form', compact("restaurant", 'types'));
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
        
        /* Per ogni campo della richiesta inviata */
        foreach ($data as $key => $value){
            /* Controllo se contiene la parola 'check' */
            if (str_contains($key, 'check')){
                /* Nel caso recupera il tipo con l'id corrispondente */
                $type = Type::all()->where('id', '=', $value)->first();
                /* Salvo il tipo nel ristorante */
                $restaurant->types()->save($type);

            }
        }
        /* Return alla view dashboard con il messaggio di avvenuta creazione */

        return to_route('dashboard', $restaurant)->with('message', "Hai creato la tua attività!!Diamo il benvenuto a $restaurant->name e al suo staff.");
        
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
        $types = Type::all();
        return view('restaurant.form', compact("restaurant", 'types'));
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
        /* Dissocio tutti i tipi */
        $restaurant->types()->detach();
        /* Riassocio tutti i nuovi tipi */
        foreach ($data as $key => $value){
            if (str_contains($key, 'check')){
                $type = Type::all()->where('id', '=', $value)->first();
                $restaurant->types()->save($type);

            }
        }
        $restaurant->update($data);

        /* Return alla view dashboard con il messaggio di avvenuta modifica */

        return to_route('dashboard', $restaurant)->with('message', "Hai modificato i dati della tua attività $restaurant->name.");
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

        return to_route('dashboard')->with('message', "La tua attività $name_restaurant è stata cancellata. ");
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

    public function orders(){
        $orders = Order::all();
        return view('restaurant.orders', compact('orders'));
    }
    
}