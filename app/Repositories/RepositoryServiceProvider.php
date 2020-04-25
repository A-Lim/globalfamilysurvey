<?php
namespace App\Repositories;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register() {
        $this->app->bind('App\Repositories\AuthRepositoryInterface', 'App\Repositories\AuthRepository');
        $this->app->bind('App\Repositories\SettingsRepositoryInterface', 'App\Repositories\SettingsRepository');
        $this->app->bind('App\Repositories\ChurchRepositoryInterface', 'App\Repositories\ChurchRepository');
        $this->app->bind('App\Repositories\SurveyRepositoryInterface', 'App\Repositories\SurveyRepository');
        $this->app->bind('App\Repositories\UserRepositoryInterface', 'App\Repositories\UserRepository');
        $this->app->bind('App\Repositories\NetworkRepositoryInterface', 'App\Repositories\NetworkRepository');
        $this->app->bind('App\Repositories\CountryRepositoryInterface', 'App\Repositories\CountryRepository');
        $this->app->bind('App\Repositories\QuestionRepositoryInterface', 'App\Repositories\QuestionRepository');
        $this->app->bind('App\Repositories\ReportRepositoryInterface', 'App\Repositories\ReportRepository');
        $this->app->bind('App\Repositories\RoleRepositoryInterface', 'App\Repositories\RoleRepository');
        $this->app->bind('App\Repositories\PermissionRepositoryInterface', 'App\Repositories\PermissionRepository');
        $this->app->bind('App\Repositories\CategoryRepositoryInterface', 'App\Repositories\CategoryRepository');
        $this->app->bind('App\Repositories\SubmissionRepositoryInterface', 'App\Repositories\SubmissionRepository');
        $this->app->bind('App\Repositories\RequestLogRepositoryInterface', 'App\Repositories\RequestLogRepository');
        $this->app->bind('App\Repositories\AuditRepositoryInterface', 'App\Repositories\AuditRepository');
    }
}
