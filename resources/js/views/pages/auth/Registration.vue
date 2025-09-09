<template>
    <form>
        <component ref="component" :is="registrationScreen"  v-bind="calToolProps" />
        <div v-if="honeypot.enabled" :name="`${honeypot.nameFieldName}_wrap`" style="display: none">
            <input
                type="text"
                v-model="form[honeypot.nameFieldName]"
                :name="honeypot.nameFieldName"
                :id="honeypot.nameFieldName"
            />
            <input type="text" v-model="form[honeypot.validFromFieldName]" :name="honeypot.validFromFieldName" />
        </div>
    </form>
</template>

<script>
import DefaultRegistration from './register/default/Index';
import CalToolRegistration from './register/cal-tool/Index';

export default {
    name: 'Registration',
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
    components: { DefaultRegistration, CalToolRegistration },
    data() {
        return {
            registrationScreen: null,
            honeypot: JSON.parse(this.honeypot_config),
            form: {
                _token: this.token,
                customer_name: '',
                admin_name: '',
                admin_phone: '',
                admin_email: '',
                password: '',
                password_confirmation: '',
                email: '',
                phone: '',
                industry_classification_id: '',
                captcha: '',
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
            },
            calToolProps: {
                register_button_title: this.register_button_title,
                axios_url: this.axios_url,
                honeypot_config: this.honeypot_config,
                current_customer_tab_title: "I AM A CURRENT CUSTOMER BUT NEED AN ONLINE ACCOUNT",
                new_commercial_account_tab_title: "NEW COMMERCIAL ACCOUNT",
                new_retail_customer_tab_title: "NEW RETAIL CUSTOMER ACCOUNT",
                captcha_verification: this.captcha_verification,
                token: this.token,
                industry_classifications: this.industry_classifications,
                amplify_client_code: this.amplify_client_code,
            }
        };
    },
    mounted() {
        if (this.amplify_client_code === 'ACT') {
            this.registrationScreen = CalToolRegistration;
        }else{
            this.registrationScreen = DefaultRegistration;
        }
    },
};
</script>
