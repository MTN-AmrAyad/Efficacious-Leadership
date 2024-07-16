<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LeaderSeminarLandpageController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


// Route::prefix('leadershipSeminar')->group(function () {
//     Route::post('/api', [LeaderSeminarLandpageController::class, 'createSeminar'])->name('seminar.create');
//     Route::get('/api', [LeaderSeminarLandpageController::class, 'review'])->name('seminar.review');
// });
