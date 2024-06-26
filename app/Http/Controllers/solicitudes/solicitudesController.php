<?php

namespace App\Http\Controllers\solicitudes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class solicitudesController extends Controller
{
    function index(){
        return view('content/pages/find_solicitudes_view');
    }
}
