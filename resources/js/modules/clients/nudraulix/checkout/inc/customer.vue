<template>
    <section
        class="checkout checkout-step"
        :class="[`checkout-${stepId}`, { active: isActive }]"
        :data-parent="`#${stepId}`"
    >
        <div class="card">
            <div class="card-header" role="tab">
                <h4>
                    <a data-toggle="collapse"><i class="icon-map mr-3"></i>Account Information</a>
                </h4>
            </div>
            <div class="row p-2">
<!--                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="ship-to-country">Addresses</label>
                        <multiselect
                            name="address"
                            id="ship-to-address"
                            v-model="address"
                            :options="this.$parent.filteredAddresses"
                            v-if="!$parent.isGuestUser"
                            @select="selectAddress"
                            placeholder="Select an Address"
                            required
                            label="name"
                            track-by="id"
                        >
                        </multiselect>
                        <div class="invalid-feedback"></div>
                    </div>
                </div>-->

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
                            :disabled="isPhoneDisabled"
                            @keypress="phoneKeyFilter"
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
                            :disabled="!$parent.isGuestUser && !!$parent.checkout_payload.customer_country"
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
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="shipping_phone">
                            PO Number
                            <span class="text-danger font-weight-bold">*</span>
                        </label>
                        <input
                            required
                            class="form-control"
                            type="text"
                            id="po_number"
                            name="po_number"
                            v-model="$parent.checkout_payload.po_number"
                            @keypress="poKeyFilter"
                        />
                        <span class="invalid-feedback"></span>
                    </div>
                </div>
                <div class="col-sm-12">
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

                <div class="col-sm-12">
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

                <div class="col-sm-12">
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

                <div class="col-sm-6">
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

                <div class="col-sm-6">
                    <div class="form-group" style="z-index: 99999">
                        <label for="customer_state">State <span class="text-danger font-weight-bold">*</span></label>
                        <multiselect
                            name="Country"
                            id="customer_state"
                            v-model="$parent.checkout_payload.customer_state"
                            :options="filteredStates"
                            :allow-empty="false"
                            :disabled="(!$parent.checkout_payload.customer_country || !$parent.isGuestUser) && !!$parent.checkout_payload.customer_state"
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
            </div>
        </div>

        <div class="my-4" v-if="! blockShippingAddressChange">
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
                <h4>
                    <a data-toggle="collapse"><i class="icon-map mr-3"></i>Shipping Address</a>
                </h4>
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
                            @keypress="digitsOnly"
                        />
                        <span class="invalid-feedback"></span>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="ship_to_country">Country<span class="text-danger font-weight-bold">*</span></label>
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
                            @keypress="lettersSpacesOnly"
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
                            @keypress="digitsOnly"
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
import { isNull } from 'lodash';

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
            address: null,
        };
    },
    components: { Multiselect },
    computed: {
        isPhoneDisabled() {
            if (this.$parent.isGuestUser) {
                return false;
            }

            const customerPhone = this.$parent.customerData.CustomerPhone;

            if (isNull(customerPhone)) {
                return false;
            }

            return customerPhone !== '';
        },
        blockShippingAddressChange() {
            return this.$parent.$props.shipping_customer_code === this.$parent.customerData.CustomerNumber;
        }
    },
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
        selectAddress(event) {
            this.$parent.changeShippingAddress(event.id)
        },
        digitsOnly(e) {
            const allowed =
                      /[0-9]/.test(e.key) ||
                      ['Backspace', 'Delete', 'ArrowLeft', 'ArrowRight', 'Tab'].includes(e.key);
            if (!allowed) e.preventDefault();
        },
        lettersSpacesOnly(e) {
            const allowed =
                      /^[A-Za-zÀ-ÖØ-öø-ÿ'.\-\s]$/.test(e.key) ||
                      ['Backspace', 'Delete', 'ArrowLeft', 'ArrowRight', 'Tab'].includes(e.key);
            if (!allowed) e.preventDefault();
        },
        phoneKeyFilter(e) {
            const allowed =
                      /[0-9+\-\s()]/.test(e.key) ||
                      ['Backspace', 'Delete', 'ArrowLeft', 'ArrowRight', 'Tab'].includes(e.key);
            if (!allowed) e.preventDefault();
        },
        poKeyFilter(e) {
            const isNav = ['Backspace', 'Delete', 'ArrowLeft', 'ArrowRight', 'Tab'].includes(e.key);
            if (isNav) return;

            // Always allow alphanumeric
            if (/^[A-Za-z0-9]$/.test(e.key)) return;

            // Optionally allow special chars defined in parent
            const allowSpecial = this.$parent.poNumberAllowSpecial === true;
            const allowedSet = (this.$parent.poNumberAllowedChars || '');
            if (allowSpecial && allowedSet.includes(e.key)) return;

            // Block everything else
            e.preventDefault();
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
