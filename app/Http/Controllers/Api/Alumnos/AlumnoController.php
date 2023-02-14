<?php

namespace App\Http\Controllers\Api\Alumnos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Alumno;
use App\Models\ListaAlumnoPeriodo;
use App\Models\Periodo;
use App\Models\PeriodoDetalle;
use App\Models\Pregunta;
use App\Models\PreguntaEvaluacion;
use App\Models\RespuestaEvaluacion;
use App\Models\RespuestaEvaluacionComentario;

class AlumnoController extends Controller
{

    public function perfil()
    {
        $alumno = Auth::user();
        $periodo = Periodo::where('encuesta_periodo', 1)->first();
        return response()->json(['perfil' => $alumno, 'periodo' => $periodo], 200);
    }

    public function login(Request $request)
    {
        $validation =  $request->validate([
            'matricula' => 'required',
        ]);
        // echo bcrypt(1234);
        $alumno = Alumno::where('matricula', $request->input("matricula"))->first();
        if ($alumno) {
            $email = $alumno->matricula . "@alumno.upqroo.edu.mx";
            if (Auth::guard('alumno')->attempt(['email' => $email, 'password' => 1234])) {

                $user = Auth::guard('alumno')->user();
                $periodo = Periodo::where('encuesta_periodo', 1)->first();
                $token = $user->createToken('evasys', ['alumno'])->plainTextToken;
                // return response()->json(['perfil' => $personal, 'carrera' => $c->carrera, 'token' => $token] , 200);
                return response()->json(['token' => $token, 'perfil' => $alumno, 'periodo' => $periodo], 200);
            }
        }
        return response()->json([
            "message" => "Usuario o contraseña incorrecta ",
        ], 401);
        // echo bcrypt(54321);

    }

    public function guardarEncuestaPorMateria(Request $request)
    {
        $alumno = Auth::user();
        $periodo = PeriodoDetalle::find($request->input('periodo_detalle_id'));
        $alunoLista = ListaAlumnoPeriodo::find($request->input('periodo_lista'));
        $respuestas = $request->input('preguntasyrespuestas')['respuestas'];
        $coment = $request->input('preguntasyrespuestas')['comentarios'];
        if (!$alunoLista->status_encuesta && count($respuestas) == 20)
            foreach ($respuestas as $key => $value) {
                $pregunta = PreguntaEvaluacion::firstOrCreate([
                    "periodo_detalle_id" => $periodo->id,
                    "pregunta_id" => ($key + 1)
                ]);
                $respuesta = RespuestaEvaluacion::create([
                    "pregunta_evaluacion_id" => $pregunta->id,
                    "puntos" => $value
                ]);
            }
        if ($coment) {
            $com = RespuestaEvaluacionComentario::create(["periodo_detalle_id" => $periodo->id, "comentario" => $coment]);
        }
        $alunoLista->status_encuesta = 1;
        $alunoLista->save();
        $materiaPeriodo = DB::table('lista_alumno_periodo')
            ->selectRaw('periodo_detalle.id as periodo_detalle_id,materia.id as materia_id,lista_alumno_periodo.id as periodo_lista , lista_alumno_periodo.status_encuesta, materia.clave, materia.materia, personal.nombre,personal.apellido_paterno,personal.apellido_materno,periodo_detalle.grupo')
            ->join('periodo_detalle', 'lista_alumno_periodo.periodo_detalle_id', 'periodo_detalle.id')
            ->join('materia', 'periodo_detalle.materia_id', 'materia.id')
            ->join('personal', 'periodo_detalle.personal_id', 'personal.id')
            ->join('periodo', 'periodo_detalle.periodo_id', 'periodo.id')
            ->where('lista_alumno_periodo.alumno_id', $alumno->id)
            ->where('periodo_detalle.id', $periodo->id)
            ->where('lista_alumno_periodo.id', $alunoLista->id)->get();
        return response()->json(["materia" => $materiaPeriodo[0]]);
    }
    public function listaMaterias(Request $request)
    {
        $alumno = Auth::user();
        $validation =  $request->validate([
            'periodo' => 'required',
        ]);
        $periodo = Periodo::find($request->input("periodo"));
        if ($alumno != null && $periodo != null) {
            $materiasPeriodo = DB::table('lista_alumno_periodo')
                ->selectRaw('periodo_detalle.id as periodo_detalle_id,materia.id as materia_id,lista_alumno_periodo.id as periodo_lista , lista_alumno_periodo.status_encuesta, materia.clave, materia.materia, personal.nombre,personal.apellido_paterno,personal.apellido_materno,periodo_detalle.grupo')
                ->join('periodo_detalle', 'lista_alumno_periodo.periodo_detalle_id', 'periodo_detalle.id')
                ->join('materia', 'periodo_detalle.materia_id', 'materia.id')
                ->join('personal', 'periodo_detalle.personal_id', 'personal.id')
                ->join('periodo', 'periodo_detalle.periodo_id', 'periodo.id')
                ->where('lista_alumno_periodo.alumno_id', $alumno->id)
                ->where('periodo.id', $request->input('periodo'))
                ->get();
            $preguntas = Pregunta::all();
            return response()->json(["materias" => $materiasPeriodo, "preguntas" => $preguntas]);
            /**
             *
                SELECT
                periodo_detalle.id as periodo_detalle,
                materia.id as materia_id,
                lista_alumno_periodo.id as periodo_lista,
                personal.id as docente_id
                FROM `alumno`
                INNER JOIN lista_alumno_periodo on alumno.id = lista_alumno_periodo.alumno_id
                INNER JOIN periodo_detalle on lista_alumno_periodo.periodo_detalle_id = periodo_detalle.id
                INNER JOIN periodo on periodo_detalle.periodo_id=periodo.id
                INNER JOIN materia on periodo_detalle.materia_id=materia.id
                INNER JOIN personal on periodo_detalle.personal_id=personal.id
                WHERE alumno.matricula=202000460 and periodo.id = 27
             */
        }
        return response()->json([$periodo, $alumno]);
    }
}
