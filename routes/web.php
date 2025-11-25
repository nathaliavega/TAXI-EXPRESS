<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OperadoraController;
use App\Http\Controllers\ConductorController;
use Illuminate\Support\Facades\Route;

// 🔍 RUTA DE DIAGNÓSTICO TEMPORAL
Route::get('/test-auth', function() {
    $user = \App\Models\User::where('correo', 'elder.garcia@gmail.com')->first();
    
    if (!$user) {
        return response()->json([
            'error' => 'Usuario NO encontrado en tabla usuarios',
            'correo_buscado' => 'elder.garcia@gmail.com',
            'tabla' => 'usuarios'
        ]);
    }
    
    $passwordCheck = \Illuminate\Support\Facades\Hash::check('elder123', $user->contrasena);
    
    return response()->json([
        'usuario_existe' => true,
        'correo' => $user->correo,
        'nombre' => $user->nombre,
        'tiene_contrasena' => !empty($user->contrasena),
        'contrasena_hash' => substr($user->contrasena, 0, 30) . '...',
        'contrasena_encriptada' => str_starts_with($user->contrasena, '$2y$'),
        'usuario_activo' => (bool)$user->activo,
        'id_rol' => $user->id_rol,
        'password_correcto' => $passwordCheck,
        'tabla_usada' => 'usuarios'
    ]);
});

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
        Route::get('/tarifas-destino', [AdminController::class, 'tarifasDestino'])->name('tarifas-destino');
        Route::get('/mantenimiento-general', [AdminController::class, 'mantenimientoGeneral'])->name('mantenimiento-general');
    });
    
    // Operadora
    Route::middleware(['checkRole:operadora'])->prefix('operadora')->name('operadora.')->group(function () {
        Route::get('/dashboard', [OperadoraController::class, 'dashboard'])->name('dashboard');
        Route::get('/control-turnos', [OperadoraController::class, 'controlTurnos'])->name('control-turnos');
        Route::get('/turnos-obligatorios', [OperadoraController::class, 'turnosObligatorios'])->name('turnos-obligatorios');
        Route::get('/vehiculos', [OperadoraController::class, 'vehiculos'])->name('vehiculos');
    });
    
    // Conductores
    Route::middleware(['auth'])->prefix('conductor')->name('conductor.')->group(function () {
        Route::get('/dashboard', [ConductorController::class, 'dashboard'])->name('dashboard');
        Route::get('/mis-turnos', [ConductorController::class, 'misTurnos'])->name('mis-turnos');
        Route::get('/alertas', [ConductorController::class, 'alertas'])->name('alertas');
        Route::get('/conductores', [ConductorController::class, 'conductores'])->name('conductores');
        Route::get('/mantenimiento-general', [ConductorController::class, 'mantenimientoGeneral'])->name('mantenimiento-general');
        Route::get('/solicitudes-cambio-ruta', [ConductorController::class, 'solicitudesCambioRuta'])->name('solicitudes-cambio-ruta');
        Route::get('/tarifas', [ConductorController::class, 'tarifas'])->name('tarifas');
        Route::get('/vehiculos', [ConductorController::class, 'vehiculos'])->name('vehiculos');
    });
});