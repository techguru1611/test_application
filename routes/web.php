<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;

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

Route::get('/items', [ItemController::class, 'index'])->name('items');

Route::post('/saveItem', [ItemController::class, 'save'])->name('saveItem');

Route::post('/toRight', [ItemController::class, 'moveRight'])->name('toRight');

Route::post('/toLeft', [ItemController::class, 'moveLeft'])->name('toLeft');
