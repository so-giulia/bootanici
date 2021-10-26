<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\PromoUser;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CheckCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'word:day';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Eccolo!!!!';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        info('called every minute');

        // $newPromoUser = new PromoUser();
        // $newPromoUser->promo_id = 1;
        // $newPromoUser->user_id = 9;
        // $newPromoUser->start = Carbon::now()->timezone('Europe/Stockholm');
        // $newPromoUser->end =Carbon::now()->timezone('Europe/Stockholm')->addMinutes(5);

        // $newPromoUser->save();
    }
}
