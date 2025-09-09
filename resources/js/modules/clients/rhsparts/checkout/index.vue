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
                :style="{ width: step_width }"
                @click="() => $refs.navigator.navigator(activeStep.index, step.index)"
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
        'steps_info',
        'cart_info',
        'addresses_info',
        'countries_info',
        'states_info',
        'ship_options_info',
        'cenpos_payment_url',
        'client_code',
        'client_name',
        'cenpos_info'
    ],
    components: { Customer, Shipping, Billing, CenposBilling, Review, TabNavigator },
    data() {
        return {
            isGuestUser: !this.is_auth_user,
            customerData: JSON.parse(this.customer_info),
            steps: JSON.parse(this.steps_info),
            cart: JSON.parse(this.cart_info),
            addresses: JSON.parse(this.addresses_info),
            countries: JSON.parse(this.countries_info),
            states: JSON.parse(this.states_info),
            shipOptions: JSON.parse(this.ship_options_info),
            cenposInfo: JSON.parse(this.cenpos_info),
            clientName: this.client_name,
            orderRuleStatus: null,
            validationErrors: {},
            validationError: '',
            recurringTokenId: '',
            shippingVia: '',
            shippingMethod: '',
            defaultCountryCode: 'US',

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

                credit_card_contact: null,
                requested_ship_date: null,
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
            },

            shipping_option: null,
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
            if (this.checkout_payload?.chooseShipping) {
                return {
                    addressOne: this.shipping_checkout?.ship_to_address1,
                    addressTwo: this.shipping_checkout?.ship_to_address2,
                    addressThree: this.shipping_checkout?.ship_to_address3,
                    country: this.shipping_checkout?.ship_to_country,
                    state: this.shipping_checkout?.ship_to_state,
                    city: this.shipping_checkout?.ship_to_city,
                    zipCode: this.shipping_checkout?.ship_to_zip_code,
                    phone: this.shipping_checkout?.shipping_phone,
                };
            } else {
                return {
                    addressOne: this.checkout_payload?.customer_address_one,
                    addressTwo: this.checkout_payload?.customer_address_two,
                    addressThree: this.checkout_payload?.customer_address_three,
                    country: this.checkout_payload?.customer_country,
                    state: this.checkout_payload?.customer_state,
                    city: this.checkout_payload?.customer_city,
                    zipCode: this.checkout_payload?.customer_zip_code,
                    phone: this.checkout_payload?.customer_phone,
                };
            }
        },
        activeStep() {
            return this.steps.find((step) => step.active);
        },
    },
    mounted() {
        if (this.isGuestUser) {
            this.checkout_payload.shipping_address = 'TEMP';
        } else {
            this.checkout_payload.customer_name = this.customerData.CustomerName;
            this.checkout_payload.customer_email = this.customerData.CustomerEmail;
            this.checkout_payload.customer_phone = this.customerData.CustomerPhone;
            this.checkout_payload.customer_country = this.customerData.CustomerCountry;
            this.checkout_payload.customer_address_one = this.customerData.CustomerAddress1;
            this.checkout_payload.customer_address_two = this.customerData.CustomerAddress2;
            this.checkout_payload.customer_address_three = this.customerData.CustomerAddress3;
            this.checkout_payload.customer_city = this.customerData.CustomerCity;
            this.checkout_payload.customer_state = this.customerData.CustomerState;
            this.checkout_payload.customer_zip_code = this.customerData.CustomerZipCode;
        }

        this.checkout_payload.customer_country = this.shipping_checkout.ship_to_country = this.countries.find(
            (option) => option.iso2 === this.customerData.CustomerCountry ?? this.defaultCountryCode,
        );

        if (!this.isGuestUser) {
            this.checkout_payload.customer_state = this.shipping_checkout.ship_to_state = this.states.find(
                (option) => option.country_code === this.customerData.CustomerCountry ?? this.defaultCountryCode,
            );
        }
    },
    methods: {
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
                order_note: this.checkout_payload.notes,
                card_token: this.checkout_payload.credit_card_token,
                total_order_value: this.shippingOptions?.TotalOrderValue,
                sales_tax_amount: this.shippingOptions?.SalesTaxAmount,
                freight_amount: 0,
                address_name:'TEMP',
                shipping_option: this.shipping_option,
                // freight_amount: this.shippingMethod?.amount,
            };

            if (this.checkout_payload?.chooseShipping) {
                payload = Object.assign(payload, {
                    address_1: this.shipping_checkout?.ship_to_address1,
                    address_2: this.shipping_checkout?.ship_to_address2,
                    address_3: this.shipping_checkout?.ship_to_address3,
                    address_country_code: this.shipping_checkout?.ship_to_country?.iso2,
                    address_state: this.shipping_checkout?.ship_to_state?.iso2,
                    address_city: this.shipping_checkout?.ship_to_city,
                    address_zip_code: this.shipping_checkout?.ship_to_zip_code,
                    phone: this.shipping_checkout?.shipping_phone,
                    shipping_number: 'TEMP',
                });
            } else {
                payload = Object.assign(payload, {
                    address_1: this.checkout_payload?.customer_address_one,
                    address_2: this.checkout_payload?.customer_address_two,
                    address_3: this.checkout_payload?.customer_address_three,
                    address_country_code: this.checkout_payload?.customer_country?.iso2,
                    address_state: this.checkout_payload?.customer_state?.iso2,
                    address_city: this.checkout_payload?.customer_city,
                    address_zip_code: this.checkout_payload?.customer_zip_code,
                    phone: this.checkout_payload?.customer_phone,
                    shipping_number: '',
                });
            }
            if (this.checkout_payload.chooseShipping) {
                payload = Object.assign(payload, {
                    chooseShipping: this.checkout_payload.chooseShipping,
                });
            }
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
                    this.validationErrors = error.response.data?.errors ?? {};
                });
        },
    },
};
</script>
