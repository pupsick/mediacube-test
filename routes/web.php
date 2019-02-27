<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::post('fetchData', 'CoreController@fetchData');

Route::prefix("departments")->namespace("Departments")->group(function() {
    Route::post('add', 'DepartmentController@addAction');
    Route::post('edit', 'DepartmentController@editAction');
    Route::post('delete', 'DepartmentController@delete');
});

Route::prefix("employees")->namespace("Employees")->group(function() {
    Route::post('add', 'EmployeeController@addAction');
    Route::post('edit', 'EmployeeController@editAction');
    Route::post('delete', 'EmployeeController@delete');
    Route::get('page/{id}', 'EmployeeController@loadEmployees');
});

Route::get('/table/page/{id}', 'CoreController@loadEmployees');

Route::get('{any}', function () {
    return view('index');
})->where('any', '^.*');