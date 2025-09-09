<template>
    <div class="row">
        <div :class="class_name">
            <form method="post" @submit.prevent>
                <input type="hidden" v-if="customerOrderRuleData.id" v-model="customer_order_rule.id"/>
                <div class="card">
                    <div class="card-body">
                        <div :class="{'form-group': true, 'd-none': frontendCustomerId !== null }">
                            <label>Customer <span class="text-danger">*</span>
                            </label>
                            <multiselect :options="customerList"
                                         :multiple="false"
                                         :searchable="true"
                                         v-model="tempCustomer"
                                         :close-on-select="true" :clear-on-select="false"
                                         :class="{'is-invalid' : validationErrors.customer_id}"
                                         label="customer_name"
                                         placeholder="Select a customer"
                                         track-by="id"/>
                            <small v-if="validationErrors.customer_id" class="invalid-feedback">
                                {{ validationErrors.customer_id[0] }}
                            </small>
                        </div>
                        <div class="form-group">
                            <label>Order Rule <span class="text-danger">*</span>
                            </label>
                            <multiselect v-model="tempOrderRule" :options="orderRuleList" :multiple="false"
                                         :searchable="true"
                                         :close-on-select="true" :clear-on-select="false"
                                         placeholder="Select an order rule from list"
                                         track-by="id"
                                         label="name"
                                         :class="{'is-invalid' : validationErrors.order_rule_id}"
                                         :disabled="isRuleDisabled"
                            />
                            <small v-if="validationErrors.order_rule_id" class="invalid-feedback">
                                {{ validationErrors.order_rule_id[0] }}
                            </small>
                        </div>
                        <div class="form-group">
                            <label>
                                Name <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="name" class="form-control"
                                   :class="{'is-invalid' : validationErrors.name}"
                                   placeholder="Enter customer rule name"
                                   v-model="customer_order_rule.name">
                            <small v-if="validationErrors.name" class="invalid-feedback">
                                {{ validationErrors.name[0] }}
                            </small>
                        </div>
                        <div class="form-group">
                            <label>
                                Description
                            </label>
                            <textarea class="form-control"
                                      :class="{'is-invalid' : validationErrors.description}"
                                      placeholder="Enter customer rule name"
                                      v-model="customer_order_rule.description"></textarea>
                            <small v-if="validationErrors.description" class="invalid-feedback">
                                {{ validationErrors.description[0] }}
                            </small>
                        </div>
                        <component ref="component" :is="currentOrderRule"></component>
                        <div class="form-group form-check">
                            <input type="checkbox"
                                   class="form-check-input"
                                   :class="{'is-invalid' : validationErrors.description}"
                                   v-model="customer_order_rule.enabled"
                                   id="rule-enabled">
                            <label class="form-check-label" for="rule-enabled">Enabled?</label>
                            <small v-if="validationErrors.enabled" class="invalid-feedback">
                                {{ validationErrors.enabled[0] }}
                            </small>
                        </div>
                    </div>
                </div>
                <div id="saveActions" class="form-group">
                    <input type="hidden" name="save_action" value="save_and_back" v-model="actionType">
                    <div class="btn-group" role="group">
                        <button type="button" :class="{'btn btn-success': true, 'rounded': fromFrontend}"
                                @click="actionType=saveAction.active.value; saveData(saveAction.active.value)">
                            <span class="la la-save" role="presentation" aria-hidden="true"></span> &nbsp;
                            <span>{{ saveAction.active?.label ?? '' }}</span>
                        </button>
                        <div :class="{'btn-group' : true, 'mt-0': fromFrontend,  'd-none': fromFrontend}" role="group">
                            <button id="bpSaveButtonsGroup" type="button"
                                    class="btn btn-success dropdown-toggle"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span :class="{'caret': true, 'd-none': fromFrontend}"></span>
                                <span :class="{'sr-only': true, 'd-none': fromFrontend}">▼</span>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="bpSaveButtonsGroup">
                                <template v-for="(option, k, index) in saveAction.options">
                                    <button class="dropdown-item" type="button" :key="'actionType-' + index"
                                            @click="saveData(k)">
                                        {{ option }}
                                    </button>
                                </template>
                            </div>
                        </div>
                    </div>
                    <a :href="backUrl" class="btn btn-default">
                        <span class="la la-ban"></span> &nbsp;Cancel </a>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import Multiselect from 'vue-multiselect';
import SubTotal from './rules/SubTotal';
import ForbiddenProduct from "./rules/ForbiddenProduct";
import CartItemCount from "./rules/CartItemCount";
import axios from 'axios';
import _ from 'lodash';

export default {
    name: "CustomerOrderRoleCreate",

    components: {
        Multiselect,
        SubTotal,
        ForbiddenProduct,
        CartItemCount
    },

    props: [
        'axios_url', 'method', 'customer_order_rule_data', 'customer_list',
        'save_action', 'class_name', 'from_frontend', 'frontend_customer_id',
        'back_url'
    ],

    data() {
        return {
            validationErrors: {},
            customerOrderRuleData: JSON.parse(this.customer_order_rule_data),
            customerList: JSON.parse(this.customer_list),
            orderRuleList: [],
            contactList: [],
            tempCustomer: null,
            tempOrderRule: null,
            isRuleDisabled: true,
            isEditAble: false,
            currentOrderRule: '',
            customer_order_rule: {
                id: null,
                name: null,
                customer_id: null,
                order_rule_id: null,
                enabled: false,
                description: null,
                value: [],
            },
            actionType: 'save_and_back',
            saveAction: JSON.parse(this.save_action),
            backUrl: this.back_url,
            fromFrontend: this.from_frontend ?? false,
            frontendCustomerId: this.frontend_customer_id ?? null
        }
    },

    mounted() {
        this.isEditAble = this.method === 'put';

        if (this.isEditAble && !this.fromFrontend) {
            this.initAdminEditLayout()
        }

        if (this.fromFrontend) {
            this.initFrontendEditLayout()
        }
    },

    methods: {
        initFrontendEditLayout() {
            for (let i = 0; i < this.customerList.length; i++) {
                if (this.customerList[i].id === this.frontendCustomerId) {
                    this.tempCustomer = this.customerList[i];
                    break;
                }
            }
            this.customer_order_rule.id = this.customerOrderRuleData.id ?? null;
            this.customer_order_rule.name = this.customerOrderRuleData.name ?? null;
            this.customer_order_rule.description = this.customerOrderRuleData.description ?? null;
            this.customer_order_rule.enabled = this.customerOrderRuleData.enabled ?? false;
            this.customer_order_rule.value = this.customerOrderRuleData.value ?? [];
        },
        initAdminEditLayout() {
            for (let i = 0; i < this.customerList.length; i++) {
                if (this.customerList[i].id === this.customerOrderRuleData.customer_id) {
                    this.tempCustomer = this.customerList[i];
                    break;
                }
            }
            this.customer_order_rule.id = this.customerOrderRuleData.id ?? null;
            this.customer_order_rule.name = this.customerOrderRuleData.name ?? null;
            this.customer_order_rule.description = this.customerOrderRuleData.description ?? null;
            this.customer_order_rule.enabled = this.customerOrderRuleData.enabled ?? false;
            this.customer_order_rule.value = this.customerOrderRuleData.value ?? [];
        },
        async loadAllOrderRules() {
            let fetchRule = '/admin/customer-order-rule/fetch/order-rule';

            if (this.fromFrontend) {
                fetchRule = '/fetch/order-rule';
            }

            await axios.post(fetchRule, {
                method: this.method,
                customer_id: this.customer_order_rule.customer_id
            }).then(res => {
                this.orderRuleList = res.data;
                if (this.orderRuleList.length > 0) {
                    if (this.customerOrderRuleData.hasOwnProperty('order_rule_id')) {
                        for (let i = 0; i < this.orderRuleList.length; i++) {
                            if (this.orderRuleList[i].id === this.customerOrderRuleData.order_rule_id) {
                                this.tempOrderRule = this.orderRuleList[i];
                                break;
                            }
                        }
                    }
                    this.isRuleDisabled = false;
                } else {
                    (new Noty({
                        type: 'warning',
                        text: 'No rule available for this customer'
                    })).show();
                }
            }).catch(error => {
                console.log(error);
            });
        },
        async getAllContactsByCustomer() {
            await axios.get(`/fetch/contacts/${this.customer_order_rule.customer_id}`)
                .then(res => {
                    this.contactList = res.data;
                }).catch(error => {
                    this.contactList = [];
                });
        },
        changeRule(rule_short_code) {
            switch (rule_short_code) {
                case 'sub-total-rule' :
                    this.currentOrderRule = SubTotal;
                    break;

                case 'forbidden-product-rule' :
                    this.currentOrderRule = ForbiddenProduct;
                    break;

                case 'cart-item-count-rule' :
                    this.currentOrderRule = CartItemCount;
                    break;

                default:
                    this.currentOrderRule = '';
            }
        },
        saveData(actionType) {
            this.actionType = actionType;
            this.customer_order_rule._save_action = actionType;
            axios[this.method](`${this.axios_url}`, this.customer_order_rule)
                .then(response => {

                    if(this.fromFrontend) {
                        ShowNotification('success', 'Order Rule', response.data.message);
                    } else {
                        (new Noty({
                            type: "success",
                            text: 'Saved successfully',
                        })).show();
                    }
                    window.location.href = "/"+response.data.redirect_url;

                })
                .catch((err) => {
                    this.validationErrors = err.response.data.errors;

                    if(this.fromFrontend) {
                        ShowNotification('error', 'Order Rule', err.response.data.message);
                    } else {
                    (new Noty({
                        type: "error",
                        text: err.response.data.message,
                    })).show();
                    }
                });
        }
    },

    watch: {
        tempCustomer: function (customer) {
            if (customer != null) {
                this.customer_order_rule.customer_id = customer.id;
                this.orderRuleList = [];
                this.isRuleDisabled = true;
                this.currentOrderRule = '';
                this.customer_order_rule.order_rule_id = null;
                this.loadAllOrderRules();
                this.getAllContactsByCustomer(customer.id);
            }
        },
        tempOrderRule: function (orderRule) {
            if (orderRule != null && orderRule.short_code != null) {
                this.customer_order_rule.order_rule_id = orderRule.id;
                this.changeRule(orderRule.short_code)
            }
        }
    },
};
</script>

<style scoped></style>
