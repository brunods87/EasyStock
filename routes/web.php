<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home.index');

//JOBS
Route::get('/jobs', 'JobController@index')->name('jobs.index');
Route::get('/jobs/create', 'JobController@create')->name('jobs.create');
Route::post('/jobs/create', 'JobController@store');
Route::get('/jobs/update/{id}', 'JobController@edit')->name('jobs.update');
Route::post('jobs/update/{id}', 'JobController@update');
Route::post('/jobs', 'JobController@destroy');

//MATERIALS
Route::get('/materials', 'MaterialController@index')->name('materials.index');
Route::get('/materials/create', 'MaterialController@create')->name('materials.create');
Route::post('/materials/create', 'MaterialController@store');
Route::get('/materials/update', 'MaterialController@edit')->name('jobs.update');
Route::post('/materials/update/{id}', 'MaterialController@update');
Route::post('/materials', 'MaterialController@destroy');

//EMPLOYEES
Route::get('/employees', 'EmployeeController@index')->name('employees.index');
Route::get('/employees/create', 'EmployeeController@create')->name('employees.create');
Route::post('/employees/create', 'EmployeeController@store');
Route::get('/employees/update/{id}', 'EmployeeController@edit')->name('employees.update');
Route::post('/employees/update/{id}', 'EmployeeController@update');
Route::post('/employees', 'EmployeeController@destroy');

//INVOICES
Route::get('/invoices', 'InvoiceController@index')->name('invoices.index');
Route::get('/invoices/create', 'InvoiceController@create')->name('invoices.create');
Route::post('/invoices/create', 'InvoiceController@store');
Route::get('/invoices/update/{id}', 'InvoiceController@edit')->name('invoices.update');
Route::post('/invoices/update/{id}', 'InvoiceController@update');
Route::post('/invoices', 'InvoiceController@destroy');

//SUPPLIERS
Route::get('/suppliers', 'SupplierController@index')->name('suppliers.index');
Route::get('/suppliers/create', 'SupplierController@create')->name('suppliers.create');
Route::post('/suppliers/create', 'SupplierController@store');
Route::get('/suppliers/update/{id}', 'SupplierController@edit')->name('suppliers.update');
Route::post('/suppliers/update/{id}', 'SupplierController@update');
Route::post('/suppliers', 'SupplierController@destroy');

//CLIENTS
Route::get('/clients', 'ClientController@index')->name('clients.index');
Route::get('/clients/create', 'ClientController@create')->name('clients.create');
Route::post('/clients/create', 'ClientController@store');
Route::get('/clients/update/{id}', 'ClientController@edit')->name('clients.update');
Route::post('/clients/update/{id}', 'ClientController@update');
Route::post('/clients', 'ClientController@destroy');