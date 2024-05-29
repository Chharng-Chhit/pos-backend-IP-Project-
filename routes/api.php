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

    // Product
    Route::get("/", [ProductController::class, "getData"]);
    Route::get('/searchName', [ProductController::class, "searchName"]);
    Route::get('/searchId', [ProductController::class, "searchID"]);
    Route::get('/types/category', [ProductController::class, "getProductByCategory"]);
    Route::put('/update', [ProductController::class, "update"]);
    Route::delete('/delete', [ProductController::class, "delete"]);
    Route::post('/', [ProductController::class,"create"]);


    // Product type
    Route::get("/types", [ProductTypeController::class, "getData"]);
    Route::post("/type", [ProductTypeController::class, "create"]);
    Route::get('/type/search', [ProductTypeController::class, "searchByName"]);
    Route::put("/type/update", [ProductTypeController::class, "update"]);
    Route::delete("/type/delete", [ProductTypeController::class, "delete"]);


});


Route::get("/getdata", [ProductTypeController::class, "getData"]);
Route::get('/getImage', [ImageController::class, 'getImage']);
Route::middleware('auth:api')->post('/uploadImage', [ImageController::class, "upload"]);
Route::middleware('auth:api')->delete('/deleteImage', [ImageController::class, "delete"]);
