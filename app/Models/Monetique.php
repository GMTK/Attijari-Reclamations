<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Monetique extends Model
{
    use HasFactory;
    protected $fillable = [
        'titreMonet'
    ];
}
