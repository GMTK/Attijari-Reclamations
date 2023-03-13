<?php

namespace App\Http\Controllers;

use App\Exports\ReclamationsExport;
use App\Http\Requests\StoreReclamationRequest;
use App\Http\Requests\UpdateReclamationRequest;
use App\Models\Agence;
use App\Models\Canal;
use App\Models\CanalSecondaire;
use App\Models\Categorie;
use App\Models\Devise;
use App\Models\Famille;
use App\Models\Monetique;
use App\Models\NivService;
use App\Models\NivUrg;
use App\Models\Reclamation;
use App\Models\ReclamationReponse;
use App\Models\TypeClient;
use Illuminate\Http\Request;
use Illuminate\Notifications\Facades\Vonage;
use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;

class ReclamationController extends Controller
{

    public function index()
    {
        $agence = Agence::all();
        $canal = Canal::all();
        $canal2 = CanalSecondaire::all();
        $categorie = Categorie::all();
        $devise = Devise::all();
        $monetique = Monetique::all();
        $nivService = NivService::all();
        $nivUrg = NivUrg::all();
        $typeClient = TypeClient::all();
        $famille = Famille::all();

        return Inertia::render('Saisir', [
            'agence' => $agence ,
            'canal' => $canal,
            'canal2' => $canal2,
            'categorie' => $categorie,
            'devise' => $devise,
            'monetique' => $monetique,
            'nivService' => $nivService,
            'nivUrg' => $nivUrg,
            'typeClient' => $typeClient,
            'famille' => $famille,

        ]);
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
            'agence_id' => 'required',
            'description' => 'required',
            'categorie_id' => 'required',
            'motif' => 'required',
            'telephone_cli' => 'required',
            'NivUrgence_id' => 'required',
            'compte' => 'required',
            'marche' => 'required',
            'montant' => 'required',
            'monetique_id' => 'required',
            'devise_id' => 'required',
            'familleReclamation_id' => 'required',
            'canal_id' => 'required',
            'canalSecondaire_id' => 'required',
            'NivService_id' => 'required',
            'typeClient_id' => 'required',
            'ReclamationRelance' => 'required',
            'ReclamationFonde' => 'required',
            'commentaire' => 'required',
            'etat' => 'required',
            'saisie_par' => 'required',
        ]);

        $rec = new Reclamation();
        $rec->client_nom = $request->client_nom;
        $rec->agence_id = $request->agence_id;
        $rec->description = $request->description;
        $rec->categorie_id= $request->categorie_id;
        $rec->devise_id = $request->devise_id;
        $rec->marche = $request->marche;
        $rec->motif = $request->motif;
        $rec->monetique_id = $request->monetique_id;
        $rec->compte = $request->compte;
        $rec->familleReclamation_id = $request->familleReclamation_id;
        $rec->commentaire = $request->commentaire;
        $rec->canal_id = $request->canal_id;
        $rec->canalSecondaire_id = $request->canalSecondaire_id;
        $rec->typeClient_id = $request->typeClient_id;
        $rec->ReclamationFonde = $request->ReclamationFonde;
        $rec->NivService_id = $request->NivService_id;
        $rec->ReclamationRelance = $request->ReclamationRelance;
        $rec->telephone_cli = $request->telephone_cli;
        $rec->montant = $request->montant;
        $rec->etat = $request->etat;
        $rec->NivUrgence_id = $request->NivUrgence_id;
        $rec->saisie_par = $request->saisie_par;

        $rec->save();

        //$this->sendSMS('22241645418', 'Votre Reclamation A été Bien Saisie, Veuillez Patienté Le Commencement du Traitement');



        return redirect()->route('saisir');
    }

    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        //
    }


    public function sendSMS(String $vers, String $message) {

        $basic  = new \Vonage\Client\Credentials\Basic("c00e9229", "dAuDZFJxsi5zXQhA");
        $client = new \Vonage\Client($basic);

        $response = $client->sms()->send(
            new \Vonage\SMS\Message\SMS($vers, 'MAFIA 007', $message)
        );

        $message = $response->current();

        if ($message->getStatus() == 0) {
            echo "The message was sent successfully\n";
        } else {
            echo "The message failed with status: " . $message->getStatus() . "\n";
        }

    }

    public function update(UpdateReclamationRequest $request)
    {

        $rec = Reclamation::findOrFail($request->id);
        $etat = $rec->etat;;

        switch ($etat) {
            case 'Non Traité':
                $rec->etat = 'En Cours';
                $rec->save();

                //$this->sendSMS("222".$rec->telephone_cli, 'Le Traitement de votre Reclamation A Commencé ');

                return redirect()->route('reclamations.encours');
            case 'En Cours':
                $rec->etat = 'Fini';
                $rec->save();

                $reponse = new ReclamationReponse();
                $reponse->rec_id = $rec->id;
                $reponse->reponse = $request->reponse;
                $reponse->repondeur = $request->repondeur;
                $reponse->save();

                //$this->sendSMS('22241645418', 'Le Traitement de votre Reclamation est Fini \n Veuillez Retourner A la Banque Pour recevoir votre reponse');

                return redirect()->route('reclamations.fini');
            case 'Fini':
                $rec->etat = 'Cloture';
                $rec->save();

                //$this->sendSMS('22241645418', 'Votre Reclamation A été Cloturé');

                return redirect()->route('reclamations.cloture');
            default:
                break;
        }




    }

    public function export()
    {

        $recs = Reclamation::all();

        $data = [];

        // loop through users and add to $data array
        foreach ($recs as $rec) {
            $data[] = [
                'Référence Réclamation' => 'REC000'.$rec->id,
                'Date réception' => $rec->created_at,
                'Canal principal  : 1er  canal par lequel la réclamation a été remontée' => '',
                'Canal secondaire  : 2ème canal éventuelle par lequel la réclamation a été remontée, doublement' => '',
                'Niveau d\'urgence de la réclamation (Forte, Normale, faible)' => $rec->niveauurgence,
                'La réclamation a fait l\'objet d\'une relance (Via le même canal principal (Oui/Non)' => '',
                'Réclamation  Fondée ? (Oui/Non)' => '',
                'Famille Réclamation' => '',
                'Catégorie Réclamation' => '',
                'Marché' => '',
                'Niveau Service' => '',
                'Agence du client' => $rec->agence,
                'Compte' => '',
                'Nom client' => $rec->client_nom,
                'Montant réclamé' => $rec->montant,
                'Devise' => '',
                'Motif de la réclamation' => $rec->motif,
                'Description de la réclamtion' => $rec->description,
                'Entité traitante' => '',
                'Réclamation retourné par la Qualification pour complèment d\'information (Oui/Non)' => '',
                'Motif de retour par la Qualification' => '',
                'Date de re envoie de la réclamation à la Qualifification après complètude d\'information' => '',
                'Date de Traitement' => '',
                'Date de clôture' => '',
                'Statut' => $rec->etat,
                'Commentaires                                 (si observations)' => '',
                // add more fields as needed
            ];
        }

        $headers = [
            'Content-Disposition' => 'attachment; filename="users.xlsx"',
        ];

        return Excel::download(new ReclamationsExport($data), 'reclamations.xlsx', null, $headers);
//        return response()->download((new ReclamationsExport($data))->store('users.xlsx', 'public'), 'users.xlsx', $headers);
    }

    public function destroy($id)
    {
        //
    }
}
