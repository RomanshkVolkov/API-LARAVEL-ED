<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Coordinador;

use Illuminate\Http\Request;


class UserController extends Controller
{

    public function login()
    {
        

    }

    public function registrar()
    {
        
        $coordinadores = Coordinador::all();
        // var_dump($coordinadores);;
        foreach($coordinadores as $coordinador){
            echo ($coordinador);
            
        }
    }

    public function cerrar()
    {
        
    }
    public function perfil()
    {
        
    }
}
