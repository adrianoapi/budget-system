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

Route::get('/', function () {
    return view('welcome');
});


Route::get('login', "{$controller}\LoginController@index")->name('auth.login');
Route::post('/login/auth', "{$controller}\LoginController@auth")->name('login.auth');
Route::get('/login/sair', "{$controller}\LoginController@logout")->name('login.logout');
Route::get('/login/recover', "{$controller}\LoginController@recover")->name('login.recover');
Route::post('/login/recover/do', "{$controller}\LoginController@recoverDo")->name('login.recover.do');

Route::prefix('dashboard')->group(function(){
    $controller = 'App\Http\Controllers';
    Route::get('/', "{$controller}\DashboardController@index")->name('dashboard.index');
});