<?php
namespace App\Http\Controllers\catalogo;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\tipo;

class tiposController extends Controller
{
    public function UserManagement()
    {
        $empresas = tipo::all();
        $userCount = $empresas->count();
        $verified = 5;
        $notVerified = 10;
        $usersUnique = $empresas->unique(['CATEGORIA']);
        $userDuplicates = 40;

        return view('catalogo.tipos_view', [
            'totalUser' => $userCount,
            'verified' => $verified,
            'notVerified' => $notVerified,
            'userDuplicates' => $userDuplicates,
        ]);
    }
    

}
