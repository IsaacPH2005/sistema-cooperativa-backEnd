<?php

use App\Http\Controllers\AdministracionController;
use App\Http\Controllers\AgenciasController;
use App\Http\Controllers\api\CarruselImagensController;
use App\Http\Controllers\api\CuentaDeAhorro\CaracteristicasController;
use App\Http\Controllers\api\CuentaDeAhorro\CuentadeAhorroController;
use App\Http\Controllers\api\CuentaDeAhorro\RequisitosController;
use App\Http\Controllers\api\DPF\BeneficiosDpfController;
use App\Http\Controllers\api\DPF\CaracteristicasDpfController;
use App\Http\Controllers\api\DPF\RequisitosDpfController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BeneficiosDeSerSocioWeb;
use App\Http\Controllers\CodigoEticaController;
use App\Http\Controllers\CoeficienteAdecuacionPatrimonialController;
use App\Http\Controllers\ComunicadosController;
use App\Http\Controllers\ContactanosController;
use App\Http\Controllers\CooperativaInfoController;
use App\Http\Controllers\CreditosController;
use App\Http\Controllers\DictamenesAuditoriasController;
use App\Http\Controllers\DpfCardController;
use App\Http\Controllers\EducacionFinancieraController;
use App\Http\Controllers\EducacionFinancierasImg;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\EstadosFinancierosController;
use App\Http\Controllers\ImagensInmueblesController;
use App\Http\Controllers\ImagenValoresController;
use App\Http\Controllers\IndicadoresFinancierosController;
use App\Http\Controllers\InformacionImportanteController;
use App\Http\Controllers\InfoSerSocioController;
use App\Http\Controllers\InmueblesController;
use App\Http\Controllers\LicitacionPublicasController;
use App\Http\Controllers\MemoriasInstitucionalController;
use App\Http\Controllers\PaginaBannersController;
use App\Http\Controllers\PaginasController;
use App\Http\Controllers\PdfCalificacionDeRiesgoController;
use App\Http\Controllers\PrincipiosController;
use App\Http\Controllers\PrincipiosTextController;
use App\Http\Controllers\PuntoDeReclamoController;
use App\Http\Controllers\RedesSocialesController;
use App\Http\Controllers\RequerimientosSerSocioController;
use App\Http\Controllers\ResponsabilidadSocialController;
use App\Http\Controllers\SeguridadTipsController;
use App\Http\Controllers\ServiciosBasicosController;
use App\Http\Controllers\TablaCalificacionDeRiesgoController;
use App\Http\Controllers\TabladpfController;
use App\Http\Controllers\TasasYTarifaController;
use App\Http\Controllers\TestimoniosController;
use App\Http\Controllers\TransferenciasElectronicasController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ValoresFundamentalesController;
use App\Http\Controllers\VideoEducacionFinancieraController;
use App\Http\Controllers\VideosRecomendacionesSeguridadController;
use App\Http\Controllers\VigilanciaController;
use App\Models\CaracteristicasDpf;
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

Route::group(["middleware" => "auth:sanctum"], function () {
  Route::post('/logout', [AuthController::class, 'logout']);
  //cooperativa
  Route::post('/empresa', [EmpresaController::class, 'edicionWebEmpresas']);
  Route::get('/empresa', [EmpresaController::class, 'lecturaEmpresa2']);

  //Carrusel
  Route::get('/carrusel-imagenes', [CarruselImagensController::class, 'index']);
  Route::post('/carrusel-imagenes-nuevo', [CarruselImagensController::class, 'store']);
  Route::get('/carrusel-imagenes/{id}', [CarruselImagensController::class, 'show']);
  Route::put('/carrusel-imagenes/{id}', [CarruselImagensController::class, 'update']);
  Route::delete('/carrusel-imagenes/{id}', [CarruselImagensController::class, 'destroy']);
  //Banners
  Route::get('/pagina-imagenes', [PaginaBannersController::class, 'index']);
  Route::get('/pagina-imagenes/{id}', [PaginaBannersController::class, 'show']);
  Route::put('/pagina-imagenes/{id}', [PaginaBannersController::class, 'update']);
  Route::post('/pagina-imagenes-nuevo', [PaginaBannersController::class, 'store']);
  Route::delete('/paginas-imagenes/{id}', [PaginaBannersController::class, 'destroy']);
  //Contactanos
  Route::get('/contacto', [ContactanosController::class, 'index']);
  Route::post('/contactanos/{id}/email', [ContactanosController::class, 'sendEmail']);
  Route::delete('/contacto/{id}', [ContactanosController::class, 'destroy']);
  Route::get('/contactos-total', [ContactanosController::class, 'countContactanos']);
  Route::get('/contactos/pdf', [ContactanosController::class, 'generatePDF']); // Ruta para generar PDF
  Route::get('/contactos/excel', [ContactanosController::class, 'generateExcel']); // Ruta para generar excel
  //Memoria institucional
  Route::get('/memoria-institucional', [MemoriasInstitucionalController::class, 'index']);
  Route::get('/memoria-institucional/{id}', [MemoriasInstitucionalController::class, 'show']);
  Route::post('/memoria-institucional-nuevo', [MemoriasInstitucionalController::class, 'store']);
  Route::delete('/memoria-institucional/{id}', [MemoriasInstitucionalController::class, 'destroy']);
  Route::put('/memoria-institucional/{id}', [MemoriasInstitucionalController::class, 'update']);
  //dictamenes auditorias
  Route::get('/dictamenes-auditorias', [DictamenesAuditoriasController::class, 'index']);
  Route::get('/dictamenes-auditorias/{id}', [DictamenesAuditoriasController::class, 'show']);
  Route::post('/dictamenes-auditorias-nuevo', [DictamenesAuditoriasController::class, 'store']);
  Route::delete('/dictamenes-auditorias/{id}', [DictamenesAuditoriasController::class, 'destroy']);
  Route::put('/dictamenes-auditorias/{id}', [DictamenesAuditoriasController::class, 'update']);
  //Estados financieros
  Route::get('/estados-financieros', [EstadosFinancierosController::class, 'index']);
  Route::get('/estados-financieros/{id}', [EstadosFinancierosController::class, 'show']);
  Route::post('/estados-financieros-nuevo', [EstadosFinancierosController::class, 'store']);
  Route::delete('/estados-financieros/{id}', [EstadosFinancierosController::class, 'destroy']);
  Route::put('/estados-financieros/{id}', [EstadosFinancierosController::class, 'update']);
  //Coeficientes adecuacion patrimoniales
  Route::get('/coeficientes-adecuacion-patrimoniales', [CoeficienteAdecuacionPatrimonialController::class, 'index']);
  Route::get('/coeficientes-adecuacion-patrimoniales/{id}', [CoeficienteAdecuacionPatrimonialController::class, 'show']);
  Route::post('/coeficientes-adecuacion-patrimoniales-nuevo', [CoeficienteAdecuacionPatrimonialController::class, 'store']);
  Route::delete('/coeficientes-adecuacion-patrimoniales/{id}', [CoeficienteAdecuacionPatrimonialController::class, 'destroy']);
  Route::put('/coeficientes-adecuacion-patrimoniales/{id}', [CoeficienteAdecuacionPatrimonialController::class, 'update']);
  //ADministracion
  Route::get('/administracion-personal', [AdministracionController::class, 'index']);
  Route::get('/administracion-personal/{id}', [AdministracionController::class, 'show']);
  Route::post('/administracion-personal-nuevo', [AdministracionController::class, 'store']);
  Route::delete('/administracion-personal/{id}', [AdministracionController::class, 'destroy']);
  Route::put('/administracion-personal/{id}', [AdministracionController::class, 'update']);
  //Vigilancia
  Route::get('/vigilancia-personal', [VigilanciaController::class, 'index']);
  Route::get('/vigilancia-personal/{id}', [VigilanciaController::class, 'show']);
  Route::post('/vigilancia-personal-nuevo', [VigilanciaController::class, 'store']);
  Route::delete('/vigilancia-personal/{id}', [VigilanciaController::class, 'destroy']);
  Route::put('/vigilancia-personal/{id}', [VigilanciaController::class, 'update']);
  //Servicios Basicos
  Route::get('/servicios-basicos', [ServiciosBasicosController::class, 'index']);
  Route::get('/servicios-basicos/{id}', [ServiciosBasicosController::class, 'show']);
  Route::post('/servicios-basicos-nuevo', [ServiciosBasicosController::class, 'store']);
  Route::delete('/servicios-basicos/{id}', [ServiciosBasicosController::class, 'destroy']);
  Route::put('/servicios-basicos/{id}', [ServiciosBasicosController::class, 'update']);
  //Transferencias electronicas
  Route::get('/transferencias-electronicas', [TransferenciasElectronicasController::class, 'index']);
  Route::get('/transferencias-electronicas/{id}', [TransferenciasElectronicasController::class, 'show']);
  Route::post('/transferencias-electronicas-nuevo', [TransferenciasElectronicasController::class, 'store']);
  Route::delete('/transferencias-electronicas/{id}', [TransferenciasElectronicasController::class, 'destroy']);
  Route::put('/transferencias-electronicas/{id}', [TransferenciasElectronicasController::class, 'update']);
  //Principios
  Route::get('/principios', [PrincipiosController::class, 'index']);
  Route::get('/principios/{id}', [PrincipiosController::class, 'show']);
  Route::post('/principios-nuevo', [PrincipiosController::class, 'store']);
  Route::delete('/principios/{id}', [PrincipiosController::class, 'destroy']);
  Route::put('/principios/{id}', [PrincipiosController::class, 'update']);
  //Principios text
  Route::post('/principios-text', [PrincipiosTextController::class, 'edicionPrincipiosText']);

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
  Route::get('/img-inmuebles', [ImagensInmueblesController::class, 'index']);
  Route::post('/img-inmuebles-nuevo', [ImagensInmueblesController::class, 'store']);
  //Agenecias
  Route::get('/agencias', [AgenciasController::class, 'index']);
  Route::post('/agencias-nuevo', [AgenciasController::class, 'store']);
  Route::put('/agencias/{id}', [AgenciasController::class, 'update']);
  Route::get('/agencias/{id}', [AgenciasController::class, 'show']);
  Route::delete('/agencias/{id}', [AgenciasController::class, 'destroy']);
  //Creditos
  Route::get('/creditos', [CreditosController::class, 'index']);
  Route::post('/creditos-nuevo', [CreditosController::class, 'store']);
  Route::put('/creditos/{id}', [CreditosController::class, 'update']);
  Route::get('/creditos/{id}', [CreditosController::class, 'show']);
  Route::delete('/creditos/{id}', [CreditosController::class, 'destroy']);
  //Comunicados
  Route::get('/comunicados', [ComunicadosController::class, 'index']);
  Route::post('/comunicados-nuevo', [ComunicadosController::class, 'store']);
  Route::put('/comunicados/{id}', [ComunicadosController::class, 'update']);
  Route::get('/comunicados/{id}', [ComunicadosController::class, 'show']);
  Route::delete('/comunicados/{id}', [ComunicadosController::class, 'destroy']);
  //ResponsabilidadSocialController
  Route::get('/responsabilidad-social', [ResponsabilidadSocialController::class, 'index']);
  Route::post('/responsabilidad-social-nuevo', [ResponsabilidadSocialController::class, 'store']);
  Route::put('/responsabilidad-social/{id}', [ResponsabilidadSocialController::class, 'update']);
  Route::get('/responsabilidad-social/{id}', [ResponsabilidadSocialController::class, 'show']);
  Route::delete('/responsabilidad-social/{id}', [ResponsabilidadSocialController::class, 'destroy']);
  //LicitacionPublicas
  Route::get('/licitacion-publica', [LicitacionPublicasController::class, 'index']);
  Route::post('/licitacion-publica-nuevo', [LicitacionPublicasController::class, 'store']);
  Route::put('/licitacion-publica/{id}', [LicitacionPublicasController::class, 'update']);
  Route::get('/licitacion-publica/{id}', [LicitacionPublicasController::class, 'show']);
  Route::delete('/licitacion-publica/{id}', [LicitacionPublicasController::class, 'destroy']);
  //ResponsabilidadSocialController
  Route::get('/educacion-financiera', [EducacionFinancieraController::class, 'index']);
  Route::post('/educacion-financiera-nuevo', [EducacionFinancieraController::class, 'store']);
  Route::put('/educacion-financiera/{id}', [EducacionFinancieraController::class, 'update']);
  Route::get('/educacion-financiera/{id}', [EducacionFinancieraController::class, 'show']);
  Route::delete('/educacion-financiera/{id}', [EducacionFinancieraController::class, 'destroy']);
  // ************* Redes Sociales **********
  Route::get('/redes-sociales', [RedesSocialesController::class, 'index']);
  Route::post('/redes-sociales', [RedesSocialesController::class, 'store']);
  Route::get('/redes-sociales/{id}', [RedesSocialesController::class, 'show']);
  Route::put('/redes-sociales/{id}', [RedesSocialesController::class, 'update']);
  Route::delete('/redes-sociales/{id}', [RedesSocialesController::class, 'destroy']);
  //Punto de reclamo
  Route::get('/punto-de-reclamo', [PuntoDeReclamoController::class, 'index']);
  Route::get('/contactos-total', [PuntoDeReclamoController::class, 'countContactanos']);
  Route::get('/punto-de-reclamo/pdf', [PuntoDeReclamoController::class, 'generatePDF']); // Ruta para generar PDF
  Route::get('/punto-de-reclamo/excel', [PuntoDeReclamoController::class, 'generateExcel']); // Ruta para generar excel
  // ************* TESTIMONIOS  **********
  Route::get('/testimonios', [TestimoniosController::class, 'index']);
  Route::post('/testimonios-nuevo', [TestimoniosController::class, 'store']);
  Route::get('/testimonios/{id}', [TestimoniosController::class, 'show']);
  Route::put('/testimonios/{id}', [TestimoniosController::class, 'update']);
  Route::delete('/testimonios/{id}', [TestimoniosController::class, 'destroy']);
  // ************* INDICADORES FINANCIEROS  **********
  Route::get('indicadores-financieros', [IndicadoresFinancierosController::class, 'index']);
  Route::post('indicadores-financieros-nuevo', [IndicadoresFinancierosController::class, 'store']);
  Route::get('indicadores-financieros/{id}', [IndicadoresFinancierosController::class, 'show']);
  Route::put('indicadores-financieros/{id}', [IndicadoresFinancierosController::class, 'update']);
  Route::delete('indicadores-financieros/{id}', [IndicadoresFinancierosController::class, 'destroy']);
  // ************* educacion financieras imagenes  **********
  Route::get('educacion-financieras-img', [EducacionFinancierasImg::class, 'index']);
  Route::post('educacion-financieras-img-nuevo', [EducacionFinancierasImg::class, 'store']);
  Route::get('educacion-financieras-img/{id}', [EducacionFinancierasImg::class, 'show']);
  Route::put('educacion-financieras-img/{id}', [EducacionFinancierasImg::class, 'update']);
  Route::delete('educacion-financieras-img/{id}', [EducacionFinancierasImg::class, 'destroy']);
  // ************* PAGINAS DE USUARIOS  **********
  Route::get('/users', [UserController::class, 'index']);
  Route::put('/user-update', [UserController::class, 'update']);
  Route::get('/users/activos', [UserController::class, 'activeUsers']);

  // ************* DPF **********
  Route::get('dpf', [TabladpfController::class, 'index']);
  Route::post('dpf-nuevo', [TabladpfController::class, 'store']);
  Route::get('dpf/{id}', [TabladpfController::class, 'show']);
  Route::put('dpf/{id}', [TabladpfController::class, 'update']);
  Route::delete('dpf/{id}', [TabladpfController::class, 'destroy']);

  // ************* caracteristicas cuenta de ahorro **********
  Route::get('caracteristicas-cuenta-de-ahorro', [CaracteristicasController::class, 'index']);
  Route::post('caracteristicas-cuenta-de-ahorro-nuevo', [CaracteristicasController::class, 'store']);
  Route::get('caracteristicas-cuenta-de-ahorro/{id}', [CaracteristicasController::class, 'show']);
  Route::put('caracteristicas-cuenta-de-ahorro/{id}', [CaracteristicasController::class, 'update']);
  Route::delete('caracteristicas-cuenta-de-ahorro/{id}', [CaracteristicasController::class, 'destroy']);


  // ************* requisitos cuenta de ahorro **********
  Route::get('requisitos-cuenta-de-ahorro', [RequisitosController::class, 'index']);
  Route::post('requisitos-cuenta-de-ahorro-nuevo', [RequisitosController::class, 'store']);
  Route::get('requisitos-cuenta-de-ahorro/{id}', [RequisitosController::class, 'show']);
  Route::put('requisitos-cuenta-de-ahorro/{id}', [RequisitosController::class, 'update']);
  Route::delete('requisitos-cuenta-de-ahorro/{id}', [RequisitosController::class, 'destroy']);

  // Cuenta de ahorro
  Route::get('/cuenta-de-ahorro', [CuentadeAhorroController::class, 'index']);
  Route::post('/cuenta-de-ahorro/edicion', [CuentadeAhorroController::class, 'update']);


  // ************* caracteristicas dpf **********
  Route::get('caracteristicas-dpf', [CaracteristicasDpfController::class, 'index']);
  Route::post('caracteristicas-dpf-nuevo', [CaracteristicasDpfController::class, 'store']);
  Route::get('caracteristicas-dpf/{id}', [CaracteristicasDpfController::class, 'show']);
  Route::put('caracteristicas-dpf/{id}', [CaracteristicasDpfController::class, 'update']);
  Route::delete('caracteristicas-dpf/{id}', [CaracteristicasDpfController::class, 'destroy']);
  // ************* beneficios dpf **********
  Route::get('beneficios-dpf', [BeneficiosDpfController::class, 'index']);
  Route::post('beneficios-dpf-nuevo', [BeneficiosDpfController::class, 'store']);
  Route::get('beneficios-dpf/{id}', [BeneficiosDpfController::class, 'show']);
  Route::put('beneficios-dpf/{id}', [BeneficiosDpfController::class, 'update']);
  Route::delete('beneficios-dpf/{id}', [BeneficiosDpfController::class, 'destroy']);
  // ************* requisitos dpf **********
  Route::get('requisitos-dpf', [RequisitosDpfController::class, 'index']);
  Route::post('requisitos-dpf-nuevo', [RequisitosDpfController::class, 'store']);
  Route::get('requisitos-dpf/{id}', [RequisitosDpfController::class, 'show']);
  Route::put('requisitos-dpf/{id}', [RequisitosDpfController::class, 'update']);
  Route::delete('requisitos-dpf/{id}', [RequisitosDpfController::class, 'destroy']);
  // ************* recomendaciones de seguridad  **********
  Route::get('recomendaciones-de-seguridad', [SeguridadTipsController::class, 'index']);
  Route::post('recomendaciones-de-seguridad-nuevo', [SeguridadTipsController::class, 'store']);
  Route::get('recomendaciones-de-seguridad/{id}', [SeguridadTipsController::class, 'show']);
  Route::put('recomendaciones-de-seguridad/{id}', [SeguridadTipsController::class, 'update']);
  Route::delete('recomendaciones-de-seguridad/{id}', [SeguridadTipsController::class, 'destroy']);
  // *************  educacion financiera videos  **********
  Route::get('educacion-financiera-video', [VideoEducacionFinancieraController::class, 'index']);
  Route::post('educacion-financiera-video-nuevo', [VideoEducacionFinancieraController::class, 'store']);
  Route::get('educacion-financiera-video/{id}', [VideoEducacionFinancieraController::class, 'show']);
  Route::put('educacion-financiera-video/{id}', [VideoEducacionFinancieraController::class, 'update']);
  Route::delete('educacion-financiera-video/{id}', [VideoEducacionFinancieraController::class, 'destroy']);
  // *************  info ser socio  **********
  Route::get('info-ser-socio', [InfoSerSocioController::class, 'index']);
  Route::post('info-ser-socio-nuevo', [InfoSerSocioController::class, 'actualizarDatos']);
  // *************  requerimientos de ser socio  **********
  Route::get('requerimientos-de-ser-socios', [RequerimientosSerSocioController::class, 'index']);
  Route::post('requerimientos-de-ser-socios-nuevo', [RequerimientosSerSocioController::class, 'store']);
  Route::get('requerimientos-de-ser-socios/{id}', [RequerimientosSerSocioController::class, 'show']);
  Route::put('requerimientos-de-ser-socios/{id}', [RequerimientosSerSocioController::class, 'update']);
  Route::delete('requerimientos-de-ser-socios/{id}', [RequerimientosSerSocioController::class, 'destroy']);
  // *************  valores fundamentales  **********
  Route::get('valores-fundamentales', [ValoresFundamentalesController::class, 'index']);
  Route::post('valores-fundamentales-nuevo', [ValoresFundamentalesController::class, 'store']);
  Route::get('valores-fundamentales/{id}', [ValoresFundamentalesController::class, 'show']);
  Route::put('valores-fundamentales/{id}', [ValoresFundamentalesController::class, 'update']);
  Route::delete('valores-fundamentales/{id}', [ValoresFundamentalesController::class, 'destroy']);
  // DPF card
  Route::get('/dpf-card', [DpfCardController::class, 'index']);
  Route::post('/dpf-card/edicion', [DpfCardController::class, 'update']);
  // *************  beneficios de ser socio  **********
  Route::get('beneficios-ser-socios', [BeneficiosDeSerSocioWeb::class, 'index']);
  Route::post('beneficios-ser-socios-nuevo', [BeneficiosDeSerSocioWeb::class, 'store']);
  Route::get('beneficios-ser-socios/{id}', [BeneficiosDeSerSocioWeb::class, 'show']);
  Route::put('beneficios-ser-socios/{id}', [BeneficiosDeSerSocioWeb::class, 'update']);
  Route::delete('beneficios-ser-socios/{id}', [BeneficiosDeSerSocioWeb::class, 'destroy']);
  // que es una cooperativa de ahorro y credito
  Route::get('/coop-info', [CooperativaInfoController::class, 'index']);
  Route::post('/coop-info/edicion', [CooperativaInfoController::class, 'update']);
  // codigo etica
  Route::get('/codigo-etica', [CodigoEticaController::class, 'index']);
  Route::post('/codigo-etica/edicion', [CodigoEticaController::class, 'update']);
  // tasas y tarifas
  Route::get('/tasas-tarifas', [TasasYTarifaController::class, 'index']);
  Route::post('/tasas-tarifas/edicion', [TasasYTarifaController::class, 'update']);
  // Calificacion de riesgo
  Route::get('/calificacion-de-riesgo', [PdfCalificacionDeRiesgoController::class, 'index']);
  Route::post('/calificacion-de-riesgo/edicion', [PdfCalificacionDeRiesgoController::class, 'update']);
  // Tabla calificacion de riesgo
  Route::get('/calificacion-de-riesgo-tabla', [TablaCalificacionDeRiesgoController::class, 'index']);
  Route::post('/calificacion-de-riesgo-tabla/edicion', [TablaCalificacionDeRiesgoController::class, 'store']);
  Route::delete('/calificacion-de-riesgo-tabla-estado/{id}', [TablaCalificacionDeRiesgoController::class, 'estado']);
  //informacionImportante img
  Route::get('/info-importante', [InformacionImportanteController::class, 'index']);
  Route::post('/info-importante/edicion', [InformacionImportanteController::class, 'update']);
  // *************  recomendaciones videos  **********
  Route::get('/recomendaciones-de-seguridad-video', [VideosRecomendacionesSeguridadController::class, 'index']);
  Route::post('/recomendaciones-de-seguridad-video-nuevo', [VideosRecomendacionesSeguridadController::class, 'store']);
  Route::get('/recomendaciones-de-seguridad-video/{id}', [VideosRecomendacionesSeguridadController::class, 'show']);
  Route::put('/recomendaciones-de-seguridad-video/{id}', [VideosRecomendacionesSeguridadController::class, 'update']);
  Route::delete('/recomendaciones-de-seguridad-video/{id}', [VideosRecomendacionesSeguridadController::class, 'destroy']);
    //informacionImportante img
    Route::get('/img-valores', [ImagenValoresController::class, 'index']);
    Route::post('/img-valores/edicion', [ImagenValoresController::class, 'update']);
  Route::get('/user', [UserController::class, 'showAuthenticatedUser']); // Para mostrar los datos del usuario
  Route::put('/user', [UserController::class, 'update']); // Para actualizar los datos del usuario
});
Route::post('/login', [AuthController::class, 'login']);


Route::get('/cuenta-de-ahorro-activo', [CuentadeAhorroController::class, 'index2']);

Route::get('/carruseles-activos', [CarruselImagensController::class, 'imagenesActivas']);
Route::get('/pagina-imagenes-activas/{nombre}', [PaginaBannersController::class, 'paginasBannersActivos']);
Route::get('/paginas', [PaginasController::class, 'index']);
Route::get('/paginas-nombre', [PaginasController::class, 'showByName']);
//contactanos
Route::post('/contacto-nuevo', [ContactanosController::class, 'store']);
Route::post('/punto-de-reclamo-nuevo', [PuntoDeReclamoController::class, 'store']);
Route::get('/punto-de-reclamo/pdf/{id}', [PuntoDeReclamoController::class, 'generatePDFID']);

Route::get('/memoria-institucional-activos', [MemoriasInstitucionalController::class, 'indexActivos']);

Route::get('/dictamenes-auditorias-activos', [DictamenesAuditoriasController::class, 'indexActivos']);

Route::get('/estados-financieros-activos', [EstadosFinancierosController::class, 'indexActivos']);

Route::get('/coeficientes-adecuacion-patrimoniales-activos', [CoeficienteAdecuacionPatrimonialController::class, 'indexActivos']);

Route::get('/administracion-personal-activos', [AdministracionController::class, 'indexActivos']);

Route::get('/vigilancia-personal-activos', [VigilanciaController::class, 'indexActivos']);

Route::get('/servicios-basicos-activos', [ServiciosBasicosController::class, 'indexActivos']);

Route::get('/transferencias-electronicas-activos', [TransferenciasElectronicasController::class, 'indexActivos']);

Route::get('/principios-activos', [PrincipiosController::class, 'indexActivos']);

Route::get('/inmuebles-activos', [InmueblesController::class, 'indexActivos']);

Route::get('/agencias-activos', [AgenciasController::class, 'indexActivos']);
Route::get('/creditosActivos/{id}', [CreditosController::class, 'show2']);
Route::get('/creditos-activos', [CreditosController::class, 'indexActivos']);

Route::get('/comunicados-activos', [ComunicadosController::class, 'indexActivos']);

Route::get('/responsabilidad-social-activos', [ResponsabilidadSocialController::class, 'indexActivos']);

Route::get('/licitacion-publica-activos', [LicitacionPublicasController::class, 'indexActivos']);

Route::get('/educacion-financiera-activos', [EducacionFinancieraController::class, 'indexActivos']);

Route::get('/testimonios-activos', [TestimoniosController::class, 'indexActivos']);
Route::get('/indicadores-financieros-activos', [IndicadoresFinancierosController::class, 'indexActivos']);

Route::get('/educacion-financieras-img-activos', [EducacionFinancierasImg::class, 'indexActivos']);
Route::get('/dpf-activos', [TabladpfController::class, 'indexActivos']);
Route::get('/empresa-activa', [EmpresaController::class, 'lecturaEmpresa']);
Route::get('/caracteristicas-cuenta-de-ahorro-activos', [CaracteristicasController::class, 'indexActivos']);
Route::get('/requisitos-cuenta-de-ahorro-activos', [RequisitosController::class, 'indexActivos']);

//dpf Caracterisiticas-activas
Route::get('/caracteristicas-dpf-activos', [CaracteristicasDpfController::class, 'indexActivos']);

//dpf Beneficios-activas
Route::get('/beneficios-dpf-activos', [BeneficiosDpfController::class, 'indexActivos']);

//dpf Requisitos-activas
Route::get('/requisitos-dpf-activos', [RequisitosDpfController::class, 'indexActivos']);
//recomendaciones de reguridad
Route::get('/recomendaciones-de-seguridad-activos', [SeguridadTipsController::class, 'indexActivos']);
//educacion financiera videos
Route::get('/educacion-financiera-video-activos', [VideoEducacionFinancieraController::class, 'indexActivos']);
//info ser socio activo
Route::get('info-ser-socio-activo', [InfoSerSocioController::class, 'indexActivo']);
// requerimientos de ser socio activos
Route::get('requerimientos-de-ser-socios-activos', [RequerimientosSerSocioController::class, 'indexActivos']);
// valores fundamentales activos
Route::get('valores-fundamentales-activos', [ValoresFundamentalesController::class, 'indexActivos']);
// beneficios ser socio activos
Route::get('beneficios-ser-socios-activos', [BeneficiosDeSerSocioWeb::class, 'indexActivos']);
//cooperativa de ahorro y credito activo
Route::get('/coop-info-activo', [CooperativaInfoController::class, 'index2']);
//codigo etica activo
Route::get('/codigo-etica-activo', [CodigoEticaController::class, 'index2']);
//tasas y tarifas activo
Route::get('/tasas-tarifas-activo', [TasasYTarifaController::class, 'index2']);
//Calificacion de riesgo activa
Route::get('/calificacion-de-riesgo-activo', [PdfCalificacionDeRiesgoController::class, 'index2']);
// tabla calificacion de riesgo
Route::get('/calificacion-de-riesgo-tabla-activo', [TablaCalificacionDeRiesgoController::class, 'index2']);
// info importante activo
Route::get('/info-importante-activo', [InformacionImportanteController::class, 'index2']);
// recomendaciones videos
Route::get('/recomendaciones-de-seguridad-video-activos', [VideosRecomendacionesSeguridadController::class, 'indexActivos']);
//imaagen de valores activo
Route::get('/img-valores-activo', [ImagenValoresController::class, 'index2']);
Route::get('/dpf-card-activo', [DpfCardController::class, 'index2']);
Route::get('/principios-text', [PrincipiosTextController::class, 'lecturaitem']);

// Redes Sociales
Route::get('/redes-sociales-activas', [RedesSocialesController::class, 'redesSocialesActivo']);
