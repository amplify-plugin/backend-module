<template>
    <div role="tabpanel" class="tab-pane active settings-pane" id="tab_basic-info">
        <fieldset class="settings-shell">
            <div class="settings-header d-flex justify-content-between border-bottom pb-0 mb-3 mt-n3">
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
        <div id="saveActions" class="form-group settings-actions">

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
        this.setValue(this.$parent.coreConfigurationData.payment.default, this.$parent.coreConfigurationData.payment.gateways);
    }
}
</script>

<style scoped>
/* codex-basic-theme */
.settings-pane {
  padding: 1rem 0;
}

.settings-shell {
  border: 1px solid #e6ebf2;
  border-radius: 16px;
  padding: 1.25rem;
  background: #f7fafc;
  margin-bottom: 0.75rem;
}

.settings-header {
  border-bottom: 1px solid #e7edf5 !important;
}

.settings-header legend,
.settings-shell legend {
  margin: 0;
  color: #1f2a44;
  font-size: 1.2rem;
  font-weight: 600;
}

.settings-shell .form-group {
  background: #fff;
  border: 1px solid #e7edf5;
  border-radius: 12px;
  padding: 0.9rem;
}

.settings-shell .form-group > label,
.settings-shell .form-group label {
  color: #31415e;
  font-weight: 600;
  margin-bottom: 0.5rem;
}

.settings-shell .form-control,
.settings-shell .custom-select,
.settings-shell .multiselect .multiselect__tags,
.settings-shell .vue-treeselect .vue-treeselect__control {
  border: 1px solid #d7dfec !important;
  border-radius: 10px !important;
  min-height: 40px;
  box-shadow: none !important;
}

.settings-shell .form-control:focus,
.settings-shell .custom-select:focus,
.settings-shell .multiselect.multiselect--active .multiselect__tags {
  border-color: #7aa7ff !important;
  box-shadow: 0 0 0 3px rgba(62, 125, 255, 0.12) !important;
}

.settings-shell .multiselect .multiselect__tags {
  padding-top: 8px !important;
}

.settings-shell .form-check,
.settings-shell .custom-checkbox {
  padding: 0.68rem 0.78rem !important;
  border: 1px solid #dbe5f0;
  border-radius: 10px;
  background: #fff;
}

.settings-shell .form-check-label {
  display: inline-flex;
  align-items: center;
  margin-bottom: 0;
}

.settings-shell .form-check-input,
.settings-shell input[type='checkbox'] {
  position: static;
  margin-left: 0;
  margin-right: 0.5rem;
}

.settings-actions {
  margin-top: 1.2rem;
  display: flex;
  align-items: center;
  gap: 0.6rem;
  border: 0 !important;
  padding: 0 !important;
  background: transparent !important;
}

@media (max-width: 991.98px) {
  .settings-shell {
    padding: 1rem;
  }
}
</style>

<style scoped>
/* codex-spacing-fix */
.settings-shell {
  padding: 0.9rem !important;
  margin-bottom: 0.6rem !important;
}

.settings-header {
  margin: -0.2rem -0.2rem 0.7rem !important;
  padding: 0.2rem 0.2rem 0.6rem !important;
}

.settings-shell .form-row,
.settings-shell .row {
  margin-left: -0.35rem;
  margin-right: -0.35rem;
}

.settings-shell .form-row > [class*='col-'],
.settings-shell .row > [class*='col-'] {
  padding-left: 0.35rem;
  padding-right: 0.35rem;
}

.settings-shell .form-group {
  padding: 0.65rem !important;
  margin-bottom: 0.55rem !important;
}

.settings-shell .row .form-group,
.settings-shell .form-row .form-group {
  margin-bottom: 0.7rem !important;
}

.settings-shell .form-control,
.settings-shell .custom-select,
.settings-shell .multiselect .multiselect__tags {
  min-height: 36px !important;
}

.settings-shell .form-group > label,
.settings-shell .form-group label {
  margin-bottom: 0.38rem !important;
}

.settings-actions {
  margin-top: 0.8rem !important;
}

.settings-actions .btn {
  padding-top: 0.35rem;
  padding-bottom: 0.35rem;
}

@media (max-width: 991.98px) {
  .settings-shell {
    padding: 0.75rem !important;
  }

  .settings-shell .form-group {
    padding: 0.6rem !important;
  }
}
</style>
