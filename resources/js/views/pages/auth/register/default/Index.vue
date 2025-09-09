<script>
import Company from './Company.vue';
import Admin from './Admin.vue';

export default {
    name: 'DefaultRegistration',
    components: { Company, Admin },
    props: [
        'register_button_title',
        'axios_url',
        'honeypot_config',
        'admin_tab_title',
        'company_tab_title',
        'captcha_verification',
        'token',
        'industry_classifications',
        'amplify_client_code',
    ],
    data() {
        return {
            step: 'company',
            captchaVerificationEnabled: this.captcha_verification === 'true',
            captchaVerified: false,
            honeypot: JSON.parse(this.honeypot_config),
            industryClassifications: JSON.parse(this.industry_classifications),
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

        removeFullPageLoader();
    },
    methods: {
        pushError(field, message) {
            this.validationErrors[field] = [];
            this.validationErrors[field][0] = message;
        },
        removeErrors() {
            this.validationErrors = {};
        },
        validateData() {
            this.removeErrors();
            const form = this.form;

            if (form.admin_name.length === 0) {
                this.pushError('admin_name', 'This contact name field is required.');
            }

            if (form.admin_phone.length === 0) {
                this.pushError('admin_phone', 'This phone field is required.');
            }

            if (form.admin_email.length === 0) {
                this.pushError('admin_email', 'This email field is required.');
            }
            if (form.password.length === 0) {
                this.pushError('password', 'This password field is required.');
            }
            if (form.password_confirmation.length === 0) {
                this.pushError('password_confirmation', 'This retype password field is required.');
            }
            if (this.captchaVerificationEnabled && form.captcha.length === 0) {
                this.pushError('captcha', 'This captcha verification is required.');
            }

            if (!_.isEmpty(this.validationErrors)) {
                ShowNotification('error', 'Registration', 'The given data is invalid.');
                return false;
            }

            return true;
        },

        saveData() {
            if (this.validateData()) {
                if (!this.captchaVerificationEnabled) {
                    delete this.form.captcha;
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
            }
        },
    },
};
</script>

<template>
    <div>
        <ul class="nav nav-tabs nav-justified">
            <li class="nav-item">
                <a
                    class="nav-link"
                    :class="{ active: step == 'company', disabled: step != 'company' }"
                    href="#home2"
                    data-toggle="tab"
                    role="tab"
                >
                    {{ company_tab_title ?? '' }}
                </a>
            </li>
            <li class="nav-item">
                <a
                    class="nav-link"
                    :class="{ active: step == 'admin', disabled: step != 'admin' }"
                    href="#profile2"
                    data-toggle="tab"
                    role="tab"
                >
                    {{ admin_tab_title ?? '' }}
                </a>
            </li>
        </ul>
        <div class="tab-content p-3">
            <div
                class="tab-pane fade home-tab"
                :class="{ 'show active': step == 'company' }"
                id="home2"
                role="tabpanel"
            >
                <Company />
            </div>
            <div
                class="tab-pane fade home-tab"
                :class="{ 'show active': step == 'admin' }"
                id="profile2"
                role="tabpanel"
            >
                <Admin />
            </div>
        </div>
    </div>
</template>

<style scoped></style>
