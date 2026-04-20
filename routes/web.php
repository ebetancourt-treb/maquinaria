<?php

use App\Http\Controllers\{DashboardController, MaquinariaController, BitacoraController, ImportController, UserController, ProfileController};
use App\Http\Controllers\Catalogos;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('maquinarias', MaquinariaController::class);
    Route::post('maquinarias/import', [ImportController::class, 'maquinarias'])->name('maquinarias.import');
    Route::get('maquinarias-export', [ImportController::class, 'exportar'])->name('maquinarias.export');
    Route::get('maquinarias/{maquinaria}/bitacora', [BitacoraController::class, 'timeline'])->name('maquinarias.bitacora');

    Route::prefix('bitacora')->name('bitacora.')->group(function () {
        Route::get('/', [BitacoraController::class, 'index'])->name('index');
        Route::get('/crear', [BitacoraController::class, 'create'])->name('create');
        Route::post('/', [BitacoraController::class, 'store'])->name('store');
        Route::get('/{registro}', [BitacoraController::class, 'show'])->name('show');
    });

    Route::prefix('catalogos')->name('catalogos.')->group(function () {
        Route::resource('tipos', Catalogos\TipoMaquinariaController::class);
        Route::resource('marcas', Catalogos\MarcaController::class);
        Route::resource('estatus', Catalogos\EstatusController::class);
        Route::resource('ubicaciones', Catalogos\UbicacionController::class);
        Route::resource('frentes', Catalogos\FrenteLaboralController::class);
    });

    Route::resource('usuarios', UserController::class)->except(['show']);

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
