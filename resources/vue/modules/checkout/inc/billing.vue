<template>
    <section class="checkout checkout-step" :class="[`checkout-${stepId}`, { active: isActive }]" :data-parent="`#${stepId}`">
        <h4><i class="icon-paper"></i> Payment Method</h4>

        <div class="form-group">
            <label for="credit-card-token">Select or Add a Credit Card</label>
            <select class="form-control" name="credit_card_token" id="credit-card-token" @change="clearCardInfo" v-model="$parent.checkout_payload.credit_card_token">
                <option value="">Add a Credit Card</option>
                <option v-if="!$parent.isGuestUser" value="gjhgh">4222 **** **** ****</option>
            </select>
        </div>

        <div class="row" v-if="!$parent.checkout_payload.credit_card_token">
            <div class="col-12">
                <p>We accept following credit cards:&nbsp;
                    <img class="d-inline-block align-middle" src="/images/credit-cards.png" style="width: 120px;" alt="Credit Cards">
                </p>
                <div class="card-wrapper"></div>
                <div class="interactive-credit-card">
                    <div class="row">
                        <div class="form-group col-sm-12">
                            <input required minlength="15" class="form-control billing-info" type="text" name="number" placeholder="Card Number*" v-model="credit_card.number" />
                            <span class="invalid-feedback"></span>
                        </div>

                        <div class="form-group col-sm-6">
                            <input required class="form-control" type="text" name="expiry" placeholder="MM/YY*" v-model="credit_card.expiry" />
                            <span class="invalid-feedback"></span>
                        </div>

                        <div class="form-group col-sm-6">
                            <input required class="form-control" type="text" name="cvc" placeholder="CVC*" v-model="credit_card.cvc" />
                            <span class="invalid-feedback"></span>
                        </div>

                        <div class="form-group col-sm-12">
                            <input required class="form-control billing-info" type="text" name="name" placeholder="Full Name*" v-model="credit_card.name" />
                            <span class="invalid-feedback"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <h4 class="margin-top-1x"><i class="icon-map"></i> Billing Address</h4>
        <hr class="padding-bottom-1x">
        <div class="form-group">
            <label for="billing-checkout-address">Billing Address</label>
            <select required class="form-control" name="billing_address" id="billing-checkout-address" v-model="$parent.checkout_payload.billing_address">
                <option value="same-as-shipping">Same As Shipping Address</option>
                <option
                    v-for="(address, index) in $parent.addresses"
                    v-if="address.ShipToNumber != 'TEMP'"
                    :key="index"
                    :value="address.ShipToNumber"
                >{{ address.ShipToName }}</option>
                <option value="other-address">Other Billing Address</option>
            </select>
        </div>

        <div class="row" v-show="$parent.checkout_payload.billing_address == 'other-address'">
            <div class="col-sm-12">
                <div class="form-group">
                    <label for="bill-to-address1">Address <span class="text-danger font-weight-bold">*</span></label>
                    <input class="form-control my-1 billing-info" placeholder="Address Line 1" type="text" name="address-1" id="bill-to-address1" required v-model="$parent.checkout_payload.billing_address1"/>
                    <input class="form-control my-1 billing-info" placeholder="Address Line 2" type="text" id="bill-to-address2" v-model="$parent.checkout_payload.billing_address2"/>
                    <input class="form-control my-1 billing-info" placeholder="Address Line 3" type="text" id="bill-to-address3" v-model="$parent.checkout_payload.billing_address3"/>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="form-group">
                    <label for="ship-to-country">Country <span class="text-danger font-weight-bold">*</span></label>
                    <multiselect
                        name="country"
                        id="ship-to-country"
                        v-model="$parent.checkout_payload.billing_country"
                        :options="$parent.countries"
                        :allow-empty="false"
                        placeholder="Select an Country"
                        label="name"
                        track-by="id"
                    ></multiselect>
                    <div class="invalid-feedback"></div>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="form-group">
                    <label for="ship-to-state">State <span class="text-danger font-weight-bold">*</span></label>
                    <multiselect
                        name="state"
                        id="ship-to-state"
                        v-model="$parent.checkout_payload.billing_state"
                        :options="states"
                        :allow-empty="false"
                        placeholder="Select an State"
                        label="name"
                        track-by="iso2"
                    ></multiselect>
                    <div class="invalid-feedback"></div>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="form-group">
                    <label for="bill-to-city">City <span class="text-danger font-weight-bold">*</span></label>
                    <input required class="form-control billing-info" name="billing_city" type="text" id="bill-to-city" v-model="$parent.checkout_payload.billing_city"/>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="form-group">
                    <label for="bill-to-zip-code">ZIP Code <span class="text-danger font-weight-bold">*</span></label>
                    <input required class="form-control billing-info" name="billing_zip_code" type="text" id="bill-to-zip-code" v-model="$parent.checkout_payload.billing_zip_code"/>
                </div>
            </div>
        </div>
    </section>

</template>

<script>
    import Multiselect from "vue-multiselect";

    export default {
        name: "Billing",
        props: ['isActive', 'stepId'],
        components: { Multiselect },
        data() {
            return {
                credit_card: {
                    name: "",
                    number: "",
                    expiry: "",
                    cvc: "",
                }
            }
        },
        computed: {
            states() {
                if (this.$parent.checkout_payload.billing_country) {
                    return this.$parent.states.filter(item => item.country_id == this.$parent.checkout_payload.billing_country.id)
                }
                return [];
            }
        },
        mounted() {
            this.setupCard();
        },
        updated() {
            this.setupCard();
        },
        methods: {
            setupCard() {
                let $creditCard = $('.interactive-credit-card');
                if ($creditCard.length) {
                    $creditCard.card({
                        form: '.interactive-credit-card',
                        container: '.card-wrapper'
                    });
                }
            },
            clearCardInfo() {
                this.credit_card.name   = "";
                this.credit_card.number = "";
                this.credit_card.expiry = "";
                this.credit_card.cvc    = "";
            }
        }
    }
</script>
