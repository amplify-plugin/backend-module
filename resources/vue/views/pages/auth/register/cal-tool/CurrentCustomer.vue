<template>
    <div class="registration-container">
        <!-- Form Title -->
        <!-- Form Title and Required Indicator -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5>New On Account User Web Store Access Request</h5>
            <h5><span class="text-danger">*</span> Indicates a Required Field</h5>
        </div>
        <div class="form-row">
            <!-- Account Number -->
            <div class="col-md-12 col-sm-12 form-group">
                <label for="account_number">Account Number <span class="text-danger">*</span></label>
                <input
                    class="form-control"
                    :class="{ 'is-invalid': $parent.validationErrors.hasOwnProperty('account_number') }"
                    type="text"
                    v-model="$parent.form.account_number"
                    id="account_number"
                    placeholder="Account Number"
                />
                <p class="text-danger" v-if="$parent.validationErrors.hasOwnProperty('account_number')">
                    {{ $parent.validationErrors.account_number[0] }}
                </p>
            </div>
        </div>

        <div class="form-row">
            <!-- Name -->
            <div class="col-md-6 col-sm-12 form-group">
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
    name: 'CurrentCustomer',
    props: [],
    data() {
        return {};
    },
    methods: {
        validateData() {
            // Reset previous validation errors
            this.$parent.removeErrors();

            const form = this.$parent.form;

            // Validate account number
            if (!form.account_number) {
                this.$parent.pushError('account_number', 'Account number is required.');
            }

            // Validate first name
            if (!form.name) {
                this.$parent.pushError('name', 'Name is required.');
            }

            // Validate email
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

            // If no validation errors, proceed to save data
            if (Object.keys(this.$parent.validationErrors).length === 0) {
                this.$parent.saveData();
            } else {
                // Show notification for validation errors
                ShowNotification('error', 'Registration', 'Please correct the errors in the form.');
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
