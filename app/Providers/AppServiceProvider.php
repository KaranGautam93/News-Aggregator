<?php

namespace App\Providers;

use App\Transformers\GuardianTransformer;
use App\Transformers\NewsApiTransformer;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(NewsApiTransformer::class, NewsApiTransformer::class);
        $this->app->bind(GuardianTransformer::class, GuardianTransformer::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
