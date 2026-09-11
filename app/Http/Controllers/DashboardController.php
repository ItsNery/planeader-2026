<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DocumentoSubcomite;
use App\Models\DocumentoCopladep;
use App\Models\PlanMunicipal;
use App\Models\PlanEstatal;
use App\Models\ProgramaDerivado;
use App\Models\Subcomite;
use App\Models\Banner;
use App\Models\MarcoJuridico;
use App\Models\FormularioContacto;
use App\Models\Encuesta;
use App\Models\User;
use App\Models\ProgramaEstatal;
use App\Models\Capacitacion;

class DashboardController extends Controller
{
    // El acceso al dashboard está permitido para cualquier usuario autenticado

    /**
     * Muestra múltiples variables en la vista protegida de Dashboard para tener un panorama amplio de la cantidad de elementos que se tienen cargados.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $cantidad_banners = Banner::count();
        $cantidad_documentos_subcomites = DocumentoSubcomite::count();
        $cantidad_documentos_copladep = DocumentoCopladep::count();
        $cantidad_documentos_planesmun = PlanMunicipal::count();
        $cantidad_documentos_planesest = PlanEstatal::count();
        $cantidad_programas_derivados = ProgramaDerivado::count();
        $cantidad_subcomites = Subcomite::count();
        $cantidad_docsMarco = MarcoJuridico::count();
        $cantidad_mensajes = FormularioContacto::count();
        $encuesta_feliz = Encuesta::where('satisfaccion', 3)->count();
        $encuesta_indiferente = Encuesta::where('satisfaccion', 2)->count();
        $encuesta_enojado = Encuesta::where('satisfaccion', 1)->count();
        $cantidad_usuarios = User::count();
        $cantidad_prog_estatales = ProgramaEstatal::count();
        $cantidad_capacitaciones = Capacitacion::count();
        return view('dashboard', compact('cantidad_documentos_subcomites', 'cantidad_documentos_copladep', 'cantidad_documentos_planesmun', 'cantidad_documentos_planesest', 'cantidad_programas_derivados', 'cantidad_subcomites', 'cantidad_banners', 'cantidad_docsMarco', 'cantidad_mensajes', 'encuesta_feliz', 'encuesta_indiferente', 'encuesta_enojado', 'cantidad_usuarios', 'cantidad_prog_estatales', 'cantidad_capacitaciones'));
    }
}
