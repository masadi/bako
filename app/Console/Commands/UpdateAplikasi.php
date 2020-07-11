<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Transaksi;
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
        //system('composer update');
        \Artisan::call('migrate');
        \Artisan::call('view:clear');
        \Artisan::call('config:cache');
        $transaksi = Transaksi::select('tanggal', 'bagian_id')->groupBy('tanggal')->groupBy('bagian_id')->orderBy('tanggal')->orderBy('nomor')->get();
        $i=1;
        foreach($transaksi as $trx){
            if(!$trx->nomor_atas){
                $trx->where('tanggal', $trx->tanggal)->where('bagian_id', $trx->bagian_id)->update(['nomor_atas' => $i]);
                $i++;
            }
        }
        $this->info('Berhasil memperbaharui aplikasi');
    }
}
