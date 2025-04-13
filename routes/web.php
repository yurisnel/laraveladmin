<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Logs\LogErrorsController;
use App\Http\Controllers\Logs\LogEventsController;
use App\Http\Controllers\Access\MenuController;
use App\Http\Controllers\Access\ProfileController;
use App\Http\Controllers\Access\UserController;
use App\Http\Controllers\Access\RoleController;
use App\Http\Controllers\Access\RouteController;
use App\Http\Controllers\Access\PermissionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

/*Route::get('/', function () {
    return view('auth.login');
});*/

Route::redirect('/', 'dashboard');
Route::redirect('/rutatest', 'dashboard')->name('rutatest');
Route::get('/dashboard', [HomeController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('guest')->group(function () {
    Route::get('/user-inactive/{user}', [UserController::class, 'userInactive'])
        ->name('user.inactive');

    Route::get('user-request-activation/{user}', [UserController::class, 'requestUserActivation'])
        ->name('user.requestActivation');
});

Route::middleware(['auth', 'permission'])->group(function () {
    Route::post('/users/validateForm', [UserController::class, 'validateForm'])->name('users.validateForm');
    Route::get('/users/dataTable', [UserController::class, 'dataTable'])->name('users.dataTable');
    Route::get('/users/{id}/enable', [UserController::class, 'enable'])->name('users.enable');
    Route::get('/users/{id}/disable', [UserController::class, 'disable'])->name('users.disable');
    Route::get('/users/{id}/reset-password', [UserController::class, 'resetPassword'])->name('users.resetPassword');
    Route::get('/users/{id}/logs', [UserController::class, 'logs'])->name('users.logs');
    Route::resource('users', UserController::class);
});

Route::middleware(['auth', 'permission'])->group(function () {
    Route::post('/roles/validateForm', [RoleController::class, 'validateForm'])->name('roles.validateForm');
    Route::get('/roles/dataTable', [RoleController::class, 'dataTable'])->name('roles.dataTable');
    Route::get('/roles/{id}/enable', [RoleController::class, 'enable'])->name('roles.enable');
    Route::get('/roles/{id}/disable', [RoleController::class, 'disable'])->name('roles.disable');
    Route::get('/roles/{id}/logs', [RoleController::class, 'logs'])->name('roles.logs');
    Route::resource('roles', RoleController::class);
});

Route::middleware(['auth', 'permission'])->group(function () {
    Route::post('/routes/validateForm', [RouteController::class, 'validateForm'])->name('routes.validateForm');
    Route::get('/routes/dataTable', [RouteController::class, 'dataTable'])->name('routes.dataTable');
    Route::get('/routes/{id}/enable', [RouteController::class, 'enable'])->name('routes.enable');
    Route::get('/routes/{id}/disable', [RouteController::class, 'disable'])->name('routes.disable');
    Route::get('/routes/{id}/logs', [RouteController::class, 'logs'])->name('routes.logs');
    Route::resource('routes', RouteController::class);
});

Route::middleware(['auth', 'permission'])->group(function () {
    Route::post('/menus/validateForm', [MenuController::class, 'validateForm'])->name('menus.validateForm');
    Route::get('/menus/dataTable', [MenuController::class, 'dataTable'])->name('menus.dataTable');
    Route::get('/menus/{id}/enable', [MenuController::class, 'enable'])->name('menus.enable');
    Route::get('/menus/{id}/disable', [MenuController::class, 'disable'])->name('menus.disable');
    Route::get('/menus/{id}/logs', [MenuController::class, 'logs'])->name('menus.logs');
    Route::resource('menus', MenuController::class);
});

Route::middleware(['auth', 'permission'])->group(function () {
    Route::post('/permissions/validateForm', [PermissionController::class, 'validateForm'])->name('permissions.validateForm');
    Route::get('/permissions/dataTable', [PermissionController::class, 'dataTable'])->name('permissions.dataTable');
    Route::get('/permissions/{id}/enable', [PermissionController::class, 'enable'])->name('permissions.enable');
    Route::get('/permissions/{id}/disable', [PermissionController::class, 'disable'])->name('permissions.disable');
    Route::get('/permissions/{id}/logs', [PermissionController::class, 'logs'])->name('permissions.logs');
    Route::resource('permissions', PermissionController::class);
});

Route::middleware(['auth', 'permission'])->group(function () {
    Route::get('/logs/events', [LogEventsController::class, 'index'])->name('logs.events.index');
    Route::get('/logs/events/dataTable', [LogEventsController::class, 'dataTable'])->name('logs.events.dataTable');
    Route::get('/logs/events/{id}', [LogEventsController::class, 'show'])->name('logs.events.show');
    Route::delete('/logs/events/{id}', [LogEventsController::class, 'destroy'])->name('logs.events.destroy');
    Route::get('/logs/events/dataTable/{modelName}/{modelId}', [LogEventsController::class, 'dataTableModel'])->name('logs.events.model.dataTable');

    Route::get('/logs/errors', [LogErrorsController::class, 'index'])->name('logs.errors.index');
    Route::get('/logs/errors/dataTable', [LogErrorsController::class, 'dataTable'])->name('logs.errors.dataTable');
    Route::get('/logs/errors/{id}', [LogErrorsController::class, 'show'])->name('logs.errors.show');
    Route::delete('/logs/errors/{id}', [LogErrorsController::class, 'destroy'])->name('logs.errors.destroy');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
require __DIR__ . '/maintainers.php';

