<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SixFourNineController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

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
    // return view('welcome');
    return Redirect::action([SixFourNineController::class, 'index']);
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/lotto/history/6-49', [SixFourNineController::class, 'index'])->name('sixfournine');
Route::post('/lotto/history/6-49/store', [SixFourNineController::class, 'store'])->name('sixfournine.store');
Route::patch('/lotto/history/6-49/update/{id_string}', [SixFourNineController::class, 'update'])->name('sixfournine.update');
Route::patch('/lotto/history/6-49/destroy/{id_string}', [SixFourNineController::class, 'destroy'])->name('sixfournine.destroy');
