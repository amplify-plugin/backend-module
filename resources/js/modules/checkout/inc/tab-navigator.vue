<template>
    <div class="checkout-footer margin-top-1x">
        <div class="column">
            <a v-if="activeStep.index === 0" class="btn btn-outline-secondary" @click="backToCart">
                <i class="icon-arrow-left"></i>
                <span class="hidden-xs-down"> Back To Cart </span>
            </a>

            <a v-else class="btn btn-outline-secondary" @click="navigator(activeStep.index, activeStep.index-1)">
                <i class="icon-arrow-left"></i>
                <span class="hidden-xs-down"> Back </span>
            </a>
        </div>
        <div class="column">
            <button v-if="activeStep.index === step_length" type="button" class="btn btn-success" @click="$parent.submitOrder">
                <span class="hidden-xs-down"> {{ step_length > 2? 'Pay And Complete' : 'Complete' }} </span>
                <i class="icon-circle-check"></i>
            </button>

            <button v-else type="button" class="btn btn-primary" @click="navigator(activeStep.index, activeStep.index+1)">
                <span class="hidden-xs-down"> Continue </span>
                <i class="icon-arrow-right"></i>
            </button>
        </div>
    </div>

</template>

<script>
    export default {
        name: "tabNavigator",
        computed: {
            step_length() {
                return this.$parent.steps.length-1;
            },
            activeStep() {
                return this.$parent.steps.find(step => step.active);
            }
        },
        methods: {
            navigator(index, navIndex) {
                this.validateStepForm(() => {
                    if (index === 1 && navIndex === 2) {
                        getFullPageLoader();

                        this.validateAddress(res => {
                            if (res) {
                                this.$parent.checkout_payload.shipping_name = res.Name;
                                this.$parent.checkout_payload.ship_to_address1 = res.Address1;
                                this.$parent.checkout_payload.ship_to_address2 = res.Address2;
                                this.$parent.checkout_payload.ship_to_state.name = res.State;
                                this.$parent.checkout_payload.ship_to_city = res.City;
                                this.$parent.checkout_payload.ship_to_zip_code = res.ZipCode;
                            }

                            if (!this.$parent.isGuestUser) {
                                this.checkOrderRule(index, navIndex);
                            } else {
                                this.navigate(navIndex);
                            }
                        });

                    } else if (index === 3 && navIndex === 2 && this.$parent.orderRuleStatus == "need_approver") {
                        this.navigate(1);
                    } else {
                        this.navigate(navIndex);
                    }
                }, navIndex < index);
            },
            validateAddress(callback) {
                if (this.$parent.checkout_payload.shipping_address == "TEMP") {
                    axios.post('validate/shipping-address', {
                        shipping_name: this.$parent.checkout_payload.shipping_name,
                        shipping_address1: this.$parent.checkout_payload.ship_to_address1,
                        shipping_address2: this.$parent.checkout_payload.ship_to_address2,
                        shipping_state: this.$parent.checkout_payload.ship_to_state?.name,
                        shipping_city: this.$parent.checkout_payload.ship_to_city,
                        shipping_zip: this.$parent.checkout_payload.ship_to_zip_code
                    }).then(res => {
                        if (res.data.Response == "Success") {
                            callback(res.data);
                        } else {
                            removeFullPageLoader();
                            ShowNotification('error', 'Shipping', res.data.Details ?? "Something went wrong.");
                        }
                    }).catch(err => {
                        removeFullPageLoader();
                        ShowNotification('error', 'Shipping', err.response.data.message);
                    });
                } else {
                    callback();
                }
            },
            checkOrderRule(index, navIndex) {
                axios.post('/cart/order-rules-check', {
                    ship_to_number: this.$parent.checkout_payload.shipping_address
                }).then(res => {
                    removeFullPageLoader();
                    this.$parent.orderRuleStatus = res.data.status;

                    if (this.$parent.orderRuleStatus == "passed") {
                        this.navigate(navIndex);
                    } else {
                        setPositionOffCanvas(false);
                        $('#rule-confirmation').modal({backdrop: 'static', keyboard: false}, 'show');
                    }
                }).catch(err => {
                    removeFullPageLoader();
                    ShowNotification('error', 'Shipping', err.response.data.message);
                });
            },
            navigate(navIndex) {
                removeFullPageLoader();
                this.$parent.steps.map(step => step.active = false);
                this.$parent.steps.find(step => step.index == navIndex).active = true;
            },
            validateStepForm(closer, bypass = false) {
                if (bypass || $("#checkout-form").valid()) {
                    closer()
                }
            },
            backToCart() {
                window.location.href = "/carts";
            }
        }
    }
</script>
