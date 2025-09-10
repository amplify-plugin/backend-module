<template>
    <div role="tabpanel" class="tab-pane active" id="tab_basic-info">
        <fieldset>
            <div class="d-flex justify-content-between border-bottom pb-0 mb-3 mt-n3">
                <legend>
                    <i class="la la-google mr-2"></i>
                    Google API/Tools Settings
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
                <div>
                    <label>Google Map API Key</label>
                    <input type="text" name="google_map_api_key" placeholder="Enter Google API Key"
                           v-model="coreConfigurationData.google_map_api_key" class="form-control"
                           :class="{ 'is-invalid': $parent.validationErrors.google_map_api_key }">
                    <small v-if="$parent.validationErrors.google_map_api_key" class="text-danger mt-3">{{
                            $parent.validationErrors.google_map_api_key[0]
                        }}</small>
                </div>

            </div>
            <div class="form-group">

                <div>
                    <label>Google Analytics ID</label>
                    <input type="text" name="google_analytics_id" placeholder="Enter Google Analytics ID"
                           v-model="coreConfigurationData.google_analytics_id" class="form-control"
                           :class="{ 'is-invalid': $parent.validationErrors.google_analytics_id }">
                    <small v-if="$parent.validationErrors.google_analytics_id" class="text-danger mt-3">{{
                            $parent.validationErrors.google_analytics_id[0]
                        }}</small>
                </div>

            </div>
            <div class="form-group">

                <div>
                    <label>Google Tag Manager ID</label>
                    <input type="text" name="google_tag_manager_id" placeholder="Google Tag Manager ID"
                           v-model="coreConfigurationData.google_tag_manager_id" class="form-control"
                           :class="{ 'is-invalid': $parent.validationErrors.google_tag_manager_id }">
                    <small v-if="$parent.validationErrors.google_tag_manager_id" class="text-danger mt-3">{{
                            $parent.validationErrors.google_tag_manager_id[0]
                        }}</small>
                </div>

            </div>
            <div class="form-group">

                <div>
                    <label>Google Analytics URL</label>
                    <input type="text" name="google_analytics_url" placeholder="Enter Google Analytics URL"
                           v-model="coreConfigurationData.google_analytics_url" class="form-control"
                           :class="{ 'is-invalid': $parent.validationErrors.google_analytics_url }">
                    <small v-if="$parent.validationErrors.google_analytics_url" class="text-danger mt-3">{{
                            $parent.validationErrors.google_analytics_url[0]
                        }}</small>
                </div>

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
import Multiselect from "vue-multiselect";
import Treeselect from "@riophae/vue-treeselect";

import '@riophae/vue-treeselect/dist/vue-treeselect.css';

export default {
    name: "Google",

    components: {Multiselect, Treeselect},

    data() {
        return {
            coreConfigurationData: {
                tab: "google",
                google_map_api_key: this.$parent.coreConfigurationData.google.google_map_api_key,
                google_analytics_id: this.$parent.coreConfigurationData.google.google_analytics_id,
                google_tag_manager_id: this.$parent.coreConfigurationData.google.google_tag_manager_id,
                google_analytics_url: this.$parent.coreConfigurationData.google.google_analytics_url
            }
        }
    },

    mounted() {
        // console.log(this.$parent.coreConfigurationData);
    },

    methods: {
        capitalizeFirstLetter(string) {
            return string.charAt(0).toUpperCase() + string.slice(1);
        },

        removeError(key) {
            let errorsObject = this.$parent.validationErrors;
            let errorExist = errorsObject[key];
            if (errorExist) {
                delete errorsObject[key];
            }
            //remove classfication error in sepecial causes
            if (errorsObject["product_classifications"]) {
                delete errorsObject["product_classifications"]
            }
            //for re-render parent component
            if (Object.keys(errorsObject).length <= 0) {
                this.$parent.validationErrors = "";
            }
            this.$parent.validationErrors = errorsObject;
        },

        checkIfProductFieldIsRequired(productFieldName) {
            return !!this.$parent.productMandatoryFields.includes(productFieldName);
        },

        addTag(newTag) {
            const tag = {
                name: newTag,
                unique_slug: newTag.substring(0, 2) + Math.floor((Math.random() * 10000000))
            }
            this.enumOptions.push(tag)
        },
    },
}
</script>
 