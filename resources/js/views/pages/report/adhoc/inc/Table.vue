<template>
    <div class="card">
        <div class="card-body">
            <div class="d-flex flex-row align-items-center mb-1">
                <h5 class="card-title mt-2">Question: {{ prompt_data.question }}</h5>
                <button v-if="!prompt_data.isUploadedQuery" type="button" class="btn btn-primary btn-sm ml-2" @click="callStoreModal('query')">Save Query</button>
                <button v-if="!prompt_data.isUploadedReport" type="button" class="btn btn-primary btn-sm ml-2" @click="callStoreModal('report')">Save Report</button>
            </div>
            <component
                :is="prompt_data.chartType? prompt_data.chartType : 'DataTable'"
                :inc_number="inc_number"
                :prompt_data="prompt_data"
            />
        </div>
    </div>
</template>

<script>
    import DataTable from '../table/DataTable.vue';
    import PieChart from '../charts/PieChart.vue';
    import BarChart from '../charts/BarChart.vue';
    import LineChart from '../charts/LineChart.vue';

    export default {
        name: "Table-Inc",
        props: ['prompt_data', 'inc_number'],
        components: { DataTable, PieChart, BarChart, LineChart },
        data() {
            return {
                currencyFormat: ['$#,##0', '$#,##0.0', '$#,##0.00', '#,##0', '#,##0.0', '#,##0.00']
            }
        },
        methods: {
            currencyToNumeric(currency) {
                return Number(currency.replace(/[^0-9.-]+/g, ""));
            },
            stringToColor(string, saturation = 100, lightness = 75) {
                let hash = 0;
                for (let i = 0; i < string.length; i++) {
                    hash = string.charCodeAt(i) + ((hash << 5) - hash);
                    hash = hash & hash;
                }

                return `hsl(${(hash % 360)}, ${saturation}%, ${lightness}%)`;
            },
            callStoreModal(type) {
                this.$parent.storePrompt.type = type;
                this.$parent.storePrompt.prompt_data = this.prompt_data;

                $('#store-report-cat-modal').modal({backdrop: 'static', keyboard: false});
            },
            generateColorForChart(position, colorScheme = 'original') {
                const original = ['#36A2EB', '#FF6384', '#4BC0C0', '#FF9F40', '#9966FF', '#FFCD56', '#C9CBCF'];
                const spectral = ['#9e0142', '#d53e4f', '#f46d43', '#fdae61', '#fee08b', '#e6f598', '#abdda4', '#66c2a5', '#3288bd', ' #5e4fa2'];

                let scheme;

                switch (colorScheme) {
                    case 'spectral':
                        scheme = spectral;
                        break;
                    default:
                        scheme = original;
                }

                return scheme[position % scheme.length];
            }
        }
    }
</script>
