<?php

use App\Http\Controllers\ApprovalCutiController;
use App\Http\Controllers\CutiController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KelolaJabatanController;
use App\Http\Controllers\KelolaPegawaiController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PejabatBerwenangController;
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
        Route::get("/detail/{id}", [CutiController::class, "show"])->name('cuti.show');
        Route::post("/tambah", [CutiController::class, "addCuti"])->name('cuti.add.action');
        Route::get("/tambah", [CutiController::class, "showCreatePage"])->name('cuti.add');
        Route::post("/delete", [CutiController::class, "deleteCuti"])->name('cuti.delete');
    });

    Route::get("pertimbangan", [ApprovalCutiController::class, "index"])->name('approval.index');
    Route::post("pertimbangan", [ApprovalCutiController::class, "approveCuti"])->name('atasan.approval.approve');
    Route::get("pertimbangan/{id}", [ApprovalCutiController::class, "showApproval"])->name('atasan.approval.detail');

    
    Route::get("keputusan", [PejabatBerwenangController::class, "index"])->name('keputusan.index');
    Route::post("keputusan", [PejabatBerwenangController::class, "keputusanCuti"])->name('pejabat.keputusan.approve');
    Route::get("keputusan/{id}", [PejabatBerwenangController::class, "show"])->name('pejabat.keputusan.detail');

    Route::prefix("kelola")->group(function(){
        Route::prefix('pegawai')->group(function(){
            Route::get('', [KelolaPegawaiController::class, 'index'])->name('pegawai.index');
            Route::post('', [KelolaPegawaiController::class, 'store'])->name('pegawai.create');
            Route::get('create', [KelolaPegawaiController::class, 'create'])->name('pegawai.create-page');
            Route::get('/{id}', [KelolaPegawaiController::class, 'show'])->name('pegawai.show');
            Route::put('/{id}', [KelolaPegawaiController::class, 'update'])->name('pegawai.update');
            Route::put('/jabatan/{id}', [KelolaPegawaiController::class, 'updateJabatan'])->name('pegawai.jabatan');
            Route::delete('/{id}', [KelolaPegawaiController::class, 'destroy'])->name('pegawai.delete');
        });
    });

    Route::prefix("kelola")->group(function(){
        Route::prefix('jabatan')->group(function(){
            Route::get('', [KelolaJabatanController::class, 'index'])->name('jabatan.index');
            Route::post('', [KelolaJabatanController::class, 'store'])->name('jabatan.create');
            Route::get('create', [KelolaJabatanController::class, 'create'])->name('jabatan.create-page');
            Route::get('/{id}', [KelolaJabatanController::class, 'show'])->name('jabatan.show');
            Route::put('/{id}', [KelolaJabatanController::class, 'update'])->name('jabatan.update');
            Route::delete('/{id}', [KelolaJabatanController::class, 'destroy'])->name('jabatan.delete');
        });
    });

    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});

Route::middleware('guest')->group(function(){
    Route::post('login', [LoginController::class, "login"])->name('login');
    Route::get('login', [LoginController::class, "loginView"]);
});