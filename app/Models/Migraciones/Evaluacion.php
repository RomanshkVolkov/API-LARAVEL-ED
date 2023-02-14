<?php

namespace App\Models\Migraciones;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evaluacion extends Model
{
    use HasFactory;
    protected $connection = "mysql2";
    protected $table = "evaluacionalu";
}
