<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeriodoDetalle extends Model
{
    use HasFactory;

    protected $table = "periodo_detalle";
    protected $fillable = [
        'periodo_id',
        'carrera_id',
        'personal_id',
        'materia_id',
        'plan_id',
        'grupo'
    ];
    protected $hidden = ['created_at', 'updated_at'];
    public  $timestamps = false;

    public function periodo()
    {
        return $this->belongsTo(Periodo::class, 'id', 'periodo_id');
    }

    public function personal()
    {
        return $this->belongsTo(
            Personal::class,
        );
    }
    public function materia()
    {
        return $this->hasOne(Materia::class, 'id', 'materia_id');
    }

    public function comentariosEvaluacion()
    {
        return $this->hasMany(RespuestaEvaluacionComentario::class);
    }


    public function preguntas()
    {
        return $this->hasMany(PreguntaEvaluacion::class);
    }
}
