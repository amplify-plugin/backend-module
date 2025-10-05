<template>
    <div role="tabpanel" class="tab-pane active"
         id="tab_basic-info">
        <fieldset>
            <legend>
                <i class="la la-search mr-2"></i>
                EasyAsk Search Configuration
            </legend>
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
        </fieldset>
        <fieldset>
            <div class="d-flex justify-content-between border-bottom pb-0 mb-3 mt-n3">
                <legend>
                    <i class="la la-search-plus mr-2"></i>
                    Search As You Type (SAYT) Configuration
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
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Product ID</label>
                        <input type="text" name="sayt_product_id" placeholder="Enter product Id"
                               v-model="coreConfigurationData.sayt_product_id" class="form-control"
                               :class="{ 'is-invalid': $parent.validationErrors.sayt_product_id }">
                        <small v-if="$parent.validationErrors.sayt_product_id" class="text-danger mt-3">{{
                                $parent.validationErrors.sayt_product_id[0]
                            }}</small>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Product Image</label>
                        <input type="text" name="sayt_product_image" placeholder="Enter product Image"
                               v-model="coreConfigurationData.sayt_product_image" class="form-control"
                               :class="{ 'is-invalid': $parent.validationErrors.sayt_product_image }">
                        <small v-if="$parent.validationErrors.sayt_product_image" class="text-danger mt-3">{{
                                $parent.validationErrors.sayt_product_image[0]
                            }}</small>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Product Name</label>
                        <input type="text" name="sayt_product_name" placeholder="Enter product name"
                               v-model="coreConfigurationData.sayt_product_name" class="form-control"
                               :class="{ 'is-invalid': $parent.validationErrors.sayt_product_name }">
                        <small v-if="$parent.validationErrors.sayt_product_name" class="text-danger mt-3">{{
                                $parent.validationErrors.sayt_product_name[0]
                            }}</small>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Product Code</label>
                        <input type="text" name="sayt_product_code" placeholder="Enter product code"
                               v-model="coreConfigurationData.sayt_product_code" class="form-control"
                               :class="{ 'is-invalid': $parent.validationErrors.sayt_product_code }">
                        <small v-if="$parent.validationErrors.sayt_product_code" class="text-danger mt-3">
                            {{$parent.validationErrors.sayt_product_code[0]
                            }}
                        </small>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Product Price</label>
                        <input type="text" name="sayt_product_price" placeholder="Enter product price"
                               v-model="coreConfigurationData.sayt_product_price" class="form-control"
                               :class="{ 'is-invalid': $parent.validationErrors.sayt_product_price }">
                        <small v-if="$parent.validationErrors.sayt_product_price" class="text-danger mt-3">{{
                                $parent.validationErrors.sayt_product_price[0]
                            }}</small>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Product Description</label>
                        <input type="text" name="sayt_product_description"
                               placeholder="Enter product description"
                               v-model="coreConfigurationData.sayt_product_description" class="form-control"
                               :class="{ 'is-invalid': $parent.validationErrors.sayt_product_description }">
                        <small v-if="$parent.validationErrors.sayt_product_description"
                               class="text-danger mt-3">{{
                                $parent.validationErrors.sayt_product_description[0]
                            }}</small>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Product Type</label>
                        <input type="text" name="sayt_product_type" placeholder="Enter product type"
                               v-model="coreConfigurationData.sayt_product_type" class="form-control"
                               :class="{ 'is-invalid': $parent.validationErrors.sayt_product_type }">
                        <small v-if="$parent.validationErrors.sayt_product_type" class="text-danger mt-3">{{
                                $parent.validationErrors.sayt_product_type[0]
                            }}</small>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Product Sizes</label>
                        <input type="text" name="sayt_product_sizes" placeholder="Enter product size"
                               v-model="coreConfigurationData.sayt_product_sizes" class="form-control"
                               :class="{ 'is-invalid': $parent.validationErrors.sayt_product_sizes }">
                        <small v-if="$parent.validationErrors.sayt_product_sizes" class="text-danger mt-3">{{
                                $parent.validationErrors.sayt_product_sizes[0]
                            }}</small>
                    </div>
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
export default {
    name: "Sayt",
    data() {
        return {
            catalogs: JSON.parse(this.$parent.catalogs),
            coreConfigurationData: {
                tab: "sayt",
                sayt_product_id: this.$parent.coreConfigurationData.sayt.sayt_product_id,
                sayt_product_image: this.$parent.coreConfigurationData.sayt.sayt_product_image,
                sayt_product_name: this.$parent.coreConfigurationData.sayt.sayt_product_name,
                sayt_product_code: this.$parent.coreConfigurationData.sayt.sayt_product_code,
                sayt_product_price: this.$parent.coreConfigurationData.sayt.sayt_product_price,
                sayt_product_description: this.$parent.coreConfigurationData.sayt.sayt_product_description,
                sayt_product_type: this.$parent.coreConfigurationData.sayt.sayt_product_type,
                sayt_product_sizes: this.$parent.coreConfigurationData.sayt.sayt_product_sizes,
                product_search_by_id_prefix: this.$parent.coreConfigurationData.sayt.product_search_by_id_prefix,
                search_box_placeholder: this.$parent.coreConfigurationData.sayt.search_box_placeholder,
                default_catalog: this.$parent.coreConfigurationData.sayt.default_catalog,
                use_product_restriction: this.$parent.coreConfigurationData.sayt.use_product_restriction,
            }
        }
    },

    mounted() {

    },

    methods: {},
}
</script>
