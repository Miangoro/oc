<?php

namespace App\Http\Controllers\pdfscontrollers;

use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf;

use Illuminate\Http\Request;

class CartaAsignacionController extends Controller
{
    public function index()
    {
        $pdf = Pdf::loadView('pdfs.CartaAsignacion');
        return $pdf->stream('NOM-070-341C_Asignacion-de-numero-de-cliente.pdf');
    }
    public function info()
    {
        $pdf = Pdf::loadView('pdfs.SolicitudInfoCliente');
        return $pdf->stream('F7.1-01-02  Solicitud de Información del Cliente NOM-070-SCFI-2016 y NMX-V-052-NORMEX-2016 Ed.pdf');
    }
   
    //vista 
    public function ServicioPersonaFisica()
    {
      $pdf = Pdf::loadView('pdfs.prestacion_servicio_fisica');
    return $pdf->stream('F4.1-01-01 Contrato de prestación de servicios NOM 070 Ed 4 persona fisica VIGENTE.pdf');
    }


    public function ServicioPersonaVigente()
    {
      $pdf = Pdf::loadView('pdfs.prestacion_servicios_vigente');
    return $pdf->stream('F4.1-01-01 Contrato de prestación de servicios NOM 070 Ed 4 VIGENTE.pdf');
    }


    public function access_user()
    {
        $pdf = Pdf::loadView('pdfs.AsignacionUsuario');
        return $pdf->stream('F7.1-01-46 Carta de asignación de usuario y contraseña para plataforma del OC Ed. 0, Vigente.pdf');
    }
    public function solicitudservi()
    {
        $pdf = Pdf::loadView('pdfs.SolicitudDeServicio');
        return $pdf->stream('Solicitud de servicios NOM-070-SCFI-2016 F7.1-01-32 Ed10 VIGENTE.pdf');
    }
    
}
