<?php

use App\Http\Controllers\AdministracionController;
use App\Http\Controllers\api\CarruselImagensController;
use App\Http\Controllers\CoeficienteAdecuacionPatrimonialController;
use App\Http\Controllers\ContactanosController;
use App\Http\Controllers\DictamenesAuditoriasController;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\EstadosFinancierosController;
use App\Http\Controllers\MemoriasInstitucionalController;
use App\Http\Controllers\PaginaBannersController;
use App\Http\Controllers\PaginasController;
use App\Http\Controllers\ServiciosBasicosController;
use App\Http\Controllers\ServiciosController;
use App\Http\Controllers\TransferenciasElectronicasController;
use App\Http\Controllers\VigilanciaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/carrusel-imagenes', [CarruselImagensController::class, 'index']);
Route::post('/carrusel-imagenes-nuevo', [CarruselImagensController::class, 'store']);
Route::get('/carrusel-imagenes/{id}', [CarruselImagensController::class, 'show']);
Route::put('/carrusel-imagenes/{id}',[CarruselImagensController::class, 'update']);
Route::delete('/carrusel-imagenes/{id}', [CarruselImagensController::class, 'destroy']);
Route::get('/carruseles-activos', [CarruselImagensController::class, 'imagenesActivas']);

Route::get('/pagina-imagenes', [PaginaBannersController::class, 'index']);
Route::get('/pagina-imagenes/{id}', [PaginaBannersController::class, 'show']);
Route::put('/pagina-imagenes/{id}', [PaginaBannersController::class, 'update']);
Route::post('/pagina-imagenes-nuevo', [PaginaBannersController::class, 'store']);
Route::delete('/paginas-imagenes/{id}', [PaginaBannersController::class, 'destroy']);
Route::get('/pagina-imagenes-activas/{nombre}', [PaginaBannersController::class, 'paginasBannersActivos']);

Route::get('/paginas', [PaginasController::class, 'index']);
Route::get('/paginas-nombre', [PaginasController::class, 'showByName']);


//Contactanos
Route::get('/contacto', [ContactanosController ::class, 'index']);
Route::post('/contacto-nuevo', [ContactanosController ::class, 'store']);
Route::post('/contactanos/{id}/email', [ContactanosController ::class, 'sendEmail']);
Route::delete('/contacto/{id}', [ContactanosController ::class, 'destroy']);
Route::get('/contactos-total', [ContactanosController ::class, 'countContactanos']);

//Memoria institucional
Route::get('/memoria-institucional', [MemoriasInstitucionalController ::class, 'index']);
Route::get('/memoria-institucional/{id}', [MemoriasInstitucionalController ::class, 'show']);
Route::post('/memoria-institucional-nuevo', [MemoriasInstitucionalController ::class, 'store']);
Route::delete('/memoria-institucional/{id}', [MemoriasInstitucionalController ::class, 'destroy']);
Route::put('/memoria-institucional/{id}', [MemoriasInstitucionalController::class, 'update']);
Route::get('/memoria-institucional-activos', [MemoriasInstitucionalController ::class, 'indexActivos']);

//dictamenes auditorias
Route::get('/dictamenes-auditorias', [DictamenesAuditoriasController ::class, 'index']);
Route::get('/dictamenes-auditorias/{id}', [DictamenesAuditoriasController ::class, 'show']);
Route::post('/dictamenes-auditorias-nuevo', [DictamenesAuditoriasController ::class, 'store']);
Route::delete('/dictamenes-auditorias/{id}', [DictamenesAuditoriasController ::class, 'destroy']);
Route::put('/dictamenes-auditorias/{id}', [DictamenesAuditoriasController::class, 'update']);
Route::get('/dictamenes-auditorias-activos', [DictamenesAuditoriasController ::class, 'indexActivos']);

//Estados financieros
Route::get('/estados-financieros', [EstadosFinancierosController ::class, 'index']);
Route::get('/estados-financieros/{id}', [EstadosFinancierosController ::class, 'show']);
Route::post('/estados-financieros-nuevo', [EstadosFinancierosController ::class, 'store']);
Route::delete('/estados-financieros/{id}', [EstadosFinancierosController ::class, 'destroy']);
Route::put('/estados-financieros/{id}', [EstadosFinancierosController::class, 'update']);
Route::get('/estados-financieros-activos', [EstadosFinancierosController ::class, 'indexActivos']);

//Coeficientes adecuacion patrimoniales
Route::get('/coeficientes-adecuacion-patrimoniales', [CoeficienteAdecuacionPatrimonialController ::class, 'index']);
Route::get('/coeficientes-adecuacion-patrimoniales/{id}', [CoeficienteAdecuacionPatrimonialController ::class, 'show']);
Route::post('/coeficientes-adecuacion-patrimoniales-nuevo', [CoeficienteAdecuacionPatrimonialController ::class, 'store']);
Route::delete('/coeficientes-adecuacion-patrimoniales/{id}', [CoeficienteAdecuacionPatrimonialController ::class, 'destroy']);
Route::put('/coeficientes-adecuacion-patrimoniales/{id}', [CoeficienteAdecuacionPatrimonialController::class, 'update']);
Route::get('/coeficientes-adecuacion-patrimoniales-activos', [CoeficienteAdecuacionPatrimonialController ::class, 'indexActivos']);

//ADministracion
Route::get('/administracion-personal', [AdministracionController ::class, 'index']);
Route::get('/administracion-personal/{id}', [AdministracionController ::class, 'show']);
Route::post('/administracion-personal-nuevo', [AdministracionController ::class, 'store']);
Route::delete('/administracion-personal/{id}', [AdministracionController ::class, 'destroy']);
Route::put('/administracion-personal/{id}', [AdministracionController::class, 'update']);
Route::get('/administracion-personal-activos', [AdministracionController ::class, 'indexActivos']);

//Vigilancia
Route::get('/vigilancia-personal', [VigilanciaController ::class, 'index']);
Route::get('/vigilancia-personal/{id}', [VigilanciaController ::class, 'show']);
Route::post('/vigilancia-personal-nuevo', [VigilanciaController ::class, 'store']);
Route::delete('/vigilancia-personal/{id}', [VigilanciaController ::class, 'destroy']);
Route::put('/vigilancia-personal/{id}', [VigilanciaController::class, 'update']);
Route::get('/vigilancia-personal-activos', [VigilanciaController ::class, 'indexActivos']);

//Servicios Basicos
Route::get('/servicios-basicos', [ServiciosBasicosController ::class, 'index']);
Route::get('/servicios-basicos/{id}', [ServiciosBasicosController ::class, 'show']);
Route::post('/servicios-basicos-nuevo', [ServiciosBasicosController ::class, 'store']);
Route::delete('/servicios-basicos/{id}', [ServiciosBasicosController ::class, 'destroy']);
Route::put('/servicios-basicos/{id}', [ServiciosBasicosController::class, 'update']);
Route::get('/servicios-basicos-activos', [ServiciosBasicosController ::class, 'indexActivos']);

//Transferencias electronicas
Route::get('/transferencias-electronicas', [TransferenciasElectronicasController ::class, 'index']);
Route::get('/transferencias-electronicas/{id}', [TransferenciasElectronicasController ::class, 'show']);
Route::post('/transferencias-electronicas-nuevo', [TransferenciasElectronicasController ::class, 'store']);
Route::delete('/transferencias-electronicas/{id}', [TransferenciasElectronicasController ::class, 'destroy']);
Route::put('/transferencias-electronicas/{id}', [TransferenciasElectronicasController::class, 'update']);
Route::get('/transferencias-electronicas-activos', [TransferenciasElectronicasController ::class, 'indexActivos']);

Route::post('/empresa', [EmpresaController::class, 'edicionWebEmpresas']);
Route::get('/empresa', [EmpresaController::class, 'lecturaEmpresa']);