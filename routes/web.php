<?php

Route::get('/', 'TasksController@index')->name('home');

// auth routes
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');

// API routes with session auth
Route::group(['prefix' => 'api/v1', 'namespace' => 'Api\V1'], function () {
    Route::post('/tasks', 'TasksController@store')->name('api.v1.tasks.store');
    Route::get('/get-tasks-list', 'TasksController@list')->name('api.v1.tasks.list');
    Route::delete('/tasks/{task}', 'TasksController@destroy')->name('api.v1.tasks.destroy');
    Route::get('/tasks/{task}', 'TasksController@show')->name('api.v1.tasks.show');
    Route::put('/tasks/{task}', 'TasksController@update')->name('api.v1.tasks.update');
    Route::put('/tasks/{task}/toggle-status', 'TasksController@toggleStatus')->name('api.v1.tasks.toggleStatus');
});
