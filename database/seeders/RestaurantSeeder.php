<?php

namespace Database\Seeders;

use App\Models\Dish;
use App\Models\Restaurant;
use App\Models\Type;
use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

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

        // nome ristorante (company o "Da" + nome proprio)
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
                $images = ['restaurant_images/1.jpg', 'restaurant_images/2.jpg', 'restaurant_images/3.jpg', 'restaurant_images/4.jpg', 'restaurant_images/5.jpg'];
                $restaurant->image = $images[$faker->numberBetween(0,4)];
                $restaurant->save();
                $restaurant->types()->save(Type::all()->random(1)->first());
            }

            for($i=0; $i<20; $i++)
            {
                $user = new User;
                $user->name = $faker->name();
                $user->password = Hash::make("password");
                $user->email = $faker->email();
                $user->save();

                $prefix = $prefixes[$faker->numberBetween(0, 2)];
                $street = $streets[$faker->numberBetween(0, 4)];
                $number = $faker->numberBetween(1, 50);

                // nome ristorante (company o "Da" + nome proprio)
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

                $restaurant->owner()->associate($user);
                $images = ['restaurant_images/1.jpg', 'restaurant_images/2.jpg', 'restaurant_images/3.jpg', 'restaurant_images/4.jpg', 'restaurant_images/5.jpg'];
                $restaurant->image = $images[$faker->numberBetween(0,4)];
                $restaurant->save();
                $numbOfTypes = $faker->numberBetween(1, 3);
                $types = Type::all()->random($numbOfTypes);
                foreach($types as $type){
                    $restaurant->types()->save($type);
                }
            }

    }
}