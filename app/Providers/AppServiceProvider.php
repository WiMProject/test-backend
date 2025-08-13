<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Artisan;

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
    public function boot(): void
    {
        // Auto migration untuk production (Railway)
        if (app()->environment('production')) {
            try {
                Artisan::call('migrate', ['--force' => true]);
                
                // Cek apakah tabel users_management kosong
                if (\App\Models\UserManagement::count() === 0) {
                    Artisan::call('db:seed', [
                        '--class' => 'UserManagementSeeder',
                        '--force' => true
                    ]);
                }
                
                Artisan::call('l5-swagger:generate');
            } catch (\Exception $e) {
                // Silent fail untuk avoid crash
            }
        }
    }
}
