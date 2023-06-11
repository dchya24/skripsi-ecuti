<?php

use App\Http\Controllers\CutiController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
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

Route::middleware('auth')->group(function() {
    Route::get('/', function(){
        return redirect()->route('dashboard');
    });
    Route::get('/home', function(){
        return redirect()->route('dashboard');
    });

    Route::get('/dashboard', [DashboardController::class, 'dashboardPage'])->name('dashboard');
    Route::prefix('cuti')->group(function(){
        Route::get("", [CutiController::class, "index"])->name('cuti.index');
        Route::post("/tambah", [CutiController::class, "addCuti"])->name('cuti.add.action');
        Route::get("/tambah", [CutiController::class, "showCreatePage"])->name('cuti.add');
        Route::post("/delete", [CutiController::class, "deleteCuti"])->name('cuti.delete');
    });

    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});

Route::middleware('guest')->group(function(){
    Route::post('login', [LoginController::class, "login"])->name('login');
    Route::get('login', [LoginController::class, "loginView"]);
});