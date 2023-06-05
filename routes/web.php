<?php

use App\Http\Controllers\CutiController;
use App\Http\Controllers\DashboardController;
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

Route::get('/', [DashboardController::class, 'dashboardPage'])->name('dashboard');

Route::prefix('cuti')->group(function(){
    Route::get("", [CutiController::class, "index"])->name('cuti.index');
    Route::get("/tambah", [CutiController::class, "showCreatePage"])->name('cuti.add');
});

Route::get('login', function(){
    return view('auth.login');
});