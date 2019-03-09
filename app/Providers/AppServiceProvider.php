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
        $roles;
        switch (auth()->user()->roles()->first()->name) {
            case 'super_admin':
                $roles =  \App\Role::all();
                break;

            case 'registrar':
                $roles =  \App\Role::where('name', 'normal')->get();
                break;

            default:
                $roles = \App\Role::whereNotIn('name', ['super_admin'])->get();
                break;
        }
        return $roles;
    }

    protected function getLevels() {
        switch (auth()->user()->roles()->first()->name) {
            case 'super_admin':
                // return \App\Level::all();
                break;

            case 'registrar':
                // return \App\Level::where('name', 'church_pastor')->first();
                break;

            default:
                // return \App\Level::whereNotIn('name', ['all'])->get();
                break;
        }
    }

    protected function registerViewComposers() {
        \View::composer('components.options.roles', function ($view) {
            // dont cache this cause query will change depending on user role
            $view->with('roles', $this->getRoles());
        });

        // \View::composer('components.options.levels', function ($view) {
        //     // dont cache this cause query will change depending on user role
        //     $view->with('levels', $this->getLevels());
        // });

        \View::composer('components.options.churches', function ($view) {
            $churches = \Cache::rememberForEver('churches', function() {
                return \App\Church::all();
            });
            $view->with('churches', $churches);
        });

        \View::composer('components.options.permissions', function ($view) {
            $permissions = \Cache::rememberForEver('permissions', function() {
                return \App\Permission::all();
            });
            $view->with('permissions', $permissions);
        });
    }
}
