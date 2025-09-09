<template>
    <form action="">
        <div class="card">
            <div class="card-body">

                <div class="form-group">
                    <div v-if="contact.errors.any()" class="alert alert-danger">
                        <ul class="list-unstyled">
                            <div v-for="(error, index) in contact.errors" :key="index">
                                <li v-for="(message, index) in error" :key="index">
                                    <i class="la la-info-circle"></i>
                                    {{ message[0] }}
                                </li>
                            </div>
                        </ul>
                    </div>
                </div>

                <div class="form-group required" element="div">
                    <label>Customer <span class="required-custom">*</span></label>
                    <select name="customer" class="form-control" :disabled="true">
                        <option>{{ customerData.customer_name }}</option>
                    </select>
                </div>

                <div class="form-group required" element="div">
                    <label>Name <span class="required-custom">*</span></label>
                    <input type="text" name="name" v-model="contact.name" class="form-control"
                        @keypress="contact.errors.clear('name')" :disabled="disabled">
                    <small v-if="contact.errors.has('name')" class="text-danger mt-3">
                        {{ contact.errors.get("name") }}
                    </small>
                </div>

                <div class="form-group required" element="div">
                    <label>Email <span class="required-custom">*</span></label>
                    <input type="email" name="email" v-model="contact.email" class="form-control"
                        @keypress="contact.errors.clear('email')" :disabled="disabled">
                    <small v-if="contact.errors.has('email')" class="text-danger mt-3">
                        {{ contact.errors.get("email") }}
                    </small>
                </div>

                <div class="form-group required" element="div">
                    <label>Phone <span class="required-custom">*</span></label>
                    <input type="text" name="phone" v-model="contact.phone" class="form-control"
                        @keypress="contact.errors.clear('phone')" :disabled="disabled">
                    <small v-if="contact.errors.has('phone')" class="text-danger mt-3">
                        {{ contact.errors.get("phone") }}
                    </small>
                </div>

                <div class="form-group" element="div">
                    <div class="checkbox">
                        <input type="checkbox" name="is_approver" id="is_approver" v-model="contact.is_approver"
                            @change="contact.errors.clear('is_approver')" :disabled="disabled" />
                        <label class="form-check-label font-weight-normal" for="is_approver">Is Approver</label>
                    </div>
                    <small v-if="contact.errors.has('is_approver')" class="text-danger d-block">
                        {{ contact.errors.get("is_approver") }}
                    </small>
                </div>

                <div class="form-group" element="div">
                    <div class="checkbox">
                        <input type="checkbox" name="is_viewer" id="is_viewer" v-model="contact.is_viewer"
                            @change="contact.errors.clear('is_viewer')" :disabled="disabled" />
                        <label class="form-check-label font-weight-normal" for="is_viewer">Is Viewer</label>
                    </div>
                    <small v-if="contact.errors.has('is_viewer')" class="text-danger d-block">
                        {{ contact.errors.get("is_viewer") }}
                    </small>
                </div>

                <div class="form-group" element="div">
                    <div class="checkbox">
                        <input type="checkbox" name="is_buyer" id="is_buyer" v-model="contact.is_buyer"
                            @change="contact.errors.clear('is_buyer')" :disabled="disabled" />
                        <label class="form-check-label font-weight-normal" for="is_buyer">Is Buyer</label>
                    </div>
                    <small v-if="contact.errors.has('is_buyer')" class="text-danger d-block">
                        {{ contact.errors.get("is_buyer") }}
                    </small>
                </div>

                <div class="form-group" element="div">
                    <label>Address</label>
                    <select name="customer_address_id" class="form-control" v-model="contact.customer_address_id"
                        @change="contact.errors.clear('customer_address_id')" :disabled="disabled">
                        <option v-for="(address, index) in customerData.addresses" :key="index" :value="address.id">{{
                            address.address_name }}</option>
                    </select>
                    <small v-if="contact.errors.has('customer_address_id')" class="text-danger mt-3">
                        {{ contact.errors.get("customer_address_id") }}
                    </small>
                </div>

                <div class="form-group required" element="div">
                    <label>Password <span class="required-custom">*</span></label>
                    <input type="password" name="password" autocomplete="off" v-model="contact.password"
                        class="form-control" @keypress="contact.errors.clear('password')" :disabled="disabled">
                    <small v-if="contact.errors.has('password')" class="text-danger mt-3">
                        {{ contact.errors.get("password") }}
                    </small>
                </div>

                <div class="form-group required" element="div">
                    <label>Confirm Password <span class="required-custom">*</span></label>
                    <input type="password" name="password_confirmation" autocomplete="off"
                        v-model="contact.password_confirmation" class="form-control"
                        @keypress="contact.errors.clear('password_confirmation')" :disabled="disabled">
                    <small v-if="contact.errors.has('password_confirmation')" class="text-danger mt-3">
                        {{ contact.errors.get("password_confirmation") }}
                    </small>
                </div>

                <div class="form-group required" element="div">
                    <label>Order Limit <span class="required-custom">*</span></label>
                    <input type="number" name="order_limit" v-model="contact.order_limit" step="any" class="form-control"
                        @keypress="contact.errors.clear('order_limit')" :disabled="disabled">
                    <small v-if="contact.errors.has('order_limit')" class="text-danger mt-3">
                        {{ contact.errors.get("order_limit") }}
                    </small>
                </div>

                <div class="form-group required" element="div">
                    <label>Daily Budget Limit <span class="required-custom">*</span></label>
                    <input type="number" name="daily_budget_limit" v-model="contact.daily_budget_limit" step="any"
                        class="form-control" @keypress="contact.errors.clear('daily_budget_limit')" :disabled="disabled">
                    <small v-if="contact.errors.has('daily_budget_limit')" class="text-danger mt-3">
                        {{ contact.errors.get("daily_budget_limit") }}
                    </small>
                </div>

                <div class="form-group required" element="div">
                    <label>Monthly Budget Limit <span class="required-custom">*</span></label>
                    <input type="number" name="monthly_budget_limit" v-model="contact.monthly_budget_limit" step="any"
                        class="form-control" @keypress="contact.errors.clear('monthly_budget_limit')" :disabled="disabled">
                    <small v-if="contact.errors.has('monthly_budget_limit')" class="text-danger mt-3">
                        {{ contact.errors.get("monthly_budget_limit") }}
                    </small>
                </div>

                <div class="col-sm-12 d-flex justify-content-between">
                    <a class="btn btn-secondary" :href="`/${pathname}`">Back</a>

                    <button class="btn btn-primary" type="button" @click="saveData" v-show="!disabled">
                        Save and back
                    </button>
                </div>
            </div>
        </div>
    </form>
</template>

<script>
import Form from "../../../../utilities/Form";
export default {
    props: ['contact_data', 'customer_data', 'type', 'pathname'],
    data() {
        return {
            contact: new Form({
                name: "",
                email: "",
                phone: "",
                customer_address_id: "",
                password: "",
                password_confirmation: "",
                order_limit: "",
                daily_budget_limit: "",
                monthly_budget_limit: "",
                is_approver: 0,
                is_viewer: 0,
                is_buyer: 0
            }),
            contactData: {},
            customerData: {},
            axios_url: "",
            method: "post",
            disabled: false,
        }
    },
    methods: {
        initEdit() {
            this.contact = new Form({
                name: this.contactData.name,
                email: this.contactData.email,
                phone: this.contactData.phone,
                customer_address_id: this.contactData.customer_address_id,
                password: "",
                password_confirmation: "",
                order_limit: this.contactData.order_limit,
                daily_budget_limit: this.contactData.daily_budget_limit,
                monthly_budget_limit: this.contactData.monthly_budget_limit,
                is_approver: this.contactData.is_approver,
                is_viewer: this.contactData.is_viewer,
                is_buyer: this.contactData.is_buyer
            });
        },
        initComp() {
            switch (this.type) {
                case 'create':
                    this.axios_url = `/api/contacts`;
                    this.method = 'post';
                    break;
                case 'edit':
                    this.axios_url = `/api/contacts/${this.contactData.id}`;
                    this.method = 'put';
                    break;
                case 'view':
                    this.disabled = true;
                    break;
                default:
                    break;
            }
        },
        saveData() {
            this.contact.submit(this.method, this.axios_url).then(response => {

                let { message } = response;
                ShowNotification('success', ' ', message);
                window.location.href="/contacts";
                return;
            });
        }
    },
    created() {
        this.customerData = JSON.parse(this.customer_data);

        if (['edit', 'view'].includes(this.type)) { this.contactData = JSON.parse(this.contact_data); }
        this.initComp();
        if (['edit', 'view'].includes(this.type)) { this.initEdit(); }
    },
}
</script>

<style>.array-controls.btn-group {
    display: none;
}

[data-field-name=address],
[data-field-name=address] .array-container,
[data-field-name=address] .array-container table {
    margin-bottom: 0 !important;
}

.text-danger>.custom-password>.form-control {
    border: 1px solid #df4759;
}</style>
