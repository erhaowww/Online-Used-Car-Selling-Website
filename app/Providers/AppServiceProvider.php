<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\Interfaces\ReviewRepositoryInterface;
use App\Repositories\UserRepository;
use App\Repositories\ReviewRepository;
use App\Repositories\Interfaces\VisitorRepositoryInterface;
use App\Repositories\VisitorRepository;

use App\Models\User;



class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(ReviewRepositoryInterface::class, ReviewRepository::class);
        $this->app->bind(VisitorRepositoryInterface::class, VisitorRepository::class);

    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {

    }
    
}
