<?php

namespace Database\Seeders;

use App\Models\Dish;
use App\Models\Restaurant;
use App\Models\Type;
use App\Models\Order;
use App\Models\User;
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

        $faker = \Faker\Factory::create();

        // for($i=0; $i<5; $i++) {

            $restaurant = new Restaurant;
            $restaurant->name = $faker->company();
            $restaurant->address = $faker->address();
            $restaurant->p_iva = $faker->randomNumber(9, true);


            $restaurant->owner()->associate(User::first());
            $restaurant->save();
            $restaurant->types()->save(Type::all()->random(1)->first());

        // }



        // $order = new Order;
        // $order->save();

        // $order->dishes()->save($dish);


        // $order->dishes()->save($dish);
        // $order->dishes()->save($dish);
    }
}