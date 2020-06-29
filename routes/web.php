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

//MATERIALS
Route::get('/materials', 'MaterialController@index')->name('materials.index');
Route::get('/materials/create', 'MaterialController@create')->name('materials.create');

//EMPLOYEES
Route::get('/employees', 'EmployeeController@index')->name('employees.index');

//INVOICES
Route::get('/invoices', 'InvoiceController@index')->name('invoices.index');

//SUPPLIERS
Route::get('/suppliers', 'SupplierController@index')->name('suppliers.index');

//CLIENTS
Route::get('/clients', 'ClientController@index')->name('clients.index');