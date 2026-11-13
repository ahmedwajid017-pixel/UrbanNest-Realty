<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\PropertyController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// All three roles can view property listings and details
// All three roles can view property listings and details
// All three roles can view property listings and details
Route::middleware(['auth', 'role:Owner,Agent,Staff'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/properties', [PropertyController::class, 'index'])
            ->middleware('can:viewAny,App\Models\Property')
            ->name('properties.index');

        Route::get('/properties/{property}', [PropertyController::class, 'show'])
    ->whereNumber('property')
    ->middleware('can:view,property')
    ->name('properties.show');
    });

// Only Owner and Agent can access property management routes
Route::middleware(['auth', 'role:Owner,Agent'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/properties/create', [PropertyController::class, 'create'])
            ->middleware('can:create,App\Models\Property')
            ->name('properties.create');

        Route::post('/properties', [PropertyController::class, 'store'])
            ->middleware('can:create,App\Models\Property')
            ->name('properties.store');

        Route::get('/properties/{property}/edit', [PropertyController::class, 'edit'])
            ->middleware('can:update,property')
            ->name('properties.edit');

        Route::match(['put', 'patch'], '/properties/{property}', [PropertyController::class, 'update'])
            ->middleware('can:update,property')
            ->name('properties.update');

        Route::delete('/properties/{property}', [PropertyController::class, 'destroy'])
            ->middleware('can:delete,property')
            ->name('properties.destroy');
    });

require __DIR__.'/auth.php';
