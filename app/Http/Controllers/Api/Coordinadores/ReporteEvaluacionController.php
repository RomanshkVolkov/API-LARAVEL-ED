<?php

namespace App\Http\Controllers\Api\Coordinadores;

use App\Http\Controllers\Controller;
use App\Models\Coordinador;
use App\Models\ListaAlumnoPeriodo;
use App\Models\Materia;
use App\Models\Alumno;
use App\Models\Personal;
use App\Models\PeriodoDetalle;
use App\Models\Pregunta;
use App\Models\PreguntaEvaluacion;
use App\Models\RespuestaEvaluacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ReporteEvaluacionController extends Controller
{

    public function reporteGeneralDocentes(Request $request)
    {
        $personal = Auth::user();
        $validation =  $request->validate([
            'periodo' => 'required',
        ]);

        $indicadoresGrales = [];
        $promedio_gral = 0;
        // Selecciona Todos los ids de los Docentes,
        // filtra por Periodo,Carrera
        $docentesPeriodo = PeriodoDetalle::selectRaw('personal_id')
            ->where('carrera_id', $personal->coordinador->carrera->id)
            ->where('periodo_id', $request->input('periodo'))
            ->groupBy('personal_id')
            ->orderBy('id')
            ->get();
        //Por cada Docente en $docentesPeriodo
        foreach ($docentesPeriodo as $numDocente => $docente) {
            //materias y grupos por docente, por carrera y periodo
            $gruposDocente = PeriodoDetalle::where('carrera_id', $personal->coordinador->carrera->id)
                ->where('periodo_id', $request->input('periodo'))
                ->where('personal_id', $docente->personal_id)
                ->get();
            // matarias x docente
            $promedio_docente = 0;
            foreach ($gruposDocente as $numGrupo => $grupo) {
                $promedio_materia = 0;
                foreach ($grupo->preguntas as $i => $pregunta) {
                    $promedio_materia +=  round(RespuestaEvaluacion::where("pregunta_evaluacion_id", $pregunta->id)->avg('puntos'), 2);
                }
                //Materias
                $indicadoresGrales['docentes'][$numDocente]['grupos'][$numGrupo]['total_alumnos'] = ListaAlumnoPeriodo::where('periodo_detalle_id', $grupo->id)->get()->count();
                $indicadoresGrales['docentes'][$numDocente]['grupos'][$numGrupo]['encuestados'] = ListaAlumnoPeriodo::where('periodo_detalle_id', $grupo->id)->where('status_encuesta', 1)->get()->count();;
                $indicadoresGrales['docentes'][$numDocente]['grupos'][$numGrupo]['materia'] =  $grupo->materia;
                $indicadoresGrales['docentes'][$numDocente]['grupos'][$numGrupo]['materia']['promedio'] = count($grupo->preguntas) > 0 ? round($promedio_materia / count($grupo->preguntas), 2) : 0;
                $indicadoresGrales['docentes'][$numDocente]['grupos'][$numGrupo]['materia']['preguntas'] =  PreguntaEvaluacion::select('pregunta_id')->where('periodo_detalle_id', $grupo->id)->count();
                $indicadoresGrales['docentes'][$numDocente]['grupos'][$numGrupo]['grupo'] =  $grupo->grupo;
                //Docente
                $indicadoresGrales['docentes'][$numDocente]['docente'] = $grupo->personal;
                $promedio_docente += $indicadoresGrales['docentes'][$numDocente]['grupos'][$numGrupo]['materia']['promedio'];
            }
            $indicadoresGrales['docentes'][$numDocente]['docente']['promedio'] =  count($gruposDocente) > 0 ?  round($promedio_docente / count($gruposDocente), 2) : 0;
            $promedio_gral += $indicadoresGrales['docentes'][$numDocente]['docente']['promedio'];
        }
        $indicadoresGrales['promedio_carrera'] = count($docentesPeriodo) > 0 ?  round($promedio_gral / count($docentesPeriodo), 2) : 0;

        return response()->json($indicadoresGrales, 200);
    }

    public function reporteGeneralCarrerasDocentes($periodo)
    {
        // $personal = Auth::user();
        // $validation =  $personal->validate([
        //     'periodo' => 'required',
        // ]);



        $coordinadores = Coordinador::all();


        // $promedio_gral = 0;
        // // Selecciona Todos los ids de los Docentes,
        // // filtra por Periodo,Carrera
        // $docentesPeriodo = PeriodoDetalle::selectRaw('personal_id')
        //     ->where('carrera_id', $personal->coordinador->carrera->id)
        //     ->where('periodo_id', $request->input('periodo'))
        //     ->groupBy('personal_id')
        //     ->orderBy('id')
        //     ->get();
        // //Por cada Docente en $docentesPeriodo
        // foreach ($docentesPeriodo as $numDocente => $docente) {
        //     //materias y grupos por docente, por carrera y periodo
        //     $gruposDocente = PeriodoDetalle::where('carrera_id', $personal->coordinador->carrera->id)
        //         ->where('periodo_id', $request->input('periodo'))
        //         ->where('personal_id', $docente->personal_id)
        //         ->get();
        //     // matarias x docente
        //     $promedio_docente = 0;
        //     foreach ($gruposDocente as $numGrupo => $grupo) {
        //         $promedio_materia = 0;
        //         foreach ($grupo->preguntas as $i => $pregunta) {
        //             $promedio_materia +=  round(RespuestaEvaluacion::where("pregunta_evaluacion_id", $pregunta->id)->avg('puntos'), 2);
        //         }
        //         //Materias
        //         $indicadoresGrales['docentes'][$numDocente]['grupos'][$numGrupo]['total_alumnos'] = ListaAlumnoPeriodo::where('periodo_detalle_id', $grupo->id)->get()->count();
        //         $indicadoresGrales['docentes'][$numDocente]['grupos'][$numGrupo]['encuestados'] = ListaAlumnoPeriodo::where('periodo_detalle_id', $grupo->id)->where('status_encuesta', 1)->get()->count();;
        //         $indicadoresGrales['docentes'][$numDocente]['grupos'][$numGrupo]['materia'] =  $grupo->materia;
        //         $indicadoresGrales['docentes'][$numDocente]['grupos'][$numGrupo]['materia']['promedio'] = count($grupo->preguntas) > 0 ? round($promedio_materia / count($grupo->preguntas), 2) : 0;
        //         $indicadoresGrales['docentes'][$numDocente]['grupos'][$numGrupo]['materia']['preguntas'] =  PreguntaEvaluacion::select('pregunta_id')->where('periodo_detalle_id', $grupo->id)->count();
        //         $indicadoresGrales['docentes'][$numDocente]['grupos'][$numGrupo]['grupo'] =  $grupo->grupo;
        //         //Docente
        //         $indicadoresGrales['docentes'][$numDocente]['docente'] = $grupo->personal;
        //         $promedio_docente += $indicadoresGrales['docentes'][$numDocente]['grupos'][$numGrupo]['materia']['promedio'];
        //     }
        //     $indicadoresGrales['docentes'][$numDocente]['docente']['promedio'] =  count($gruposDocente) > 0 ?  round($promedio_docente / count($gruposDocente), 2) : 0;
        //     $promedio_gral += $indicadoresGrales['docentes'][$numDocente]['docente']['promedio'];
        // }
        // $indicadoresGrales['promedio_carrera'] = count($docentesPeriodo) > 0 ?  round($promedio_gral / count($docentesPeriodo), 2) : 0;

        // return response()->json($indicadoresGrales, 200);
        return response()->json($coordinadores, 200);
    }


    public function reporteByPeriodoDocenteMateria(Request $request)
    {
        $validation =  $request->validate([
            'periodo' => 'required',
            'docente' => 'required',
            'materia' => 'required',
        ]);
        $personal = Auth::user();
        $periodosGrupos = PeriodoDetalle::select('*')
            ->where('carrera_id', $personal->coordinador->carrera->id)
            ->where('periodo_id', $request->periodo)
            ->where('personal_id', $request->docente)
            ->where('materia_id', $request->materia)
            ->get();

        $evaluacion = [];

        foreach ($periodosGrupos as $i => $periodoDetalle) {
            $evaluacion[$i]["grupo"] = $periodoDetalle->grupo;
            $evaluacion[$i]["comentarios"] = $periodoDetalle->comentariosEvaluacion;
            $evaluacion[$i]["total_alumnos"] = ListaAlumnoPeriodo::where('periodo_detalle_id', $periodoDetalle->id)->get()->count();
            $evaluacion[$i]["total_encuestados"] = ListaAlumnoPeriodo::where('periodo_detalle_id', $periodoDetalle->id)->where('status_encuesta', 1)->get()->count();
            $preguntas = PreguntaEvaluacion::where('periodo_detalle_id', $periodoDetalle->id)
                ->groupBy('pregunta_id')
                ->get();
            $promedioXGrupo = 0;
            foreach ($preguntas as $k => $pregunta) {
                $evaluacion[$i]['preguntas'][$k]['pregunta'] = $pregunta->pregunta[0]->pregunta;
                $evaluacion[$i]['preguntas'][$k]['promedio'] = round(RespuestaEvaluacion::where("pregunta_evaluacion_id", $pregunta->id)->avg('puntos'), 2);
                $evaluacion[$i]['preguntas'][$k]['total'] = RespuestaEvaluacion::where("pregunta_evaluacion_id", $pregunta->id)->get()->count();
                $promedioXGrupo = ($promedioXGrupo + $evaluacion[$i]['preguntas'][$k]['promedio']);
            }
            if (count($preguntas) > 0) {
                $evaluacion[$i]["promedio_grupo"] = round($promedioXGrupo / count($preguntas), 2);
              } else {
                $evaluacion[$i]["promedio_grupo"] = 0;
              }

        }
        return response()->json($evaluacion, 200);
    }

    public function alumnosPeriodoActivo(Request $request)
    {
        $personal = Auth::user();
        $validation =  $request->validate([
            'periodo' => 'required',
        ]);
        $repuesta = [];
        $grupos = PeriodoDetalle::selectRaw('grupo')
            ->where('periodo_id', $request->input('periodo'))
            ->where('carrera_id', $personal->coordinador->carrera->id)
            ->orderBy('grupo', 'asc')
            ->groupBy('grupo')
            ->get();
        foreach ($grupos as $index => $grupo) {
            $grupos_detalles = PeriodoDetalle::select('id')
                ->where('periodo_id', $request->input('periodo'))
                ->where('carrera_id', $personal->coordinador->carrera->id)
                ->where('grupo', $grupo->grupo)
                ->orderBy('id', 'asc')
                ->groupBy('id')
                ->get();
            $repuesta[$index]['grupo'] = $grupo->grupo;
            $repuesta[$index]['alumnos']['total'] = ListaAlumnoPeriodo::whereIn('periodo_detalle_id', $grupos_detalles)->orderBy('alumno_id', 'asc')->groupBy('alumno_id')->get()->count();
            $repuesta[$index]['alumnos']['evaluados']['total'] = ListaAlumnoPeriodo::whereIn('periodo_detalle_id', $grupos_detalles)->where('status_encuesta', 1)->orderBy('alumno_id', 'asc')->groupBy('alumno_id')->get()->count();
            $repuesta[$index]['alumnos']['evaluados']['lista'] = ListaAlumnoPeriodo::with('alumno')->whereIn('periodo_detalle_id', $grupos_detalles)->where('status_encuesta', 1)->orderBy('alumno_id', 'asc')->groupBy('alumno_id')->get();
            $repuesta[$index]['alumnos']['pendientes']['total'] = ListaAlumnoPeriodo::whereIn('periodo_detalle_id', $grupos_detalles)->where('status_encuesta', null)->orderBy('alumno_id', 'asc')->groupBy('alumno_id')->get()->count();
            $repuesta[$index]['alumnos']['pendientes']['lista'] = ListaAlumnoPeriodo::with('alumno')->whereIn('periodo_detalle_id', $grupos_detalles)->where('status_encuesta', null)->orderBy('alumno_id', 'asc')->groupBy('alumno_id')->get();
        }
        return response()->json($repuesta);
    }
}
