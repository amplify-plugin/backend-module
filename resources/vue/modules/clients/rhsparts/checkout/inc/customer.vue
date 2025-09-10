<template>
    <section
        class="checkout checkout-step"
        :class="[`checkout-${stepId}`, { active: isActive }]"
        :data-parent="`#${stepId}`"
    >
        <div class="card">
            <div class="card-header" role="tab">
                <h6>
                    <a data-toggle="collapse"><i class="icon-map"></i>Account Information</a>
                </h6>
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
                            :disabled="!$parent.isGuestUser"
                        />
                        <span class="invalid-feedback"></span>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="ship-to-country">Country <span class="text-danger font-weight-bold">*</span></label>
                        <multiselect
                            name="Country"
                            id="ship-to-country"
                            v-model="$parent.checkout_payload.customer_country"
                            :options="this.$parent.countries"
                            :allow-empty="false"
                            :disabled="!$parent.isGuestUser"
                            @select="selectCountry"
                            placeholder="Select an Country"
                            required
                            label="name"
                            track-by="id"
                        >
                        </multiselect>
                        <div class="invalid-feedback"></div>
                    </div>
                </div>

                <div class="col-12 col-sm-6">
                    <div class="">
                        <div class="form-group">
                            <label for="customer_address_one"
                                >Address <span class="text-danger font-weight-bold">*</span></label
                            >
                            <input
                                required
                                class="form-control"
                                type="text"
                                id="customer_address_one"
                                name="customer_address_one"
                                v-model="$parent.checkout_payload.customer_address_one"
                                :disabled="!$parent.isGuestUser"
                            />
                            <span class="invalid-feedback"></span>
                        </div>
                    </div>

                    <div class="">
                        <div class="form-group">
                            <input
                                class="form-control"
                                type="text"
                                id="customer_address_two"
                                name="customer_address_two"
                                v-model="$parent.checkout_payload.customer_address_two"
                                :disabled="!$parent.isGuestUser"
                            />
                            <span class="invalid-feedback"></span>
                        </div>
                    </div>

                    <div class="">
                        <div class="form-group">
                            <input
                                class="form-control"
                                type="text"
                                id="customer_address_three"
                                name="customer_address_three"
                                v-model="$parent.checkout_payload.customer_address_three"
                                :disabled="!$parent.isGuestUser"
                            />
                            <span class="invalid-feedback"></span>
                        </div>
                    </div>

                    <div class="">
                        <div class="form-group">
                            <label for="customer_city">City<span class="text-danger font-weight-bold">*</span></label>
                            <input
                                required
                                class="form-control"
                                type="text"
                                id="customer_city"
                                name="customer_city"
                                v-model="$parent.checkout_payload.customer_city"
                                :disabled="!$parent.isGuestUser"
                            />
                            <span class="invalid-feedback"></span>
                        </div>
                    </div>

                    <div class="">
                        <div class="form-group">
                            <label for="customer_zip_code"
                                >Zip Code <span class="text-danger font-weight-bold">*</span></label
                            >
                            <input
                                required
                                class="form-control"
                                type="text"
                                id="customer_zip_code"
                                name="customer_zip_code"
                                v-model="$parent.checkout_payload.customer_zip_code"
                                :disabled="!$parent.isGuestUser"
                            />
                            <span class="invalid-feedback"></span>
                        </div>
                    </div>

                    <div class="">
                        <div class="form-group" style="z-index: 99999">
                            <label for="customer_state"
                                >State <span class="text-danger font-weight-bold">*</span></label
                            >
                            <multiselect
                                name="Country"
                                id="customer_state"
                                v-model="$parent.checkout_payload.customer_state"
                                :options="filteredStates"
                                :allow-empty="false"
                                :disabled="!$parent.checkout_payload.customer_country || !$parent.isGuestUser"
                                placeholder="Select an State"
                                label="name"
                                @search-change="searchState"
                            >
                            </multiselect>
                            <span class="invalid-feedback"></span>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 mt-4">
                    <div class="border p-3">
                        <p>
                            <input
                                type="radio"
                                id="ship_complete"
                                name="shipping_option"
                                v-model="$parent.shipping_option"
                                value="27"
                            />
                            <label for="ship_complete">Ship Complete</label>
                        </p>
                        <p>
                            <input
                                type="radio"
                                id="ship_partial"
                                name="shipping_option"
                                v-model="$parent.shipping_option"
                                value="28"
                            />
                            <label for="ship_partial">Ship Partial</label>
                        </p>
                        <p>
                            <input
                                type="radio"
                                id="backorder_ok"
                                name="shipping_option"
                                v-model="$parent.shipping_option"
                                value="26"
                            />
                            <label for="backorder_ok">Backorder Ok</label>
                        </p>
                        <p>
                            <input
                                type="radio"
                                id="price_packing_slips"
                                name="shipping_option"
                                v-model="$parent.shipping_option"
                                value="20"
                            />
                            <label for="price_packing_slips">Price Packing Slips</label>
                        </p>
                        <p>
                            <input
                                type="radio"
                                id="ship_blind"
                                name="shipping_option"
                                v-model="$parent.shipping_option"
                                value="blind"
                            />
                            <label for="ship_blind">Ship Blind</label>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="my-4">
            <div class="form-check choose_shipping">
                <input
                    class="form-check-input"
                    v-model="$parent.checkout_payload.chooseShipping"
                    type="checkbox"
                    value=""
                    id="defaultCheck1"
                />
                <label class="form-check-label" for="defaultCheck1"> Choose another shipping address </label>
            </div>
        </div>

        <div class="card" v-if="$parent.checkout_payload.chooseShipping">
            <div class="card-header" role="tab">
                <h6>
                    <a data-toggle="collapse"><i class="icon-map"></i>Shipping Address</a>
                </h6>
            </div>
            <div class="row p-2">
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
                        >
                        </multiselect>
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
                        />
                        <span class="invalid-feedback"></span>
                    </div>
                </div>
            </div>
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
        };
    },
    components: { Multiselect },
    mounted() {
        let countryCode = this.$parent.customerData.CustomerCountry ?? this.$parent.defaultCountryCode;
        this.selectCountry({ iso2: countryCode });
        this.selectShippingCountry({ iso2: countryCode });
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
