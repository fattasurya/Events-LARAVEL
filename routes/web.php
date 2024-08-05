<?php



use Illuminate\Support\Facades\Route;

use App\Http\Controllers\EventController;

use App\Http\Controllers\FullCalenderController;



/*

|--------------------------------------------------------------------------

| Web Routes

|--------------------------------------------------------------------------

|

| Here is where you can register web routes for your application. These

| routes are loaded by the RouteServiceProvider within a group which
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\FullCalenderController;

/*
|---------------------------------------------------------------------------
| Web Routes
|---------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route untuk halaman kontak
Route::get('/kontak', function () {
    return view('kontak');
});

// Route untuk pencarian event
Route::get('/events/search', [EventController::class, 'search'])->name('events.search');

// Route untuk list event
Route::get('/events/list', [EventController::class, 'list'])->name('events.list');

// Route untuk menampilkan event berdasarkan ID
Route::get('/events/{id}', [EventController::class, 'show'])->name('events.show');

// Route resource untuk CRUD events
Route::resource('events', EventController::class);

// Route untuk kalender penuh
Route::get('/', [FullCalenderController::class, 'index']);
Route::post('fullcalenderAjax', [FullCalenderController::class, 'ajax']);
// web.php


Route::delete('/events/{id}', [EventController::class, 'destroy'])->name('events.destroy');





