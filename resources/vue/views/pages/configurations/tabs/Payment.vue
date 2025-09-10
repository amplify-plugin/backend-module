<template>
    <div role="tabpanel" class="tab-pane active" id="tab_basic-info">
        <fieldset>
            <div class="d-flex justify-content-between border-bottom pb-0 mb-3 mt-n3">
                <legend>
                    <i class="la la-hand-holding-usd mr-2"></i>
                    Payment Gateway Settings
                </legend>
                <div class="d-md-none custom-sidebar-ar" @click="$parent.toggleSidebar()">
                    <div class="menu-icon-ar">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                             stroke="#1b2a4e" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                             class="feather feather-menu">
                            <line x1="3" y1="12" x2="21" y2="12"></line>
                            <line x1="3" y1="6" x2="21" y2="6"></line>
                            <line x1="3" y1="18" x2="21" y2="18"></line>
                        </svg>
                    </div>
                    <div class="close-icon-ar">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                             stroke="red" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                             class="feather feather-x">
                            <line x1="18" y1="6" x2="6" y2="18"></line>
                            <line x1="6" y1="6" x2="18" y2="18"></line>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="form-group" :class="{ 'text-danger': $parent.validationErrors.payment_gateway }">
                <label>Select Payment Gateway</label>
                <select name="payment_gateway" class="form-control custom-select"
                        v-model="paymentConfigurationData.payment_gateway"
                        @change="updatePaymentInfo"
                        :class="{ 'is-invalid': $parent.validationErrors.order_details_page_id }">
                    <option :value="index" v-for="(pg, index) in $parent.coreConfigurationData.payment.labels"
                            :key="index"
                            :selected="index == paymentConfigurationData.payment_gateway ? true : false">
                        {{ pg }}
                    </option>
                </select>
                <small v-if="$parent.validationErrors.order_details_page_id" class="text-danger mt-3">{{
                        $parent.validationErrors.order_details_page_id[0]
                    }}</small>
            </div>
            <div class="form-group">
                <label>Credit Card Payment url</label>
                <input type="text" name="payment_url" placeholder="Enter Payment url"
                       v-model="paymentConfigurationData.payment_url" class="form-control"
                       :class="{ 'is-invalid': $parent.validationErrors.payment_url }">
                <small v-if="$parent.validationErrors.payment_url" class="text-danger mt-3">{{
                        $parent.validationErrors.payment_url[0]
                    }}</small>
            </div>
            <div class="form-group">
                <label>ACH Payment url</label>
                <input type="text" name="ach_payment_url" placeholder="Enter ACH Payment url"
                       v-model="paymentConfigurationData.ach_payment_url" class="form-control"
                       :class="{ 'is-invalid': $parent.validationErrors.ach_payment_url }">
                <small v-if="$parent.validationErrors.ach_payment_url" class="text-danger mt-3">{{
                        $parent.validationErrors.ach_payment_url[0]
                    }}</small>
            </div>
            <div class="form-group">
                <label>Merchant ID</label>
                <input type="text" name="merchant_id" placeholder="Merchant ID"
                       v-model="paymentConfigurationData.merchant_id" class="form-control"
                       :class="{ 'is-invalid': $parent.validationErrors.merchant_id }">
                <small v-if="$parent.validationErrors.merchant_id" class="text-danger mt-3">{{
                        $parent.validationErrors.merchant_id[0]
                    }}</small>
            </div>
            <div class="form-group">
                <label>Cenpos encrypted mid</label>
                <input :type="encryptedMidType" name="cenpos_encrypted_mid" placeholder="Enter Cenpos encrypted mid"
                       v-model="paymentConfigurationData.cenpos_encrypted_mid" class="form-control"
                       :class="{ 'is-invalid': $parent.validationErrors.cenpos_encrypted_mid }">
                <i @click="toggleEncryptMidShow"
                   :class="{ 'eye-position las la-eye-slash': showEncryptMid, 'eye-position las la-eye': !showEncryptMid }"></i>
                <small v-if="$parent.validationErrors.cenpos_encrypted_mid"
                       class="text-danger mt-3">{{
                        $parent.validationErrors.cenpos_encrypted_mid[0]
                    }}</small>
            </div>
            <div class="form-group">
                <label>Secret key</label>
                <input :type="secretKeyType" name="secret_key" placeholder="Enter Secret key"
                       v-model="paymentConfigurationData.secret_key" class="form-control"
                       :class="{ 'is-invalid': $parent.validationErrors.secret_key }">
                <i @click="toggleSecretKeyShow"
                   :class="{ 'eye-position las la-eye-slash': showSecretKey, 'eye-position las la-eye': !showSecretKey }"></i>
                <small v-if="$parent.validationErrors.secret_key" class="text-danger mt-3">{{
                        $parent.validationErrors.secret_key[0]
                    }}</small>
            </div>
            <div class="form-group">
                <input type="checkbox" name="logger_enabled"
                       id="payment_logger_enabled"
                       v-model="paymentConfigurationData.logger_enabled"
                       :class="{ 'is-invalid': $parent.validationErrors.logger_enabled }">
                <label for="payment_logger_enabled">Enable Payment API Log</label>
                <small v-if="$parent.validationErrors.logger_enabled" class="text-danger mt-3">{{
                        $parent.validationErrors.logger_enabled[0]
                    }}</small>
            </div>
            <div class="form-group">
                <input type="checkbox" name="allow_payments" id="payment_allow_payments"
                       v-model="paymentConfigurationData.allow_payments"
                       :class="{ 'is-invalid': $parent.validationErrors.allow_payments }">
                <label for="payment_allow_payments">Allow Payments on account</label>
            </div>
            <div class="form-group">
                <input type="checkbox" name="allow_credit_payments" id="payment_allow_credit_payments"
                       v-model="paymentConfigurationData.allow_credit_payments"
                       :class="{ 'is-invalid': $parent.validationErrors.allow_credit_payments }"
                >
                <label for="payment_allow_credit_payments">Allow credits in payments</label>
                <small v-if="$parent.validationErrors.allow_credit_payments"
                       class="text-danger mt-3">{{
                        $parent.validationErrors.allow_credit_payments[0]
                    }}</small>
            </div>
            <div class="form-group">
                <input type="checkbox" name="allow_bulk_invoice_payments" id="payment_allow_bulk_invoice_payments"
                       v-model="paymentConfigurationData.allow_bulk_invoice_payments"
                       :class="{ 'is-invalid': $parent.validationErrors.allow_bulk_invoice_payments }">
                <label for="payment_allow_bulk_invoice_payments">Allow Bulk Invoice Payments</label>
            </div>
        </fieldset>
        <div id="saveActions" class="form-group">

            <button @click="$parent.saveCoreConfigInfo(paymentConfigurationData)" type="button"
                    class="btn btn-success">
                <span class="la la-save" role="presentation" aria-hidden="true"></span> &nbsp;
                <span data-value="save_and_edit"> Save</span>
            </button>

            <button @click="$parent.saveAndAction()" type="button" class="btn btn-default">
                <span class="la la-ban"></span> Cancel
            </button>

        </div>
    </div>
</template>

<script>
import Multiselect from "vue-multiselect";
import Treeselect from "@riophae/vue-treeselect";

import '@riophae/vue-treeselect/dist/vue-treeselect.css';

export default {
    name: "Payment",

    components: {Multiselect, Treeselect},

    data() {
        return {
            showEncryptMid: false,
            encryptedMidType: 'password',
            showSecretKey: false,
            secretKeyType: 'password',
            paymentConfigurationData: {
                tab: "payment",
                payment_gateway: this.$parent.coreConfigurationData.payment.default,
                payment_url: "",
                merchant_id: "",
                cenpos_encrypted_mid: "",
                secret_key: "",
                allow_credit_payments: this.$parent.coreConfigurationData.payment.allow_credit_payments,
                allow_payments: this.$parent.coreConfigurationData.payment.allow_payments,
                allow_bulk_invoice_payments: this.$parent.coreConfigurationData.payment.allow_bulk_invoice_payments,
                logger_enabled: this.$parent.coreConfigurationData.payment.logger_enabled

            }
        }
    },

    methods: {
        toggleEncryptMidShow() {
            this.showEncryptMid = !this.showEncryptMid;
            this.encryptedMidType = (this.showEncryptMid) ? 'text' : 'password';
        },
        toggleSecretKeyShow() {
            this.showSecretKey = !this.showSecretKey;
            this.secretKeyType = (this.showSecretKey) ? 'text' : 'password';
        },
        updatePaymentInfo(event) {
            this.setValue(event.target.value, this.$parent.coreConfigurationData.payment.gateways);
        },
        setValue(gateway, gateways) {
            for (const [key, value] of Object.entries(gateways)) {
                if (key === gateway) {
                    this.paymentConfigurationData.payment_url = value.payment_url ?? "";
                    this.paymentConfigurationData.ach_payment_url = value.ach_payment_url ?? "";
                    this.paymentConfigurationData.merchant_id = value.merchant_id ?? "";
                    this.paymentConfigurationData.secret_key = value.secret_key ?? "";
                    this.paymentConfigurationData.cenpos_encrypted_mid = value.cenpos_encrypted_mid ?? "";
                }
            }
        }
    },

    mounted() {
        this.paymentConfigurationData.logger_enabled = this.$parent.coreConfigurationData.payment.logger_enabled;
        this.setValue(this.$parent.coreConfigurationData.payment.default, this.$parent.coreConfigurationData.payment.gateways);
    }
}
</script>
