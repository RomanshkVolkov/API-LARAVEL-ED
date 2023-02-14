<?php

namespace App\Http\Controllers\Api\Coordinadores;

use App\Http\Controllers\Controller;
use App\Models\Carrera;
use App\Models\Materia;
use App\Models\Coordinador;
use App\Models\Periodo;
use App\Models\PeriodoDetalle;
use App\Models\Personal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use SebastianBergmann\Environment\Console;

class CoordinadorController extends Controller
{


    public function perfil()
    {
        $personal = Auth::user();
        $personal->coordinador;
        $personal->coordinador->carrera;
        $personal->coordinador->carrera->departamento;
        return response()->json(['perfil' => $personal], 200);
    }

    public function periodos()
    {
        $personal = Auth::user();
        // $personal->periodos = PeriodoDetalle::select('periodo_id')->where('carrera_id', $personal->coordinador->carrera->id)->groupBy('periodo_id')->orderBy('id', 'desc')->get();
        $periodos = Periodo::orderBy('clave', 'desc')->get();
        // foreach ($personal->periodos as $key => $value) {
        //     $val = Periodo::find($value->periodo_id);
        //     $periodos[] = $val;
        // }
        return response()->json(['periodos' => $periodos], 200);
    }
    public function estadisticas()
    {
        $personal = Auth::user();
        $personal->materias = PeriodoDetalle::select('materia_id')->where('carrera_id', $personal->coordinador->carrera->id)->groupBy('materia_id')->get();
        $personal->docentes = PeriodoDetalle::select('personal_id')->where('carrera_id', $personal->coordinador->carrera->id)->groupBy('personal_id')->get();
        return response()->json(['materias' => count($personal->materias), 'docentes' => count($personal->docentes)], 200);
    }

    public function login(Request $request)
    {
        $validation =  $request->validate([
            'clave' => 'required',
            'password' => 'required',
        ]);
        // echo bcrypt(1234);
        $personal = Personal::where('clave', $request->input("clave"))->first();
        if ($personal) {
            $email = $request->input('clave') . "@upqroo.edu.mx";
            if (Auth::guard('personal')->attempt(['email' => $email, 'password' => $request->input('password')])) {
                if (Coordinador::where('personal_id', $personal->id)->count() > 0) {
                    $c = Coordinador::where('personal_id', $personal->id)->first();
                    $user = Auth::guard('personal')->user();
                    $token = $user->createToken('evasys', ['personal'])->plainTextToken;
                    // return response()->json(['perfil' => $personal, 'carrera' => $c->carrera, 'token' => $token] , 200);
                    return response()->json(['token' => $token], 200);
                }
                return response()->json([
                    "message" => "Usuario o contraseña incorrecta",

                ], 401);
            }
        }
        return response()->json([
            "message" => "Usuario o contraseña incorrecta ",
        ], 401);
        // echo bcrypt(54321);

    }
}
