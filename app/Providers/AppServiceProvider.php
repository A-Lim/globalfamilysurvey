<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        $this->registerViewComposers();
        Validator::extend('recaptcha', 'App\\Validators\\ReCaptcha@validate');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->isLocal()) {
            $this->app->register(\Barryvdh\Debugbar\ServiceProvider::class);
        }
    }

    protected function getRoles() {
        $roles = null;
        switch (auth()->user()->roles()->first()->name) {
            case 'super_admin':
                $roles =  \App\Role::all();
                break;

            default:
                $roles = \App\Role::whereNotIn('name', ['super_admin'])->get();
                break;
        }
        return $roles;
    }

    protected function registerViewComposers() {
        \View::composer('components.options.roles', function ($view) {
            // dont cache this cause query will change depending on user role
            $view->with('roles', $this->getRoles());
        });

        \View::composer('components.options.churches', function ($view) {
            $churchRepository = resolve(\App\Repositories\ChurchRepositoryInterface::class);
            $churches = $churchRepository->all();
            $view->with('churches', $churches);
        });

        \View::composer('components.options.permissions', function ($view) {
            $permissionRepository = resolve(\App\Repositories\PermissionRepositoryInterface::class);
            $permissions = $permissionRepository->all();
            $view->with('permissions', $permissions);
        });
    }
}
