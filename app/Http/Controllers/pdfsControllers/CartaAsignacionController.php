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

    public function Contrato_prestacion_servicio_NOM_199()
    {
      $pdf = Pdf::loadView('pdfs.Contrato_prestacion_servicio_NOM_199');
    return $pdf->stream('F4.1-01-07 Contrato Prestación de Servicios NOM-199 Ed 5 VIGENTE.pdf');
    }

    public function acta_circunstanciada_produccion()
    {
      $pdf = Pdf::loadView('pdfs.acta_circunstanciada_unidades_produccion');
    return $pdf->stream('F-UV-02-02 ACTA CIRCUNSTANCIADA V6.pdf');
    }


    public function solicitudInfoNOM_199()
    {
      $pdf = Pdf::loadView('pdfs.solicitudInfoClienteNOM-199');
    return $pdf->stream('F7.1-03-02 Solicitud de Información al Cliente NOM-199-SCFI-2017 Ed. 4 VIGENTE.pdf');
    }



    public function access_user()
    {
        $pdf = Pdf::loadView('pdfs.AsignacionUsuario');
        return $pdf->stream('F7.1-01-46 Carta de asignación de usuario y contraseña para plataforma del OC Ed. 0, Vigente.pdf');
    }

    //PDF Dictamen de instalaciones
    public function dictamenp()
    {
        $pdf = Pdf::loadView('pdfs.DictamenProductor');
        return $pdf->stream('F-UV-02-04 Ver 10, Dictamen de cumplimiento de Instalaciones como productor.pdf');
    }
    public function dictamene()
    {
        $pdf = Pdf::loadView('pdfs.DictamenEnvasado');
        return $pdf->stream('F-UV-02-11 Ver 5, Dictamen de cumplimiento de Instalaciones como envasador.pdf');
    }
    public function dictamenc()
    {
        $pdf = Pdf::loadView('pdfs.DictamenComercializador');
        return $pdf->stream('F-UV-02-12 Ver 5, Dictamen de cumplimiento de Instalaciones como comercializador.pdf');
    }

    public function solicitudservi()
    {
        $pdf = Pdf::loadView('pdfs.SolicitudDeServicio');
        return $pdf->stream('Solicitud de servicios NOM-070-SCFI-2016 F7.1-01-32 Ed10 VIGENTE.pdf');
    }


    //Guias de translado
    public function guiasTranslado()
    {
        $pdf = Pdf::loadView('pdfs.GuiaDeTranslado');
        return $pdf->stream('539G005_Guia_de_traslado_de_maguey_o_agave.pdf');
    }

    public function Etiqueta()
    {
        $pdf = Pdf::loadView('pdfs.Etiqueta-2401ESPTOB');
        return $pdf->stream('Etiqueta-2401ESPTOB.pdf');
    }
}
