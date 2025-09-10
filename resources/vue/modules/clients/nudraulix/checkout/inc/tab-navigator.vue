<template>
    <div class="checkout-footer margin-top-1x my-2">
        <div class="column">
            <a v-if="activeStep.index === 0" class="btn btn-outline-secondary" @click="backToCart">
                <i class="icon-arrow-left"></i>
                <span class="hidden-xs-down"> Back To Cart </span>
            </a>

            <a v-else class="btn btn-outline-secondary" @click="navigator(activeStep.index, activeStep.index - 1)">
                <i class="icon-arrow-left"></i>
                <span class="hidden-xs-down"> Back </span>
            </a>
        </div>
        <div class="column">
            <button
                v-if="activeStep.index === step_length"
                type="button"
                class="btn btn-success"
                @click="handleSubmit"
            >
                <span class="hidden-xs-down"> {{ step_length > 2 ? 'Submit' : 'Complete' }} </span>
                <i class="icon-circle-check"></i>
            </button>

            <button
                v-else
                type="button"
                class="btn btn-primary"
                @click="navigator(activeStep.index, activeStep.index + 1)"
            >
                <span class="hidden-xs-down"> Continue {{ product }}</span>
                <i class="icon-arrow-right"></i>
            </button>
        </div>
    </div>
</template>

<script>
import { mapState, mapActions } from 'vuex';

export default {
    name: 'tabNavigator',
    data() {
        return {
            msg: 'Please, Select a Shipping Method!',
        };
    },
    computed: {
        ...mapState('checkout', ['product']),
        step_length() {
            return this.$parent.steps.length - 1;
        },
        activeStep() {
            return this.$parent.steps.find((step) => step.active);
        },
    },

    methods: {
        ...mapActions('checkout', ['getShippingMethod']),

        navigator(index, navIndex) {
            if (navIndex === 1) {
                this.validateStepForm(() => {
                    if (!this.$parent.checkout_payload.chooseShipping) {
                        const customerPayload = {
                            customer_name: this.$parent.checkout_payload.customer_name,
                            customer_phone: this.$parent.checkout_payload.customer_phone,
                            customer_email: this.$parent.checkout_payload.customer_email,
                            customer_country: this.$parent.checkout_payload.customer_country,
                            customer_city: this.$parent.checkout_payload.customer_city,
                            customer_state: this.$parent.checkout_payload.customer_state,
                            customer_zip_code: this.$parent.checkout_payload.customer_zip_code,
                            customer_address_one: this.$parent.checkout_payload.customer_address_one,
                            customer_address_three: this.$parent.checkout_payload.customer_address_three,
                            customer_address_two: this.$parent.checkout_payload.customer_address_two,
                        };
                        this.getShippingMethod(customerPayload);
                    } else {
                        const shippingPayload = {
                            customer_name: this.$parent.shipping_checkout.shipping_name,
                            customer_phone: this.$parent.shipping_checkout.shipping_phone,
                            customer_email: this.$parent.shipping_checkout.shipping_email,
                            customer_country: this.$parent.shipping_checkout.ship_to_country,
                            customer_city: this.$parent.shipping_checkout.ship_to_city,
                            customer_state: this.$parent.shipping_checkout.ship_to_state,
                            customer_zip_code: this.$parent.shipping_checkout.ship_to_zip_code,
                            customer_address_one: this.$parent.shipping_checkout.ship_to_address1,
                            customer_address_three: this.$parent.shipping_checkout.ship_to_address2,
                            customer_address_two: this.$parent.shipping_checkout.ship_to_address3,
                        };
                        this.getShippingMethod(shippingPayload);
                    }
                    this.navigate(navIndex);
                }, navIndex < index);
            } else if (navIndex === 2) {
                if (navIndex === 2 && !this.$parent.shippingMethod) {
                    this.$parent.validationError = this.msg;
                    return;
                } else {
                    this.$parent.validationError = '';
                }
                this.navigate(navIndex);
            } else {
                this.validateStepForm(() => {
                    this.navigate(navIndex);
                }, navIndex < index);
            }
        },

        navigate(navIndex) {
            this.$parent.steps.map((step) => (step.active = false));
            this.$parent.steps.find((step) => step.index === navIndex).active = true;
        },

        // Run jQuery validator AND parent custom validator
        validateStepForm(closer, bypass = false, msg = '') {
            const formOk = $('#checkout-form').valid();
            const customOk = this.$parent.validateFields();
            if (bypass || (formOk && customOk)) {
                closer();
            }
            if (msg) {
                this.$parent.validationError = msg;
            }
        },

        backToCart() {
            window.location.href = '/carts';
        },

        handleSubmit() {
            if (this.$parent.isCreditCardRequired && !this.$parent.checkout_payload.credit_card_token) {
                this.$parent.validationError = 'Please enter credit card details!';
                return;
            }
            this.$parent.validationError = '';
            this.$parent.submitOrder();
        }
    }
};
</script>
<style scoped>
.checkout-none {
    display: table;
    width: 100%;
    margin-top: 28px;
    table-layout: fixed;
}
</style>
