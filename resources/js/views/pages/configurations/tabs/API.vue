<template>
    <div role="tabpanel" class="tab-pane active" id="tab_basic-info">
        <fieldset>
            <div class="d-flex justify-content-between border-bottom pb-0 mb-3 mt-n3">
                <legend>
                    <i class="la la-accessible-icon mr-2"></i>
                    Amplify API Configuration
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
                <input type="checkbox" name="display_contact_id"
                       id="display_contact_id"
                       v-model="apiConfigurationData.contact_detail"
                       :class="{ 'is-invalid': $parent.validationErrors.contact_detail }">
                <label for="display_contact_id">Enable Contact Detail API</label>
                <div v-if="apiConfigurationData.contact_detail === true">
                    <select class="form-control custom-select" v-model="apiConfigurationData.contact_id_key">
                        <option value="" disabled>Select an Contact Search Field</option>
                        <option v-for="(label, code) in apiConfigurationData.contact_id_options"
                                :key="code"
                                :selected="code === apiConfigurationData.contact_id_key"
                                :value="code">
                            {{ label }}
                        </option>
                    </select>
                </div>
                <small v-if="$parent.validationErrors.contact_detail" class="text-danger mt-3">
                    {{ $parent.validationErrors.contact_detail[0] }}
                </small>
            </div>

        </fieldset>
        <div id="saveActions" class="form-group">
            <button @click="$parent.saveCoreConfigInfo(apiConfigurationData)" type="button" class="btn btn-success">
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

export default {
    name: "API",

    components: {Multiselect},

    data() {
        return {
            apiConfigurationData: {
                tab: 'api',
                contact_detail: false,
                contact_id_key: 'id',
                contact_id_options: {}

            },
        }
    },

    mounted() {
        this.apiConfigurationData = this.$parent.coreConfigurationData.api;
        this.apiConfigurationData.tab = 'api';
    },
}
</script>

<style>
.multiselect .multiselect__tags {
    height: 38px !important;
    border-radius: 4px !important;
    border: 1px solid rgba(0, 40, 100, .12) !important;
}


.multiselect .multiselect__tags {
    padding-top: 8px !important;
}
</style>
