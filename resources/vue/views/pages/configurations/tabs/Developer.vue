<template>
    <div role="tabpanel" class="tab-pane active settings-pane" id="tab_basic-info">
        <fieldset class="settings-shell">
            <div class="settings-header d-flex justify-content-between border-bottom pb-0 mb-3 mt-n3">
                <legend>
                    <i class="la la-code mr-2"></i>
                    Developer Options
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

            <div class="toggle-grid">
                <div class="form-group">
                    <div class="form-check">
                        <input
                            class="form-check-input"
                            type="checkbox"
                            v-model="coreConfigurationData.log_search"
                            id="log_search"
                        />
                        <label class="form-check-label" for="log_search">
                            Enable Api Log of EasyAsk Search Calls
                        </label>
                    </div>
                    <small class="text-muted mt-2 d-block">
                        If enabled the system will log all the search call going to EasyAsk search.
                        <a href="/admin/api-log?group=" target="_blank">See Current Logs</a>
                    </small>
                </div>

                <div class="form-group">
                    <div class="form-check">
                        <input
                            class="form-check-input"
                            type="checkbox"
                            v-model="coreConfigurationData.log_payment"
                            id="log_payment"
                        />
                        <label class="form-check-label" for="log_payment">
                            Enable Api Log of Payment Gateway/ERP Calls
                        </label>
                    </div>
                    <small class="text-muted mt-2 d-block">
                        If enabled system will log all the payment gateways related api calls.
                        <a href="/admin/api-log?group=" target="_blank">See Current Logs</a>
                    </small>
                </div>

                <div class="form-group">
                    <div class="form-check">
                        <input
                            class="form-check-input"
                            type="checkbox"
                            v-model="coreConfigurationData.log_erp_api"
                            id="log_erp_api"
                        />
                        <label class="form-check-label" for="log_erp_api">
                            Enable API logs with ERP communication
                        </label>
                    </div>
                    <small class="text-muted mt-2 d-block">
                        If enabled system will log all the API calls goes to ERP for customer,
                        shipping and product related information.
                        <a href="/admin/api-log?group=" target="_blank">See Current Logs</a>
                    </small>
                </div>

                <div class="form-group">
                    <div class="form-check">
                        <input
                            class="form-check-input"
                            type="checkbox"
                            v-model="coreConfigurationData.log_email"
                            id="log_email"
                        />
                        <label class="form-check-label" for="log_email">
                            Enabled log of email notification.
                        </label>
                    </div>
                    <small class="text-muted mt-2 d-block">
                        If enabled system will log email notification and status when it was sent.
                        <a href="/admin/mail-log" target="_blank">See Current Logs</a>
                    </small>
                </div>

                <div class="form-group">
                    <div class="form-check">
                        <input
                            class="form-check-input"
                            type="checkbox"
                            v-model="coreConfigurationData.log_trace_parts_api"
                            id="log_trace_parts_api"
                        />
                        <label class="form-check-label" for="log_trace_parts_api">
                            Enabled log of trace-parts api.
                        </label>
                    </div>
                    <small class="text-muted mt-2 d-block">
                        If enabled system will log trace-parts api data.
                        <a href="/admin/api-log?group=api.navigator.traceparts.com" target="_blank">See Current Logs</a>
                    </small>
                </div>

                <div class="form-group">
                    <p class="text-muted mt-2 d-block mb-0">
                        <a href="/admin/env-variable" target="_blank">.ENV Variable Editor <code>(Developer and System Administrator Only)</code></a>
                    </p>
                </div>
            </div>

            <div class="form-group">
                <label>System Error Notification Report</label>
                <div class="table-responsive table-recipient">
                    <table class="table table-striped table-hover table-sm mb-0">
                        <tr>
                            <th>Email</th>
                            <th width="35">
                                <button
                                    type="button"
                                    style="width: 35px; height: 35px"
                                    role="button"
                                    @click.prevent="() => coreConfigurationData.bug_recipient.push('')"
                                    class="btn btn-sm btn-primary"
                                >
                                    <b>+</b>
                                </button>
                            </th>
                        </tr>
                        <tr v-for="(email, index) in coreConfigurationData.bug_recipient" :key="index">
                            <td>
                                <input class="form-control"
                                       type="email"
                                       required
                                       min="5"
                                       max="255"
                                       v-model="coreConfigurationData.bug_recipient[index]"
                                />
                            </td>
                            <td width="35">
                                <button
                                    type="button"
                                    role="button"
                                    style="width: 35px; height: 35px"
                                    @click.prevent="() => coreConfigurationData.bug_recipient.splice(index,1)"
                                    class="btn btn-sm btn-danger"
                                >
                                    <b>-</b>
                                </button>
                            </td>
                        </tr>
                    </table>
                </div>
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
    name: 'Developer',
    data() {
        return {
            systemConfiguration: this.$parent.coreConfigurationData,
            coreConfigurationData: {
                tab: 'developer',
                log_search: this.$parent.coreConfigurationData.developer.log_search ?? false,
                log_payment: this.$parent.coreConfigurationData.developer.log_payment ?? false,
                log_erp_api: this.$parent.coreConfigurationData.developer.log_erp_api ?? false,
                log_trace_parts_api: this.$parent.coreConfigurationData.developer.log_trace_parts_api ?? false,
                log_email: this.$parent.coreConfigurationData.developer.log_email ?? false,
                bug_recipient: this.$parent.coreConfigurationData.developer.bug_recipient ?? [],
            },
        };
    },
    mounted() {
        // console.log(this.systemConfiguration);
    },
};
</script>

<style scoped>
.settings-pane {
  padding: 1rem 0;
}

.settings-shell {
  border: 1px solid #e6ebf2;
  border-radius: 16px;
  padding: 1rem;
  background: #f7fafc;
}

.settings-header {
  border-bottom: 1px solid #e7edf5 !important;
  margin: -0.2rem -0.2rem 0.7rem !important;
  padding: 0.2rem 0.2rem 0.6rem !important;
}

.settings-header legend,
.settings-shell legend {
  margin: 0;
  color: #1f2a44;
  font-size: 1.2rem;
  font-weight: 600;
}

.toggle-grid {
  display: grid;
  grid-template-columns: repeat(2, minmax(0, 1fr));
  gap: 0.7rem;
}

.form-group {
  background: #fff;
  border: 1px solid #e7edf5;
  border-radius: 12px;
  padding: 0.7rem;
  margin-bottom: 0.6rem;
}

.form-group > label,
.form-group label {
  color: #31415e;
  font-weight: 600;
  margin-bottom: 0.38rem;
}

.form-control,
.custom-select {
  border: 1px solid #d7dfec !important;
  border-radius: 10px !important;
  min-height: 36px;
  box-shadow: none !important;
}

.form-control:focus,
.custom-select:focus {
  border-color: #7aa7ff !important;
  box-shadow: 0 0 0 3px rgba(62, 125, 255, 0.12) !important;
}

.form-check {
  padding: 0.55rem 0.65rem !important;
  border: 1px solid #dbe5f0;
  border-radius: 10px;
  background: #fff;
}

.form-check-label {
  display: inline-flex;
  align-items: center;
  margin-bottom: 0;
}

.form-check-input,
input[type='checkbox'] {
  position: static;
  margin-left: 0;
  margin-right: 0.5rem;
}

.text-muted {
  color: #5f738f !important;
}

.table-recipient {
  border: 1px solid #d7dfec;
  border-radius: 10px;
  background: #fff;
}

.settings-actions {
  margin-top: 0.9rem;
  display: flex;
  align-items: center;
  gap: 0.6rem;
  border: 0;
  padding: 0;
  background: transparent;
}

@media (max-width: 991.98px) {
  .toggle-grid {
    grid-template-columns: 1fr;
  }

  .settings-shell {
    padding: 0.8rem;
  }
}
</style>
