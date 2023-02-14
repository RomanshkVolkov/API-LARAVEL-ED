<?php

namespace App\Models\Migraciones;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeriodoM extends Model
{
    use HasFactory;

    protected $connection = "mysql2";
    protected $table = "periodo";
}
