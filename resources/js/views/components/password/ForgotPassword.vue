<template>
    <div>
        <form class="login-box" @submit.prevent="sendOtp">
            <h4 class="margin-bottom-1x">Forgot Your Password ?</h4>
            <div class="form-group">
                <div class="input-group">
                    <input class="form-control" type="email" v-model="email" placeholder="Email" required />
                    <span class="input-group-addon">
                        <i class="icon-mail"></i>
                    </span>
                </div>
                <span class="invalid-feedback d-block" v-if="errorMessage.email" style="position: absolute">
                    <strong>{{ errorMessage.email }}</strong>
                </span>
            </div>
            <div class="text-center text-sm-right">
                <button class="btn btn-primary margin-bottom-none" :disabled="loading">
                    <span v-if="loading">Loading...</span>
                    <span v-else> Submit</span>
                </button>
            </div>
        </form>

        <vue-modal name="otp-modal" :on-close="closeModal" :outer-close="false">
            <h5 slot="header">Password Reset</h5>
            <form class="login-box" @submit.prevent="otpCheck">
                <h4 class="margin-bottom-1x">Enter The OTP</h4>
                <div style="margin-top: 0.5rem">
                    <div class="input-group">
                        <input class="form-control" type="text" v-model="otp" placeholder="OTP" required />
                        <span class="input-group-addon">
                            <i class="icon-lock"></i>
                        </span>
                    </div>
                    <span class="invalid-feedback d-block" v-if="errorMessage.otp">
                        <strong>{{ errorMessage.otp }}</strong>
                    </span>
                </div>

                <span class="invalid-feedback d-block" v-if="codeSend" style="padding-left: 0; color: green"
                    >OTP Resend To Your Email</span
                >
                <span @click="resendOtp()" class="resend-otp" v-else style="font-size: 80%">Resend OTP ?</span>

                <div class="text-center text-sm-right">
                    <button class="btn btn-primary margin-bottom-none" :disabled="loading">
                        <span v-if="loading">Loading...</span>
                        <span v-else> Submit</span>
                    </button>
                </div>
            </form>
        </vue-modal>

        <vue-modal name="password-modal" :outer-close="false">
            <h5 slot="header">Password Reset</h5>
            <form class="login-box" @submit.prevent="resetPassword">
                <h4 class="margin-bottom-1x">Enter Your New Password</h4>

                <div style="margin-bottom: 0.5rem">
                    <div class="input-group">
                        <input
                            class="form-control"
                            type="password"
                            v-model="password"
                            placeholder="Password"
                            minlength="6"
                            required
                        />
                        <span class="input-group-addon">
                            <i class="icon-lock"></i>
                        </span>
                    </div>
                    <span class="invalid-feedback d-block" v-if="errorMessage.password">
                        <strong>{{ errorMessage.password }}</strong>
                    </span>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <input
                            class="form-control"
                            type="password"
                            v-model="confirmPassword"
                            placeholder="Confirm Password"
                            minlength="6"
                            required
                        />
                        <span class="input-group-addon">
                            <i class="icon-lock"></i>
                        </span>
                    </div>
                    <span class="invalid-feedback d-block" v-if="errorMessage.confirmPassword">
                        <strong>{{ errorMessage.confirmPassword }}</strong>
                    </span>
                </div>

                <div class="text-center text-sm-right">
                    <button class="btn btn-primary margin-bottom-none" :disabled="loading">
                        <span v-if="loading">Loading...</span>
                        <span v-else> Submit</span>
                    </button>
                </div>
            </form>
        </vue-modal>
    </div>
</template>
<script>
import Vue from 'vue';
import VueModal from 'vue2-modal';

Vue.use(VueModal);
export default {
    props: {},
    data() {
        return {
            email: '',
            otp: '',
            password: '',
            confirmPassword: '',
            codeSend: false,
            loading: false,
            errorMessage: {
                email: '',
                otp: '',
                password: '',
                confirmPassword: '',
            },
        };
    },
    methods: {
        closeModal() {
            (this.otp = ''),
                (this.password = ''),
                (this.confirmPassword = ''),
                (this.codeSend = false),
                (this.errorMessage = {
                    email: '',
                    otp: '',
                    password: '',
                    confirmPassword: '',
                });
        },
        sendOtp() {
            this.otp = '';
            this.loading = true;
            axios
                .post('/password-reset-otp', { email: this.email })
                .then((res) => {
                    this.loading = false;
                    if (res.status == 200) {
                        this.errorMessage.email = '';
                        this.$modals.show('otp-modal');
                    } else if (res.status == 210) {
                        this.errorMessage.email = res.data.message;
                    } else {
                        this.errorMessage.email = 'Something Went Wrong';
                    }
                })
                .catch((error) => {
                    this.loading = false;
                    this.errorMessage.email = 'Something Went Wrong';
                });
        },
        resendOtp() {
            axios
                .post('/password-reset-otp', { email: this.email })
                .then((res) => {
                    if (res.status == 200) {
                        this.codeSend = true;
                    }
                })
                .catch((error) => {
                    this.errorMessage.email = 'Something Went Wrong';
                });
        },

        otpCheck() {
            this.loading = true;
            axios
                .post('/otp-check', { email: this.email, otp: this.otp })
                .then((res) => {
                    this.loading = false;

                    if (res.status == 200) {
                        this.$modals.hide('otp-modal');
                        this.$modals.show('password-modal');
                    } else if (res.status == 210) {
                        this.errorMessage.otp = res.data.message;
                    }
                })
                .catch((error) => {
                    this.loading = false;
                    this.errorMessage.otp = 'Something Went Wrong';
                });
        },

        resetPassword() {
            this.loading = true;
            if (this.password.length < 6) {
                this.errorMessage.password = 'Password Minimum 6 Character';
                this.loading = false;
                return;
            } else {
                this.errorMessage.password = '';
            }

            if (this.password !== this.confirmPassword) {
                this.errorMessage.confirmPassword = 'Confirm Password Not Matched';
                this.loading = false;
                return;
            } else {
                this.errorMessage.confirmPassword = '';
            }
            axios
                .post('/reset-password', { email: this.email, password: this.password, otp: this.otp })
                .then((res) => {
                    this.loading = false;
                    ShowNotification('success', 'Authentication', res.data.message);
                    if (res.data.success) {
                        window.location.href = '/login';
                    } else {
                        this.errorMessage.confirmPassword = res.data.message;
                    }
                })
                .catch((error) => {
                    this.loading = false;
                    this.errorMessage.otp = 'Something Went Wrong';
                });
        },
    },
};
</script>

<style scoped>
.resend-otp {
    cursor: pointer;
    color: #094a75;
}

.resend-otp:hover {
    color: #0da9ef;
}
</style>
