<?php

namespace App\Models\Migraciones;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlumnoM extends Model
{
    use HasFactory;
    /**
     * 
     * tabla asociada al Modelo
     * @var string
     * 
     */
    protected $connection = "mysql2";
    protected $table = "alumno";


    /**
     * columnas de la tabla a llenar 
     *
     * @var array
     */
    protected $fillable = ["matricula", "nombre", "apellido_materno", "apellido_paterno"];
}
