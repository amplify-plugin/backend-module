<template>
    <div>
        <Pie
            :data="chartData"
            :options="options"
            :height="600"
            :stringToColor="stringToColor"
        />
    </div>
</template>

<script>
import { Pie } from 'vue-chartjs';
import { Colors } from 'chart.js';
import { Chart as ChartJS, ArcElement, Tooltip, Legend } from 'chart.js';
ChartJS.register(ArcElement, Tooltip, Legend, Colors);

export default {
    name: 'SinglePieChart',
    props: ['data', 'labels', 'label', 'stringToColor'],
    components: { Pie },
    computed: {
        chartData() {
            return {
                labels: this.labels,
                datasets: [
                    {
                        label: this.label,
                        // backgroundColor: this.data.map((item, index) => this.$parent.$parent.generateColorForChart(index, 'spectral')),
                        data: this.data
                    }
                ]
            };
        }
    },
    data() {
        return {
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        };
    },
    methods: {
        generateColors(count) {
            const colors = [];
            for (let i = 0; i < count; i++) {
                colors.push(this.$parent.$parent.stringToColor(this.labels[i]));
            }
            return colors;
        }
    }
};
</script>
