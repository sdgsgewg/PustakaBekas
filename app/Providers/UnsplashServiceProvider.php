<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Unsplash\HttpClient;

class UnsplashServiceProvider extends ServiceProvider
{
    public function register()
    {
        // No need for specific registration in this case
    }

    public function boot()
    {
        // Initialize the Unsplash client
        HttpClient::init([
            'applicationId' => env('UNSPLASH_ACCESS_KEY'),
            'secret' => env('UNSPLASH_SECRET_KEY'),
            'utmSource' => 'PustakaBekas', // Optional
        ]);
    }
}
