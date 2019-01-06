<?php
// Homepage
Route::get('/', function () {
    return view('welcome');
});

// Authentication Routes
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

// Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');

// Dashboard
Route::get('dashboard', 'DashboardController@index')->name('dashboard');
Route::get('dashboard/members-report', 'DashboardController@members_report');

// Settings
// Route::get('settings', 'SettingsController@index');

// Roles
// Route::get('roles', 'RolesController@index');
// Route::get('roles/create', 'RolesController@create');
// Route::post('roles/', 'RolesController@store');
// Route::get('roles/{role}', 'RolesController@edit');
// Route::patch('roles/{role}', 'RolesController@update');
// Route::delete('roles/{role}', 'RolesController@destroy');
Route::get('roles/datatable', 'RolesController@datatable');
Route::resource('roles', 'RolesController')->except(['show']);

// Settings
// Route::resource('settings', 'SettingsController')->except(['show']);
Route::get('settings', 'SettingsController@index');
Route::patch('settings', 'SettingsController@update');

// Users
// https://laracasts.com/discuss/channels/laravel/laravel-policy-on-user-model?page=1
Route::get('users/datatable', 'UsersController@datatable');
Route::resource('users', 'UsersController')->except(['show']);
// Route::get('users', 'UsersController@index');
// Route::get('users/create', 'UsersController@create');
// Route::post('users/', 'UsersController@store');
// Route::get('users/{user}/edit', 'UsersController@edit')
//     ->middleware('can:update,user');
// Route::patch('users/{user}', 'UsersController@update')
//     ->middleware('can:update,user');
// Route::delete('users/{user}', 'UsersController@destroy')
//     ->middleware('can:delete,user');

// Surveys
Route::get('surveys', 'SurveysController@index');
Route::get('surveys/{survey}', 'SurveysController@show');
Route::delete('surveys/{survey}', 'SurveysController@destroy');

// Questions
Route::get('questions/datatable', 'QuestionsController@datatable');
Route::get('questions', 'QuestionsController@index');
Route::get('questions/{question}', 'QuestionsController@show');
Route::delete('questions/{question}', 'QuestionsController@destroy');

// Churches
Route::get('churches/datatable', 'ChurchesController@datatable');
Route::resource('churches', 'ChurchesController')->except(['show']);

// Reports
Route::resource('reports', 'ReportsController')->except(['show']);

// Categories
Route::resource('categories', 'CategoriesController')->except(['show']);

// Api
Route::post('api/leaders', 'ApiController@leaders');
Route::post('api/members', 'ApiController@members');
Route::post('api/test', 'ApiController@registrations');

// Route::get('results/leaders', 'ResultsController@leaders');
Route::get('results/members', 'ResultsController@members');
