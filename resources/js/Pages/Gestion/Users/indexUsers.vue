<script setup>
import AuthenticatedLayout from '@/Layouts/Authenticated.vue'
import Modal from '@/Components/Modal.vue'
import Button from '@/Components/Button.vue'
import {nextTick, onMounted, ref} from "vue";
import { Link, useForm,} from '@inertiajs/inertia-vue3'
import { UserIcon, MailIcon, LockClosedIcon, UserAddIcon } from '@heroicons/vue/outline'
import InputIconWrapper from '@/Components/InputIconWrapper.vue'
import Input from '@/Components/Input.vue'
import Label from '@/Components/Label.vue'
import InputError from "@/Components/InputError.vue";
</script>

<script>

import Multiselect from "vue-multiselect";
import Swal from "sweetalert2";

export default {

    components: { Multiselect },

    data() {
        return {
            confirmingUserAdding: false,
            confirmingUserDetails: false,
            confirmingUserPermissions: false,
            confirmingUserEditing: false,
            confirmingUserDeletion: false,

            showingPermissions: false,

            form: this.$inertia.form({
                id: 0,
                name: '',
                email: '',
                password: '',
                password_confirmation: '',
                terms: false,
            }),

            attributeForm: this.$inertia.form({
                id: 0,
                roles: [],
                permissions: [],
            }),

            user_details: {
                id: 0,
                name: '',
                email: '',
                tel: 0,
                created_at: '',
                updated_at: '',
                roles: [],
            },

            selected_roles: [],
            selected_permissions: [],
            options: this.roles.map(item => item.title),
            option_permissions: [],

            currentPage: 1,
            perPage: 5,
            search: '',
            sortColumn: 'email',
            sortDirection: 'asc'

        }
    },

    props: ['links','users_list', 'roles'],

    created() {
        console.log(this.users_list.data)
    },

    computed: {

        filteredData() {
            this.currentPage = 1
            return this.users_list.filter((item) => {
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

        showPermissions() {

            if (this.selected_roles.length !== 0) {
                let non_reduced_selected_permissions = this.roles.filter(
                    role => this.selected_roles.includes(role.title)
                ).flatMap(role => role.permissions.map(permission => permission.title));

                this.option_permissions = non_reduced_selected_permissions.reduce((accumulator, currentTitle) => {
                    if (!accumulator.includes(currentTitle)) {
                        accumulator.push(currentTitle);
                    }
                    return accumulator;
                }, []);

                this.selected_permissions = this.option_permissions

                this.showingPermissions = true
            }
        },

        closeModal() {
            this.confirmingUserAdding = false
            this.confirmingUserDetails = false
            this.confirmingUserPermissions = false
            this.confirmingUserEditing = false
            this.confirmingUserDeletion = false

            this.showingPermissions = false

            this.selected_roles = []
            this.selected_permissions = []
            this.options = this.roles.map(item => item.title)
            this.option_permissions = []

            this.form.reset()
        },

        confirmUserAdding() {
            this.confirmingUserAdding = true
        },

        confirmUserDetails(user) {

            this.user_details.id = user.id
            this.user_details.name = user.name
            this.user_details.email = user.email
            this.user_details.tel = 41645418
            this.user_details.created_at = user.created_at
            this.user_details.updated_at = user.updated_at
            this.user_details.roles = user.roles

            this.confirmingUserDetails = true
        },

        confirmUserPermissions(user) {

            this.attributeForm.id = user.id

            if (user['roles'].length !== 0) {
                this.selected_roles = user['roles'].map(role => role.title)

                this.selected_permissions = this.roles.filter(
                    role => this.selected_roles.includes(role.title)
                ).flatMap(role => role.permissions.map(permission => permission.title));

                this.showingPermissions = true
            }

            this.showPermissions()

            this.confirmingUserPermissions = true
        },

        confirmUserEditing(user) {

            this.form.id = user.id
            this.form.name = user.name
            this.form.email = user.email

            this.confirmingUserEditing = true
        },

        confirmUserDeletion(user) {

            this.form.id = user.id

            this.confirmingUserDeletion = true
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
            this.form.post(route('users.store'), {
                preserveScroll: true,
                onSuccess: () => {
                    this.closeModal()
                    this.swalAlert('Nouveau Utilisateur a été Créer')
                },
                onFinish: () => this.form.reset('password', 'password_confirmation'),
            })

        },

        deleteUser(user_id) {

            this.form.delete(route("users.destroy", user_id), {
                preserveScroll: true,
                onSuccess: () => {
                    this.closeModal()
                    this.swalAlert('Utilisateur a été Supprimer')
                },
            })

        },

        updateUser(user_id) {
            this.form.put(route("users.update", user_id), {
                preserveScroll: true,
                onSuccess: () => {
                    this.closeModal()
                    this.swalAlert('Utilisateur a été modifié')
                },
            })
        },

        AttributeUser(user_id) {

            this.attributeForm.roles = this.roles.filter(role => this.selected_roles.includes(role.title)).map(role => role.id)

            let non_reduced_permissions = []
            this.roles.forEach(role => {
                if (this.selected_roles.includes(role.title)) {
                    role.permissions.forEach(permission => {
                        if (this.selected_permissions.includes(permission.title)) {
                            non_reduced_permissions.push(permission.id);
                        }
                    });
                }
            });

            this.attributeForm.permissions = non_reduced_permissions.reduce((accumulator, currentId) => {
                if (!accumulator.includes(currentId)) {
                    accumulator.push(currentId);
                }
                return accumulator;
            }, []);


            this.attributeForm.put(route('users.attribute', user_id), {
                preserveScroll: true,
                onSuccess: () => {
                    this.closeModal()
                    this.swalAlert('Utilisateurs a été Attribuer ses Roles et ses Habilitations')
                },
            })
        }
    }
}
</script>



<template>
    <Modal :show="confirmingUserAdding" @close="closeModal" >

            <div class="p-10">
                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100" >
                    Creer Un Nouveau Utilisateur
                </h2>

                <div class="mt-6">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2 mt-3" for="name" >
                        Nom
                    </label>
                    <InputIconWrapper>
                        <template #icon>
                            <UserIcon aria-hidden="true" class="w-5 h-5" />
                        </template>
                        <Input withIcon id="name" type="text" placeholder="Name" class="block w-full" v-model="this.form.name" required autofocus autocomplete="name" />
                    </InputIconWrapper>
                </div>

                <div class="mt-6">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2 mt-3" for="email" >
                        Email
                    </label>
                    <InputIconWrapper>
                        <template #icon>
                            <MailIcon aria-hidden="true" class="w-5 h-5" />
                        </template>
                        <Input withIcon id="email" type="email" class="block w-full" placeholder="Email" v-model="this.form.email" required autocomplete="username" />
                    </InputIconWrapper>
                </div>

                <div class="mt-6">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2 mt-3" for="password" >
                        Mot de passe
                    </label>
                    <InputIconWrapper>
                        <template #icon>
                            <LockClosedIcon aria-hidden="true" class="w-5 h-5" />
                        </template>
                        <Input withIcon id="password" type="password" class="block w-full" placeholder="Password" v-model="this.form.password" required autocomplete="new-password" />
                    </InputIconWrapper>
                </div>

                <div class="mt-6">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2 mt-3" for="password_confirmation" >
                        Confirmer Mot De Passe
                    </label>
                    <InputIconWrapper>
                        <template #icon>
                            <LockClosedIcon aria-hidden="true" class="w-5 h-5" />
                        </template>
                        <Input withIcon id="password_confirmation" type="password" class="block w-full" placeholder="Confirm Password" v-model="this.form.password_confirmation" required autocomplete="new-password" />
                    </InputIconWrapper>
                </div>

                <div class="mt-6 flex justify-end">
                    <Button variant="secondary" @click="closeModal">
                        Annuler
                    </Button>

                    <Button
                        variant="primary"
                        class="ml-3"
                        :disabled="this.form.processing"
                        @click="submit"
                    >
                        Confirmer
                    </Button>
                </div>
            </div>
    </Modal>

    <Modal :show="confirmingUserDetails" @close="closeModal">
        <div>
            <div class="max-w-6xl mx-auto py-7 sm:px-6 lg:px-8">
                <div class="block mb-8">
                    <a href="#" @click="closeModal" class="bg-gray-200 hover:bg-gray-300 text-black font-bold py-2 px-4 rounded">Retour à la liste</a>
                </div>
                <div class="flex flex-col">
                    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                            <div class="shadow overflow-hidden border-b border-gray-200 dark:border-gray-500 sm:rounded-lg">
                                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-500  w-full">
                                    <tr class="border-b">
                                        <th scope="col" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            ID
                                        </th>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 bg-white divide-y divide-gray-200 dark:divide-gray-500">
                                            {{ this.user_details.id }}
                                        </td>
                                    </tr>

                                    <tr class="border-b">
                                        <th scope="col" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Nom D'Utilisateur
                                        </th>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 bg-white divide-y divide-gray-200 dark:divide-gray-500">
                                            {{ this.user_details.name }}26
                                        </td>
                                    </tr>

                                    <tr class="border-b">
                                        <th scope="col" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Nom Complet
                                        </th>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 bg-white divide-y divide-gray-200 dark:divide-gray-500">
                                            {{ this.user_details.name }}
                                        </td>
                                    </tr>
                                    <tr class="border-b">
                                        <th scope="col" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Email
                                        </th>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 bg-white divide-y divide-gray-200 dark:divide-gray-500">
                                            {{ this.user_details.email }}
                                        </td>
                                    </tr>

                                    <tr class="border-b">
                                        <th scope="col" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Service
                                        </th>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 bg-white divide-y divide-gray-200 dark:divide-gray-500">
                                            Ressources Humaines
                                        </td>
                                    </tr>

                                    <tr class="border-b">
                                        <th scope="col" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Telephone
                                        </th>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 bg-white divide-y divide-gray-200 dark:divide-gray-500">
                                            41 64 54 18
                                        </td>
                                    </tr>

                                    <tr class="border-b">
                                        <th scope="col" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Roles
                                        </th>
                                        <td v-if="this.user_details.roles.length !== 0" class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 bg-white divide-y divide-gray-200 dark:divide-gray-500 flex flex-wrap ">

                                            <div v-for="role in this.user_details.roles">
                                                <span  class="mr-2 px-3 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                     {{ role.title }}
                                                </span>
                                            </div>

                                        </td>

                                        <td v-else>
                                            &nbsp;&nbsp;&nbsp;
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                    Aucun Role
                                            </span>
                                        </td>
                                    </tr>

                                    <tr class="border-b">
                                        <th scope="col" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Creer à
                                        </th>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 bg-white divide-y divide-gray-200 dark:divide-gray-500">
                                            {{ this.user_details.created_at.substr(0, 10) }} À {{ user_details['created_at'].substr(11, 8) }}
                                        </td>
                                    </tr>
                                    <tr class="border-b">
                                        <th scope="col" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Derniere Modification
                                        </th>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 bg-white divide-y divide-gray-200 dark:divide-gray-500">
                                            {{ this.user_details.updated_at.substr(0, 10) }} À {{ user_details['updated_at'].substr(11, 8) }}
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </Modal>

    <Modal :show="confirmingUserPermissions" @close="this.closeModal" >
        <div class="p-7 ">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100" >
                Creer Un Nouveau Role
            </h2>

            <div id="multiselect-container" class="pt-10">
                <multiselect
                    class=" overflow-h"
                    v-model="selected_roles"
                    :options="options"
                    :multiple="true"
                    :searchable="true"
                    :close-on-select="false"
                    placeholder="Choisir un Role"
                    @click="this.showPermissions()"
                />

            </div>

            <div v-if="this.showingPermissions" id="multiselect-container" class="pt-10">
                <multiselect
                    class=" overflow-h"
                    v-model="selected_permissions"
                    :options="option_permissions"
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
                    @click="this.AttributeUser(this.form.id)"
                >
                    Confirmer
                </Button>
            </div>
        </div>
    </Modal>

    <Modal :show="confirmingUserEditing" @close="closeModal" >

        <div class="p-10">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100" >
                Modifier Les Informations de cet Utilisateur
            </h2>

            <div class="mt-6">
                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2 mt-3" for="name"  >
                    Nom
                </label>
                <InputIconWrapper>
                    <template #icon>
                        <UserIcon aria-hidden="true" class="w-5 h-5" />
                    </template>
                    <Input withIcon id="name" type="text"  class="block w-full"  v-model="this.form.name" required autofocus autocomplete="name" />
                </InputIconWrapper>
            </div>

            <div class="mt-6">
                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2 mt-3" for="email" >
                    Email
                </label>
                <InputIconWrapper>
                    <template #icon>
                        <MailIcon aria-hidden="true" class="w-5 h-5" />
                    </template>
                    <Input withIcon id="email" type="email" class="block w-full"   v-model="this.form.email" required autocomplete="username" />
                </InputIconWrapper>
            </div>

            <div class="mt-6 flex justify-end">
                <Button variant="secondary" @click="closeModal">
                    Annuler
                </Button>

                <Button
                    variant="primary"
                    class="ml-3"
                    :disabled="form.processing"
                    @click="updateUser(this.form.id)"
                >
                    Confirmer
                </Button>
            </div>
        </div>
    </Modal>

    <Modal :show="confirmingUserDeletion" @close="closeModal">
        <div class="p-6">
            <h2
                class="text-lg font-medium text-gray-900 dark:text-gray-100"
            >
                Êtes-vous sûr de vouloir supprimer cet utilisateur ?
            </h2>

            <div class="mt-6 flex justify-end">
                <Button variant="secondary" @click="closeModal">
                    Annuler
                </Button>

                <Button
                    variant="danger"
                    class="ml-3"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                    @click="deleteUser(this.form.id)"
                >
                    Supprimer
                </Button>
            </div>
        </div>
    </Modal>

    <AuthenticatedLayout title="Utilisateurs">
        <template #header>
            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <h2 class="text-xl font-semibold leading-tight ml-8">
                    Liste des Utilisateurs
                </h2>
            </div>
        </template>

        <div>
            <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
                <div class="block">
                    <Button variant="success" @click="confirmUserAdding" >
                        Ajouter
                    </Button>
                    <div class="flex justify-end">
                        <div class="flex justify-end mb-4">
                            <select class="mr-3 border border-solid border-neutral-300 bg-transparent bg-clip-padding pr-10 py-1.5 text-base font-normal text-neutral-700 outline-none transition duration-300 ease-in-out focus:border-primary focus:text-neutral-700 focus:shadow-te-primary focus:outline-none dark:text-neutral-200 dark:placeholder:text-neutral-200" id="sort" v-model="sortColumn">
                                <option value="id">ID</option>
                                <option value="name">Name</option>
                                <option value="email">EMAIL</option>
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
                <div class="flex flex-col ">
                    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8 ">
                        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8 ">
                            <div class="shadow overflow-hidden border-b border-gray-200 dark:border-gray-500 sm:rounded-lg ">
                                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-500 w-full ">
                                    <thead>
                                    <tr>
                                        <th scope="col" width="50" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:border-gray-600 dark:bg-dark-eval-1 dark:text-gray-300 dark:focus:ring-offset-dark-eval-1">
                                            ID
                                        </th>
                                        <th scope="col" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:border-gray-600 dark:bg-dark-eval-1 dark:text-gray-300 dark:focus:ring-offset-dark-eval-1">
                                            Nom
                                        </th>
                                        <th scope="col" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:border-gray-600 dark:bg-dark-eval-1 dark:text-gray-300 dark:focus:ring-offset-dark-eval-1">
                                            Email
                                        </th>

                                        <th scope="col" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:border-gray-600 dark:bg-dark-eval-1 dark:text-gray-300 dark:focus:ring-offset-dark-eval-1">
                                            Roles
                                        </th>
                                        <th scope="col" width="200" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:border-gray-600 dark:bg-dark-eval-1 dark:text-gray-300 dark:focus:ring-offset-dark-eval-1">
                                            Actions
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200 dark:divide-gray-500 ">

                                    <tr v-for="(user, index) in paginatedData" :key="index">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:border-gray-600 dark:bg-dark-eval-1 dark:text-gray-300 dark:focus:ring-offset-dark-eval-1">
                                            {{ user.id }}
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:border-gray-600 dark:bg-dark-eval-1 dark:text-gray-300 dark:focus:ring-offset-dark-eval-1">
                                            {{ user.name }}
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:border-gray-600 dark:bg-dark-eval-1 dark:text-gray-300 dark:focus:ring-offset-dark-eval-1">
                                            {{ user.email }}
                                        </td>

                                        <td v-if="user['roles'].length !== 0" class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 flex flex-wrap dark:border-gray-600 dark:bg-dark-eval-1 dark:text-gray-300 dark:focus:ring-offset-dark-eval-1">

                                            <div v-for="role in user['roles']" class="">
                                                <span  class="mr-2 px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 ">
                                                     {{ role.title }}
                                                </span>
                                            </div>

                                        </td>

                                        <td v-else class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 flex flex-wrap dark:border-gray-600 dark:bg-dark-eval-1 dark:text-gray-300 dark:focus:ring-offset-dark-eval-1">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                    Aucun Role
                                            </span>
                                        </td>

                                        <td class="px-6  whitespace-nowrap text-sm font-medium dark:border-gray-600 dark:bg-dark-eval-1 dark:text-gray-300 dark:focus:ring-offset-dark-eval-1">

                                            <a href="#" @click="confirmUserDetails(user)" class="text-blue-600 hover:text-blue-900 mb-2 mr-2">Details</a>
                                            <a href="#" @click="confirmUserPermissions(user)" class="text-green-600 hover:text-green-900 mb-2 mr-2">Attribuer</a>

                                            <a href="#" @click="confirmUserEditing(user)" class="text-indigo-600 hover:text-indigo-900 mb-2 mr-2">modifier</a>
<!--                                            <form class="inline-block" action="#" @click="confirmUserAdding" method="POST" onsubmit="return confirm('Confirmer?');">-->
<!--                                                <input type="hidden" name="_method" value="DELETE">-->
<!--                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">-->
                                                <a  href="#" @click="confirmUserDeletion(user)" class="text-red-600 hover:text-red-900 mb-2 mr-2" >Supprimer</a>
<!--                                            </form>-->

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

</template>


