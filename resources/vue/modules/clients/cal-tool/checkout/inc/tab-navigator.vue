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
            <button v-if="activeStep.index === step_length" type="button" class="btn btn-success" @click="handleSubmit">
                <span class="hidden-xs-down"> {{ step_length > 2 ? 'Submit' : 'Complete' }} </span>
                <i class="icon-circle-check"></i>
            </button>

            <button v-else type="button" class="btn btn-primary"
                @click="navigator(activeStep.index, activeStep.index + 1)">
                <span class="hidden-xs-down"> Continue {{ product }}</span>
                <i class="icon-arrow-right"></i>
            </button>
        </div>
    </div>
</template>

<script>
import { mapState, mapActions, mapGetters } from 'vuex';

export default {
    name: 'tabNavigator',
    data() {
        return {
            msg: 'Please, Select a Shipping Method!',
        };
    },
    computed: {
        ...mapState('checkout', ['product']),
        ...mapGetters('checkout', ['shippingMethods']),
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
                    const currentPayload = this.$parent.getShippingPayload();

                    // Compare current with cached payload
                    if (JSON.stringify(currentPayload) !== JSON.stringify(this.$parent.lastShippingPayload)) {
                        this.getShippingMethod(currentPayload);
                        this.$parent.lastShippingPayload = currentPayload; // cache the result
                    }

                    this.navigate(navIndex);
                }, navIndex < index);
            } else if (navIndex === 2) {
                if (!this.$parent.shippingMethod) {
                    this.$parent.validationError = this.msg;
                    return;
                }
                else if (
                    this.$parent.shippingMethod?.frttermscd === "C" &&
                    this.isFreightCollect(this.$parent.shippingMethod.shipvia) &&
                    !this.$parent.checkout_payload.freight_account_number
                ) {
                    this.$parent.validationError = 'Enter your freight account number.';
                    return;
                }
                else {
                    this.$parent.validationError = '';
                }
                this.navigate(navIndex);
            } else if (navIndex === 3) {
                 if (this.$parent.isCreditCardRequired && !this.$parent.checkout_payload.credit_card_token) {
                    this.$parent.validationError = 'Please enter credit card details!';
                    return;
                }

                this.$parent.validationError = '';
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
        validateStepForm(closer, bypass = false, msg = '') {
            if (bypass || $('#checkout-form').valid()) {
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
           if (!this.$parent.checkout_payload.po_number) {
                this.$parent.validationError = 'The purchase order number is required!';
                return;
            }
            this.$parent.validationError = '';
            this.$parent.submitOrder();
        },
        isFreightCollect(shipvia) {
            const freightMethods = this.shippingMethods['Freight Collect'] || [];
            for (const option of freightMethods) {
                for (const key in option) {
                    if (option[key].shipvia === shipvia) {
                        return true;
                    }
                }
            }
            return false;
        }
    },
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
