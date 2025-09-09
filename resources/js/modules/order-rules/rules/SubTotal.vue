<template>
    <div class="form-group">
        <label>Parameters</label>
        <div class="border px-4 py-2 bg-light mb-1 rounded" v-for="(ruleValue, index) in customer_order_rule_value"
             :key="index">
            <button type="button"
                    class="btn btn-sm p-0 btn-light rounded-circle" :class="$parent.fromFrontend ? 'position-absolute':'position-absolute-backend'"
                    style="left: 6px; width: 30px; height: 30px; cursor: pointer"
                    @click="removeRuleForm(index)">
                <span class="text-muted" aria-hidden="true"
                      style="font-weight: 700; font-size: 1.5rem; line-height: 1;">×</span>
            </button>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label :for="`contact-${index}`">Contact(s)</label>
                        <multiselect :options="$parent.contactList" :multiple="true"
                                     :searchable="true"
                                     :close-on-select="false" :clear-on-select="false"
                                     placeholder="Select Contacts"
                                     :id="`contact-${index}`"
                                     track-by="id" label="name" v-model="ruleValue.contacts"/>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label :for="`from-amount-${index}`">From Amount</label>
                        <input type="number" step="any" :id="`from-amount-${index}`" class="form-control"
                               v-model="ruleValue.from_amount">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label :for="`to-amount-${index}`">To Amount</label>
                        <input type="number" step="any" :id="`to-amount-${index}`" class="form-control"
                               v-model="ruleValue.to_amount">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label :for="`ship-address-${index}`">Shipping Address</label>
                        <multiselect :options="ship_addresses" :multiple="true"
                                     :searchable="true"
                                     v-model="ruleValue.ship_to"
                                     :close-on-select="true"
                                     :clear-on-select="false"
                                     :id="`ship-address-${index}`"
                                     placeholder="Select Shipping"
                                     track-by="address_code" label="address_name"/>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label :for="`approver-${index}`">Approver(s)</label>
                        <multiselect :options="approvers" :multiple="true"
                                     :searchable="true"
                                     :close-on-select="true" :clear-on-select="false"
                                     placeholder="Select approver(s)"
                                     :id="`approver-${index}`"
                                     track-by="id" label="name" v-model="ruleValue.approvers"/>
                    </div>
                </div>
            </div>
        </div>
        <button class="btn btn-outline-primary" @click="addRuleForm()">+ Add More Parameters</button>
    </div>
</template>
<script>
import axios from "axios";

export default {
    name: "SubTotal",
    data() {
        return {
            customer_order_rule_value: [],
            approvers: [],
            ship_addresses: [],
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

            this.ship_addresses = res.data.meta.ship_addresses;

            //Existing Fields
            if (res.data.data != null) {
                res.data.data.forEach((ruleValue) => {
                    let rule = {
                        from_amount: ruleValue.from_amount,
                        to_amount: ruleValue.to_amount,
                        ship_to: [],
                        approvers: [],
                        contacts: [],
                    };

                    ruleValue.contacts.forEach(contact_id => {
                        const contact = this.$parent.contactList.find(contact => contact.id === contact_id);

                        if (contact) {
                            rule.contacts.push(contact);
                        }
                    });

                    this.approvers.forEach((approver) => {
                        if (ruleValue.approvers.includes(approver.id)) {
                            rule.approvers.push(approver);
                        }
                    });

                    this.ship_addresses.forEach((ship_address) => {
                        if (ruleValue.ship_to.includes(ship_address.address_code)) {
                            rule.ship_to.push(ship_address);
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
                from_amount: null,
                to_amount: null,
                ship_to: [],
                approvers: [],
                contacts: [],
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
                        from_amount: rule_value.from_amount,
                        to_amount: rule_value.to_amount,
                        ship_to: rule_value.ship_to.map((ship) => ship.address_code),
                        approvers: rule_value.approvers.map((approver) => approver.id),
                        contacts: rule_value.contacts.map((contact) => contact.id),
                    })
                });
            },
            deep: true
        }
    }
};
</script>
<style>
    .position-absolute-backend{
        position: absolute;
        top: -14px;
    }
</style>
