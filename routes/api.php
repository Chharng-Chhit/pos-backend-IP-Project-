<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Product\ProductTypeController;
use App\Http\Controllers\Product\ProductController;
use App\Http\Controllers\GalleryController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post("register", [ApiController::class, "register"]);
Route::post("login", [ApiController::class, "login"]);

Route::group(["middleware" => ["auth:api"]], function(){

    Route::get("profile", [ApiController::class, "profile"]);
    Route::get("refresh", [ApiController::class, "refreshToken"]);
    Route::get("logout", [ApiController::class, "logout"]);
});

Route::group(["middleware" => ["auth:api"], 'prefix' => 'product'], function(){

    Route::get('/', function(){
        return "hello";
    });
    Route::get("/", [ProductController::class, "getData"]);
    // Route::get("refresh", [ApiController::class, "refreshToken"]);
    // Route::get("logout", [ApiController::class, "logout"]);
});

Route::group(["middleware" => ["auth:api"], 'prefix' => 'type'], function(){

    Route::get('/', function(){
        return "hello";
    });
    Route::get("/", [ProductTypeController::class, "getData"]);
    // Route::get("refresh", [ApiController::class, "refreshToken"]);
    // Route::get("logout", [ApiController::class, "logout"]);
});

Route::post('/add', [GalleryController::class], 'store');
