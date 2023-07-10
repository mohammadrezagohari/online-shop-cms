<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProvinceController;
use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/mobile', function (Request $request) {
    $mobile = "09387589696";
    $programmer = "mehrdad ebrahimi";
    return response()->json(['programmer' => $programmer, 'mobile' => $mobile]);
});

//version v1
Route::prefix('v1')->group(function () {



    Route::prefix('auth')->group(function () {
        Route::get('login', function () {
            return redirect('/');
        })->name('login');
        Route::post('login', [AuthController::class, 'login'])->name('login');
        Route::prefix('otp')->group(function () {
            Route::post('/', [AuthController::class, 'otp'])->name('otp');
            Route::post('/verify', [AuthController::class, 'verifyMobile'])->name('verifyMobile');
         //   Route::get('/verify', [AuthController::class, 'verifyMobile'])->name('verifyMobile');
        });
        Route::post('register', [AuthController::class, 'register'])->name('register');
    });


    Route::middleware('auth:sanctum')->group(function () {

        Route::group(['prefix' => 'province'], function () {
            Route::get('/', [ProvinceController::class, 'index'])->name('index');
            Route::post('/store', [ProvinceController::class, 'store'])->name('store')->middleware('is_admin');
            Route::get('/show/{id}', [ProvinceController::class, 'show'])->name('show');
            Route::patch('/update/{id}', [ProvinceController::class, 'update'])->name('update')->middleware('is_admin');
            Route::delete('/delete/{id}', [ProvinceController::class, 'destroy'])->name('delete')->middleware('is_admin');
        });


    });
});
