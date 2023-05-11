<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /* Creo un nuovo utente */
        $user = new User;
        $user->name = "Alessandro";
        $user->password = "password";
        $user->email = "root@root.it";
        $user->save();
    }
}
