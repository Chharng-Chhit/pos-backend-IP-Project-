<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Product\ProductTypeController;
use App\Http\Controllers\Product\ProductController;
use App\Http\Controllers\Pos\PosController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Sale\SaleController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Sale\PrintController;

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

Route::group(["middleware" => ["auth:api"]], function () {

    Route::get("profile", [ApiController::class, "profile"]);
    Route::get("refresh", [ApiController::class, "refreshToken"]);
    Route::get("logout", [ApiController::class, "logout"]);
    Route::get('/profile', [ApiController::class, "profile"]);
});

Route::group(["middleware" => ["auth:api"], 'prefix' => 'product'], function () {

    // Product
    Route::get("/", [ProductController::class, "getData"]);
    Route::get('/searchName', [ProductController::class, "searchName"]);
    Route::get('/searchId', [ProductController::class, "searchID"]);
    Route::get('/types/category', [ProductController::class, "getProductByCategory"]);
    Route::put('/update', [ProductController::class, "update"]);
    Route::delete('/delete', [ProductController::class, "delete"]);
    Route::post('/', [ProductController::class, "create"]);
    Route::post('/addStock', [ProductController::class, "addStock"]);


    // Product type
    Route::get("/types", [ProductTypeController::class, "getData"]);
    Route::post("/type", [ProductTypeController::class, "create"]);
    Route::get('/type/search', [ProductTypeController::class, "searchByName"]);
    Route::put("/type/update", [ProductTypeController::class, "update"]);
    Route::delete("/type/delete", [ProductTypeController::class, "delete"]);
});

Route::group(["middleware" => "auth:api"], function () {

    // user
    Route::get('user/all', [UserController::class, 'getUser']);
    Route::get('user/', [UserController::class, 'notCustomer']); // for get user that is not a customer
    Route::get('user/customers', [UserController::class, 'getCustomer']);
    Route::post('user/', [UserController::class, 'create']);

    Route::get('/user/view', [UserController::class, 'view']);
    Route::post('/user/create', [UserController::class, 'create']);
    Route::put('/user/update', [UserController::class, 'update']);
    Route::delete('/user/delete', [UserController::class, 'delete']);
    Route::get('/user/search', [UserController::class, 'searchUser']);
    Route::put('/user/changepassword', [UserController::class, 'changePassword']);
});

Route::group(["middleware" => ["auth:api"], 'prefix' => 'pos'], function () {
    Route::get('/products',     [PosController::class, 'getProducts']); // Read all records
    Route::post('/order',       [PosController::class, 'makeOrder']); // Create new order

});

Route::group(["middleware" => ["auth:api"], 'prefix' => 'sale'], function () {
    Route::get("/", [SaleController::class, 'getData']);
    Route::get("/view", [SaleController::class, 'getDataById']);


    Route::get('/print/{receipt_number}',   [PrintController::class, 'printInvoice']);
});
Route::group(["middleware" => ["auth:api"], 'prefix' => 'dasboard'], function () {
    Route::get("/", [DashboardController::class, 'getDashboard']);
    Route::get("/thisMonth", [DashboardController::class, 'getDashboardThisMonth']);
    Route::get("/today", [DashboardController::class, 'getDashboardToday']);
    Route::get("/lastMonth", [DashboardController::class, 'getDashboardLastMonth']);
});

Route::get("/getdata", [ProductTypeController::class, "getData"]);
Route::get('/getImage', [ImageController::class, 'getImage']);
Route::middleware('auth:api')->post('/uploadImage', [ImageController::class, "upload"]);
Route::middleware('auth:api')->delete('/deleteImage', [ImageController::class, "delete"]);
