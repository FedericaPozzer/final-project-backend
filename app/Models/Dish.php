<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;



class Dish extends Model
{
    use SoftDeletes;
    use HasFactory;
    
    protected $fillable = ["name", "description", "price", "available", "image"];


    // relations - dishes/restaurants
    public function restaurant(): BelongsTo
    {
        return $this->belongsTo(Restaurant::class);
    }

    // relations - dishes/orders
    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class);
    }
    
}