<template>
    <div class="row">
        <div :class="class_name">
            <form method="post" @submit.prevent="" :action="backUrl">

                <!-- load the view from the application if it exists, otherwise load the one in the package -->
                <div class="tab-container  mb-2">
                    <Tabs :key="tabsRerender"/>

                    <div class="tab-content p-0 ">

                        <div class="nav-tabs-custom " id="form_tabs">

                            <div class="px-3">

                                <div v-if="Object.keys(validationErrors).length"
                                     class="alert alert-danger pb-0 alert-dismissible mb-0 mt-3 fade show"
                                     role="alert">
                                    <ul class="list-unstyled">
                                        <div>
                                            <li><i class="la la-info-circle"></i>
                                                Something went wrong (Validation Errors)
                                            </li>
                                        </div>
                                        <!--<div v-for="single_errors in validationErrors">
                                            <li v-for="error in single_errors"><i class="la la-info-circle"></i>
                                                {{ error }}
                                            </li>
                                        </div>-->
                                    </ul>
                                    <button type="button" class="close d-none" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            </div>

                            <component :is="activeTab"/>

                            <SwitchTabs ref="switchTabs"/>

                        </div>
                    </div>
                </div>

                <div id="saveActions" class="form-group">

                    <input type="hidden" name="save_action" v-model="actionType">

                    <div class="btn-group" role="group">
                    <button type="submit" class="btn btn-success">
                        <span class="la la-save" role="presentation" aria-hidden="true"></span> &nbsp;
                        <span @click="actionType=saveAction.active.value; saveData(saveAction.active.value)">{{ saveAction.active.label }}</span>
                    </button>
                    <div class="btn-group" role="group">
                        <button id="btnGroupDrop1" type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="caret"></span><span class="sr-only">▼</span></button>
                        <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                            <template v-for="(option, k, index) in saveAction.options">
                                <button class="dropdown-item"
                                    type="button"
                                    :key="'actionType-'+index"
                                    @click="saveData(k)">
                                    {{ option }}
                                </button>
                            </template>
                        </div>
                    </div>
                </div>

                <button @click="saveAndAction('cancel')" type="button"
                        class="btn btn-default">
                    <span class="la la-ban"></span> Cancel
                </button>

                </div>
            </form>
        </div>
    </div>
</template>

<script>
import AvailableLocales from "../../components/AvailableLocales";
import _                from "lodash";
import SwitchTabs from "../../components/SwitchTabs";
import Tabs       from ".//tabs/Tabs";
import BasicInfo  from ".//tabs/BasicInfo";
import Customers  from ".//tabs/Customers";


export default {
    name : "CustomerGroupCreate",
    props: [
        'class_name', 'url', 'active_tab',
        'method', 'axios_url', 'query_string', 'customer_group_pricing_type',
        'customer_group_data', 'categories', 'save_action'
    ],
    data() {
        return {
            customer_group         : {
                id                : '',
                group_code        : '',
                group_name        : '',
                group_pricing_type: 'rules-based-pricing',
                customers         : []
            },
            group_types            : JSON.parse(this.customer_group_pricing_type),
            backUrl                : '/admin/customer-group',
            newUrl                 : '/admin/customer-group/create',
            tabs                   : {
                BasicInfo: {title: 'Basic Info', hash: 'basic-info'},
                Customers: {title: 'Customers', hash: 'customers'},
            },
            activeTab              : _.cloneDeep(this.active_tab),
            validationErrors       : {},
            tabsRerender           : 0,
            flat_discounts         : [],
            rules_based_pricing    : {
                flat_discount                : false,
                flat_discount_pricing_rules  : [
                    {
                        discount  : "",
                        categories: []
                    },
                ],
                volume_discount              : false,
                volume_discount_additive     : false,
                volume_discount_pricing_rules: [
                    {
                        discounts : [],
                        categories: [],
                    }
                ],

                order_value_discount              : false,
                order_value_discount_additive     : false,
                order_value_discount_pricing_rules: []

            },
            OrderValueDiscount     : {
                order_value_upto: "",
                discount        : "",
                editable        : false,
            },
            tempOrderValueDiscount : {
                order_value_upto: "",
                discount        : "",
                editable        : false,
            },
            tempVolumeDiscount     : {
                min     : "",
                max     : "",
                discount: "",
                editable: false,
            },
            volume_discount_index  : [
                {
                    min     : "",
                    max     : "",
                    discount: "",
                    editable: false,
                }
            ],
            flat_categories        : [],
            volume_categories      : [],
            default_flat_discount  : {
                percentage: 0,
                categories: [],
            },
            index                  : 0,
            searching              : false,
            loading                : false,
            customer_search        : '',
            customerList           : {
                url : "/admin/customer-group/fetch/customer-list",
                data: [],
            },
            addCustomerToGroupUrl  : '/admin/customer-group/add-customer-to-group',
            removeCustomerFromGroup: "/admin/customer-group/remove-customer-from-group",
            reRenderTable          : 0,
            isSearchResult         : false,
            assignedCustomerList   : [],
            paginationBackup       : {
                currentPage   : 1,
                firstItem     : 0,
                lastItem      : 0,
                pageCount     : 0,
                resultsPerPage: 12,
                totalItems    : 0,
            },
            pagination             : {},
            VolumeBasedError       : [{"volume_min": "", "volume_max": "", "volume_discount": ""}],
            orderBasedError        : {},
            re_render_volume       : 0,
            re_render_order_value  : 0,
            saveAction      : JSON.parse(this.save_action),
            actionType      : '',

        }
    },
    components: {SwitchTabs, AvailableLocales, Tabs, BasicInfo, Customers},

    mounted() {
        this.pagination = _.cloneDeep(this.paginationBackup);
    },

    created() {
        this.flat_categories   = _.orderBy(JSON.parse(this.categories), 'label', 'asc');
        this.volume_categories = _.orderBy(JSON.parse(this.categories), 'label', 'asc');
        if (this.method === 'put') {
            this.initEdit()
        }
    },

    methods: {
        initEdit() {
            let customer_group_data = JSON.parse(this.customer_group_data);
            console.log('customer_group_data',customer_group_data);
            this.customer_group = {
                id                : customer_group_data.id,
                group_code        : customer_group_data.group_code,
                group_name        : customer_group_data.group_name,
                group_pricing_type: customer_group_data.group_pricing_type,
            };
            if (customer_group_data.cg_pricing_rules) {
                let customer_group_pricing_rules = customer_group_data.cg_pricing_rules;
                let filteredFlatDiscount         = [];
                let filteredVolumeDiscount       = [];
                let filteredOrderValueDiscount   = [];
                if (customer_group_pricing_rules.flat_discounts.length > 0) {
                    filteredFlatDiscount = customer_group_pricing_rules.flat_discounts.map((ele) => {
                        return {categories: ele.categories, discount: ele.discount};
                    });
                }
                let volume_discount_index = [];
                if (customer_group_pricing_rules.volume_discounts.length > 0) {
                    filteredVolumeDiscount = customer_group_pricing_rules.volume_discounts.map((ele) => {
                        volume_discount_index.push({
                            min     : "",
                            max     : "",
                            discount: "",
                            editable: false,
                        });
                        return {categories: ele.categories, discounts: ele.volume_discount_details};
                    });
                }

                if (!!customer_group_pricing_rules.order_value_discount && customer_group_pricing_rules.order_value_discount.order_value_discount_details.length > 0) {
                    filteredOrderValueDiscount = customer_group_pricing_rules.order_value_discount.order_value_discount_details.map((ele) => {
                        return {order_value_upto: ele.order_value_upto, discount: ele.discount};
                    });
                }

                this.rules_based_pricing = {
                    flat_discount                : customer_group_pricing_rules.is_flat_discount,
                    flat_discount_pricing_rules  : filteredFlatDiscount,
                    volume_discount              : customer_group_pricing_rules.is_volume_discount,
                    volume_discount_additive     : customer_group_pricing_rules.is_volume_discount_additive,
                    volume_discount_pricing_rules: filteredVolumeDiscount,

                    order_value_discount              : customer_group_pricing_rules.is_order_value_discount,
                    order_value_discount_additive     : customer_group_pricing_rules.is_order_value_discount_additive,
                    order_value_discount_pricing_rules: filteredOrderValueDiscount
                }
                this.volume_discount_index = volume_discount_index;
                delete this.rules_based_pricing['volume_discount_index'];
            }
            let volumeAllCategories      = _.cloneDeep(this.volume_categories);
            let volumeExistingCategories = [];
            if (this.rules_based_pricing.volume_discount_pricing_rules.length > 0) {
                this.rules_based_pricing.volume_discount_pricing_rules.forEach(ele => {
                    if (ele.categories.length > 0) {
                        volumeExistingCategories.push(ele.categories);
                    }
                })
                volumeExistingCategories      = _.flatten(volumeExistingCategories);
                let remainingVolumeCategories = volumeAllCategories.filter(ele => {
                    return !volumeExistingCategories.includes(volumeExistingCategories.find(el => el.id == ele.id))
                });
                this.volume_categories        = remainingVolumeCategories;
            }

            let flatDiscountAllCategories = _.cloneDeep(this.flat_categories);
            let flatExistingCategories    = [];
            if (this.rules_based_pricing.flat_discount_pricing_rules.length > 0) {
                this.rules_based_pricing.flat_discount_pricing_rules.forEach(ele => {
                    if (ele.categories.length > 0) {
                        flatExistingCategories.push(ele.categories);
                    }
                })
                flatExistingCategories              = _.flatten(flatExistingCategories);
                let remainingFlatExistingCategories = flatDiscountAllCategories.filter(ele => {
                    return !flatExistingCategories.includes(flatExistingCategories.find(el => el.id == ele.id))
                });
                this.flat_categories                = remainingFlatExistingCategories;
            }


        },

        saveAndAction(argument) {
            if (argument === 'cancel') {
                window.location = '/admin/customer-group';
            }
        },

        addOrderValueUpto() {
            this.rules_based_pricing.order_value_discount_pricing_rules.push({
                "order_value_upto": "",
                "discount"        : "",
                "editable"        : true
            })
        },

        validateOrderValueDiscount() {
            let err = {};
            if (!this.OrderValueDiscount.order_value_upto) {
                err.order_upto = "Order upto field is required";
            } else if (this.OrderValueDiscount.order_value_upto < 0) {
                err.order_upto = "Order upto field must not negative value";
            }
            if (!this.OrderValueDiscount.discount) {
                err.order_discount = "Discount field is required";
            } else if (parseFloat(this.OrderValueDiscount.discount)
                       < 0
                       || parseFloat(this.OrderValueDiscount.discount)
                       > 100) {
                err.order_discount = "Discount length between 0 to 100";
            }
            this.orderBasedError = err;
        },

        validateBeforeUpdateOrderValue(index) {
            let err                = 0;
            let orderValueDiscount = _.cloneDeep(this.rules_based_pricing.order_value_discount_pricing_rules[index]);
            delete this.rules_based_pricing.order_value_discount_pricing_rules[index].order_upto_error;
            delete this.rules_based_pricing.order_value_discount_pricing_rules[index].discount_error;
            if (!orderValueDiscount.order_value_upto) {
                this.rules_based_pricing.order_value_discount_pricing_rules[index].order_upto_error
                    = "Order upto field is required";
                err++;
            } else if (parseFloat(orderValueDiscount.order_value_upto) < 0) {
                this.rules_based_pricing.order_value_discount_pricing_rules[index].order_upto_error
                    = "Order upto must not negative value";
                err++;
            }
            if (!orderValueDiscount.discount) {
                this.rules_based_pricing.order_value_discount_pricing_rules[index].discount_error
                    = "Discount field is required";
                err++;
            } else if (orderValueDiscount.discount
                       < 0
                       || orderValueDiscount.discount
                       > 100) {
                this.rules_based_pricing.order_value_discount_pricing_rules[index].discount_error
                    = "Discount length between 0 to 100";
                err++;
            }
            return err;
        },


        updateOrderValue(index) {
            let errorCount = this.validateBeforeUpdateOrderValue(index);
            if (errorCount < 1) {
                this.rules_based_pricing.order_value_discount_pricing_rules[index].editable = false;
            }
            this.re_render_order_value++;
        },

        validateBeforeUpdateVolumeValue(index, indexInner) {
            let err = 0;
            delete this.rules_based_pricing.volume_discount_pricing_rules[index].discounts[indexInner].min_error;
            delete this.rules_based_pricing.volume_discount_pricing_rules[index].discounts[indexInner].max_error;
            delete this.rules_based_pricing.volume_discount_pricing_rules[index].discounts[indexInner].discount_error;
            if (!this.rules_based_pricing.volume_discount_pricing_rules[index].discounts[indexInner].min) {
                this.rules_based_pricing.volume_discount_pricing_rules[index].discounts[indexInner].min_error
                    = "Min field is required";
                err++;
            } else if (parseFloat(this.rules_based_pricing.volume_discount_pricing_rules[index].discounts[indexInner].min)
                       < 0) {
                this.rules_based_pricing.volume_discount_pricing_rules[index].discounts[indexInner].min_error
                    = "Min field must not be negative";
                err++;
            } else if (!!this.rules_based_pricing.volume_discount_pricing_rules[index].discounts[indexInner].max
                       && parseFloat(this.rules_based_pricing.volume_discount_pricing_rules[index].discounts[indexInner].min)
                       > parseFloat(this.rules_based_pricing.volume_discount_pricing_rules[index].discounts[indexInner].max)) {
                this.rules_based_pricing.volume_discount_pricing_rules[index].discounts[indexInner].min_error
                    = "Min value must not greater than max value";
                err++;
            }
            if (!this.rules_based_pricing.volume_discount_pricing_rules[index].discounts[indexInner].max) {
                this.rules_based_pricing.volume_discount_pricing_rules[index].discounts[indexInner].max_error
                    = "Max field is required";
                err++;
            } else if (parseFloat(this.rules_based_pricing.volume_discount_pricing_rules[index].discounts[indexInner].max)
                       < 0) {
                this.rules_based_pricing.volume_discount_pricing_rules[index].discounts[indexInner].maxerror
                    = "Max field must not be negative";
                err++;
            }
            if (!this.rules_based_pricing.volume_discount_pricing_rules[index].discounts[indexInner].discount) {
                this.rules_based_pricing.volume_discount_pricing_rules[index].discounts[indexInner].discount_error
                    = "Discount field is required";
                err++;
            }
            return err;
        },

        updateVolumeValue(index, indexInner) {
            let errorCount = this.validateBeforeUpdateVolumeValue(index, indexInner);
            if (errorCount < 1) {
                this.rules_based_pricing.volume_discount_pricing_rules[index].discounts[indexInner].editable = false;
            }
            this.re_render_volume++;
        },

        saveOrderValueDiscount() {
            this.validateOrderValueDiscount();
            if (_.isEmpty(this.orderBasedError)) {
                this.OrderValueDiscount.editable = false;
                this.rules_based_pricing.order_value_discount_pricing_rules.push(this.OrderValueDiscount);
                this.OrderValueDiscount = {order_value_upto: "", discount: "", editable: false,}
            }
        },

        validateVolumeValueDiscount(index) {
            let err = {};

            if (!this.volume_discount_index[index].min) {
                err.volume_min = "Min field is required";
            } else if (!!this.volume_discount_index[index].max
                       && parseFloat(this.volume_discount_index[index].min)
                       > parseFloat(this.volume_discount_index[index].max)) {
                err.volume_min = "Min value must not greater than max value";
            } else if (parseFloat(this.volume_discount_index[index].min) < 0) {
                err.volume_min = "Min field must not be negative";
            }
            if (!this.volume_discount_index[index].max) {
                err.volume_max = "Max field is required";
            } else if (parseFloat(this.volume_discount_index[index].max) < 0) {
                err.volume_max = "Max field must not be negative";
            }
            if (!this.volume_discount_index[index].discount) {
                err.volume_discount = "Discount field is required";
            }
            this.VolumeBasedError[index] = err;
        },

        saveVolumeValueDiscount(index) {
            this.validateVolumeValueDiscount(index);
            if (_.isEmpty(this.VolumeBasedError[index])) {
                this.volume_discount_index[index].editable = false;
                this.rules_based_pricing.volume_discount_pricing_rules[index].discounts.push(this.volume_discount_index[index]);
                this.volume_discount_index[index] = {
                    min     : "",
                    max     : "",
                    discount: "",
                    editable: false
                }
            } else {
                this.re_render_volume++;
            }
        },

        saveData(actionType) {
            this.validationErrors               = {};
            let pricing_rules                   = this.rules_based_pricing;
            pricing_rules.volume_discount_index = this.volume_discount_index;
            let params                          = _.cloneDeep(this.customer_group);
            params.pricing_rules                = pricing_rules
            params._save_action                 = actionType;

            axios[this.method](`${this.axios_url}`, params)
                .then(response => {
                    this.validationErrors = "";
                    switch(actionType){
                        case 'save_and_back':
                            console.log('save_and_back')
                            window.location = '/admin/customer-group'
                            break;
                        case 'save_and_edit':
                            console.log('save_and_edit')
                            window.location = '/admin/customer-group/'+ params.id +'/edit'
                            break;
                        case 'save_and_new':
                            console.log('save_and_new')
                            window.location = '/admin/customer-group/create'
                            break;
                        case 'save_and_preview':
                            console.log('save_and_preview')
                            window.location = '/admin/customer-group/'+ params.id +'/show'
                            break;
                    }
                })
                .catch((err) => {
                    this.validationErrors = err.response.data.errors;
                    new Noty({
                        type: "error",
                        text: err.response.data.message,
                    }).show();
                    console.error(err);
                });
        },

        changeCurrentPage(next = true) {
            let currentPage = this.pagination.currentPage;

            next && this.pagination.currentPage < this.pagination.pageCount
            ? this.pagination.currentPage++
            : false;

            !next && this.pagination.currentPage > 1
            ? this.pagination.currentPage--
            : false;

            currentPage !== this.pagination.currentPage
            ? this.getCustomerList(null, 'customerByGroupId')
            : false;
        },

        getNextTab(next = true, tab = this.activeTab) {
            let tabsName = _.keys(this.tabs);
            let tabInd   = _.indexOf(tabsName, tab);
            let lastInd  = _.lastIndexOf(tabsName);
            tab          = tabInd !== -1 && tabInd !== lastInd ? tabsName[tabInd + (next ? 1 : -1)] : tab;

            return tab ?? (next ? 'Products' : 'BasicInfo');
        },

        getCustomerList(search = null, action = null) {
            search = search ?? this.customer_search ?? '';

            if (action === 'customerByGroupId') {
                if (this.method === 'put') {
                    let params   = {
                        customer_group_id: this.customer_group.id,
                        pagination       : this.pagination,
                        page             : this.pagination.currentPage,
                    };
                    this.loading = true;
                    axios.post(this.customerList.url, params)
                        .then(({data}) => {
                            this.assignedCustomerList = data.data;
                            this.pagination           = {
                                currentPage   : data.current_page,
                                firstItem     : data.from,
                                lastItem      : data.to,
                                pageCount     : data.last_page,
                                resultsPerPage: data.per_page ?? 12,
                                totalItems    : data.total,
                            }
                            this.reRenderTable++;
                        })
                        .catch(error => {
                            new Noty({
                                type: "error",
                                text: error.message
                            }).show();
                        })
                        .finally(() => {
                            this.loading = false;
                        });
                }
            } else {
                if (search.length && search.length > 2) {
                    if (this.method === "put") {
                        let params     = {
                            search,
                            customer_group_id: this.customer_group.id
                        };
                        this.searching = true;
                        axios.post(this.customerList.url, params)
                            .then(({data}) => {
                                this.customerList.data = data.data;
                                this.isSearchResult    = true;
                                this.reRenderTable++;
                            })
                            .catch(error => {
                                new Noty({
                                    type: "error",
                                    text: error.message
                                }).show();
                            })
                            .finally(() => {
                                this.searching = false;
                            });
                    } else {
                        new Noty({
                            type: "warning",
                            text: 'Please save the customer group first'
                        }).show();
                    }
                } else {
                    new Noty({
                        type: "warning",
                        text: 'Please type at least 3 characters'
                    }).show();
                    this.customerList.data = [];
                    this.isSearchResult    = false;
                }
            }
        },

        resetSearch() {
            this.customerList.data = [];
            this.customer_search   = '';
            this.isSearchResult    = false;

            new Noty({
                type: "success",
                text: 'Reset successfully'
            }).show();
        },

        addCustomerToGroup(customer, customerIndex = null) {
            /*if (this.checkIfCustomerAlreadyExistInGroup(customer.id)) {
                new Noty({
                    type: "error",
                    text: 'Customer already exist in the group'
                }).show();
            } else {*/


            let params = {
                customer_id: customer.id,
                group_id   : this.customer_group.id
            };
            axios.post(this.addCustomerToGroupUrl, params)
                .then(({data}) => {
                    if (data.success) {
                        new Noty({
                            type: "success",
                            text: 'Added successfully'
                        }).show();
                        this.customerList.data.splice(customerIndex, 1);
                        this.getCustomerList(this.customer_search, 'customerByGroupId');
                    } else {
                        new Noty({
                            type: "error",
                            text: 'Can not add'
                        }).show();
                        this.reRenderTable++;
                    }

                })
                .catch(error => {
                    new Noty({
                        type: "error",
                        text: error.message
                    }).show();
                })
                .finally(() => {
                });
            //}
        },

        checkIfCustomerAlreadyExistInGroup(id = null) {
            let param = {id, customer_group_id: this.customer_group.id};
            axios.post('/admin/customer-group/fetch/customer-by-id', param).then(({data}) => {
                console.log(data)
            });
            return Boolean(this.assignedCustomerList.find(ele => ele.id === customerId));
        },

        removeCustomer(id, index = null) {
            this.$swal({
                title             : 'Remove this customer?',
                icon              : 'warning',
                showCancelButton  : true,
                confirmButtonColor: '#ff6b81',
                cancelButtonColor : '#399E7F',
                confirmButtonText : 'Remove'
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.post(this.removeCustomerFromGroup, {id})
                        .then(({data}) => {
                            if (data.success) {
                                // this.assignedCustomerList.splice(index, 1)
                                this.getCustomerList(this.customer_search, 'customerByGroupId');
                                new Noty({
                                    type: "success",
                                    text: `Customer removed successfully!`,
                                }).show();
                            } else {
                                new Noty({
                                    type: "error",
                                    text: 'Can remove customer'
                                }).show();
                                this.reRenderTable++;
                            }

                        })
                        .catch(error => {
                            new Noty({
                                type: "error",
                                text: error.message
                            }).show();
                        })
                        .finally(() => {
                        });
                }
            });
        },

        addRow() {
            this.rules_based_pricing.flat_discount_pricing_rules.push({
                discount  : "",
                categories: "",
            });
            this.index++;
        },

        addVolumeRow() {
            this.volume_discount_index.push({
                min     : "",
                max     : "",
                discount: "",
                editable: false,
            });
            this.rules_based_pricing.volume_discount_pricing_rules.push({
                discounts : [],
                categories: "",
            });
            //this.index++;
        },

        removevolume_discount_indexRow(index, indexInner) {
            this.$swal.fire({
                title: 'Are you sure?',
                //icon: 'warning',
                showCancelButton  : true,
                confirmButtonColor: '#42ba96',
                cancelButtonColor : '#ff7979',
                confirmButtonText : 'Yes, remove it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.rules_based_pricing.volume_discount_pricing_rules[index].discounts.splice(indexInner, 1);
                    new Noty({
                        type: "success",
                        text: 'removed successfully'
                    }).show();
                }
            })
        },

        removeOrderValueUptoRow(index) {
            this.$swal.fire({
                title: 'Are you sure?',
                //icon: 'warning',
                showCancelButton  : true,
                confirmButtonColor: '#42ba96',
                cancelButtonColor : '#ff7979',
                confirmButtonText : 'Yes, remove it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.rules_based_pricing.order_value_discount_pricing_rules.splice(index, 1);
                    new Noty({
                        type: "success",
                        text: 'removed successfully'
                    }).show();
                }
            })
        },

        deleteVolumeRow(index) {
            this.$swal.fire({
                title: 'Are you sure?',
                //icon: 'warning',
                showCancelButton  : true,
                confirmButtonColor: '#42ba96',
                cancelButtonColor : '#ff7979',
                confirmButtonText : 'Yes, remove it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    let allVolumeCategories      = _.cloneDeep(this.volume_categories);
                    let existingVolumeCategories = this.rules_based_pricing.volume_discount_pricing_rules[index].categories;
                    console.log(existingVolumeCategories);

                    if (existingVolumeCategories.length > 0) {
                        existingVolumeCategories.forEach(ele => {
                            allVolumeCategories.push(ele);
                        });
                        let sortedVolumeCategories = _.orderBy(allVolumeCategories, 'label', 'asc');
                        this.volume_categories     = sortedVolumeCategories;
                    }

                    this.rules_based_pricing.volume_discount_pricing_rules.splice(index, 1);
                    new Noty({
                        type: "success",
                        text: 'removed successfully'
                    }).show();
                }
            })

        },

        deleteFlatRow(index) {
            this.$swal.fire({
                title: 'Are you sure?',
                //icon: 'warning',
                showCancelButton  : true,
                confirmButtonColor: '#42ba96',
                cancelButtonColor : '#ff7979',
                confirmButtonText : 'Yes, remove it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    let allFlatCategories      = _.cloneDeep(this.flat_categories);
                    let existingFlatCategories = this.rules_based_pricing.flat_discount_pricing_rules[index].categories;
                    if (existingFlatCategories.length > 0) {
                        existingFlatCategories.forEach(ele => {
                            allFlatCategories.push(ele);
                        });
                        let sortedFlatCategories = _.orderBy(allFlatCategories, 'label', 'asc');
                        this.flat_categories     = sortedFlatCategories;
                    }
                    this.rules_based_pricing.flat_discount_pricing_rules.splice(index, 1);
                    new Noty({
                        type: "success",
                        text: 'removed successfully'
                    }).show();
                }
            })

        },

        removeError(key) {
            let errorsObject = this.validationErrors;
            let errorExist   = errorsObject[key];
            if (errorExist) {
                delete errorsObject[key];
            }
            //for re-render parent component
            if (Object.keys(errorsObject).length <= 0) {
                this.validationErrors = "";
            }
            this.validationErrors = errorsObject;
        },
    }
}
</script>

<style scoped>

</style>
