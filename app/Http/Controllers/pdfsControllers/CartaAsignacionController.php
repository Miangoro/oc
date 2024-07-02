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

<<<<<<< HEAD
    //vista servicio persona vigente 
    public function ServicioPersonaVigente()
    {
      $pdf = Pdf::loadView('pdfs.prestacion_servicios_vigente');
    return $pdf->stream('F4.1-01-01 Contrato de prestación de servicios NOM 070 Ed 4 VIGENTE.pdf');
    }

    public function Contrato_NMX_052()
    {
      $pdf = Pdf::loadView('pdfs.CONTRATO_NMX-052');
    return $pdf->stream('F4.1-01-12 CONTRATO NMX-052 Ed 0.pdf');
    }


=======
>>>>>>> a6376fcce60600ef8f9d292514c7f2e936abe664
    public function access_user()
    {
        $pdf = Pdf::loadView('pdfs.AsignacionUsuario');
        return $pdf->stream('F7.1-01-46 Carta de asignación de usuario y contraseña para plataforma del OC Ed. 0, Vigente.pdf');
    }
    
    //PDF Dictamen de instalaciones
    public function dictamenp()
    {
        $pdf = Pdf::loadView('pdfs.DictamenProductor');
        return $pdf->stream('Dictamen de productor de mezcal.pdf');
    }
    public function dictamene()
    {
        $pdf = Pdf::loadView('pdfs.DictamenEnvasado');
        return $pdf->stream('Dictamen de envasador.pdf');
    }
    public function dictamenc()
    {
        $pdf = Pdf::loadView('pdfs.DictamenComercializador');
        return $pdf->stream('Dictamen de Comercializador.pdf');
    }

    public function solicitudservi()
    {
        $pdf = Pdf::loadView('pdfs.SolicitudDeServicio');
        return $pdf->stream('Solicitud de servicios NOM-070-SCFI-2016 F7.1-01-32 Ed10 VIGENTE.pdf');
    }
    
}
