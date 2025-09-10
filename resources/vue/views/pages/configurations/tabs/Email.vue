

<template>
    <div role="tabpanel" class="tab-pane active" id="tab_basic-info">
        <fieldset>
            <div class="d-flex justify-content-between border-bottom pb-0 mb-3 mt-n3">
                <legend>
                    <i class="la la-envelope mr-2"></i>
                    Email Configuration
                </legend>
                <div class="d-md-none custom-sidebar-ar" @click="$parent.toggleSidebar()">
                    <div class="menu-icon-ar">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                             stroke="#1b2a4e" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                             class="feather feather-menu">
                            <line x1="3" y1="12" x2="21" y2="12"></line>
                            <line x1="3" y1="6" x2="21" y2="6"></line>
                            <line x1="3" y1="18" x2="21" y2="18"></line>
                        </svg>
                    </div>
                    <div class="close-icon-ar">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                             stroke="red" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                             class="feather feather-x">
                            <line x1="18" y1="6" x2="6" y2="18"></line>
                            <line x1="6" y1="6" x2="18" y2="18"></line>
                        </svg>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label>Admin Notification Email</label>
                <input type="text" name="admin_email" placeholder="Enter admin notification email"
                       v-model="emailConfigurationData.admin_email"
                       class="form-control">
                <small class="help">Email address that will be notified when admin level event occur.</small>
            </div>

            <div class="form-group">
                <label>System Sender Name</label>
                <input type="text" name="sender_name" placeholder="Enter system sender name"
                       v-model="emailConfigurationData.sender_name"
                       class="form-control">
                <small class="help">Sender name that will be used when send notification email.</small>
            </div>

            <div class="form-group">
                <label>System Email Address</label>
                <input type="text" name="sender_email" placeholder="Enter system email address"
                       v-model="emailConfigurationData.sender_email"
                       class="form-control">
                <small class="help">Sender email address that will be used send notification email.</small>
            </div>

            <div class="form-group">
                <label>Driver</label>
                <select name="payment_gateway"
                        class="form-control custom-select"
                        v-model="emailConfigurationData.transport"
                        @change="updateEmailInfo">
                    <option :value="index" v-for="(label, index) in drivers"
                            :key="index"
                            :selected="index === emailConfigurationData.transport ? true : false">
                        {{ label }}
                    </option>
                </select>
            </div>

            <div class="form-group">
                <label>Host</label>
                <input type="text" name="host" placeholder="Enter Host" v-model="emailConfigurationData.host"
                       class="form-control" :class="{ 'is-invalid': $parent.validationErrors.host }">
                <small v-if="$parent.validationErrors.host" class="text-danger mt-3">{{
                        $parent.validationErrors.host[0]
                    }}</small>
            </div>

            <div class="form-group">

                <label>Port</label>
                <input type="text" name="port" placeholder="Enter Port" v-model="emailConfigurationData.port"
                       class="form-control" :class="{ 'is-invalid': $parent.validationErrors.port }">
                <small v-if="$parent.validationErrors.port" class="text-danger mt-3">{{
                        $parent.validationErrors.port[0]
                    }}</small>

            </div>

            <div class="form-group">

                <label>User name</label>
                <input type="text" name="username" placeholder="Enter Username"
                       v-model="emailConfigurationData.username" class="form-control"
                       :class="{ 'is-invalid': $parent.validationErrors.username }">
                <small v-if="$parent.validationErrors.username" class="text-danger mt-3">{{
                        $parent.validationErrors.username[0]
                    }}</small>
            </div>

            <div class="form-group">

                <div>
                    <label>Password</label>
                    <input :type="passwordFieldType" name="password" placeholder="Enter Password"
                           v-model="emailConfigurationData.password" class="form-control"
                           :class="{ 'is-invalid': $parent.validationErrors.password }">

                    <i @click="toggleShow"
                       :class="{ 'eye-position fas fa-eye-slash': showPassword, 'eye-position fas fa-eye': !showPassword }"></i>

                    <small v-if="$parent.validationErrors.password" class="text-danger mt-3">{{
                            $parent.validationErrors.password[0]
                        }}</small>
                </div>

            </div>

            <div class="form-group">
                <label>Encryption</label>
                <select name="payment_gateway" class="form-control custom-select"
                        v-model="emailConfigurationData.encryption"
                        :class="{ 'is-invalid': $parent.validationErrors.encryption }">
                    <option :value="pg.code" v-for="(pg, index) in encryptions" :key="index"
                            :selected="pg.code == emailConfigurationData.encryption ? true : false">
                        {{ pg.name }}
                    </option>
                </select>
                <small v-if="$parent.validationErrors.encryption" class="text-danger mt-3">{{
                        $parent.validationErrors.encryption[0]
                    }}</small>
            </div>

            <div class="form-group">
                <label>Error Notification Emails</label>
                <input type="text" name="error_notify_email" placeholder="Enter comma separated mails"
                       v-model="emailConfigurationData.error_notify_email"
                       class="form-control">
                <small v-if="$parent.validationErrors.error_notify_email" class="text-danger mt-3">
                    {{ $parent.validationErrors.error_notify_email[0] }}</small>
                <small class="help">Email address that will be notified when exception occurred in system.</small>
            </div>

            <div class="form-group">
                <input type="checkbox" name="logger_enabled"
                       id="email_logger_enabled"
                       v-model="emailConfigurationData.logger_enabled"
                       :class="{ 'is-invalid': $parent.validationErrors.logger_enabled }">
                <label for="email_logger_enabled">Enable Email API Log</label>
                <small v-if="$parent.validationErrors.logger_enabled" class="text-danger mt-3">{{
                        $parent.validationErrors.logger_enabled[0]
                    }}</small>
            </div>
        </fieldset>
        <div id="saveActions" class="form-group">

            <button @click="$parent.saveCoreConfigInfo(emailConfigurationData)" type="button" class="btn btn-success">
                <span class="la la-save" role="presentation" aria-hidden="true"></span> &nbsp;
                <span data-value="save_and_edit"> Save</span>
            </button>

            <button @click="$parent.saveAndAction()" type="button" class="btn btn-default">
                <span class="la la-ban"></span> Cancel
            </button>
        </div>
    </div>
</template>

<script>
import Multiselect from "vue-multiselect";
import Treeselect from "@riophae/vue-treeselect";

import '@riophae/vue-treeselect/dist/vue-treeselect.css';

export default {
    name: "Email",

    components: {Multiselect, Treeselect},

    data() {
        return {
            emailConfigurationData: {
                tab: 'email',
                transport: this.$parent.mailConfigurationData.default ?? 'smtp',
                logger_enabled: this.$parent.mailConfigurationData.logger_enabled ?? false,
                host: '',
                port: '',
                username: '',
                password: '',
                encryption: '',
                admin_email: '',
                error_notify_email: '',
                sender_name: '',
                sender_email: ''

            },
            drivers: this.$parent.mailConfigurationData.labels ?? [],
            encryptions: [
                {
                    name: 'SSL',
                    code: 'ssl'
                },
                {
                    name: 'TLS',
                    code: 'tls'
                },
            ],
            showPassword: false,
            passwordFieldType: "password"
        }
    },

    mounted() {
        this.emailConfigurationData.error_notify_email = this.$parent.mailConfigurationData.error_notify_email ?? null;
        this.emailConfigurationData.admin_email = this.$parent.mailConfigurationData.admin_email ?? null;
        this.emailConfigurationData.sender_name = this.$parent.mailConfigurationData.from.name ?? null;
        this.emailConfigurationData.sender_email = this.$parent.mailConfigurationData.from.address ?? null;
        this.setValue(this.$parent.mailConfigurationData.default, this.$parent.mailConfigurationData.mailers);
    },

    methods: {
        updateEmailInfo(event) {
            this.setValue(event.target.value, this.$parent.mailConfigurationData.mailers);
        },

        setValue(email, configurations) {
            for (const [key, value] of Object.entries(configurations)) {
                if (key === email) {
                    this.emailConfigurationData.host = value.host ?? "";
                    this.emailConfigurationData.username = value.username ?? "";
                    this.emailConfigurationData.password = value.password ?? "";
                    this.emailConfigurationData.port = value.port ?? false;
                    this.emailConfigurationData.encryption = value.encryption ?? false;
                }
            }
        },

        toggleShow() {
            this.showPassword = !this.showPassword;
            this.passwordFieldType = this.passwordFieldType === "password" ? "text" : "password";
        }
    },
}
</script>
