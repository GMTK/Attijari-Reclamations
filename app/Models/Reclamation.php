<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reclamation extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_nom',
        'agence_id',
        'description',
        'categorie-id',
        'motif',
        'telephone_cli',
        'devise_id',
        'compte',
        'canal_id',
        'monetique_id',
        'typeClient_id',
        'canalSecondaire',
        'NivService_id',
        'ReclamationFonde',
        'ReclamationRelance',
        'familleReclamation_id',
        'commentaire',
        'marche',
        'NivUrgence_id',
        'montant',
        'etat',
        'saisie_par',

    ];
}
