<template>
    <div>
        <data-table
            :data="data"
            :columns="columns"
            @on-table-props-changed="reloadTable"
        >
            <div slot="filters" slot-scope="{ tableFilters, perPage }">
                <div class="row">
                    <div class="col-12">
                        <a class="btn btn-outline-primary btn-sm" :href="`/${pathname}/create`">
                            Create Contact
                        </a>
                    </div>
                    <div class="col-md-2 mb-2">
                        <select class="form-control" v-model="tableFilters.length">
                            <option :key="page" v-for="page in perPage">{{ page }}</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-2 pt-2">
                        <div class="custom-control custom-checkbox d-inline">
                            <input class="custom-control-input" type="checkbox" id="ex-check-1" v-model="tableFilters.filters.isAdmin">
                            <label class="custom-control-label" for="ex-check-1">Is admin</label>
                        </div>
                        <div class="custom-control custom-checkbox d-inline">
                            <input class="custom-control-input" type="checkbox" id="ex-check-2" v-model="tableFilters.filters.isApprover">
                            <label class="custom-control-label" for="ex-check-2">Is approver</label>
                        </div>
                    </div>
                    <div class="col-md-4 mb-2">
                        <input
                            name="name"
                            class="form-control"
                            v-model="tableFilters.search"
                            placeholder="Search Table">
                    </div>
                </div>
            </div>

            <div slot="pagination" slot-scope="{ links = {}, meta = {} }">
                <nav class="row">
                    <div class="col-md-6 text-left">
                        <span>
                            Showing {{meta.from}} to {{meta.to}} of {{ meta.total }} Entries
                        </span>
                    </div>
                    <div class="col-md-6 text-right">
                        <button
                            :disabled="!links.prev"
                            class="btn btn-primary"
                            @click="url = links.prev">
                            Prev
                        </button>
                        <button
                            :disabled="!links.next"
                            class="btn btn-primary ml-2"
                            @click="url = links.next">
                            Next
                        </button>
                    </div>
                </nav>
            </div>

        </data-table>
    </div>
</template>
<script>
    import DTButton from "../datatable-comps/DTButton.vue";
    export default {
        props: ['pathname'],
        data() {
            return {
                url: "/api/contacts",
                data: {},
                tableProps: {
                    search: '',
                    length: 10,
                    column: 'id',
                    dir: 'asc'
                },
                columns: [
                    {
                        label: 'ID',
                        name: 'id',
                        orderable: true,
                    },
                    {
                        label: 'Name',
                        name: 'name',
                        orderable: true,
                    },
                    {
                        label: 'Email',
                        name: 'email',
                        orderable: true,
                    },
                    {
                        label: 'Order Limit',
                        name: 'order_limit',
                        orderable: true,
                    },
                    {
                        label: 'Action',
                        orderable: false,
                        classes: {
                            view: {},
                            edit: {}
                        },
                        component: DTButton,
                    }
                ],
            }
        },
        created() {
            this.getData(this.url);
        },
        watch: {
            url() {
                this.getData(this.url);
            }
        },
        methods: {
            getData(url = this.url, options = this.tableProps) {
                axios.get(url, {
                    params: options
                })
                .then(response => {
                    this.data = response.data;
                })
                .catch(errors => {});
            },

            reloadTable(tableProps) {
                this.getData(this.url, tableProps);
            }
        }
    }
</script>
<style>
</style>
