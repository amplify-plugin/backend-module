<template>
    <div>
        <ul class="nav nav-tabs nav-justified">
            <li class="nav-item">
                <a
                    class="nav-link"
                    :class="{ active: step === 'current_customer' }"
                    href="#current_customer"
                    data-toggle="tab"
                    role="tab"
                    @click="initializeForm('current_customer')"
                >
                    {{ current_customer_tab_title ?? '' }}
                </a>
            </li>
            <li class="nav-item">
                <a
                    class="nav-link"
                    :class="{ active: step === 'new_commercial_account' }"
                    href="#new_commercial_account"
                    data-toggle="tab"
                    role="tab"
                    @click="step='new_commercial_account'"
                >
                    {{ new_commercial_account_tab_title ?? '' }}
                </a>
            </li>
            <li class="nav-item">
                <a
                    class="nav-link"
                    :class="{ active: step === 'new_retail_customer' }"
                    href="#new_retail_customer"
                    data-toggle="tab"
                    role="tab"
                    @click="initializeForm('new_retail_customer')"
                >
                    {{ new_retail_customer_tab_title ?? '' }}
                </a>
            </li>
        </ul>
        <div class="tab-content p-3">
            <div
                class="tab-pane fade home-tab"
                :class="{ 'show active': step === 'current_customer' }"
                id="current_customer"
                role="tabpanel"
            >
                <CurrentCustomer />
            </div>
            <div
                class="tab-pane fade home-tab"
                :class="{ 'show active': step === 'new_commercial_account' }"
                id="new_commercial_account"
                role="tabpanel"
            >
                <CommercialAccount />
            </div>
            <div
                class="tab-pane fade home-tab"
                :class="{ 'show active': step === 'new_retail_customer' }"
                id="new_retail_customer"
                role="tabpanel"
            >
                <RetailCustomer />
            </div>
        </div>
    </div>
</template>

<script>
import CurrentCustomer from './CurrentCustomer.vue';
import CommercialAccount   from './CommercialAccount.vue';
import RetailCustomer from './RetailCustomer.vue';

export default {
    name: 'CalToolRegistration',
    components: { CurrentCustomer, CommercialAccount, RetailCustomer },
    props: [
        'register_button_title',
        'axios_url',
        'honeypot_config',
        'new_retail_customer_tab_title',
        'current_customer_tab_title',
        'new_commercial_account_tab_title',
        'captcha_verification',
        'token',
        'industry_classifications',
        'amplify_client_code',
    ],
    data() {
        return {
            step: 'current_customer',
            captchaVerificationEnabled: this.captcha_verification === 'true',
            captchaVerified: false,
            honeypot: JSON.parse(this.honeypot_config),
            industryClassifications: JSON.parse(this.industry_classifications),
            form: {},
            validationErrors: {},
        };
    },
    mounted() {
        if (!this.captchaVerificationEnabled) {
            this.captchaVerified = true;
        }

        if (this.honeypot.enabled) {
            this.form[this.honeypot.nameFieldName] = '';
            this.form[this.honeypot.validFromFieldName] = this.honeypot.encryptedValidFrom;
        }

        this.initializeForm('current_customer')

        removeFullPageLoader();
    },
    methods: {
        initializeForm(step) {
            this.step = step;
            this.validationErrors = {};

            if (step === 'current_customer') {
                // Set form structure for Current Customer
                this.form = {
                    account_number: '',
                    name: '',
                    email: '',
                    password: '',
                    password_confirmation: '',
                    newsletter_subscription: true,
                    form_type: 'current_customer',
                };
            } else if (step === 'new_retail_customer') {
                // Set form structure for Retail Customer
                this.form = {
                    name: '',
                    company_name: '',
                    email: '',
                    phone_number: '',
                    password: '',
                    password_confirmation: '',
                    industry_classification_id: '',
                    address: [
                        {
                            address_name: '',
                            address_1: '',
                            address_2: '',
                            address_3: '',
                            city: '',
                            state: '',
                            country_code: '',
                            zip_code: '',
                        },
                    ],
                    newsletter_subscription: true,
                    form_type: 'new_retail_customer',
                };
            }
        },

        pushError(field, message) {
            this.validationErrors[field] = [];
            this.validationErrors[field][0] = message;
        },

        removeErrors() {
            this.validationErrors = {};
        },

        saveData() {
            if (this.form.form_type === 'current_customer') {
                this.axios_url = '/registration/request-account';
            } else if (this.form.form_type === 'new_retail_customer') {
                this.axios_url = '/registration/create-cash-customer';
            }

            axios
                .post(this.axios_url, this.form)
                .then((response) => {
                    ShowNotification(response.data.type, 'Registration', response.data.message);
                    if (response.data.redirect_url.length > 0) {
                        setTimeout(function () {
                            window.location.href = response.data.redirect_url;
                        }, 1000);
                    }
                })
                .catch((err) => {
                    ShowNotification(
                        'error',
                        'Registration',
                        err.response.data.message ?? 'The given data is invalid.',
                    );
                    this.validationErrors = err.response.data.errors;
                    console.error(err);
                });
        },
    },
};
</script>

<style scoped></style>
