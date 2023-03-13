<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
class StoreReclamationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [

            'description'     => [
                'string',
                'required',
            ],
            'agence_id'     => [
                'required',
            ],
            'categorie_id'     => [
                'required',
            ],
            'etat'     => [
                'string',
                'required',
            ],

            'NivUrgence_id'     => [
                'required',
            ],
            'motif'     => [
                'string',
                'required',
            ],
            'montant'     => [
                'string',
                'required',
            ],
            'devise_id'     => [
                'required',
            ],
            'monetique_id'     => [
                'required',
            ],
            'canal_id'     => [
                'required',
            ],
            'canalSecondaire_id'     => [
                'required',
            ],
            'typeClient_id'     => [
                'required',
            ],
            'marche'     => [
                'string',
                'required',
            ],
            'compte'     => [
                'string',
                'required',
            ],
            'ReclamationRelance'     => [
                'string',
                'required',
            ],
            'NivService_id'     => [
                'required',
            ],
            'familleReclamation_id'     => [
                'required',
            ],
            'ReclamationFonde'     => [
                'string',
                'required',
            ],
            'commentaire'     => [
                'string',
                'required',
            ],
            'telephone_cli'   => [
                'string' ,
                'required',
            ],
            'client_nom' => [
                'string',
                'required',
            ],
            'saisie_par' => [
                'string',
                'required',
            ],
        ];
    }
}
