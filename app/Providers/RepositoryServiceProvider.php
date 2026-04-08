<?php

namespace App\Providers;

use App\Interfaces\FamilyMemberRepositoryInterface;
use App\Interfaces\HeadOfFamilyRepositoryInterface;
use App\Interfaces\SocialAssistanceRecipentRepositoryInterface;
use App\Interfaces\SocialAssistanceRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use App\Repositories\FamilyMemberRepository;
use App\Repositories\HeadOfFamilyRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;
use App\Repositories\SocialAssistanceRepository;
use App\Repositories\SocialAssistanceRecipentRepository;
class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(HeadOfFamilyRepositoryInterface::class, HeadOfFamilyRepository::class);
        $this->app->bind(FamilyMemberRepositoryInterface::class, FamilyMemberRepository::class);
        $this->app->bind(SocialAssistanceRepositoryInterface::class, SocialAssistanceRepository::class);
        $this->app->bind(SocialAssistanceRecipentRepositoryInterface::class, SocialAssistanceRecipentRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
