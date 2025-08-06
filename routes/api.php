<?php

use Illuminate\Http\Request;
use App\Http\Controllers\Api\V1\Auth\AuthenticationController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\PreferenceController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SourceController;
use App\Http\Controllers\AuthorController;
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

  //  Route::group(['v2'], function() {

      Route::group(['prefix'=> 'auth'], function() {
            Route::post('register', [AuthenticationController::class, 'register']);
            Route::post('login', [AuthenticationController::class, 'login']);
            Route::post('forgot-password', [ForgotPasswordController::class, 'forgotPassword']);
          Route::group(['middleware' => 'auth:sanctum'], function() {
            Route::get('user', [AuthenticationController::class, 'user']);
            Route::post('logout', [AuthenticationController::class, 'logout']);
            Route::post('/email/verification-notification', [VerifyEmailController::class, 'resendNotification'])->name('verification.send');
            Route::post('reset-password', [ResetPasswordController::class, 'resetPassword']); 

             // Articles
           Route::get('/articles', [ArticleController::class, 'index']);
           Route::get('/articles/{article:slug}', [ArticleController::class, 'show']);
           Route::get('/feed', [ArticleController::class, 'personalizedFeed']);
           // Route::apiResource('articles', ArticleController::class);
    
         // Preferences
            Route::get('/preferences', [PreferenceController::class, 'index']);
            Route::put('/preferences/preference', [PreferenceController::class, 'update']);
    
           // Sources, Categories, Authors
           Route::get('/sources', [ArticleController::class, 'sources']);
           Route::get('/categories', [ArticleController::class, 'categories']);
           Route::get('/authors', [ArticleController::class, 'authors']);
 
          });
     });

//  });
