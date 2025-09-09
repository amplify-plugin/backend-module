<template>
    <form id="checkout-form">
        <div class="checkout-steps">
            <a
                v-for="(step, index) in steps"
                :key="index"
                :id="step.id"
                href="javascript:void(0);"
                class="font-weight-bold h4"
                :class="{ active: step.active }"
                :style="{
                    width: step_width,
                    cursor: 'default',
                    pointerEvents: 'none'
                }"
            >
                <span v-if="index > 0" class="angle"></span>
                <span v-else class="step-indicator mr-1"></span>
                {{ step.label }}
            </a>
        </div>

        <component
            v-for="(step, index) in steps"
            :key="index"
            :is="step.component"
            :step-id="step.id"
            :is-active="step.active"
        />
        <TabNavigator ref="navigator" />

        <!-- Order Rule Confirmation -->
        <div class="modal fade" id="rule-confirmation" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Order Rule Confirmation</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-center">
                        <h2>
                            <i class="icon-help text-warning" style="font-size: 5rem"></i>
                            <p>Your order is under order rule.</p>
                        </h2>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" @click="submitOrder(true)">OK</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</template>

<script>
import Review from './inc/review.vue';
import Billing from './inc/billing.vue';
import CenposBilling from './inc/cenpos-billing.vue';
import Shipping from './inc/shipping.vue';
import Customer from './inc/customer.vue';
import TabNavigator from './inc/tab-navigator.vue';
import 'vue-multiselect/dist/vue-multiselect.min.css';
import { mapState } from 'vuex';

export default {
    name: 'OrderCheckout',
    props: [
        'is_auth_user',
        'is_redirect_order_complete',
        'customer_info',
        'contact_info',
        'steps_info',
        'cart_info',
        'addresses_info',
        'countries_info',
        'states_info',
        'ship_options_info',
        'cenpos_payment_url',
        'client_code',
        'cenpos_css_url',
        'is_credit_card_required',
        'cenpos_merchant_id',
        'cenpos_ach_payment_url',
        'is_ach_required',
    ],
    components: { Customer, Shipping, Billing, CenposBilling, Review, TabNavigator },
    data() {
        return {
            isGuestUser: !this.is_auth_user,
            customerData: JSON.parse(this.customer_info),
            contactData: JSON.parse(this.contact_info),
            steps: JSON.parse(this.steps_info),
            cart: JSON.parse(this.cart_info),
            addresses: JSON.parse(this.addresses_info),
            countries: JSON.parse(this.countries_info),
            states: JSON.parse(this.states_info),
            shipOptions: JSON.parse(this.ship_options_info),
            orderRuleStatus: null,
            validationErrors: {},
            validationError: '',
            recurringTokenId: '',
            shippingVia: '',
            shippingMethod: '',
            defaultCountryCode: 'US',
            defaultCountryState: 'CA',
            isCreditCardRequired: this.is_credit_card_required,
            isAchRequired : this.is_ach_required,
            lastShippingPayload: null,
            payment_method: '',

            checkout_payload: {
                customer_name: null,
                customer_email: null,
                customer_phone: null,
                customer_country: null,
                customer_address_one: null,
                customer_address_two: null,
                customer_address_three: null,
                customer_city: null,
                customer_state: null,
                customer_zip_code: null,
                customer_default_warehouse: null,
                chooseShipping: false,
                credit_card_token: '',
                billing_address: 'same-as-shipping',
                billing_name: null,
                billing_address1: null,
                billing_address2: null,
                billing_address3: null,

                billing_state: null,
                billing_zip_code: null,
                billing_country: null,

                po_number: null,
                notes: null,
                internal_notes: null,

                credit_card_contact: null,
                requested_ship_date: null,
                freight_account_number: null,
                sub_total: null,
            },

            shipping_checkout: {
                shipping_phone: null,
                ship_to_address1: null,
                ship_to_address2: null,
                ship_to_address3: null,
                ship_to_country: null,
                ship_to_state: null,
                ship_to_city: null,
                ship_to_zip_code: null,
                shipping_name: null,
                ship_to_carrier_code: null,
                ship_to_wharehouse: null,
            },

            cenpos_information: {
                merchant_id: this.cenpos_merchant_id,
                auth_number: '',
                card_type: '',
                reference_number: '',
                card_number: '',
            }
        };
    },
    computed: {
        ...mapState('checkout', {
            shippingOptions: (state) => state.methods,
        }),
        step_width() {
            return 100 / this.steps.length + '%';
        },
        getCustomerAddress() {
            const payload = this.checkout_payload;

            return {
                addressOne: payload.customer_address_one,
                addressTwo: payload.customer_address_two,
                addressThree: payload.customer_address_three,
                country: payload.customer_country,
                state: payload.customer_state,
                city: payload.customer_city,
                zipCode: payload.customer_zip_code,
                phone: payload.customer_phone,
            };
        },
    },
    mounted() {
        const customer = this.customerData;
        const contact = this.contactData;

        this.checkout_payload.customer_name = customer.CustomerName;
        this.checkout_payload.customer_email = contact.email;
        this.checkout_payload.customer_phone = contact.phone ?? customer.CustomerPhone;
        this.checkout_payload.customer_country = customer.CustomerCountry;
        this.checkout_payload.customer_address_one = customer.CustomerAddress1;
        this.checkout_payload.customer_address_two = customer.CustomerAddress2;
        this.checkout_payload.customer_address_three = customer.CustomerAddress3;
        this.checkout_payload.customer_city = customer.CustomerCity;
        this.checkout_payload.customer_state = customer.CustomerState;
        this.checkout_payload.customer_zip_code = customer.CustomerZipCode;
        this.checkout_payload.customer_default_warehouse = customer.DefaultWarehouse;
     
        this.checkout_payload.customer_country = this.shipping_checkout.ship_to_country =
            this.countries.find(opt => opt.iso2 === customer.CustomerCountry) ?? null;

        this.checkout_payload.customer_state = this.shipping_checkout.ship_to_state =
            this.states.find(
                opt => opt.country_code === customer.CustomerCountry && opt.iso2 === customer.CustomerState
            ) || this.states.find(
                opt => opt.country_code === this.defaultCountryCode && opt.iso2 === this.defaultCountryState
            );

    },
    methods: {
         getShippingPayload() {
            return {
                shipping_name: this.shipping_checkout.shipping_name,
                customer_phone: this.shipping_checkout.shipping_phone,
                customer_email: this.checkout_payload.customer_email,
                customer_country: this.shipping_checkout.ship_to_country?.iso2,
                customer_city: this.shipping_checkout.ship_to_city,
                customer_state: this.shipping_checkout.ship_to_state?.iso2,
                customer_zip_code: this.shipping_checkout.ship_to_zip_code,
                customer_address_one: this.shipping_checkout.ship_to_address1,
                customer_address_two: this.shipping_checkout.ship_to_address2,
                customer_address_three: this.shipping_checkout.ship_to_address3,
                shipping_method: this.shipping_checkout.ship_to_carrier_code,
                customer_default_warehouse: this.checkout_payload.customer_default_warehouse,
            };
        },
        submitOrder(isUnderOrderRule = false) {
            if (!$('#checkout-form').valid()) {
                return;
            }

            getFullPageLoader();

            let payload = {
                order_type: 'order',
                redirect_to_order_complete: this.is_redirect_order_complete,
                is_under_order_rule: isUnderOrderRule,
                customer_name: this.checkout_payload.customer_name,
                customer_email: this.checkout_payload.customer_email,
                customer_phone: this.checkout_payload.customer_phone,
                shipping_method: this.shippingMethod?.shipvia,
                shipping_amount: this.shippingMethod?.amount,
                customer_order_ref: this.checkout_payload.po_number,
                order_notes: this.checkout_payload.notes,
                card_token: this.checkout_payload.credit_card_token,
                total_order_value: this.shippingOptions?.TotalOrderValue,
                sales_tax_amount: this.shippingOptions?.SalesTaxAmount,
                freight_amount: this.shippingMethod?.amount,
                address_name:'TEMP',
                internal_notes: this.checkout_payload.internal_notes,
                po_number: this.checkout_payload.po_number,
                freight_account_number: this.checkout_payload.freight_account_number,
                sub_total: this.checkout_payload.sub_total ?? 0,
                payment_method: this.payment_method,
            };

            payload = Object.assign(payload, {
                address_1: this.shipping_checkout?.ship_to_address1,
                address_2: this.shipping_checkout?.ship_to_address2,
                address_3: this.shipping_checkout?.ship_to_address3,
                address_country_code: this.shipping_checkout?.ship_to_country?.iso2,
                address_state: this.shipping_checkout?.ship_to_state?.iso2,
                address_city: this.shipping_checkout?.ship_to_city,
                address_zip_code: this.shipping_checkout?.ship_to_zip_code,
                shipping_phone: this.shipping_checkout?.shipping_phone,
                shipping_number: 'TEMP',
                freight_terms_type:  this.shippingMethod?.frttermscd ?? null,
            });

            payload = Object.assign(payload, {
                billing_name: this.checkout_payload.customer_name,
                billing_address1: this.checkout_payload.customer_address_one,
                billing_address2: this.checkout_payload.customer_address_two,
                billing_address3: this.checkout_payload.customer_address_three,
                billing_state: this.checkout_payload.customer_state?.iso2,
                billing_zip_code: this.checkout_payload.customer_zip_code,
                billing_country: this.checkout_payload.customer_country?.iso2,
            });

            payload = Object.assign(payload, this.cenpos_information);
            axios
                .post('/customer/submit-order', payload)
                .then((res) => {
                    removeFullPageLoader();
                    ShowNotification('success', 'Order', res.data.message);
                    setTimeout(function () {
                        if (res.data.redirect_to) window.location.href = res.data.redirect_to;
                    }, 300);
                })
                .catch((error) => {
                    removeFullPageLoader();
                    ShowNotification('error', 'Address', error.response.data.message);
                    this.validationError =  error.response.data.message ?? '';
                });
        },
    },
};
</script>
