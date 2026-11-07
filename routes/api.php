<?php

use App\Http\Controllers\Api\EquipmentController;


use App\Http\Controllers\Api\FuelLoadController;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;


Route::prefix('v1')->group(function () {

    Route::post('/login', [AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {


        Route::post('/logout', [AuthController::class, 'logout']);

        Route::apiResource('equipment', EquipmentController::class);

        Route::apiResource('fuel_loads', FuelLoadController::class)->except('update','destroy');


        Route::get('/user', function (Request $request) {
            return $request->user();
        });


        Route::get('/users', function (Request $request) {
            return User::all();
        });


/*        Route::prefix('equipment')->group(function () {

            Route::get('/',[EquipmentController::class, 'index']);

            //ruta para ver las cargas de combustible de un equipo
            Route::get('/{equipment}/fuel-loads',[FuelLoadController::class, 'show']);


        });*/







    });

});







