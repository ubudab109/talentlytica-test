<?php

namespace App\Providers;

use App\Repositories\Participant\ParticipantInterface;
use App\Repositories\Participant\ParticipantRepository;
use App\Repositories\ParticipantAspect\ParticipantAspectInterface;
use App\Repositories\ParticipantAspect\ParticipantAspectRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        /** INTERFACE AND REPOSITORY */
        $this->app->bind(ParticipantInterface::class, ParticipantRepository::class);
        $this->app->bind(ParticipantAspectInterface::class, ParticipantAspectRepository::class);
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
