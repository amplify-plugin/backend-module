<template>
    <section
        class="checkout checkout-step"
        :class="[`checkout-${stepId}`, { active: isActive }]"
        :data-parent="`#${stepId}`"
    >
        <div class="card mb-4">
            <div class="card-header" role="tab">
                <h4>
                    <a data-toggle="collapse"><i class="icon-map mr-3"></i>Account Information</a>
                </h4>
            </div>
            <div class="row p-2">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="customer_name"
                            >Customer Name <span class="text-danger font-weight-bold">*</span></label
                        >
                        <input
                            required
                            class="form-control"
                            type="text"
                            id="customer_name"
                            name="customer_name"
                            v-model="$parent.checkout_payload.customer_name"
                            :disabled="!$parent.isGuestUser"
                        />
                        <span class="invalid-feedback"></span>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="customer_email"
                            >E-mail Address <span class="text-danger font-weight-bold">*</span></label
                        >
                        <input
                            required
                            class="form-control"
                            type="email"
                            id="customer_email"
                            name="customer_email"
                            v-model="$parent.checkout_payload.customer_email"
                            :disabled="!$parent.isGuestUser"
                        />
                        <span class="invalid-feedback"></span>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="customer_phone"
                            >Phone Number <span class="text-danger font-weight-bold">*</span></label
                        >
                        <input
                            required
                            class="form-control"
                            type="text"
                            id="customer_phone"
                            name="customer_phone"
                            v-model="$parent.checkout_payload.customer_phone"
                        />
                        <span class="invalid-feedback"></span>
                    </div>
                </div>

            </div>
        </div>

        <div class="card">
            <div class="card-header" role="tab">
                <h4>
                    <a data-toggle="collapse"><i class="icon-map mr-3"></i>Shipping Address</a>
                </h4>
            </div>
            <div class="row p-2">
                <div class="col-sm-12" v-if="!$parent.isGuestUser">
                    <div class="form-group">
                        <label for="shipping_address_select">Select Shipping Address</label>
                        <multiselect
                            id="shipping_address_select"
                            v-model="selectedShippingAddress"
                            :options="$parent.addresses"
                            :custom-label="shippingLabel"
                            placeholder="Choose a saved shipping address"
                            label="ShipToNumber"
                            track-by="ShipToNumber"
                            @input="applyShippingAddress"
                        />
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="shipping_name"
                            >Shipping Name <span class="text-danger font-weight-bold">*</span></label
                        >
                        <input
                            required
                            class="form-control"
                            type="text"
                            id="shipping_name"
                            name="shipping_name"
                            v-model="$parent.shipping_checkout.shipping_name"
                            :disabled="!$parent.isGuestUser"
                        />
                        <span class="invalid-feedback"></span>
                    </div>
                </div>

                <div class="col-sm-12">
                    <div class="form-group">
                        <label for="ship_to_address1">Address<span class="text-danger font-weight-bold">*</span></label>
                        <input
                            required
                            class="form-control"
                            type="text"
                            id="ship_to_address1"
                            name="ship_to_address1"
                            v-model="$parent.shipping_checkout.ship_to_address1"
                            :disabled="!$parent.isGuestUser"
                        />
                        <span class="invalid-feedback"></span>
                    </div>
                </div>

                <div class="col-sm-12">
                    <div class="form-group">
                        <input
                            class="form-control"
                            type="text"
                            id="customer_address_two"
                            name="customer_address_two"
                            v-model="$parent.shipping_checkout.ship_to_address2"
                            :disabled="!$parent.isGuestUser"
                        />
                        <span class="invalid-feedback"></span>
                    </div>
                </div>

                <div class="col-sm-12">
                    <div class="form-group">
                        <input
                            class="form-control"
                            type="text"
                            id="ship_to_address_three"
                            name="ship_to_address_three"
                            v-model="$parent.shipping_checkout.ship_to_address3"
                            :disabled="!$parent.isGuestUser"
                        />
                        <span class="invalid-feedback"></span>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="ship_to_city">City <span class="text-danger font-weight-bold">*</span></label>
                        <input
                            required
                            class="form-control"
                            type="text"
                            id="ship_to_city"
                            name="ship_to_city"
                            v-model="$parent.shipping_checkout.ship_to_city"
                            :disabled="!$parent.isGuestUser"
                        />
                        <span class="invalid-feedback"></span>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="ship_to_state">State <span class="text-danger font-weight-bold">*</span></label>
                        <multiselect
                            name="Country"
                            id="ship_to_state"
                            v-model="$parent.shipping_checkout.ship_to_state"
                            :options="filteredStates"
                            :allow-empty="false"
                            placeholder="Select an State"
                            label="name"
                            @search-change="searchState"
                            :disabled="!$parent.isGuestUser"
                        >
                        </multiselect>

                        <span class="invalid-feedback"></span>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="ship_to_zip_code"
                            >Zip Code <span class="text-danger font-weight-bold">*</span></label
                        >
                        <input
                            required
                            class="form-control"
                            type="text"
                            id="ship_to_zip_code"
                            name="ship_to_zip_code"
                            v-model="$parent.shipping_checkout.ship_to_zip_code"
                            :disabled="!$parent.isGuestUser"
                        />
                        <span class="invalid-feedback"></span>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="ship_to_country">Country <span class="text-danger font-weight-bold">*</span></label>
                        <multiselect
                            name="Country"
                            id="ship-to-country"
                            v-model="$parent.shipping_checkout.ship_to_country"
                            :options="this.$parent.countries"
                            :allow-empty="false"
                            @select="selectShippingCountry"
                            placeholder="Select an Country"
                            label="name"
                            :disabled="!$parent.isGuestUser"
                        >
                        </multiselect>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="shipping_phone"
                            >Phone Number <span class="text-danger font-weight-bold">*</span></label
                        >
                        <input
                            required
                            class="form-control"
                            type="text"
                            id="shipping_phone"
                            name="shipping_phone"
                            v-model="$parent.shipping_checkout.shipping_phone"
                            :disabled="!$parent.isGuestUser"
                        />
                        <span class="invalid-feedback"></span>
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
import Multiselect from 'vue-multiselect';

export default {
    name: 'Customer',
    props: ['isActive', 'stepId'],
    data() {
        return {
            countries: [],
            testValue: '',
            states: [],
            shipping_states: this.$parent.states,
            filteredStates: [],
            selectedShippingAddress: null
        };
    },
    components: { Multiselect },
    mounted() {
        let countryCode = this.$parent.customerData.CustomerCountry ?? this.$parent.defaultCountryCode;
        this.selectCountry({ iso2: countryCode });
        this.selectShippingCountry({ iso2: countryCode });

        const defaultShipTo = this.$parent.customerData.DefaultShipTo;
        const defaultAddress = this.$parent.addresses.find(
           addr => String(addr.ShipToNumber).trim() === String(defaultShipTo).trim()
        );

        if (defaultAddress) {
            this.selectedShippingAddress = defaultAddress;
            this.applyShippingAddress(defaultAddress);
        }
    },
    methods: {
        selectCountry(event) {
            this.$parent.checkout_payload.customer_state = '';
            let items = this.$parent.states.filter((item) => item.country_code === event.iso2);
            this.filteredStates = this.states = items;
        },
        selectShippingCountry(event) {
            this.$parent.shipping_checkout.ship_to_state = '';
            let items = this.$parent.states.filter((item) => item.country_code === event.iso2);
            this.filteredStates = this.shipping_states = items;
        },
        searchState(query, name) {
            this.filteredStates = this[name === 'ship_to_state' ? 'shipping_states' : 'states'].filter((state) => {
                const escapedSubstr = query.toLowerCase().replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
                const pattern = new RegExp('^' + escapedSubstr);
                return pattern.test(state.name.toLowerCase());
            });
        },
        shippingLabel(option) {
            return `${option.ShipToName}, ${option.ShipToAddress1}, ${option.ShipToCity}, ${option.ShipToState}`;
        },
        applyShippingAddress(selected) {
            const a = selected;

            this.$parent.shipping_checkout = {
                shipping_phone: a.ShipToPhoneNumber,
                ship_to_address1: a.ShipToAddress1,
                ship_to_address2: a.ShipToAddress2,
                ship_to_address3: a.ShipToAddress3,
                ship_to_country: this.$parent.countries.find(c => c.iso2.toLowerCase() === a.ShipToCountryCode.toLowerCase()),
                ship_to_state: this.$parent.states.find(s => s.iso2 === a.ShipToState),
                ship_to_city: a.ShipToCity,
                ship_to_zip_code: a.ShipToZipCode,
                shipping_name: a.ShipToName,
                ship_to_carrier_code: a.CarrierCode,
                ship_to_wharehouse: a.ShipToWarehouse
            };
        },
    },
};
</script>
<style scoped>
@media (min-width: 320px) and (max-width: 767px) {
    .choose_shipping {
        padding-left: 2rem;
    }
}
</style>
