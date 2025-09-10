<template>
    <section class="checkout checkout-step" :class="[`checkout-${stepId}`, { active: isActive }]"
        :data-parent="`#${stepId}`">
        <h4><i class="icon-paper"></i> Payment Methods</h4>
        <hr class="padding-bottom-1x" />
        <div class="card">
            <div class="card-body">
                <div class="alert alert-danger fade show" role="alert" v-if="errors">
                    <strong>{{ errors }}!</strong>.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="row d-flex justify-content-center">
                    <div class="col-xs-12 col-md-8 col-lg-6">
                        <p class="text-center font-weight-bold" style="font-size: 1.5rem; margin-right: 20px;">
                            Total To Be Charged: <strong>${{ calculateTotal }}</strong>
                        </p>

                        <p id="cenpos-error-message" style="display: none">
                            N.B: Double clicking on the Credit card also initiate the payment.
                        </p>

                        <div class="form-group mt-3">
                            <label class="font-weight-bold d-block">Select Payment Method:</label>

                            <div class="form-check form-check-inline" v-if="showOnAccount">
                                <input class="form-check-input" type="radio" id="onAccount" value="on_account" v-model="selectedPaymentMethod" />
                                <label class="form-check-label" for="onAccount">On Account</label>
                            </div>

                            <div class="form-check form-check-inline" v-if="showCreditCard">
                                <input class="form-check-input" type="radio" id="creditCard" value="credit_card" v-model="selectedPaymentMethod" />
                                <label class="form-check-label" for="creditCard">Credit Card</label>
                            </div>

                            <div class="form-check form-check-inline" v-if="showACH">
                                <input class="form-check-input" type="radio" id="ach" value="ach" v-model="selectedPaymentMethod" />
                                <label class="form-check-label" for="ach">ACH</label>
                            </div>
                        </div>

                        <div v-if="selectedPaymentMethod === 'on_account'"  :key="'billing-info-' + selectedPaymentMethod" class="mt-4 border rounded p-3 bg-light">
                            <h5>Billing Information</h5>
                            <p><strong>Name:</strong> {{ $parent.customerData?.CustomerName || 'N/A' }}</p>
                            <p><strong>Address:</strong> {{ $parent.checkout_payload?.customer_address_one || 'N/A' }}</p>
                            <p><strong>City:</strong> {{ $parent.checkout_payload?.customer_city || 'N/A' }}</p>
                            <p><strong>State:</strong> {{ $parent.checkout_payload?.customer_state?.name || 'N/A' }}</p>
                            <p><strong>Zip Code:</strong> {{ $parent.checkout_payload?.customer_zip_code || 'N/A' }}</p>
                            <p><strong>Phone:</strong> {{ $parent.checkout_payload?.customer_phone || 'N/A' }}</p>
                            <p><strong>Email:</strong> {{ $parent.checkout_payload?.customer_email || 'N/A' }}</p>
                        </div>

                        <div v-show="selectedPaymentMethod === 'credit_card'">
                            <div id="CenposPlugin">
                                <div class="w-100 h-100 justify-content-center align-items-center"
                                    style="padding-top: 214px">
                                    <!-- <img src="/assets/img/loading.gif" style="margin-left: 47%" alt="" /> -->
                                </div>
                            </div>

                            <form method="POST" action="">
                                <input type="button" class="btn btn-primary" id="paySubmit" value="Submit" />

                                <input type="hidden" name="cardname" value="" />
                                <input type="hidden" name="cc_token" value="" />
                                <input type="hidden" name="last_four" value="" />
                                <input type="hidden" name="cc_cardtype" value="" />
                                <input type="hidden" name="cardexpmonth" value="" />
                                <input type="hidden" name="cardexpyear" value="" />
                                <input type="hidden" name="cardtype" value="" />
                            </form>
                        </div>

                        <div v-if="selectedPaymentMethod === 'ach'" class="mt-4 border rounded p-3 bg-light">
                            <h5>ACH Payment Confirmation</h5>
                            <p class="mb-0">Your payment method is <strong>ACH</strong></p>
                            <p>Please click <strong>Continue</strong> to complete the checkout process.</p>
                        </div>
                    </div>
                </div>
                <div id="cenpos-failed-body" class="d-none">
                    <h3 class="h3 text-center text-danger mb-4">Sorry something has gone wrong!</h3>
                    <p>
                        We are sorry, but we are unable to connect with the payment processing system for your credit
                        card.
                    </p>

                    <div class="d-flex justify-content-center mb-5">
                        <a href="/shop" class="btn btn-outline-primary">Return to Shop</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="alert alert-danger mt-2" role="alert" v-if="$parent.validationError">
            {{ $parent.validationError }}
        </div>
    </section>
</template>

<script>
import axios from 'axios';
import { mapState } from 'vuex';

export default {
    name: 'Billing',
    props: ['isActive', 'stepId'],
    data() {
        return {
            ajaxCall: null,
            errors: '',
            selectedPaymentMethod: 'credit_card',
            isCreditCardRequired: this.$parent.isCreditCardRequired,
            isAchRequired: this.$parent.isAchRequired
        };
    },
    mounted() {
        if (this.isCreditCardRequired) {
            this.selectedPaymentMethod = 'credit_card';
        } else if (this.isAchRequired) {
            this.selectedPaymentMethod = 'ach';
        } else {
            this.selectedPaymentMethod = 'on_account';
        }

        this.$parent.payment_method = this.selectedPaymentMethod;

        $('#paySubmit').click(function () {
            if (typeof $('#CenposPlugin').submitAction == 'function') {
                $('#CenposPlugin').submitAction();
            } else {
                $('#cenpos-error-message').css('display', 'block');
            }
        });
    },
    methods: {
        loadCenposToken() {
            const self = this;

            getFullPageLoader();

            self.ajaxCall = setTimeout(() => {
                const paymentMethod = self.selectedPaymentMethod;

                axios
                    .post('/api/cenpos-token', {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        email: self.$parent.checkout_payload.customer_email,
                        amount: self.calculateTotal,
                        address: self.$parent.checkout_payload.customer_address_one,
                        zipcode: self.$parent.checkout_payload.customer_zip_code,
                        method: paymentMethod,
                    })
                    .then((res) => {
                        const url =
                            paymentMethod === 'ach'
                                ? self.$parent.cenpos_ach_payment_url
                                : self.$parent.cenpos_payment_url;

                        self.setupPaymentSystem(
                            self.$parent.customerData.CustomerNumber,
                            res.data,
                            url
                        );
                    })
                    .catch((error) => {
                        console.error('There was an error with the API call:', error);
                    })
                    .finally(() => {
                        removeFullPageLoader();
                    });
            }, 1000);
        },
        setupPaymentSystem(customerNumber, verifyingPost, payment_url) {
            let params = {
                verifyingpost: verifyingPost,
                type: 'Auth',
                autologin: 'false',
                disabledalert: 'false',
                ispresta: 'true',
                check: 'false',
                isCvv: 'true',
                amount: this.calculateTotal,
                customUrlCss: this.$parent.cenpos_css_url,
                address: this.$parent.checkout_payload.customer_address_one,
                zipcode: this.$parent.checkout_payload.customer_zip_code,
            };

            if (!this.$parent.isGuestUser) {
                params.isEmail = true;
            }

            $('#CenposPlugin').createWebpay({
                url: payment_url,
                async: false,
                params: new URLSearchParams(params).toString(),
                width: '100%',
                height: '428',
                success: this.successCallback,
                cancel: this.CallbackCancel,
            });
        },
        successCallback(res) {
            if ((!res.TokenId && !res.RecurringSaleTokenId) || res.Result === '221') {
                this.errors = res.Message;
            } else {
                this.$parent.checkout_payload.credit_card_token = res.TokenId ?? res.RecurringSaleTokenId;
                this.$parent.cenpos_information.card_type = res.CardType ?? '';
                this.$parent.cenpos_information.card_number = res.ProtectedCardNumber ?? '';
                ShowNotification('success','Success', 'Token is generated. please continue to checkout.');
            }

        },
        CallbackCancel(res) {
            if (res) {
                this.errors = 'Decline transaction! Please,Try again!';
            }
        },
        navigate(navIndex) {
            this.$parent.steps.map((step) => (step.active = false));
            this.$parent.steps.find((step) => step.index === navIndex).active = true;
        },
    },
    computed: {
        ...mapState('checkout', ['methods']),
        calculateTotal() {
            // let shippingAmount = this.$parent.shippingMethod?.amount ?? 0;
            // let taxAmount = this.methods.SalesTaxAmount;
            // let hazMatCharge = this.methods.HazMatCharge;
            // let total = Number(this.$parent.cart.total) + Number(shippingAmount) + Number(taxAmount) + Number(hazMatCharge);
            let total = Number(this.methods?.TotalOrderValue ?? 0);
            return total.toFixed(2);
        },

        showCreditCard() {
            return this.isCreditCardRequired || !this.isAchRequired;
        },

        showACH() {
            return this.isAchRequired;
        },

        showOnAccount() {
            return !this.isCreditCardRequired && !this.isAchRequired;
        }
    },
    watch: {
        isActive(newVal) {
            if (newVal && this.selectedPaymentMethod === 'credit_card') {
                this.loadCenposToken();
            }
        },
        selectedPaymentMethod(newMethod) {
            this.$parent.payment_method = newMethod;
            if (this.isActive && newMethod === 'credit_card') {
                this.loadCenposToken();
            }
        },
    },
};
</script>

<style scoped>
.my-popup-class {
    width: 300px;
    height: auto;
}

.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    align-items: center;
    justify-content: center;
}

.modal-container {
    background: white;
    padding: 20px;
    border-radius: 10px;
    text-align: center;
    width: 400px;
}

.modal-container h3 {
    margin-bottom: 10px;
}

.modal-container button {
    margin: 10px;
}
</style>
