<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RespuestaEvaluacionComentario extends Model
{
    use HasFactory;

    public  $timestamps = false;
    protected $table = 'respuesta_evaluacion_comentario';
    protected $fillable = ["periodo_detalle_id","comentario"];
    protected $hidden = ['created_at','updated_at'];
}
