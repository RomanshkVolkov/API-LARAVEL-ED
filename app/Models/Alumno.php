<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Alumno extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    /**
     * 
     * tabla asociada al Modelo
     * @var string
     * 
     */
    protected $table = "alumno";

    protected $hidden = ['password' ,'created_at', 'updated_at'];
    /**
     * columnas de la tabla a llenar 
     *
     * @var array
     */
    protected $fillable = ["matricula", "nombre", "apellido_materno", "apellido_paterno", 'email', 'password'];
}
