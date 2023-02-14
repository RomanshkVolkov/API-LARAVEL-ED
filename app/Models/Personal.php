<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


class Personal extends  Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = "personal";
    protected $hidden = ['password', 'created_at', 'updated_at', 'departamento_id'];

    protected $guard = 'personal';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ["clave", "nombre", "apellido_paterno", "apellido_materno", "sexo", "departamento_id", 'email', 'password'];
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    protected $timestamp = false;

    public function coordinador()
    {
        return $this->hasOne(Coordinador::class);
    }

    public function departamento()
    {
        return $this->hasOneThrough(Carrera::class, Departamento::class);
    }

    public function materias()
    {
        return $this->hasMany(Materia::class);
    }

    public function carrera()
    {

        return $this->hasOneThrough(
            Carrera::class,
            Coordinador::class,
            'personal id', // Foreign key on the coordinador table...
            'carrera_id', // Foreign key on the carrera table...
            'id', // Local key on the personal table...
            'id' // Local key on the cars table...
        );
    }
}
