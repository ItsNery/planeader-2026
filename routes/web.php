<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\CapacitacionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DocumentoCopladepController;
use App\Http\Controllers\DocumentoSubcomiteController;
use App\Http\Controllers\EncuestaController;
use App\Http\Controllers\EncuestaPed2025Controller;
use App\Http\Controllers\FormularioContactoController;
use App\Http\Controllers\InicioController;
use App\Http\Controllers\MarcoJuridicoController;
use App\Http\Controllers\PlanEstatalController;
use App\Http\Controllers\PlanMunicipalController;
use App\Http\Controllers\ProgramaDerivadoController;
use App\Http\Controllers\ProgramaEstatalController;
use App\Http\Controllers\RegistroController;
use App\Http\Controllers\SubcomiteController;
use App\Http\Controllers\HerramientaPlaneacionController;
use App\Http\Controllers\PlanEstatalAnexoController;
use App\Http\Controllers\DocumentoApoyoCoplademunController;
use App\Http\Controllers\DocumentoMetodologicoController;
use App\Http\Controllers\DocumentoSesionController;
use App\Http\Controllers\InvitadoCopladepController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\EventoController;
use App\Http\Controllers\AgendaEventoController;
use App\Http\Controllers\AgendaCapacidadController;
use App\Http\Controllers\AgendaFechaBloqueadaController;
use App\Http\Controllers\PanelAgendaEventoController;
use App\Http\Controllers\PushSubscriptionController;
use App\Http\Controllers\RegistroCopladepController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('inicio');
});
Route::get('/', [InicioController::class, 'index']);

// Comentado por el momento a la espera de nuevo diseño acorde al PED
Route::get('/ped', function () {
    return view('planestatal');
});

// Route::get('/ped-programas', function () {
//     return view('programaderivados');
// });

// Route::get('/subcomites', function () {
//     return view('subcomites');
// });

// Route::get('/copladep', function () {
//     return view('copladep');
// });
Route::get('/copladep/primera-sesion-ordinaria', [DocumentoSesionController::class, 'mostrarPrimeraSesion']);
Route::get('/copladep/primera-sesion-ordinaria/registro', [RegistroCopladepController::class, 'create'])->name('copladep-registro.create');
Route::post('/copladep/primera-sesion-ordinaria/registro', [RegistroCopladepController::class, 'store'])->name('copladep-registro.store');

Route::get('/ped-programas', [ProgramaDerivadoController::class, 'mostrarProgramasDerivados']);

Route::get('/ped', [PlanEstatalController::class, 'mostrarPlanEstatal']);

// Route::get('/nuevo-ped', function () {
//     return view('nuevo-ped');
// });

Route::get('/copladep', [DocumentoCopladepController::class, 'mostrarDocumentosCopladep']);

Route::get('/subcomites', [SubcomiteController::class, 'mostrarSubcomites']);

Route::get('/subcomites/mesas-tecnicas-programas-especiales', [SubcomiteController::class, 'mesasTecnicasProgramasEspeciales'])
    ->name('subcomites.mesas-tecnicas-programas-especiales');
Route::get('/subcomites/{slug}', [SubcomiteController::class, 'showPublic'])->name('subcomites.showPublic');
Route::post('/agenda-eventos', [AgendaEventoController::class, 'store'])->name('agenda-eventos.store');
Route::get('/agenda-eventos/consulta', [AgendaEventoController::class, 'consulta'])->name('agenda-eventos.consulta');
Route::get('/agenda-eventos/{agendaEvento}/google-calendar', [AgendaEventoController::class, 'googleCalendar'])->name('agenda-eventos.google-calendar');
Route::get('/agenda-eventos/{agendaEvento}/ics', [AgendaEventoController::class, 'ics'])->name('agenda-eventos.ics');
Route::get('/coplademun', [DocumentoApoyoCoplademunController::class, 'mostrarCoplademun']);



// Route::get('/coplademun', function () {
//     return view('coplademun');
// });

Route::get('/coplademun/registro', function () {
    return view('registro-coplademun');
});

// Route::get('/capacitacion-municipal', function () {
//     return view('capacitaciones');
// });

Route::get('/capacitacion-municipal', [CapacitacionController::class, 'listarcapacitaciones']);

Route::get('/documentos-metodologicos', [DocumentoMetodologicoController::class, 'mostrarMetodologicos']);
// Route::get('/documentos-metodologicos', function () {
//     return view('documentos-metodologicos');
// });

Route::get('/herramientas-planeacion', [HerramientaPlaneacionController::class, 'mostrarHerramientas']);

Route::get('/planesmunicipales', [PlanMunicipalController::class, 'mostrarPlanesMunicipales']);

Route::get('/obtener-plan-municipal/{municipioId}', [PlanMunicipalController::class, 'obtenerPlanMunicipal'])->name('planmunicipal.obtener');

Route::get('/obtener_planes/{id_municipio}', [PlanMunicipalController::class, 'obtenerPlanes'])->name('obtener_planes');

// Sin sección
// Route::get('/regionalizacion', function () {
//     return view('regionalizacion');
// });
// Route::get('/regionalizacion', [InicioController::class, 'regionalizacion']);
// Route::get('/get_info_region/{id_region}', [InicioController::class, 'getInfoRegion']);

Route::get('/regionalizacion', [InicioController::class, 'regionalizacion']);

// Route::get('/get_info_region/{id_region}', [InicioController::class, 'getInfoRegion']);
Route::get('/get_info_region/{tipo}/{id}', [InicioController::class, 'getInfoRegion']);

Route::get('/marcojuridico', function () {
    return view('marcojuridico');
});

Route::get('/marcojuridico', [MarcoJuridicoController::class, 'mostrarDocumentosMarco']);

Route::post('/guardar-respuesta', [EncuestaController::class, 'guardarRespuesta']);

Route::get('/contacto', function () {
    return view('contacto');
});
Route::resource('formulariocontacto', FormularioContactoController::class);

Route::get('/taller', function () {
    return view('taller');
});

Route::get('/programas-estatales', [ProgramaEstatalController::class, 'mostrarProgramasEstatales']);
Route::get('/consultaciudadana2025', function () {
    return view('consulta');
});


Route::get('/encuesta/cuestionario', [EncuestaPed2025Controller::class, 'cuestionario'])->name('cuestionario');
Route::post('/encuesta/cuestionario', [EncuestaPed2025Controller::class, 'cuestionario_store'])->name('cuestionario_store');
Route::get('/encuesta/resultados', [EncuestaPed2025Controller::class, 'resultados'])->name('cuestionario_resultados');

// Ruta para MOSTRAR el formulario (GET)
Route::get('/coplademun/registro', [RegistroController::class, 'create'])->name('registro.create');

// Ruta para PROCESAR el formulario (POST)
Route::post('/coplademun/registro', [RegistroController::class, 'store'])->name('registro.store');

// NUEVA RUTA: Ruta para MOSTRAR el listado de registrados (GET)
Route::get('/coplademun/listado', [RegistroController::class, 'index'])->name('registros.index');

// --- Fin de Rutas para el registro de COPLADEMUN ---
// Rutas protegidas

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('panel-marco-juridico', MarcoJuridicoController::class);
    Route::resource('panel-documentos-subcomites', DocumentoSubcomiteController::class);

    Route::get('/copladep/primera-sesion-ordinaria/registro/listado', [RegistroCopladepController::class, 'index'])->name('copladep-registro.index');
    Route::get('/copladep/primera-sesion-ordinaria/invitados', [InvitadoCopladepController::class, 'index'])->name('copladep-registro-invitados.index');
    Route::post('/copladep/primera-sesion-ordinaria/invitados', [InvitadoCopladepController::class, 'store'])->name('copladep-registro-invitados.store');
    Route::put('/copladep/primera-sesion-ordinaria/invitados/{id}', [InvitadoCopladepController::class, 'update'])->name('copladep-registro-invitados.update');
    Route::delete('/copladep/primera-sesion-ordinaria/invitados/{id}', [InvitadoCopladepController::class, 'destroy'])->name('copladep-registro-invitados.destroy');
    Route::get('/copladep/primera-sesion-ordinaria/monitor', [InvitadoCopladepController::class, 'monitor'])->name('copladep-registro-invitados-monitor.index');
    Route::post('/copladep/primera-sesion-ordinaria/invitados/{id}/toggle-express', [InvitadoCopladepController::class, 'toggleCheckInExpress'])->name('copladep-registro-invitados.toggle-express');
    Route::resource('panel-documentos-copladep', DocumentoCopladepController::class);

    Route::resource('panel-planes-municipales', PlanMunicipalController::class);
    Route::resource('panel-planes-estatales', PlanEstatalController::class);

    Route::get('panel-programas-derivados/crear-masivo', [ProgramaDerivadoController::class, 'createMassive'])
        ->name('panel-programas-derivados.createMassive');

    Route::post('panel-programas-derivados/store-masivo', [ProgramaDerivadoController::class, 'storeMassive'])
        ->name('panel-programas-derivados.storeMassive');
    Route::resource('panel-programas-derivados', ProgramaDerivadoController::class);
    Route::resource('panel-subcomites', SubcomiteController::class);
    Route::resource('panel-banners', BannerController::class);
    Route::resource('panel-contacto', FormularioContactoController::class);
    // Route::resource('panel-capacitaciones', CapacitacionController::class);
    Route::resource('capacitaciones', CapacitacionController::class);
    Route::resource('panel-documentos-metodologicos', DocumentoMetodologicoController::class);
    Route::delete('documentos/{documento}', [CapacitacionController::class, 'destroyDocumento'])->name('documentos.destroy');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::patch('/documentos/{id}/publicado', [MarcoJuridicoController::class, 'updatePublicado'])->name('update-publicado');
    Route::patch('/documentos-subcomite/{id}/publicado', [DocumentoSubcomiteController::class, 'updatePublicado'])->name('update-publicado-documento-subcomite');
    Route::patch('/documentos-copladep/{id}/publicado', [DocumentoCopladepController::class, 'updatePublicado'])->name('update-publicado-documentos-copladep');
    Route::patch('/plan-municipal/{id}/publicado', [PlanMunicipalController::class, 'updatePublicado'])->name('update-publicado-plan-municipal');
    Route::patch('/capacitacion/{id}/publicado', [CapacitacionController::class, 'updatePublicado'])->name('update-publicado-capacitacion');


    Route::patch('/plan-estatal/{id}/publicado', [PlanEstatalController::class, 'updatePublicado'])->name('update-publicado-plan-estatal');
    Route::patch('/programa-derivado/{id}/publicado', [ProgramaDerivadoController::class, 'updatePublicado'])->name('update-publicado-programa-derivado');
    Route::patch('/subcomite/{id}/publicado', [SubcomiteController::class, 'updatePublicado'])->name('update-publicado-subcomite');
    // Route::get('/documentosmarcojuridico', [MarcoJuridicoController::class, 'index'])->name('documentosmarcojuridico.index');
    Route::patch('/documentos-apoyo-coplademun/{id}/publicado', [DocumentoApoyoCoplademunController::class, 'updatePublicado'])->name('update-publicado-documentos-apoyo-coplademun');
    Route::patch('/documentos-metodologicos/{id}/publicado', [DocumentoMetodologicoController::class, 'updatePublicado'])->name('update-publicado-documentos-metodologicos');
    Route::get('panel-herramientas/orden', [HerramientaPlaneacionController::class, 'orden'])
        ->name('panel-herramientas.orden');
    Route::put('panel-herramientas/orden', [HerramientaPlaneacionController::class, 'actualizarOrden'])
        ->name('panel-herramientas.actualizar-orden');
    Route::resource('panel-herramientas', HerramientaPlaneacionController::class);
    Route::delete('panel-herramientas-anexo/{id}', [HerramientaPlaneacionController::class, 'destroyAnexo'])->name('panel-herramientas.destroyAnexo');
    Route::patch('/herramienta-planeacion/{id}/publicado', [HerramientaPlaneacionController::class, 'updatePublicado'])->name('update-publicado-herramienta-planeacion');
    Route::resource('panel-admin', AdminUserController::class);
    Route::resource('panel-roles', RoleController::class);
    Route::resource('panel-programas-estatales', ProgramaEstatalController::class);
    Route::patch('/programa-estatal/{id}/publicado', [ProgramaEstatalController::class, 'updatePublicado'])->name('update-publicado-programa-estatal');
    Route::resource('panel-documentos-apoyo-coplademun', DocumentoApoyoCoplademunController::class)->names('panel-documentos-apoyo-coplademun')->parameters(['panel-documentos-apoyo-coplademun' => 'documento']);
    Route::patch('/documento-apoyo-coplademun/{id}/publicado', [DocumentoApoyoCoplademunController::class, 'updatePublicado'])->name('update-publicado-documento-apoyo-coplademun');
    Route::resource('panel-documentos-sesiones', DocumentoSesionController::class);
    Route::patch('/documento-sesion/{id}/publicado', [DocumentoSesionController::class, 'updatePublicado'])->name('update-publicado-documento-sesion');
    Route::get('panel-planes-estatales/{planId}/anexos', [PlanEstatalAnexoController::class, 'index'])->name('panel-planes-estatales-anexos.index');
    Route::get('panel-planes-estatales/{planId}/anexos/create', [PlanEstatalAnexoController::class, 'create'])->name('panel-planes-estatales-anexos.create');
    Route::post('panel-planes-estatales/{planId}/anexos', [PlanEstatalAnexoController::class, 'store'])->name('panel-planes-estatales-anexos.store');
    Route::get('panel-planes-estatales/{planId}/anexos/{id}/edit', [PlanEstatalAnexoController::class, 'edit'])->name('panel-planes-estatales-anexos.edit');
    Route::put('panel-planes-estatales/{planId}/anexos/{id}', [PlanEstatalAnexoController::class, 'update'])->name('panel-planes-estatales-anexos.update');
    Route::delete('panel-planes-estatales/{planId}/anexos/{id}', [PlanEstatalAnexoController::class, 'destroy'])->name('panel-planes-estatales-anexos.destroy');
    Route::patch('/plan-estatal-anexo/{id}/publicado', [PlanEstatalAnexoController::class, 'updatePublicado'])->name('update-publicado-plan-estatal-anexo');
    Route::get('panel-eventos/capacidades-agenda', [AgendaCapacidadController::class, 'index'])
        ->name('panel-eventos.capacidades-agenda.index');
    Route::post('panel-eventos/capacidades-agenda', [AgendaCapacidadController::class, 'store'])
        ->name('panel-eventos.capacidades-agenda.store');
    Route::delete('panel-eventos/capacidades-agenda/{agendaCapacidad}', [AgendaCapacidadController::class, 'destroy'])
        ->name('panel-eventos.capacidades-agenda.destroy');
    Route::get('panel-eventos/fechas-bloqueadas-agenda', [AgendaFechaBloqueadaController::class, 'index'])
        ->name('panel-eventos.fechas-bloqueadas-agenda.index');
    Route::post('panel-eventos/fechas-bloqueadas-agenda', [AgendaFechaBloqueadaController::class, 'store'])
        ->name('panel-eventos.fechas-bloqueadas-agenda.store');
    Route::delete('panel-eventos/fechas-bloqueadas-agenda/{agendaFechaBloqueada}', [AgendaFechaBloqueadaController::class, 'destroy'])
        ->name('panel-eventos.fechas-bloqueadas-agenda.destroy');
    Route::resource('panel-eventos', EventoController::class);
    Route::get('/panel-agenda-eventos-exportar', [PanelAgendaEventoController::class, 'export'])
        ->name('panel-agenda-eventos.export')
        ->middleware('permission:ver-agenda-evento');
    Route::resource('panel-agenda-eventos', PanelAgendaEventoController::class)
        ->parameters(['panel-agenda-eventos' => 'agendaEvento']);
    Route::patch('/panel-agenda-eventos/{agendaEvento}/estado', [PanelAgendaEventoController::class, 'status'])
        ->name('panel-agenda-eventos.status');
    Route::post('/panel-agenda-eventos/push-subscriptions', [PushSubscriptionController::class, 'store'])
        ->name('panel-agenda-eventos.push-subscriptions.store');
    Route::delete('/panel-agenda-eventos/push-subscriptions/{pushSubscription}', [PushSubscriptionController::class, 'destroy'])
        ->name('panel-agenda-eventos.push-subscriptions.destroy');
});
