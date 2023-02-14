<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PreguntaEvaluacion extends Model
{
    use HasFactory;
    public  $timestamps = false;

    protected $table = 'pregunta_evaluacion';
    protected $fillable = ["periodo_detalle_id", "pregunta_id"];
    protected $hidden = ['created_at', 'updated_at'];
    public function respuesta()
    {
        return $this->hasMany(RespuestaEvaluacion::class, 'pregunta_evaluacion_id');
    }
    public function pregunta()
    {
        return $this->hasMany(Pregunta::class, 'id', 'pregunta_id');
    }
}
