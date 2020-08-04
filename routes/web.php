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
Auth::routes();

Route::get('/', 'HomeController@index')->name('home');
Route::get('/home', 'HomeController@index')->name('home');

Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::get('/', 'HomeController@index')->name('home');
    Route::get('/home', 'HomeController@index')->name('home');
});

/**
 * END CONFIGURAÇÃO DA CONTA
 * ==========================================================================================================================================
 */


Route::group(['middleware' => ['auth']], function () {

    Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {

        //Usuários
        Route::get('/usuarios', 'UsuarioController@index')->name('usuarios');
        Route::get('/usuarios/create', 'UsuarioController@create')->name('usuarios.create');
        Route::post('/usuarios/store', 'UsuarioController@store')->name('usuarios.store');
        Route::delete('/usuarios/{usuario}/destroy', 'UsuarioController@destroy')->name('usuarios.destroy');
        Route::get('/usuarios/{usuario}/edit', 'UsuarioController@edit')->name('usuarios.edit');
        Route::put('/usuarios/update', 'UsuarioController@update')->name('usuarios.update');
        Route::get('/usuarios/{usuario}/btnactive', 'UsuarioController@btnactive')->name('usuarios.btnactive');


        //Perfil
        Route::get('/usuario/perfil', 'ProfileController@index')->name('usuario.perfil');
        Route::put('/usuario/perfil/update/{id}', 'ProfileController@update')->name('usuario.perfil.update');


        //Alterar Senha
        Route::get('/usuario/alterar-senha', 'ChangePassController@index')->name('usuario.alterar-senha');
        Route::post('/usuario/alterar-senha/change', 'ChangePassController@changePassword')->name('usuario.alterar-senha.change');


        // Clientes
        Route::get('/clientes', 'ClienteController@index')->name('teste.cliente');
        Route::get('/cliente/create', 'ClienteController@create')->name('teste.cliente.create');
        Route::get('/cliente/show/{id}', 'ClienteController@show')->name('teste.cliente.show');

    });

});


// CLEAR CACHE
Route::get('/clear', function () {

    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('config:cache');
    Artisan::call('view:clear');

    return "Cleared!";

})->name('clear');



