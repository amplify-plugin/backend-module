<template>
    <div class="form-group"> 
        <label>Parameters</label>
        <div class="border px-4 py-2 bg-light mb-1 rounded" v-for="(ruleValue, index) in customer_order_rule_value"
             :key="index">
            <button type="button"
                    class="btn btn-sm p-0 btn-light rounded-circle position-absolute"
                    style="left: 6px; width: 30px; height: 30px; cursor: pointer"
                    @click="removeRuleForm(index)">
                <span class="text-muted" aria-hidden="true"
                      style="font-weight: 700; font-size: 1.5rem; line-height: 1;">×</span>
            </button>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label :for="`product-${index}`">Product</label>
                        <multiselect :options="products" :multiple="false"
                                     :searchable="true"
                                     v-model="ruleValue.product"
                                     :close-on-select="true"
                                     :clear-on-select="false"
                                     :id="`product-${index}`"
                                     placeholder="Select Product"
                                     track-by="id"
                                     label="local_product_name"/>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label :for="`approver-${index}`">Approval</label>
                        <multiselect :options="approvers" :multiple="true"
                                     :searchable="true"
                                     :close-on-select="true" :clear-on-select="false"
                                     placeholder="Select Who Approval"
                                     :id="`approver-${index}`"
                                     track-by="id" label="name" v-model="ruleValue.approvers"/>
                    </div>
                </div>
            </div>
        </div>
        <button class="btn btn-outline-primary" @click="addRuleForm()">+ New Item</button>
    </div>
</template>
<script>
import axios from "axios";

export default {
    name: "ForbiddenProduct",
    data() {
        return {
            customer_order_rule_value: [],
            approvers: [],
            products: [],
        };
    },
    created() {
        
        let fetchRule = '/admin/customer-order-rule/fetch/rule';

        if (this.$parent.fromFrontend) {
            fetchRule = '/fetch/rule';
        }
        
        axios.post(fetchRule, {
            customer_id: this.$parent.customer_order_rule.customer_id,
            order_rule_id: this.$parent.customer_order_rule.order_rule_id
        }).then(res => {
            //Meta Fields
            this.approvers = res.data.meta.approvers;
            this.products = res.data.meta.products;
            //Existing Fields
            if (res.data.data != null) {
                res.data.data.forEach((ruleValue) => {
                    
                    let rule = {
                        product: {},
                        approvers: []
                    };

                    this.approvers.forEach((approver) => {
                        if (ruleValue.approvers.includes(approver.id)) {
                            rule.approvers.push(approver);
                        }
                    });

                    this.products.forEach((product) => {
                        if (ruleValue.product === product.id) {
                            rule.product = product;
                        }
                    });

                    this.customer_order_rule_value.push(rule);
                });
            }
        }).catch(error => {
            console.log(error);
        });
    },
    methods: {
        addRuleForm() {
            this.customer_order_rule_value.push({
                product: {},
                approvers: []
            });
        },
        removeRuleForm(index) {
            delete this.customer_order_rule_value[index];
            this.customer_order_rule_value = this.customer_order_rule_value.filter((item) => typeof item != 'undefined');
        }
    },
    watch: {
        customer_order_rule_value: {
            handler: function () {
                this.$parent.customer_order_rule.value = [];
                this.customer_order_rule_value.forEach((rule_value) => {
                    this.$parent.customer_order_rule.value.push({
                        product: rule_value.product.id ?? null,
                        approvers: rule_value.approvers.map((approver) => approver.id)
                    })
                });
            },
            deep: true
        }
    }
};
</script>
