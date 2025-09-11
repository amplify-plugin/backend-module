<template>
    <div role="tabpanel" class="tab-pane active" id="tab_basic-info">
        <fieldset>
            <div class="d-flex justify-content-between border-bottom pb-0 mb-3 mt-n3">
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
                    <br>
                    <a href="/admin/api-log" target="_blank">See Current Logs</a>
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
                    <br>
                    <a href="/admin/api-log" target="_blank">See Current Logs</a>
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
                    <br>
                    <a href="/admin/api-log" target="_blank">See Current Logs</a>
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
                    <br>
                    <a href="/admin/mail-log" target="_blank">See Current Logs</a>
                </small>
            </div>
            <div class="form-group">
                <label>System Error Notification Report</label>
                <table class="table table-striped table-hover table-sm">
                    <tr>
                        <th>Email</th>
                        <th>
                            <button
                                type="button"

                                role="button"
                                @click.prevent="() => coreConfigurationData.bug_recipient.push('')"
                                class="btn btn-sm btn-primary">
                                <b>+</b>
                            </button>
                        </th>
                    </tr>
                    <tr v-for="(email, index) in coreConfigurationData.bug_recipient" :key="index">
                        <td>
                            <input class="form-control form-control-sm"
                                   type="email"
                                   required
                                   min="5"
                                   max="255"
                                   v-model="coreConfigurationData.bug_recipient[index]"
                            >
                        </td>
                        <td>
                            <button
                                type="button"
                                role="button"
                                @click.prevent="() => coreConfigurationData.bug_recipient.splice(index,1)"
                                class="btn btn-sm btn-danger">
                                <b>-</b>
                            </button>
                        </td>
                    </tr>
                </table>
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
    name: "Developer",
    data() {
        return {
            coreConfigurationData: {
                tab: "developer",
                log_search: this.$parent.coreConfigurationData.log_search ?? false,
                log_payment: this.$parent.coreConfigurationData.log_payment ?? false,
                log_erp_api: this.$parent.coreConfigurationData.log_erp_api ?? false,
                log_email: this.$parent.coreConfigurationData.log_email ?? false,
                bug_recipient: this.$parent.coreConfigurationData.bug_recipient ?? [],
            }
        }
    }
}
</script>
