<?php

use App\Models\User;
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/Saisir', function () {
    return Inertia::render('Saisir');
})->middleware(['auth', 'verified'])->name('saisir');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// gestion Reclamation

Route::post('/Saisir', [\App\Http\Controllers\ReclamationController::class, 'store'])
    ->name('reclamation.store');

Route::post('/reclamations/updateEtat', [\App\Http\Controllers\ReclamationController::class, 'update'])
    ->name('reclamations.update');

//Gestion


Route::get('/users', [\App\Http\Controllers\UserController::class, 'index']
)->middleware(['auth', 'verified'])->name('gestion.users');

Route::get('/roles', [\App\Http\Controllers\RoleController::class, 'index']
)->middleware(['auth', 'verified'])->name('gestion.roles');

Route::get('/permissions', [\App\Http\Controllers\PermissionController::class, 'index']
)->middleware(['auth', 'verified'])->name('gestion.permissions');



// Reclamations vues

Route::get('/reclamations/tout', [\App\Http\Controllers\ReclamationController::class, 'tout']
)->middleware(['auth', 'verified'])->name('reclamations.tout');

Route::get('/reclamations/nonTraite', [\App\Http\Controllers\ReclamationController::class, 'nonTraite']
)->middleware(['auth', 'verified'])->name('reclamations.nontraite');

Route::get('/reclamations/fini', [\App\Http\Controllers\ReclamationController::class, 'fini']
)->middleware(['auth', 'verified'])->name('reclamations.fini');

Route::get('/reclamations/cloture', [\App\Http\Controllers\ReclamationController::class, 'cloture']
)->middleware(['auth', 'verified'])->name('reclamations.cloture');

Route::get('/reclamations/enCours', [\App\Http\Controllers\ReclamationController::class, 'enCours']
)->middleware(['auth', 'verified'])->name('reclamations.encours');

Route::get('/reclamations/nonTraiteRetard', [\App\Http\Controllers\ReclamationController::class, 'retard']
)->middleware(['auth', 'verified'])->name('reclamations.nontraiteretard');


//users gestion

Route::post('/users', [\App\Http\Controllers\UserController::class, 'store'])
    ->name('users.store');

Route::delete('/users/{users}/destroy', [\App\Http\Controllers\UserController::class, 'destroy'])
    ->name('users.destroy');

Route::get('/users/{users}/show', [\App\Http\Controllers\UserController::class, 'show'])
    ->name('users.show');

Route::get('/users/{users}/edit', [\App\Http\Controllers\UserController::class, 'edit'])
    ->name('users.edit');

Route::put('/users/{users}/update', [\App\Http\Controllers\UserController::class, 'update'])
    ->name('users.update');

Route::put('/users/{users}/attribute', [\App\Http\Controllers\UserController::class, 'Attribute'])
    ->name('users.attribute');


//permission gestion

Route::post('/permissions', [\App\Http\Controllers\PermissionController::class, 'store'])
    ->name('permissions.store');


//role gestion

Route::post('/roles', [\App\Http\Controllers\RoleController::class, 'store'])
    ->name('roles.store');

Route::put('/roles/{roles}/update', [\App\Http\Controllers\RoleController::class, 'update'])
    ->name('roles.update');

Route::delete('/roles/{roles}/destroy', [\App\Http\Controllers\RoleController::class, 'destroy'])
    ->name('roles.destroy');



require __DIR__ . '/auth.php';
