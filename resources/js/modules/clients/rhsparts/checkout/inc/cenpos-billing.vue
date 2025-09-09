<template>
    <section
        class="checkout checkout-step"
        :class="[`checkout-${stepId}`, { active: isActive }]"
        :data-parent="`#${stepId}`"
    >
        <h4><i class="icon-paper"></i> Payment Method</h4>

        <div class="alert alert-danger fade show" role="alert" v-if="errors">
  <strong>{{errors}}!</strong>.
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
        <div class="row d-flex justify-content-center">
            <div class="col-xs-12 col-md-8 col-lg-5">
                <p id="cenpos-error-message" style="display: none">
                    N.B: Double clicking on the Credit card also initiate the payment.
                </p>
                <div id="CenposPlugin" style="min-height: 428px">
                    <div class="w-100 h-100 justify-content-center align-items-center" style="padding-top: 214px">
                        <img src="/img/loading.gif" style="margin-left: 47%" alt="" />
                    </div>
                </div>

                <form method="POST" action="">
                    <input
                        type="button"
                        v-show="this.$parent.client_code === 'RHS'"
                        class="btn btn-primary float-right"
                        id="paySubmit"
                        value="Submit"
                    />

                    <input type="hidden" name="cardname" value="" />
                    <input type="hidden" name="cc_token" value="" />
                    <input type="hidden" name="last_four" value="" />
                    <input type="hidden" name="cc_cardtype" value="" />
                    <input type="hidden" name="cardexpmonth" value="" />
                    <input type="hidden" name="cardexpyear" value="" />
                    <input type="hidden" name="cardtype" value="" />
                </form>
            </div>
        </div>

        <div id="cenpos-failed-body" class="d-none">
            <h3 class="h3 text-center text-danger mb-4">Sorry something has gone wrong!</h3>
            <p>
                We are sorry, but we are unable to connect with the payment processing system for your credit card.
                Please contact {{$parent.clientName ?? "Amplify"}} with the following information.
            </p>

            <div class="d-flex justify-content-center mb-5">
                <a href="/shop" class="btn btn-outline-primary">Return to Shop</a>
            </div>
        </div>
    </section>
</template>

<script>
import axios from 'axios';
import { mapState} from 'vuex';

export default {
    name: 'Billing',
    props: ['isActive', 'stepId'],
    data() {
        return {
            ajaxCall: null,
            errors:''
        }
    },
    mounted() {
        $('#paySubmit').click(function () {
            if (typeof $('#CenposPlugin').submitAction == 'function') {
                $('#CenposPlugin').submitAction();
            } else {
                $('#cenpos-error-message').css('display', 'block');
            }
        });

    },
    methods: {
        setupPaymentSystem(customerNumber, verifyingPost, payment_url) {
            let params = {
                verifyingPost: verifyingPost,
                customerNumber: customerNumber,
                autologin: false,
                isCvv: true,
                email: this.$parent.checkout_payload.customer_email,
                amount: this.calculateTotal,
            }

            if (!this.$parent.isGuestUser) {
                params.isEmail = true;
            }

            params = new URLSearchParams(params).toString();

            $("#CenposPlugin").createWebpay({
                url: payment_url,
                params: params,
                width: '100%',
                height: '700',
                success: this.successCallback,
                cancel: this.CallbackCancel,
            });
        },
        successCallback(res) {
            if (!res.RecurringSaleTokenId || res.Result == '221') {
                this.errors = 'Decline transaction! Please,Try again!';
            }else{
                this.$parent.checkout_payload.credit_card_token = res.RecurringSaleTokenId??'000';
                this.$parent.submitOrder();
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
        fetchCenposTokenData () {
            getFullPageLoader();
            const self = this;
            if (self.ajaxCall) clearTimeout(self.ajaxCall);

            self.ajaxCall = setTimeout(function () {
                axios.post('/api/cenpos-token', {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    type: 'sale',
                    email: self.$parent.checkout_payload.customer_email,
                    amount: self.calculateTotal.toFixed(2),
                }).then(res => {
                    self.setupPaymentSystem(self.$parent.customerData.CustomerNumber, res.data,self.$parent.cenposInfo.payment_url);
                    removeFullPageLoader();
                })
            }, 10);
        }
    },
    computed:{
        ...mapState('checkout', ['methods']),
        calculateTotal(){
            let shippingAmount = this.selectedShippingMethod?.amount ?? 0;
            let taxAmount = this.methods.SalesTaxAmount ?? 0;
            return Number(this.$parent.cart.total) + Number(shippingAmount) + Number(taxAmount)
        },
        selectedShippingMethod() {
            return this.$parent.shippingMethod
        },
        activeStep() {
            return this.$parent.steps.find((step) => step.active);
        },
    },
    watch: {
        "activeStep": function() {
            const customerEmail = this.$parent.checkout_payload.customer_email;
            if ( customerEmail && customerEmail !== '' && this.activeStep.id === 'billing') {
                this.fetchCenposTokenData();
            }
        }

    },
}
</script>

<style scoped>
.my-popup-class {
    width: 300px;
    height: auto;
}
</style>
