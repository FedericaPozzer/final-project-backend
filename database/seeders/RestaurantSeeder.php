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

        /* Importo Faker */
        $faker = \Faker\Factory::create();

        /* Array di indirizzi */
        $prefixes = ['Via', 'Piazza', 'Corso'];
        $streets = ['Donatello', 'Michelangelo', 'Leonardo', 'Raffaello', 'Splinter'];

        $prefix = $prefixes[$faker->numberBetween(0, 2)];
        $street = $streets[$faker->numberBetween(0, 4)];
        $number = $faker->numberBetween(1, 50);

        if($faker->boolean(50)){
            $name = $faker->company();
        }
        else{
            $name =  'Da ' . $faker->firstName() ;
        }
        

            /* Creo un nuovo ristorante */
            $restaurant = new Restaurant;
            $restaurant->name = $name;
            $restaurant->address = $prefix . ' ' . $street . ' ' . $number;
            $restaurant->vat = $faker->randomNumber(9, true);
            $restaurant->phone_number = $faker->phoneNumber();

            /* Se l'utente non ha ristoranti gliene associo uno */
            if (!(User::first()->restaurant)){
                $restaurant->owner()->associate(User::first());
                $restaurant->save();
                $restaurant->types()->save(Type::all()->random(1)->first());
            }

    }
}