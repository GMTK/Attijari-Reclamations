<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reclamation extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_nom',
        'agence',
        'description',
        'service',
        'motif',
        'telephone_cli',
        'niveauurgence',
        'montant',
        'etat',
        'saisie_par',

    ];
}
