<?php

use App\Http\Controllers\API\V1\AuthController;
use App\Http\Controllers\API\V1\MainController;
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

Route::prefix('v1')->group(function () {

    Route::prefix("auth")
        ->controller(AuthController::class)
        ->group(
            function () {
                Route::post("login", "login")->name("login");
                Route::post("register", "register");

                Route::post("logout", "logout")->middleware('api');
                Route::post("refreshToken", "refreshToken")->middleware('api');
                Route::get("me", "me")->middleware('api');
            }
        );

    Route::middleware(['api'])
        ->group(
            function () {
                Route::get("/", MainController::class);
            }
        );
});

Route::any('{any}', function () {
    return response()->json([
        "status" => false,
        "body" => [],
        "errors" => [],
        "message" => "Не найден!"
    ], 404);
})->where('any', '.*');
