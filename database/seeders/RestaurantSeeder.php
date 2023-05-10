<?php

namespace Database\Seeders;

use App\Models\Dish;
use App\Models\Restaurant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RestaurantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $restaurant = new Restaurant;
        $restaurant->name = 'ristorante 1';
        $restaurant->save();

        $dish = new Dish;
        $dish->name = "piatto 1";
        $dish->in_stock = 5;
        $dish->save();

        $restaurant->dishes()->save($dish);

        $restaurant->dishes()->first()->stock(10);

    }
}