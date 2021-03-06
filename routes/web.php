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

Route::group( ['middleware' => 'auth' ], function()
{

	//JOBS
	Route::get('/jobs', 'JobController@index')->name('jobs.index');
	Route::get('/jobs/create', 'JobController@create')->name('jobs.create');
	Route::post('/jobs/create', 'JobController@store');
	Route::get('/jobs/update/{id}', 'JobController@edit')->name('jobs.update');
	Route::post('jobs/update/{id}', 'JobController@update');
	Route::get('/jobs/view/{id}', 'JobController@view')->name('jobs.view');
	Route::post('/jobs', 'JobController@destroy');
		Route::post('/jobItems/store', 'JobController@storeItems')->name('jobs.storeItems');
		Route::post('/jobs/getJobs', 'JobController@getJobs')->name('jobs.getJobs');
		Route::post('/jobExpenses/destroy', 'JobExpenseController@destroy')->name('jobExpense.destroy');
		Route::post('/jobProfits/destroy', 'JobProfitController@destroy')->name('jobProfit.destroy');
		Route::get('/jobs/exportPdf/{id}', 'JobController@exportPdf')->name('jobs.exportPdf');
		Route::get('/jobs/exportExcel/{id}', 'JobController@exportExcel')->name('jobs.exportExcel');

	//MATERIALS
	Route::get('/materials', 'MaterialController@index')->name('materials.index');
	Route::get('/materials/create', 'MaterialController@create')->name('materials.create');
	Route::post('/materials/create', 'MaterialController@store');
	Route::get('/materials/update/{id}', 'MaterialController@edit')->name('materials.update');
	Route::post('/materials/update/{id}', 'MaterialController@update');
	Route::post('/materials', 'MaterialController@destroy');
	Route::get('/materials/insert', 'MaterialController@insert')->name('materials.insert');
	Route::get('/materials/insertInJob/{job_id}', 'MaterialController@insertInJob')->name('materials.insertInJob');
	Route::post('/materials/getDiscount', 'MaterialController@getDiscount')->name('materials.discount');
	Route::get('/materials/exportPdf', 'MaterialController@exportPdf')->name('materials.exportPdf');
	Route::get('/materials/exportExcel', 'MaterialController@exportExcel')->name('materials.exportExcel');
	Route::get('/materials/exportMaterial/{id}', 'MaterialController@exportMaterial')->name('materials.exportMaterial');

		//CATEGORIES
		Route::get('/categories', 'CategoryController@index')->name('categories.index');
		Route::get('/categories/create', 'CategoryController@create')->name('categories.create');
		Route::post('/categories/create', 'CategoryController@store');
		Route::get('/categories/update/{id}', 'CategoryController@edit')->name('categories.update');
		Route::post('/categories/update/{id}', 'CategoryController@update');
		Route::post('/categories', 'CategoryController@destroy');
		//TYPES
		Route::get('/types', 'TypeController@index')->name('types.index');
		Route::get('/types/create', 'TypeController@create')->name('types.create');
		Route::post('/types/create', 'TypeController@store');
		Route::get('/types/update/{id}', 'TypeController@edit')->name('types.update');
		Route::post('/types/update/{id}', 'TypeController@update');
		Route::post('/types', 'TypeController@destroy');
		//UNITIES
		Route::get('/unities', 'UnityController@index')->name('unities.index');
		Route::get('/unities/create', 'UnityController@create')->name('unities.create');
		Route::post('/unities/create', 'UnityController@store');
		Route::get('/unities/update{id}', 'UnityController@edit')->name('unities.update');
		Route::post('/unities/update/{id}', 'UnityController@update');
		Route::post('/unities', 'UnityController@destroy');

	//EMPLOYEES
	Route::get('/employees', 'EmployeeController@index')->name('employees.index');
	Route::get('/employees/create', 'EmployeeController@create')->name('employees.create');
	Route::post('/employees/create', 'EmployeeController@store');
	Route::get('/employees/update/{id}', 'EmployeeController@edit')->name('employees.update');
	Route::post('/employees/update/{id}', 'EmployeeController@update');
	Route::post('/employees', 'EmployeeController@destroy');
	Route::get('/employees/insert', 'EmployeeController@insert')->name('employees.insert');

	//INVOICES
	Route::get('/invoices', 'InvoiceController@index')->name('invoices.index');
	Route::get('/invoices/create', 'InvoiceController@create')->name('invoices.create');
	Route::post('/invoices/create', 'InvoiceController@store');
	Route::get('/invoices/update/{id}', 'InvoiceController@edit')->name('invoices.update');
	Route::post('/invoices/update/{id}', 'InvoiceController@update');
	Route::get('/invoices/view/{id}', 'InvoiceController@view')->name('invoices.view');
	Route::post('/invoices', 'InvoiceController@destroy');
	Route::get('/invoices/exportPdf/{id}', 'InvoiceController@exportPdf')->name('invoices.exportPdf');
	Route::get('/invoices/exportExcel/{id}', 'InvoiceController@exportExcel')->name('invoices.exportExcel');

		//INVOICE_ITEMS
		Route::post('/invoiceItems/store', 'InvoiceItemController@store')->name('invoiceItem.store');
		Route::post('/invoiceItems/destroy', 'InvoiceItemController@destroy')->name('invoiceItem.destroy');

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

	//SETTINGS
	Route::get('/settings', 'SettingController@index')->name('settings.index');
	Route::post('/settings', 'SettingController@update');

});