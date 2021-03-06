<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\BookService;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Book
        $this->app->bind(
            \App\Repositories\Book\BookRepositoryInterface::class,
            \App\Repositories\Book\BookRepository::class
        );

        // User
        $this->app->bind(
            \App\Repositories\User\UserRepositoryInterface::class,
            \App\Repositories\User\UserRepository::class
        );

        $this->app->bind('BookService', BookService::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (request()->isSecure()) {
            \URL::forceScheme('https');
        }

        Schema::defaultStringLength(191);
    }
}
