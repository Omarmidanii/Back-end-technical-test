<?php

namespace App\Providers;

use App\Http\Interfaces\AuthRepositoryInterface;
use App\Http\Interfaces\BaseRepositoryInterface;
use App\Http\Interfaces\OrderRepositoryInterface;
use App\Http\Interfaces\ProductRepositoryInterface;
use App\Http\Repositories\AuthRepository;
use App\Http\Repositories\BaseRepository;
use App\Http\Repositories\OrderRepository;
use App\Http\Repositories\ProductRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(BaseRepositoryInterface::class, BaseRepository::class);
        $this->app->bind(AuthRepositoryInterface::class, AuthRepository::class);
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
        $this->app->bind(OrderRepositoryInterface::class, OrderRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
