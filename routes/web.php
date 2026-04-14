<?php

use App\Http\Controllers\LeafletController;
use App\Http\Controllers\OfficerController;
use App\Http\Controllers\PelaporanController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/pelaporan',[PelaporanController::class,'index'])->name('pelaporan');
    Route::post('/pelaporan/submit',[PelaporanController::class,'laporan'])->name('laporan');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('role:officer')->group(function () {
    Route::get('/officer/dashboard',[OfficerController::class,'officerDashboard'])->name('officer.dashboard');
    Route::get('/officer/laporan/{id}',[PelaporanController::class,'showLaporan'])->name('officer.show-laporan');
    Route::delete('/officer/laporan/delete/{id}',[PelaporanController::class,'destroy'])->name('officer.destroy-laporan');
});





require __DIR__.'/auth.php';
