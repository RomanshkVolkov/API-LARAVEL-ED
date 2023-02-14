<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carrera extends Model
{
    use HasFactory;

    protected $table = "carrera";

    protected $fillable = [
        "id",
        "carrera",
        "abreviatura",
        "nivel",
        "departamento_id"
    ];
    protected $hidden = ['created_at','updated_at','departamento_id'];

    public function departamento()
    {
        return $this->hasOne(Departamento::class,'id','departamento_id');
    }
    
}
