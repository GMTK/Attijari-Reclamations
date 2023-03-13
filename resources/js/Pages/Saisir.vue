<script setup>
import AuthenticatedLayout from '@/Layouts/Authenticated.vue'
import Button from '@/Components/Button.vue'
import Input from '@/Components/Input.vue'
import Label from '@/Components/Label.vue'
import ValidationErrors from '@/Components/ValidationErrors.vue'

</script>

<script>

import {usePage} from "@inertiajs/inertia-vue3";
import Swal from "sweetalert2";

export default {

    props: [
        'agence',
        'canal',
        'canal2',
        'categorie',
        'devise',
        'monetique',
        'nivService',
        'nivUrg',
        'typeClient',
        'famille'
    ],

    data() {
        return {

            form: this.$inertia.form({
                client_nom:'',
                agence_id:'',
                description:'',
                categorie_id:'',
                motif:'',
                telephone_cli:'',
                NivUrgence_id:'',
                montant: '',
                devise_id: '',
                monetique_id: '',
                typeClient_id: '',
                NivService_id: '',
                familleReclamation_id:'',
                ReclamationFonde:'',
                canal_id:'',
                canalSecondaire_id:'',
                ReclamationRelance:'',
                marche: '',
                compte:'',
                commentaire:'',
                etat: 'Non Traité',
                saisie_par: usePage().props.value.auth.user.name,
                terms: false,
            })

        }
    },

    methods: {
        submit() {
            this.form.post(route('reclamation.store'), {
                onSuccess: () => {
                    this.swalAlert('La Reclamation a été bien saisie avec succés')
                    this.form.reset()
                },
            })
        },

        swalAlert(text) {
            Swal.fire({
                title: 'Succés',
                text: text,
                background: 'rgba(255, 255, 255, 1)',
                icon: 'success',
                backdrop: 'rgba(107, 114, 128, 0.75)',
                confirmButtonColor: '#3b81f6'
            })
        },
    }

}

</script>



<template>
    <AuthenticatedLayout title="Saisir">
        <template #header>
            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <h2 class="text-xl font-semibold leading-tight ml-8">
                    Saisir une reclamation
                </h2>
            </div>
        </template>

        <ValidationErrors class="mb-4" />

        <form @submit.prevent="this.submit">
            <div class="grid md:grid-cols-2 md:gap-6">

                <div class="w-full  p-3">
                    <div class="flex flex-col rounded overflow-hidden h-auto shadow shadow-lg">
                        <div class="bg-white rounded-b lg:rounded-b-none lg:rounded-r p-4 flex flex-col justify-between leading-normal">
                            <div class="text-black font-bold text-xl mb-2 leading-tight">Informations De La Reclamation</div>
                            <div class="w-full px-3 mb-3">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-1 mt-2 dark:text-gray-300" for="canal_id">
                                    Canal Primaire
                                </label>
                                <select v-model="form.canal_id" class="block appearance-none w-full bg-white mt-1 border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline dark:border-gray-600 dark:bg-dark-eval-1 dark:text-gray-300 dark:focus:ring-offset-dark-eval-1">
                                    <option value="" selected disabled hidden>Choisir un Canal Primaire</option>
                                    <option v-for="canal in this.canal" :value="canal.id">{{ canal['titreCanal'] }}</option>
                                </select>
                            </div>
                            <div class="w-full px-3 mb-3">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-1 mt-2 dark:text-gray-300" for="canalSecondaire_id">
                                    Canal Secondaire
                                </label>
                                <select v-model="form.canalSecondaire_id" class="block appearance-none w-full bg-white mt-1 border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline dark:border-gray-600 dark:bg-dark-eval-1 dark:text-gray-300 dark:focus:ring-offset-dark-eval-1">
                                    <option value="" selected disabled hidden>Choisir un Canal Secondaire</option>
                                    <option v-for="canal2 in this.canal2" :value="canal2.id">{{ canal2['titreCanalSecondaire'] }}</option>
                                </select>
                            </div>
                            <div class="w-full px-3 mb-3">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-1 mt-2 dark:text-gray-300" for="Urg_id">
                                    Niveau D'urgence
                                </label>
                                <select v-model="form.NivUrgence_id" class="block appearance-none w-full bg-white mt-1 border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline dark:border-gray-600 dark:bg-dark-eval-1 dark:text-gray-300 dark:focus:ring-offset-dark-eval-1">
                                    <option value="" selected disabled hidden>Choisir un Niveau D'Urgence</option>
                                    <option v-for="nivUrg in this.nivUrg" :value="nivUrg.id">{{ nivUrg['titreUrg'] }}</option>

                                </select>
                            </div>
                            <div class="w-full px-3 mb-3">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-1 mt-2 dark:text-gray-300" for="relance">
                                    Relance
                                </label>
                                <select v-model="form.ReclamationRelance" class="block appearance-none w-full bg-white mt-1 border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline dark:border-gray-600 dark:bg-dark-eval-1 dark:text-gray-300 dark:focus:ring-offset-dark-eval-1">
                                    <option value="" selected disabled hidden>Est une Relance ?</option>
                                    <option value="OUI">OUI</option>
                                    <option value="NON">NON</option>
                                </select>
                            </div>
                            <div class="w-full px-3 mb-3">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-1 mt-2 dark:text-gray-300" for="RecRt">
                                    Reclamation Fondé
                                </label>
                                <select v-model="form.ReclamationFonde" class="block appearance-none w-full bg-white mt-1 border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline dark:border-gray-600 dark:bg-dark-eval-1 dark:text-gray-300 dark:focus:ring-offset-dark-eval-1">
                                    <option value="" selected disabled hidden>Reclamation Fondé ?</option>
                                    <option value="OUI">OUI</option>
                                    <option value="NON">NON</option>
                                </select>
                            </div>
                            <div class="w-full px-3 mb-3">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-1 mt-2 dark:text-gray-300" for="famille">
                                    Famille Reclamation
                                </label>
                                <select v-model="form.familleReclamation_id" class="block appearance-none w-full bg-white mt-1 border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline dark:border-gray-600 dark:bg-dark-eval-1 dark:text-gray-300 dark:focus:ring-offset-dark-eval-1">
                                    <option value="" selected disabled hidden>Choisir une Famille de Reclamation</option>
                                    <option v-for="famille in this.famille" :value="famille.id">{{ famille['titreFamilleRec'] }}</option>
                                </select>

                            </div>
                            <div class="w-full px-3 mb-3">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-1 mt-2 dark:text-gray-300" for="cat_id">
                                    Categorie
                                </label>
                                <select v-model="form.categorie_id" class="block appearance-none shadow w-full bg-white mt-1 border border-blue-500 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline dark:border-gray-600 dark:bg-dark-eval-1 dark:text-gray-300 dark:focus:ring-offset-dark-eval-1">
                                    <option value="" selected disabled hidden>Choisir une Categorie</option>
                                    <option v-for="categorie in this.categorie" :value="categorie.id">{{ categorie['titreCat'] }}</option>

                                </select>
                            </div>
                            <div class="w-full px-3 mb-3">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-1 mt-2 dark:text-gray-300" for="mon_id">
                                    Monetique
                                </label>
                                <select v-model="form.monetique_id" class="block appearance-none w-full bg-white mt-1 border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline dark:border-gray-600 dark:bg-dark-eval-1 dark:text-gray-300 dark:focus:ring-offset-dark-eval-1">
                                    <option value="" selected disabled hidden>Choisir une Monetique</option>
                                    <option v-for="monetique in this.monetique" :value="monetique.id">{{ monetique['titreMonet'] }}</option>

                                </select>
                            </div>
                            <div class="w-full px-3 mb-3">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-1 mt-2 dark:text-gray-300" for="Niv_id">
                                    Niveau Service
                                </label>
                                <select v-model="form.NivService_id" class="block appearance-none w-full bg-white mt-1 border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline dark:border-gray-600 dark:bg-dark-eval-1 dark:text-gray-300 dark:focus:ring-offset-dark-eval-1">
                                    <option value="" selected disabled hidden>Choisir un Niveau de Service</option>
                                    <option v-for="nivService in this.nivService" :value="nivService.id">{{ nivService['titreNiv'] }}</option>
                                </select>
                            </div>
                            <div class="w-full px-3 mb-3">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-1 mt-2 dark:text-gray-300" for="motif">
                                    Motif
                                </label>
                                <Input  id="motif" type="text" placeholder="---"  class="shadow appearance-none border border-blue-500 rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline" v-model="form.motif" required autofocus autocomplete="motif" />
                            </div>
                            <div class="w-full px-3 mb-3">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2 mt-3 dark:text-gray-300" for="description">
                                    Description
                                </label>
                                <textarea id="description" rows="2" v-model="form.description" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Leave a comment..." required></textarea>

                            </div>
                            <div class="w-full px-3 mb-3">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2 mt-3 dark:text-gray-300" for="commentaire">
                                    Commentaire(si observation)
                                </label>
                                <textarea id="commentaire" rows="2" v-model="form.commentaire" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Leave a comment..." required></textarea>

                            </div>
                        </div>
                    </div>
                </div>


                <div class="w-full  p-3">
                    <div class="flex flex-col rounded overflow-hidden h-auto shadow shadow-lg">
                        <div class="bg-white rounded-b lg:rounded-b-none lg:rounded-r p-4 flex flex-col justify-between leading-normal">
                            <div class="text-black font-bold text-xl mb-2 leading-tight">Informations Du Client</div>
                            <div class="w-full px-3 mb-3">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-1 mt-2 dark:text-gray-300" for="agence_id">
                                    Agence du client
                                </label>
                                <select v-model="form.agence_id" class="block appearance-none w-full bg-white mt-1 border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline dark:border-gray-600 dark:bg-dark-eval-1 dark:text-gray-300 dark:focus:ring-offset-dark-eval-1">
                                    <option value="" selected disabled hidden>Choisir une Agence</option>
                                    <option v-for="agence in this.agence" :value="agence.id">{{ agence['titreAg'] }}</option>
                                </select>
                            </div>
                            <div class="w-full px-3 mb-3">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-1 mt-2 dark:text-gray-300" for="type_id">
                                    Type Client
                                </label>
                                <select v-model="form.typeClient_id" class="block appearance-none w-full bg-white mt-1 border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline dark:border-gray-600 dark:bg-dark-eval-1 dark:text-gray-300 dark:focus:ring-offset-dark-eval-1">
                                    <option value="" selected disabled hidden>Choisir un Type de Client</option>
                                    <option v-for="typeClient in this.typeClient" :value="typeClient.id">{{ typeClient['titreCli'] }}</option>
                                </select>
                            </div>
                            <div class="w-full px-3 mb-3">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-1 mt-2 dark:text-gray-300" for="compte">
                                    Compte du Client
                                </label>
                                <Input  id="compte" type="text" placeholder="---" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" v-model="form.compte" required autofocus autocomplete="compte" />
                            </div>

                            <div class="w-full px-3 mb-3">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-1 mt-2 dark:text-gray-300" for="client_nom">
                                    Nom Client
                                </label>
                                <Input  id="client_nom" type="text" placeholder="---" class="shadow appearance-none border border-blue-500 rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline" v-model="form.client_nom" required autofocus autocomplete="client_nom" />
                            </div>
                            <div class="w-full px-3 mb-3">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-1 mt-2 dark:text-gray-300" for="telephone_cli">
                                    Telephone Du Client
                                </label>
                                <Input  id="telephone_cli" type="text" placeholder="---" class="shadow appearance-none border border-blue-500 rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline" v-model="form.telephone_cli" required autofocus autocomplete="telephone_cli" />
                            </div>
                            <div class="w-full px-3 mb-3">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-1 mt-2 dark:text-gray-300" for="marche">
                                    Marché
                                </label>
                                <Input  id="marche" type="text" placeholder="---"  class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" v-model="form.marche" required autofocus autocomplete="marche" />
                            </div>
                            <div class="w-full px-3 mb-3">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-1 mt-2 dark:text-gray-300" for="montant">
                                    Montant Reclamé
                                </label>
                                <Input  id="montant" type="text" placeholder="---" class="shadow appearance-none border border-blue-500 rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline" v-model="form.montant" required autofocus autocomplete="montant" />
                            </div>
                            <div class="w-full px-3 mb-3">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-1 mt-2 dark:text-gray-300" for="dev_id">
                                    Devise
                                </label>
                                <select v-model="form.devise_id" class="block appearance-none w-full bg-white mt-1 border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline dark:border-gray-600 dark:bg-dark-eval-1 dark:text-gray-300 dark:focus:ring-offset-dark-eval-1">
                                    <option value="" selected disabled hidden>Choisir une Devise</option>
                                    <option v-for="devise in this.devise" :value="devise.id">{{ devise['titreDevi'] }}</option>

                                </select>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="mt-6 flex justify-end">
                <Button class="w-32 h-12" variant="secondary" type="reset">
                    Annuler
                </Button>

                <Button
                    variant="primary"
                    class="ml-3 w-32 h-12"
                    :disabled="form.processing"
                >
                    Confirmer
                </Button>
            </div>


<!--            <div class="grid md:grid-cols-2 md:gap-6">-->

<!--            </div>-->
<!--            <div class="grid md:grid-cols-4 md:gap-6">-->
<!--            </div>-->
<!--            <div class="grid md:grid-cols-4 md:gap-6 mt-2">-->
<!--            </div>-->

<!--            <div class="grid md:grid-cols-2 md:gap-6 mt-2">-->

<!--            </div>-->
<!--            <div class="grid md:grid-cols-4 md:gap-6 mt-2">-->

<!--            </div>-->

<!--            <div class="grid md:grid-cols-2 md:gap-6 mt-2">-->



<!--            </div>-->
<!--            <div class="grid md:grid-cols-2 md:gap-6">-->

<!--            </div>-->
        </form>


    </AuthenticatedLayout>

</template>
