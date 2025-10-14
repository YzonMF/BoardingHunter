<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
<<<<<<< HEAD
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
=======
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
>>>>>>> df8fd1e0a75bf37a3f73aca1da97278d268a4c67
    {
        // $schedule->command('inspire')->hourly();
    }

    /**
     * Register the commands for the application.
<<<<<<< HEAD
     *
     * @return void
     */
    protected function commands()
=======
     */
    protected function commands(): void
>>>>>>> df8fd1e0a75bf37a3f73aca1da97278d268a4c67
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
