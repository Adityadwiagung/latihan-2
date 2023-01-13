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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['verify' => true]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


//Prefix untuk /master
Route::prefix('master')->group(function () {

    // Mahasiswa
    Route::middleware(['auth', 'verified'])->group(function () {
        Route::get('/mahasiswa', [App\Http\Controllers\MahasiswaController::class, 'index'])->name('get.mahasiswa');
        Route::get('/mahasiswa/tambah', [App\Http\Controllers\MahasiswaController::class, 'tambah'])->name('get.tambah.mahasiswa');
        Route::post('/mahasiswa/tambah/proses', [App\Http\Controllers\MahasiswaController::class, 'proses_tambah'])->name('post.proses-tambah.mahasiswa');
        Route::get('/mahasiswa/detail/{id}', [App\Http\Controllers\MahasiswaController::class, 'detail'])->name('get.detail.mahasiswa');
        Route::get('/mahasiswa/ubah/{id}', [App\Http\Controllers\MahasiswaController::class, 'ubah'])->name('get.ubah.mahasiswa');
        Route::patch('/mahasiswa/ubah/proses/{id}', [App\Http\Controllers\MahasiswaController::class, 'proses_ubah'])->name('post.proses-ubah.mahasiswa');
        Route::delete('/mahasiswa/hapus/{id}', [App\Http\Controllers\MahasiswaController::class, 'hapus'])->name('delete.mahasiswa');
    });


    // Kelas
    Route::middleware(['auth', 'verified'])->group(function () {
        Route::get('/kelas', [App\Http\Controllers\KelasController::class, 'index'])->name('get.kelas');
        Route::get('/kelas/tambah', [App\Http\Controllers\KelasController::class, 'tambah'])->name('get.tambah.kelas');
        Route::post('/kelas/tambah/proses', [App\Http\Controllers\KelasController::class, 'proses_tambah'])->name('post.proses-tambah.kelas');
        Route::get('/kelas/detail/{id}', [App\Http\Controllers\KelasController::class, 'detail'])->name('get.detail.kelas');
        Route::get('/kelas/ubah/{id}', [App\Http\Controllers\KelasController::class, 'ubah'])->name('get.ubah.kelas');
        Route::patch('/kelas/ubah/proses/{id}', [App\Http\Controllers\KelasController::class, 'proses_ubah'])->name('post.proses-ubah.kelas');
        Route::delete('/kelas/hapus/{id}', [App\Http\Controllers\KelasController::class, 'hapus'])->name('delete.kelas');
    });

});

// No Prefix and Middleware Auth & Verified
    Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/about', [App\Http\Controllers\HomeController::class, 'about'])->name('about');

    // Profile
    Route::get('/my-profile/{id}', [App\Http\Controllers\ProfileController::class, 'create'])->name('profile.home');
    Route::patch('/my-profile/{id}', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');

    // Get Files
    Route::get('/files/profile-picture/{namaFile}', [App\Http\Controllers\FilesController::class, 'showProfilePicture']);
});