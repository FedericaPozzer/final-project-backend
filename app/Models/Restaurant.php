<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;




class Restaurant extends Model
{
    use HasFactory;

    protected $fillable = ["name", "address", "vat", "phone_number", "image"];


    // relations - restaurants/dishes
    public function dishes(): HasMany
    {
        return $this->hasMany(Dish::class);
    }

    // relations - restaurants/types
    public function types(): BelongsToMany
    {
        return $this->belongsToMany(Type::class);
    }

    // relations - restaurants/owner(user)
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    

    // funzione per ordinare i piatti by name
    public function dishesSortedByName($restaurant_id) {
        return Dish::all()->where('restaurant_id', '=', $restaurant_id)->sortBy('name');
    }

    /* Funzione per sapere se un tipo appartiene al ristorante in base al suo id*/
    public function containsType($type_id) {
        /* richiamo il tipo con il suo id */
        $type = Type::all()->where('id', '=', $type_id)->first();
        /* Controllo se il tipo appartiene al ristorante */
        foreach ($this->types as $restaurantType){
            if($restaurantType->id == $type->id){
                return true;
            }
        }
        return  false;
    }

    public function unshippedOrders() {
        $orders = Order::all()->where('restaurant_id', '=', $this->id)->where('shipped', '=', 0);
        $number = count($orders);
        return $number;
    }

}