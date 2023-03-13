<script setup>
import AuthenticatedLayout from '@/Layouts/Authenticated.vue'
import { UserIcon, ArrowUpIcon, ArrowDownIcon, CheckIcon, ExclamationCircleIcon, ClockIcon, BellIcon } from '@heroicons/vue/outline'
import Button from "@/Components/Button.vue";
</script>

<script>

import LineChart from "@/Components/Charts/LineChart.vue";
import HistogramChart from "@/Components/Charts/HistogramChart.vue";
import PieChart from "@/Components/Charts/PieChart.vue";

import jsPDF from 'jspdf';
import html2canvas from "html2canvas";

export default {

    props: [
        'users',
        'usersMonth',
        'semaine',
        'recSemainePercent',
        'retard',
        'recParEtats',
        'recWeeks',
        'recAnnes',
    ],

    components: {
        LineChart,
        HistogramChart,
        PieChart,
    },

    data() {
        return {

            alertOpen: true,
            form: this.$inertia.form({}),

            past4Weeks: this.recWeeks,
            userschartData: this.recParEtats,
            histYears: [...new Set(this.recAnnes.map(item => item.year))].reverse(),
            selectedYear: 2023
        }
    },

    created() {
        console.log(this.recAnnes)
    },

    computed: {
        monthsData() {

            const histMonths = this.recAnnes
                .filter(item => item.year === this.selectedYear) // only keep objects with year === 2023
                .reduce((acc, item) => {
                    const monthIndex = item.month - 1;
                    acc[monthIndex] += item.count; // accumulate the counts in the appropriate month index
                    return acc;
                }, new Array(12).fill(0)); // initialize an array of 12 zeroes (one for each month)

            return histMonths


        }

    },

    methods: {

        generatePdf() {
            // Create a new jsPDF instance
            const doc = new jsPDF();

            // Get the HTML element to be converted to PDF
            const pdfContent = document.getElementById('pdfContent');

            this.$nextTick(() => {

                html2canvas(pdfContent).then(canvas => {

                    // Get the dimensions of the canvas element
                    const canvasWidth = canvas.width;
                    const canvasHeight = canvas.height;

                    // Calculate the dimensions of the PDF document based on the canvas dimensions
                    const pdfWidth = doc.internal.pageSize.getWidth();
                    const pdfHeight = pdfWidth * canvasHeight / canvasWidth;

                    // Add the canvas as an image to the PDF document
                    const imageData = canvas.toDataURL('image/png');
                    doc.addImage(imageData, 'PNG', 0,5, pdfWidth, pdfHeight*1.1);

                    // Save the PDF document
                    doc.save('dashboard.pdf');
                });
            })
        },

        closeAlert: function(){
            this.alertOpen = false;
        }
    }

}

</script>

<template>

    <AuthenticatedLayout title="Dashboard">
        <template #header>
            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <h2 class="text-xl font-semibold leading-tight">
                    Dashboard
                </h2>
                <div class="flex justify-end mr-8">
                    <Button @click="generatePdf()" variant="primary" >
                        Exporter Le Tableau
                    </Button>
                </div>
            </div>
        </template>

        <div id="pdfContent">

            <div v-if="alertOpen && retard > 0" class="text-white px-6 py-4 border-0 rounded relative mb-4 bg-red-500">
          <span class="text-xl inline-block mr-5 align-middle">
            <BellIcon aria-hidden="true" class="w-5 h-5" />
          </span>
                <span class="inline-block align-middle mr-8">
             Vous Avez <a :href="route('reclamations.nontraiteretard')" class="underline font-semibold">{{ retard }}</a> Reclamations en Retard
          </span>

                <button class="absolute bg-transparent text-2xl font-semibold leading-none right-0 top-0 mt-4 mr-6 outline-none focus:outline-none" v-on:click="closeAlert()">
                    <span>×</span>
                </button>
            </div>

            <div class="flex flex-wrap text-gray-900 bg-gray-100 dark:bg-dark-eval-0 ">
                <div class="mt-4 w-full lg:w-6/12 xl:w-6/12 px-5 mb-4 ">
                    <div class="relative flex flex-col min-w-0 break-words bg-white rounded mb-3 xl:mb-0 shadow-lg dark:border-gray-600 dark:bg-dark-eval-1 dark:text-gray-300 dark:focus:ring-offset-dark-eval-1">
                        <div class="flex-auto p-4">
                            <div class="flex flex-wrap">
                                <div class="relative w-full pr-4 max-w-full flex-grow flex-1">
                                    <h5 class=" uppercase font-bold text-xs"> Utilisateurs</h5 >
                                    <span class="font-semibold text-xl text-blueGray-700">{{ users }}</span>
                                </div>
                                <div class="relative w-auto pl-4 flex-initial">
                                    <div class="text-white p-3 text-center inline-flex items-center justify-center w-12 h-12 shadow-lg rounded-full  bg-green-500">
                                        <UserIcon aria-hidden="true" class="w-5 h-5" />
                                    </div>
                                </div>
                            </div>
                            <p class="text-sm text-blueGray-400 ">
                                <span class="text-emerald-500 mr-2"><ArrowUpIcon aria-hidden="true" class="h-4" /> {{ usersMonth }} </span>
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
                                    <span class="font-semibold text-xl text-blueGray-700">{{ semaine }}</span>
                                </div>
                                <div class="relative w-auto pl-4 flex-initial">
                                    <div class="text-white p-3 text-center inline-flex items-center justify-center w-12 h-12 shadow-lg rounded-full  bg-pink-500">
                                        <ExclamationCircleIcon aria-hidden="true" class="w-5 h-5" />
                                    </div>
                                </div>
                            </div>
                            <p class="text-sm text-blueGray-400 ">
                                <span v-if=" recSemainePercent > 0 " class="text-red-500 mr-2"><ArrowUpIcon aria-hidden="true" class="h-4" /> {{ recSemainePercent.toFixed(2) }}%</span>
                                <span v-else-if="recSemainePercent === 0" class="text-gray-500 mr-2"><i aria-hidden="true" class="h-4" /> {{ recSemainePercent.toFixed(2) }}%</span>
                                <span v-else-if="recSemainePercent === 0" class="text-emerald-500 mr-2"><ArrowDownIcon aria-hidden="true" class="h-4" /> {{ recSemainePercent.toFixed(2).toString().slice(1) }}%</span>
                                <span class="whitespace-nowrap"> Depuis la semaine derniere </span></p>
                        </div>
                    </div>
                </div>

                <div class="mt-4 mb-4 w-full px-5">
                    <div class="relative flex flex-col min-w-0 break-words bg-white rounded mb-6 xl:mb-0 shadow-lg">
                        <div class="flex-auto p-4 dark:border-gray-600 dark:bg-dark-eval-1 dark:text-gray-300 dark:focus:ring-offset-dark-eval-1">
                            <div class="flex flex-wrap">
                                <div class="relative w-full pr-4 max-w-full flex-grow flex-1">
                                    <h5 class="text-blueGray-400 uppercase font-bold text-xs">Reclamations Cloturées Aujourd'hui</h5>
                                    <span class="font-semibold text-xl text-blueGray-700">9</span>
                                </div>
                                <div class="relative w-auto pl-4 flex-initial">
                                    <div class="text-white p-3 text-center inline-flex items-center justify-center w-12 h-12 shadow-lg rounded-full  bg-blue-500">
                                        <CheckIcon aria-hidden="true" class="w-5 h-5" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-4 px-5 grid md:grid-cols-2 md:gap-6">
                <pie-chart class="mb-4 p-4 dark:border-gray-600 dark:bg-dark-eval-1 dark:text-gray-300 dark:focus:ring-offset-dark-eval-1" title="Distribution par Etat" :data="userschartData"></pie-chart>
                <line-chart class="mb-4 p-4 dark:border-gray-600 dark:bg-dark-eval-1 dark:text-gray-300 dark:focus:ring-offset-dark-eval-1" title="Reclamations au cours des 4 dernières semaines" :data="past4Weeks"></line-chart>
            </div>
            <div class="bg-white rounded-lg shadow p-6 mb-4 dark:border-gray-600 dark:bg-dark-eval-1 dark:text-gray-300 dark:focus:ring-offset-dark-eval-1">
                <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                    <h2 class="text-lg font-medium">
                        Liste de Toute les Reclamations
                    </h2>
                    <div class="flex justify-end">
                        <select v-model="selectedYear" class="mr-3 border border-solid border-neutral-300 bg-transparent bg-clip-padding pr-10 py-1.5 text-base font-normal text-neutral-700 outline-none transition duration-300 ease-in-out focus:border-primary focus:text-neutral-700 focus:shadow-te-primary focus:outline-none dark:text-neutral-200 dark:placeholder:text-neutral-200" >
                            <option v-for="year in histYears" :value="year">{{ year }}</option>
                        </select>
                    </div>

                </div>
                <histogram-chart :data="monthsData"></histogram-chart>
            </div>


        </div>
    </AuthenticatedLayout>

</template>
