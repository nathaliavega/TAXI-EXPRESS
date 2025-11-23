<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class AppServiceProvider extends ServiceProvider
{
    
    public const HOME = '/dashboard';

    public function register(): void
    {
    
    }

    public function boot(): void
    {
        
        $this->configureRedirects();
    }

   
    protected function configureRedirects(): void
    {
        
    }
}