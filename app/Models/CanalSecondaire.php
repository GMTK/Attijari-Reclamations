<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CanalSecondaire extends Model
{
    use HasFactory;
    protected $fillable = [
        'titreCanalSecondaire'
    ];
}
