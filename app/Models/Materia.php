<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Materia extends Model
{
    use HasFactory;

    protected $table = "materia";
    protected $fillable = [
        'clave',
        'materia',
        'abreviatura',
        'creditos',
        'departamento_id'
    ];
    protected $hidden = ['created_at', 'updated_at'];
}
