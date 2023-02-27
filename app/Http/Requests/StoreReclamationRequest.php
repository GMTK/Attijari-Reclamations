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
            'agence'     => [
                'string',
                'required',
            ],
            'categorie'     => [
                'string',
                'required',
            ],
            'etat'     => [
                'string',
                'required',
            ],

            'niveauurgence'     => [
                'string',
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
