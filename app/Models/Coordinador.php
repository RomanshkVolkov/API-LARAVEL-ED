<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coordinador extends Model
{
    use HasFactory;

    protected $table = "coordinador";
    protected $fillable = ['id', 'personal_id','carrera_id'];
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    protected $hidden = ['created_at','updated_at','personal_id','carrera_id'];
    
    public function carrera()
    {
        return $this->belongsTo(Carrera::class );
    }
    public function departamento()
    {
        return $this->hasOneThrough(Departamento::class , Carrera::class , 'departamento_id','carrera_id',);
    }
    
}
