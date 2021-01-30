<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\DeletedContactsController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\PhoneController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::apiResource('contacts',ContactController::class)->only(['index','store','update','destroy']);
Route::apiResource('deleted-contacts',DeletedContactsController::class)->only(['store']);
// Route::apiResource('emails',EmailController::class)->only('destroy');
// Route::apiResource('phones',PhoneController::class)->only('destroy');
