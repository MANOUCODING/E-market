<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppreciationSemestre extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function classesAppreciationSemestres(){

        return $this->belongsTo(Classe::class);

    }
}
