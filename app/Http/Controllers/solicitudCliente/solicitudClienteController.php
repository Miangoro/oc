<?php

namespace App\Http\Controllers\solicitudCliente;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\empresa;
use App\Models\empresa_producto;
use App\Models\empresa_norma;
use App\Models\empresa_actividad;
use App\Models\solicitud_informacion;

class solicitudClienteController extends Controller
{
    public function index()
    {
      return view('solicitudes.solicitudCliente');
    }

    public function RegistroExitoso(){
      return view('solicitudes.Registro_exitoso');
    }

    public function registrar(Request $request)
    {

      $empresa = new empresa();
      $empresa->razon_social = $request->razon_social;
      $empresa->domicilio_fiscal = $request->calle1." ".$request->numero1;
      $empresa->estado = $request->localidad1;
      $empresa->regimen = $request->regimen;
      $empresa->correo = $request->correo;
      $empresa->telefono = $request->telefono;
      $empresa->tipo = 1; //en este caso siempre es 1 porque es un cliente prospecto
      $empresa->rfc = $request->rfc;
      $empresa->representante = $request->representante  ?: 'No aplica';
      $empresa->save();
      $id_empresa = $empresa->id_empresa;

      for($i=0;$i<count($request->producto);$i++){
        $producto = new empresa_producto();
        $producto->id_producto = $request->producto[$i];
        $producto->id_empresa = $id_empresa;
        $producto->save();
      }

      for($i=0;$i<count($request->norma);$i++){
        $norma = new empresa_norma();
        $norma->id_norma = $request->norma[$i];
        $norma->id_empresa = $id_empresa;
        $norma->save();
      }

      for($i=0;$i<count($request->actividad);$i++){
        $actividad = new empresa_actividad();
        $actividad->id_actividad = $request->actividad[$i];
        $actividad->id_empresa = $id_empresa;
        $actividad->save();
      }


        $solicitud = new solicitud_informacion();
        $solicitud->id_empresa = $id_empresa;
        $solicitud->info_procesos = $request->info_procesos;
        $solicitud->save();
      

      

      

      return view('solicitudes.Registro_exitoso');
    }
}
