<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    use HasFactory;
    

    // relations - orders/dishes
    public function dishes(): BelongsToMany
    {
        return $this->belongsToMany(Dish::class)->withPivot('quantity');
    }

    public function restaurant(): BelongsTo
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function totalPrice(){
        $price = 0;
        foreach($this->dishes as $dish)
        {
            for ($i = 0; $i < $dish->pivot->quantity; $i++)
            {
                $price += $dish->price;
            }

        }
        return $price;
    }
}
