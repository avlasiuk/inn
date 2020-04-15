<?php

namespace App\Providers;

use App\Services\FnsService;
use Illuminate\Support\ServiceProvider;

class FnsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $fnsService = new FnsService();

        $this->app->instance('App\Services\FnsService', $fnsService);
    }
}
