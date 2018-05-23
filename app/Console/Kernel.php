<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\UpdateBookVirtualPassport::class,
        Commands\CreateVirtualPassport::class,
        Commands\StoreTagByCategory::class,
        Commands\CompletionUserInfoRecord::class,
        Commands\ClearCollectionPdfBookBySourceTag::class,
        Commands\ClearBookNameDescriptionTag::class,
        Commands\UpdatePdfBookSize::class,
        Commands\DestorySmallBook::class,
        Commands\CountSmallBook::class,
        Commands\CorrectingBooktopMonth::class,
        Commands\CorrectingBooktopWeek::class,
        Commands\UpdateVirtualPassportName::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
