<template>
    <div class="row">
        <div :class="class_name">
            <!-- Default box -->
            <form method="post" @submit.prevent="saveData()" :action="url">
                <div v-if="translation_enabled" class="mb-2 text-right">
                    <!-- Single button -->
                    <AvailableLocales
                        :availableLocales="availableLocales"
                        :current_lang="current_lang"
                        :queryString="query_string"
                        :url="url"
                    ></AvailableLocales>
                </div>

                <div class="tab-container mb-2">
                    <Tabs :key="tabsRerender" ref="tabs"/>

                    <div class="tab-content p-0 ">


                        <Loader v-if="loader" ref="loader"/>

                        <div v-else>
                            <component :is="activeTab"/>

                            <SwitchTabs ref="switchTabs"/>
                        </div>
                    </div>
                </div>

                <div id="saveActions" class="form-group">
                <input type="hidden" name="save_action" value="save_and_back">
                <div class="btn-group" role="group">
                    <button type="submit" class="btn btn-success">
                        <span class="la la-save" role="presentation" aria-hidden="true"></span> &nbsp;
                        <span @click="actionType=saveAction.active.value;">{{ saveAction.active.label }}</span>
                    </button>
                    <div class="btn-group" role="group">
                        <button id="btnGroupDrop1" type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="caret"></span><span class="sr-only">▼</span></button>
                        <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">

                            <template v-for="(option, index) in saveAction.options">
                                <button class="dropdown-item" @click="actionType=index;">{{ option }}</button>
                            </template>

                        </div>
                    </div>
                </div>
                <a :href="backUrl" class="btn btn-default"><span class="la la-ban"></span> &nbsp;Cancel</a>
                </div>

            </form>
        </div>

        <InlineCreate
            ref="inlineCreate"
            axios_url="/admin/attribute/inline/create"
            :locale="locale"
            :show="showInline"
        ></InlineCreate>

        <OptionInlineCreate
            ref="optionInlineCreate"
            axios_url="/admin/option/inline/create"
        ></OptionInlineCreate>

    </div>
</template>

<script>
import InlineCreate       from "../attribute/InlineCreate";
import OptionInlineCreate from "../options/InlineCreate";
import AvailableLocales   from "../../components/AvailableLocales";
import Tabs               from "./tabs/Tabs";
import BasicInfo          from "./tabs/BasicInfo";
import Products           from "./tabs/Products";
import _                  from "lodash";
import "vue-multiselect/dist/vue-multiselect.min.css";
import SwitchTabs         from "../../components/SwitchTabs";
import Loader             from "../../components/Loader";

export default {
    name      : 'ProductClassificationCreate',
    props     : [
        'class_name', 'url', 'translatable',
        'product_classification', 'attributes', 'options',
        'translation_enabled', 'available_locales', 'current_lang',
        'method', 'axios_url', 'locale',
        'query_string', 'active_tab', 'easy_ask_default_product_categories', 'product_list', 'all_single_product_pages', 'save_action'
    ],
    components: {Loader, SwitchTabs, InlineCreate, AvailableLocales, OptionInlineCreate, Tabs, BasicInfo, Products,},

    data() {
        return {
            tabsRerender                   : 1,
            loader                         : false,
            check_use_product              : false,
            showInline                     : false,
            currentLang                    : this.current_lang,
            availableLocales               : JSON.parse(this.available_locales),
            productList                    : JSON.parse(this.product_list),
            allAttributes                  : [],
            selectedAttribute              : [],
            allProductOptions              : [],
            selected_product_options       : [],
            selectedProducts               : [],
            validationErrors               : "",
            productClassification          : {
                title                 : '',
                label                 : '',
                single_product_page_id: null,
                attributes            : [],
                options               : [],
                products              : [],
                _save_action          : ''

            },
            tabs                           : {
                BasicInfo: {title: 'Basic Info', hash: 'basic-info'},
                Products : {title: 'Products', hash: 'products'},
            },
            activeTab                      : _.cloneDeep(this.active_tab),
            enumOptions                    : [],
            enumOption                     : "",
            backUrl                        : '/admin/product-classification',
            newUrl                         : '/admin/product-classification/create',
            hasMinMaxErr                   : false,
            noRanges                       : ['text', 'boolean', 'enum'],
            actionType                     : 'save_and_back',
            easyAskDefaultProductCategories: JSON.parse(this.easy_ask_default_product_categories),
            allSingleProductPages          : JSON.parse(this.all_single_product_pages),
            saveAction                     : JSON.parse(this.save_action),

        }
    },

    mounted() {
        this.init();
    },

    methods: {
        checkUseInProducts() {
            if (this.method == 'put' && this.check_use_product == false) {
                this.check_use_product = true;
                axios.get(`/admin/product-classification/check-use-product/${JSON.parse(this.product_classification).id}`).then(response => {
                    if (response.data > 0) {
                        swal({
                            title     : "Warning",
                            text      : `This classification has already been used in ${response.data} products.
                                     Do you want to update the Attributes of Classification?`,
                            icon      : "warning",
                            buttons   : ["No", "Yes"],
                            dangerMode: true,
                        }).then((value) => {
                            if (value) {
                                new Noty({
                                    type: "info",
                                    text: 'You can update now',
                                }).show();
                            }
                        });
                    }
                }).catch((err) => {
                    console.error(err);
                })
            }
        },

        async init() {
            let allAttributes  = JSON.parse(this.attributes);
            this.allAttributes = allAttributes.map(ele => {
                return {...ele, ...{errors: null}}
            });
            await this.getAllOptions();
            let productClassification = JSON.parse(this.product_classification);
            !_.isEmpty(productClassification) ? this.initEdit(productClassification) : null;
        },

        checkHasRange(value) {
            return this.noRanges.find((ele) => {
                return ele === value
            })
        },

        initEdit(product_classification) {
            this.selectedAttribute     = [];
            this.productClassification = product_classification;
            this.allAttributes.filter(attribute => {
                this.productClassification.attributes.filter(ele => {
                    ele.id === attribute.id
                    ? this.selectedAttribute.push(_.cloneDeep(attribute))
                    : null;
                });
            });

            this.allProductOptions.filter(option => {
                this.productClassification.options.filter(ele => {
                    ele.id === option.id
                    ? this.selected_product_options.push(_.cloneDeep(option))
                    : null;
                });
            });
        },

        removeError(key) {
            let errorsObject = this.validationErrors;
            let errorExist   = errorsObject[key];
            if (errorExist) {
                delete errorsObject[key];
            }
            //for re-render component
            if (Object.keys(errorsObject).length <= 0) {
                this.validationErrors = "";
            } else {
                this.validationErrors = errorsObject;
            }
        },

        async saveData() {
            this.hasMinMaxErr = false;
            await this.validateMinMax();
            this.productClassification._save_action           = this.actionType;
            this.productClassification.attributes             = this.selectedAttribute.map(ele => ele.id);
            this.productClassification.options                = this.selected_product_options.map(ele => ele.id);
            this.productClassification.single_product_page_id = this.productClassification.single_product_page_id === undefined ? null : this.productClassification.single_product_page_id;
            this.hasMinMaxErr?
                new Noty({
                    type: "error",
                    text: 'Something went wrong',
                }).show() :
                axios[this.method](`${this.axios_url}?locale=${this.locale}`, {...this.productClassification, ...{title: this.productClassification.label}, ...this.products})
                .then(response => {
                    let pivot = [];
                    this.selectedAttribute.filter((ele, ind) => {
                        pivot.push({
                            classification_id: response.data.data.id,
                            type             : ele.type,
                            attribute_id     : ele.id,
                            min              : ele.min,
                            max              : ele.max,
                            is_multiple      : ele.is_multiple,
                            is_required      : ele.is_required,
                            boolean_titles   : _.isEmpty(ele.boolean_true) && _.isEmpty(ele.boolean_false)
                                               ? null
                                               : {"true": ele.boolean_true, "false": ele.boolean_false},
                            enums            : _.isEmpty(ele.enums)
                                               ? null
                                               : ele.enums.map(ele => ele.name),
                        });
                    });

                    this.updatePivot(pivot, "/"+response.data.redirect_url);
                })
                .catch((err) => {
                    this.validationErrors = err.response.data.errors;
                    new Noty({
                        type: "error",
                        text: err.response.data.message,
                    }).show();
                    console.error(err);
                });
        },

        async updatePivot(pivot, redirect_url) {
            await axios.post('/admin/product-classification/update-pivot-table', pivot)
                .then(res => {
                    new Noty({
                        type: "success",
                        text: 'Saved successfully',
                    }).show();

                    window.location.href = redirect_url;
                })
                .catch((err) => {
                    console.error(err);
                })
        },

        validateMinMax(index = null) {
            _.isNull(index)
            ? this.selectedAttribute.filter((attribute, index) => {
                return this.setError(attribute, index);
            })
            : this.setError(this.selectedAttribute[index], index);
        },

        setError(attribute, index) {
            this.hasMinMaxErr = false;
            attribute.errors  = "";
            if (!this.checkHasRange(attribute.type)) {
                if (attribute.min === "" || attribute.max === "") {
                    this.hasMinMaxErr                    = true;
                    this.selectedAttribute[index].errors = {
                        message: "The Min Or Max value must not be empty"
                    }
                } else if (parseFloat(attribute.min) < 0 || parseFloat(attribute.max) < 0) {

                    this.hasMinMaxErr = true;

                    this.selectedAttribute[index].errors = {
                        message: "Negative number not allowed"
                    }
                } else if (parseFloat(attribute.min) > parseFloat(attribute.max)) {

                    this.hasMinMaxErr = true;

                    this.selectedAttribute[index].errors = {
                        message: "The Max value must be greater than Min value"
                    }
                }
            } else if (attribute.type === 'boolean') {
                if (attribute.boolean_true === "" || attribute.boolean_false === "") {
                    this.hasMinMaxErr                    = true;
                    this.selectedAttribute[index].errors = {
                        message: "Boolean Field Must Not Be Null"
                    }
                }
            } else if (attribute.type === 'enum') {
                if (attribute.enums.length <= 0) {
                    this.hasMinMaxErr                    = true;
                    this.selectedAttribute[index].errors = {
                        message: "Please Select some enum value"
                    }
                }
            } else {
                this.selectedAttribute[index].errors = null;
            }
        },

        addTag(newTag, index) {
            const tag = {
                name       : newTag,
                unique_slug: newTag.substring(0, 2) + Math.floor((Math.random() * 10000000))
            }
            this.enumOptions.push(tag)
            this.selectedAttribute[index].enums.push(tag);
            this.validateMinMax(index);
        },

        async getAllOptions() {
            this.loader = true;
            await axios.post('/admin/product/fetch/product-options')
                .then(response => {
                    this.allProductOptions = response.data;
                })
                .catch(err => {
                    console.error(err)
                })
                .finally(() => {
                    this.loader = false;
                })
        },

        getNextTab(next = true, tab = this.activeTab) {
            let tabsName = _.keys(this.tabs);
            let tabInd   = _.indexOf(tabsName, tab);
            let lastInd  = _.lastIndexOf(tabsName);
            tab          = tabInd !== -1 && tabInd !== lastInd ? tabsName[tabInd + (next ? 1 : -1)] : tab;

            return tab ?? (next ? 'Products' : 'BasicInfo');
        },
    },

    watch: {
        /*selectedAttribute: function (newVal, oldVal) {
            console.log(newVal, oldVal);
        }*/
    },

    computed: {
        _() {
            return _;
        },
    },
}
</script>

<style>
.noty_theme__mint.noty_type__success {
    padding: .75rem 1.25rem !important;
    background: #42BA96;
}

.multiselect.is-invalid {
    border: 1px solid red;
    border-radius: 5px;
}

.red-border {
    border: 1px solid red !important;
}

</style>
