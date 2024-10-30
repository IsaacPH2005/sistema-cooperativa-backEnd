<?php

use App\Http\Controllers\AdministracionController;
use App\Http\Controllers\AgenciasController;
use App\Http\Controllers\api\CarruselImagensController;
use App\Http\Controllers\CoeficienteAdecuacionPatrimonialController;
use App\Http\Controllers\ComunicadosController;
use App\Http\Controllers\ContactanosController;
use App\Http\Controllers\CreditosController;
use App\Http\Controllers\DictamenesAuditoriasController;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\EstadosFinancierosController;
use App\Http\Controllers\ImagensInmueblesController;
use App\Http\Controllers\InmueblesController;
use App\Http\Controllers\MemoriasInstitucionalController;
use App\Http\Controllers\PaginaBannersController;
use App\Http\Controllers\PaginasController;
use App\Http\Controllers\PrincipiosController;
use App\Http\Controllers\PrincipiosTextController;
use App\Http\Controllers\ResponsabilidadSocialController;
use App\Http\Controllers\ServiciosBasicosController;
use App\Http\Controllers\TransferenciasElectronicasController;
use App\Http\Controllers\VigilanciaController;
use App\Models\EducacionFinancieras;
use App\Models\LicitacionPublicas;
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

//Principios
Route::get('/principios', [PrincipiosController ::class, 'index']);
Route::get('/principios/{id}', [PrincipiosController ::class, 'show']);
Route::post('/principios-nuevo', [PrincipiosController ::class, 'store']);
Route::delete('/principios/{id}', [PrincipiosController ::class, 'destroy']);
Route::put('/principios/{id}', [PrincipiosController::class, 'update']);
Route::get('/principios-activos', [PrincipiosController ::class, 'indexActivos']);

//Principios text
Route::post('/principios-text', [PrincipiosTextController::class, 'edicionPrincipiosText']);
Route::get('/principios-text', [PrincipiosTextController::class, 'lecturaitem']);

// Obtener todos los inmuebles
Route::get('/inmuebles', [InmueblesController::class, 'index']);
// Obtener un inmueble específico por ID
Route::get('/inmuebles/{id}', [InmueblesController::class, 'show']);
// Almacenar un nuevo inmueble
Route::post('/inmuebles-nuevo', [InmueblesController::class, 'store']);
// Actualizar un inmueble existente por ID
Route::put('/inmuebles/{id}', [InmueblesController::class, 'update']);
// Eliminar un inmueble por ID
Route::delete('/inmuebles/{id}', [InmueblesController::class, 'destroy']);
Route::delete('/img-inmuebles/{id}', [InmueblesController::class, 'deleteImage']);
Route::get('/inmuebles-activos', [InmueblesController::class, 'indexActivos']);
// Route::get('/inmuebles
Route::get('/img-inmuebles', [ImagensInmueblesController::class, 'index']);
Route::post('/img-inmuebles-nuevo', [ImagensInmueblesController::class, 'store']);

//Agenecias
Route::get('/agencias', [AgenciasController::class, 'index']);
Route::post('/agencias-nuevo', [AgenciasController::class, 'store']);
Route::put('/agencias/{id}', [AgenciasController::class, 'update']);
Route::get('/agencias/{id}', [AgenciasController::class, 'show']);
Route::delete('/agencias/{id}', [AgenciasController::class, 'destroy']);
Route::get('/agencias-activos', [AgenciasController::class, 'indexActivos']);

//Creditos
Route::get('/creditos', [CreditosController::class, 'index']);
Route::post('/creditos-nuevo', [CreditosController::class,'store']);
Route::put('/creditos/{id}', [CreditosController::class, 'update']);
Route::get('/creditos/{id}', [CreditosController::class,'show']);
Route::delete('/creditos/{id}', [CreditosController::class, 'destroy']);
Route::get('/creditos-activos', [CreditosController::class, 'indexActivos']);

//Comunicados
Route::get('/comunicados', [ComunicadosController::class, 'index']);
Route::post('/comunicados-nuevo', [ComunicadosController::class,'store']);
Route::put('/comunicados/{id}', [ComunicadosController::class, 'update']);
Route::get('/comunicados/{id}', [ComunicadosController::class,'show']);
Route::delete('/comunicados/{id}', [ComunicadosController::class, 'destroy']);
Route::get('/comunicados-activos', [ComunicadosController::class, 'indexActivos']);
//ResponsabilidadSocialController
Route::get('/responsabilidad-social', [ResponsabilidadSocialController::class, 'index']);
Route::post('/responsabilidad-social-nuevo', [ResponsabilidadSocialController::class,'store']);
Route::put('/responsabilidad-social/{id}', [ResponsabilidadSocialController::class, 'update']);
Route::get('/responsabilidad-social/{id}', [ResponsabilidadSocialController::class,'show']);
Route::delete('/responsabilidad-social/{id}', [ResponsabilidadSocialController::class, 'destroy']);
Route::get('/responsabilidad-social-activos', [ResponsabilidadSocialController::class, 'indexActivos']);

//LicitacionPublicas
Route::get('/licitacion-publica', [LicitacionPublicas::class, 'index']);
Route::post('/licitacion-publica-nuevo', [LicitacionPublicas::class,'store']);
Route::put('/licitacion-publica/{id}', [LicitacionPublicas::class, 'update']);
Route::get('/licitacion-publica/{id}', [LicitacionPublicas::class,'show']);
Route::delete('/licitacion-publica/{id}', [LicitacionPublicas::class, 'destroy']);
Route::get('/licitacion-publica-activos', [LicitacionPublicas::class, 'indexActivos']);

//ResponsabilidadSocialController
Route::get('/educacion-financiera', [EducacionFinancieras::class, 'index']);
Route::post('/educacion-financiera-nuevo', [EducacionFinancieras::class,'store']);
Route::put('/educacion-financiera/{id}', [EducacionFinancieras::class, 'update']);
Route::get('/educacion-financiera/{id}', [EducacionFinancieras::class,'show']);
Route::delete('/educacion-financiera/{id}', [EducacionFinancieras::class, 'destroy']);
Route::get('/educacion-financiera-activos', [EducacionFinancieras::class, 'indexActivos']);

Route::post('/empresa', [EmpresaController::class, 'edicionWebEmpresas']);
Route::get('/empresa', [EmpresaController::class, 'lecturaEmpresa']);