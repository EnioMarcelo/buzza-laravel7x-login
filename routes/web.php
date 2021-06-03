<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
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


Route::get('/', 'HomeController@index')->name('home');
Route::get('/home', 'HomeController@index')->name('home');

Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::get('/', 'HomeController@index')->name('home');
    Route::get('/home', 'HomeController@index')->name('home');
});


Auth::routes();

/**
 * END CONFIGURAÇÃO DA CONTA
 * ==========================================================================================================================================
 */


Route::group(['middleware' => ['auth']], function () {

    // Clientes
    Route::group(['prefix' => 'clientes', 'as' => 'clientes.', 'middleware' => ['permission:Super Administrator|Clientes - ALL|Clientes - ADD|Clientes - EDIT|Clientes - DEL|Clientes - SEARCH']], function () {
        Route::get('/', 'ClienteController@index')->name('cliente');
        Route::get('/create', 'ClienteController@create')->name('cliente.create');
        Route::get('/{id}/show', 'ClienteController@show')->name('cliente.show');
        Route::get('/{cliente}/edit', 'ClienteController@edit')->name('cliente.edit');
        Route::put('/update', 'ClienteController@update')->name('cliente.update');
        Route::delete('/{cliente}/destroy', 'ClienteController@destroy')->name('cliente.destroy');
    });


    //Usuários
    Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['role:Super Administrator']], function () {

        Route::get('/usuario', 'UsuarioController@index')->name('usuario');
        Route::get('/usuario/create', 'UsuarioController@create')->name('usuario.create');
        Route::post('/usuario/store', 'UsuarioController@store')->name('usuario.store');
        Route::delete('/usuario/{usuario}/destroy', 'UsuarioController@destroy')->name('usuario.destroy');
        Route::get('/usuario/{usuario}/edit', 'UsuarioController@edit')->name('usuario.edit');
        Route::put('/usuario/update', 'UsuarioController@update')->name('usuario.update');
        Route::get('/usuario/{usuario}/btnactive', 'UsuarioController@btnactive')->name('usuario.btnactive');

        Route::get('/usuario/{usuario}/role', 'UsuarioController@role')->name('usuario.role');
        Route::put('/usuario/role/sync', 'UsuarioController@roleSync')->name('usuario.roleSync');


        //Perfil
        Route::get('/usuario/perfil', 'ProfileController@index')->name('usuario.perfil');
        Route::put('/usuario/perfil/update/{id}', 'ProfileController@update')->name('usuario.perfil.update');


        //Alterar Senha
        Route::get('/usuario/alterar-senha', 'ChangePassController@index')->name('usuario.alterar-senha');
        Route::post('/usuario/alterar-senha/change', 'ChangePassController@changePassword')->name('usuario.alterar-senha.change');


        // role
        Route::get('/role', 'RoleController@index')->name('role');
        Route::get('/role/{role}/edit', 'RoleController@edit')->name('role.edit');
        Route::get('/role/create', 'RoleController@create')->name('role.create');
        Route::post('/role/store', 'RoleController@store')->name('role.store');
        Route::put('/role/update', 'RoleController@update')->name('role.update');
        Route::delete('/role/{role}/destroy', 'RoleController@destroy')->name('role.destroy');

        Route::get('/role/{role}/permission', 'RoleController@permission')->name('role.permission');
        Route::put('/role/permission/sync', 'RoleController@permissionSync')->name('role.permissionSync');


        // Permission
        Route::get('/permission', 'PermissionController@index')->name('permission');
        Route::get('/permission/{permission}/edit', 'PermissionController@edit')->name('permission.edit');
        Route::get('/permission/create', 'PermissionController@create')->name('permission.create');
        Route::post('/permission/store', 'PermissionController@store')->name('permission.store');
        Route::put('/permission/update', 'PermissionController@update')->name('permission.update');
        Route::delete('/permission/{permission}/destroy', 'PermissionController@destroy')->name('permission.destroy');
    });

    Route::group(['prefix' => 'usuario', 'as' => 'usuario.'], function () {

        //Perfil
        Route::get('/perfil', 'ProfileController@index')->name('perfil');
        Route::put('/perfil/update/{id}', 'ProfileController@update')->name('perfil.update');


        //Alterar Senha
        Route::get('/alterar-senha', 'ChangePassController@index')->name('alterar-senha');
        Route::post('/alterar-senha/change', 'ChangePassController@changePassword')->name('alterar-senha.change');
    });
});


// CLEAR CACHE
Route::get('/clear', function () {

    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('config:cache');
    Artisan::call('view:clear');
    Artisan::call('permission:cache-reset');


    return "Cleared!";
})->name('clear');
