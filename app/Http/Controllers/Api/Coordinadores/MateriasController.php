<?php
namespace App\Http\Controllers\Api\Coordinadores;

use App\Http\Controllers\Controller;
use App\Models\Coordinador;
use App\Models\Materia;
use App\Models\Personal;
use App\Models\PeriodoDetalle;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class MateriasController extends Controller
{

    public function materiasByPeriodoDocente(Request $request)
    {
        $validation =  $request->validate([
            'periodo' => 'required',
            'docente' => 'required',
        ]);
        $personal = Auth::user();
        // $periodoDetalles['ids_personal'] = PeriodoDetalle::select('personal_id')->where('carrera_id', $personal->coordinador->carrera->id)->where('periodo_id',$request->periodo)->orderBy('personal_id')->groupBy('personal_id')->get();
        $periodoDetalles['ids_materias'] = PeriodoDetalle::select('materia_id')->where('carrera_id', $personal->coordinador->carrera->id)->where('periodo_id',$request->periodo)->where('personal_id',$request->docente)->groupBy('materia_id')->get();
        // $periodoDetalles['grupo'] = PeriodoDetalle::select('grupo')->where('carrera_id', $personal->coordinador->carrera->id)->where('periodo_id',$request->periodo)->groupBy('grupo')->get();
        
        
        $docentes = [];
        foreach ($periodoDetalles['ids_materias'] as $key => $value) {
            $periodoDetalles['ids_materias'][$key] = Materia::find($value->materia_id);
        }
        return response()->json(['materias' => $periodoDetalles['ids_materias'],'total' => count($periodoDetalles['ids_materias']) ], 200);
    }
}
