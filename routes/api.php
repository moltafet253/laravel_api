<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Api\V1\PostController as V1PostController;
use App\Http\Controllers\Api\V2\PostController as V2PostController;

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


//view posts
Route::get('posts', [PostController::class, 'index']);

//show post with id
Route::get('posts/{id}', [PostController::class, 'show']);

//create post
Route::post('posts', [PostController::class, 'store']);

//update post
Route::put('posts/{id}', [PostController::class, 'update']);

//delete post
Route::delete('posts/{id}', [PostController::class, 'delete']);

//Create API Controller -> php artisan make:controller UserController --api => UserController is name of controller
Route::apiResource('users', UserController::class);

//Version management -> you can
//first create your controller like this -> php artisan make:controller Api\V1\PostController --api
//then create resources split -> php artisan make:resource V1\PostResource
Route::prefix('v1')->group(function (){
    Route::get('/posts',[V1PostController::class,'index']);
});

//Route::prefix('v2')->group(function (){
//    Route::get('/posts',[V2PostController::class,'index']);
//});

//if you want to authorize user with token
Route::prefix('v2')->middleware('auth:api')->group(function (){
    Route::get('/posts',[V2PostController::class,'index']);
});

//Register Method
//for first create a controller for example -> AuthController
//then write this
Route::post('/register',[AuthController::class,'register']);
//then go to your controller and create a method for example -> public function register (Request $request){}
//then go to your postman and duplicate from create post and empty body and create this keys -> name email password c_password
//then go to controller and extend from ApiController and use|import class and write that codes

//Login Method
Route::post('/login',[AuthController::class,'login']);
//then go to your controller and duplicate from register and I wrote there
//then duplicate your register postman request

//Logout Method
Route::post('/logout',[AuthController::class,'logout'])->middleware('auth:api');
//then create a function name logout
//then duplicate login postman and create into header -> Accept => application/json
