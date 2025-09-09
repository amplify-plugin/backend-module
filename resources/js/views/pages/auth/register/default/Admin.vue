<template>
    <div>
        <div class="form-group">
            <label for="admin_name">Contact Name <span class="text-danger ">*</span></label>
            <input class="form-control"
                   :class="{'is-invalid' : $parent.validationErrors.hasOwnProperty('admin_name')}"
                   type="text" v-model="$parent.form.admin_name">

            <p class="text-danger d-block" v-if="$parent.validationErrors?.admin_name">
                {{ $parent.validationErrors.admin_name[0] ?? '' }}
            </p>
        </div>

        <div class="form-group">
            <label for="admin_phone">Phone <span class="text-danger ">*</span></label>
            <input class="form-control"
                   :class="{'is-invalid' : $parent.validationErrors.hasOwnProperty('admin_phone')}"
                   type="text" v-model="$parent.form.admin_phone">

            <p class="text-danger d-block" v-if="$parent.validationErrors?.admin_phone">
                {{ $parent.validationErrors.admin_phone[0] ?? '' }}
            </p>
        </div>

        <div class="form-group">
            <label for="admin_email">Email Address <span class="text-danger ">*</span></label>
            <input class="form-control"
                   :class="{'is-invalid' : $parent.validationErrors.hasOwnProperty('admin_email')}"
                   type="email" v-model="$parent.form.admin_email">

            <p class="text-danger d-block" v-if="$parent.validationErrors?.admin_email">
                {{ $parent.validationErrors.admin_email[0] ?? '' }}
            </p>
        </div>

        <div class="form-group">
            <label for="password">Password <span class="text-danger ">*</span></label>
            <input class="form-control"
                   :class="{'is-invalid' : $parent.validationErrors.hasOwnProperty('password')}"
                   type="password" v-model="$parent.form.password">

            <p class="text-danger d-block" v-if="$parent.validationErrors?.password">
                {{ $parent.validationErrors.password[0] ?? '' }}
            </p>
        </div>

        <div class="form-group">
            <label for="password_confirmation">Retype Password<span class="text-danger ">*</span></label>
            <input class="form-control" type="password"
                   :class="{'is-invalid' : $parent.validationErrors.hasOwnProperty('password')}"
                   v-model="$parent.form.password_confirmation">
            <p class="text-danger d-block" v-if="$parent.validationErrors?.password">
                {{ $parent.validationErrors.password[0] ?? '' }}
            </p>
        </div>

        <div class="form-group" v-if="$parent.captchaVerificationEnabled">
            <label>Captcha Verification<span class="text-danger">*</span></label>
            <div class="bg-secondary border d-flex rounded px-3 gap-3">
                <div class="d-flex gap-3 justify-content-between align-items-baseline">
                    <div class="captcha-container" v-html="captchaImage"></div>
                    <button class="btn btn-outline-secondary px-3 m-0" @click="reloadCaptcha">
                        <i class="icon-reload"></i>
                    </button>
                </div>
                <input type="text" class="form-control mt-2"
                       :class="{'is-invalid' : $parent.validationErrors.hasOwnProperty('captcha')}"
                       placeholder="Enter Captcha Character"
                       v-model="$parent.form.captcha"/>
            </div>
            <p class="text-danger d-block" v-if="$parent.validationErrors?.captcha">
                {{ $parent.validationErrors.captcha[0] ?? '' }}
            </p>
        </div>

        <div class="col-12 d-flex justify-content-between p-0">
            <button class="align-items-center btn btn-info d-flex d-inline-block margin-bottom-none" type="button"
                    @click="back">
                <i class="icon-rewind" aria-hidden="true"></i>Back
            </button>

            <button class="btn btn-success margin-bottom-none mr-0"
                    type="button"
                    :disabled="captchaNeedCheck"
                    @click="$parent.saveData()">
                <i class="icon-location"></i> {{ $parent.registerButtonTitle ?? 'Register' }}
            </button>
        </div>
    </div>
</template>

<script>
export default {
    name: 'Admin',
    data() {
        return {
            captchaImage: null
        }
    },
    mounted() {
        this.reloadCaptcha();
    },
    methods: {
        back() {
            this.$parent.step = "company";
        },
        reloadCaptcha() {
            axios.get('reload-captcha')
                .then(response => {
                    this.captchaImage = response.data.captcha;
                })
                .catch((err) => {
                    ShowNotification('error', 'Registration', err.response.data.message ?? 'The given data is invalid.');
                    this.validationErrors = err.response.data.errors;
                    console.error(err);
                });
        }
    },
    computed: {
        captchaNeedCheck() {
            if (this.$parent.captchaVerificationEnabled) {
                if (this.$parent.form.captcha.length === 0) {
                    this.$parent.captchaVerified = false;
                    return true;
                }
                this.$parent.captchaVerified = true;
                return false;
            }

            return false;
        }
    }
}
</script>
<style>
.captcha-container {
    height: 60px !important;
}

.captcha-container > img {
    width: 100% !important;
    height: 100% !important;
    object-fit: contain;
}
</style>
