<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BedroomController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\RekeningController;
use App\Http\Controllers\SettingController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function (){
    //Welcome User
    Route::get('dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
    //Delete Account
    Route::put('inactive', [AuthController::class, 'inactive_account'])->name('auth.inactive');
    
    //Bedroom
    Route::resource('bedroom', BedroomController::class);
    //Booking
    Route::resource('booking', BookingController::class);
    //Rekening
    Route::resource('rekening', RekeningController::class);
    //View rekening
    Route::get('rekening', [RekeningController::class, 'index'])->name('rekening.index');
    Route::get('rekedit', [RekeningController::class, 'edit'])->name('rekening.edit');
    Route::put('rekedit', [RekeningController::class, 'update'])->name('rekening.update');
    //View Bedroom Detail
    Route::get('bedroom_detail', [BookingController::class, 'bedroom_detail'])->name('bedroom.detail');
    //Booking send bedroom id
    Route::get('transaction/{id}', [BookingController::class, 'transaction'])->name('booking.transaction');
    //Payment POV Admin
    Route::get('payment', [BookingController::class, 'index_admin'])->name('index_admin');
    //Status POV Admin
    Route::post('status/{id}/update-status', [BookingController::class, 'payment_status'])->name('booking.status');
    
    
    //FRONT END
    
    //Setting User
    Route::get('profile', [SettingController::class, 'index'])->name('profile.index');
    Route::get('profile/show', [SettingController::class, 'show'])->name('profile.show');
    Route::get('profile/edit', [SettingController::class, 'form'])->name('profile.form');
    Route::put('profile', [SettingController::class, 'add'])->name('profile.add');
    //Profil Image
    Route::put('profile/upload', [SettingController::class, 'uploadImage'])->name('profile.update');
    //newPassword
    Route::put('newpassword', [SettingController::class, 'newPassword'])->name('profile.newpassword');
    //Chart ViewAdmin
    Route::get('api/data-revenue', [SettingController::class, 'chartRevenue']);
    Route::post('logout', [AuthController::class, 'logout'])->name('auth.logout');
});

//LOGIN & REGISTER
Route::get('/', function () {
    return redirect()->route('auth.login');
});
//Halaman Register
Route::get('/register', [AuthController::class, 'register'])->name('auth.register');
//Save user register
Route::post('/register', [AuthController::class, 'store'])->name('auth.store');
//Halaman Login
Route::get('login', [AuthController::class, 'login'])->name(('auth.login'));
//Pemeriksaan ke tabel user yang disebut (Autentikasi/authentication)
Route::post('login', [AuthController::class, 'authentication'])->name(('auth.authentication'));
//Sesi Logout
