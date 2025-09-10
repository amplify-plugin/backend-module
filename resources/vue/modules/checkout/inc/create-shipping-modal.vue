<template>
    <div class="modal fade" id="add-address" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Create New Address</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="ship-to-name">Name </label>
                                <input class="form-control shipping-info" name="shipping_name" type="text" id="ship-to-name" v-model="shipping_payload.shipping_name"/>
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="ship-to-number">Shipping Number </label>
                                <input class="form-control shipping-info" name="shipping_number" type="text" id="ship-to-number" v-model="shipping_payload.shipping_number"/>
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="ship-to-address1">Address <span class="text-danger font-weight-bold">*</span></label>
                                <input class="form-control my-1 shipping-info" placeholder="Address Line 1" type="text" id="ship-to-address1" v-model="shipping_payload.ship_to_address1"/>
                                <input class="form-control my-1 shipping-info" placeholder="Address Line 2" type="text" id="ship-to-address2" v-model="shipping_payload.ship_to_address2"/>
                                <small v-if="validationErrors.shipping_address1" class="text-danger mt-3">{{ validationErrors.shipping_address1[0] }}</small>
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="ship-to-contact1">Contact </label>
                                <input class="form-control my-1 shipping-info" placeholder="Contact 1" type="text" id="ship-to-contact1" v-model="shipping_payload.ship_to_contact1"/>
                                <input class="form-control my-1 shipping-info" placeholder="Contact 2" type="text" id="ship-to-contact2" v-model="shipping_payload.ship_to_contact2"/>
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="ship-to-phone1">Phone <span class="text-danger font-weight-bold">*</span></label>
                                <input class="form-control my-1 shipping-info" placeholder="Phone 1" type="text" id="ship-to-phone1" v-model="shipping_payload.ship_to_phone1"/>
                                <input class="form-control my-1 shipping-info" placeholder="Phone 2" type="text" id="ship-to-contact2" v-model="shipping_payload.ship_to_phone2"/>
                                <small v-if="validationErrors.shipping_phone1" class="text-danger mt-3">{{ validationErrors.shipping_phone1[0] }}</small>
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="ship-to-email1">Email <span class="text-danger font-weight-bold">*</span></label>
                                <input class="form-control my-1 shipping-info" placeholder="Email 1" type="text" id="ship-to-email1" v-model="shipping_payload.ship_to_email1"/>
                                <input class="form-control my-1 shipping-info" placeholder="Email 2" type="text" id="ship-to-contact2" v-model="shipping_payload.ship_to_email2"/>
                                <small v-if="validationErrors.shipping_email1" class="text-danger mt-3">{{ validationErrors.shipping_email1[0] }}</small>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="ship-to-country">Country <span class="text-danger font-weight-bold">*</span></label>
                                <multiselect
                                    name="country"
                                    id="ship-to-country"
                                    v-model="shipping_payload.ship_to_country"
                                    :options="$parent.$parent.countries"
                                    :allow-empty="false"
                                    placeholder="Select an Country"
                                    label="name"
                                    track-by="id"
                                ></multiselect>
                                <small v-if="validationErrors.shipping_country" class="text-danger mt-3">{{ validationErrors.shipping_country[0] }}</small>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="ship-to-state">State <span class="text-danger font-weight-bold">*</span></label>
                                <multiselect
                                    name="state"
                                    id="ship-to-state"
                                    v-model="shipping_payload.ship_to_state"
                                    :options="states"
                                    :allow-empty="false"
                                    placeholder="Select an State"
                                    label="name"
                                    track-by="iso2"
                                ></multiselect>
                                <small v-if="validationErrors.shipping_state" class="text-danger mt-3">{{ validationErrors.shipping_state[0] }}</small>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="ship-to-city">City <span class="text-danger font-weight-bold">*</span></label>
                                <input class="form-control shipping-info" name="city" type="text" id="ship-to-city" v-model="shipping_payload.ship_to_city"/>
                                <small v-if="validationErrors.shipping_city" class="text-danger mt-3">{{ validationErrors.shipping_city[0] }}</small>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="ship-to-zip-code">ZIP Code <span class="text-danger font-weight-bold">*</span></label>
                                <input class="form-control shipping-info" name="zip_code" type="text" id="ship-to-zip-code" v-model="shipping_payload.ship_to_zip_code"/>
                                <small v-if="validationErrors.shipping_zip" class="text-danger mt-3">{{ validationErrors.shipping_zip[0] }}</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" :disabled="loading" @click="createShippingAddress">Create</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Multiselect from "vue-multiselect";

    export default {
        name: "CreateShipping",
        components: { Multiselect },
        data() {
            return {
                loading: false,
                validationErrors: {},
                shipping_payload: {
                    shipping_name: "",
                    shipping_number: "",
                    ship_to_address1: "",
                    ship_to_address2: "",
                    ship_to_contact1: "",
                    ship_to_contact2: "",
                    ship_to_phone1: "",
                    ship_to_phone2: "",
                    ship_to_email1: "",
                    ship_to_email2: "",
                    ship_to_city: "",
                    ship_to_state: "",
                    ship_to_zip_code: "",
                    ship_to_country: "",
                }
            }
        },
        computed: {
            states() {
                if (this.shipping_payload.ship_to_country) {
                    return this.$parent.$parent.states.filter(item => item.country_id == this.shipping_payload.ship_to_country.id)
                }
                return [];
            }
        },
        mounted() {
            this.shipping_payload.ship_to_country = this.$parent.$parent.countries.length === 1? this.$parent.$parent.countries[0] : null;
        },
        methods: {
            createShippingAddress() {
                getFullPageLoader();
                this.loading = true;
                this.validationErrors = {};

                axios.post('/shipping-address/create', {
                    shipping_number: this.shipping_payload.shipping_number,
                    shipping_name: this.shipping_payload.shipping_name,
                    shipping_address1: this.shipping_payload.ship_to_address1,
                    shipping_address2: this.shipping_payload.ship_to_address2,
                    shipping_contact1: this.shipping_payload.ship_to_contact1,
                    shipping_contact2: this.shipping_payload.ship_to_contact2,
                    shipping_phone1: this.shipping_payload.ship_to_phone1,
                    shipping_phone2: this.shipping_payload.ship_to_phone2,
                    shipping_email1: this.shipping_payload.ship_to_email1,
                    shipping_email2: this.shipping_payload.ship_to_email2,
                    shipping_country: this.shipping_payload.ship_to_country?.name,
                    shipping_state: this.shipping_payload.ship_to_state?.name,
                    shipping_city: this.shipping_payload.ship_to_city,
                    shipping_zip: this.shipping_payload.ship_to_zip_code
                }).then(res => {
                    this.loading = false;
                    this.$parent.$parent.addresses.push(res.data);
                    this.$parent.$parent.checkout_payload.shipping_address = res.data.ShipToNumber;

                    $('#add-address').modal('hide');
                    this.resetShippingFields();

                    ShowNotification('success', 'Address', "Successfully created.");
                    removeFullPageLoader();
                }).catch(error => {

                    this.loading = false;
                    this.validationErrors = error.response.data.errors ?? error.response.data.message;
                    ShowNotification('error', 'Address', error.response.data.message);
                    removeFullPageLoader();
                });
            },
            resetShippingFields() {
                this.shipping_payload.shipping_number = "";
                this.shipping_payload.shipping_name = "";
                this.shipping_payload.ship_to_address1 = "";
                this.shipping_payload.ship_to_address2 = "";
                this.shipping_payload.ship_to_contact1 = "";
                this.shipping_payload.ship_to_contact2 = "";
                this.shipping_payload.ship_to_phone1 = "";
                this.shipping_payload.ship_to_phone2 = "";
                this.shipping_payload.ship_to_email1 = "";
                this.shipping_payload.ship_to_email2 = "";
                this.shipping_payload.ship_to_city = "";
                this.shipping_payload.ship_to_state = "";
                this.shipping_payload.ship_to_zip_code = "";
            }
        }
    }
</script>
