<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\UserRepositoryInterface;
use App\Repositories\UserRepository as UserRepository;
use App\Interfaces\HeadOfFamilyRepositoryInterface;
use App\Repositories\HeadOfFamilyRepository as HeadOfFamilyRepository;
use App\Interfaces\FamilyMemberRepositoryInterface;
use App\Repositories\FamilyMemberRepository as FamilyMemberRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            UserRepositoryInterface::class,
            UserRepository::class
        );
        $this->app->bind(
           HeadOfFamilyRepositoryInterface::class,
           HeadOfFamilyRepository::class
        );

        $this->app->bind(
           FamilyMemberRepositoryInterface::class,
           FamilyMemberRepository::class
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
