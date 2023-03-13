<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reclamations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('canal_id')->references('id')->on('Canals')->cascadeOnDelete();
            $table->foreignId('canalSecondaire_id')->references('id')->on('canal_secondaires')->cascadeOnDelete();
            $table->foreignId('NivUrgence_id')->references('id')->on('niv_urgs')->cascadeOnDelete();
            $table->string('ReclamationRelance');
            $table->string('ReclamationFonde');
            $table->foreignId('familleReclamation_id')->references('id')->on('familles')->cascadeOnDelete();
            $table->foreignId('categorie_id')->references('id')->on('categories')->cascadeOnDelete();
            $table->string('marche');
            $table->foreignId('NivService_id')->references('id')->on('niv_services')->cascadeOnDelete();
            $table->foreignId('agence_id')->references('id')->on('agences')->cascadeOnDelete();
            $table->string('compte');
            $table->string('client_nom');
            $table->string('montant');
            $table->foreignId('devise_id')->references('id')->on('devises')->cascadeOnDelete();
            $table->string('motif');
            $table->string('description');
            $table->foreignId('monetique_id')->references('id')->on('monetiques')->cascadeOnDelete();
            $table->foreignId('typeClient_id')->references('id')->on('type_clients')->cascadeOnDelete();
            $table->string('commentaire');
            $table->string('telephone_cli');
            $table->string('etat');
            $table->string('saisie_par');
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reclamations');
    }
};
