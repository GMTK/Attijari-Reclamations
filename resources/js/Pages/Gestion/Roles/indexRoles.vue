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
import Swal from "sweetalert2";

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

            options: this.permissions.map(item => item.title),

            currentPage: 1,
            perPage: 5,
            search: '',
            sortColumn: 'id',
            sortDirection: 'asc'

        }

    },

    computed: {

        filteredData() {
            this.currentPage = 1
            return this.roles.filter((item) => {
                return item[this.sortColumn].toString().toLowerCase().includes(this.search.toLowerCase());
            });
        },
        sortedData() {
            const data = this.filteredData.slice()
            if (this.sortDirection === 'asc') {
                data.sort((a, b) => {
                    if (parseInt(a[this.sortColumn])) {
                        return a[this.sortColumn] - b[this.sortColumn]
                    } else {
                        return a[this.sortColumn].localeCompare(b[this.sortColumn])
                    }
                })
            } else {
                data.sort((a, b) => {
                    if (parseInt(a[this.sortColumn])) {
                        return b[this.sortColumn] - a[this.sortColumn]
                    } else {
                        return b[this.sortColumn].localeCompare(a[this.sortColumn])
                    }
                })
            }
            return data
        },
        paginatedData() {
            const startIndex = (this.currentPage - 1) * this.perPage;
            const endIndex = startIndex + this.perPage;
            return this.sortedData.slice(startIndex, endIndex);
        },

        totalPages() {
            return Math.ceil(this.sortedData.length / this.perPage);
        },
    },

    methods: {

        setPage(pageNumber) {
            this.currentPage = pageNumber;
        },

        previousPage() {
            if(this.currentPage > 1)
                --this.currentPage
        },

        nextPage() {
            if(this.currentPage < this.totalPages)
                ++this.currentPage
        },

        sort(column) {
            if (column === this.sortColumn) {
                this.sortDirection = this.sortDirection === 'asc' ? 'desc' : 'asc'
            } else {
                this.sortColumn = column
                this.sortDirection = 'asc'
            }
        },

        filter_n_map_form() {

            let selected = this.selected
            this.form.permissions = this.permissions.filter(function(item) {
                return selected.indexOf(item.title) > -1;
            }).map(function(item) {
                return item.id;
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

        submit() {
            this.filter_n_map_form()

            this.form.post(route('roles.store'), {
                preserveScroll: true,
                onSuccess: () => {
                    this.closeModal()
                    this.swalAlert('Nouveau Role a été Créer')
                },
            })

        },

        update(role_id) {

            this.filter_n_map_form()

            this.form.put(route('roles.update', role_id), {
                preserveScroll: true,
                onSuccess: () => {
                    this.closeModal()
                    this.swalAlert('Role a été modifié')
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
                    onSuccess: () => {
                        this.closeModal()
                        this.swalAlert('Role a été modifié')
                    },
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
                    <div class="flex justify-end">
                        <div class="flex justify-end mb-4">
                            <select class="mr-3 border border-solid border-neutral-300 bg-transparent bg-clip-padding pr-10 py-1.5 text-base font-normal text-neutral-700 outline-none transition duration-300 ease-in-out focus:border-primary focus:text-neutral-700 focus:shadow-te-primary focus:outline-none dark:text-neutral-200 dark:placeholder:text-neutral-200" id="sort" v-model="sortColumn">
                                <option value="id">ID</option>
                                <option value="title">TITRE</option>
                            </select>
                            <select class="mr-3 border border-solid border-neutral-300 bg-transparent bg-clip-padding pr-10 py-1.5 text-base font-normal text-neutral-700 outline-none transition duration-300 ease-in-out focus:border-primary focus:text-neutral-700 focus:shadow-te-primary focus:outline-none dark:text-neutral-200 dark:placeholder:text-neutral-200" id="direction" v-model="sortDirection">
                                <option value="asc">CROISSANT</option>
                                <option value="desc">DECROISSANT</option>
                            </select>
                            <div class="relative flex w-full flex-wrap items-stretch">
                                <input
                                    type="search"
                                    v-model="search"
                                    class="relative m-0 -mr-px block w-[1%] min-w-0 flex-auto rounded-l border border-solid border-neutral-300 bg-transparent bg-clip-padding px-3 py-1.5 text-base font-normal text-neutral-700 outline-none transition duration-300 ease-in-out focus:border-primary focus:text-neutral-700 focus:shadow-te-primary focus:outline-none dark:text-neutral-200 dark:placeholder:text-neutral-200"
                                    placeholder="Search"
                                    aria-label="Search"
                                    aria-describedby="button-addon1" />
                            </div>
                        </div>
                    </div>

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

                                    <tr v-for="(role, index) in paginatedData" :key="index">
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
                                <div class="flex flex-col items-center my-5">
                                    <div class="flex text-gray-700">
                                        <div class="h-10 w-10 mr-1 flex justify-center items-center rounded-full bg-gray-200 cursor-pointer" @click="previousPage()">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-left w-6 h-6">
                                                <polyline points="15 18 9 12 15 6"></polyline>
                                            </svg>
                                        </div>
                                        <div class="flex h-10 font-medium rounded-full bg-gray-200" v-for="pageNumber in totalPages" :key="pageNumber" @click="setPage(pageNumber)">
                                            <div v-if="pageNumber === this.currentPage" class="w-10 md:flex justify-center items-center hidden  cursor-pointer leading-5 transition duration-150 ease-in  rounded-full bg-teal-600 text-white ">{{ pageNumber }}</div>
                                            <div v-else class="w-10 md:flex justify-center items-center hidden  cursor-pointer leading-5 transition duration-150 ease-in  rounded-full  ">{{ pageNumber }}</div>
                                        </div>
                                        <div class="h-10 w-10 ml-1 flex justify-center items-center rounded-full bg-gray-200 cursor-pointer" @click="nextPage()">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right w-6 h-6">
                                                <polyline points="9 18 15 12 9 6"></polyline>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
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


