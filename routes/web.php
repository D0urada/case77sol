<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ClientController;
use Illuminate\Support\Facades\Route;

/**
 * @OA\Info(
 *     title="API de Gestão de Clientes",
 *     version="1.0.0",
 *     description="API para gestão e administração de clientes",
 *     termsOfService="http://swagger.io/terms/",
 *     @OA\Contact(
 *         name="Julia Dourado",
 *         email="julia.dourado@example.com",
 *         url="http://seusite.com"
 *     ),
 *     @OA\License(
 *         name="MIT",
 *         url="https://opensource.org/licenses/MIT"
 *     )
 * )
 */

Route::prefix('admin')->name('admin.')->middleware(['auth', 'verified'])->group(function () {
    Route::view('/dashboard', 'admin.dashboard')->name('dashboard');

    require_once __DIR__ . '/modules/clients.php';
    require_once __DIR__ . '/modules/projects.php';
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::get('/', function () {
    return view('app');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');


