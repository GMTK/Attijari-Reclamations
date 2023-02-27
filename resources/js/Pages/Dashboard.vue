<script setup>
import AuthenticatedLayout from '@/Layouts/Authenticated.vue'
import { UserIcon, ArrowUpIcon, ArrowDownIcon, CheckIcon, ExclamationCircleIcon, ClockIcon } from '@heroicons/vue/outline'

</script>

<template>

    <AuthenticatedLayout title="Dashboard">
        <template #header>
            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <h2 class="text-xl font-semibold leading-tight">
                    Dashboard
                </h2>
            </div>
        </template>

        <div class="flex flex-wrap text-gray-900 bg-gray-100 dark:bg-dark-eval-0 ">
            <div class="mt-4 w-full lg:w-6/12 xl:w-6/12 px-5 mb-4 ">
                <div class="relative flex flex-col min-w-0 break-words bg-white rounded mb-3 xl:mb-0 shadow-lg dark:border-gray-600 dark:bg-dark-eval-1 dark:text-gray-300 dark:focus:ring-offset-dark-eval-1">
                    <div class="flex-auto p-4">
                        <div class="flex flex-wrap">
                            <div class="relative w-full pr-4 max-w-full flex-grow flex-1">
                                <h5 class=" uppercase font-bold text-xs"> Utilisateurs</h5>
                                <span class="font-semibold text-xl text-blueGray-700">334</span>
                            </div>
                            <div class="relative w-auto pl-4 flex-initial">
                                <div class="text-white p-3 text-center inline-flex items-center justify-center w-12 h-12 shadow-lg rounded-full  bg-green-500">
                                    <UserIcon aria-hidden="true" class="w-5 h-5" />
                                </div>
                            </div>
                        </div>
                        <p class="text-sm text-blueGray-400 ">
                            <span class="text-emerald-500 mr-2"><ArrowUpIcon aria-hidden="true" class="h-4" /> 2,99% </span>
                            <span class="whitespace-nowrap"> Depuis le mois dernier </span></p>
                    </div>
                </div>
            </div>

            <div class=" mt-4 w-full lg:w-6/12 xl:w-6/12 px-5">
                <div class="relative flex flex-col min-w-0 break-words bg-white rounded mb-4 xl:mb-0 shadow-lg">
                    <div class="flex-auto p-4 dark:border-gray-600 dark:bg-dark-eval-1 dark:text-gray-300 dark:focus:ring-offset-dark-eval-1">
                        <div class="flex flex-wrap">
                            <div class="relative w-full pr-4 max-w-full flex-grow flex-1">
                                <h5 class="text-blueGray-400 uppercase font-bold text-xs">Reclamations Cette Semaine</h5>
                                <span class="font-semibold text-xl text-blueGray-700">299</span>
                            </div>
                            <div class="relative w-auto pl-4 flex-initial">
                                <div class="text-white p-3 text-center inline-flex items-center justify-center w-12 h-12 shadow-lg rounded-full  bg-pink-500">
                                    <ExclamationCircleIcon aria-hidden="true" class="w-5 h-5" />
                                </div>
                            </div>
                        </div>
                        <p class="text-sm text-blueGray-400 ">
                            <span class="text-red-500 mr-2"><ArrowUpIcon aria-hidden="true" class="h-4" /> 4,01%</span>
                            <span class="whitespace-nowrap"> Depuis la semaine derniere </span></p>
                    </div>
                </div>
            </div>

            <div class="mt-4 w-full lg:w-6/12 xl:w-6/12 px-5">
                <div class="relative flex flex-col min-w-0 break-words bg-white rounded mb-6 xl:mb-0 shadow-lg">
                    <div class="flex-auto p-4 dark:border-gray-600 dark:bg-dark-eval-1 dark:text-gray-300 dark:focus:ring-offset-dark-eval-1">
                        <div class="flex flex-wrap">
                            <div class="relative w-full pr-4 max-w-full flex-grow flex-1">
                                <h5 class="text-blueGray-400 uppercase font-bold text-xs">Reclamations Resolue Aujourd'hui</h5>
                                <span class="font-semibold text-xl text-blueGray-700">9</span>
                            </div>
                            <div class="relative w-auto pl-4 flex-initial">
                                <div class="text-white p-3 text-center inline-flex items-center justify-center w-12 h-12 shadow-lg rounded-full  bg-blue-500">
                                    <CheckIcon aria-hidden="true" class="w-5 h-5" />
                                </div>
                            </div>
                        </div>
                        <p class="text-sm text-blueGray-400 ">
                            <span class="text-red-500 mr-2"><ArrowDownIcon aria-hidden="true" class="h-4" /> 1,25% </span>
                            <span class="whitespace-nowrap"> Depuis hier </span></p>
                    </div>
                </div>
            </div>

            <div class="mt-4 w-full lg:w-6/12 xl:w-6/12 px-5">
                <div class="relative flex flex-col min-w-0 break-words bg-white rounded mb-6 xl:mb-0 shadow-lg">
                    <div class="flex-auto p-4 dark:border-gray-600 dark:bg-dark-eval-1 dark:text-gray-300 dark:focus:ring-offset-dark-eval-1">
                        <div class="flex flex-wrap">
                            <div class="relative w-full pr-4 max-w-full flex-grow flex-1">
                                <h5 class="text-blueGray-400 uppercase font-bold text-xs">Reclamations En Retard</h5>
                                <span class="font-semibold text-xl text-blueGray-700">51</span>
                            </div>
                            <div class="relative w-auto pl-4 flex-initial">
                                <div class="text-white p-3 text-center inline-flex items-center justify-center w-12 h-12 shadow-lg rounded-full  bg-red-500">
                                    <ClockIcon aria-hidden="true" class="w-5 h-5" />
                                </div>
                            </div>
                        </div>
                        <p class="text-sm text-blueGray-400">
                            <span class="text-emerald-500 mr-2"><ArrowDownIcon aria-hidden="true" class="h-4" /> 12% </span>
                            <span class="whitespace-nowrap"> Depuis la semaine derniere </span></p>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
