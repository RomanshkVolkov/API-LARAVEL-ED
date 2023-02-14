<?php

namespace App\Http\Controllers\Migraciones;

use App\Http\Controllers\Controller;
use App\Models\Alumno;
use App\Models\Departamento;
use App\Models\Carrera;
use App\Models\Coordinador;
use App\Models\ListaAlumnoPeriodo;
use App\Models\PeriodoDetalle;
use App\Models\Materia;
use App\Models\Migraciones\AlumnoM;
use App\Models\Migraciones\DepartamentoM;
use App\Models\Migraciones\CarreraM;
use App\Models\Migraciones\CoordinadorM;
use App\Models\Migraciones\CuestionarioM;
use App\Models\Migraciones\Encuesta;
use App\Models\Migraciones\Evaluacion;
use App\Models\Migraciones\GrupoListaM;
use App\Models\Migraciones\ListaAlumnoPeriodoM;
use App\Models\Migraciones\PeriodoM;
use App\Models\Migraciones\MateriaM;
use App\Models\Migraciones\PersonalM;
use App\Models\Migraciones\PlanM;
use App\Models\Periodo;
use App\Models\Personal;
use App\Models\Plan;
use App\Models\Pregunta;
use App\Models\PreguntaEvaluacion;
use App\Models\RespuestaEvaluacion;
use App\Models\RespuestaEvaluacionComentario;

use function PHPUnit\Framework\isEmpty;
use Illuminate\Support\Facades\DB;

class InsertarDatos extends Controller
{


    public function migrarAlumnos()
    {

        //vieja base de datos upqroo 2 ya que tiene mas registros 
        $alumnosM =  AlumnoM::all();

        foreach ($alumnosM  as $key => $value) {
            //si ya esta registrado en la base de datos 
            if ($a = Alumno::where('matricula', $value->ALUCTR)->count() == 0) {
                $alumno = Alumno::create(
                    [
                        "matricula" => $value->ALUCTR,
                        "nombre" => $value->ALUNOM,
                        "apellido_materno" => ($value->ALUAPM) ? $value->ALUAPM : "S/A",
                        "apellido_paterno" => $value->ALUAPP,
                        'email' => $value->ALUCTR . "@alumno.upqroo.edu.mx",
                        'password' => 12345
                    ]
                );
            } else {
                echo "ya existe : " . $value . "<br>";
            }
        }
    }

    public function deptoM()
    {

        // Departamento creado de la base de datos de UPQROO
        $deptoM =  DepartamentoM::all();

        foreach ($deptoM  as $key => $value) {
            // print($value);
            if (Departamento::where('id', $value->DEPCVE)->count() == 0) {
                $depto = Departamento::create(
                    [
                        "id" => $value->DEPCVE,
                        "departamento" => $value->DEPNOM,
                        "abreviatura" => $value->DEPNCO
                    ]
                );
            } else {
            }
        }
    }

    public function personalM()
    {
        //
        $per =  PersonalM::all();
        $i = 1;
        foreach ($per  as $key => $value) {
            // echo $i++;
            // echo "<br>";
            $per2 =  Personal::where('clave', $value->PERCVE)->count();
            // $cDp = Departamento::where('id', $value->PERDEP)->count();
            $mat = "sin-apellidos";
            $pat = "sin-apellidos";

            // if ($cDp > 0) {

            if ($per2 == 0 && $value->PERCVE > 0) {
                $depto = Departamento::find(201);

                $apepYm =  explode(' ', $value->PERAPE);

                if (count($apepYm) == 1) {
                    $mat = $value->PERAPE;
                    $pat = "sin-apellidos";
                }
                if (count($apepYm) == 2) {
                    $pat = $apepYm[0];
                    $mat = $apepYm[1];
                }
                if (count($apepYm) == 3) {
                    $pat = $apepYm[0];
                    $mat = $apepYm[1] . " " . $apepYm[2];
                }
                if (count($apepYm) > 3) {
                    $pat = $apepYm[0];
                    $mat = $apepYm[1] . " " . $apepYm[2] . " " . $apepYm[3];
                }
                // echo "Nuevo  = ".$value->PERCVE." nom : ". $value->PERNOM . " ap : " .$pat." " . " am : " .$mat." " .$depto->id. "  ,Depto: ". $cDp ."<br>" ; 

                $personal = Personal::create(
                    [
                        "clave" => $value->PERCVE,
                        "nombre" => $value->PERNOM,
                        "apellido_paterno" => $pat,
                        "apellido_materno" => $mat,

                        "sexo" => ($value->PERSEX = 1) ? 'H' : 'M',
                        "departamento_id" => $depto->id,
                        'email' => $value->PERCVE . "@upqroo.edu.mx",
                        'password' => bcrypt(1234),
                        "departamento_id" => 201
                    ]
                );
            } else {
                $existe = PersonalM::where('PERCVE', $value->PERCVE)->count();
                // echo "Repetido  = ".$value->PERCVE." ". $value->PERNOM . " " .$value->PERAPE." " .$value->PERDEP. "  ,Depto: ". $cDp ."  ,existe = ".$existe ."<br>" ;   
            }
            // } else {
            //     $existe =PersonalM::where('PERCVE', $value->PERCVE)->count();
            //     echo "Sin departamento  = ".$value->PERCVE." ". $value->PERNOM . " " .$value->PERAPE." " .$value->PERDEP. "  ,Depto: ". $cDp ."  ,existe = ".$existe ."<br>" ; 
            // }
        }
    }


    public function carreraM()
    {

        $carr = CarreraM::all();
        foreach ($carr  as $key => $value) {
            if (Departamento::where('id', $value->DEPCVE)->count() > 0) {
                $depto = Departamento::find($value->DEPCVE);
                if (Carrera::where('id', $value->CARCVE)->count() == 0) {

                    $carrera = Carrera::create(
                        [
                            "id" => $value->CARCVE,
                            "carrera" => $value->CARNOM,
                            "abreviatura" => $value->CARNCO,
                            "nivel" => $value->CARNIV,
                            "departamento_id" => $depto->id
                        ]
                    );
                }
            } else {
                echo "no existe depto " . $value->DEPCVE;
            }
        }
    }
    public function coordinadoresM()
    {



        $coor = CoordinadorM::all();
        foreach ($coor  as $key => $value) {
            if (Carrera::where('id', $value->carcve)->count() > 0 && Personal::where('clave', $value->percve)->count() > 0) {
                $car = Carrera::find($value->carcve);
                $per = Personal::where('clave', $value->percve)->first();
                if (Coordinador::where('id', $value->corcve)->count() == 0) {
                    $coordinador = Coordinador::firstOrCreate(
                        [
                            "id" => $value->corcve,
                            "carrera_id" => $car->id,
                            "personal_id" => $per->id,

                        ]
                    );
                }
            } else {
                echo "no existe corcve " . $value->corcve . "<br>";
                echo "no existe carcve " . $value->carcve . "<br>";
                echo "no existe perve " . $value->percve . "<br><br>";
            }
        }
    }

    public function periodoM()
    {
        // $periodo = PeriodoM::all();

        $periodo = array(
            //     ['clave' => 3111, 'periodo' => "ENE-ABR 2011"],
            //     ['clave' => 3112, 'periodo' => "MAY-AGO 2011"],
            //     ['clave' => 3113, 'periodo' => "SEP-DIC 2011"],
            //     ['clave' => 3121, 'periodo' => "ENE-ABR 2012"],
            //     ['clave' => 3122, 'periodo' => "MAY-AGO 2012"],
            //     ['clave' => 3123, 'periodo' => "SEP-DIC 2012"],
            //     ['clave' => 3131, 'periodo' => "ENE-ABR 2013"],
            //     ['clave' => 3132, 'periodo' => "MAY-AGO 2013"],
            //     ['clave' => 3133, 'periodo' => "SEP-DIC 2013"],
            //     ['clave' => 3141, 'periodo' => "ENE-ABR 2014"],
            //     ['clave' => 3142, 'periodo' => "MAY-AGO 2014"],
            //     ['clave' => 3143, 'periodo' => "SEP-DIC 2014"],
            //     ['clave' => 3151, 'periodo' => "ENE-ABR 2015"],
            //     ['clave' => 3152, 'periodo' => "MAY-AGO 2015"],
            //     ['clave' => 3153, 'periodo' => "SEP-DIC 2015"],
            //     ['clave' => 3161, 'periodo' => "ENE-ABR 2016"],
            //     ['clave' => 3162, 'periodo' => "MAY-AGO 2016"],
            //     ['clave' => 3163, 'periodo' => "SEP-DIC 2016"],
            //     ['clave' => 3172, 'periodo' => "MAY-AGO 2017"],
            //     ['clave' => 3173, 'periodo' => "SEP-DIC 2017"],
            //     ['clave' => 3181, 'periodo' => "ENE-ABR 2018"],
            //     ['clave' => 3182, 'periodo' => "MAY-AGO 2018"],
            //     ['clave' => 3183, 'periodo' => "SEP-DIC 2018"],
            //     ['clave' => 3191, 'periodo' => "ENE-ABR 2019"],
            //     ['clave' => 3201, 'periodo' => "ENE-ABR 2020"],
            //     ['clave' => 3202, 'periodo' => "MAY -AGO 2020"],
            //     ['clave' => 3203, 'periodo' => "SEP -DIC 2020"],
            //     ['clave' => 3211, 'periodo' => "ENE-ABR 2021"],
            //     ['clave' => 3171, 'periodo' => "ENE-ABR 2017"]

            ['clave' => 3212, 'periodo' => "MAY-AGO 2021"],
            ['clave' => 3213, 'periodo' => "SEP-DIC 2021"],
            ['clave' => 3221, 'periodo' => "ENE-ABR 2022"],
            ['clave' => 3222, 'periodo' => "MAY-AGO 2022"],
            ['clave' => 3223, 'periodo' => "SEP-DIC 2022"],


        );
        //    echo ($periodo);
        foreach ($periodo as $key => $value) {

            if (Periodo::where('clave', $value['clave'])->count() == 0) {
                $per = Periodo::create(
                    [
                        'periodo' => $value['periodo'],
                        'clave' => $value['clave']
                    ]
                );
            }
        }
    }
    public function materiaM()
    {
        $materia = MateriaM::all();

        foreach ($materia as $key => $value) {
            // $depto = Departamento::find($value->DEPCVE);
            // if ($depto != null) {

            if (Materia::where('clave', $value->MATCVE)->count() == 0) {
                if ($value->MATNOM != "") {

                    $materia = Materia::create([
                        'clave' => $value->MATCVE,
                        'materia' => $value->MATNOM,
                        'abreviatura' => $value->MATCVE, //$value->MATNCO,
                        'creditos' => 6, //$value->MATCRE,
                        'departamento_id' => 201 //$depto->id
                    ]);
                }
            } else {
                // echo $value->MATCVE;
                // echo " repetido:";
                // echo $value->MATNOM;
                // echo "</br>";
                // echo "</br>";
            }
        }
        // }
    }

    public function planM()
    {
        $plan = PlanM::all();
        foreach ($plan as $key => $value) {
            $carrera = Carrera::find($value->CARCVE);
            if (Plan::where('clave', $value->PLACVE)->where('plan', $value->PLACOF)->count() == 0)
                Plan::create([
                    "clave" => $value->PLACVE,
                    "plan" => $value->PLACOF,
                    'carrera_id' => $carrera->id
                ]);
        }
    }
    public function gpLi()
    {
        set_time_limit(360);
        $grupo = GrupoListaM::whereNotNull('GPONUM')->get();
        $gp = 0;
        $gL = 0;
        echo "<table>";
        foreach ($grupo as $key => $value) {

            echo   "<tr>";
            if (
                $value->CARCVE != 0 &&
                // $value->PLACVE != 0 &&
                Materia::where('clave', $value->MATCVE)->count() > 0 &&
                Carrera::where('id', $value->CARCVE)->count() > 0 &&
                Periodo::where('clave', $value->PDOCVE)->count() > 0 &&
                Personal::where('clave', $value->PERCVE)->count() > 0 &&
                $value->PERCVE != 0
            ) {

                $materia = Materia::where('clave', $value->MATCVE)->first();
                $carrera = Carrera::where('id', $value->CARCVE)->first();
                $per = Periodo::where('clave', $value->PDOCVE)->first();
                $pers = Personal::where('clave', $value->PERCVE)->first();
                // $plan = Plan::where('clave', $value->PLACVE)->where('carrera_id', $value->CARCVE)->first();
                $plan = Plan::where('clave', "A")->where('carrera_id', $value->CARCVE)->first();

                // $gp="";
                if (!$plan) {
                    $plan = Plan::where('clave', "A")->where('carrera_id', $value->CARCVE)->first();
                    // echo "aqui : " . $value . $plan;
                }
                if (
                    PeriodoDetalle::where('periodo_id', $per->id)
                    ->where('carrera_id',  $carrera->id)
                    ->where('personal_id',  $pers->id)
                    ->where('materia_id',  $materia->id)
                    ->where('grupo', $value->GPONUM)
                    ->where('plan_id',  $plan->id)->count() == 0

                ) {
                    $pl = PeriodoDetalle::firstOrCreate([
                        'periodo_id' => $per->id,
                        'carrera_id' => $carrera->id,
                        'personal_id' => $pers->id,
                        'materia_id' => $materia->id,
                        'plan_id'   => $plan->id,
                        'grupo' => $value->GPONUM
                    ]);
                }
            } else {
                echo Materia::where('clave', $value->MATCVE)->count() ==  0  ?  "  <tr></tr> <td>Materia  </td>  <td>" . $value->MATCVE . " </td> </tr> "  : "";
                echo Carrera::where('id', $value->CARCVE)->count() ==  0  ?  "  <tr> <td>Carrera  </td>  <td>" . $value->CARCVE . " </td> </tr> "  : "";
                echo Periodo::where('clave', $value->PDOCVE)->count() ==  0  ?  "  <tr> <td>Periodo  </td>  <td>" . $value->PDOCVE . " </td> </tr> "  : "";
                echo Personal::where('clave', $value->PERCVE)->count() ==  0  ?  "  <tr> <td>Persona  </td>  <td> " . $value->PERCVE . " </td> </tr> "  : "";
            }
        }
        echo "  </tr>";
        echo "<table>";

        echo $gp;
    }


    public function listaPeriodosAlumnosM()
    {
        set_time_limit(3600);

        $alumnos = ListaAlumnoPeriodoM::select('ALUCTR')->groupBy('ALUCTR')->orderByDesc('ALUCTR')->get();

        foreach ($alumnos as $index => $alumno) {
            if (ListaAlumnoPeriodoM::where('ALUCTR', $alumno->ALUCTR)->count() > 0) {
                $periodosCursados = ListaAlumnoPeriodoM::select('PDOCVE')->where('ALUCTR', $alumno->ALUCTR)->groupBy('PDOCVE')->get();
                foreach ($periodosCursados as $index2 => $periodo) {
                    $listabyPer = ListaAlumnoPeriodoM::selectRaw('PDOCVE,ALUCTR,MATCVE,GPOCVE')->where('ALUCTR', $alumno->ALUCTR)->where('PDOCVE', $periodo->PDOCVE)->get();
                    foreach ($listabyPer as $i => $perAlumn) {
                        if (
                            Periodo::where("clave", $perAlumn->PDOCVE)->count() > 0 &&
                            Materia::where("clave", $perAlumn->MATCVE)->count() > 0 &&
                            Alumno::where('matricula', $alumno->ALUCTR)->count() > 0

                        ) {
                            $per = Periodo::where("clave", $perAlumn->PDOCVE)->first();
                            $mat = Materia::where("clave", $perAlumn->MATCVE)->first();
                            $alum = Alumno::where('matricula', $alumno->ALUCTR)->first();
                            if (
                                PeriodoDetalle::where('periodo_id', $per->id)
                                ->where('materia_id', $mat->id)
                                ->where('grupo', $perAlumn->GPOCVE)
                                ->count() > 0
                            ) {
                                $perDetalle = PeriodoDetalle::where('periodo_id', $per->id)
                                    ->where('materia_id', $mat->id)
                                    ->where('grupo', $perAlumn->GPOCVE)->first();
                                $lap = ListaAlumnoPeriodo::firstOrCreate([
                                    'alumno_id' => $alum->id,
                                    'periodo_detalle_id' => $perDetalle->id
                                ]);
                            }
                        }
                    }
                }
            } else {
                echo  "s/r " . $alumno->ALUCTR . "<br>";
            }
        }
    }


    public function PreguntasYrespuestasM()
    {
        set_time_limit(3600);

        // ********************************************************
        // MIGRACION ALUMNOS LISTA PERIODO ESTATUS
        // ********************************************************

        // $matriculas = Encuesta::select('ALUCTR')->where('PDOCVE', '3222')->groupBy('ALUCTR')->orderByDesc('ALUCTR')->get();

        // foreach ($matriculas as $index => $enc) {

        //     if (str_contains($enc->ALUCTR, '@')) {
        //         $exp = explode('@', $enc->ALUCTR);
        //         $alu = Alumno::where('matricula', $exp[0])->first();
        //     } else {
        //         $alu = Alumno::where('matricula', $enc->ALUCTR)->first();
        //     }

        //     $encuesta = Encuesta::select('*')->where('ALUCTR', $enc->ALUCTR)->where('PDOCVE', '3222')->get();
        //     $per  = Periodo::where('clave', '3222')->first();
        //     // $stat = ListaAlumnoPeriodo::where('alumno_id', $alu->id)->where('created_at', '>', '2022-08-10')->get();
        //     $stat = ListaAlumnoPeriodo::select('lista_alumno_periodo.*')
        //         ->join('periodo_detalle', 'lista_alumno_periodo.periodo_detalle_id', 'periodo_detalle.id')
        //         ->join('periodo', 'periodo_detalle.periodo_id', 'periodo.id')
        //         ->where('lista_alumno_periodo.alumno_id', $alu->id)
        //         ->where('lista_alumno_periodo.created_at', '>', '2022-08-10')
        //         ->where('periodo.clave', 3222)
        //         ->get();

        // consulta sql pura para filtrat x periodo

        //  SELECT lista_alumno_periodo.*, periodo_detalle.id, periodo.id, periodo.clave FROM `lista_alumno_periodo` 
        //  INNER JOIN periodo_detalle on lista_alumno_periodo.periodo_detalle_id=periodo_detalle.id 
        //  INNER JOIN periodo on periodo_detalle.periodo_id=periodo.id 
        //  where lista_alumno_periodo.alumno_id = 4836 and lista_alumno_periodo.created_at > '2022-08-10'

        // foreach ($stat as $key => $status) {
        //     // echo  $enc->ALUCTR . "<br>";
        //     $status->status_encuesta = $encuesta[0]->ESTATUS;
        //     $status->save();
        // }

        // ********************************************************
        // FIN MIGRACION ALUMNOS LISTA PERIODO ESTATUS
        // ********************************************************

        // foreach ($encuesta as $key => $enper) {

        $det = Evaluacion::select('*')->get();
        // $ex = 0;
        foreach ($det as $i => $detByMat) {
            // $ex++;
            if (
                personal::where('clave', $detByMat->PERCVE)->count() > 0 &&
                Materia::where('clave', $detByMat->MATCVE)->count() > 0
                // Periodo::where('clave', $detByMat->IDPER)->count() > 0
            ) {
                $PERCVE = personal::where('clave', $detByMat->PERCVE)->first();
                $MATCVE = Materia::where('clave', $detByMat->MATCVE)->first();
                //         $IDPER = Periodo::where('clave', $detByMat->IDPER)->first();

                $pd = PeriodoDetalle::where('materia_id', $MATCVE->id)
                    ->where('personal_id', $PERCVE->id)
                    ->orderBy('id', 'desc')
                    // ->where('grupo', $perAlumn->GPOCVE)
                    ->first();

                if ($pd) {
                    if ($pd->periodo_id == 33) {

                        // echo  $PERCVE->id . "<br>";
                        // echo  $pd . "<br>";
                        for ($e = 1; $e < 21; $e++) {

                            $prg = Pregunta::find($e);
                            $resp =  PreguntaEvaluacion::create([
                                "periodo_detalle_id" => $pd->id,
                                "pregunta_id" => $prg->id
                            ]);
                            $repByPrg = RespuestaEvaluacion::create([
                                "pregunta_evaluacion_id" => $resp->id,
                                "puntos" => $detByMat->{"r$e"}
                            ]);
                        }
                        if ($detByMat->comentario != "") {
                            RespuestaEvaluacionComentario::create([
                                "periodo_detalle_id" => $pd->id,
                                'comentario' => $detByMat->comentario
                            ]);
                        }
                    }
                }
            } else {
                echo  $detByMat . "<br>";
            }
            // if ($ex > 100) return 0;
        }
        // }
    }
    public function migrar()
    {
        // $this->migrarAlumnos(); // correr con = .env/DB_2DATABASE=upqroo2
        // $this->deptoM();  // correr con = .env/DB_2DATABASE=upqroo
        // $this->personalM();  // correr con = .env/DB_2DATABASE=upqroo2
        // $this->carreraM();  // correr con = .env/DB_2DATABASE=upqroo
        // $this->coordinadoresM();  // correr con = .env/DB_2DATABASE=upqroo
        // $this->periodoM();  // correr con = .env/DB_2DATABASE=upqroo
        // $this->materiaM();  // correr con = .env/DB_2DATABASE=upqroo
        // $this->planM();  // correr con = .env/DB_2DATABASE=upqroo
        // $this->gpLi();  // correr con = .env/DB_2DATABASE=upqroo
        // $this->listaPeriodosAlumnossM();
        // $this->PreguntasYrespuestasM();
    }
}
