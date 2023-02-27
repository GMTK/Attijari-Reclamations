<script setup>
import AuthenticatedLayout from '@/Layouts/Authenticated.vue'
import Button from '@/Components/Button.vue'
import Input from '@/Components/Input.vue'
import Label from '@/Components/Label.vue'
import ValidationErrors from '@/Components/ValidationErrors.vue'

</script>

<script>

import {usePage} from "@inertiajs/inertia-vue3";

export default {

    data() {
        return {

            form: this.$inertia.form({
                client_nom:'',
                agence:'',
                description:'',
                categorie:'',
                motif:'',
                telephone_cli:'',
                niveauurgence:'',
                montant: '',
                etat: 'Non Traité',
                saisie_par: usePage().props.value.auth.user.name,
                terms: false,
            })

        }
    },

    methods: {
        submit() {
            this.form.post(route('reclamation.store'), {
                onSuccess: () => this.form.reset(),
            })
        }
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
                <div class="w-full px-3">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2 mt-3 dark:text-gray-300" for="categorie">
                        Categorie
                    </label>
                    <select v-model="form.categorie" class="block appearance-none w-full bg-white mt-3 border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline dark:border-gray-600 dark:bg-dark-eval-1 dark:text-gray-300 dark:focus:ring-offset-dark-eval-1">
                        <option value="" selected disabled hidden>Choisir une Categorie</option>
                        <option>Categorie 1</option>
                        <option>Categorie 2</option>
                        <option>Categorie 3</option>
                        <option>Categorie 3</option>
                        <option>Categorie 3</option>
                    </select>
                </div>
                <div class="w-full px-3">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2 mt-3 dark:text-gray-300" for="montant">
                        Montant
                    </label>
                    <Input  id="montant" type="text" placeholder="---" class="block w-full mt-3" v-model="form.montant" required autofocus autocomplete="montant" />
                </div>
            </div>
            <div class="grid md:grid-cols-2 md:gap-6">
                <div class="w-full px-3">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2 mt-3 dark:text-gray-300" for="client_nom">
                        Nom Client
                    </label>
                    <Input  id="client_nom" type="text" placeholder="---" class="block w-full mt-3" v-model="form.client_nom" required autofocus autocomplete="client_nom" />
                </div>
                <div class="w-full px-3">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2 mt-2 dark:text-gray-300" for="telephone_cli">
                        Telephone du client
                    </label>
                    <Input  id="telephone_cli" type="tel" placeholder="---" class="block w-full mt-3" v-model="form.telephone_cli" required autofocus autocomplete="telephone_cli" />
                </div>
            </div>

            <div class="grid md:grid-cols-2 md:gap-6">
                <div class="w-full px-3">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2 mt-3 dark:text-gray-300" for="motif">
                        Motif
                    </label>
                    <Input  id="motif" type="text" placeholder="---" class="block w-full mt-3" v-model="form.motif" required autofocus autocomplete="motif" />
                </div>
                <div class="w-full px-3">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2 mt-3 dark:text-gray-300" for="categorie">
                        Niveau D'urgence
                    </label>
                    <select v-model="form.niveauurgence" class="block appearance-none w-full bg-white mt-3 border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline dark:border-gray-600 dark:bg-dark-eval-1 dark:text-gray-300 dark:focus:ring-offset-dark-eval-1">
                        <option value="" selected disabled hidden>Choisir un Niveau</option>
                        <option>Faible</option>
                        <option>Moyen</option>
                        <option>Fort</option>

                    </select>
                </div>

            </div>
            <div class="grid md:grid-cols-2 md:gap-6">
                <div class="w-full px-3">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2 mt-3 dark:text-gray-300" for="agence">
                        Agence
                    </label>
                    <Input  id="agence" type="text" placeholder="---" class="block w-full mt-3" v-model="form.agence" required autofocus autocomplete="agence" />
                </div>
                <div class="w-full px-3">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2 mt-3 dark:text-gray-300" for="description">
                        Description
                    </label>
                    <textarea id="description" rows="2" v-model="form.description" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Leave a comment..." required></textarea>

                </div>
            </div>

            <div class="mt-6 flex justify-end">
                <Button variant="secondary" type="reset">
                    Annuler
                </Button>

                <Button
                    variant="primary"
                    class="ml-3"
                    :disabled="form.processing"
                >
                    Confirmer
                </Button>
            </div>
        </form>


    </AuthenticatedLayout>

</template>
