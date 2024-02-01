<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClienteController;



// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

//dentro del parentesis ('modelo', controllador::class)
Route::apiResource('Clientes', ClienteController::class);

