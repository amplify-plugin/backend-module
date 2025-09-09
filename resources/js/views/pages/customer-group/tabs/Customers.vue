<template>
    <div role="tabpanel" class="tab-pane active"
         id="tab_customers">
        <div class="row">
            <!-- load the view from type and view_namespace attribute if set -->

            <!-- hidden input -->
            <div class="hidden">
                <input type="hidden" name="customers" value="" class="form-control">
            </div>

            <div class="form-group col-sm-12">
                <div class="d-flex justify-content-between mb-2">
                    <label>
                        <strong>
                            Search Customers To Add
                        </strong>
                        <i v-if="$parent.searching" class="la la-spinner la-pulse"></i>
                    </label>

                    <button class="btn btn-default btn-sm"
                            type="button"
                            @click="$parent.resetSearch();"
                            data-toggle="tooltip"
                            data-placement="top"
                            title="Reset Search">
                        <i class="la la-history"></i>
                    </button>
                </div>

                <!-- Searching input -->
                <input type="text" class="form-control"
                       :readonly="$parent.searching"
                       v-model="$parent.customer_search"
                       @keyup="setDebounce()"
                       placeholder="Search Text...">

                <div v-if="$parent.isSearchResult" class="dropdown">
                    <div class="dropdown-menu shadow">
                        <div v-if="$parent.customerList.data.length" class="divFixed">
                            <div v-for="(customer, customerIndex) in $parent.customerList.data">
                                <a type="button" class="dropdown-item"
                                   @click="$parent.addCustomerToGroup(customer, customerIndex)">
                                    {{ customer.customer_name }} &nbsp;
                                    <strong> | </strong>&nbsp;
                                    {{ customer.email }} &nbsp;
                                    <strong> | </strong>&nbsp;
                                    {{ customer.phone }}</a>
                            </div>
                        </div>
                        <div v-else class="text-center">
                            <span>No customer found</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group col-sm-12">
                <div class="d-flex justify-content-between mb-2">
                    <label class="my-auto">
                        <strong>
                            Customers In Group
                        </strong>
                        <small>
                            (Showing {{ $parent.pagination.firstItem }} to
                            {{ $parent.pagination.lastItem }} of
                            {{ $parent.pagination.totalItems }} items)
                        </small>
                    </label>

                    <div class="pagination">
                        <span class="btn btn-outline-default mr-1"
                              :class="$parent.pagination.currentPage <= 1
                                  ? 'disabled'
                                  : 'text-dark cursor-pointer'"
                              @click="$parent.changeCurrentPage(false)"
                              :title="`${$parent.pagination.currentPage <= 1
                                            ? ''
                                            : 'Previous (' + ($parent.pagination.currentPage - 1) + ')'}`">
                            <i class="la la-less-than"></i>
                        </span>
                        <select v-model="$parent.pagination.resultsPerPage"
                                class="rounded border border-secondary"
                                title="Results Per Page"
                                @change="onChangePaginationDropdown()">
                            <option :value="perPage" v-for="perPage in $root.perPages" :key="perPage">
                                {{ perPage }}
                            </option>
                        </select>
                        <span class="btn btn-outline-default ml-1"
                              :class="$parent.pagination.currentPage >= $parent.pagination.pageCount
                                                      ? 'disabled'
                                                      : 'text-dark cursor-pointer'"
                              @click="$parent.changeCurrentPage(true)"
                              :title="`${$parent.pagination.currentPage >= $parent.pagination.pageCount
                                                                ? ''
                                                                : 'Next (' + ($parent.pagination.currentPage + 1) + ')'}`">
                            <i class="la la-greater-than"></i>
                        </span>
                    </div>
                </div>
                <div v-if="$parent.loading">
                    <Loader/>
                </div>
                <div v-else class="tableFixHead rounded border">
                    <table :key="$parent.reRenderTable" class="table table-default table-hover mb-0">
                        <thead>
                        <tr>
                            <th scope="col" class="text-nowrap">Customer Code</th>
                            <th scope="col" class="text-nowrap">Customer Name</th>
                            <th scope="col" class="text-nowrap">Customer Email</th>
                            <th scope="col" class="text-nowrap">Customer Phone</th>
                            <th scope="col">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-if="$parent.assignedCustomerList.length"
                            v-for="(customer, index) in $parent.assignedCustomerList">
                            <td>
                                {{ customer.customer_code }}
                            </td>

                            <td>
                                {{ customer.customer_name }}
                            </td>
                            <td>
                                {{ customer.email }}
                            </td>
                            <td>
                                {{ customer.phone }}
                            </td>
                            <td>
                                <button class="btn btn-danger btn-sm"
                                        @click="$parent.removeCustomer(customer.id, index)"
                                        data-toggle="tooltip" data-placement="top" title="Remove">
                                    <i class='lar la-trash-alt'></i>
                                </button>
                            </td>
                        </tr>
                        <tr v-if="!$parent.assignedCustomerList.length">
                            <td class="text-center w-100" colspan="100%">No customer found</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import _      from "lodash";
import Loader from "../../../components/Loader";


export default {
    name      : "Customers",
    components: {Loader},
    data() {
        return {
            timer: null,
        }
    },
    mounted() {
        this.$parent.getCustomerList(null, 'customerByGroupId');
    },

    methods: {
        setDebounce() {
            clearTimeout(this.timer);
            let customer_search = this.$parent.customer_search;
            this.timer          = setTimeout(() => {
                this.$parent.getCustomerList(customer_search);
            }, 600)
        },

        onChangePaginationDropdown() {
            this.$parent.pagination.currentPage = 1;
            this.$parent.getCustomerList(this.$parent.customer_search)
        },
    },
    watch  : {},
}
</script>

<style scoped>
.dropdown-menu {
    width: 100%;
    display: block;
}

.divFixed {
    max-height: 200px !important;
    overflow-y: auto !important;
}

a:not([href]):not([tabindex]):hover {
    background-color: #ebeced;
}

.tableFixHead {
    max-height: 400px !important;
    overflow-y: auto !important;
}

.tableFixHead table {
    border-collapse: collapse;
    width: 100%;
}

.tableFixHead table th {
    position: sticky;
    top: 0;
    z-index: 1;
    background: #eee !important;
}

.tableFixHead table th,
.tableFixHead table td {
    padding: 8px 16px;
}
</style>
