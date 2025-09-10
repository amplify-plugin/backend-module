<template>
    <section
        class="checkout checkout-step"
        :class="[`checkout-${stepId}`, { active: isActive }]"
        :data-parent="`#${stepId}`"
    >
        <h4><i class="icon-paper"></i> Payment Method</h4>

        <div class="form-group">
            <label for="credit-card-token">Select or Add a Credit Card</label>
            <select
                class="form-control"
                name="credit_card_token"
                id="credit-card-token"
                v-model="$parent.checkout_payload.credit_card_token"
            >
                <option value="">Add a Credit Card</option>
            </select>
        </div>

        <div class="row" v-if="!$parent.checkout_payload.credit_card_token">
            <div class="col-12">
                <p>
                    We accept following credit cards:&nbsp;
                    <img
                        class="d-inline-block align-middle"
                        src="/images/credit-cards.png"
                        style="width: 120px"
                        alt="Credit Cards"
                    />
                </p>
                <div class="card-wrapper"></div>
                <div class="interactive-credit-card">
                    <div class="row">
                        <div class="form-group col-sm-12">
                            <input
                                class="form-control billing-info"
                                type="text"
                                name="number"
                                placeholder="Card Number*"
                            />
                            <span class="invalid-feedback"></span>
                        </div>

                        <div class="form-group col-sm-6">
                            <input class="form-control" type="text" name="expiry" placeholder="MM/YY*" />
                            <span class="invalid-feedback"></span>
                        </div>

                        <div class="form-group col-sm-6">
                            <input class="form-control" type="text" name="cvc" placeholder="CVC*" />
                            <span class="invalid-feedback"></span>
                        </div>

                        <div class="form-group col-sm-12">
                            <input class="form-control billing-info" type="text" name="name" placeholder="Full Name*" />
                            <span class="invalid-feedback"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <h4 class="margin-top-1x"><i class="icon-map"></i> Billing Address</h4>
        <hr class="padding-bottom-1x" />
        <div class="form-group">
            <label for="billing-checkout-address">Billing Address</label>
            <select
                class="form-control"
                name="billing_address"
                id="billing-checkout-address"
                v-model="$parent.checkout_payload.billing_address"
            >
                <option value="same-as-shipping">Same As Shipping Address</option>
                <option
                    v-for="(address, index) in $parent.addresses"
                    v-if="address.ShipToNumber !== 'TEMP'"
                    :key="index"
                    :value="address.ShipToNumber"
                >
                    {{ address.ShipToName }}
                </option>
                <option value="other-address">Other Billing Address</option>
            </select>
        </div>

        <div class="row" v-show="$parent.checkout_payload.billing_address === 'other-address'">
            <div class="col-sm-12">
                <div class="form-group">
                    <label for="bill-to-address1">Address <span class="text-danger font-weight-bold">*</span></label>
                    <input
                        class="form-control my-1 billing-info"
                        placeholder="Address Line 1"
                        type="text"
                        id="bill-to-address1"
                        v-model="$parent.checkout_payload.billing_address1"
                    />
                    <input
                        class="form-control my-1 billing-info"
                        placeholder="Address Line 2"
                        type="text"
                        id="bill-to-address2"
                        v-model="$parent.checkout_payload.billing_address2"
                    />
                    <input
                        class="form-control my-1 billing-info"
                        placeholder="Address Line 3"
                        type="text"
                        id="bill-to-address3"
                        v-model="$parent.checkout_payload.billing_address3"
                    />
                </div>
            </div>

            <div class="col-sm-6">
                <div class="form-group">
                    <label for="bill-to-state">State <span class="text-danger font-weight-bold">*</span></label>
                    <select
                        class="form-control billing-info"
                        name="billing_state"
                        type="text"
                        id="bill-to-state"
                        v-model="$parent.checkout_payload.billing_state"
                    >
                        <option value="">Select an State</option>
                        <option v-for="(stateName, stateCode) in $parent.states" :key="stateCode" :value="stateCode">
                            {{ stateCode + '-' + stateName }}
                        </option>
                    </select>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="form-group">
                    <label for="bill-to-city">City <span class="text-danger font-weight-bold">*</span></label>
                    <input
                        class="form-control billing-info"
                        name="billing_city"
                        type="text"
                        id="bill-to-city"
                        v-model="$parent.checkout_payload.billing_city"
                    />
                </div>
            </div>

            <div class="col-sm-6">
                <div class="form-group">
                    <label for="bill-to-zip-code">ZIP Code <span class="text-danger font-weight-bold">*</span></label>
                    <input
                        class="form-control billing-info"
                        name="billing_zip_code"
                        type="text"
                        id="bill-to-zip-code"
                        v-model="$parent.checkout_payload.billing_zip_code"
                    />
                </div>
            </div>
        </div>
    </section>
</template>

<script>
export default {
    name: 'Billing',
    props: ['isActive', 'stepId'],
};
</script>
