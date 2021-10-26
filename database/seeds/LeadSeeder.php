<?php

use Illuminate\Database\Seeder;
use App\Lead;

class LeadSeeder extends Seeder
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
            $newlead = new Lead();

            $newlead->user_id = 1;
            $newlead->from_email= 'emaildichicco@hot.it';
            $newlead->name_guest = 'mariuccio';
            $newlead->object_email = 'oggetto del messaggio ';
            $newlead->message='il messaggio del messahggio';

            $newlead->save();
        }
    }
}
