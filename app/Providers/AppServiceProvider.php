<?php

namespace App\Providers;

use App\Models\Priority;
use App\Models\Status;
use App\Models\Task;
use App\Models\User;
use App\Policies\PriorityPolicy;
use App\Policies\StatusPolicy;
use App\Policies\TaskPolicy;
use App\Policies\UserPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::policy(Status::class, StatusPolicy::class);
        Gate::policy(Priority::class, PriorityPolicy::class);
        Gate::policy(Task::class, TaskPolicy::class);
        Gate::policy(User::class, UserPolicy::class);
    }
}
