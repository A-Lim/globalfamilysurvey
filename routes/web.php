<?php
// Homepage
Route::get('/', function () { return redirect('login'); });

// Authentication Routes
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');


// Registration
Route::get('register', 'Auth\RegisterController@index')->name('register');
Route::get('register/church', 'Auth\RegisterController@church_registration');
Route::get('register/network', 'Auth\RegisterController@network_registration');
Route::post('register/church', 'Auth\RegisterController@church_register');
Route::post('register/network', 'Auth\RegisterController@network_register');

// Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');

// Dashboard
Route::get('dashboard', 'DashboardController@index')->name('dashboard');
Route::get('dashboard/members-report', 'DashboardController@members_report');

// Roles
Route::get('roles/datatable', 'RolesController@datatable');
Route::resource('roles', 'RolesController')->except(['show']);

// Settings
Route::get('settings', 'SettingsController@index');
Route::get('settings/dashboard', 'SettingsController@dashboard');
Route::get('settings/jobs', 'SettingsController@jobs');
Route::patch('settings', 'SettingsController@update');

// Users
// https://laracasts.com/discuss/channels/laravel/laravel-policy-on-user-model?page=1
Route::get('users/datatable', 'UsersController@datatable');
Route::get('profile', 'UsersController@profile');
Route::resource('users', 'UsersController')->except(['show']);

// Surveys
Route::get('surveys', 'SurveysController@index');
Route::get('surveys/create', 'SurveysController@create');
Route::post('surveys/retrieve', 'SurveysController@retrieve');
Route::post('surveys/{survey}/refresh', 'SurveysController@save');
Route::post('surveys', 'SurveysController@save');

Route::get('surveys/{survey}', 'SurveysController@show');
Route::delete('surveys/{survey}', 'SurveysController@destroy');

// Questions
Route::get('questions/{question}/data', 'QuestionsController@data');
Route::get('questions/datatable', 'QuestionsController@datatable');
Route::get('questions', 'QuestionsController@index');
Route::get('questions/{question}', 'QuestionsController@show');
Route::delete('questions/{question}', 'QuestionsController@destroy');

// Churches
Route::get('churches/datatable', 'ChurchesController@datatable');
Route::resource('churches', 'ChurchesController')->except(['show']);

// Reports
Route::get('reports/data', 'ReportsController@grouped_data');
Route::get('reports/{report}/data', 'ReportsController@data');
Route::resource('reports', 'ReportsController')->except(['show']);


// Categories
Route::resource('categories', 'CategoriesController')->except(['show']);

// Webhook
Route::resource('webhooks', 'WebhooksController');

// Submissions
Route::post('submissions/pull', 'SubmissionsController@pull');
Route::get('submissions/test', 'SubmissionsController@test');

// Request Log
Route::get('requestlogs/stats', 'RequestLogsController@stats');
Route::get('requestlogs/datatable', 'RequestLogsController@datatable');
Route::get('requestlogs/{requestLog}', 'RequestLogsController@show');

// Audit
Route::get('audits', 'AuditsController@index');
Route::get('audits/datatable', 'AuditsController@datatable');
Route::get('audits/{audit}', 'AuditsController@show');
