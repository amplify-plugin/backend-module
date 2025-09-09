<template>
    <div class="registration-container">
        <!-- Form Title and Required Indicator -->
        <div class="text-right mb-3">
            <h5><span class="text-danger">*</span> Indicates a Required Field</h5>
        </div>

        <!-- Form Fields -->
        <div class="form-row">
            <!-- First Name -->
            <div class="col-md-12 col-sm-12 form-group">
                <label for="name">Name <span class="text-danger">*</span></label>
                <input
                    class="form-control"
                    :class="{ 'is-invalid': $parent.validationErrors.hasOwnProperty('name') }"
                    type="text"
                    v-model="$parent.form.name"
                    id="name"
                    placeholder="Name"
                />
                <p class="text-danger" v-if="$parent.validationErrors.hasOwnProperty('name')">
                    {{ $parent.validationErrors.name[0] }}
                </p>
            </div>
        </div>

        <div class="form-row">
            <!-- Company Name -->
            <div class="col-md-6 col-sm-12 form-group">
                <label for="company_name">Company Name <span class="text-danger">*</span></label>
                <input
                    class="form-control"
                    :class="{ 'is-invalid': $parent.validationErrors.hasOwnProperty('company_name') }"
                    type="text"
                    v-model="$parent.form.company_name"
                    id="company_name"
                    placeholder="Company Name"
                />
                <p class="text-danger" v-if="$parent.validationErrors.hasOwnProperty('company_name')">
                    {{ $parent.validationErrors.company_name[0] }}
                </p>
            </div>

            <!-- Email -->
            <div class="col-md-6 col-sm-12 form-group">
                <label for="email">Email <span class="text-danger">*</span></label>
                <input
                    class="form-control"
                    :class="{ 'is-invalid': $parent.validationErrors.hasOwnProperty('email') }"
                    type="email"
                    v-model="$parent.form.email"
                    id="email"
                    placeholder="Email"
                />
                <small class="text-muted">Your E-Mail Address will serve as your User ID when you Login</small>
                <p class="text-danger" v-if="$parent.validationErrors.hasOwnProperty('email')">
                    {{ $parent.validationErrors.email[0] }}
                </p>
            </div>
        </div>

        <div class="form-row">
            <!-- Password -->
            <div class="col-md-6 col-sm-12 form-group">
                <label for="password">Password <span class="text-danger">*</span></label>
                <input
                    class="form-control"
                    :class="{ 'is-invalid': $parent.validationErrors.hasOwnProperty('password') }"
                    type="password"
                    v-model="$parent.form.password"
                    id="password"
                    placeholder="Password"
                />
                <p class="text-danger" v-if="$parent.validationErrors.hasOwnProperty('password')">
                    {{ $parent.validationErrors.password[0] }}
                </p>
            </div>

            <!-- Password Confirmation -->
            <div class="col-md-6 col-sm-12 form-group">
                <label for="password_confirmation">Password Confirmation <span class="text-danger">*</span></label>
                <input
                    class="form-control"
                    :class="{ 'is-invalid': $parent.validationErrors.hasOwnProperty('password_confirmation') }"
                    type="password"
                    v-model="$parent.form.password_confirmation"
                    id="password_confirmation"
                    placeholder="Password Confirmation"
                />
                <p class="text-danger" v-if="$parent.validationErrors.hasOwnProperty('password_confirmation')">
                    {{ $parent.validationErrors.password_confirmation[0] }}
                </p>
            </div>
        </div>

        <div class="form-row">
            <!-- Phone Number -->
            <div class="col-md-6 col-sm-12 form-group">
                <label for="phone_number">Phone Number <span class="text-danger">*</span></label>
                <input
                    class="form-control"
                    :class="{ 'is-invalid': $parent.validationErrors.hasOwnProperty('phone_number') }"
                    type="text"
                    v-model="$parent.form.phone_number"
                    id="phone_number"
                    placeholder="Phone Number"
                />
                <p class="text-danger" v-if="$parent.validationErrors.hasOwnProperty('phone_number')">
                    {{ $parent.validationErrors.phone_number[0] }}
                </p>
            </div>

            <!-- Product Classification -->
            <div class="col-md-6 col-sm-12 form-group" v-if="this.$parent.amplify_client_code === 'ACT'">
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
        </div>

        <!-- Keep Address Section Like Before -->
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
                <!-- Address Fields -->
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

        <!-- Terms & Conditions Text (Above Checkbox) -->
        <small class="text-muted d-block mb-2">
            Click on "I Accept" button to agree to the California Tool & Welding Supply Terms and Conditions and to submit your registration.
        </small>

        <!-- Checkbox -->
        <div class="form-group mt-2">
            <div class="form-check">
                <input
                    type="checkbox"
                    class="form-check-input"
                    v-model="$parent.form.newsletter_subscription"
                    id="newsletter_subscription"
                />
                <label class="form-check-label" for="newsletter_subscription">
                    California Tool & Welding Supply newsletter subscription.
                </label>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="text-right mt-4">
            <button class="btn btn-danger margin-bottom-none mr-0" type="button" @click.prevent="validateData">I ACCEPT</button>
        </div>
    </div>
</template>

<script>
export default {
    name: 'RetailCustomer',
    data() {
        return {
            productClassifications: [
                { id: 1, name: 'Industrial Products' },
                { id: 2, name: 'Consumer Goods' },
                { id: 3, name: 'Electronics' },
                // Add more product classifications as needed
            ],
        };
    },
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

            if (!form.name) {
                this.$parent.pushError('name', 'Name is required.');
            }

            if (!form.company_name) {
                this.$parent.pushError('company_name', 'Company name is required.');
            }

            if (!form.email) {
                this.$parent.pushError('email', 'Email is required.');
            } else if (!this.validateEmail(form.email)) {
                this.$parent.pushError('email', 'Email format is invalid.');
            }

            // Validate password
            if (!form.password) {
                this.$parent.pushError('password', 'Password is required.');
            }

            // Validate password confirmation
            if (!form.password_confirmation) {
                this.$parent.pushError('password_confirmation', 'Password confirmation is required.');
            } else if (form.password !== form.password_confirmation) {
                this.$parent.pushError('password_confirmation', 'Passwords do not match.');
            }

            if (!form.phone_number) {
                this.$parent.pushError('phone_number', 'Phone number is required.');
            }

            if (this.$parent.amplify_client_code === 'ACT' && !form.industry_classification_id) {
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
                ShowNotification('error', 'Registration', 'Please correct the errors in the form.');
            } else {
                this.$parent.saveData();
            }
        },

        validateEmail(email) {
            const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return re.test(String(email).toLowerCase());
        },
    },
};
</script>

<style scoped></style>
