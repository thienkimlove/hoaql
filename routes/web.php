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

Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');
Route::get('login', 'BasicController@redirectToSSO')->name('login');
Route::get('logout', ['uses' => 'BasicController@logout', 'as' => 'logout']);
Route::get('callback', 'BasicController@handleSSOCallback')->name('callback');
Route::get('notice', 'BasicController@notice')->name('notice');

Route::group(['middleware' => 'acl'], function() {

    Route::get('/admin', 'BasicController@index')->name('index');
    Route::post('ajax', 'BasicController@ajax')->name('ajax');
    // User & Roles
    Route::get('users.dataTables', ['uses' => 'UsersController@dataTables', 'as' => 'users.dataTables']);
    Route::resource('users', 'UsersController');

    Route::get('users/{id}/permissions', ['uses' => 'UserPermissionsController@index', 'as' => 'userPermissions.index']);
    Route::put('users/{id}/permissions', ['uses' => 'UserPermissionsController@update', 'as' => 'userPermissions.update']);

    Route::get('roles/dataTables', ['uses' => 'RolesController@dataTables', 'as' => 'roles.dataTables']);
    Route::resource('roles', 'RolesController');
    Route::get('roles/{id}/permissions', ['uses' => 'RolePermissionsController@index', 'as' => 'rolePermissions.index']);
    Route::put('roles/{id}/permissions', ['uses' => 'RolePermissionsController@update', 'as' => 'rolePermissions.update']);
    Route::resource('permissions', 'PermissionsController', ['only' => ['index']]);


    Route::post('modules.add', ['uses' => 'ModulesController@add', 'as' => 'modules.add']);
    Route::post('modules.remove', ['uses' => 'ModulesController@remove', 'as' => 'modules.remove']);



    Route::get('settings.dataTables', ['uses' => 'SettingsController@dataTables', 'as' => 'settings.dataTables']);
    Route::resource('settings', 'SettingsController');

    Route::get('customers.dataTables', ['uses' => 'CustomersController@dataTables', 'as' => 'customers.dataTables']);
    Route::resource('customers', 'CustomersController');

    Route::get('rules.dataTables', ['uses' => 'RulesController@dataTables', 'as' => 'rules.dataTables']);
    Route::resource('rules', 'RulesController');

    Route::get('payments.dataTables', ['uses' => 'PaymentsController@dataTables', 'as' => 'payments.dataTables']);
    Route::resource('payments', 'PaymentsController');


    Route::get('orders.dataTables', ['uses' => 'OrdersController@dataTables', 'as' => 'orders.dataTables']);

    Route::get('orders.delivery/{id}', ['uses' => 'OrdersController@delivery', 'as' => 'orders.delivery']);

    Route::get('orders.complete/{id}', ['uses' => 'OrdersController@complete', 'as' => 'orders.complete']);

    Route::get('orders.return/{id}', ['uses' => 'OrdersController@return', 'as' => 'orders.return']);

    Route::get('orders.cancel/{id}', ['uses' => 'OrdersController@cancel', 'as' => 'orders.cancel']);

    Route::get('orders/export', 'OrdersController@export')->name('orders.export');

    Route::resource('orders', 'OrdersController');

});


#frontend

Route::get('/', 'FrontendController@index')->name('frontend.index');


# if other website is different we need add more function and routes.
