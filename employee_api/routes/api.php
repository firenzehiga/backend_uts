<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\AuthController;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

    # route employees
    Route::get('/employee', [EmployeeController::class, 'index']);
    # route store untuk menambahkan data
    Route::post('/employee', [EmployeeController::class, 'store']);
    # route update untuk mengubah data
    Route::put('/employee/{id}', [EmployeeController::class, 'update']);
    # route delete untuk menghapus data
    Route::delete('/employee/{id}', [EmployeeController::class, 'delete']);
    # route show untuk menampilkan detail data
    Route::get('/employee/{id}', [EmployeeController::class, 'show']);
    # route search untuk mencari data berdasarkan nama
    Route::get('/search', [EmployeeController::class, 'searchByName']);
    # route get active untuk menampilkan data pegawai yang aktif
    Route::get('/active', [EmployeeController::class, 'getActive']);
    # route get inactive untuk menampilkan data pegawai yang tidak aktif
    Route::get('/inactive', [EmployeeController::class, 'getInActive']);
    # route get terminated untuk menampilkan data pegawai yang terminated
    Route::get('/terminated', [EmployeeController::class, 'getTerminated']);
