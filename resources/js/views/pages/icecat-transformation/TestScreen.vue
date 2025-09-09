<template>
    <div id="dataTransformationTestScreen" class="animated fadeIn">

        <div class="row">
            <div class="col-md-12 bold-labels">
                <!-- Default box -->

                <form method="post" :action="backUrl">
                    <div class="card">
                        <div class="card-body row">
                            <div class="alert alert-danger w-100 text-center" v-if="'' !== error">
                                <i class="fa fa-exclamation-triangle"></i>
                                {{ error }}
                            </div>
                            <SearchModal
                                calledFrom="dataTransformationTestScreen"
                                ref="searchModal"
                                type="category"/>

                            <Bottom ref="bottom"
                                    calledFrom="dataTransformationTestScreen"
                                    :getProducts="getEasyAskProducts"
                                    :getModal="getModal"
                                    buttonName="Select"
                            />

                            <hr class="w-100">

                            <div v-if="isProductSelected" class="col-sm-12">
                                <div class="row" :key="reRenderProductData">
                                    <div class="form-group col-sm-6">
                                        <div class="text-center">
                                            <label>Product Fields</label>
                                        </div>

                                        <div class="tableFixHead">
                                            <table class="table table-sm mb-0 table-bordered">
                                                <tr class="array-row">
                                                    <th style="width: 30%">Name</th>
                                                    <th style="width: 70%">Value</th>
                                                </tr>
                                                <tr class="array-row" v-for="productField in productData">
                                                    <td style="font-weight: 600!important;">
                                                        {{ productField.name }}
                                                    </td>
                                                    <td>
                                                        {{ productField.value }}
                                                    </td>
                                                </tr>

                                            </table>
                                        </div>

                                    </div>

                                    <div class="form-group col-sm-3">
                                        <div class="text-center">
                                            <label>Product Attributes</label>
                                        </div>
                                        <div class="tableFixHead">
                                            <table class="table table-sm mb-0 table-bordered">
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Value</th>
                                                </tr>
                                                <tr class="array-row" v-for="productAttribute in productAttributes">
                                                    <td style="font-weight: 600!important;">
                                                        {{ productAttribute.name }}
                                                    </td>
                                                    <td>
                                                        {{ productAttribute.value }}
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>

                                    </div>

                                    <div class="form-group col-sm-3">
                                        <div class="text-center">
                                            <label>Variables</label>
                                        </div>
                                        <div class="tableFixHead">
                                            <table class="table table-sm table-striped mb-0 table-bordered">
                                                <tr class="array-row">
                                                    <th>Name</th>
                                                    <th>Value</th>
                                                </tr>
                                                <tr class="array-row" v-for="variable in variables">
                                                    <td style="font-weight: 600!important;">
                                                        {{ variable.name }}
                                                    </td>
                                                    <td>
                                                        {{ variable.value }}
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="form-group col-sm-3">
                                        <div>
                                            <label>Categories : </label>
                                            <span v-for="category in categories">
                                                <span style="font-size: 15px;"
                                                      class="badge badge-secondary"> {{ category }} </span>
                                            </span>
                                        </div>
                                    </div>

                                    <div class="form-group col-sm-3">
                                        <div>
                                            <label>Product Classification : </label>
                                            <span v-if="productClassification">
                                                <span style="font-size: 15px;"
                                                      class="badge badge-secondary">{{ productClassification }} </span>
                                            </span>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="form-group col-sm-12">
                                <div class="d-flex justify-content-between mb-3">
                                    <div>
                                        <button :disabled="!isProductSelected" class="btn btn-primary" type="button"
                                                @click="evaluateScripts">Execute Script
                                        </button>
                                        <button :disabled="!isProductSelected" type="button" class="btn btn-primary"
                                                @click="singleStep">Single Step
                                        </button>
                                    </div>

                                    <div>
                                        <button :disabled="isEditScriptEnabled" type="button" class="btn btn-primary"
                                                @click="editScript">Edit Script
                                        </button>
                                        <button v-if="isEditScriptEnabled" @click="updateScript"
                                                type="button" class="btn btn-success">
                                            Update Script
                                        </button>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <label>Script</label>
                                </div>
                                <textarea v-if="isEditScriptEnabled" v-model="dataTransformation.scripts"
                                          class="form-control script-editor"
                                          :disabled="!isEditScriptEnabled"
                                          rows="8">
                                </textarea>
                                <div v-if="!isEditScriptEnabled" id="scriptDiv" class="script-editor p-2 pb-4">
                                    <span :id="index" v-for="(scriptText, index) in scriptTextArr">
                                         {{ scriptText }} <br>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="saveActions" class="form-group">
                        <button :disabled="!isEditScriptEnabled" type="button" class="btn btn-success">
                            <span class="la la-save" role="presentation" aria-hidden="true"></span> &nbsp;
                            <span data-value="save_and_back">Save</span>
                        </button>

                        <a :href="backUrl" :disabled="!isEditScriptEnabled" class="btn btn-warning"><span
                            class="la la-ban"></span> &nbsp;Cancel</a>

                        <a :href="backUrl" class="btn btn-danger"><span
                            class="la la-ban"></span> &nbsp;Exit Testing</a>

                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import _           from "lodash";
import Bottom      from "../../components/selected-products/Bottom";
import SearchModal from "../../components/search-product-modal/SearchProductModal";


export default {
    name      : "DataTransformationTestScreen",
    components: {Bottom, SearchModal},
    props     : [
        'data_transformation_data', 'easy_ask_default_product_categories', 'locale'
    ],

    data() {
        return {
            dataTransformationData         : JSON.parse(this.data_transformation_data),
            backUrl                        : '/admin/data-transformation',
            newUrl                         : '/admin/data-transformation/create',
            actionType                     : 'save_and_back',
            dataTransformation             : {
                id                 : null,
                transformation_name: '',
                scripts            : '',
            },
            getModal                       : null,
            settings                       : {
                view: null
            },
            defaultSettings                : {
                view: 'grid'
            },
            noProductFound                 : "No Product Found",
            search_by_product_id           : null,
            placeholderImage               : this.$root.config.fallback_image,
            productByIdUrl                 : "/admin/product/fetch/product-by-id",
            EAProduct                      : {
                url : "/admin/product/fetch/products-list",
                data: [],
            },
            productData                    : [],
            productAttributes              : [],
            variables                      : [],
            isProductSelected              : false,
            isEditScriptEnabled            : false,
            site_search                    : '',
            navPath                        : [],
            defaultNavPath                 : [
                {
                    englishName    : "All Products",
                    navNodePathType: 1,
                    path           : "All Products",
                    purePath       : "All Products",
                    seoPath        : "",
                    value          : "All Products",
                }
            ],
            easyAskDefaultProductCategories: JSON.parse(this.easy_ask_default_product_categories),
            currentProductsBackup          : [],
            currentProducts                : [],
            searching                      : false,
            reRenderProductData            : 0,
            category_id                    : null,
            selectedProductId              : null,
            error                          : '',
            isIfStatement                  : false,
            categories                     : [],
            productClassification          : null,
            returnSKUS                     : false,
            returnSKUSClicked              : false,
        }
    },
    created() {
        this.initEdit();
    },
    methods: {
        initEdit() {
            this.dataTransformation.id                  = this.dataTransformationData.id;
            this.dataTransformation.transformation_name = this.dataTransformationData.transformation_name;
            this.dataTransformation.scripts             = this.dataTransformationData.scripts;
            this.productData                            = [];
            this.productAttributes                      = [];
            this.variables                              = [];
        },

        saveData() {
            //
        },

        setCategoryNavPath(category) {
            let navPath = {
                value          : `${category.name}`,
                path           : `All Products////${category.name}`,
                purePath       : `All Products////${category.name}`,
                seoPath        : `${category.nodeString}`,
                navNodePathType: 1,
                englishName    : `${category.name}`
            }
            this.navPath.push(navPath);
        },

        reStructureSeoPath(seoPath) {
            if (this.isSearchStringExist(seoPath)
                && this.$refs.searchModal.categories.length
                === 0) {
                this.$refs.searchModal.resetData(true);
            } else if (this.isSearchStringExist(seoPath)) {
                this.$refs.searchModal.$refs.top.site_search = '';
                this.site_search                             = '';
            } else if (this.$refs.searchModal.categories.some(category => category.nodeString
                                                                          === seoPath)) {
                _.remove(this.$refs.searchModal.categories, category => category.nodeString
                                                                        === seoPath);

                if (this.$refs.searchModal.categories.length
                    > 0
                    || this.$refs.searchModal.$refs.top.site_search
                    !== '') {
                    this.getEasyAskProducts();
                } else {
                    this.$refs.searchModal.resetData(true);
                }
            }
        },

        removeNavPath(index) {
            this.navPath.splice(index, 1);
        },

        isSearchStringExist(seoPath) {
            return seoPath.charAt(0) === '-' && (seoPath.substring(seoPath.indexOf('-') + 1)
                                                 === this.$refs.searchModal.$refs.top.site_search)
        },

        getEasyAskProducts(product_id = null) {
            if (product_id !== null) {
                let url                       = `${this.productByIdUrl}?id=${product_id}&categoryProduct=true&selectAllFieldsWithAttributes=true`;
                this.$refs.bottom.smallLoader = true;

                axios.post(url)
                    .then(({data}) => {
                        // Check if product is already selected
                        if (data.id === this.selectedProductId) {
                            new Noty({
                                type: "error",
                                text: 'Product is already selected.'
                            }).show();

                            return;
                        }

                        // Setting product with all related data
                        this.setProductData(data);

                        // After setting product data doing some other things and show product details
                        this.afterSettingProductData();
                    })
                    .catch(error => {
                        if ((error?.response?.status ?? null) === 404) {
                            new Noty({
                                type: "error",
                                text: 'Product not found'
                            }).show();
                        }
                    })
                    .finally(() => {
                        this.$refs.bottom.smallLoader = false;
                        this.$root.renderTooltip();
                    });
            } else {
                if (this.site_search.length >= 2 ||
                    this.$refs.searchModal.categories.length > 0) {
                    this.searching  = true;
                    let site_search = this.mergeSeoPaths(this.$refs.searchModal);
                    let pagination  = new URLSearchParams(this.$refs.searchModal.pagination).toString();
                    let url         = `${this.EAProduct.url}?site_search=${site_search}
                    &categoryProduct=true
                    &categoryId=${this.category_id}
                    &${pagination}
                    &returnSKUS=${this.returnSKUS}
                    &page=${this.$refs.searchModal.pagination.currentPage}`;

                    axios.post(url)
                        .then(({data}) => {
                            this.$refs.searchModal.attributeOptions = [];
                            this.$refs.searchModal.attributes       = [];
                            this.$refs.searchModal.brandOptions     = [];
                            this.$refs.searchModal.categoryOptions  = data.categories;
                            if (this.site_search !== '') {
                                this.addSiteSearchIntoNavPath(this.site_search);
                            }

                            let searchResult = data.mappedProductData;
                            data.mappedProductData.forEach((ele, index) => {
                                this.currentProductsBackup.forEach((list_ele) => {
                                    if (ele.product_id === list_ele.Product_Id) {
                                        searchResult[index].duplicate = true;
                                    }
                                });
                            });

                            this.$refs.searchModal.searchResultProducts
                                = searchResult.map((product) => {
                                return {
                                    'Product_Id'  : product.product_id,
                                    'Product_Name': product.local_product_name,
                                    'Thumbnail'   : product?.product_image?.main ?? null,
                                    'duplicate'   : product.duplicate,
                                };
                            });

                            this.$refs.searchModal.pagination = {
                                currentPage   : data.paginationData.current_page,
                                firstItem     : data.paginationData.from,
                                lastItem      : data.paginationData.to,
                                pageCount     : data.paginationData.last_page,
                                resultsPerPage: data.paginationData.per_page,
                                totalItems    : data.paginationData.total,
                            }
                        })
                        .finally(() => {
                            this.searching = false;
                        });
                } else {
                    new Noty({
                        type: "warning",
                        text: 'Type at least 2 characters in search box'
                    }).show();
                }
            }
        },

        setProductAttributes(data) {
            let allAttributes = [];

            data.attributes.map((attribute) => {
                let allowMultiple = [];
                if (data.product_classification) {
                    allowMultiple = data.product_classification.attributes
                        .filter((ele) => {
                            return ele.id === attribute.id;
                        })
                        .map((ele) => {
                            return ele.pivot.is_multiple === 1;
                        });
                }

                if (allowMultiple.length === 0) {
                    allowMultiple[0] = false;
                }

                allAttributes.push({
                    'name'          : attribute.local_name,
                    'value'         : JSON.parse(attribute.pivot.attribute_value)[`${this.locale}`],
                    'allow_multiple': allowMultiple[0],
                });
            });

            // check if allAttributes has duplicate name, if so than merge the value of the same name and remove the duplicate
            let uniqueAttributes = [];
            let duplicateName    = [];
            allAttributes.forEach((ele) => {
                if (duplicateName.indexOf(ele.name) === -1) {
                    duplicateName.push(ele.name);
                    uniqueAttributes.push(ele);
                } else {
                    uniqueAttributes.forEach((uniqueEle) => {
                        if (uniqueEle.name === ele.name) {
                            uniqueEle.value = uniqueEle.value + ', ' + ele.value;
                        }
                    });
                }
            });

            this.productAttributes = _.cloneDeep(uniqueAttributes);
        },

        reStructureProductField(productFields) {
            let productData = [];
            Object.keys(productFields).map(function (key) {
                productData.push({
                    'name' : key,
                    'value': productFields[key],
                });
            });
            this.productData = productData;
        },

        addSiteSearchIntoNavPath(site_search) {
            let isAlreadyExistInNavPath = this.navPath.some(nav => nav.value === site_search.trim());

            if (!isAlreadyExistInNavPath) {
                let navPath = {
                    value          : `${site_search}`,
                    path           : `All Products////${site_search}`,
                    purePath       : `All Products////${site_search}`,
                    seoPath        : `-${site_search}`,
                    navNodePathType: 1,
                    englishName    : `${site_search}`
                }
                this.navPath.push(navPath);
            }
        },

        setSettings(key, value, setDefault = false) {
            if (setDefault) {
                this.settings = _.cloneDeep(this.defaultSettings);
            } else {
                this.settings[key] = value;
            }

            localStorage.setItem('settings', JSON.stringify(this.settings));

            return this;
        },

        getSettings() {
            let settings = localStorage.getItem('settings');
            if (settings)
                this.settings = JSON.parse(settings);
            else
                this.setSettings(false, false, true);
        },

        mergeSeoPaths({brands, categories}) {
            let site_search = `-${this.site_search}`;
            if (categories.length > 0) {
                categories.forEach(((item, index) => {
                    site_search += `/${item.nodeString}`
                }));
            }
            if (brands.length > 0) {
                brands.forEach(((item, index) => {
                    site_search += `/${item.nodeString}`
                }));
            }

            return site_search;
        },

        resetNavPath() {
            this.navPath = _.cloneDeep(this.defaultNavPath);
        },

        evaluateScripts() {
            //TODO: Evaluate script
            this.executeScriptInApiEnd(null, false);
        },

        singleStep() {
            //TODO: Test single step
            let element = $('#scriptDiv .selectedText');
            let id      = parseInt(element[0].id);
            this.executeScriptInApiEnd(id, true);
        },

        editScript() {
            this.isEditScriptEnabled = true;
        },

        updateScript() {
            this.isEditScriptEnabled = false;
            this.updateDataTransformationScript();
            this.selectFirstLineOfScript();
        },

        cancelScriptEditing() {
            this.isEditScriptEnabled = false;
        },

        selectFirstLineOfScript() {
            let element = $('#scriptDiv .selectedText');
            setTimeout(() => {
                element.removeClass('selectedText');
                $('#scriptDiv span#' + 0).addClass('selectedText');
            }, 500);
        },

        selectEndOfBlock() {
            let element = $('#scriptDiv .selectedText');
            let id      = parseInt(element[0].id);
            let st      = '';
            setTimeout(() => {
                element.removeClass('selectedText');
                for (let i = id; i < this.scriptTextArr.length; i++) {
                    st = this.scriptTextArr[i].trim();
                    if (st.endsWith('}')) {
                        $('#scriptDiv span#' + (i + 1)).addClass('selectedText');
                        break;
                    }
                }
            }, 500);
        },

        updateDataTransformationScript() {
            let params = {
                id                 : this.dataTransformation.id ?? '',
                transformation_name: this.dataTransformation.transformation_name,
                applies_to         : this.dataTransformationData.applies_to,
                scripts            : this.dataTransformation.scripts,
            };

            axios.put(`/admin/data-transformation/${this.dataTransformation.id}?locale=${this.locale}`, params)
                .then(response => {
                    new Noty({
                        type: "success",
                        text: 'Script updated successfully',
                    }).show();
                })
                .catch((err) => {
                    new Noty({
                        type: "error",
                        text: err.response.data.message,
                    }).show();
                    console.error(err);
                });
        },

        executeScriptInApiEnd(originalIndex = null, single_step = false) {
            let scripts = single_step
                          ? {[originalIndex]: this.scriptTextArr[originalIndex]}
                          : this.scriptTextArr;

            let params = {
                id                   : this.dataTransformation.id,
                script               : scripts,
                fields               : this.productData,
                attributes           : this.productAttributes,
                variables            : this.variables,
                categories           : this.categories,
                productClassification: this.productClassification,
            };

            let url = `/admin/data-transformation/fetch/test-script?locale=${this.locale}`;

            axios.post(url, params)
                .then(response => {
                    this.productData           = response.data.fields;
                    this.productAttributes     = response.data.attributes;
                    this.variables             = response.data.variables;
                    this.variables             = response.data.variables;
                    this.categories            = response.data.categories;
                    this.productClassification = response.data.productClassification;
                    this.isIfStatement         = response.data.ifStatement;

                    if (this.isIfStatement === false) {
                        this.selectEndOfBlock();
                    } else {
                        this.goToNextLine(originalIndex, single_step);
                    }

                    new Noty({
                        type: "success",
                        text: 'Script has been executed successfully',
                    }).show();
                })
                .catch((err) => {
                    new Noty({
                        type: "error",
                        text: err.response.data.message,
                    }).show();
                    console.error(err);
                });
        },

        goToNextLine(id, single_step) {
            let newId   = id + 1;
            let element = $('#scriptDiv .selectedText');
            element.removeClass('selectedText');
            if ((newId + 1) > this.scriptTextArr.length) {
                newId = 0;
                this.selectFirstLineOfScript();
            } else {
                if (this.isIfStatement === true) {
                    ++newId;
                    $('#scriptDiv span#' + newId).addClass('selectedText');
                } else {
                    let nextScript = single_step
                                     ? this.scriptTextArr[newId]
                                     : '';
                    newId          = nextScript.trim().endsWith('}') ? newId + 1 : newId;
                    $('#scriptDiv span#' + newId).addClass('selectedText');
                }
            }


        },

        setCategories(categories) {
            categories.forEach(category => {
                this.categories.push(category.label);
            });
        },

        setProductClassification(product_classification) {
            this.productClassification = product_classification.label;
        },

        setProductData(data) {
            this.selectedProductId = data.id;
            let product            = {
                'id'                       : data.id,
                'product_code'             : data.product_code,
                'product_name'             : data.local_product_name,
                'product_type'             : data.product_type,
                'has_sku'                  : data.has_sku,
                'description'              : data.local_description,
                'ean_number'               : data.ean_number,
                'gtin_number'              : data.gtin_number,
                'upc_number'               : data.upc_number,
                'asin'                     : data.asin,
                'manufacturer'             : data.manufacturer,
                'model_code'               : data.model_code,
                'model_name'               : data.local_model_name,
                'selling_price'            : data.selling_price,
                'msrp'                     : data.msrp,
                'parent_id'                : data.parent_id,
                'sku_id'                   : data.sku_id,
                'sku_default_attributes'   : data.sku_default_attributes,
                'sku_part_number'          : data.sku_part_number,
                'main'                     : data.product_image ? data.product_image.main : '',
                'thumbnail'                : data.product_image ? data.product_image.thumbnail : '',
                'additional'               : data.product_image ? data.product_image.additional : '',
                'user_id'                  : data.user_id,
                'product_classification_id': data.product_classification_id,
                'status'                   : data.status,
            };
            this.reStructureProductField(product);

            this.categories            = [];
            this.productClassification = null;
            this.productAttributes     = [];
            this.variables             = [];

            if (data.categories.length > 0) {
                this.setCategories(data.categories);
            }
            if (data.product_classification) {
                this.setProductClassification(data.product_classification);
            }
            if (data.attributes.length > 0) {
                this.setProductAttributes(data);
            }
        },

        afterSettingProductData() {
            this.reRenderProductData++;
            this.$refs.bottom.search_by_product_id = "";
            this.selectFirstLineOfScript();
            this.isProductSelected = true;
            new Noty({
                type: "success",
                text: 'Product selected successfully!'
            }).show();
        },
    },
    mounted() {
        this.getSettings();
        this.$root.renderTooltip();
        this.getModal = this.$refs.searchModal.getModal;
        this.selectFirstLineOfScript();
    },
    computed: {
        _() {
            return _;
        },

        scriptTextArr: function () {
            return this.dataTransformation.scripts.split(/\r?\n/);
        }
    },
    watch: {
        returnSKUS: function (newVal, oldVal) {
            if (newVal !== oldVal && this.returnSKUSClicked) {
                this.getEasyAskProducts();
                this.returnSKUSClicked = false;
            }
        },
    }
}
</script>

<style>
.script-editor, .script-editor:focus {
    background-color: #0c1021;
    color: #fff;
    font-family: Monospace, monospace;
    border-color: transparent;
    box-shadow: none;
}

.tableFixHead {
    max-height: 250px !important;
    overflow-y: auto !important;
}

/*.form-control:disabled {*/
/*    background-color: #2b2b2b;*/
/*}*/

.selectedText {
    background: #2264c1;
}
</style>
