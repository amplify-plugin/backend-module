<template>
    <div role="tabpanel" class="tab-pane active" id="tab_basic-info">
        <div class="form-row">
            <!-- load the view from type and view_namespace attribute if set -->

            <!-- hidden input -->
            <div class="hidden">
                <input type="hidden" name="basic-info" value="" class="form-control" />
            </div>
            <!-- load the view from type and view_namespace attribute if set -->

            <!-- select from array -->
            <div
                class="form-group col-sm-12 col-lg-6"
                :class="{ 'text-danger': $parent.validationErrors.product_type }"
            >
                <label> Product Type <span class="text-danger font-weight-bold">*</span> </label>
                <select
                    name="product_type"
                    class="form-control"
                    v-model="$parent.productData.product_type"
                    :class="{ 'is-invalid': $parent.validationErrors.product_type }"
                >
                    <option :value="productType" v-for="(productType, index) in productTypesArray" :key="index">
                        {{ capitalizeFirstLetter(productType) }}
                    </option>
                </select>
                <small v-if="$parent.validationErrors.product_type" class="text-danger mt-3">{{
                    $parent.validationErrors.product_type[0]
                }}</small>
            </div>
            <!-- load the view from type and view_namespace attribute if set -->

            <!-- text input -->
            <div
                class="form-group col-sm-12 col-lg-6"
                :class="{ 'text-danger': $parent.validationErrors.product_name }"
            >
                <label>
                    Product Name
                    <span v-if="checkIfProductFieldIsRequired('product_name')" class="text-danger font-weight-bold">*</span>
                </label>
                <i
                    class="las la-info-circle pull-right"
                    style="margin-top: 3px"
                    title="Minimum product name length is 5 characters and Maximum product name length is 255 characters"
                ></i>
                <i
                    class="la la-flag-checkered pull-right"
                    style="margin-top: 3px"
                    title="This field is translatable."
                ></i>
                <input
                    @input="
                        removeError('product_name');
                        $parent.convertNameToSlug($parent.productData.local_product_name);
                    "
                    :required="checkIfProductFieldIsRequired('product_name')"
                    type="text"
                    name="product_name"
                    placeholder="Enter product name"
                    v-model="$parent.productData.local_product_name"
                    class="form-control"
                    :class="{ 'is-invalid': $parent.validationErrors.product_name }"
                />
                <small v-if="$parent.validationErrors.product_name" class="text-danger mt-3">{{
                    $parent.validationErrors.product_name[0]
                }}</small>
            </div>
            <!-- load the view from type and view_namespace attribute if set -->

            <div v-if="$parent.productData.product_type == 'normal'" class="form-group col-sm-12">
                <div class="row">
                    <div class="col-12 col-xl-3 col-xxl-2">
                        <div class="checkbox my-0 my-lg-2">
                            <input id="has_sku" type="checkbox" v-model="$parent.productData.has_sku" />
                            <label for="has_sku" class="form-check-label font-weight-normal"
                                >Has SKUs <span class="text-danger font-weight-bold">*</span>
                            </label>
                        </div>
                    </div>
                    <div class="col-12 col-xl-9 col-xxl-10">
                        <div v-if="$parent.productData.has_sku">
                            <multiselect
                                :class="{ 'is-invalid': $parent.validationErrors.sku_default_attributes }"
                                v-model="$parent.productData.sku_default_attributes"
                                :options="$parent.allAttributes"
                                :multiple="true"
                                :close-on-select="false"
                                :clear-on-select="false"
                                :preserve-search="true"
                                :hide-selected="true"
                                placeholder="Pick some Attributes"
                                label="local_name"
                                track-by="local_name"
                            >
                                <!-- <template slot="selection">
                                    <span
                                    class="multiselect__single"
                                        v-if="$parent.validationErrors.sku_default_attributes" >
                                        {{ $parent.validationErrors.sku_default_attributes[0] }}
                                    </span>
                                </template> -->
                            </multiselect>
                            <small v-if="$parent.validationErrors.sku_default_attributes" class="text-danger mt-3">{{
                                $parent.validationErrors.sku_default_attributes[0]
                            }}</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- text input -->
            <div
                class="form-group col-sm-12 col-lg-6"
                :class="{ 'text-danger': $parent.validationErrors.product_code }"
            >
                <label>
                    Product Code
                    <span v-if="checkIfProductFieldIsRequired('product_code')" class="text-danger font-weight-bold">*</span>
                </label>
                <i
                    class="las la-info-circle pull-right"
                    style="margin-top: 3px"
                    title="Minimum product code length is 5 characters and Maximum product code length is 20 characters"
                ></i>
                <input
                    @input="removeError('product_code')"
                    type="text"
                    :required="checkIfProductFieldIsRequired('product_code')"
                    name="product_code"
                    placeholder="Enter product code"
                    v-model="$parent.productData.product_code"
                    class="form-control"
                    :class="{ 'is-invalid': $parent.validationErrors.product_code }"
                />
                <small v-if="$parent.validationErrors.product_code" class="text-danger mt-3">{{
                    $parent.validationErrors.product_code[0]
                }}</small>
            </div>

            <!-- selectTree -->
            <div
                class="form-group col-sm-12 col-lg-6"
                v-if="$parent.productData.product_type !== 'bundle'"
                :class="{
                    'text-danger':
                        $parent.validationErrors.product_classifications ||
                        $parent.validationErrors.product_classification_id,
                }"
            >
                <label>
                    Product Classification
                    <span v-if="checkIfProductFieldIsRequired('product_classification_id')" class="text-danger font-weight-bold"
                        >*</span
                    >
                </label>
                <div>
                    <treeselect
                        @close="$parent.classificationChanged = true"
                        @select="removeError('product_classification_id')"
                        :class="{
                            'is-invalid':
                                $parent.validationErrors.product_classifications ||
                                $parent.validationErrors.product_classification_id,
                        }"
                        :multiple="false"
                        :required="checkIfProductFieldIsRequired('product_classification_id')"
                        name="product_classification_id"
                        placeholder="Select a classification"
                        :options="$parent.productClassifications"
                        v-model="$parent.productData.product_classification_id"
                    />
                    <small v-if="$parent.validationErrors.product_classifications" class="text-danger mt-3">{{
                        $parent.validationErrors.product_classifications[0]
                    }}</small>
                    <small v-if="$parent.validationErrors.product_classification_id" class="text-danger mt-3">{{
                        $parent.validationErrors.product_classification_id[0]
                    }}</small>
                </div>
            </div>

            <!-- Tiny MCE -->
            <div class="form-group col-sm-12" :class="{ 'text-danger': $parent.validationErrors.short_description }">
                <label>
                    Product Short Description
                    <span v-if="checkIfProductFieldIsRequired('short_description')" class="text-danger font-weight-bold">*</span>
                </label>
                <i
                    class="la la-flag-checkered pull-right"
                    style="margin-top: 3px"
                    title="This field is translatable."
                ></i>
                <ckeditor
                    v-model="$parent.productData.local_short_description"
                    :class="{ 'is-invalid': $parent.validationErrors.short_description }"
                ></ckeditor>
                <small v-if="$parent.validationErrors.short_description" class="text-danger mt-3">{{
                    $parent.validationErrors.short_description[0]
                }}</small>
            </div>

            <!-- Tiny MCE -->
            <div class="form-group col-sm-12" :class="{ 'text-danger': $parent.validationErrors.description }">
                <label>
                    Product Description
                    <span v-if="checkIfProductFieldIsRequired('description')" class="text-danger font-weight-bold">*</span>
                </label>
                <i
                    class="la la-flag-checkered pull-right"
                    style="margin-top: 3px"
                    title="This field is translatable."
                ></i>
                <ckeditor
                    v-model="$parent.productData.local_description"
                    :class="{ 'is-invalid': $parent.validationErrors.description }"
                ></ckeditor>
                <small v-if="$parent.validationErrors.description" class="text-danger mt-3">{{
                    $parent.validationErrors.description[0]
                }}</small>
            </div>

            <div class="form-group col-sm-12 col-lg-6">
                <label>Prop 65 Message</label>
                <textarea
                    class="form-control"
                    id="prop65_message"
                    v-model="$parent.productData.prop65_message"
                    placeholder="Prop 65 Message"
                ></textarea>
            </div>

            <div class="form-group col-sm-12 col-lg-6" :class="{ 'text-danger': $parent.validationErrors.categories }">
                <label>
                    Categories
                    <span v-if="checkIfProductFieldIsRequired('categories')" class="text-danger font-weight-bold">*</span>
                </label>
                <div>
                    <treeselect
                        :class="{ 'is-invalid': $parent.validationErrors.categories }"
                        name="productDataCategories"
                        placeholder="Select categories"
                        :multiple="true"
                        :required="checkIfProductFieldIsRequired('categories')"
                        @select="removeError('categories')"
                        :options="$parent.categories"
                        :value-consists-of="'ALL'"
                        v-model="$parent.productDataCategories"
                    />
                    <small v-if="$parent.validationErrors.categories" class="text-danger mt-3">
                        {{ $parent.validationErrors.categories[0] }}
                    </small>
                </div>
            </div>
            <!-- :value-consists-of="'ALL'"  -->

            <div class="form-group col-sm-12 col-lg-6">
                <label>Brand</label>
                <div>
                    <treeselect
                        :multiple="false"
                        name="brand_id"
                        placeholder="Select a Brand"
                        :options="$parent.brands"
                        v-model="$parent.productData.brand_id"
                    />
                </div>
            </div>


            <!-- number input -->
            <div class="form-group col-sm-12 col-lg-6" :class="{ 'text-danger': $parent.validationErrors.ean_number }">
                <label>EAN Number</label>
                <i
                    class="las la-info-circle pull-right"
                    style="margin-top: 3px"
                    title="The EAN number must be 13 digits"
                ></i>
                <input
                    type="number"
                    name="ean_number"
                    v-model="$parent.productData.ean_number"
                    class="form-control"
                    placeholder="Enter EAN number"
                    :class="{ 'is-invalid': $parent.validationErrors.ean_number }"
                />
                <small v-if="$parent.validationErrors.ean_number" class="text-danger mt-3">{{
                    $parent.validationErrors.ean_number[0]
                }}</small>
            </div>

            <!-- text input -->
            <div class="form-group col-sm-12 col-lg-6" :class="{ 'text-danger': $parent.validationErrors.gtin_number }">
                <label>GTIN Number</label>
                <i
                    class="las la-info-circle pull-right"
                    style="margin-top: 3px"
                    title="The GTIN number must be of 8, 12, 13 or 14 characters"
                ></i>
                <input
                    type="text"
                    name="gtin_number"
                    v-model="$parent.productData.gtin_number"
                    class="form-control"
                    placeholder="Enter GTIN number"
                    :class="{ 'is-invalid': $parent.validationErrors.gtin_number }"
                />
                <small v-if="$parent.validationErrors.gtin_number" class="text-danger mt-3">{{
                    $parent.validationErrors.gtin_number[0]
                }}</small>
            </div>

            <!-- number input -->
            <div class="form-group col-sm-12 col-lg-6" :class="{ 'text-danger': $parent.validationErrors.upc_number }">
                <label>UPC Number</label>
                <i
                    class="las la-info-circle pull-right"
                    style="margin-top: 3px"
                    title="The UPC number must be 12 digits"
                ></i>
                <input
                    type="number"
                    name="upc_number"
                    v-model="$parent.productData.upc_number"
                    class="form-control"
                    placeholder="Enter UPC number"
                    :class="{ 'is-invalid': $parent.validationErrors.upc_number }"
                />
                <small v-if="$parent.validationErrors.upc_number" class="text-danger mt-3">{{
                    $parent.validationErrors.upc_number[0]
                }}</small>
            </div>

            <!-- text input -->
            <div class="form-group col-sm-12 col-lg-6" :class="{ 'text-danger': $parent.validationErrors.asin }">
                <label>ASIN</label>
                <i
                    class="las la-info-circle pull-right"
                    style="margin-top: 3px"
                    title="The ASIN number must be 10 characters"
                ></i>
                <input
                    type="text"
                    name="asin"
                    v-model="$parent.productData.asin"
                    class="form-control"
                    placeholder="Enter ASIN number"
                    :class="{ 'is-invalid': $parent.validationErrors.asin }"
                />
                <small v-if="$parent.validationErrors.asin" class="text-danger mt-3">{{
                    $parent.validationErrors.asin[0]
                }}</small>
            </div>

            <!-- text input -->
            <div
                class="form-group col-sm-12 col-lg-6"
                :class="{ 'text-danger': $parent.validationErrors.manufacturer }"
            >
                <label>Manufacturer Part Number</label>
                <i
                    class="las la-info-circle pull-right"
                    style="margin-top: 3px"
                    title="Minimum manufacturer part number length is 2 characters and Maximum manufacturer part number length is 80 characters"
                ></i>
                <input
                    type="text"
                    name="manufacturer"
                    v-model="$parent.productData.manufacturer"
                    class="form-control"
                    placeholder="Enter manufacturer part number"
                    :class="{ 'is-invalid': $parent.validationErrors.manufacturer }"
                />
                <small v-if="$parent.validationErrors.manufacturer" class="text-danger mt-3">{{
                    $parent.validationErrors.manufacturer[0]
                }}</small>
            </div>

            <div class="form-group col-sm-12 col-lg-6">
                <label>Model Codes</label>

                <vSelect
                    :options="options"
                    @search="fetchOptions"
                    v-model="$parent.productData.model_codes"
                    :class="{ 'is-invalid': $parent.validationErrors.model_codes }"
                    placeholder="Enter Model Codes"
                    multiple
                >
                    <template slot="no-options">Enter Model Codes</template>
                </vSelect>

                <small v-if="$parent.validationErrors.model_codes" class="text-danger mt-3">{{
                    $parent.validationErrors.model_codes[0]
                }}</small>
            </div>

            <!-- text input -->
            <!-- <div class="form-group col-sm-12 col-lg-6" :class="{'text-danger': $parent.validationErrors.model_code}">
                <label>Model Code</label>
                <i class="las la-info-circle pull-right" style="margin-top: 3px;"
                   title="Minimum model code length is 2 characters and Maximum model code length is 80 characters"></i>
                <input type="text" name="model_code" v-model="$parent.productData.model_code" class="form-control" placeholder="Enter model code"
                       :class="{'is-invalid': $parent.validationErrors.model_code}">
                <small v-if="$parent.validationErrors.model_code"
                       class="text-danger mt-3">{{ $parent.validationErrors.model_code[0] }}</small>
            </div> -->

            <!-- text input -->
            <!-- <div class="form-group col-sm-12 col-lg-6" :class="{'text-danger': $parent.validationErrors.model_name}">
                <label>Model Name</label>
                <i class="las la-info-circle pull-right" style="margin-top: 3px;"
                   title="Minimum model name length is 2 characters and Maximum model name length is 80 characters"></i>
                <i class="la la-flag-checkered pull-right" style="margin-top: 3px;"
                   title="This field is translatable."></i>
                <input type="text" name="model_name" v-model="$parent.productData.local_model_name" class="form-control" placeholder="Enter model name" />
                <small v-if="$parent.validationErrors.model_name"
                       class="text-danger mt-3">{{ $parent.validationErrors.model_name[0] }}</small>
            </div> -->

            <!-- New fields -->

            <div class="form-group col-sm-12 col-lg-6" :class="{ 'text-danger': $parent.validationErrors.uom }">
                <label>UOM – Unit Of Measure</label>
                <i
                    class="las la-info-circle pull-right"
                    style="margin-top: 3px"
                    title="Maximum Unit Of Measure length is 20 characters"
                ></i>
                <input
                    type="text"
                    name="uom"
                    v-model="$parent.productData.uom"
                    class="form-control"
                    placeholder="Enter UOM"
                    :class="{ 'is-invalid': $parent.validationErrors.uom }"
                />
                <small v-if="$parent.validationErrors.uom" class="text-danger mt-3">{{
                    $parent.validationErrors.uom[0]
                }}</small>
            </div>

            <div class="form-group col-sm-12 col-lg-6" :class="{ 'text-danger': $parent.validationErrors.pack_size }">
                <label>Pack Size</label>
                <input
                    type="text"
                    name="pack_size"
                    v-model="$parent.productData.pack_size"
                    class="form-control"
                    placeholder="Eneter pack size"
                    :class="{ 'is-invalid': $parent.validationErrors.pack_size }"
                />
                <small v-if="$parent.validationErrors.pack_size" class="text-danger mt-3">{{
                    $parent.validationErrors.pack_size[0]
                }}</small>
            </div>

            <div class="form-group col-sm-12 col-lg-6">
                <div class="row">
                    <div class="col-md-6 checkbox my-0 my-md-2">
                        <input id="is_non_stock" type="checkbox" v-model="$parent.productData.is_non_stock" />
                        <label for="is_non_stock" class="form-check-label font-weight-normal">
                            <strong>Non-stock Item? </strong>
                        </label>
                    </div>
                    <div class="col-md-6 checkbox my-0 my-md-2" v-if="$parent.productData.is_non_stock === false">
                        <input id="in_stock" type="checkbox" v-model="$parent.productData.in_stock" />
                        <label for="in_stock" class="form-check-label font-weight-normal">
                            <strong>Item is available in Stock? </strong>
                        </label>
                    </div>
                    <div class="col-md-6 checkbox my-0 my-md-2">
                        <input id="is_ncnr" type="checkbox" v-model="$parent.productData.is_ncnr" />
                        <label for="is_ncnr" class="form-check-label font-weight-normal">
                            <strong>Is Non-Cancelable, Non-Returnable Item? </strong>
                        </label>
                    </div>
                    <div class="col-md-6 checkbox my-0 my-md-2">
                        <input id="allow_back_order" type="checkbox" v-model="$parent.productData.allow_back_order" />
                        <label for="allow_back_order" class="form-check-label font-weight-normal"
                            ><strong>Allow Back-order?</strong>
                        </label>
                    </div>
                </div>
            </div>

            <div class="form-group col-sm-12 col-lg-6">
                <label>Manufacturer</label>
                <div>
                    <treeselect
                        :multiple="false"
                        name="manufacturer_id"
                        placeholder="Select a manufacturer"
                        :options="$parent.manufacturers"
                        v-model="$parent.productData.manufacturer_id"
                    />
                </div>
            </div>

            <div class="form-group col-sm-12 col-lg-6" v-show="$parent.use_product_specific_detail_page">
                <label>Product Detail Page</label>
                <div class="d-block">
                    <multiselect
                        :options="$parent.allSingleProductPages"
                        v-model="$parent.productData.single_product_page"
                        :multiple="false"
                        :close-on-select="true"
                        :clear-on-select="false"
                        placeholder="Selct an Single Product Page Layout"
                        track-by="id"
                        label="name"
                    />
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Multiselect from 'vue-multiselect';
import Treeselect from '@riophae/vue-treeselect';
import '@riophae/vue-treeselect/dist/vue-treeselect.css';
import vSelect from 'vue-select';
import 'vue-select/dist/vue-select.css';

export default {
    name: 'BasicInfo',

    components: { Multiselect, Treeselect, vSelect },

    data() {
        return {
            productClassifications: [],
            categories: [],
            productTypesArray: ['normal', 'bundle', 'configurable'],
            options: [],
        };
    },

    mounted() {
        if (_.isEmpty(this.$parent.productData.product_type)) {
            this.$parent.productData.product_type = 'normal';
        }

        this.$parent.getDynamicCurrentPreviousTabIds();
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
            //remove classification error in special causes
            if (errorsObject['product_classifications']) {
                delete errorsObject['product_classifications'];
            }
            //for re-render parent component
            if (Object.keys(errorsObject).length <= 0) {
                this.$parent.validationErrors = '';
            }
            this.$parent.validationErrors = errorsObject;
        },

        checkIfProductFieldIsRequired(productFieldName) {
            return (
                this.$parent.coreConfigs.required_fields &&
                this.$parent.productMandatoryFields.includes(productFieldName)
            );
        },

        addTag(newTag) {
            const tag = {
                name: newTag,
                unique_slug: newTag.substring(0, 2) + Math.floor(Math.random() * 10000000),
            };
            this.enumOptions.push(tag);
        },

        fetchOptions(search, loading) {
            if (search.length) {
                loading(true);
                const vm = this;
                axios
                    .get('/mode-codes-search', {
                        params: {
                            search,
                        },
                    })
                    .then((response) => {
                        loading(false);
                        vm.options = response.data;
                    });
            }
        },
    },
};
</script>

<style>
.vue-treeselect .vue-treeselect__control,
.multiselect .multiselect__tags {
    height: 38px !important;
    border-radius: 4px !important;
    border: 1px solid rgba(0, 40, 100, 0.12) !important;
}

.vue-treeselect.is-invalid {
    border: 1px solid red;
    border-radius: 5px;
}

.multiselect .multiselect__tags {
    padding-top: 8px !important;
}

.required-custom {
    color: #ff0000;
}

.cke_contents {
    min-height: 300px !important;
}

.vue-treeselect__multi-value {
    margin-bottom: 8px;
}
</style>
