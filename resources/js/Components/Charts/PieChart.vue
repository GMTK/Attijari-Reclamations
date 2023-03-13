<template>
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-lg font-medium mb-4">{{ title }}</h2>
        <canvas ref="chart"></canvas>
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
                labels: this.data.map(etat => etat.etat),
                datasets: [{
                    data: this.data.map(etat => etat.total),
                    backgroundColor: ['#f7f700','#34D399','#EF4444'],
                    // '#34D399' , '#f7f700', '#f6781d', '#EF4444'
                }],
            };

            const chartOptions = {
                scales: {
                    maintainAspectRatio: true,
                    yAxes: [{
                        ticks: {
                            beginAtZero: false,
                        },
                    }],
                },
            };

            new Chart(ctx, {
                type: 'pie',
                data: chartData,
                options: chartOptions,
            });
        },
    },
};
</script>

<style>
canvas {
    max-width: 100%;
    height: auto;
}
</style>
