<template>
    <div role="tabpanel" class="tab-pane active" id="tab_basic-info">
        <fieldset>
            <div class="d-flex justify-content-between border-bottom pb-0 mb-3 mt-n3">
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
