<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MaquinariaController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\Catalogos;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BitacoraController;


Route::redirect('/', '/dashboard');

Route::middleware(['auth', 'verified'])->group(function () {

    Route::prefix('bitacora')->name('bitacora.')->group(function () {
        Route::get('/',        [BitacoraController::class, 'index'])->name('index');
        Route::get('/crear',   [BitacoraController::class, 'create'])->name('create');
        Route::post('/',       [BitacoraController::class, 'store'])->name('store');
        Route::get('/{registro}', [BitacoraController::class, 'show'])->name('show');
    });


    // ── Dashboard ──
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    // ── Maquinaria ──
    Route::resource('maquinarias', MaquinariaController::class);
    Route::post('maquinarias/import', [ImportController::class, 'maquinarias'])
        ->name('maquinarias.import');
    Route::get('maquinarias/export/excel', [ImportController::class, 'exportar'])
        ->name('maquinarias.export');
    Route::get('maquinarias/{maquinaria}/bitacora', [BitacoraController::class, 'timeline'])
    ->name('maquinarias.bitacora');


    // ── Catálogos (CRUD) ──
    Route::prefix('catalogos')->name('catalogos.')->group(function () {
        Route::resource('tipos',       Catalogos\TipoMaquinariaController::class);
        Route::resource('marcas',      Catalogos\MarcaController::class);
        Route::resource('estatus',     Catalogos\EstatusController::class);
        Route::resource('ubicaciones', Catalogos\UbicacionController::class);
        Route::resource('frentes',     Catalogos\FrenteLaboralController::class);
    });

    // ── Usuarios ──
    Route::resource('usuarios', UserController::class);
});

require __DIR__ . '/auth.php';