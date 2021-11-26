<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\DisposisiController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KepsekController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TrackController;
use App\Http\Controllers\WakaController;
use App\Models\Disposisi;
use Illuminate\Support\Facades\Auth;
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



Route::get('/tables', function () {
    return view('tables');
});

Route::get('/', [LoginController::class, 'index']);
Route::get('login', [LoginController::class, 'index'])->name('login');
Route::post('postlogin', [LoginController::class, 'postlogin'])->name('postlogin');
Route::get('logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

Route::middleware(['auth', 'ceklevel:admin,tata_usaha'])->group(function () {
    Route::get('/detail/{id}', [AdminController::class, 'show'])->name('detail');
    Route::get('/surat_masuk', [AdminController::class, 'index'])->name('surat_masuk');
    Route::get('/arsip', [AdminController::class, 'arsip'])->name('arsip');
    Route::get('/arsip_detail', [AdminController::class, 'arsip_detail'])->name('arsip_detail');
    Route::get('/create', [AdminController::class, 'create'])->name('create');
    Route::post('/tambah', [AdminController::class, 'store'])->name('tambah');
    Route::get('/edit_masuk/{id}', [AdminController::class, 'edit'])->name('edit_masuk');
    Route::put('/update_masuk/{id}', [AdminController::class, 'update'])->name('update_masuk');
    Route::delete('/hapus_masuk/{id}', [AdminController::class, 'destroy'])->name('hapus_masuk');
    Route::get('/create_disposisi/{id}', [DisposisiController::class, 'create'])->name('create_disposisi');
    Route::post('/save_disposisi/{id}', [DisposisiController::class, 'store'])->name('save_disposisi');
    Route::post('/kirim/{id}', [DisposisiController::class, 'store'])->name('kirim');
    Route::get('/edit_disposisi/{id}', [DisposisiController::class, 'edit'])->name('edit_disposisi');
    Route::put('/update_disposisi/{id}', [DisposisiController::class, 'update'])->name('update_disposisi');
});
Route::middleware(['auth', 'ceklevel:admin,kepala_sekolah'])->group(function () {
    Route::get('/detail_kepsek/{id}', [KepsekController::class, 'show'])->name('detail_kepsek');
    Route::get('/surat_masuk_kepsek', [KepsekController::class, 'index'])->name('surat_masuk_kepsek');
    Route::post('/disposisi_kepsek/{id}', [KepsekController::class, 'store'])->name('disposisi_kepsek');
    Route::post('/persetujuan/{id}', [KepsekController::class, 'persetujuan'])->name('persetujuan');
});
Route::middleware(['auth', 'ceklevel:admin,disposisi'])->group(function () {
    Route::get('/detail_waka/{id}', [WakaController::class, 'show'])->name('detail_waka');
    Route::get('/surat_masuk_waka', [WakaController::class, 'index'])->name('surat_masuk_waka');
    Route::get('/disposisi_waka', [WakaController::class, 'disposisi'])->name('disposisi_waka');
    Route::post('/save_waka/{id}', [WakaController::class, 'store'])->name('save_waka');
});
Route::middleware(['auth', 'ceklevel:admin,tata_usaha,kepala_sekolah,disposisi'])->group(function () {
    Route::get('/arsip', [AdminController::class, 'arsip'])->name('arsip');
    Route::get('/arsip_detail/{id}', [AdminController::class, 'arsip_detail']);
    Route::get('/disposisi', [DisposisiController::class, 'index'])->name('disposisi');
    Route::get('/track/{id}', [AdminController::class, 'track'])->name('track');
    Route::get('/download/{id}', [AdminController::class, 'download'])->name('download');
});
