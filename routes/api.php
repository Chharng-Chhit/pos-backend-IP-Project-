<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Product\ProductTypeController;
use App\Http\Controllers\Product\ProductController;
use App\Http\Controllers\ImageController;

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


    // Product type
    Route::get("/types", [ProductTypeController::class, "getData"]);
    Route::post("/type", [ProductTypeController::class, "create"]);
    Route::get('/types/{key}', [ProductTypeController::class, "search"]);
    Route::put("/type/{id}", [ProductTypeController::class, "update"]);
    Route::delete("/type/{id}", [ProductTypeController::class, "delete"]);

});

Route::group(["middleware" => ["auth:api"], 'prefix' => 'type'], function(){

    Route::get("/", [ProductTypeController::class, "getData"]);
    Route::post("/", [ProductTypeController::class, "create"]);
    Route::put("/{id}", [ProductTypeController::class, "update"]);
});
Route::get('/get', function(){
    return "Hello world";
});
Route::get("/getdata", [ProductTypeController::class, "getData"]);
Route::get('/getImage', [ImageController::class, 'getImage']);
Route::middleware('auth:api')->post('/uploadImage', [ImageController::class, "upload"]);
Route::delete('/deleteImage', [ImageController::class, "delete"]);
