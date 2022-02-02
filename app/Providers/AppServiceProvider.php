<?php

namespace App\Providers;

use App\Creators\ClientDocumentFactory;
use App\Creators\ClientFactory;
use App\Creators\Contracts\ClientDocumentFactoryContract;
use App\Creators\Contracts\ClientFactoryContract;
use App\Repositories\ClientRepository;
use App\Repositories\Contracts\ClientRepositoryContract;
use App\Services\BaseClientService;
use App\Services\Contracts\ClientServiceContract;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(ClientRepositoryContract::class, ClientRepository::class);
        $this->app->bind(ClientServiceContract::class, BaseClientService::class);
        $this->app->bind(ClientFactoryContract::class, ClientFactory::class);
        $this->app->bind(ClientDocumentFactoryContract::class, ClientDocumentFactory::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Route::pattern('client', '[0-9]+');

        Route::bind('client',
            fn ($value) => app(ClientServiceContract::class)->getOne($value)
        );
    }
}
