<template>
    <section>
        <div>
            <Bar :options="options" :data="chartData" :height="600" />
        </div>

        <Navigator :data="prompt_data" />
    </section>
</template>

<script>
    import Navigator from './Navigator.vue';
    import { Bar } from 'vue-chartjs'
    import { Colors } from 'chart.js';
    import { Chart as ChartJS, Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale } from 'chart.js'
    ChartJS.register(CategoryScale, LinearScale, BarElement, Title, Tooltip, Legend, Colors);

    export default {
        name: "Bar-Chart",
        props: ['prompt_data', 'inc_number'],
        components: { Navigator, Bar },
        data() {
            return {
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                        display: false
                        }
                    }
                }
            }
        },
        computed: {
            chartData() {
                let labelCol = null, dataCol = [];

                for (const column of this.prompt_data.columns) {
                    if (!labelCol && column['@attributes']?.EA_ColType == "A" && column['@attributes']?.EA_HTMLType == "A") {
                        labelCol = column;
                    }
                    if (this.$parent.currencyFormat.includes(column['@attributes']?.EA_Format)) {
                        dataCol.push(column);
                    }
                }

                this.options.plugins.legend.display = dataCol.length > 2;

                return {
                    labels: this.prompt_data.data.map(item => item[labelCol.EA_TagName]),
                    datasets: dataCol.map(col => {
                        return {
                            label: col.EA_ColumnName,
                            backgroundColor: dataCol.length > 1 ? '' : this.prompt_data.data.map((item, index) => this.$parent.generateColorForChart(index)),
                            data: this.prompt_data.data.map(item => this.$parent.currencyToNumeric(item[col.EA_TagName]))
                        }
                    })
                }
            }
        },
        mounted() { },
        methods: {
        },
    }
</script>
