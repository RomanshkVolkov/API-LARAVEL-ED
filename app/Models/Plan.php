<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;
    protected $table = "plan";
    protected $fillable = [
        "clave",
        "plan",
        'carrera_id'
    ];
    public $timestamps = false;
}
