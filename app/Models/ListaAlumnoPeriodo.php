<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListaAlumnoPeriodo extends Model
{
    use HasFactory;

    protected $table = 'lista_alumno_periodo';
    public $fillable = [
        'alumno_id',
        'periodo_detalle_id',
        'status_encuesta'
    ];

    protected $hidden = [
        'id',
        'periodo_detalle_id',
        'created_at',
        'updated_at'
    ];
    public function alumno()
    {
        return  $this->hasOne(Alumno::class, 'id', 'alumno_id');
    }
}
