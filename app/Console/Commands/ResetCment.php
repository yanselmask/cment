<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class ResetCment extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cment:reset';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset all configurations';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Artisan::call('migrate:rollback');
        unlink(storage_path('installed'));
    }
}
