<?php

namespace App\Providers;

use App\Permission;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        \App\User::class => \App\Policies\UserPolicy::class,
        \App\Church::class => \App\Policies\ChurchPolicy::class,
        \App\Survey::class => \App\Policies\SurveyPolicy::class,
        \App\Question::class => \App\Policies\QuestionPolicy::class,
        \App\Role::class => \App\Policies\RolePolicy::class,
        \App\Report::class => \App\Policies\ReportPolicy::class,
        \App\Webhook::class => \App\Policies\WebhookPolicy::class,
        // share policy between report and category (cause they are basically linked to report)
        \App\Category::class => \App\Policies\ReportPolicy::class,
        \App\Setting::class => \App\Policies\SettingPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        foreach ($this->getPermissions() as $permission) {
            Gate::define($permission->name, function($user) use ($permission) {
                return $user->hasRole($permission->roles);
            });
        }
    }

    protected function getPermissions() {
        return Permission::with('roles')->get();
    }
}
