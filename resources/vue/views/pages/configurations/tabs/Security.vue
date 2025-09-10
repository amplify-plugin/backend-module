<template>
    <div role="tabpanel" class="tab-pane active" id="tab_basic-info">
        <fieldset>
            <div class="d-flex justify-content-between border-bottom pb-0 mb-3 mt-n3">
                <legend>
                    <i class="la la-exclamation-triangle mr-2"></i>
                    Security Configuration
                </legend>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-check">
                        <input
                            type="checkbox"
                            name="skip_contact_approval"
                            id="skip_contact_approval"
                            v-model="coreConfigurationData.skip_contact_approval"
                            :class="{
                                'is-invalid': $parent.validationErrors.skip_contact_approval,
                                'form-check-input': true,
                            }"
                        />
                        <label for="skip_contact_approval"
                            >Allow Contact to login after request account without Approval</label
                        >
                        <small v-if="$parent.validationErrors.skip_contact_approval" class="text-danger">{{
                            $parent.validationErrors.skip_contact_approval[0]
                        }}</small>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>System Password Minimum Length</label>
                        <input
                            type="number"
                            name="password_length"
                            placeholder="Password Length"
                            v-model="coreConfigurationData.password_length"
                            class="form-control"
                            :class="{ 'is-invalid': $parent.validationErrors.password_length }"
                        />
                    </div>
                </div>
            </div>
        </fieldset>
        <fieldset class="mt-3">
            <legend>
                <i class="la la-cookie mr-2"></i>
                GDPR Compliance Policy
            </legend>
            <div class="form-group">
                <label
                    >Cookie Consent Title
                    <span class="text-danger">*</span>
                </label>
                <input
                    type="text"
                    name="cookie_title"
                    placeholder="Cookie consent message title"
                    v-model="coreConfigurationData.cookie_title"
                    class="form-control"
                    :class="{ 'is-invalid': $parent.validationErrors.cookie_title }"
                />
            </div>
            <div class="form-group">
                <label>
                    Cookie Consent Content
                    <span class="text-danger">*</span>
                </label>
                <ckeditor
                    v-model="coreConfigurationData.cookie_content"
                    :class="{ 'is-invalid': coreConfigurationData.cookie_content }"
                ></ckeditor>
            </div>
        </fieldset>

        <div id="saveActions" class="form-group">
            <button @click="$parent.saveCoreConfigInfo(coreConfigurationData)" type="button" class="btn btn-success">
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
export default {
    name: 'Security',
    data() {
        return {
            coreConfigurationData: {
                tab: 'security',
                password_length: this.$parent.coreConfigurationData.security.password_length,
                cookie_title: this.$parent.coreConfigurationData.security.cookie_title,
                cookie_content: this.$parent.coreConfigurationData.security.cookie_content,
                skip_contact_approval: this.$parent.coreConfigurationData.security.skip_contact_approval,
            },
        };
    },
};
</script>
