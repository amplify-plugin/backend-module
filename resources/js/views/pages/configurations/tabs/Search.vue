<template>
    <div role="tabpanel" class="tab-pane active" id="tab_basic-info">
        <fieldset>
            <div class="d-flex justify-content-between border-bottom pb-0 mb-3 mt-n3">
                <legend>
                    <i class="la la-search mr-2"></i>
                    EasyAsk Search Configuration
                </legend>
                <div class="d-md-none custom-sidebar-ar" @click="$parent.toggleSidebar()">
                    <div class="menu-icon-ar">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="24"
                            height="24"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="#1b2a4e"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            class="feather feather-menu"
                        >
                            <line x1="3" y1="12" x2="21" y2="12"></line>
                            <line x1="3" y1="6" x2="21" y2="6"></line>
                            <line x1="3" y1="18" x2="21" y2="18"></line>
                        </svg>
                    </div>
                    <div class="close-icon-ar">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="24"
                            height="24"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="red"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            class="feather feather-x"
                        >
                            <line x1="18" y1="6" x2="6" y2="18"></line>
                            <line x1="6" y1="6" x2="18" y2="18"></line>
                        </svg>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label>Easyask Product Search By Id Prefix</label>
                <input
                    type="text"
                    name="product_search_by_id_prefix"
                    placeholder="Enter Product Prefix"
                    v-model="coreConfigurationData.product_search_by_id_prefix"
                    class="form-control"
                    :class="{ 'is-invalid': $parent.validationErrors.product_search_by_id_prefix }"
                />
                <small v-if="$parent.validationErrors.product_search_by_id_prefix" class="text-danger mt-3">{{
                    $parent.validationErrors.product_search_by_id_prefix[0]
                }}</small>
            </div>
            <div class="form-group">
                <label>EasyAsk Host Protocol</label>
                <select
                    name="protocol"
                    class="form-control custom-select"
                    :class="{ 'is-invalid': $parent.validationErrors.protocol }"
                    v-model="coreConfigurationData.protocol"
                >
                    <option value="http">Http</option>
                    <option value="https">Https</option>
                </select>
                <small v-if="$parent.validationErrors.protocol" class="text-danger mt-3">{{
                    $parent.validationErrors.protocol[0]
                }}</small>
            </div>
            <div class="form-group">
                <label>EasyAsk Host</label>
                <input
                    type="text"
                    name="easyask_host"
                    placeholder="Enter Easy Host"
                    v-model="coreConfigurationData.easyask_host"
                    class="form-control"
                    :class="{ 'is-invalid': $parent.validationErrors.easyask_host }"
                />
                <small v-if="$parent.validationErrors.easyask_host" class="text-danger mt-3">{{
                    $parent.validationErrors.easyask_host[0]
                }}</small>
            </div>
            <div class="form-group">
                <label>EasyAsk Port</label>
                <input
                    type="text"
                    name="easyask_port"
                    placeholder="Enter Port"
                    v-model="coreConfigurationData.easyask_port"
                    class="form-control"
                    :class="{ 'is-invalid': $parent.validationErrors.easyask_port }"
                />
                <small v-if="$parent.validationErrors.easyask_port" class="text-danger mt-3">{{
                    $parent.validationErrors.easyask_port[0]
                }}</small>
            </div>
            <div class="form-group">
                <label>EasyAsk Dictionary</label>
                <input
                    type="text"
                    name="easyask_dictionary"
                    placeholder="Enter EasyAsk Dictionary"
                    v-model="coreConfigurationData.easyask_dictionary"
                    class="form-control"
                    :class="{ 'is-invalid': $parent.validationErrors.easyask_dictionary }"
                />
                <small v-if="$parent.validationErrors.easyask_dictionary" class="text-danger mt-3">{{
                    $parent.validationErrors.easyask_dictionary[0]
                }}</small>
            </div>
            <div class="form-group">
                <label>Search box placeholder</label>
                <input
                    type="text"
                    name="search_box_placeholder"
                    placeholder="Enter Search box placeholder text"
                    v-model="coreConfigurationData.search_box_placeholder"
                    class="form-control"
                    :class="{ 'is-invalid': $parent.validationErrors.search_box_placeholder }"
                />
                <small v-if="$parent.validationErrors.search_box_placeholder" class="text-danger mt-3">{{
                    $parent.validationErrors.search_box_placeholder[0]
                }}</small>
            </div>

            <div class="form-group">
                <label>Default Catalog</label>
                <select
                    name="default_catalog"
                    class="form-control custom-select"
                    :class="{ 'is-invalid': $parent.validationErrors.default_catalog }"
                    v-model="coreConfigurationData.default_catalog"
                >
                    <option value="" :selected="coreConfigurationData.default_catalog != null" disabled>
                        Select an Catalog
                    </option>
                    <option v-for="(catalog, index) in catalogs" :key="index" :value="catalog.id">
                        {{ catalog.name }}
                    </option>
                </select>
                <small v-if="$parent.validationErrors.default_catalog" class="text-danger mt-3">{{
                    $parent.validationErrors.default_catalog[0]
                }}</small>
            </div>

            <div class="form-group">
                <input
                    type="checkbox"
                    name="use_product_restriction"
                    id="use_product_restriction"
                    v-model="coreConfigurationData.use_product_restriction"
                    :class="{ 'is-invalid': $parent.validationErrors.use_product_restriction }"
                />
                <label for="use_product_restriction">Use Product Restriction Control</label>
                <small v-if="$parent.validationErrors.use_product_restriction" class="text-danger mt-3">{{
                        $parent.validationErrors.use_product_restriction[0]
                    }}</small>
            </div>

            <div class="form-group">
                <input
                    type="checkbox"
                    name="logger_enabled"
                    id="payment_logger"
                    v-model="coreConfigurationData.logger_enabled"
                    :class="{ 'is-invalid': $parent.validationErrors.logger_enabled }"
                />
                <label for="payment_logger">Enable Search API Log</label>
                <small v-if="$parent.validationErrors.logger_enabled" class="text-danger mt-3">{{
                    $parent.validationErrors.logger_enabled[0]
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
export default {
    name: 'Search',
    data() {
        return {
            catalogs: JSON.parse(this.$parent.catalogs),
            coreConfigurationData: {
                tab: 'search',
                product_search_by_id_prefix: this.$parent.coreConfigurationData.search.product_search_by_id_prefix,
                protocol: this.$parent.coreConfigurationData.search.protocol,
                easyask_host: this.$parent.coreConfigurationData.search.easyask_host,
                easyask_port: this.$parent.coreConfigurationData.search.easyask_port,
                easyask_dictionary: this.$parent.coreConfigurationData.search.easyask_dictionary,
                logger_enabled: this.$parent.coreConfigurationData.search.logger_enabled,
                use_product_restriction: this.$parent.coreConfigurationData.search.use_product_restriction,
                search_box_placeholder: this.$parent.coreConfigurationData.search.search_box_placeholder,
                default_catalog: this.$parent.coreConfigurationData.search.default_catalog,
            },
        };
    },
};
</script>
