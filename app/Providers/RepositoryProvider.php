<?php

namespace App\Providers;

use App\Repositories\MySQL\BaseRepository;
use App\Repositories\MySQL\IBaseRepository;
use App\Repositories\MySQL\ProductRepository\InterfaceProductRepository;
use App\Repositories\MySQL\ProductRepository\ProductRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(IBaseRepository::class, BaseRepository::class,);
        $this->app->bind(InterfaceProductRepository::class, ProductRepository::class,);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
