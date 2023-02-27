<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReclamationRequest;
use App\Http\Requests\UpdateReclamationRequest;
use App\Models\Reclamation;
use App\Models\ReclamationReponse;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ReclamationController extends Controller
{

    public function index()
    {
        //
    }

    public function tout()
    {

        $rec = Reclamation::all();

        return Inertia::render('Reclamations/Tout', ['reclamations' => $rec]);
    }

    public function nonTraite()
    {


        $rec = Reclamation::where('etat', 'Non Traité')->get();

        return Inertia::render('Reclamations/NonTraite', ['reclamations' => $rec]);
    }
//
    public function enCours()
    {

        $rec = Reclamation::where('etat', 'En Cours')->get();

        return Inertia::render('Reclamations/EnCours', ['reclamations' => $rec]);
    }
//
    public function fini()
    {

        $rec = Reclamation::where('etat', 'Fini')->get();
        $reponses = ReclamationReponse::all();

        return Inertia::render('Reclamations/Fini', ['reclamations' => $rec, 'reponses' => $reponses]);
    }
//
    public function cloture()
    {

        $rec = Reclamation::where('etat', 'Cloture')->get();

        return Inertia::render('Reclamations/Cloture', ['reclamations' => $rec]);
    }
//
    public function retard()
    {

        $rec = Reclamation::where('etat', '=', 'Non Traité')
            ->where('created_at', '<=', now()->subDays(5))
            ->get();

        return Inertia::render('Reclamations/NonTraiteRetard', ['reclamations' => $rec]);
    }

    public function create()
    {
        //
    }

    public function store(StoreReclamationRequest $request)
    {

        $request->validate([
            'client_nom' => 'required' ,
            'agence' => 'required',
            'description' => 'required',
            'categorie' => 'required',
            'motif' => 'required',
            'telephone_cli' => 'required',
            'niveauurgence' => 'required',
            'montant' => 'required',
            'etat' => 'required',
            'saisie_par' => 'required',
        ]);

        $rec = new Reclamation();
        $rec->client_nom = $request->client_nom;
        $rec->agence = $request->agence;
        $rec->description = $request->description;
        $rec->service= $request->categorie;
        $rec->motif = $request->motif;
        $rec->telephone_cli = $request->telephone_cli;
        $rec->montant = $request->montant;
        $rec->etat = $request->etat;
        $rec->niveauurgence = $request->niveauurgence;
        $rec->saisie_par = $request->saisie_par;

        $rec->save();

        //$user->roles()->sync($request->input('roles', []));


        return redirect()->route('reclamations.tout');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }


    public function update(UpdateReclamationRequest $request)
    {

        $rec = Reclamation::findOrFail($request->id);
        $etat = $rec->etat;

        switch ($etat) {
            case 'Non Traité':
                $rec->etat = 'En Cours';
                $rec->save();
                return redirect()->route('reclamations.encours');
            case 'En Cours':
                $rec->etat = 'Fini';
                $rec->save();

                $reponse = new ReclamationReponse();
                $reponse->rec_id = $rec->id;
                $reponse->reponse = $request->reponse;
                $reponse->repondeur = $request->repondeur;
                $reponse->save();

                return redirect()->route('reclamations.fini');
            case 'Fini':
                $rec->etat = 'Cloture';
                $rec->save();
                return redirect()->route('reclamations.cloture');
            default:
                break;
        }




    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
