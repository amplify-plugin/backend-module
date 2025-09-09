<template>
    <div class="row">
        <div :class="class_name">
            <!-- Default box -->
            <form method="post" @submit.prevent="" :action="backUrl">
                <div v-if="translation_enabled" class="mb-2 text-right">
                    <!-- Single button -->
                    <AvailableLocales
                        :availableLocales="availableLocales"
                        :activeTab="activeTab"
                        :queryString="query_string"
                        :current_lang="current_lang"
                        :url="url"
                    ></AvailableLocales>
                </div>

                <div v-if="Object.keys(validationErrors).length" class="alert alert-danger pb-0">
                    <ul class="list-unstyled">
                        <div v-for="single_errors in validationErrors">
                            <li v-for="error in single_errors">
                                <i class="la la-info-circle"></i>
                                {{ getErr(error) }}
                            </li>
                        </div>
                    </ul>
                </div>

                <div class="tab-container mb-2">
                    <Tabs :key="tabsRerender"></Tabs>

                    <div class="tab-content p-0">
                        <div class="nav-tabs-custom" id="form_tabs">
                            <component ref="component" :is="activeTab"></component>
                            <SwitchTabs ref="switchTabs" />
                        </div>
                    </div>
                </div>

                <input type="hidden" name="current_tab" value="basic-info" />

                <div id="saveActions" class="form-group">
                    <input type="hidden" name="save_action" v-model="actionType" />

                    <div class="btn-group" role="group">
                        <button type="submit" class="btn btn-success">
                            <span class="la la-save" role="presentation" aria-hidden="true"></span> &nbsp;
                            <span
                                @click="
                                    actionType = saveAction.active.value;
                                    saveProduct();
                                "
                                >{{ saveAction.active.label }}</span
                            >
                        </button>
                        <div class="btn-group" role="group">
                            <button
                                id="btnGroupDrop1"
                                type="button"
                                class="btn btn-success dropdown-toggle"
                                data-toggle="dropdown"
                                aria-haspopup="true"
                                aria-expanded="false"
                            >
                                <span class="caret"></span><span class="sr-only">▼</span>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                <template v-for="(option, index) in saveAction.options">
                                    <button
                                        class="dropdown-item"
                                        @click="
                                            actionType = index;
                                            saveProduct();
                                        "
                                    >
                                        {{ option }}
                                    </button>
                                </template>
                            </div>
                        </div>
                    </div>

                    <template v-if="published_before !== 'published'">
                        <button
                            @click="
                                actionType = 'save_and_back';
                                is_published = true;
                                productData.status = 'published';
                                saveProduct();
                            "
                            type="button"
                            class="btn btn-outline-success"
                        >
                            <span class="la la-upload" role="presentation" aria-hidden="true"></span> &nbsp;
                            <span data-value="save_and_edit"> Publish</span>
                        </button>

                        <button @click="saveAndAction('cancel')" type="button" class="btn btn-default">
                            <span class="la la-ban"></span> Cancel
                        </button>
                    </template>
                </div>
            </form>
        </div>

        <!-- Filemanager Modal -->
        <div id="fileManagerModalWrapper">
            <div
                class="modal"
                id="filemanagerModal"
                role="dialog"
                aria-labelledby="filemanagerModal"
                data-backdrop="static"
                data-keyboard="false"
                aria-modal="true"
                style="top: -10px !important"
            >
                <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content">
                        <!-- Modal Header -->
                        <div class="modal-header modal-moveable">
                            <h4 class="modal-title">File Manager</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>

                        <!-- Modal body -->
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-12">
                                    <file-manager ref="fileManager"></file-manager>
                                </div>
                                <div class="col-12">
                                    <div class="modal-header border-top rounded-0">
                                        <h4 class="modal-title">Selected File(s)</h4>
                                    </div>

                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="rounded">
                                                    <table
                                                        class="bg-white table table-striped table-hover nowrap rounded shadow-xs border-xs mt-2 dataTable dtr-inline"
                                                    >
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Path</th>
                                                                <th>View</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody
                                                            v-if="
                                                                typeof selectedFiles === 'object' &&
                                                                selectedFiles &&
                                                                selectedFiles.length
                                                            "
                                                        >
                                                            <tr v-for="(selectedFile, index) in selectedFiles">
                                                                <td>{{ index + 1 }}</td>
                                                                <td>{{ selectedFile }}</td>
                                                                <td class="py-1">
                                                                    <img
                                                                        :src="selectedFile"
                                                                        @error="$root.getDefaultImage"
                                                                        :alt="selectedFile"
                                                                        style="height: 47px"
                                                                    />
                                                                </td>
                                                                <td>
                                                                    <!-- remove path from selectedFiles -->
                                                                    <button
                                                                        type="button"
                                                                        class="btn btn-danger btn-sm"
                                                                        title="Remove"
                                                                        @click="
                                                                            $refs.component.removeSelectedFiles(index)
                                                                        "
                                                                    >
                                                                        <i class="la la-minus"></i>
                                                                    </button>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                        <tbody
                                                            v-else-if="
                                                                typeof selectedFiles === 'string' &&
                                                                selectedFiles &&
                                                                selectedFiles.length
                                                            "
                                                        >
                                                            <tr>
                                                                <td>{{ 1 }}</td>
                                                                <td>{{ selectedFiles }}</td>
                                                                <td class="py-1">
                                                                    <img
                                                                        :src="selectedFiles"
                                                                        @error="$root.getDefaultImage"
                                                                        :alt="selectedFiles"
                                                                        style="height: 47px"
                                                                    />
                                                                </td>
                                                                <td>
                                                                    <!-- remove path from selectedFiles -->
                                                                    <button
                                                                        type="button"
                                                                        class="btn btn-danger btn-sm"
                                                                        title="Remove"
                                                                        @click="selectedFiles = ''"
                                                                    >
                                                                        <i class="la la-minus"></i>
                                                                    </button>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                        <tbody v-else>
                                                            <tr>
                                                                <td colspan="100%" class="bg-light text-center">
                                                                    No files selected
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal footer -->
                        <div class="modal-footer modal-moveable">
                            <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            <div v-html="modalShade"></div>
        </div>
    </div>
</template>

<script>
import Tabs from './tabs/Tabs';
import Pricing from './tabs/Pricing';
import Products from './tabs/BundleProducts';
import BasicInfo from './tabs/BasicInfo';
// import Icecat from './tabs/IcecatInfo.vue';
import Media from './tabs/Media';
import Documents from './tabs/Documents';
import SEO from './tabs/SEO';
import Attributes from './tabs/attributes/Attributes';
import Options from './tabs/options/Options';
import SKUS from './tabs/skus/SKUS';
import AvailableLocales from '../../components/AvailableLocales';
import SwitchTabs from '../../components/SwitchTabs';
import _ from 'lodash';
import ExtraData from './tabs/ExtraData.vue';
import FeaturesAndSpecifications from './tabs/FeaturesAndSpecifications.vue';

export default {
    name: 'ProductCreate',

    props: [
        'class_name',
        'url',
        'translatable',
        'product_classification',
        'attributes',
        'translation_enabled',
        'available_locales',
        'current_lang',
        'method',
        'axios_url',
        'locale',
        'active_tab',
        'show_order_quantity_config_tab',
        'use_product_specific_detail_page',
        'query_string',
        'can_publish',
        'core_configs',
        'options',
        'product_mandatory_fields',
        'easy_ask_default_product_categories',
        'product',
        'sku_default_attributes',
        'customer_groups',
        'timezone',
        'default_datetime_format',
        'product_search_by_id_prefix',
        'all_manufacturers',
        'all_brands',
        'all_single_product_pages',
        'all_document_types',
        'accept_file_types',
        'product_documents',
        'fields',
        'use_minimum_order_quantity',
        'save_action',
        'published_status',
        'model_codes',
    ],

    components: {
        SwitchTabs,
        Tabs,
        Pricing,
        BasicInfo,
        Attributes,
        Media,
        AvailableLocales,
        SKUS,
        Products,
        Options,
        SEO,
        Documents,
        // Icecat,
        ExtraData,
        FeaturesAndSpecifications,
    },

    data() {
        return {
            saveAction: {
                active: {
                    value: 'save_and_back',
                    label: 'Save and back',
                },
                options: {
                    save_and_preview: 'Save and preview',
                    save_and_edit: 'Save and edit this item',
                    save_and_new: 'Save and new item',
                },
            },
            allFields: JSON.parse(this.fields),
            loadedModal: 'Loading modal...',
            modalShade: '',
            modalBody: 'Loading...',
            currentLang: this.current_lang,
            availableLocales: JSON.parse(this.available_locales),
            published_before: this.published_status,
            productData: {
                in_stock: false,
                is_ncnr: false,
                ...JSON.parse(this.product),
                selected_product_options: [],
                sku_default_attributes: JSON.parse(this.sku_default_attributes),
                productDocuments: JSON.parse(this.product_documents),
                model_codes: JSON.parse(this.model_codes),
                single_product_page: null,
            },
            coreConfigs: JSON.parse(this.core_configs),
            queryString: JSON.parse(this.query_string),
            activeModalId: '',
            allAttributes: [],
            classificationAttributes: JSON.parse(this.attributes),
            optionalSelectedAttributes: [],
            optionalAttributes: [],
            allOptions: [],
            classificationOptions: JSON.parse(this.options),
            optionalSelectedOptions: [],
            optionalOptions: [],
            removeOldAttributes: false,
            tabs: {},
            defaultTabs: {},
            otherTabs: {
                SKUS: { title: 'SKUS', hash: 'skus' },
                Products: { title: 'Products', hash: 'products' },
                Options: { title: 'Options', hash: 'options' },
            },
            activeTab: _.cloneDeep(this.active_tab),
            product_classification_id: null,
            productClassifications: [],
            categories: [],
            productDataCategories: [],
            category_id: [],
            validationErrors: {},
            actionType: 'save_and_edit',
            productImageUrl: '/admin/product-image',
            backUrl: '/admin/product',
            createNew: '/admin/product/create',
            is_published: false,
            tabsRerender: 0,
            removeThese: {
                text: [],
                integer: [],
                boolean: [],
                decimal: [],
                enums: [],
                date: [],
            },
            customer_group_price_list: [],
            productMandatoryFields: JSON.parse(this.product_mandatory_fields),
            easyAskDefaultProductCategories: JSON.parse(this.easy_ask_default_product_categories),
            currentPreviousTabs: {
                current_tab_id: '',
                previous_tab_id: '',
            },
            selectedFiles: [],
            manufacturers: [],
            brands: [],
            timer: null,
            allSingleProductPages: JSON.parse(this.all_single_product_pages),
            allDocumentTypes: JSON.parse(this.all_document_types),
            selectedDocumentTypes: [],
            useMinimumOrderQuantity: !!this.use_minimum_order_quantity,
        };
    },

    mounted() {
        this.init();

        if (_.isNull(this.productData.product_slug)) {
            this.convertNameToSlug(this.productData.local_product_name ?? '');
        }
    },

    methods: {
        getAllTabs() {
            let tabs = {
                BasicInfo: { title: 'Basic Info', hash: 'basic-info', hasError: false },
                Attributes: { title: 'Attributes', hash: 'attributes', hasError: false },
                Pricing: { title: 'Pricing', hash: 'pricing', hasError: false },
                Media: { title: 'Media', hash: 'media', hasError: false },
                Documents: { title: 'Documents', hash: 'documents', hasError: false },
                SEO: { title: 'SEO', hash: 'seo', hasError: false },
                // Icecat: { title: 'Icecat Info', hash: 'icecat', hasError: false },
                FeaturesAndSpecifications: {
                    title: 'Features & Specifications',
                    hash: 'features-and-specifications',
                    hasError: false,
                },
            };

            if (this.show_order_quantity_config_tab) {
                Object.assign(tabs, {
                    ExtraData: { title: 'Extra Data', hash: 'extra-data', hasError: false },
                });
            }

            return tabs;
        },
        init() {
            this.tabs = this.getAllTabs();
            let customerGroups = JSON.parse(this.customer_groups);
            this.customer_group_price_list = customerGroups.map((ele) => {
                return { ...ele, price: '' };
            });
            this.manufacturers = JSON.parse(this.all_manufacturers);
            this.brands = JSON.parse(this.all_brands);
            this.removeThese = {
                text: ['boolean_titles', 'enums', 'min', 'max'],
                integer: ['boolean_titles', 'enums'],
                boolean: ['enums', 'min', 'max'],
                decimal: ['boolean_titles', 'enums'],
                enums: ['boolean_titles', 'min', 'max'],
                date: ['boolean_titles', 'enums'],
            };

            this.defaultTabs = _.cloneDeep(this.tabs);
            let product_image = {
                main: '',
                thumbnail: '',
                additional: '',
            };

            if (this.method === 'post') {
                this.productData.has_sku = false;
                this.productData = {
                    ...this.productData,
                    ...{ product_image: product_image },
                    ...{ product_classification: {} },
                    ...{ product_classification_id: null },
                };
                if (this.productData.product_type === 'normal') {
                    this.productData.has_sku === '' ? (this.productData.has_sku = false) : null;
                }
            }

            !this.productData.product_image ? (this.productData.product_image = product_image) : null;

            if (this.method !== 'post') {
                if (this.productData.customer_group_price) {
                    let AllGroupPrice = _.cloneDeep(this.customer_group_price_list);
                    AllGroupPrice.forEach((allDataElement, index) => {
                        let foundIndex = this.productData.customer_group_price.findIndex((ele) => {
                            return ele.id == allDataElement.id;
                        });
                        if (foundIndex != -1) {
                            AllGroupPrice[index].price = this.productData.customer_group_price[foundIndex].pivot.price;
                        }
                    });
                    this.customer_group_price_list = AllGroupPrice;
                }

                this.productDataCategories = this.productData.categories?.map((ele) => ele.id);
                this.productData.single_product_page = this.allSingleProductPages?.find(
                    (ele) => ele.id == this.productData.single_product_page_id,
                );

                this.getClassificationAttributes();
                this.getClassificationOptions();
            }

            this.getAllAttributes();
            this.getAllOptions();
            this.fetchProductClassification();
            this.fetchCategory();
            this.onProductTypeChange(this.productData.product_type);
            if (!_.isEmpty(this.productData.products_list)) {
                this.productData.products_list = this.productData.products_list;
            }

            this.productData.features = JSON.parse(this.productData.features ?? '[]');
            this.productData.specifications = JSON.parse(this.productData.specifications ?? '[]');

            this.processQueryString();
        },

        fetchProductClassification(id = null) {
            let params = { id };
            axios
                .post('/admin/product/fetch/product-classification', params)
                .then((response) => {
                    _.isNumber(id)
                        ? (this.productData.product_classification = response.data)
                        : (this.productClassifications = response.data);
                })
                .catch((err) => {
                    console.error(err);
                });
        },

        fetchCategory() {
            axios
                .post('/admin/product/fetch/category-tree')
                .then((response) => {
                    this.categories = response.data;
                })
                .catch((err) => {
                    console.error(err);
                });
        },

        mergeAttributes() {
            return [...(this.classificationAttributes ?? []), ...(this.optionalSelectedAttributes ?? [])];
        },

        mergeOptions() {
            return [...(this.classificationOptions ?? []), ...(this.optionalSelectedOptions ?? [])];
        },

        async processProductData() {
            let _this = this;
            let attributes = this.mergeAttributes();
            let options = this.mergeOptions();

            let pivot = {
                productAttributes: [],
                optionalSelectedAttributes: [],

                productOptions: [],
                optionalSelectedOptions: [],
            };

            attributes.filter((ele, ind) => {
                pivot.productAttributes.push({
                    //product_id     : response.data.data.id,
                    attribute_id: ele.id,
                    attribute_value: ele.attribute_value ?? '',
                });
            });

            this.optionalSelectedAttributes.map((attribute, ind) => {
                if (attribute.type === 'date') {
                    if (!_.has(attribute, 'date_range')) {
                        attribute.min = '';
                        attribute.max = '';
                    } else {
                        if (attribute.date_range === null) {
                            attribute.min = '';
                            attribute.max = '';
                        } else {
                            attribute.min = attribute.date_range.start;
                            attribute.max = attribute.date_range.end;
                        }
                    }
                }
            });

            this.optionalSelectedAttributes.filter((ele, ind) => {
                pivot.optionalSelectedAttributes.push({
                    classification_id: this.productData.product_classification?.id,
                    attribute_id: ele.id,
                    min: ele.min ?? null,
                    max: ele.max ?? null,
                    boolean_titles:
                        _.isEmpty(ele.boolean_true) && _.isEmpty(ele.boolean_false)
                            ? null
                            : { true: ele.boolean_true, false: ele.boolean_false },
                    enums: _.isEmpty(ele.enums) ? null : ele.enums.map((ele) => ele.name),
                    is_required: 0,
                });
            });

            options?.filter((ele, ind) => {
                pivot.productOptions.push({
                    option_id: ele.id,
                });
            });

            _this.optionalSelectedOptions?.filter((ele, ind) => {
                pivot.optionalSelectedOptions.push({
                    classification_id: this.productData.product_classification.id,
                    option_id: ele.id,
                    is_required: 0,
                });
            });

            // await this.processStatus(pivot.productAttributes);
            pivot = await this.refinePivot(pivot);

            return {
                id: this.productData.id,
                product_type: this.productData.product_type,
                product_code: this.productData.product_code,
                products_list:
                    this.productData.product_type === 'bundle' ? JSON.stringify(this.productData.products_list) : null,
                has_sku: this.productData.product_type === 'normal' ? this.productData.has_sku : false,
                short_description: this.productData.local_short_description,
                description: this.productData.local_description,
                status: this.productData.status !== 'published' ? 'draft' : 'published',
                is_updated: false,
                product_name: this.productData.local_product_name,
                product_classification_id: this.productData.product_classification?.id,
                categories: this.productDataCategories,
                ean_number: this.productData.ean_number,
                gtin_number: this.productData.gtin_number,
                upc_number: this.productData.upc_number,
                asin: this.productData.asin,
                manufacturer: this.productData.manufacturer,
                brand: this.productData.brand,
                // model_code: this.productData.model_code,
                // model_name: this.productData.local_model_name,
                selling_price: this.productData.selling_price
                    ? parseFloat(this.productData.selling_price).toFixed(2)
                    : null,
                msrp: this.productData.msrp ? parseFloat(this.productData.msrp).toFixed(2) : null,
                attributes: attributes.map((ele) => ele.id),
                sku_default_attributes:
                    this.productData.sku_default_attributes.length > 0
                        ? this.productData.sku_default_attributes.map((ele) => ele.id)
                        : null,
                options:
                    this.productData.product_type === 'configurable'
                        ? this.productData.selected_product_options.map((ele) => ele.id)
                        : null,
                is_published: this.productData.is_published ?? this.is_published,
                pivot: pivot,

                //product images
                main: this.productData.product_image.main,
                thumbnail: this.productData.product_image.thumbnail,
                additional: this.productData.product_image.additional,
                active_tab: this.activeTab,
                classificationChanged: false,
                customer_group_price: this.customer_group_price_list,

                // New fields
                uom: this.productData.uom,
                pack_size: this.productData.pack_size,
                manufacturer_id: this.productData.manufacturer_id,
                brand_id: this.productData.brand_id,
                is_non_stock: this.productData.is_non_stock,
                allow_back_order: this.productData.allow_back_order,
                product_slug: this.productData.product_slug,
                meta_description: this.productData.meta_description,
                meta_keywords: this.productData.meta_keywords,
                single_product_page_id:
                    this.productData.single_product_page === undefined
                        ? null
                        : this.productData.single_product_page?.id,
                productDocuments: this.productData.productDocuments,
                model_codes: this.productData.model_codes.length > 0 ? this.productData.model_codes : null,
                prop65_message: this.productData.prop65_message,
                brand_name: this.productData.brand_name,
                min_order_qty: this.productData.min_order_qty,
                qty_interval: this.productData.qty_interval,
                own_truck_only: this.productData.own_truck_only,
                features: this.productData.features,
                specifications: this.productData.specifications,
            };
        },

        processStatus(productAttributes) {
            // TODO: need to set the condtion do follow the core configuration.
            /*
            if (
                this.productData.product_name === '' ||
                this.productData.product_code === '' ||
                (this.coreConfigs.use_classifications ? _.some(productAttributes, ['attribute_value', '']) : false)
            ) {
                if (this.productData.status == 'published') {
                    new Noty({
                        type: "info",
                        text: `This product can't be published, because some of fields are incomplete`,
                    }).show();
                }

                this.productData.status = 'incomplete';
            }
            */
            this.productData.status = 'draft';

            new Noty({
                type: 'warning',
                text: `Required fill must be fillup ${this.productData.status}`,
            }).show();
        },

        imageValidation() {
            let errors = {};
            for (const property in this.productData.product_image) {
                if (this.productData.product_image[property] === '') {
                    errors[property] = [property + ' image field is required'];
                }
            }

            if (Object.keys(errors).length) {
                this.validationErrors = errors;
                return false;
            }

            return true;
        },

        async saveProduct() {
            let productData = await this.processProductData();
            productData._save_action = this.actionType;

            this.validationErrors = {};
            axios[this.method](`${this.axios_url}?locale=${this.locale}`, productData)
                .then((response) => {
                    this.productData.id = response.data.data.id;
                    new Noty({
                        type: 'success',
                        text: 'Saved successfully',
                    }).show();
                    window.location.href = '/' + response.data.redirect_url;
                })
                .catch((e) => {
                    this.validationErrors = e.response.data.errors;
                });
        },

        saveProductImage(id, product_image_id) {
            axios[product_image_id ? 'put' : 'post'](
                `${this.productImageUrl}` + (product_image_id ? `/${product_image_id}` : ''),
                { ...this.productData.product_image, ...{ product_id: id } },
            )
                .then((res) => {
                    /*new Noty({
                        type: "success",
                        text: 'Product Image Saved Successfully'
                    }).show();*/
                })
                .catch((e) => {
                    this.validationErrors = e.response.data.errors;
                });
        },

        saveAndAction(actionType = null) {
            actionType = actionType ?? this.actionType;
            let url = '';

            switch (actionType) {
                case 'save_and_edit':
                    //url = `${this.backUrl}/${this.productData.id}/edit?activeTab=${this.activeTab}&locale=${this.locale}`;
                    url = this.backUrl;
                    break;
                case 'save_and_next':
                    let nextTab = this.getNextTab() ?? 'BasicInfo';
                    url = `${this.backUrl}/${this.productData.id}/edit?
                    activeTab=${nextTab}
                    &locale=${this.locale}`;
                    break;
                case 'save_and_publish':
                    url = this.backUrl;
                    break;
                case 'save_and_new':
                    url = this.createNew;
                    break;
                default:
                    url = this.backUrl;
                    break;
            }

            window.location = url;
        },

        getNextTab(next = true, tab = this.activeTab) {
            let tabsName = _.keys(this.tabs);
            let tabInd = _.indexOf(tabsName, tab);
            let nextTabName = tabsName[tabInd + (next ? 1 : -1)];
            return !!nextTabName ? nextTabName : tab;
        },

        removeOldClassificationsAttributes(newVal, oldVal) {
            this.$swal
                .fire({
                    title: 'Are you sure?',
                    text: 'Old attributes data will be removed',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#399E7F',
                    cancelButtonColor: '#ff7979',
                    confirmButtonText: 'Yes',
                })
                .then((result) => {
                    if (result.isConfirmed) {
                        this.removeOldAttributes = true;
                        this.getClassificationAttributes();
                    } else {
                        this.productData.product_classification_id = oldVal.id;
                        this.classificationChanged = false;
                    }
                });
        },

        getClassificationAttributes() {
            let qs = `id=${this.productData.id ?? ''}
            &classification_id=${this.productData.product_classification?.id ?? ''}
            &methodName=${this.method}&locale=${this.locale}&remove_old_attributes=${this.removeOldAttributes}`;

            axios
                .post(`/admin/product/fetch/attribute?${qs}`)
                .then((response) => {
                    this.classificationAttributes = []; // required attributes
                    this.optionalSelectedAttributes = []; // optional attributes

                    let classificationAttr = response.data.productClassification ?? [];
                    let selectedAttr = response.data.product ?? [];

                    selectedAttr.forEach((el) => {
                        let index = classificationAttr.findIndex((attr_el) => {
                            return attr_el.id == el.id;
                        });

                        if (index >= 0) classificationAttr[index] = el;
                        else classificationAttr.push(el);
                    });

                    this.optionalAttributes = _.xorBy(response.data.all, classificationAttr, 'id');

                    classificationAttr.forEach((el) => {
                        if (el.is_required) this.classificationAttributes.push(el);
                        else this.optionalSelectedAttributes.push(el);
                    });
                })
                .finally(() => {
                    this.loader = false;
                    this.removeOldAttributes = false;
                });
        },

        getClassificationOptions() {
            let qs = `id=${this.productData.id ?? ''}
            &classification_id=${this.productData.product_classification?.id ?? ''}
            &methodName=${this.method}
            &locale=${this.locale}`;

            !_.isEmpty(this.productData.product_classification)
                ? axios
                      .post(`/admin/product/fetch/product-option?${qs}`)
                      .then((response) => {
                          this.classificationOptions = response.data.productClassification;
                          let classificationOptionsIds = [];
                          if (response.data.productClassification.length > 0) {
                              response.data.productClassification.map((option) => {
                                  classificationOptionsIds.push(option.id);
                              });
                          }

                          let optionalSelectedOptions = [];
                          if (response.data.product.length > 0) {
                              response.data.product.map((option) => {
                                  if (!classificationOptionsIds.includes(option.id)) {
                                      optionalSelectedOptions.push(option);
                                  }
                              });
                          }
                          this.optionalSelectedOptions = this.method === 'post' ? [] : optionalSelectedOptions ?? [];

                          let optionalOptions = [];
                          if (response.data.all.length > 0) {
                              response.data.all.map((option) => {
                                  if (!classificationOptionsIds.includes(option.id)) {
                                      optionalOptions.push(option);
                                  }
                              });
                          }
                          this.optionalOptions = optionalOptions;
                      })
                      .finally(() => {
                          this.loader = false;
                      })
                : false;
        },

        getAllAttributes() {
            axios
                .post(
                    `/admin/product/fetch/attributes?
            classification_id=${this.productData?.product_classification?.id ?? ''}`,
                )
                .then((response) => {
                    this.allAttributes = response.data;

                    // this.allAttributes = response.data.filter(attribute => {
                    //     return attribute.tunable;
                    // });

                    this.getOptionalAttributes();
                })
                .catch((err) => {
                    console.error(err);
                });
        },

        getAllOptions() {
            axios
                .post(
                    `/admin/product/fetch/product-options?
            classification_id=${this.productData?.product_classification?.id ?? ''}`,
                )
                .then((response) => {
                    this.allOptions = response.data;
                    let optionalOptions = _.xorBy(response.data, this.classificationOptions, 'id');
                    this.optionalOptions = optionalOptions;
                })
                .catch((err) => {
                    console.error(err);
                });
        },

        getOptionalAttributes() {
            this.optionalAttributes = _.xorBy(this.allAttributes, this.classificationAttributes, 'id');
        },

        getOptionalSelectedAttributes() {
            this.optionalSelectedAttributes = _.xorBy(this.classificationAttributes, this.allAttributes, 'id');
        },

        checkIfProductClassification(tab = 'basic-info') {
            if (this.productData.product_type !== 'bundle' && this.coreConfigs.use_classifications) {
                if (!this.productData.product_classification_id) {
                    new Noty({
                        type: 'error',
                        text: 'Please select a Product Classification first',
                    }).show();

                    setTimeout(() => {
                        document.querySelector(`[href = '#tab_${tab}']`).click();
                    }, 100);

                    this.validationErrors = { product_classifications: ['Please choose product classifications'] };
                }
            }
        },

        checkIfX(field = 'product_code', validationErrors = null, tab = 'basic-info') {
            if (this.productData.product_type !== 'bundle') {
                if (!this.productData[field]) {
                    new Noty({
                        type: 'error',
                        text: 'Please insert product code first',
                    }).show();

                    setTimeout(() => {
                        document.querySelector(`[href = '#tab_${tab}']`).click();
                    }, 100);

                    this.validationErrors.field = validationErrors ?? [`Please fill ${field}`];
                }
            }
        },

        checkIfProductCode(tab = 'basic-info') {
            if (this.productData.product_type !== 'bundle') {
                if (!this.productData.product_code) {
                    new Noty({
                        type: 'error',
                        text: 'Please insert product code first',
                    }).show();

                    setTimeout(() => {
                        document.querySelector(`[href = '#tab_${tab}']`).click();
                    }, 100);
                    this.validationErrors = { product_code: ['Please insert into product code'] };
                }
            }
        },

        checkIfProductIsSavedWhenClickingSKUSTab() {
            if (this.productData.product_type === 'normal' && this.productData.has_sku && this.method === 'post') {
                let tab = this.currentPreviousTabs['previous_tab_id'];

                new Noty({
                    type: 'error',
                    text: 'You need to save product first to add SKUS',
                }).show();

                setTimeout(() => {
                    document.querySelector(`[href = '#tab_${tab}']`).click();
                }, 100);
            }
        },

        onProductTypeChange(product_type) {
            switch (product_type) {
                case 'normal':
                    this.restoreDefaultTabs().onHasSku(this.productData.has_sku);
                    break;
                case 'bundle':
                    this.restoreDefaultTabs().removeTab('Attributes').addTab('Products');
                    break;
                case 'configurable':
                    this.restoreDefaultTabs().addTab('Options');
                    break;
                default:
                    this.restoreDefaultTabs();
                    break;
            }

            this.reRenderTabs();
        },

        reRenderTabs() {
            this.tabsRerender += 1;
        },

        addTab(tab) {
            this.tabs[tab] = this.otherTabs[tab];
            return this;
        },

        removeTab(tab) {
            if (tab in this.tabs) {
                delete this.tabs[tab];
            }
            return this;
        },

        restoreDefaultTabs() {
            this.tabs = _.cloneDeep(this.defaultTabs);
            return this;
        },

        onHasSku(hasSkuVal) {
            hasSkuVal === true || hasSkuVal === 1
                ? this.restoreDefaultTabs().addTab('SKUS').reRenderTabs()
                : this.restoreDefaultTabs().reRenderTabs();

            this.getDynamicCurrentPreviousTabIds();
        },

        refinePivot(pivot) {
            let attributesById = _.keyBy(this.allAttributes, 'id');
            pivot.optionalSelectedAttributes.filter((aAttribute, ind) => {
                let type = attributesById[aAttribute.attribute_id]?.type;
                type += type === 'enum' ? 's' : '';

                aAttribute = _.omit(aAttribute, this.removeThese[type]);
                pivot.optionalSelectedAttributes[ind] = aAttribute;
            });

            return pivot;
        },

        getDynamicCurrentPreviousTabIds() {
            if (this.productData.product_type === 'normal' && this.productData.has_sku && this.method === 'post') {
                let allTabs = {
                    BasicInfo: 'basic-info',
                    Attributes: 'attributes',
                    Pricing: 'pricing',
                    Media: 'media',
                    SKUS: 'skus',
                };

                this.currentPreviousTabs['previous_tab_id'] = this.currentPreviousTabs['current_tab_id'];
                this.currentPreviousTabs['current_tab_id'] = allTabs[this.activeTab];
            }
        },

        processQueryString() {
            let activeModalId = null;

            if (this.queryString.activeModalId) {
                activeModalId = document.querySelector(`[data-target='#${this.queryString.activeModalId}']`);
            }

            setTimeout(() => {
                activeModalId ? activeModalId.click() : false;
            }, 100);
        },

        convertNameToSlug(Name) {
            clearTimeout(this.timer);
            this.timer = setTimeout(() => {
                let slug = Name.trim()
                    .toLowerCase()
                    .replace(/-/g, ' ')
                    .replace(/[^\w ]+/g, '')
                    .replace(/ +/g, '-');

                this.checkProductSlugUnique(slug);
            }, 500);
        },

        checkProductSlugUnique(slug) {
            let params = {};
            if (this.method === 'put') {
                params.id = this.productData.id;
            }
            params.slug = slug;

            axios
                .post(`/admin/product/fetch/product-slug`, params)
                .then((response) => {
                    this.productData.product_slug = response.data.slug;
                })
                .catch((err) => {
                    console.error(err);
                });
        },
        getErr(error) {
            if (_.isObject(error)) {
                return _.values(error)[0];
            }
            return error;
        },
        renderError() {
            this.tabs = this.getAllTabs();
            let isSwitchTab = false;
            for (const key in this.validationErrors) {
                const field = this.allFields[key];
                this.tabs[field.tab].hasError = true;

                if (!isSwitchTab) {
                    this.activeTab = field.tab;
                    isSwitchTab = false;
                }
            }
        },
    },

    watch: {
        'productData.product_classification': function (newVal, oldVal) {
            if (!!newVal && newVal !== oldVal) {
                this.getClassificationAttributes();
                this.getClassificationOptions();
            }
        },

        'productData.product_classification_id': function (newVal, oldVal) {
            if (_.isNumber(newVal)) this.fetchProductClassification(newVal);
        },

        'productData.status': function (newVal, oldVal) {
            this.productData.is_published = this.is_published = newVal === 'published';
        },

        'productData.product_type': function (newVal, oldVal) {
            this.onProductTypeChange(newVal);
        },

        'productData.has_sku': function (newVal, oldVal) {
            if (newVal !== oldVal) {
                this.onHasSku(newVal);
            }
        },
        selectedFiles: function (newVal, oldVal) {
            this.productData.product_image[this.$refs.component.type] = newVal;
        },
    },
};
</script>

<style>
.cke_contents {
    min-height: 300px !important;
}

.vue-treeselect .vue-treeselect__control,
.multiselect .multiselect__tags {
    min-height: 38px;
    height: auto;
    border-radius: 4px !important;
    border: 1px solid rgba(0, 40, 100, 0.12) !important;
}

@media (max-width: 576px) {
    .modal-content {
        margin-top: 78px;
    }

    .modal-header {
        margin-left: 28px;
    }
}
</style>
