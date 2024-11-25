<?php

// use Illuminate\Http\Request;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FacultyController;
use App\Http\Controllers\LogController;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

// Route::get('/', function(){
//     return 'hello';
// });

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logs', [LogController::class, 'store']);

Route::group(['middleware' => ['auth:universitymis']], function(){

    ###Profile
    Route::post('/profile', [FacultyController::class, 'store']);
    Route::post('/update-status', [FacultyController::class, 'availability']);

    ####LOGS
    Route::get('/completed-logs/page/', [LogController::class, 'completed_logs']);
    Route::get('/accepted-logs/page/', [LogController::class, 'accepted_logs']);

    ### LOG OUT
    Route::post('/logout', [AuthController::class, 'logout']);

});
