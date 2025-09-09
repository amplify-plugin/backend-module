<template>
    <div v-if="this.data.show_chart" class="d-flex justify-content-center mt-3">
        <a href="javascript:void(0)" class="btn btn-secondary bg-transparent icon-btn mr-1" @click="changeView(null)">
            <img class="img-fluid" src="/images/icons/datatable.png" />
        </a>

        <a v-if="data.chartType != 'PieChart' " href="javascript:void(0)" class="btn btn-secondary bg-transparent icon-btn mr-1" @click="changeView('PieChart')">
            <img class="img-fluid" src="/images/icons/pie-graph.png" />
        </a>

        <a v-if="data.chartType != 'BarChart' " href="javascript:void(0)" class="btn btn-secondary bg-transparent icon-btn mr-1" @click="changeView('BarChart')">
            <img class="img-fluid" src="/images/icons/bar-graph.png" />
        </a>

        <a v-if="data.chartType != 'LineChart' " href="javascript:void(0)" class="btn btn-secondary bg-transparent icon-btn mr-1" @click="changeView('LineChart')">
            <img class="img-fluid" src="/images/icons/line-graph.png" />
        </a>
    </div>
</template>

<script>
    export default {
        name: "Chart-Navigator",
        props: ['data'],
        methods: {
            changeView(view = null) {
                this.data.chartType = view;
            }
        }
    }
</script>
