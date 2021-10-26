<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 0; $i < 10; $i++){
            //Users
            $newuser = new User();

            $newuser->email = 'nome' . ($i +1) . '@gmail.com';
            $newuser->password = 'password' . ($i +1);
            $newuser->name = 'Nome numero ' . ($i +1);
            $newuser->last_name = 'Cognome numero ' . ($i +1);
            $newuser->address = 'Indirizzo numero ' . ($i +1);
            $newuser->cap = '00000';
            $newuser->slug = Str::slug($newuser->name . ' ' . $newuser->last_name, '-');

            $newuser->save();
        }
    }
}
