<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FreeGiftController;
use App\Http\Controllers\GiftRecordController;
use App\Http\Controllers\VisitorController;
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


Route::post('freegifts', [FreeGiftController::class, 'store']);
Route::get('freegifts', [FreeGiftController::class, 'show']);
Route::put('freegifts/decrease/{id}', [FreeGiftController::class, 'decrease']);
Route::put('freegifts/increase/{id}', [FreeGiftController::class, 'increase']);
Route::post('gift-records', [GiftRecordController::class, 'store']);
Route::get('gift-records', [GiftRecordController::class, 'show']);
Route::get('gift-records/checkPaymentId/{paymentId}', [GiftRecordController::class, 'checkPaymentId']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
