<template>
  <div role="tabpanel" class="tab-pane active settings-pane" id="tab_basic-info">
    <fieldset class="settings-shell">
      <div class="settings-header d-flex justify-content-between border-bottom pb-0 mb-3 mt-n3">
        <legend>
          <i class="la la-exclamation-triangle mr-2"></i>
          Security Configuration
        </legend>
      </div>
      <div class="form-group">
        <div class="form-check">
          <input
              type="checkbox"
              name="force_password_reset_enabled"
              id="force_password_reset_enabled"
              v-model="coreConfigurationData.force_password_reset_enabled"
              :class="{
                            'is-invalid': $parent.validationErrors.force_password_reset_enabled,
                            'form-check-input': true,
                        }"
          />
          <label for="force_password_reset_enabled"> Enable Force Password Reset</label>
          <small v-if="$parent.validationErrors.force_password_reset_enabled" class="text-danger mt-3">{{
              $parent.validationErrors.force_password_reset_enabled[0]
            }}</small>
        </div>
        <small class="text-muted d-block"
        >If enabled system will ask user to reset password, if changed by admin.</small
        >
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
        <div class="col-md-6" v-if="!coreConfigurationData.skip_contact_approval">
          <div class="form-group">
            <label>Account Verification Method</label>
            <select
                name="verification_method"
                v-model="coreConfigurationData.verification_method"
                :class="{ 'form-control': true, 'is-invalid': $parent.validationErrors.verification_method }">
              <option value="email" :selected="coreConfigurationData.verification_method === 'email'">
                Email Verification
              </option>
              <option value="backend" :selected="coreConfigurationData.verification_method === 'backend'">
                Admin Verification
              </option>
            </select>
            <small v-if="$parent.validationErrors.verification_method" class="text-danger">{{
                $parent.validationErrors.verification_method[0]
              }}</small>
          </div>
        </div>
        <div class="col-md-12">
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
    <fieldset class="settings-shell mt-3">
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

    <div id="saveActions" class="form-group settings-actions">
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
        verification_method: this.$parent.coreConfigurationData.security.verification_method,
        force_password_reset_enabled: this.$parent.coreConfigurationData.security.force_password_reset_enabled,
      },
    };
  },
};
</script>

<style scoped>
/* codex-basic-theme */
.settings-pane {
  padding: 1rem 0;
}

.settings-shell {
  border: 1px solid #e6ebf2;
  border-radius: 16px;
  padding: 1.25rem;
  background: #f7fafc;
  margin-bottom: 0.75rem;
}

.settings-header {
  border-bottom: 1px solid #e7edf5 !important;
}

.settings-header legend,
.settings-shell legend {
  margin: 0;
  color: #1f2a44;
  font-size: 1.2rem;
  font-weight: 600;
}

.settings-shell .form-group {
  background: #fff;
  border: 1px solid #e7edf5;
  border-radius: 12px;
  padding: 0.9rem;
}

.settings-shell .form-group > label,
.settings-shell .form-group label {
  color: #31415e;
  font-weight: 600;
  margin-bottom: 0.5rem;
}

.settings-shell .form-control,
.settings-shell .custom-select,
.settings-shell .multiselect .multiselect__tags,
.settings-shell .vue-treeselect .vue-treeselect__control {
  border: 1px solid #d7dfec !important;
  border-radius: 10px !important;
  min-height: 40px;
  box-shadow: none !important;
}

.settings-shell .form-control:focus,
.settings-shell .custom-select:focus,
.settings-shell .multiselect.multiselect--active .multiselect__tags {
  border-color: #7aa7ff !important;
  box-shadow: 0 0 0 3px rgba(62, 125, 255, 0.12) !important;
}

.settings-shell .multiselect .multiselect__tags {
  padding-top: 8px !important;
}

.settings-shell .form-check,
.settings-shell .custom-checkbox {
  padding: 0.68rem 0.78rem !important;
  border: 1px solid #dbe5f0;
  border-radius: 10px;
  background: #fff;
}

.settings-shell .form-check-label {
  display: inline-flex;
  align-items: center;
  margin-bottom: 0;
}

.settings-shell .form-check-input,
.settings-shell input[type='checkbox'] {
  position: static;
  margin-left: 0;
  margin-right: 0.5rem;
}

.settings-actions {
  margin-top: 1.2rem;
  display: flex;
  align-items: center;
  gap: 0.6rem;
  border: 0 !important;
  padding: 0 !important;
  background: transparent !important;
}

@media (max-width: 991.98px) {
  .settings-shell {
    padding: 1rem;
  }
}
</style>

<style scoped>
/* codex-spacing-fix */
.settings-shell {
  padding: 0.9rem !important;
  margin-bottom: 0.6rem !important;
}

.settings-header {
  margin: -0.2rem -0.2rem 0.7rem !important;
  padding: 0.2rem 0.2rem 0.6rem !important;
}

.settings-shell .form-row,
.settings-shell .row {
  margin-left: -0.35rem;
  margin-right: -0.35rem;
}

.settings-shell .form-row > [class*='col-'],
.settings-shell .row > [class*='col-'] {
  padding-left: 0.35rem;
  padding-right: 0.35rem;
}

.settings-shell .form-group {
  padding: 0.65rem !important;
  margin-bottom: 0.55rem !important;
}

.settings-shell .row .form-group,
.settings-shell .form-row .form-group {
  margin-bottom: 0.7rem !important;
}

.settings-shell .form-control,
.settings-shell .custom-select,
.settings-shell .multiselect .multiselect__tags {
  min-height: 36px !important;
}

.settings-shell .form-group > label,
.settings-shell .form-group label {
  margin-bottom: 0.38rem !important;
}

.settings-actions {
  margin-top: 0.8rem !important;
}

.settings-actions .btn {
  padding-top: 0.35rem;
  padding-bottom: 0.35rem;
}

@media (max-width: 991.98px) {
  .settings-shell {
    padding: 0.75rem !important;
  }

  .settings-shell .form-group {
    padding: 0.6rem !important;
  }
}
</style>
