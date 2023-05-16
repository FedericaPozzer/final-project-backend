<?php

namespace Database\Seeders;

use App\Models\Dish;
use App\Models\Order;
use App\Models\Restaurant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 5; $i++)
        {
            $faker = \Faker\Factory::create();

            $restaurants = Restaurant::all();
            foreach($restaurants as $restaurant)
            {
                $order = new Order;
                $order->shipped = 0;
                $order->guest_name = $faker->name();
                $order->guest_address = $faker->address();
                $order->guest_mail = $faker->email();
                $order->save();
                $restaurant->orders()->save($order);
        
                for ($y= 0; $y < $faker->randomDigit(); $y++)
                {
                    $order->dishes()->save(Dish::all()->where('restaurant_id', '=', $restaurant->id)->random(1)->first(), ['quantity' => $faker->numberBetween(1, 5)]);
                }
            }
        }

    }
}
