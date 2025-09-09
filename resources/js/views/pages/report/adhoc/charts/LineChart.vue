<template>
    <section>
        <div>
            <LineChartCanva
                :options="options"
                :data="chartData"
                :height="600"
            />
        </div>

        <Navigator :data="prompt_data" />
    </section>
</template>

<script>
    import Navigator from './Navigator.vue';
    import { Colors } from 'chart.js';
    import { Line as LineChartCanva } from 'vue-chartjs'
    import { Chart as ChartJS, CategoryScale, LinearScale, PointElement, LineElement, Title, Tooltip, Legend } from 'chart.js'
    ChartJS.register(CategoryScale, LinearScale, PointElement, LineElement, Title, Tooltip, Legend, Colors);

    export default {
        name: "Line-Chart",
        props: ['prompt_data', 'inc_number'],
        components: { Navigator, LineChartCanva },
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
                            // backgroundColor: this.$parent.stringToColor(col.EA_ColumnName),
                            label: col.EA_ColumnName,
                            data: this.prompt_data.data.map(item => this.$parent.currencyToNumeric(item[col.EA_TagName]))
                        }
                    })
                }
            }
        },
        mounted() {},
        methods: {
            pushColumnData(columns, column) {
                columns.push({
                    name: column.EA_TagName,
                    title: column.EA_ColumnName,
                    format: column['@attributes']?.EA_Format ?? null
                });
            }
        },
    }
</script>
