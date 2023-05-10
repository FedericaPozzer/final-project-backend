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
        $user = new User;
        $user->name = "Alessandro";
        $user->password = "password";
        $user->email = "root@root.it";
        $user->save();

        $type = new Type;
        $type->name = 'Italiano';
        $type->save();

        $restaurant = new Restaurant;
        $restaurant->name = 'Da Gennaro';
        $restaurant->owner()->associate($user);
        $restaurant->save();
        $restaurant->types()->save($type);

        $dish = new Dish;
        $dish->name = "Pizza Margherita";
        $dish->in_stock = 5;
        $dish->save();

        $restaurant->dishes()->save($dish);

        $dish = new Dish;
        $dish->name = "Pizza Diavola";
        $dish->in_stock = 3;
        $dish->save();

        $restaurant->dishes()->save($dish);

        $restaurant->dishes()->first()->stock(10);

        $type = new Type;
        $type->name = 'Turco';
        $type->save();

        $restaurant = new Restaurant;
        $restaurant->name = 'Da Abdul';
        $restaurant->owner()->associate($user);
        $restaurant->save();
        $restaurant->types()->save($type);

        $dish = new Dish;
        $dish->name = "Pizza Kebab";
        $dish->description = "non è una pizza";
        $dish->in_stock = 5;
        $dish->save();

        $restaurant->dishes()->save($dish);

        $dish = new Dish;
        $dish->name = "Falafel";
        $dish->in_stock = 3;
        $dish->save();

        $restaurant->dishes()->save($dish);

        $restaurant->dishes()->first()->stock(10);

        $order = new Order;
        $order->save();

        $order->dishes()->save($dish);

        $dish = new Dish;
        $dish->name = "Pizza Patatine e Wurstel";
        $dish->in_stock = 3;
        $dish->save();

        $order->dishes()->save($dish);
        $order->dishes()->save($dish);
    }
}