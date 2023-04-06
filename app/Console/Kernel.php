<?php

namespace App\Console;

use App\Console\Commands\InactiveClientCommand;
use App\Jobs\OrdersAssignJob;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected $commands = [
        InactiveClientCommand::class,
        'App\Console\Commands\InactiveClientCommand',
    ];

    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();
        $schedule->job(new OrdersAssignJob)->everyMinute();
        $schedule->command('email:inactive-client-command')
            ->daily()
            ->evenInMaintenanceMode()
            ->runInBackground();

            
    }


    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
