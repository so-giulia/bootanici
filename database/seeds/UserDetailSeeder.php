<?php

use Illuminate\Database\Seeder;
use App\UserDetail;

class UserDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 0; $i < 10; $i++){
            //Dettagli
            $newdetail = new UserDetail();

            $newdetail->user_id = ($i +1);
            $newdetail->propic_url = 'url';
            $newdetail->bio = 'sono una bio';
            $newdetail->service = 'faccio tutto';
            $newdetail->phone = '555555';
            $newdetail->avg_hourly_rate = '20';

            $newdetail->save();
        }
    }
}
