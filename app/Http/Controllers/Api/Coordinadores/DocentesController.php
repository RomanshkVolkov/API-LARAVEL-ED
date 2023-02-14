<?php

namespace App\Http\Controllers\Api\Coordinadores;

use App\Http\Controllers\Controller;
use App\Models\Coordinador;
use App\Models\Personal;
use App\Models\PeriodoDetalle;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class DocentesController extends Controller
{

    public function docentesByPeriodo(Request $request)
    {
        $validation =  $request->validate([
            'periodo' => 'required',
        ]);
        $personal = Auth::user();
        $periodoDetalles['ids_personal'] = PeriodoDetalle::select('personal_id')->where('carrera_id', $personal->coordinador->carrera->id)->where('periodo_id',$request->periodo)->orderBy('personal_id')->groupBy('personal_id')->get();
        // $periodoDetalles['ids_materias'] = PeriodoDetalle::select('materia_id')->where('carrera_id', $personal->coordinador->carrera->id)->where('periodo_id',$request->periodo)->groupBy('materia_id')->get();
        // $periodoDetalles['grupo'] = PeriodoDetalle::select('grupo')->where('carrera_id', $personal->coordinador->carrera->id)->where('periodo_id',$request->periodo)->groupBy('grupo')->get();
        
        
        $docentes = [];
        foreach ($periodoDetalles['ids_personal'] as $key => $value) {
            $periodoDetalles['ids_personal'][$key] = Personal::find($value->personal_id);
        }
        return response()->json(['docentes' => $periodoDetalles['ids_personal'],'total' => count($periodoDetalles['ids_personal']) ], 200);
    }
}
