<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Dish extends Model
{
    use HasFactory;
    public function post(): BelongsTo
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function sell($quantity)
    {
        if ($this->in_stock > $quantity) {
            $this->in_stock -= $quantity;
            $this->save();
            return true;
        } else {
            return false;
        }
    }

    public function add($quantity)
    {
        $this->in_stock += $quantity;
        $this->save();
    }

    public function stock($quantity)
    {
        $this->in_stock = $quantity;
        $this->save();
    }
}