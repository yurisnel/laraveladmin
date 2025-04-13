
<?php

use App\Http\Controllers\ClientController;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth', 'permission'])->group(function () {
      Route::post('/clients/validateForm', [ClientController::class, 'validateForm'])->name('clients.validateForm');
      Route::get('/clients/dataTable', [ClientController::class, 'dataTable'])->name('clients.dataTable');
      Route::get('/clients/{id}/enable', [ClientController::class, 'enable'])->name('clients.enable');
      Route::get('/clients/{id}/disable', [ClientController::class, 'disable'])->name('clients.disable');
      Route::get('/clients/{id}/logs', [ClientController::class, 'logs'])->name('clients.logs');
      Route::resource('clients', ClientController::class);
});