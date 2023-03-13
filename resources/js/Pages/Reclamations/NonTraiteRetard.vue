<script setup>
import AuthenticatedLayout from '@/Layouts/Authenticated.vue'
import Modal from '@/Components/Modal.vue'
import Button from '@/Components/Button.vue'
import {nextTick, ref} from "vue";
import {useForm} from "@inertiajs/inertia-vue3";

</script>

<script>

import Swal from "sweetalert2";

export default {

    props: ['reclamations'],

    data() {
        return {
            confirmingRecDetails: false,

            commencingRecTraitement: false,


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
            }),

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
            return this.reclamations.filter((item) => {
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

        closeModal() {
            this.confirmingRecDetails = false
        },

        closeModal2() {
            this.commencingRecTraitement = false
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

        commenceRecTraitement(rec) {
            this.form.id = rec.id

            this.commencingRecTraitement = true
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

        updateRec() {

            this.form.post(route('reclamations.update'),{
                preserveScroll: true,
                onSuccess: () => {
                    this.closeModal()
                    this.closeModal2()
                    this.swalAlert('Traitement de la Reclamation a Commencé')
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
                    Liste des Reclamations Non Traitées
                </h2>
            </div>
        </template>

        <div>
            <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
                <div class="block">
                    <div class="flex justify-end">
                        <div class="flex justify-end mb-4">
                            <select class="mr-3 border border-solid border-neutral-300 bg-transparent bg-clip-padding pr-10 py-1.5 text-base font-normal text-neutral-700 outline-none transition duration-300 ease-in-out focus:border-primary focus:text-neutral-700 focus:shadow-te-primary focus:outline-none dark:text-neutral-200 dark:placeholder:text-neutral-200" id="sort" v-model="sortColumn">
                                <option value="id">ID</option>
                                <option value="name">CATEGORIE</option>
                                <option value="Urg_id">NIVEAU URGENCE</option>
                                <option value="agence">AGENCE</option>
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
                                <table class="min-w-full divide-y  divide-gray-200 dark:divide-gray-500 dark:divide-gray-500 w-full">
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
                                    <tbody class="bg-white divide-y  divide-gray-200 dark:divide-gray-500 dark:divide-gray-500">

                                    <tr v-for="(rec, index) in paginatedData" :key="index">
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
                                            {{ rec.Urg_id }}
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

    <Modal :show="this.confirmingRecDetails" @close="this.closeModal" >
        <div>
            <div class="max-w-6xl mx-auto py-7 sm:px-6 lg:px-8">

                <div class="flex flex-col">
                    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8 " >
                        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                            <div class="shadow overflow-hidden border-b border-gray-200 dark:border-gray-500 sm:rounded-lg">
                                <table class="min-w-full divide-y  divide-gray-200 dark:divide-gray-500 dark:divide-gray-500 w-full">
                                    <tr class="border-b">
                                        <th scope="col" class="px-6 w-20 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            ID Reclamation
                                        </th>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 bg-white divide-y  divide-gray-200 dark:divide-gray-500 dark:divide-gray-500">
                                            {{ this.rec_details.id }}
                                        </td>
                                    </tr>

                                    <tr class="border-b">
                                        <th scope="col" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Motif
                                        </th>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 bg-white divide-y  divide-gray-200 dark:divide-gray-500 dark:divide-gray-500">
                                            {{ this.rec_details.motif }}
                                        </td>
                                    </tr>

                                    <tr class="border-b">
                                        <th scope="col" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Categorie
                                        </th>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 bg-white divide-y  divide-gray-200 dark:divide-gray-500 dark:divide-gray-500">
                                            {{ this.rec_details.categorie }}
                                        </td>
                                    </tr>

                                    <tr class="border-b">
                                        <th scope="col" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Nom du Client
                                        </th>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 bg-white divide-y  divide-gray-200 dark:divide-gray-500 ">
                                            {{ this.rec_details.client }}
                                        </td>
                                    </tr>

                                    <tr class="border-b">
                                        <th scope="col" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Telephone Du Client
                                        </th>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 bg-white divide-y  divide-gray-200 dark:divide-gray-500">
                                            {{ this.rec_details.tel }}
                                        </td>
                                    </tr>

                                    <tr class="border-b">
                                        <th scope="col" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Agence
                                        </th>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 bg-white divide-y  divide-gray-200 dark:divide-gray-500">
                                            {{ this.rec_details.agence }}
                                        </td>
                                    </tr>

                                    <tr class="border-b">
                                        <th scope="col" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Saisie Par
                                        </th>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 bg-white divide-y  divide-gray-200 dark:divide-gray-500">
                                            {{ this.rec_details.saisie_par }}
                                        </td>
                                    </tr>

                                    <tr class="border-b">
                                        <th scope="col" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Niveau D'urgence
                                        </th>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 bg-white divide-y  divide-gray-200 dark:divide-gray-500">

                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-500 text-white">
                                                    {{ this.rec_details.nivUrg }}
                                                </span>

                                        </td>
                                    </tr>

                                    <tr class="border-b">
                                        <th scope="col" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Description
                                        </th>
                                        <td class="whitespace-pre-wrap break-words px-6 py-4 whitespace-nowrap text-sm text-gray-900 bg-white divide-y  divide-gray-200 dark:divide-gray-500 ">

                                            {{ this.rec_details.description }}

                                        </td>
                                    </tr>

                                    <tr class="border-b">
                                        <th scope="col" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Creer à
                                        </th>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 bg-white divide-y  divide-gray-200 dark:divide-gray-500">
                                            {{ this.rec_details.created_at.substr(0, 10) }} À {{ rec_details['created_at'].substr(11, 8) }}
                                        </td>
                                    </tr>
                                    <tr class="border-b">
                                        <th scope="col" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Derniere Modification
                                        </th>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 bg-white divide-y  divide-gray-200 dark:divide-gray-500">
                                            {{ this.rec_details.created_at.substr(0, 10) }} À {{ rec_details['created_at'].substr(11, 8) }}
                                        </td>
                                    </tr>
                                    <tr class="border-b">
                                        <th scope="col" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Etat D'avancement
                                        </th>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 bg-white divide-y  divide-gray-200 dark:divide-gray-500">

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
                    <a href="#" @click="commenceRecTraitement(this.rec_details)" class="bg-green-200 hover:bg-green-300 text-black font-bold py-2 px-4 rounded">Debuter Traitement</a>
                </div>

            </div>
        </div>
    </Modal>

    <Modal :show="commencingRecTraitement" @close="closeModal2">
        <div class="p-6">
            <h2
                class="text-lg font-medium text-gray-900 dark:text-gray-100"
            >
                Êtes-vous sûr de vouloir Commencer Le Traitement sur Cette Reclamation ?
            </h2>

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


