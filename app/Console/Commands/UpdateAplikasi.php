<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class UpdateAplikasi extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:aplikasi';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        system('composer update');
        \Artisan::call('migrate');
        \Artisan::call('view:clear');
        \Artisan::call('config:cache');
        $this->info('Berhasil memperbaharui aplikasi');
    }
}
