<?php

namespace App\Providers;

use App\Repositories\Contracts\AnnouncementRepositoryInterface;
use App\Repositories\Contracts\CategoryRepositoryInterface;
use App\Repositories\Contracts\CompetitionRepositoryInterface;
use App\Repositories\Contracts\RegistrationRepositoryInterface;
use App\Repositories\Contracts\SettingRepositoryInterface;
use App\Repositories\EloquentAnnouncementRepository;
use App\Repositories\EloquentCategoryRepository;
use App\Repositories\EloquentCompetitionRepository;
use App\Repositories\EloquentRegistrationRepository;
use App\Repositories\EloquentSettingRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(CategoryRepositoryInterface::class, EloquentCategoryRepository::class);
        $this->app->bind(CompetitionRepositoryInterface::class, EloquentCompetitionRepository::class);
        $this->app->bind(RegistrationRepositoryInterface::class, EloquentRegistrationRepository::class);
        $this->app->bind(AnnouncementRepositoryInterface::class, EloquentAnnouncementRepository::class);
        $this->app->bind(SettingRepositoryInterface::class, EloquentSettingRepository::class);
    }
}
