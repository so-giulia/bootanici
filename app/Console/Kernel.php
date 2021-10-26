<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\PromoUser;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        \App\Console\Commands\CheckCommand::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('word:day')->everyMinute();

        // $schedule->call(function () {


        //     $newPromoUser = new PromoUser();
        //     $newPromoUser->promo_id = 1;
        //     $newPromoUser->user_id = 9;
        //     $newPromoUser->start = Carbon::now()->timezone('Europe/Stockholm');
        //     $newPromoUser->end =Carbon::now()->timezone('Europe/Stockholm')->addMinutes(5);

        //     $newPromoUser->save();

        //     DB::table('Users')->update(['start' => 'value']);

        //     PromoUser::whereRaw('start >= end')->delete();
        //     DB::table('recent_users')->delete();
        // })->everyMinute();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
