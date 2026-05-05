<template>
    <div role="tabpanel" class="tab-pane active" id="tab_basic-info">
        <fieldset>
            <div class="d-flex justify-content-between border-bottom pb-0 mb-3 mt-n3">
                <legend>
                    <i class="la la-download mr-2"></i>
                    Export Configuration
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

        </fieldset>
        <div id="saveActions" class="form-group">

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <div>
                            <label>Export Max Limit</label>
                            <input type="text" name="export_max_limit" placeholder="Enter Export Max Limit"
                                v-model="coreConfigurationData.export_max_limit" class="form-control"
                                :class="{ 'is-invalid': $parent.validationErrors.export_max_limit }" />
                            <small v-if="$parent.validationErrors.export_max_limit" class="text-danger mt-3">{{
                                $parent.validationErrors.export_max_limit[0]
                            }}</small>
                        </div>
                    </div>
                </div>
            </div>

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
    name: 'Export',
    data() {
        return {
            pageData: [],
            coreConfigurationData: {
                tab: 'export',
            },
        };
    },

    mounted() {
        this.coreConfigurationData = this.$parent.coreConfigurationData.export;
        this.coreConfigurationData.tab = 'export';
    },
};
</script>
