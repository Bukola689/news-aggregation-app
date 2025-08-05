<?php

use Illuminate\Http\Request;
use App\Http\Controllers\Api\V1\Auth\AuthenticationController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

  //  Route::group(['v1'], function() {

      Route::group(['prefix'=> 'auth'], function() {
            Route::post('register', [AuthenticationController::class, 'register']);
            Route::post('login', [AuthenticationController::class, 'login']);
            Route::post('forgot-password', [ForgotPasswordController::class, 'forgotPassword']);
          Route::group(['middleware' => 'auth:sanctum'], function() {
            Route::post('user', [AuthController::class, 'user']);
            Route::post('logout', [AuthenticationController::class, 'logout']);
            Route::post('/email/verification-notification', [VerifyEmailController::class, 'resendNotification'])->name('verification.send');
            Route::post('reset-password', [ResetPasswordController::class, 'resetPassword']); 
 
          });
     });

//  });
