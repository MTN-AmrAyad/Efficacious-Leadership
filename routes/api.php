<?php

use App\Http\Controllers\ClienDataController;
use App\Http\Controllers\SeminarSixController;
use App\Http\Controllers\EfficaciousLeadershipController;
use App\Http\Controllers\FeedBackController;
use App\Http\Controllers\PatchTwoSQrController;
use App\Models\LeaderSeminarLandpage;
use App\Models\LeadershipSeminar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LeaderSeminarLandpageController;
use App\Http\Controllers\EfficasiousAttendPartThreeController;
use App\Http\Controllers\FreeWebinarAugestController;
use App\Http\Controllers\GenerateVochuerPatch3Controller;
use App\Http\Controllers\InstallementLandController;
use App\Http\Controllers\LeadershipAttedJulyController;
use App\Http\Controllers\LeaderShipAugestController;
use App\Http\Controllers\LeadershipWebinarController;
use App\Http\Controllers\LivingFetraController;
use App\Http\Controllers\LivingFetraMainProController;
use App\Http\Controllers\SeminarNineController;
use App\Models\LeadershipAttedJuly;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Retrive Data
Route::get('/review', [ClienDataController::class, 'index']);

// Retrive Data
Route::get('/reviewSeminar', [SeminarSixController::class, 'index']);

// inserting Data
Route::post('/register', [ClienDataController::class, 'register']);

// inserting Data
Route::post('/registerSeminar', [SeminarSixController::class, 'register']);

// Check Number Whatsapp exist or not
Route::post('/whatsapp', [ClienDataController::class, 'whatsapp']);

// Check Number Whatsapp exist or not
Route::post('/whatsappSeminar', [SeminarSixController::class, 'whatsapp']);

// Route::get('/getData/{type}/{phone}', [ClienDataController::class, 'getData']);
Route::get('/reg/{type}/{phone}', [ClienDataController::class, 'reg']);
// Route::get('/getData/{type}/{phone}', [ClienDataController::class, 'getData']);
Route::get('/regSemainar/{type}/{phone}', [SeminarSixController::class, 'reg']);

Route::get('getData/{phone}', [ClienDataController::class, 'getData']);

Route::get('getData/{phone}', [SeminarSixController::class, 'getData']);

// Route::get('instegram/{phone}', [ClienDataController::class, 'instegram']);



// Route Group for form in the EfficaciousLeadership Program
Route::controller(EfficaciousLeadershipController::class)->group(function () {
    Route::post('EfficaciousLeadership', 'create');
    Route::get('EfficaciousLeadership', 'review');
    Route::post('ERPLogin', 'ERPLogin');
    Route::post('createLeadERP', 'createLeadERP');
});
// Route Group for form in the EfficaciousLeadership Program
Route::controller(FeedBackController::class)->group(function () {
    Route::post('Feedback', 'create');
    Route::get('Feedback', 'review');
});
// Route Group for form generate QR Code for the Effic patch 2
Route::controller(PatchTwoSQrController::class)->group(function () {
    Route::post('ScnaQR/{phone_number}', 'QRcode');
    Route::get('ClientScanner', 'getAllQRcode');
});
// Route Group for form in seminar leadership page
Route::controller(LeaderSeminarLandpageController::class)->group(function () {
    Route::post('leadershipSeminar', 'createSeminar');
    Route::get('leadershipSeminar', 'review');
});
// Route Group for form in Attrend leadership part Three
Route::controller(EfficasiousAttendPartThreeController::class)->group(function () {
    Route::post('leadershipPartThree', 'store');
    Route::get('leadershipPartThree', 'index');
});
// Route Group fSeminar nine 9
Route::controller(SeminarNineController::class)->group(function () {
    Route::post('seminar-nine', 'store');
    Route::get('seminar-nine', 'index');
});
// Route to generate the vocher taken screen shot to client
Route::controller(GenerateVochuerPatch3Controller::class)->group(function () {
    Route::post('generate-vochuer', 'store');
    Route::get('generate-vochuer', 'index');
});
// Route to Register the data to leadership AUGEST
Route::controller(LeaderShipAugestController::class)->group(function () {
    Route::post('LeaderAugest', 'LeaderAugest');
    Route::get('LeaderAugest', 'review');
});

Route::controller(LeadershipAttedJulyController::class)->group(function () {
    Route::post('leaderShip-storeData',  'store');
    Route::get('leaderShip-getData',  'index');
    Route::get('leaderShip-checkChair',  'checkChair');
});

Route::controller(LeadershipWebinarController::class)->group(function () {
    Route::post('leaderShip-webinar-registration', 'store');
    Route::get('leaderShip-webinar-retriving', 'index');
});
Route::controller(FreeWebinarAugestController::class)->group(function () {
    Route::post('leaderShip-Augwebinar-registration', 'store');
    Route::get('leaderShip-Augwebinar-retriving', 'index');
});
//installement for land page
Route::controller(InstallementLandController::class)->group(function () {
    Route::post('installement-registration', 'store');
    // Route::get('    ', 'index');
});
Route::controller(LivingFetraController::class)->group(function () {
    Route::post('living-Fetra-registration', 'store');
    Route::get('living-Fetra-retriving', 'index');
});

//routing livingFetra Main Programe
Route::controller(LivingFetraMainProController::class)->group(function () {
    Route::post('livingFetra-store', 'store');
    Route::get('livingFetra-data', 'index');
    Route::get('livingFetra-checkChair',  'checkChair');
    Route::get('livingFetra-getClient/{id}',  'getClientById');
    Route::post('livingFetra-scanQr/{id}/{key}',  'scanQrEbtAdvanced');
    Route::get('livingFetra-getScanQr',  'getQr');
    Route::post('livingFetra-confirmation/{id}',  'sendMessage');
});




Route::post('/lead', [EfficaciousLeadershipController::class, 'ERPLogin']);
