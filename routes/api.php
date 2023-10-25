<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\UploadImagesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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


//public routes
Route::post('register',[AuthController::class, 'register']);
Route::post('login',[AuthController::class, 'login']);

//Protected route
Route::group(['middleware' => 'auth:sanctum','prefix' => 'property'], function () {
    Route::post('/', [PropertyController::class, 'index']);
    Route::post('/create', [PropertyController::class, 'create']);
    Route::get('/view/{id}', [PropertyController::class, 'detail']);
    Route::post('/edit/{id}', [PropertyController::class, 'update']);
    Route::delete('/delete/{id}', [PropertyController::class, 'delete']);
    Route::get('/amenity', [PropertyController::class, 'getAmenity']);
    // Route::post('/media/upload', [UploadImagesController::class, 'store'])->name('property.media.upload');
    // Route::get('/media/data/{post}', [UploadImagesController::class, 'getData'])->name('property.media.data');
});
