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
$controller = 'App\Http\Controllers';

Route::get('/', "LoginController@index")->name('login');

Route::prefix('login')->group(function(){
    Route::get('/', "LoginController@index")->name('login');
    Route::post('/auth', "LoginController@auth")->name('login.auth');
    Route::get('/sair', "LoginController@logout")->name('login.logout');
    Route::get('/recover', "LoginController@recover")->name('login.recover');
    Route::post('/recover/do', "LoginController@recoverDo")->name('login.recover.do');
});

Route::prefix('dashboard')->group(function(){
    Route::get('/', "DashboardController@index")->name('dashboard.index');
});

Route::prefix('usuarios')->group(function(){
    Route::get('/',           'UserController@index'    )->name('usuarios.index');
    Route::get('perfil',      'UserController@profile'  )->name('usuarios.profile');
    Route::get('novo',        'UserController@create'   )->name('usuarios.create');
    Route::post('store',      'UserController@store'    )->name('usuarios.store');
    Route::get('edit/{user}', 'UserController@edit'     )->name('usuarios.edit');
    Route::put('edit/{user}', 'UserController@update'   )->name('usuarios.update');
    
    Route::put('perfil/{user}', 'UserController@upProfile')->name('usuarios.update.profile');

    Route::delete('destroy/{user}', 'UserController@destroy')->name('usuarios.destroy');
});

Route::prefix('clientes')->group(function(){
    Route::get('/',             'ClientController@index' )->name('clientes.index');
    Route::get('novo',          'ClientController@create')->name('clientes.create');
    Route::post('store',        'ClientController@store' )->name('clientes.store');
    Route::get('edit/{client}', 'ClientController@edit'  )->name('clientes.edit');
    Route::put('edit/{client}', 'ClientController@update')->name('clientes.update');

    Route::delete('destroy/{client}', 'ClientController@destroy')->name('clientes.destroy');
});

Route::prefix('empresas')->group(function(){
    Route::get('/',              'CompanyController@index' )->name('empresas.index');
    Route::get('novo',           'CompanyController@create')->name('empresas.create');
    Route::post('store',         'CompanyController@store' )->name('empresas.store');
    Route::get('edit/{company}', 'CompanyController@edit'  )->name('empresas.edit');
    Route::put('edit/{company}', 'CompanyController@update')->name('empresas.update');

    Route::delete('destroy/{company}', 'CompanyController@destroy')->name('empresas.destroy');
});

Route::prefix('produtos')->group(function(){
    Route::get('/',              'ProductController@index' )->name('produtos.index');
    Route::get('novo',           'ProductController@create')->name('produtos.create');
    Route::get('show',           'ProductController@show'  )->name('produtos.show');
    Route::post('store',         'ProductController@store' )->name('produtos.store');
    Route::get('edit/{product}', 'ProductController@edit'  )->name('produtos.edit');
    Route::put('edit/{product}', 'ProductController@update')->name('produtos.update');

    Route::delete('destroy/{product}', 'ProductController@destroy')->name('produtos.destroy');
});

Route::prefix('items')->group(function(){
    Route::get('/',           'ItemController@index' )->name('itens.index');
    Route::get('novo',        'ItemController@create')->name('itens.create');
    Route::get('show',        'ItemController@show'  )->name('itens.show');
    Route::post('store',      'ItemController@store' )->name('itens.store');
    Route::post('edit',        'ItemController@update')->name('itens.update');
    Route::post('edit/order',        'ItemController@order')->name('itens.order');
    Route::get('edit/{item}', 'ItemController@edit'  )->name('itens.edit');

    Route::post('destroy', 'ItemController@destroy')->name('itens.destroy');
});

Route::prefix('cotacoes')->group(function(){
    Route::get('/',              'QuoteController@index' )->name('cotacoes.index');
    Route::get('novo/{client}',  'QuoteController@create')->name('cotacoes.create');
    Route::post('store',         'QuoteController@store' )->name('cotacoes.store');
    Route::get('edit/{quote}',   'QuoteController@edit'  )->name('cotacoes.edit');
    Route::post('close/{quote}', 'QuoteController@close' )->name('cotacoes.close');
    Route::post('clone/{quote}', 'QuoteController@clone' )->name('cotacoes.clone');
    Route::get('approve/{quote}', 'QuoteController@approve' )->name('cotacoes.approve');
    Route::get('items/{quote}',  'QuoteController@items' )->name('cotacoes.items');
    Route::get('items/export/{quote}',  'QuoteController@export' )->name('cotacoes.export');
    Route::put('edit/{quote}',   'QuoteController@update')->name('cotacoes.update');
    Route::put('edit/{quote}/fator', 'QuoteController@updateFator')->name('cotacoes.update.fator');
    Route::put('edit/{quote}/icms',  'QuoteController@updateIcms')->name('cotacoes.update.icms');
    Route::put('edit/{quote}/ipi',   'QuoteController@updateIpi')->name('cotacoes.update.ipi');

    Route::delete('destroy/{quote}', 'QuoteController@destroy')->name('cotacoes.destroy');
});