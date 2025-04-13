<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NAME_MODELController;


Route::middleware(['auth', 'permission'])->group(function () {
    Route::post('/NAME_TABLE/validateForm', [NAME_MODELController::class, 'validateForm'])->name('NAME_TABLE.validateForm');
    Route::get('/NAME_TABLE/dataTable', [NAME_MODELController::class, 'dataTable'])->name('NAME_TABLE.dataTable');
    Route::get('/NAME_TABLE/{id}/enable', [NAME_MODELController::class, 'enable'])->name('NAME_TABLE.enable');
    Route::get('/NAME_TABLE/{id}/disable', [NAME_MODELController::class, 'disable'])->name('NAME_TABLE.disable');
    Route::get('/NAME_TABLE/{id}/logs', [NAME_MODELController::class, 'logs'])->name('NAME_TABLE.logs');
    Route::resource('NAME_TABLE', NAME_MODELController::class);
});
