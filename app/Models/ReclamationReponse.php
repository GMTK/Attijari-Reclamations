<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReclamationReponse extends Model
{
    use HasFactory;

    protected $fillable = [
        'reponse',
        'repondeur',
    ];
}
