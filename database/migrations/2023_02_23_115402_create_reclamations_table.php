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
            $table->string('client_nom');
            $table->string('agence');
            $table->string('description');
            $table->string('service');
            $table->string('motif');
            $table->string('montant')->nullable();
            $table->string('niveauurgence');
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
