<template>
    <div role="tabpanel" class="tab-pane active settings-pane" id="tab_basic-info">
        <fieldset class="settings-shell">
            <div class="settings-header d-flex justify-content-between border-bottom pb-0 mb-3 mt-n3">
                <legend>
                    <i class="la la-search mr-2"></i>
                    EasyAsk Report Configuration
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
                <label>Report Host Protocol</label>
                <select name="protocol" class="form-control custom-select"
                        :class="{ 'is-invalid': $parent.validationErrors.protocol }"
                        v-model="coreConfigurationData.protocol">
                    <option value="http">Http</option>
                    <option value="https">Https</option>
                </select>
                <small v-if="$parent.validationErrors.protocol" class="text-danger mt-3">{{
                        $parent.validationErrors.protocol[0]
                    }}</small>
            </div>
            <div class="form-group">
                <label>Report Host</label>
                <input type="text" name="easyask_host" placeholder="Enter Easy Host"
                       v-model="coreConfigurationData.host" class="form-control"
                       :class="{ 'is-invalid': $parent.validationErrors.host }">
                <small v-if="$parent.validationErrors.host" class="text-danger mt-3">{{
                        $parent.validationErrors.host[0]
                    }}</small>
            </div>
            <div class="form-group">
                <label>Report Port</label>
                <input type="text" name="easyask_port" placeholder="Enter Port"
                       v-model="coreConfigurationData.port" class="form-control"
                       :class="{ 'is-invalid': $parent.validationErrors.port }">
                <small v-if="$parent.validationErrors.port" class="text-danger mt-3">{{
                        $parent.validationErrors.port[0]
                    }}</small>
            </div>
            <div class="form-group">
                <label>Report Business Query Dictionary</label>
                <input type="text" name="easyask_business_query_dictionary" placeholder="Enter EasyAsk Business Query Dictionary"
                       v-model="coreConfigurationData.business_query_dictionary" class="form-control"
                       :class="{ 'is-invalid': $parent.validationErrors.business_query_dictionary }">
                <small v-if="$parent.validationErrors.business_query_dictionary" class="text-danger mt-3">{{
                        $parent.validationErrors.business_query_dictionary[0]
                    }}</small>
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
import '@riophae/vue-treeselect/dist/vue-treeselect.css';

export default {
    name: "Report",
    data() {
        return {
            productClassifications: [],
            categories: [],
            productTypesArray: ['normal', 'bundle', 'configurable'],
            coreConfigurationData: {
                tab: "report",
                protocol: this.$parent.coreConfigurationData.report.protocol,
                host: this.$parent.coreConfigurationData.report.host,
                port: this.$parent.coreConfigurationData.report.port,
                business_query_dictionary: this.$parent.coreConfigurationData.report.business_query_dictionary,
             }
        }
    },
}
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
