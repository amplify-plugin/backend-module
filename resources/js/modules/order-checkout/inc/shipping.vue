<template>
    <section class="checkout checkout-step" :class="[`checkout-${stepId}`, { active: isActive }]" :data-parent="`#${stepId}`">
        <h4><i class="icon-bag"></i> Shipping Method</h4>
        <hr class="padding-bottom-1x">
        <div class="form-group">
            <label for="shipping-checkout-option">Ship Method <span class="text-danger font-weight-bold">*</span></label>
            <select required class="form-control" name="shipping_option" id="shipping-checkout-option" v-model="$parent.checkout_payload.shipping_option" disabled>
                <option value="">Select an Option</option>
                <option
                    v-for="(option, index) in $parent.shipOptions"
                    :key="index"
                    :value="option.CarrierCode"
                >{{ option.CarrierDescription }}</option>
            </select>
            <div class="invalid-feedback"></div>
            <small v-if="$parent.validationErrors.shipping_method" class="text-danger mt-3">{{ $parent.validationErrors.shipping_method[0] }}</small>
        </div>

        <h4 class="margin-top-1x">
            <i class="icon-map"></i> Shipping Address
        </h4>
        <hr class="padding-bottom-1x">

        <div class="form-group">
            <label for="shipping-checkout-address">Address Name <span class="text-danger font-weight-bold">*</span></label>
            <select required class="form-control" id="shipping-checkout-address" name="shipping_address" @change="$parent.orderRuleStatus = null" v-model="$parent.checkout_payload.shipping_address" disabled>
                <option value="">Select an Address</option>
                <option
                    v-for="(address, index) in $parent.addresses"
                    :key="index"
                    :value="address.ShipToNumber"
                >{{ address.ShipToName }}</option>
            </select>
            <div class="invalid-feedback"></div>
            <small v-if="$parent.validationErrors.shipping_number" class="text-danger mt-3">{{ $parent.validationErrors.shipping_number[0] }}</small>
        </div>

        <div class="row" v-show="$parent.checkout_payload.shipping_address == 'TEMP'">
            <div class="col-sm-12">
                <div class="form-group">
                    <label for="ship-to-address1">Address <span class="text-danger font-weight-bold">*</span></label>
                    <input required class="form-control my-1 shipping-info" placeholder="Address Line 1" type="text" id="ship-to-address1" name="address-1"  v-model="$parent.checkout_payload.ship_to_address1" disabled/>
                    <div class="invalid-feedback"></div>
                    <input class="form-control my-1 shipping-info" placeholder="Address Line 2" type="text" id="ship-to-address2" v-model="$parent.checkout_payload.ship_to_address2" disabled/>
                    <input class="form-control my-1 shipping-info" placeholder="Address Line 3" type="text" id="ship-to-address3" v-model="$parent.checkout_payload.ship_to_address3" disabled/>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="form-group">
                    <label for="ship-to-country">Country <span class="text-danger font-weight-bold">*</span></label>
                    <select required class="form-control shipping-info" name="country" type="text" id="ship-to-country" v-model="$parent.checkout_payload.ship_to_country" disabled>
                        <option value="">Select an Country</option>
                        <option
                            v-for="(country, index) in $parent.countries"
                            :key="index"
                            :value="country.iso2"
                        >{{ country.name }}</option>
                    </select>
                    <div class="invalid-feedback"></div>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="form-group">
                    <label for="ship-to-state">State <span class="text-danger font-weight-bold">*</span></label>
                    <select required class="form-control shipping-info" name="state" type="text" id="ship-to-state" v-model="$parent.checkout_payload.ship_to_state" disabled>
                        <option value="">Select an State</option>
                        <option
                            v-for="(state, index) in $parent.states"
                            :key="index"
                            :value="state.iso2"
                        >{{ state.name }}</option>
                    </select>
                    <div class="invalid-feedback"></div>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="form-group">
                    <label for="ship-to-city">City <span class="text-danger font-weight-bold">*</span></label>
                    <input required class="form-control shipping-info" name="city" type="text" id="ship-to-city" v-model="$parent.checkout_payload.ship_to_city" disabled/>
                    <div class="invalid-feedback"></div>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="form-group">
                    <label for="ship-to-zip-code">ZIP Code <span class="text-danger font-weight-bold">*</span></label>
                    <input required class="form-control shipping-info" name="zip_code" type="text" id="ship-to-zip-code" v-model="$parent.checkout_payload.ship_to_zip_code" disabled/>
                    <div class="invalid-feedback"></div>
                </div>
            </div>

        </div>
    </section>
</template>

<script>
    export default {
        name: "Shipping",
        props: ['isActive', 'stepId'],
    }
</script>
