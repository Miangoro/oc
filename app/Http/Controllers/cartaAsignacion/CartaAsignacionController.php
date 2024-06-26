<?php

namespace App\Http\Controllers\cartaAsignacion;

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
}