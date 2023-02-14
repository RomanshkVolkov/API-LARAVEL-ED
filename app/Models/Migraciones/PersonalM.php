<?php

namespace App\Models\Migraciones;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonalM extends Model
{
    use HasFactory;
    /**
     * 
     * tabla asociada al Modelo
     * @var string
     * 
     */
    protected $connection = "mysql2";
    protected $table = "personal";


    /**
     * columnas de la tabla a llenar 
     *
     * @var array
     */
    protected $fillable = ["id" , "nombre" , "apellido_paterno" , "apellido_materno" , "sexo" , "departamento_id"];
}
