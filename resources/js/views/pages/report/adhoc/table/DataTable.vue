<template>
    <div>
        <table class="table table-striped" :id="`table-${inc_number}`"></table>
    </div>
</template>

<script>
export default {
    name: "Data-Table",
    props: ['prompt_data', 'inc_number'],
    data() {
        return {
            dtHandle: null,
            headers: [],
            rows: []
        }
    },
    mounted() {
        this.prepareData();
        this.dtHandle = $(`#table-${this.inc_number}`).DataTable({
            columns: this.headers,
            data: this.rows,
            layout: this.customLayout(),
            buttons: this.customButtons()
        });
    },
    methods: {
        customLayout() {
            return {
                bottomStart: ['info', 'buttons', 'paging'],
                bottomEnd: null
            };
        },
        customButtons() {
            let btns = [];
            let title = this.stringToTitle(this.prompt_data.question);

            if (this.prompt_data.show_chart) {
                btns = btns.concat([
                    {
                        tag: 'img',
                        attr: {
                            src: '/images/icons/pie-graph.png'
                        },
                        className: 'btn icon-btn bg-transparent cursor-pointer',
                        action: () => this.changeView("PieChart")
                    },
                    {
                        tag: 'img',
                        attr: {
                            src: '/images/icons/bar-graph.png'
                        },
                        className: 'btn icon-btn bg-transparent cursor-pointer',
                        action: () => this.changeView("BarChart")
                    },
                    {
                        tag: 'img',
                        attr: {
                            src: '/images/icons/line-graph.png'
                        },
                        className: 'btn icon-btn bg-transparent cursor-pointer',
                        action: () => this.changeView("LineChart")
                    }
                ]);
            }

            return btns.concat([{
                extend: 'collection',
                text: 'Export',
                className: 'btn bg-transparent',
                buttons: [
                    {
                        extend: 'excel',
                        text: 'Excel',
                        title: title,
                    },
                    {
                        extend: 'csv',
                        text: 'CSV',
                        title: title,
                    },
                    {
                        extend: 'pdf',
                        text: 'PDF',
                        title: title,
                        customize: function (doc) {
                            doc.content[1].table.widths =
                                Array(doc.content[1].table.body[0].length + 1).join('*').split('');
                        }
                    },
                    {
                        extend: 'print',
                        text: 'Print',
                        title: title,
                    }
                ]
            }]);
        },
        prepareData() {
            this.rows = [];
            this.prompt_data.data.forEach(item => {
                let row = [];
                this.prompt_data.columns.map(column => {
                    row.push(item[column.EA_TagName] ?? "");
                });

                this.rows.push(row);
            });

            this.headers = this.prompt_data.columns.map(column => {
                return {
                    title: column.EA_ColumnName
                }
            });
        },
        changeView(view = null) {
            this.prompt_data.chartType = view;
        },
        stringToTitle(str) {
            return str.split(" ").map(([firstChar,...rest])=>firstChar.toUpperCase()+rest.join("").toLowerCase()).join(" ");
        }
    },
    watch: {
        prompt_data: {
            handler: function (val) {
                this.prepareData();
                if (this.dtHandle) {
                    this.dtHandle.clear().destroy();
                    $(`#table-${this.inc_number}`).empty();
                }
                this.dtHandle = $(`#table-${this.inc_number}`).DataTable({
                    columns: this.headers,
                    data: this.rows,
                    layout: this.customLayout(),
                    buttons: this.customButtons()
                });
            },
            deep: true
        }
    },
}
</script>
