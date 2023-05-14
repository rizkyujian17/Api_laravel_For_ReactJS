<?php

use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\ContactsController;
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

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::post('/logout', [UserController::class, 'logout']);
    Route::post('/update/user', [UserController::class, 'updateUser']);
    Route::post('/delete/user', [UserController::class, 'deleteUser']);


});
    Route::post('/contacts', [ContactsController::class, 'createNewContact']);
    Route::get('/contacts', [ContactsController::class, 'getAllContacts']);
    Route::get('/contacts/{id}', [ContactsController::class, 'getContactById']);
    Route::put('/contacts/{id}', [ContactsController::class, 'updateContact']);
    Route::delete('/contacts/{id}', [ContactsController::class, 'deleteContact']);

    Route::post('/register', [UserController::class, 'createNewUser']);
    Route::post('/login', [UserController::class, 'login']);
    Route::get('/tes', [UserController::class, 'tesTing']);

// Route::get('/tes', function () {
//     return response()->json("halolaravel");
// });