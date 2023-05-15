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

    protected $fillable = ["name", "address", "vat", "phone_number", "img"];


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

    // funzione per ordinare i piatti by name
    public function dishesSortedByName($restaurant_id) {
        return Dish::all()->where('restaurant_id', '=', $restaurant_id)->sortByDesc('name');
    }

}