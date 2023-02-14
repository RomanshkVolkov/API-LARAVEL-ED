<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pregunta extends Model
{
    use HasFactory;

    public  $timestamps = false;

    protected $table = 'pregunta';
    protected $fillable = ["pregunta","tipo"];

    protected $hidden = ['created_at','updated_at'];

}
