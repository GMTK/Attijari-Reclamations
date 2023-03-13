<template>
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-lg font-medium mb-4">{{ title }}</h2>
        <canvas ref="canvas" ></canvas>
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
        this.createChart();
    },
    methods: {
        createChart() {
            const ctx = this.$refs.canvas.getContext('2d');
            const chartData = {
                labels: this.data.map(item => item.period[0].slice(6, 10) + ' au ' + item.period[1].slice(6, 10)).reverse(),
                datasets: [{
                    label: 'Nombre de reclamations',
                    data: this.data.map(item => item.count).reverse(),
                    backgroundColor: 'rgba(0, 128, 255, 0.2)',
                    borderColor: 'rgba(0, 128, 255, 1)',
                    borderWidth: 1,
                }],
            };
            const chartOptions = {
                scales: {
                    maintainAspectRatio: true,
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                        },
                    }],
                },
            };
            new Chart(ctx, {
                type: 'line',
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
