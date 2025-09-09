<template>
    <div id="searchProductModal">
        <div class="modal fade" id="addProductModal" tabIndex="0" role="dialog" aria-labelledby="addProductModalLabel"
            data-backdrop="static" data-keyboard="false" aria-modal="true" style="top: -10px!important;">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header modal-moveable">
                        <h5 class="modal-title" id="addProductModalLabel">
                            Select Products
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" @click="modalShade = ''"
                            aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body bg-light" style="padding: 0.5rem!important;">
                        <div class="card mb-0">
                            <div class="card-body row mb-0 pb-0">

                                <!-- searchModalTop -->
                                <modal-top-section ref="top" :called-from="calledFrom" />

                                <div class="form-group col-sm-12 mb-0">
                                    <hr class="mb-0">
                                </div>

                                <!-- searchModalLeft -->
                                <modal-left-section ref="left" />

                                <!-- searchModalRight -->
                                <modal-right-section ref="right" />

                            </div>
                        </div>
                    </div>
                    <div class="modal-footer modal-moveable">
                        <button v-if="!['dataTransformationTestScreen'].includes(calledFrom)" type="button"
                            class="btn btn-primary  mr-lg-0" @click="addProducts()">Add
                        </button>
                        <button type="button" class="btn btn-secondary mr-auto" data-dismiss="modal"
                            @click="modalShade = ''" aria-label="Close" id="cancelButton" ref="cancelButton">Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div v-html="modalShade"></div>
    </div>
</template>

<script>
import _ from "lodash";
import $ from 'jquery';
import 'jquery-ui-dist/jquery-ui';
import ModalLeftSection from "./body/Left";
import ModalRightSection from "./body/Right";
import ModalTopSection from "./body/Top";

export default {
    name: "SearchProductModal",
    components: { ModalLeftSection, ModalRightSection, ModalTopSection },
    props: ["type", "calledFrom", "module"],
    data() {
        return {
            loadedModal: 'Loading modal...',
            modalShade: '',
            modalBody: 'Loading...',
            reRenderAddTable: 0,
            timer: null,
            searchResultProducts: [],
            selectedProductsArr: [],
            paginationBackup: {
                currentPage: 1,
                firstItem: 0,
                isDrillDownActive: false,
                lastItem: 10,
                pageCount: 0,
                resultsPerPage: 10,
                totalItems: 0,
                //sortOrder        : "EAScore,f,EAFeatured Weight,f,Bestseller Rank,t",
            },
            pagination: {},
            attributes: [],
            attributeOptions: [],
            brands: [],
            brandOptions: [],
            categories: [],
            categoryOptions: [],
            categoryOptionsBackup: [],
            fetchingList: false,
            navNodePathTypes: {
                1: {
                    name: 'Categopry',
                    prefix: '',
                },
                2: {
                    name: 'Brand',
                    prefix: 'Brand:',
                },
                3: {
                    name: 'Attribute',
                    prefix: 'Attribute:',
                }
            },
            isSeoPathRemoved: false,
            reRenderSearchList: 0,
            showSelectAllItems: false,
            allProductsSelectedItems: [],
        }
    },

    mounted() {
        this.pagination = _.cloneDeep(this.paginationBackup);
    },

    methods: {
        getModal() {
            if (['dataTransformationTestScreen', 'megaMenuScreen', 'campaignScreen'].includes(this.calledFrom)) {
                this.$parent.returnSKUS = false;
            } else {
                this.$parent.$parent.returnSKUS = false;
            }

            setTimeout(() => {
                let modalShade = document.querySelector(".modal-backdrop.fade.show");
                modalShade ? modalShade.remove() : null;
                this.modalShade = modalShade.outerHTML;
                this.modalBody = document.querySelector("#addProductModal .modal-body").innerHTML;

                // Resetting search modal data
                this.resetData(true, false);

                // Initiate draggable
                setTimeout(() => {
                    $('.modal-dialog').draggable({
                        handle: ".modal-moveable"
                    });
                }, 1000);
                
                //Get default categories
                if (this.calledFrom === 'productModule') {
                    this.$parent.$parent.getEasyAskProducts();
                } else if (['megaMenuScreen', 'campaignScreen'].includes(this.calledFrom)) {
                    this.$parent.getEasyAskProducts();
                } else if (this.calledFrom === 'categoryModule' || this.calledFrom === 'productClassificationModule') {
                    this.categoryOptions = this.$parent.$parent.$parent.easyAskDefaultProductCategories;
                }
            }, 100);
        },

        changeCurrentPage(next = true) {
            let currentPage = this.pagination.currentPage;

            next && this.pagination.currentPage < this.pagination.pageCount
                ? this.pagination.currentPage++
                : false;

            !next && this.pagination.currentPage > 1
                ? this.pagination.currentPage--
                : false;

            currentPage !== this.pagination.currentPage
                ? (['dataTransformationTestScreen', 'megaMenuScreen', 'campaignScreen'].includes(this.calledFrom)
                    ? this.$parent.getEasyAskProducts()
                    : this.$parent.$parent.getEasyAskProducts())
                : false;
        },

        renderTooltip() {
            this.$root.renderTooltip();
        },

        setDebounce() {
            clearTimeout(this.timer);
            this.timer = setTimeout(() => {
                if (this.calledFrom === 'productModule') {
                    this.resetData(false, false);
                    this.$parent.$parent.resetNavPath();
                    this.$parent.$parent.getEasyAskProducts();
                } else if (this.calledFrom === 'categoryModule' || this.calledFrom === 'productClassificationModule') {
                    if (this.isSeoPathRemoved) {
                        this.$parent.$parent.getEasyAskProducts();
                    } else {
                        this.resetData(false, false);
                        this.$parent.$parent.resetNavPath();
                        this.$parent.$parent.getEasyAskProducts();
                    }
                } else if (['dataTransformationTestScreen', 'megaMenuScreen', 'campaignScreen'].includes(this.calledFrom)) {
                    if (this.isSeoPathRemoved) {
                        this.$parent.getEasyAskProducts();
                    } else {
                        this.resetData(false, false);
                        this.$parent.resetNavPath();
                        this.$parent.getEasyAskProducts();
                    }
                }
            }, 600)
        },

        addProducts(isAll = false) {
            if (this.selectedProductsArr.length > 0 || isAll) {
                if (this.module === 'data-transformations') {
                    let selectedProducts = [];
                    selectedProducts = isAll ? this.allProductsSelectedItems : this.selectedProductsArr;
                    this.$parent.$parent.checkAndRemoveProductsFromCurrentProducts(selectedProducts);
                    this.$parent.$parent.allProducts = this.$parent.$parent.allProducts.concat(selectedProducts);
                    this.$parent.$parent.dataTransformationData.products_list = this.$parent.$parent.allProducts;

                    new Noty({
                        type: "success",
                        text: `Product added successfully!`,
                    }).show();

                    document.querySelector("#cancelButton").click();
                    this.selectedProductsArr = [];
                    if (isAll) {
                        this.allProductsSelectedItems = [];
                    }
                    this.$parent.$parent.saveDataToFile(true);
                } else if(['megaMenuScreen', 'campaignScreen'].includes(this.calledFrom)) {
                    let selectedProducts = isAll ? this.allProductsSelectedItems : this.selectedProductsArr;

                    for (const selectedProduct of selectedProducts) {
                        if (this.$parent.allProducts.findIndex(product => product.Product_Id === selectedProduct.Product_Id) >= 0) {
                            new Noty({
                                type: "error",
                                text: `Product is already selected.`,
                            }).show(); return;
                        }

                        selectedProduct.Attribute_Access    = this.$parent.$parent.defaultProductAttributeAccess;
                        selectedProduct.Product_Column_Size = this.$parent.$parent.defaultProductColumnSize;
                    }

                    this.$parent.allProducts = this.$parent.allProducts.concat(JSON.parse(JSON.stringify(selectedProducts)));

                    new Noty({
                        type: "success",
                        text: `Product added successfully!`,
                    }).show();

                    this.$refs.cancelButton.click();
                    this.selectedProductsArr = [];
                    this.allProductsSelectedItems = [];
                } else {
                    let productsThoseAreNotExistInCurrentProductList = _.differenceBy(this.selectedProductsArr, this.$parent.$parent.currentProducts, 'Product_Id');
                    if (this.$parent.$parent.currentProducts === "") {
                        this.$parent.$parent.currentProducts = [];
                    }
                    if (productsThoseAreNotExistInCurrentProductList.length) {
                        if (this.$parent?.$parent?.newProductIds) {
                            this.$parent
                                .$parent
                                .newProductIds
                                = productsThoseAreNotExistInCurrentProductList.map(ele => ele.Product_Id);
                        }

                        this.$parent
                            .$parent
                            .currentProducts
                            = this.$parent.$parent.currentProducts.concat(productsThoseAreNotExistInCurrentProductList);
                        this.$parent
                            .$parent
                            .currentProductsBackup
                            = this.$parent.$parent.currentProductsBackup.concat(productsThoseAreNotExistInCurrentProductList);

                        new Noty({
                            type: "success",
                            text: `Product added successfully!`,
                        }).show();
                        document.querySelector("#cancelButton").click();
                        this.selectedProductsArr = [];
                    } else {
                        new Noty({
                            type: "error",
                            text: `Product already exists in current products list`,
                        }).show();
                    }

                    this.$root.renderTooltip();

                }
            } else {
                new Noty({
                    type: "error",
                    text: `Please select at least one product to add`,
                }).show();
            }
        },

        selectedProducts(product) {
            if (this.isDataExistInArray(product, this.selectedProductsArr, "Product_Id")) {
                this.selectedProductsArr.forEach(((item, index) => {
                    if (product.Product_Id === item.Product_Id) {
                        this.selectedProductsArr.splice(index, 1);
                    }
                }));
            } else {
                this.selectedProductsArr.push(product);
            }
        },

        resetData(resetSiteSearch = false, showResetMessage = true) {
            if (resetSiteSearch) {
                this.$parent.$parent.site_search = '';
                this.$refs.top.site_search = '';

                this.$parent.$parent.navPath = _.cloneDeep(this.$parent.$parent.defaultNavPath);
            }

            this.attributes = [];
            this.attributeOptions = [];
            this.brands = [];
            this.brandOptions = [];
            this.categories = [];

            if (this.calledFrom === 'productModule' && resetSiteSearch) {
                this.categoryOptions = _.cloneDeep(this.categoryOptionsBackup);
            } else if (this.calledFrom === 'categoryModule' || this.calledFrom === 'productClassificationModule') {
                this.categoryOptions = this.$parent.$parent.$parent.easyAskDefaultProductCategories;
            } else if (['dataTransformationTestScreen', 'megaMenuScreen', 'campaignScreen'].includes(this.calledFrom)) {
                this.categoryOptions = this.$parent.easyAskDefaultProductCategories;
            }

            this.searchResultProducts = [];
            this.selectedProductsArr = [];
            this.pagination = _.cloneDeep(this.paginationBackup);

            showResetMessage
                ? new Noty({
                    type: "success",
                    text: 'Reset Successful!',
                }).show()
                : false;
        },

        selectedCategory(category) {
            if (this.isDataExistInArray(category, this.categories, "nodeString"))
                this.categories.forEach(((item, index) => {
                    if (category.nodeString === item.nodeString) {
                        this.categories.splice(index, 1);
                    }
                }));
            else
                this.categories.push(category);

            this.makeDebounceSearch(null);
        },

        selectedBrand(brand) {
            if (this.isDataExistInArray(brand, this.brands, "nodeString")) {
                this.brands.forEach((item, index) => {
                    if (brand.nodeString === item.nodeString) {
                        this.brands.splice(index, 1);
                    }
                });
            } else {
                this.brands.forEach((item, index) => {
                    if (item.nodeString.indexOf('Price:') !== -1) {
                        this.brands.splice(index, 1);
                    }
                })
                this.brands.push(brand);
            }

            this.makeDebounceSearch(brand.seoPath);
        },

        selectedAttribute(attribute) {
            console.log('attribute', attribute);
        },

        isDataExistInArray(data, dataArr, checkPropertyName) {
            let __FOUND = false;
            if (dataArr.length) {
                __FOUND = dataArr.find(function (item, index) {
                    return item[checkPropertyName] == data[checkPropertyName];
                });
            }
            return __FOUND;
        },

        makeDebounceSearch(siteSearch = null) {
            clearTimeout(this.timer);
            this.timer = setTimeout(() => {
                ['dataTransformationTestScreen', 'megaMenuScreen', 'campaignScreen'].includes(this.calledFrom)
                    ? this.$parent.getEasyAskProducts(null, siteSearch)
                    : this.$parent.$parent.getEasyAskProducts(null, siteSearch);
            }, 600)
        },

        categoryNameWithLength({ name, productCount }) {
            return `${name} (${productCount})`
        },

        brandNameWithLength({ attributeValue, productCount }) {
            return `${attributeValue} (${productCount})`
        },

        selectAllProductsOfSearchScreen(isAll = false) {
            if (this.searchResultProducts.length === 0) {
                new Noty({
                    type: "warning",
                    text: 'No products found to select',
                }).show();
                return;
            }

            if (isAll) {
                this.pagination.resultsPerPage = "All";
                this.$parent.$parent.isSelectAllProductsFromCategoryBtnClicked = true;
                this.$parent.$parent.getEasyAskProducts();
            } else {
                $('.checkedSearchedProducts').prop('checked', true);
                this.selectedProductsArr = _.cloneDeep(this.searchResultProducts);
                this.addProducts();
            }
        },
    },

    computed: {
        _() {
            return _;
        },
        placeholderImage() {
            return this.$root.config.fallback_image;
        },
        perPages() {
            return this.$root.config.pagination_options;
        },
    }
}
</script>

<style lang="scss">
#searchProductModal {

    #result-table tr td:first-child,
    #result-table tr th:first-child {
        width: 13% !important;
    }

    #result-table tr td:not(first-child),
    #result-table tr th:not(first-child) {
        width: 29% !important;
    }

    .custom-border-right {
        border-right: 1px solid rgba(0, 40, 100, .12);
    }

    .custom-border {
        border: 1px solid rgba(0, 40, 100, .12);
    }

    .custom-sub-title {
        font-size: 15px;
    }

    .div-fixed {
        overflow-y: auto;
        height: 95px;
    }
}
</style>

<style>
.hover-me:hover {
    background-color: #f4f7fb;
}

.text-hover-danger:hover {
    color: #df4759;
}

.wait {
    width: 100%;
    height: 100%;
    background: #dddddd2b;
    z-index: 100;
    position: absolute;
}

.modal-content.ui-resizable {
    overflow: scroll;
}

.modal-moveable {
    cursor: move;
}
</style>
