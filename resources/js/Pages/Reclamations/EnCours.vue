<script setup>
import AuthenticatedLayout from '@/Layouts/Authenticated.vue'
import Modal from '@/Components/Modal.vue'
import Button from '@/Components/Button.vue'
import {nextTick, ref} from "vue";
import {useForm} from "@inertiajs/inertia-vue3";

</script>

<script>

import {usePage} from "@inertiajs/inertia-vue3";

export default {

    props: ['reclamations'],

    data() {
        return {
            confirmingRecDetails: false,

            finishingTraitement: false,


            rec_details: {
                id: '',
                client:'',
                agence:'',
                description:'',
                categorie:'',
                motif:'',
                tel:'',
                nivUrg:'',
                montant: '',
                etat: '',
                saisie_par: '',
                created_at: '',
                updated_at: '',

            },

            form: this.$inertia.form({
                id: 0,
                reponse: '',
                repondeur: usePage().props.value.auth.user.name,
            })
        }
    },

    methods: {

        closeModal() {
            this.confirmingRecDetails = false
        },

        closeModal2() {
            this.finishingTraitement = false
        },

        confirmRecDetails(rec) {

            this.rec_details.id = rec.id
            this.rec_details.client = rec.client_nom
            this.rec_details.agence = rec.agence
            this.rec_details.description = rec.description
            this.rec_details.categorie = rec.service
            this.rec_details.motif = rec.motif
            this.rec_details.tel = rec.telephone_cli
            this.rec_details.nivUrg = rec.niveauurgence
            this.rec_details.montant = rec.montant
            this.rec_details.etat = rec.etat
            this.rec_details.created_at = rec.created_at
            this.rec_details.updated_at = rec.updated_at
            this.rec_details.saisie_par = rec.saisie_par

            this.confirmingRecDetails = true
        },

        finishTraitement(rec) {

            this.form.id = rec.id
            this.finishingTraitement = true

        },

        updateRec() {

            this.form.post(route('reclamations.update'),{
                preserveScroll: true,
                onSuccess: () => {
                    this.closeModal()
                    this.closeModal2()
                },
            })

        }


    }
}

</script>



<template>
    <AuthenticatedLayout title="Tout">
        <template #header>
            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <h2 class="text-xl font-semibold leading-tight ml-8">
                    Liste des Reclamations En cours De Traitement
                </h2>
            </div>
        </template>

        <div>
            <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
                <div class="flex flex-col">
                    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                            <div class="shadow overflow-hidden border-b border-gray-200 dark:border-gray-500 sm:rounded-lg">
                                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-500 w-full">
                                    <thead>
                                    <tr>
                                        <th scope="col" width="50" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            ID
                                        </th>
                                        <th scope="col" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Motif
                                        </th>
                                        <th scope="col" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Categorie
                                        </th>
                                        <th scope="col" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Nivesu Urgence
                                        </th>
                                        <th scope="col" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Agence
                                        </th>
                                        <th scope="col" width="200" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Actions
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200 dark:divide-gray-500">

                                    <tr v-for="rec in reclamations">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ rec.id }}
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ rec.motif }}
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ rec.service }}
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ rec.niveauurgence }}
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ rec.agence }}
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">

                                            <a href="#" @click="this.confirmRecDetails(rec)" class="text-blue-600 hover:text-blue-900 mb-2 mr-2">Details</a>

                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>


    </AuthenticatedLayout>

    <Modal :show="this.confirmingRecDetails" @close="this.closeModal" >
        <div>
            <div class="max-w-6xl mx-auto py-7 sm:px-6 lg:px-8">

                <div class="flex flex-col">
                    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8 " >
                        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                            <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-500 w-full">
                                    <tr class="border-b">
                                        <th scope="col" class="px-6 w-20 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            ID Reclamation
                                        </th>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 bg-white divide-y divide-gray-200 dark:divide-gray-500">
                                            {{ this.rec_details.id }}
                                        </td>
                                    </tr>

                                    <tr class="border-b">
                                        <th scope="col" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Motif
                                        </th>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 bg-white divide-y divide-gray-200 dark:divide-gray-500">
                                            {{ this.rec_details.motif }}
                                        </td>
                                    </tr>

                                    <tr class="border-b">
                                        <th scope="col" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Categorie
                                        </th>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 bg-white divide-y divide-gray-200 dark:divide-gray-500">
                                            {{ this.rec_details.categorie }}
                                        </td>
                                    </tr>

                                    <tr class="border-b">
                                        <th scope="col" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Nom du Client
                                        </th>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 bg-white divide-y divide-gray-200 dark:divide-gray-500">
                                            {{ this.rec_details.client }}
                                        </td>
                                    </tr>

                                    <tr class="border-b">
                                        <th scope="col" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Telephone Du Client
                                        </th>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 bg-white divide-y divide-gray-200 dark:divide-gray-500">
                                            {{ this.rec_details.tel }}
                                        </td>
                                    </tr>

                                    <tr class="border-b">
                                        <th scope="col" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Agence
                                        </th>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 bg-white divide-y divide-gray-200 dark:divide-gray-500">
                                            {{ this.rec_details.agence }}
                                        </td>
                                    </tr>

                                    <tr class="border-b">
                                        <th scope="col" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Saisie Par
                                        </th>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 bg-white divide-y divide-gray-200 dark:divide-gray-500">
                                            {{ this.rec_details.saisie_par }}
                                        </td>
                                    </tr>

                                    <tr class="border-b">
                                        <th scope="col" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Niveau D'urgence
                                        </th>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 bg-white divide-y divide-gray-200 dark:divide-gray-500">

                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-500 text-white">
                                                    {{ this.rec_details.nivUrg }}
                                                </span>

                                        </td>
                                    </tr>

                                    <tr class="border-b">
                                        <th scope="col" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Description
                                        </th>
                                        <td class="whitespace-pre-wrap break-words px-6 py-4 whitespace-nowrap text-sm text-gray-900 bg-white divide-y divide-gray-200 dark:divide-gray-500 ">

                                            {{ this.rec_details.description }}

                                        </td>
                                    </tr>

                                    <tr class="border-b">
                                        <th scope="col" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Creer à
                                        </th>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 bg-white divide-y divide-gray-200 dark:divide-gray-500">
                                            {{ this.rec_details.created_at.substr(0, 10) }} À {{ rec_details['created_at'].substr(11, 8) }}
                                        </td>
                                    </tr>
                                    <tr class="border-b">
                                        <th scope="col" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Derniere Modification
                                        </th>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 bg-white divide-y divide-gray-200 dark:divide-gray-500">
                                            {{ this.rec_details.created_at.substr(0, 10) }} À {{ rec_details['created_at'].substr(11, 8) }}
                                        </td>
                                    </tr>
                                    <tr class="border-b">
                                        <th scope="col" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Etat D'avancement
                                        </th>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 bg-white divide-y divide-gray-200 dark:divide-gray-500">

                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-500 text-white">
                                                    {{ this.rec_details.etat }}
                                            </span>

                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="block mt-8">
                    <a href="#" @click="this.finishTraitement(this.rec_details)" class="bg-green-200 hover:bg-green-300 text-black font-bold py-2 px-4 rounded">Finir Traitement</a>
                </div>

            </div>
        </div>
    </Modal>

    <Modal :show="finishingTraitement" @close="closeModal2">
        <div class="p-6">
            <h2
                class="text-lg font-medium text-gray-900 dark:text-gray-100"
            >
                Finir le traitement de cette Reclamation
            </h2>

            <div class="w-full pt-1">
                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2 mt-3 dark:text-gray-300" for="reponse">
                    Repondre
                </label>
                <textarea id="reponse" rows="5" v-model="form.reponse" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Donner une Reponse..." required></textarea>

            </div>

            <div class="mt-6 flex justify-end">
                <Button variant="secondary" @click="closeModal2">
                    Annuler
                </Button>

                <Button
                    variant="success"
                    class="ml-3"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                    @click="this.updateRec()"
                >
                    Confirmer
                </Button>
            </div>
        </div>
    </Modal>

</template>


