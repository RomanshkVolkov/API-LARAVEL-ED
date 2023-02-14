<?php

namespace App\Http\Controllers\Api\Coordinadores;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PeriodoDetalle;
use App\Models\Materia;

class GrupoController extends Controller
{
    public function grupoByPeriodoDocenteMat(Request $request)
    {
        $validation =  $request->validate([
            'periodo' => 'required',
            'docente' => 'required',
            'materia' => 'required',
        ]);
        $personal = Auth::user();
        // $periodoDetalles['ids_personal'] = PeriodoDetalle::select('personal_id')->where('carrera_id', $personal->coordinador->carrera->id)->where('periodo_id',$request->periodo)->orderBy('personal_id')->groupBy('personal_id')->get();
        $periodoDetalles['grupo'] = PeriodoDetalle::select('grupo')
            ->where('carrera_id', $personal->coordinador->carrera->id)
            ->where('periodo_id', $request->periodo)
            ->where('personal_id', $request->docente)
            ->where('materia_id', $request->materia)
            ->groupBy('grupo')
            ->get();
        return response()->json(['grupos' => $periodoDetalles['grupo'], 'total' => count($periodoDetalles['grupo'])], 200);
    }
}
