<?php

namespace App\Console;

use App\Console\Commands\AddMonthlyBill;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected $commands = [
        AddMonthlyBill::class, // Daftarkan command di sini
    ];
    
    protected function schedule(Schedule $schedule)
    {
        // Menjadwalkan command agar berjalan setiap bulan pada tanggal 1
        $schedule->command('add:monthly-bill')->monthlyOn(1, '08:00');
    }


    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
