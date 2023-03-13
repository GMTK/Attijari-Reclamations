<template>
    <div class="chart-container">
        <canvas ref="chart" class="chart" width="400" height="150"></canvas>
    </div>
</template>


<script>
import Chart from 'chart.js';

export default {
    props: {
        title: {
            type: String,
            required: true,
        },
        data: {
            type: Array,
            required: true,
        },
    },
    mounted() {
        this.renderChart();
    },
    methods: {
        renderChart() {
            const ctx = this.$refs.chart.getContext('2d');

            const chartData = {
                labels: [
                    'Jan',
                    'Fev',
                    'Mars',
                    'Avr',
                    'Mai',
                    'Juin',
                    'Jui',
                    'Aout',
                    'Sept',
                    'Oct',
                    'Nov',
                    'Dec',
                ], // Modify labels array
                datasets: [
                    {
                        label: 'Reclamations Par Mois',
                        backgroundColor: '#38B2AC',
                        data: this.data,
                    },
                ],
            };

            const chartOptions = {
                scales: {
                    yAxes: [
                        {
                            ticks: {
                                beginAtZero: true,
                            },
                        },
                    ],
                },
            };

            this.chart = new Chart(ctx, {
                type: 'bar',
                data: chartData,
                options: chartOptions,
            });
        },
        updateChart() {
            if (this.chart) {
                this.chart.data.datasets[0].data = this.data;
                this.chart.update();
            }
        },
    },
    watch: {
        data() {
            this.updateChart();
        },
    },
};
</script>
