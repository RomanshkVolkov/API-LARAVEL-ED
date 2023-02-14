<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RespuestaEvaluacion extends Model
{
    use HasFactory;

    public  $timestamps = false;
    protected $table = 'respuesta_evaluacion';
    protected $fillable = ["pregunta_evaluacion_id","puntos"];

    protected $hidden = ['created_at','updated_at'];
}
