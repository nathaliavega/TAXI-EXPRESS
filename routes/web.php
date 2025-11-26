<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OperadoraController;
use App\Http\Controllers\ConductorController;
use App\Http\Controllers\TarifaDestinoController; // ⬅️ AGREGAR ESTA LÍNEA
use Illuminate\Support\Facades\Route;

// RUTAS PÚBLICAS
Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/nosotros', function () {
    return view('nosotros');
})->name('nosotros');

Route::get('/servicios', function () {
    return view('servicios');
})->name('servicios');

Route::get('/corporativo', function () {
    return view('corporativo');
})->name('corporativo');

// LOGIN
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});

// RUTAS PROTEGIDAS
Route::middleware(['auth'])->group(function () {
    
    // Logout
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('/logout', [LoginController::class, 'logout'])->name('logout.get');
    
    // Admin
    Route::middleware(['auth', 'checkRole:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/vehiculos', [AdminController::class, 'vehiculos'])->name('vehiculos');
        Route::get('/conductores', [AdminController::class, 'conductores'])->name('conductores');
        Route::get('/propietarios', [AdminController::class, 'propietarios'])->name('propietarios');
        Route::get('/alertas', [AdminController::class, 'alertas'])->name('alertas');
        Route::get('/solicitudes-cambio-ruta', [AdminController::class, 'solicitudesCambioRuta'])->name('solicitudes-cambio-ruta');
        Route::get('/mantenimiento-general', [AdminController::class, 'mantenimientoGeneral'])->name('mantenimiento-general');
        
        // Solicitudes - aprobar/rechazar
        Route::patch('/solicitudes/aprobar/{id}', [AdminController::class, 'aprobarSolicitud'])
            ->name('solicitudes.aprobar');
        Route::patch('/solicitudes/rechazar/{id}', [AdminController::class, 'rechazarSolicitud'])
            ->name('solicitudes.rechazar');
        
        // ⬇️ TARIFAS DESTINO - SOLO ESTAS DOS RUTAS
        Route::get('/tarifas-destino', [TarifaDestinoController::class, 'index'])->name('tarifas-destino');
        Route::post('/tarifas-destino', [TarifaDestinoController::class, 'store'])->name('tarifas-destino.store');
        Route::put('/tarifas-destino/{id}', [TarifaDestinoController::class, 'update'])->name('tarifas-destino.update');
        Route::delete('/tarifas-destino/{id}', [TarifaDestinoController::class, 'destroy'])->name('tarifas-destino.destroy');
        
        Route::get('/fix-estados', function() {
        DB::table('tarifas_destinos')
            ->whereNull('estado')
            ->orWhere('estado', '')
            ->update(['estado' => 'Activa']);
        
        return "Estados actualizados correctamente";
    });
    });
    
    // Operadora
    Route::middleware(['checkRole:operadora'])->prefix('operadora')->name('operadora.')->group(function () {
        Route::get('/dashboard', [OperadoraController::class, 'dashboard'])->name('dashboard');
        Route::get('/control-turnos', [OperadoraController::class, 'controlTurnos'])->name('control-turnos');
        Route::get('/turnos-obligatorios', [OperadoraController::class, 'turnosObligatorios'])->name('turnos-obligatorios');
        Route::get('/vehiculos', [OperadoraController::class, 'vehiculos'])->name('vehiculos');
        Route::get('/control-turnos', [App\Http\Controllers\Operadora\ControlTurnosController::class, 'index'])->name('control-turnos');
        Route::put('/control-turnos/{id}', [App\Http\Controllers\Operadora\ControlTurnosController::class, 'update'])->name('control-turnos.update');
        Route::delete('/control-turnos/{id}', [App\Http\Controllers\Operadora\ControlTurnosController::class, 'destroy'])->name('control-turnos.destroy');
        
    });
    
    // Conductores
    Route::middleware(['auth'])->prefix('conductor')->name('conductor.')->group(function () {
        Route::get('/dashboard', [ConductorController::class, 'dashboard'])->name('dashboard');
        Route::get('/mis-turnos', [ConductorController::class, 'misTurnos'])->name('mis-turnos');
        Route::get('/alertas', [ConductorController::class, 'alertas'])->name('alertas');
        Route::get('/conductores', [ConductorController::class, 'conductores'])->name('conductores');
        Route::get('/mantenimiento-general', [ConductorController::class, 'mantenimientoGeneral'])->name('mantenimiento-general');
        
        // Solicitudes de cambio de ruta
        Route::get('/solicitudes-cambio-ruta', [ConductorController::class, 'solicitudesCambioRuta'])
            ->name('solicitudes-cambio-ruta');
        Route::post('/solicitudes-cambio-ruta', [ConductorController::class, 'storeSolicitudCambioRuta'])
            ->name('solicitudes-cambio-ruta.store');
        
        Route::get('/tarifas', [ConductorController::class, 'tarifas'])->name('tarifas');
        Route::get('/vehiculos', [ConductorController::class, 'vehiculos'])->name('vehiculos');
    });
});