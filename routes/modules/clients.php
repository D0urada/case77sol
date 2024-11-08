<?php

// routes/modules/clients.php

use App\Http\Controllers\Admin\ClientController;
use Illuminate\Support\Facades\Route;

Route::prefix('clients')->name('clients.')->group(function () {
    Route::get('/', [ClientController::class, 'index'])->name('index');
    Route::post('/', [ClientController::class, 'store'])->name('store');
    Route::get('/{client}/show', [ClientController::class, 'show'])->name('show');
    Route::put('/{client}', [ClientController::class, 'update'])->name('update');
    Route::delete('/{client}', [ClientController::class, 'destroy'])->name('destroy');
    Route::get('/search', [ClientController::class, 'search'])->name('search');
});


