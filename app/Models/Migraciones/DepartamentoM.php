<?php

namespace App\Models\Migraciones;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DepartamentoM extends Model
{
    use HasFactory;
    /**
     * 
     * tabla asociada al Modelo
     * @var string
     * 
     */
    protected $connection = "mysql2";
    protected $table = "departamento";


    /**
     * columnas de la tabla a llenar 
     *
     * @var array
     */
    
}
