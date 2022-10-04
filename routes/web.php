<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\challange2Controller;
use App\Http\Controllers\challenge4Controller;


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


Route::get('/challang2',[challange2Controller::class,'challang2']);
Route::get('/groupByOwnersService',[challenge4Controller::class,'groupByOwnersService']);


