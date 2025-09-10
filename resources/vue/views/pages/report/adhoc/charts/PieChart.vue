<template>
    <section>
        <div class="mb-3" v-for="(dataset, index) in chartDatasets" :key="index">
            <h4 class="text-dark bg-light text-center">{{ dataset.label }}</h4>
            <SinglePieChart :data="dataset.data" :labels="labels" :label="dataset.label" />
        </div>
        <Navigator :data="prompt_data" />
    </section>
</template>

<script>
import Navigator from './Navigator.vue';
import SinglePieChart from './components/SinglePieChart.vue';

export default {
    name: "Pie-Chart",
    props: ['prompt_data', 'inc_number'],
    components: { Navigator, SinglePieChart },
    data() {
        return {
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        }
    },
    computed: {
        labels() {
            const labelCol = this.prompt_data.columns.find(column => column['@attributes']?.EA_ColType == "A" && column['@attributes']?.EA_HTMLType == "A");
            return this.prompt_data.data.map(item => item[labelCol.EA_TagName]);
        },
        chartDatasets() {
            const dataCols = this.prompt_data.columns.filter(column => this.$parent.currencyFormat.includes(column['@attributes']?.EA_Format));
            return dataCols.map(col => ({
                label: col.EA_ColumnName,
                data: this.prompt_data.data.map(item => this.$parent.currencyToNumeric(item[col.EA_TagName]))
            }));
        }
    }
};
</script>
