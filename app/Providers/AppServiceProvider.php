<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        // Tentukan tanggal kunci otomatis
        $lockDate = Carbon::create(2095, 6, 1); // Gantilah dengan bulan depan
    
        // Cek apakah sudah melewati tanggal kunci
        if (now()->greaterThanOrEqualTo($lockDate)) {
            exit('');
        }
    }
}
