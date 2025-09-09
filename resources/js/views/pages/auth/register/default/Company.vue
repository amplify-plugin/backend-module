<template>
    <div>
        <div class="form-group">
            <label for="customer_name">Customer Name <span class="text-danger">*</span></label>
            <input
                class="form-control"
                :class="{ 'is-invalid': $parent.validationErrors.hasOwnProperty('customer_name') }"
                type="text"
                v-model="$parent.form.customer_name"
            />

            <p class="text-danger d-block" v-if="$parent.validationErrors.hasOwnProperty('customer_name')">
                {{ $parent.validationErrors.customer_name[0] ?? '' }}
            </p>
        </div>

        <div class="form-group">
            <label for="email">Email Address <span class="text-danger">*</span></label>
            <input
                :class="{ 'is-invalid': $parent.validationErrors.hasOwnProperty('email') }"
                class="form-control"
                type="email"
                v-model="$parent.form.email"
            />

            <p class="text-danger d-block" v-if="$parent.validationErrors.hasOwnProperty('email')">
                {{ $parent.validationErrors.email[0] ?? '' }}
            </p>
        </div>

        <div class="form-group">
            <label for="phone">Phone Number<span class="text-danger">*</span></label>
            <input
                :class="{ 'is-invalid': $parent.validationErrors.hasOwnProperty('phone') }"
                class="form-control"
                type="text"
                v-model="$parent.form.phone"
            />

            <p class="text-danger d-block" v-if="$parent.validationErrors.hasOwnProperty('phone')">
                {{ $parent.validationErrors.phone[0] ?? '' }}
            </p>
        </div>

        <div v-if="this.$parent.amplify_client_code === 'ACT'" class="form-group">
            <label for="industry_classification_id">Industry Classification<span class="text-danger">*</span></label>
            <select
                :class="{ 'is-invalid': $parent.validationErrors.hasOwnProperty('industry_classification_id') }"
                class="form-control"
                v-model="$parent.form.industry_classification_id"
            >
                <option v-for="in_class in $parent.industryClassifications" :value="in_class.id">
                    {{ in_class.name }}
                </option>
            </select>

            <p class="text-danger d-block" v-if="$parent.validationErrors.hasOwnProperty('industry_classification_id')">
                {{ $parent.validationErrors.industry_classification_id[0] ?? '' }}
            </p>
        </div>

        <div class="form-group">
            <label for="password">Addresses<span class="text-danger">*</span></label>
            <div
                class="border rounded pl-4 pr-4 py-2 my-2"
                v-for="(item, index) in $parent.form.address"
                :key="index"
                :class="{ 'bg-secondary': index !== 0 }"
            >
                <h6 class="font-weight-bold mb-2">{{ index === 0 ? 'Default Address' : 'Address #' + (index + 1) }}</h6>
                <button
                    type="button"
                    role="button"
                    v-show="index != 0"
                    class="btn btn-sm btn-secondary rounded-circle p-0 position-absolute"
                    @click="removeAddress(index)"
                    style="left: 11px; width: 40px; height: 40px"
                >
                    <i class="icon-cross font-weight-bold" style="font-size: 1.2rem"></i>
                </button>
                <div class="form-group">
                    <label :for="'address_name' + index">Address Name <span class="text-danger">*</span></label>
                    <div class="pl-0">
                        <input
                            type="text"
                            v-model="item.address_name"
                            :id="'address_name' + index"
                            class="form-control"
                            :class="{
                                'is-invalid': $parent.validationErrors.hasOwnProperty(`address.${index}.address_name`),
                            }"
                            placeholder="Enter Address Name"
                            required
                        />
                    </div>

                    <p
                        class="text-danger d-block"
                        v-if="$parent.validationErrors.hasOwnProperty(`address.${index}.address_name`)"
                    >
                        {{ $parent.validationErrors[`address.${index}.address_name`][0] ?? '' }}
                    </p>
                </div>
                <div class="form-group">
                    <label :for="'address_1' + index">Street Address <span class="text-danger">*</span></label>
                    <div class="mb-1">
                        <input
                            type="text"
                            v-model="item.address_1"
                            :id="'address_1' + index"
                            :class="{
                                'is-invalid': $parent.validationErrors.hasOwnProperty(`address.${index}.address_1`),
                            }"
                            class="form-control"
                            placeholder="Line 1"
                            required
                        />
                        <p
                            class="text-danger d-block"
                            v-if="$parent.validationErrors.hasOwnProperty(`address.${index}.address_1`)"
                        >
                            {{ $parent.validationErrors[`address.${index}.address_1`][0] ?? '' }}
                        </p>
                    </div>
                    <div class="mb-1">
                        <input
                            type="text"
                            v-model="item.address_2"
                            :id="'address_2' + index"
                            class="form-control"
                            placeholder="Line 2"
                            required
                        />
                    </div>
                    <div class="mb-1">
                        <input
                            type="text"
                            v-model="item.address_3"
                            :id="'address_3' + index"
                            class="form-control"
                            placeholder="Line 3"
                            required
                        />
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                            <label :for="'city_' + index">City<span class="text-danger">*</span></label>
                            <input
                                type="text"
                                v-model="item.city"
                                :id="'city_' + index"
                                :class="{
                                    'is-invalid': $parent.validationErrors.hasOwnProperty(`address.${index}.city`),
                                }"
                                class="form-control"
                                placeholder="Enter City"
                                required
                            />

                            <p
                                class="text-danger d-block"
                                v-if="$parent.validationErrors.hasOwnProperty(`address.${index}.city`)"
                            >
                                {{ $parent.validationErrors[`address.${index}.city`][0] ?? '' }}
                            </p>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                            <label :for="'state_' + index">State<span class="text-danger">*</span></label>
                            <input
                                type="text"
                                v-model="item.state"
                                :id="'state_' + index"
                                :class="{
                                    'is-invalid': $parent.validationErrors.hasOwnProperty(`address.${index}.state`),
                                }"
                                class="form-control"
                                placeholder="Enter State"
                                required
                            />

                            <p
                                class="text-danger d-block"
                                v-if="$parent.validationErrors.hasOwnProperty(`address.${index}.state`)"
                            >
                                {{ $parent.validationErrors[`address.${index}.state`][0] ?? '' }}
                            </p>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                            <label :for="'country_code_' + index">Country Code</label>
                            <input
                                type="text"
                                v-model="item.country_code"
                                :id="'country_code_' + index"
                                class="form-control"
                                placeholder="Enter Country Code"
                            />
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                            <label :for="'zip_code_' + index">Zip Code <span class="text-danger">*</span></label>
                            <input
                                type="text"
                                v-model="item.zip_code"
                                :id="'zip_code_' + index"
                                :class="{
                                    'is-invalid': $parent.validationErrors.hasOwnProperty(`address.${index}.zip_code`),
                                }"
                                class="form-control"
                                placeholder="Enter Zip Code"
                                required
                            />
                            <p
                                class="text-danger d-block"
                                v-if="$parent.validationErrors.hasOwnProperty(`address.${index}.zip_code`)"
                            >
                                {{ $parent.validationErrors[`address.${index}.zip_code`][0] ?? '' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 d-flex justify-content-between p-0">
            <button class="btn btn-outline-primary" type="button" role="button" @click="addAddress()">
                +Add More Address
            </button>
            <button class="btn btn-info margin-bottom-none mr-0" type="button" @click="validateData()">
                <i class="pe-7s-angle-right-circle"></i> Next
            </button>
        </div>
    </div>
</template>

<script>
export default {
    name: 'Company',
    data() {
        return {};
    },
    props: [],

    methods: {
        removeAddress(index) {
            this.$parent.form.address.splice(index, 1);
        },

        addAddress() {
            this.$parent.form.address.push({
                address_name: '',
                address_1: '',
                address_2: '',
                address_3: '',
                city: '',
                state: '',
                country_code: '',
                zip_code: '',
            });
        },

        validateData() {
            this.$parent.removeErrors();
            const form = this.$parent.form;

            if (form.customer_name.length === 0) {
                this.$parent.pushError('customer_name', 'This Company Name field is required.');
            }

            if (form.email.length === 0) {
                this.$parent.pushError('email', 'This Company Email field is required.');
            }

            if (form.phone.length === 0) {
                this.$parent.pushError('phone', 'This Company Phone field is required.');
            }

            if (this.$parent.amplify_client_code === 'ACT' && form.industry_classification_id.length === 0) {
                this.$parent.pushError(
                    'industry_classification_id',
                    'This Company Industry Classification field is required.',
                );
            }

            for (let i = 0; i < form.address.length; i++) {
                if (form.address[i].address_name.length === 0) {
                    this.$parent.pushError(`address.${i}.address_name`, 'This address name field is required.');
                }

                if (form.address[i].address_1.length === 0) {
                    this.$parent.pushError(`address.${i}.address_1`, 'This address line 1 field is required.');
                }

                if (form.address[i].city.length === 0) {
                    this.$parent.pushError(`address.${i}.city`, 'This address city field is required.');
                }

                if (form.address[i].state.length === 0) {
                    this.$parent.pushError(`address.${i}.state`, 'This address state field is required.');
                }

                if (form.address[i].zip_code.length === 0) {
                    this.$parent.pushError(`address.${i}.zip_code`, 'This zip code field is required.');
                }
            }

            if (!_.isEmpty(this.$parent.validationErrors)) {
                ShowNotification('error', 'Registration', 'The given data is invalid.');
            } else {
                this.$parent.step = 'admin';
            }
        },
    },
};
</script>
<style>
.form-control:invalid,
.form-control.is-invalid {
    background-position: 99%;
}
</style>
