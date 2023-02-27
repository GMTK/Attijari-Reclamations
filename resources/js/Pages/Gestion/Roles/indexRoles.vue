<script setup>
import AuthenticatedLayout from '@/Layouts/Authenticated.vue'
import Modal from '@/Components/Modal.vue'
import Button from '@/Components/Button.vue'
import {nextTick, ref} from "vue";
import InputError from "@/Components/InputError.vue";
import Input from "@/Components/Input.vue";

</script>

<script>

import Multiselect from 'vue-multiselect'
import {ref} from "vue";

export default {

    props: ['roles', 'permissions'],

    components: { Multiselect },

    data () {

        return {


            confirmingRoleAdding: false,
            confirmingRoleEditing: false,

            form: this.$inertia.form({
                id: 0,
                title: '',
                permissions: [],
            }),

            selected: [],

            options: this.permissions.map(item => item.title)

        }

    },
    methods: {

        filter_n_map_form() {

            let selected = this.selected
            this.form.permissions = this.permissions.filter(function(item) {
                return selected.indexOf(item.title) > -1;
            }).map(function(item) {
                return item.id;
            })



        },

        submit() {
            this.filter_n_map_form()

            this.form.post(route('roles.store'), {
                preserveScroll: true,
                onSuccess: () => {
                    this.closeModal()
                },
            })

        },

        update(role_id) {

            this.filter_n_map_form()

            this.form.put(route('roles.update', role_id), {
                preserveScroll: true,
                onSuccess: () => {
                    this.closeModal()
                },
            })
        },

        closeModal() {

            this.confirmingRoleAdding = false
            this.confirmingRoleEditing =  false
            this.form.reset()
            this.selected = []
        },

        confirmRoleAdding() {
            this.confirmingRoleAdding = true
        },

        confirmRoleEditing(role) {
            this.form.id = role.id
            this.form.title = role.title
            this.selected = role.permissions.map(item => item.title)
            this.confirmingRoleEditing = true
        },

        deleteRole(role_id) {
            if(confirm("Voulez Vous Supprimer Cette utilisateur")) {
                this.form.delete(route("roles.destroy", role_id), {
                    preserveScroll: true,
                })
            }
        }
    }

}

</script>

<template>
    <AuthenticatedLayout title="Roles">
        <template #header>
            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <h2 class="text-xl font-semibold leading-tight ml-8">
                    Liste des Roles
                </h2>
            </div>
        </template>

        <div>
            <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
                <div class="block mb-8">
                    <Button variant="success" @click="confirmRoleAdding" >
                        Ajouter
                    </Button>

                </div>
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
                                            Titre
                                        </th>
                                        <th scope="col" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Habilitations
                                        </th>
                                        <th scope="col" width="200" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Actions
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200 dark:divide-gray-500">

                                    <tr v-for="role in roles">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ role.id }}
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ role.title }}
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 flex flex-wrap">

                                            <span v-for="perm in role['permissions']" class="px-2 mb-2 mr-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                    {{ perm.title }}
                                            </span>

                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">

                                            <a href="#" @click="confirmRoleEditing(role)" class="text-indigo-600 hover:text-indigo-900 mb-2 mr-2">modifier</a>
                                            <a  href="#" @click="this.deleteRole(role.id)" class="text-red-600 hover:text-red-900 mb-2 mr-2" >Supprimer</a>

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

    <Modal :show="confirmingRoleAdding" @close="this.closeModal" >
        <div class="p-7 ">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100" >
                Creer Un Nouveau Role
            </h2>

            <div class="mt-6 ">
                <label for="name" class="block font-medium text-sm text-gray-700">Titre</label>
                <Input type="text" name="titre" id="titre" v-model="form.title" class="form-input rounded-md shadow-sm mt-1 block w-full" />

                <InputError :message="form.errors.title" class="mt-2" />
            </div>
            <div id="multiselect-container" class="pt-10 relative">
                <multiselect
                    class=" overflow-h"
                    v-model="selected"
                    :options="options"
                    :multiple="true"
                    :searchable="true"
                    :close-on-select="false"
                    placeholder="Choisir des Permissions"
                />

            </div>

            <div class="pt-80 flex justify-end" >
                <Button variant="secondary" @click="closeModal">
                    Annuler
                </Button>

                <Button
                    variant="primary"
                    class="ml-3"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                    @click="this.submit"
                >
                    Confirmer
                </Button>
            </div>
        </div>
    </Modal>

    <Modal :show="confirmingRoleEditing" @close="this.closeModal" >
        <div class="p-7 ">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100" >
                Creer Un Nouveau Role
            </h2>

            <div class="mt-6 ">
                <label for="titre" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2 mt-3">Titre</label>
                <Input type="text" name="titre" id="titre" v-model="form.title" class="form-input rounded-md shadow-sm mt-1 block w-full" />

                <InputError :message="form.errors.title" class="mt-2" />
            </div>
            <div id="multiselect-container" class="pt-10 relative">
                <multiselect
                    class=" overflow-h"
                    v-model="selected"
                    :options="options"
                    :multiple="true"
                    :searchable="true"
                    :close-on-select="false"
                    placeholder="Choisir des Permissions"
                />

            </div>

            <div class="pt-80 flex justify-end" >
                <Button variant="secondary" @click="closeModal">
                    Annuler
                </Button>

                <Button
                    variant="primary"
                    class="ml-3"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                    @click="this.update(this.form.id)"
                >
                    Confirmer
                </Button>
            </div>
        </div>
    </Modal>
</template>


