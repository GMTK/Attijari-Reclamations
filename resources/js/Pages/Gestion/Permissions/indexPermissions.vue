<script setup>
import AuthenticatedLayout from '@/Layouts/Authenticated.vue'
import Modal from '@/Components/Modal.vue'
import Button from '@/Components/Button.vue'
import {nextTick, ref} from "vue";
import {useForm} from "@inertiajs/inertia-vue3";

const confirmingpermAdding = ref(false)

const confirmpermAdding = () => {
    confirmingpermAdding.value = true
}

const form = useForm({
    title: '',
    description: '',
})

const closeModal = () => {
    confirmingpermAdding.value = false

    form.reset()
}

const submit = () => {
    form.post(route('permissions.store'), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
    })

}

</script>

<script>

export default {
    props: {
        permissions_list: {
            type: Array,
            required: true,
        },

    },

    mounted() {
        console.log(this.permissions_list)
    }
};

</script>



<template>
    <AuthenticatedLayout title="Permissiona">
        <template #header>
            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <h2 class="text-xl font-semibold leading-tight ml-8">
                    Liste des Habilitations
                </h2>
            </div>
        </template>

        <div>
            <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
                <div class="block mb-8">
                    <Button variant="success" @click="confirmpermAdding" >
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
                                            description
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200 dark:divide-gray-500">

                                    <tr v-for="perm in permissions_list">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ perm.id }}
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ perm.title }}
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ perm.description }}
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

    <Modal :show="confirmingpermAdding" @close="closeModal" >
        <div class="p-10">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100" >
                Creer Une Nouvelle Habilitations
            </h2>

            <div class="mt-6">
                <label for="name" class="block font-medium text-sm text-gray-700">Titre</label>
                <input type="text" name="titre" id="titre" v-model="form.title" class="form-input rounded-md shadow-sm mt-1 block w-full">

                <InputError :message="form.errors.titre" class="mt-2" />
            </div>

            <div class="mt-6">
                <label for="name" class="block font-medium text-sm text-gray-700">Description</label>
                <input type="text" name="description" id="description" v-model="form.description" class="form-input rounded-md shadow-sm mt-1 block w-full">

                <InputError :message="form.errors.description" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end">
                <Button variant="secondary" @click="closeModal">
                    Annuler
                </Button>

                <Button
                    variant="primary"
                    class="ml-3"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                    @click="submit"
                >
                    Confirmer
                </Button>
            </div>
        </div>
    </Modal>
</template>


