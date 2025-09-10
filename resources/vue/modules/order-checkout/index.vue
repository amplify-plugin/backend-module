<template>
    <form id="checkout-form">
        <div class="checkout-steps">
            <a
                v-for="(step, index) in steps" :key="index" :id="step.id"
                href="javascript:void(0);"
                class="font-weight-bold h4"
                :class="{ active: step.active }"
                :style="{ width: step_width}"
            >
                <span v-if="index > 0" class="angle"></span>
                <span v-else class="step-indicator mr-1"></span>
                {{ step.label }}
            </a>
        </div>

        <component
            v-for="(step, index) in steps" :key="index"
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
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body text-center">
                        <h2>
                            <i class="icon-help text-warning" style="font-size: 5rem;"></i>
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
    import Review from "./inc/review.vue";
    import Billing from "./inc/billing.vue";
    import CenposBilling from "./inc/cenpos-billing.vue";
    import Shipping from "./inc/shipping.vue";
    import Customer from "./inc/customer.vue";
    import TabNavigator from './inc/tab-navigator.vue';

    export default {
        name: "OrderCheckout",
        props: ['customer_info', 'contact_info', 'steps_info', 'order_info', 'addresses_info', 'states_info', 'countries_info', 'ship_options_info', 'choose_ship_permission'],
        components: { Customer, Shipping, Billing, CenposBilling, Review, TabNavigator },
        data() {
            return {
                customerData: JSON.parse(this.customer_info),
                contactData: JSON.parse(this.contact_info),
                steps: JSON.parse(this.steps_info),
                order: JSON.parse(this.order_info),
                addresses: JSON.parse(this.addresses_info),
                countries: JSON.parse(this.countries_info),
                states: JSON.parse(this.states_info),
                shipOptions: JSON.parse(this.ship_options_info),
                orderRuleStatus: null,
                validationErrors: {},

                checkout_payload: {
                    customer_name: null,
                    customer_email: null,
                    customer_phone: null,

                    shipping_option: "",
                    shipping_address: "",
                    shipping_name: null,
                    ship_to_address1: null,
                    ship_to_address2: null,
                    ship_to_address3: null,
                    ship_to_country: null,
                    ship_to_state: null,
                    ship_to_city: null,
                    ship_to_zip_code: null,

                    credit_card_token: "",
                    billing_address: "same-as-shipping",
                    billing_name: null,
                    billing_address1: null,
                    billing_address2: null,
                    billing_address3: null,
                    billing_city: null,
                    billing_state: null,
                    billing_zip_code: null,
                    billing_country: null,

                    po_number: null,
                    notes: null,

                    credit_card_contact: null,
                    requested_ship_date: null,
                }
            }
        },
        computed: {
            step_width() {
                return (100/this.steps.length) + "%";
            }
        },
        mounted() {
            console.log(this.order.shipping_number ?? this.order.temp_address.address_name);

            this.checkout_payload.customer_name  = this.customerData.CustomerName;
            this.checkout_payload.customer_email = this.contactData.email;
            this.checkout_payload.customer_phone = this.customerData.CustomerPhone;

            this.checkout_payload.shipping_option = this.order.shipping_method ?? this.order.temp_address.address_name;
            this.checkout_payload.shipping_address = this.order.shipping_number ?? this.order.temp_address.address_name;

            this.checkout_payload.po_number = this.order.customer_order_number;
            this.checkout_payload.notes = this.order.notes;

            this.checkout_payload.ship_to_address1 = this.order.temp_address.address_1;
            this.checkout_payload.ship_to_country = this.order.temp_address.address_country_code;
            this.checkout_payload.ship_to_city = this.order.temp_address.address_city;
            this.checkout_payload.ship_to_state = this.order.temp_address.address_state
            this.checkout_payload.ship_to_zip_code = this.order.temp_address.address_zip_code
        },
        methods: {
            submitOrder(isUnderOrderRule = false) {
                if (!$("#checkout-form").valid()) {
                    return;
                }

                getFullPageLoader();

                axios.post(`/order/submit-pending-order/${this.order.id}`, {
                    customer_order_ref: this.checkout_payload.po_number,
                    order_note: this.checkout_payload.notes,
                    card_token: this.checkout_payload.credit_card_token,
                }).then(res => {
                    removeFullPageLoader();
                    ShowNotification('success', 'Order', res.data.message);

                    setTimeout(function () {
                        if (res.data.redirect_to)
                            window.location.href = res.data.redirect_to;
                    }, 300);
                })
                .catch(error => {
                    removeFullPageLoader();
                    ShowNotification('error', 'Address', error.response.data.message);
                    // console.log(error.response.data.errors);
                    this.validationErrors = error.response.data?.errors ?? {};
                });
            }
        }
    }
</script>
