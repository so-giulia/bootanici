<?php

use Illuminate\Database\Seeder;
use App\Review;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 0;$i < 5; $i++) {
            $newReview = new Review();
            $newReview->user_id= 1;
            $newReview->name= 'marco l\'hater';
            $newReview->feedback_text= 'avevo un pianta.. il botanico mi ha fatto sparire pure il sottovaso';
            $newReview->vote= 3+$i;
            $newReview->save();
        }
        
    }
}
