<template>
    <div role="tabpanel" class="tab-pane active"
         id="tab_skus">

        <div class="row">
            <!-- load the view from type and view_namespace option if set -->

            <!-- hidden input -->
            <div class="hidden">
                <input type="hidden" name="skus" value="" class="form-control">
            </div>

            <div class="col-12">
                <div class="card mb-3">
                    <div class="card-body row">
                        <div class="form-group col-sm-12 mb-0">

                            <!-- Pagination -->
                            <div class="w-100 d-flex justify-content-between my-2">
                                <label class="m-0">
                                    Filter Current SKU List
                                    <i v-if="searching" class="la la-spinner la-pulse"></i>
                                    <small>
                                        (Showing {{ selectedSKUSPagination.firstItem }} to
                                        {{ selectedSKUSPagination.lastItem }} of
                                        {{ selectedSKUSPagination.totalItems }} items)
                                    </small>
                                </label>

                                <div class="pagination">
                                    <span class="btn btn-outline-default mr-1"
                                          :class="selectedSKUSPagination.currentPage <= 1
                                              ? 'disabled'
                                              : 'text-dark cursor-pointer'"
                                          @click="changeCurrentPageInSelectedSKUS(false)"
                                          :title="`${selectedSKUSPagination.currentPage <= 1
                                                        ? ''
                                                        : 'Previous (' + (selectedSKUSPagination.currentPage - 1) + ')'}`">
                                        <i class="la la-less-than"></i>
                                    </span>
                                    <select v-model="selectedSKUSPagination.resultsPerPage"
                                            class="rounded border border-secondary"
                                            title="Results Per Page"
                                            @change="onChangePaginationDropdown()">
                                        <option :value="perPage" v-for="perPage in selectedSKUSPerPages" :key="perPage">
                                            {{ perPage }}
                                        </option>
                                    </select>
                                    <span class="btn btn-outline-default ml-1"
                                          :class="selectedSKUSPagination.currentPage >= selectedSKUSPagination.pageCount
                                                      ? 'disabled'
                                                      : 'text-dark cursor-pointer'"
                                          @click="changeCurrentPageInSelectedSKUS(true)"
                                          :title="`${selectedSKUSPagination.currentPage >= selectedSKUSPagination.pageCount
                                                                ? ''
                                                                : 'Next (' + (selectedSKUSPagination.currentPage + 1) + ')'}`">
                                        <i class="la la-greater-than"></i>
                                    </span>
                                </div>
                            </div>

                            <!-- Searching input -->
                            <input type="text" class="form-control"
                                   :readonly="searching"
                                   v-model="site_search"
                                   placeholder="Search Text...">

                        </div>

                        <hr class="w-100">

                        <div class="form-group col-sm-12 mb-0">
                            <div class="d-flex justify-content-between mb-2">
                                <label class="mb-0 my-auto">Current SKU List</label>
                                <div>
                                    <button class="btn btn-default btn-sm"
                                            @click="resetSelectedSKUData(true);"
                                            data-toggle="tooltip" data-placement="top" title="Reset Search">
                                        <i class="la la-history"></i>
                                    </button>
                                    <button class="btn btn-default btn-sm"
                                            @click="getSKUProductsList();"
                                            data-toggle="tooltip" data-placement="top" title="Refresh List">
                                        <i :class="{'la-pulse': fetchingList}" class="las la-sync"></i>
                                    </button>
                                    <div class="btn-group">
                                        <button
                                            @click="setSettings('view', 'list').$root.renderTooltip()"
                                            :class="{'active' : settings.view === 'list'}"
                                            data-toggle="tooltip" data-placement="top"
                                            :title="`List ${settings.view === 'list' ? '(active)' : ''}`"
                                            class="btn btn-sm btn-default">
                                            <i class="las la-list"></i>
                                        </button>
                                        <button
                                            @click="setSettings('view', 'grid').$root.renderTooltip()"
                                            :class="{'active' : settings.view === 'grid'}"
                                            data-toggle="tooltip" data-placement="top"
                                            :title="`Grid ${settings.view === 'grid' ? '(active)' : ''}`"
                                            class="btn btn-sm btn-default">
                                            <i class="las la-th-large"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div v-if="loading">
                                <Loader/>
                            </div>
                            <div v-else>
                                <div v-if="settings.view === 'list'">
                                    <div class="d-block rounded overflow-hidden mb-3 border tableFixHead">
                                        <table id="list-table" :key="reRenderListTable"
                                               class="table table-default table-hover m-0">
                                            <thead>
                                            <tr>
                                                <th scope="col" class="text-nowrap">SKU PRODUCT ID</th>
                                                <th scope="col" class="text-nowrap">SKU Image</th>
                                                <th scope="col" class="text-nowrap">SKU Name</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                            </thead>
                                            <tbody class="scrollable_product_list">
                                            <tr v-if="listsSKUProducts.length" v-for="(product,index) in listsSKUProducts" draggable="true" @dragstart="dragStart" @dragover="dragOver" @dragend="dragEnd" :data-id="product.id" :data-reorder="product.reorder">
                                                <td>
                                                    {{ product.id }}
                                                </td>
                                                <td>
                                                    <img @error="$root.getDefaultImage"
                                                         class="img-thumbnail height-list-product pointer-event-none"
                                                         :src="`${product.product_image ? product.product_image.main : placeholder}`"
                                                         alt="">
                                                </td>
                                                <td>
                                                    {{ product.local_product_name }}
                                                </td>
                                                <td>
                                                    <button class="btn btn-danger btn-sm"
                                                            @click="removeSKUProductFromList(product.id)"
                                                            data-toggle="tooltip" data-placement="top" title="Remove">
                                                        <i class='lar la-trash-alt'></i>
                                                    </button>
                                                    <button @click="editSKUProduct(product)"
                                                            class="btn btn-primary btn-sm" data-toggle="tooltip"
                                                            data-placement="top" title="Edit">
                                                        <i class="lar la-edit"></i>
                                                    </button>
                                                    <button class="btn btn-secondary btn-sm" data-toggle="tooltip"
                                                            @click="viewSKUProduct(product)"
                                                            data-placement="top" title="View">
                                                        <i class="lar la-eye"></i>
                                                    </button>
                                                    <button class="btn btn-success btn-sm" data-toggle="tooltip"
                                                            @click="cloneSKUProduct(product)"
                                                            data-placement="top" title="Clone">
                                                        <i class="lar la-copy"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            <tr v-if="!listsSKUProducts.length">
                                                <td class="text-center" colspan="100%" style="width: 100%!important">
                                                    {{ noProductFound }}
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div v-if="settings.view === 'grid'">
                                    <div class="container product-container mt-3 mb-0 px-0" :key="reRenderListTable">
                                        <div class="form-row scrollable_product_grid">
                                            <div class="col-6 col-xl-4 col-xxl-4 col-xxxl-3 mb-2 mt-1"
                                                 v-if="listsSKUProducts.length"
                                                 v-for="(product, index) in listsSKUProducts"
                                                 :title="product.Product_Name"
                                                 data-toggle="tooltip"
                                                 data-placement="top"

                                                 draggable="true"
                                                 @dragstart="dragStart"
                                                 @dragover="dragOver"
                                                 @dragend="dragEnd"
                                                 :data-id="product.id"
                                                 :data-reorder="product.reorder"
                                                 >
                                                <!-- bbb_deals -->
                                                <div class="bbb_deals pb-2 pt-5 px-3 px-xl-2">
                                                    <div class="bbb_deals_title">
                                                        <small>SKU PRODUCT ID: # {{ product.id }}</small>
                                                    </div>
                                                    <div class="bbb_deals_slider_container">
                                                        <div class=" bbb_deals_item">
                                                            <div class="bbb_deals_image">
                                                                <img @error="$root.getDefaultImage"
                                                                     class="img-thumbnail product-height modal-image  pointer-event-none"
                                                                     :src="`${product.product_image ? product.product_image.main : placeholder}`"
                                                                     :alt="product.Product_Name">
                                                            </div>


                                                            <div class="bbb_deals_content mt-3">
                                                                <div
                                                                    class="bbb_deals_info_line d-flex flex-row justify-content-start">
                                                                    <div class="bbb_deals_item_name ellipsis">
                                                                        <small>{{
                                                                                product.Product_Name
                                                                            }}</small>
                                                                    </div>
                                                                </div>
                                                                <div class="w-100 text-center">
                                                                    <button class="btn btn-danger btn-sm"
                                                                            @click="removeSKUProductFromList(product.id)"
                                                                            data-toggle="tooltip" data-placement="top"
                                                                            title="Remove">
                                                                        <i class='lar la-trash-alt'></i>
                                                                    </button>
                                                                    <button @click="editSKUProduct(product)"
                                                                            class="btn btn-primary btn-sm"
                                                                            data-toggle="tooltip"
                                                                            data-placement="top" title="Edit">
                                                                        <i class="lar la-edit"></i>
                                                                    </button>
                                                                    <button class="btn btn-warning btn-sm"
                                                                            data-toggle="tooltip"
                                                                            @click="viewSKUProduct(product)"
                                                                            data-placement="top" title="View">
                                                                        <i class="lar la-eye"></i>
                                                                    </button>
                                                                    <button class="btn btn-success btn-sm"
                                                                            data-toggle="tooltip"
                                                                            @click="cloneSKUProduct(product)"
                                                                            data-placement="top" title="Clone">
                                                                        <i class="lar la-copy"></i>
                                                                    </button>
                                                                </div>
                                                                <div class="available d-none">
                                                                    <div
                                                                        class="available_line d-flex flex-row justify-content-start">
                                                                        <div class="available_title">
                                                                            Available: <span>6</span>
                                                                        </div>
                                                                        <div class="sold_stars ml-auto">
                                                                            <i class="fa fa-star"></i>
                                                                            <i class="fa fa-star"></i>
                                                                            <i class="fa fa-star"></i>
                                                                            <i class="fa fa-star"></i>
                                                                            <i class="fa fa-star"></i>
                                                                        </div>
                                                                    </div>
                                                                    <div class="available_bar"><span
                                                                        style="width:17%"></span></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div v-if="!listsSKUProducts.length" class="w-100">
                                                <NoItemFound :message="noProductFound" ref="noItemFound"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="btn-group border-light rounded d-flex" id="componentDiv">
                    <span class="bg-light btn btn-link cursor-pointer text-dark text-decoration-none"
                          :class="{'active' : optionType === 'creator'}"
                          @click="optionType='creator'"> {{ creatorTitle }} New SKU's
                    </span>
                    <span style="height: auto; width: 3px; background: rgb(224 229 236);"></span>
                    <span class="btn btn-success cursor-pointer font-weight-bold"
                          :class="{'active' : optionType === 'selector'}"
                          @click="isActionFromProductList ? optionType='creator' : optionType='selector'">Select New SKU's
                    </span>
                </div>

                <component :is="optionType" :ref="optionType"></component>
            </div>

        </div>
    </div>
</template>

<script>
import Creator     from "./Creator";
import Selector    from "./Selector";
import _           from "lodash";
import NoItemFound from "../../../../components/NoItemFound";
import Top         from "../../../../components/search-product-modal/body/Top";
import Loader      from "../../../../components/Loader";
import $           from "jquery";


export default {
    name: "SKUS",

    components: {
        Creator, Selector, NoItemFound, Top, Loader
    },

    data() {
        return {
            creatorTitle                : 'Create',
            optionType                  : 'selector',
            validationErrors            : {},
            skus_search                 : '',
            searching                   : false,
            skuProductSearchURL         : '/admin/product/fetch/sku-products',
            skuProductListByIdURL       : '/admin/product/fetch/sku-product-list-by-id',
            productBySkuIdUrl           : "/admin/product/fetch/product-by-sku-id",
            placeholder                 : this.$root.placeholder,
            axios_sku_create_url        : '/admin/product/sku/create',
            axios_sku_update_url        : '/admin/product/sku/update',
            axios_sku_delete_url        : '/admin/product/sku/remove',
            method                      : 'post',
            locale                      : this.$parent.locale,
            showInline                  : false,
            reRenderCreatorBlock        : 0,
            reRenderAddTable            : 0,
            reRenderListTable           : 0,
            searchResultSKUProducts     : [],
            listsSKUProducts            : [],
            parent_id                   : '',
            productData                 : {
                product_type : 'Normal',
                product_image: {
                    main: ''
                },
            },
            allAttributes               : [],
            selectedAttributeOptions    : [],
            productAttributeValues      : [],
            image                       : {
                main: {
                    directory: ""
                },
            },
            disableFields               : false,
            fetchingList                : false,
            productForViewAction        : [],
            isActionFromProductList     : false,
            pagination                  : {
                currentPage      : 1,
                firstItem        : 0,
                isDrillDownActive: false,
                lastItem         : null,
                pageCount        : 0,
                resultsPerPage   : 12,
                totalItems       : 0,
            },
            paginationBackup            : [],
            perPages                    : this.$root.config.pagination_options,
            defaultAttributes           : [],
            selectedSKUProductsArr      : [],
            multipleSelect              : false,
            productAddedCount           : 0,
            productExistCount           : 0,
            productFailedToAddCount     : 0,
            multipleSelectAddEvent      : false,
            loadingBtnOnAdd             : false,
            noProductFound              : "No product found",
            selectedSKUSPaginationBackup: {
                currentPage   : 1,
                firstItem     : 0,
                lastItem      : 0,
                pageCount     : 0,
                resultsPerPage: 12,
                totalItems    : 0,
            },
            selectedSKUSPagination      : [],
            selectedSKUSPerPages        : [2, 6, 12, 24, 48, 96, 150, 500],
            fromSelectedList            : true,
            settings                    : {
                view: null
            },
            defaultSettings             : {
                view: 'grid'
            },
            site_search                 : '',
            loading                     : true,
            EAProduct                   : {
                url : "/admin/product/fetch/easy-ask-products",
                data: [],
            },
            skuProductsCountToAdd       : 0,
            allSKUProductsInList        : [],
            returnSKUS                  : false,
            returnSKUSClicked           : false,
            draggingRow                 : null,
            dragOverRow                 : null,
        }
    },

    mounted() {
        this.$parent.checkIfProductCode();
        this.$parent.getDynamicCurrentPreviousTabIds();
        this.$parent.checkIfProductIsSavedWhenClickingSKUSTab();
        this.selectedSKUSPagination = _.cloneDeep(this.selectedSKUSPaginationBackup);
        this.getAllAttributes();
        this.image.main.directory = "uploads/images/product/"
                                    + this.slugify(this.$parent.productData.product_code)
                                    + "/main";
        this.parent_id            = this.$parent.productData.id;
        this.getSKUProductListByParentId();

        if (this.creatorTitle === "Create") {
            this.selectedAttributeOptions = this.$parent.productData.sku_default_attributes;
            this.defaultAttributes        = _.cloneDeep(this.$parent.productData.sku_default_attributes);
        }

        this.getSettings();
        this.$root.renderTooltip();
        this.paginationBackup = _.cloneDeep(this.pagination);
    },

    methods: {
        resetData(resetSiteSearch = false, showResetMessage = true) {
            if (resetSiteSearch) {
                this.skus_search             = '';
                this.searchResultSKUProducts = [];
                this.pagination              = _.cloneDeep(this.paginationBackup);

            }

            new Noty({
                type: "success",
                text: 'Reset Successful!',
            }).show()

        },

        removeError(key) {
            let errorsObject = this.$parent.validationErrors;
            let errorExist   = errorsObject[key];
            if (errorExist) {
                delete errorsObject[key];
            }
            //for re-render parent component
            if (Object.keys(errorsObject).length <= 0) {
                this.$parent.validationErrors = "";
            }
            this.$parent.validationErrors = errorsObject;
        },

        capitalizeFirstLetter(string) {
            return string.charAt(0).toUpperCase() + string.slice(1);
        },

        slugify(name) {
            if (!_.isEmpty(this.$parent.productData.product_classification)) {
                return name.replace(/[^A-Z0-9]/ig, "_").toLowerCase();
            }
        },

        getAllAttributes() {
            axios.post('/admin/product/fetch/attributes')
                .then(response => {
                    this.allAttributes = response.data;
                })
                .catch(err => {
                    console.error(err)
                });
        },

        resetCreateBlock() {
            this.selectedAttributeOptions = [];
            this.getAllAttributes();
            this.productData            = {
                sku_id         : '',
                product_name   : '',
                product_code   : '',
                description    : '',
                sku_part_number: '',
                product_type   : 'Normal',
                product_image  : {
                    main: ''
                },
                selling_price  : '',
                selling_price  : '',
                qty_interval   : '',
            }
            this.productAttributeValues = [];
            this.reRenderCreatorBlock++;
        },

        getOriginalSkuID(sku_string) {
            //convert sku_id to array
            let split_sku = sku_string.split("-");
            //remove_first_element
            split_sku.shift();
            // join sku id
            let original_sku_id = split_sku.join('-');
            return original_sku_id;
        },

        getEasyAskProducts(product_id = null, siteSearch = null) {
            let skus_search = _.trim(_.cloneDeep(this.skus_search));

            if (skus_search.length === 0 || skus_search.length >= 2) {
                this.fetchingList = true;
                this.searching    = true;
                let site_search   = siteSearch ?? `-${skus_search}`
                let pagination    = new URLSearchParams(this.pagination).toString();

                if (site_search === 'SKUS') {
                    let isProductIdaNumber = Number.isInteger(parseFloat(product_id))
                    if (isProductIdaNumber) {
                        if (this.checkIfProductAlreadyExistInList(parseFloat(product_id.trim()))) {
                            this.showAlertMessage("error", "Product already exist in the list.");
                            return;
                        }

                        site_search                                           = `-${this.$parent.product_search_by_id_prefix}=${parseFloat(product_id)}`
                        this.$refs.selector.$refs.bottom.smallLoader          = true;
                        this.$refs.selector.$refs.bottom.search_by_product_id = parseFloat(product_id);
                    } else {
                        new Noty({type: "warning", text: 'Product ID must be integer'}).show();
                        return;
                    }
                }

                let url = `${this.EAProduct.url}?site_search=${site_search}&${pagination}&returnSKUS=${this.returnSKUS}`;

                axios.post(url)
                    .then(({data}) => {
                        if (!data.noResultsMessage) {
                            if (data.products?.items && data.products.items.length > 0) {
                                data.products.items.map((product, index) => {
                                    product.isSkuProduct = (JSON.parse(product.Sku_List).length === 1 && product?.Sku_ProductCode && (product.Sku_ProductCode === JSON.parse(product.Sku_List)[0][1])) ?? false;
                                });
                            }
                            if (!_.isNull(product_id)) {
                               if (!data.products?.items.length || (this.parent_id == data.products.items[0].Product_Id)) {
                                    new Noty({
                                        type: "error",
                                        text: 'Product not found'
                                    }).show();

                                    return;
                                }

                                let productData = data.products.items[0];
                                this.addSKUToList(productData);
                                this.$refs.selector.$refs.bottom.search_by_product_id = null;
                                Selector.components.Bottom.methods.resetSearchByProductId();
                            } else {
                                (data.products?.items ?? []).filter(item => item.is_checked = false);
                                this.searchResultSKUProducts = data.products.items ?? [];
                                this.searchResultSKUProducts.forEach((ele, index) => {
                                    this.allSKUProductsInList.forEach((list_ele) => {
                                        if (ele.Product_Id == list_ele) {
                                            this.searchResultSKUProducts[index].duplicate = true;
                                        }
                                    });
                                });
                                let paginationData = data.products.itemDescription;
                                this.pagination    = {
                                    currentPage   : paginationData.currentPage,
                                    firstItem     : paginationData.firstItem,
                                    lastItem      : paginationData.lastItem,
                                    pageCount     : paginationData.pageCount,
                                    resultsPerPage: paginationData.resultsPerPage,
                                    totalItems    : paginationData.totalItems,
                                };
                            }
                        } else {
                            new Noty({
                                type: "warning",
                                text: data.noResultsMessage
                            }).show();
                        }
                    })
                    .catch((error) => {
                        new Noty({
                            type: "error",
                            text: error.message
                        }).show();
                    })
                    .finally(() => {
                        this.searching = false;
                        this.$root.renderTooltip();
                        this.fetchingList = false;

                        if (!_.isNull(product_id)) {
                            this.$refs.selector.$refs.bottom.smallLoader = false;
                        }
                    });

            } else {
                new Noty({
                    type: "warning",
                    text: 'Type at least 2 characters in search box'
                }).show();
            }
        },

        getSKUProductListByParentId() {
            this.fetchingList = true;
            let url           = `${this.skuProductListByIdURL}?parent_id=${this.parent_id}`;
            axios.post(url)
                .then(({data}) => {
                    this.listsSKUProducts     = Object.values(data.data);
                    this.allSKUProductsInList = Object.values(data.all_data);

                    this.selectedSKUSPagination = {
                        currentPage   : data.current_page,
                        firstItem     : data.from,
                        lastItem      : data.to,
                        pageCount     : data.last_page,
                        resultsPerPage: data.per_page,
                        totalItems    : data.total,
                    };

                    this.reRenderListTable++;
                })
                .catch((e) => {
                    console.error(e);
                    this.showAlertMessage("error", "Something went wrong.");
                })
                .finally(() => {
                    this.fetchingList = false;
                    this.loading      = false;
                    this.$root.renderTooltip();

                    // Manage Edit & preview form product list
                    let getURL            = new URL(location.href);
                    let simple_product_id = getURL.searchParams.get("simple_product_id"),
                        action            = getURL.searchParams.get("action");

                    simple_product_id ? this.actionForSimpleProduct(simple_product_id, action) : false;
                })
        },

        actionForSimpleProduct(simple_product_id, action) {
            if (simple_product_id !== null && action !== null) {
                this.isActionFromProductList = true;
                let product                  = this.listsSKUProducts.find(ele => ele.id
                                                                                 === parseInt(simple_product_id));
                if (action === 'edit') {
                    this.editSKUProduct(product);
                } else if (action === 'view') {
                    this.viewSKUProduct(product);
                } else if (action === 'create') {
                    this.optionType = "Creator"
                }
            }
        },

        addSKUToList(product = {}, index = null) {
            let productId = product.isSkuProduct
                            ? JSON.parse(product.Sku_List)[0][0]
                            : product.Product_Id;
            if (this.checkIfProductAlreadyExistInList(productId)) {
                this.showAlertMessage("error", "Product already exist in the list.");
            } else {
                this.saveSelectedProductIntoDatabase(product, false, true);
                this.$root.renderTooltip();
            }
        },

        removeSKUProductFromList(productID) {
            this.$swal({
                title: 'Remove this product?',
                //icon              : 'warning',
                showCancelButton  : true,
                confirmButtonColor: '#ff6b81',
                cancelButtonColor : '#399E7F',
                confirmButtonText : 'Remove'

            }).then((result) => {
                if (result.isConfirmed) {
                    axios.post(`${this.axios_sku_delete_url}/${this.$parent.productData.id}/${productID}`).then((response) => {
                        this.showAlertMessage("success", "SKU Product has been removed successfully!");
                        if (this.isActionFromProductList) {
                            this.returnToProductList();
                        } else {
                            this.reRenderListTable++;
                            this.optionType = 'selector';
                        }
                    }).catch((e) => {
                        console.error(e);
                        this.showAlertMessage("error", "Something went wrong. Can not remove product.");
                    }).finally(() => {
                        this.getSKUProductListByParentId();
                    });
                }
            });
        },

        removeSKUProductFromSearchResult(productID) {
            this.searchResultSKUProducts.forEach(((item, index) => {
                if (productID === item.id) {
                    this.searchResultSKUProducts.splice(index, 1);
                }
            }));
            this.reRenderAddTable++;
        },

        checkIfProductAlreadyExistInList(productSkuId) {
            //let old_sku_id = productSkuId.split('-').slice(1).join('-');
            //let new_sku_id = this.parent_id + '-' + productSkuId;
            return Boolean(this.allSKUProductsInList.find(ele => ele == productSkuId));
        },

        async processProductData() {
            this.selectedAttributeOptions.filter((ele, ind) => {
                this.productAttributeValues.push({
                    attribute_id   : ele.id,
                    attribute_value: ele.attribute_value ?? '',
                });
            });

            // let new_sku_id = this.productData.sku_id ? this.parent_id + "-" + this.productData.sku_id : null;

            return {
                id                    : this.productData.id,
                parent_id             : this.parent_id,
                // sku_id                : new_sku_id,
                product_name          : this.productData.local_product_name ?? null,
                product_type          : this.productData.product_type.toLowerCase(),
                attributes            : this.selectedAttributeOptions.map(ele => ele.id),
                product_code          : this.productData.product_code ?? null,
                description           : this.productData.local_description ?? null,
                sku_part_number       : this.productData.sku_part_number ?? null,
                main                  : this.productData.product_image.main,
                selling_price         : this.productData.selling_price
                                        ? parseFloat(this.productData.selling_price).toFixed(2)
                                        : null,
                locale                : this.locale,
                productAttributeValues: this.productAttributeValues,
                min_order_qty         : this.productData.min_order_qty ?? 1,
                qty_interval          : this.productData.qty_interval ?? 1,
            }
        },

        async saveSKUData(buttonClicked) {
            let productData       = await this.processProductData();
            this.validationErrors = {};
            let url               = `${this.axios_sku_create_url}?locale=${this.locale}`;

            if (buttonClicked === 'update') {
                url = `${this.axios_sku_update_url}?locale=${this.locale}`;
            }

            axios[this.method](url, productData).then((response) => {

                if (buttonClicked === 'save') {
                    this.resetCreateBlock();
                    this.afterSaveOrClone('save');
                }

                if (buttonClicked === 'clone') {
                    this.productData.sku_id = '';
                    this.afterSaveOrClone('clone');
                }

                if (buttonClicked === 'update') {
                    this.resetCreateBlock();
                    this.afterUpdate();
                }

            }).catch((e) => {

                console.error(e);
                this.validationErrors = e.response.data.errors;
                this.showAlertMessage("error", "The given data was invalid.");
            })
        },

        afterSaveOrClone(actionType) {
            this.showAlertMessage("success", "SKU product has been saved and added to the list successfully!");

            if (this.isActionFromProductList) {
                this.returnToProductList();
            } else {
                this.getSKUProductListByParentId();
                if (actionType === 'save') {
                    this.optionType = 'selector';
                } else if (actionType === 'clone') {
                    this.optionType = 'creator';
                }
                this.reRenderListTable++;
            }
        },

        afterUpdate() {
            this.showAlertMessage("success", "SKU product has been updated and added to the list successfully!");

            if (this.isActionFromProductList) {
                this.returnToProductList();
            } else {
                this.getSKUProductListByParentId();
                this.optionType   = 'selector';
                this.creatorTitle = 'Create';
                this.reRenderListTable++;
            }
        },

        async saveSelectedProductIntoDatabase(product, multipleSelect = false, productById = false) {
            let productData = await this.processProductDataForSelectCloneEditView(product, true);

            axios.post(`${this.axios_sku_update_url}?locale=${this.locale}`, productData).then((response) => {
                if (! response.data.success) {
                    this.showAlertMessage("error", productData.product_name + " " + response.data.message);
                    this.loadingBtnOnAdd = false;
                    this.productFailedToAddCount += 1;
                } else {
                    if (multipleSelect) {
                        this.productAddedCount += 1;
                    } else {
                        this.afterSaveOrClone('save');
                    }
                }

            }).catch((e) => {
                if (multipleSelect) {
                    this.productFailedToAddCount += 1;
                } else {
                    console.error(e);
                    this.showAlertMessage("error", "Something went wrong. Can not save the product.");
                }

            }).finally(() => {
                if (multipleSelect
                    && (this.productAddedCount + this.productFailedToAddCount + this.productExistCount)
                    === this.skuProductsCountToAdd
                ) {
                    this.afterAddingMultipleSKUToList();
                }
            })

        },

        afterAddingMultipleSKUToList() {
            this.getSKUProductListByParentId();
            this.showMessageForMultipleSelect();
            this.loadingBtnOnAdd = false;
            this.getEasyAskProducts();
            this.selectedSKUProductsArr = [];
            this.skuProductsCountToAdd  = 0;
            this.reRenderAddTable++;
        },

        async processProductDataForSelectCloneEditView(product, select = false) {
            // let new_sku_id                = select? (product.isSkuProduct? JSON.parse(product.Sku_List)[0][0] : product.Product_Id) : product.sku_id.split('-').slice(1).join('-');
            let attributes                = select? [] : product.attributes.map(ele => ele.id);
            let productAttributeValues    = [];
            let selectedProductAttributes = [];
            let attributeValue            = []

            if (!select) {
                product.attributes.filter((ele, ind) => {
                    attributeValue = JSON.parse(ele.pivot.attribute_value);

                    productAttributeValues.push({
                        attribute_id   : ele.id,
                        attribute_value: this.getLocalData(attributeValue, this.locale),
                    });

                    selectedProductAttributes.push({
                        id             : ele.id,
                        local_name     : ele.local_name,
                        attribute_value: this.getLocalData(attributeValue, this.locale),
                    });
                });
            }

            return {
                id                       : select? (product.isSkuProduct? JSON.parse(product.Sku_List)[0][0] : product.Product_Id) : product.id,
                parent_id                : this.parent_id,
                // sku_id                   : (select ? this.parent_id + '-' : '') + new_sku_id,
                product_name             : select ? (product.isSkuProduct ? product.Sku_Name : product.Product_Name) : this.getLocalData(product.product_name, this.locale),
                product_type             : select ? 'normal' : product.product_type,
                attributes               : attributes,
                product_code             : select ? (product.isSkuProduct ? product.Sku_ProductCode : product.Product_Code) : product.product_code,
                description              : select ? null : this.getLocalData(product.description, this.locale),
                sku_part_number          : select ? null : product.sku_part_number,
                main                     : select ? (product.isSkuProduct ? product.Sku_ProductImage : product.Product_Image) : product.product_image.main,
                selling_price            : select ? (product.Price = (product.Price) ? product.Price.replace('$', '') : '') : product?.msrp ?? product?.selling_price ?? 0.00,
                min_order_qty            : product?.min_order_qty ?? 1,
                qty_interval             : product?.qty_interval ?? 1,
                productAttributeValues   : productAttributeValues,
                selectedProductAttributes: selectedProductAttributes,
                multipleSelect           : select,
            }
        },

        getLocalData(target, local = "en") {
            return target
                   ? target[local]
                     ?? target[this.$store.state.config.language]
                     ?? target["en"]
                     ?? target["fr"]
                   : '';
        },

        async showingDataIntoRelatedFields(productData) {
            this.productData.id                 = productData.id;
            this.productData.sku_id             = productData.sku_id;
            this.productData.local_product_name = productData.product_name;
            this.productData.product_type       = 'Normal';
            this.productData.product_code       = productData.product_code;
            this.selectedAttributeOptions       = productData.selectedProductAttributes;
            this.productData.local_description  = productData.description;
            this.productData.sku_part_number    = productData.sku_part_number;
            this.productData.product_image.main = productData.main;
            this.productData.selling_price      = productData.selling_price;
            this.productData.min_order_qty      = productData.min_order_qty;
            this.productData.qty_interval       = productData.qty_interval;
        },

        async commonFunctionalityForEditViewClone(product) {
            this.resetCreateBlock();
            let productData = await this.processProductDataForSelectCloneEditView(product);
            await this.showingDataIntoRelatedFields(productData);
            this.handleChangesOnAttributeOptions();
            this.reRenderCreatorBlock++;
            this.optionType = 'creator';
            this.$root.renderTooltip();
        },

        async editSKUProduct(product) {
            await this.commonFunctionalityForEditViewClone(product);
            this.creatorTitle  = 'Edit';
            this.disableFields = false;
            document.getElementById('componentDiv').scrollIntoView();
        },

        async viewSKUProduct(product) {
            await this.commonFunctionalityForEditViewClone(product);
            this.creatorTitle         = 'View';
            this.disableFields        = true;
            this.productForViewAction = product;
            document.getElementById('componentDiv').scrollIntoView();
        },

        async cloneSKUProduct(product, calledFrom = 'selectorPage') {
            if (calledFrom === 'searchModal') {
                Selector.components.SearchSkuModal.methods.closeSearchModal();
            }
            await this.commonFunctionalityForEditViewClone(product);
            this.creatorTitle       = 'Create';
            this.disableFields      = false;
            this.productData.sku_id = '';
            document.getElementById('componentDiv').scrollIntoView();
        },

        returnToProductList() {
            let getURL = new URL(location.href);
            window.location.replace(getURL.origin + "/admin/product");
        },

        showAlertMessage(type, text) {
            new Noty({
                type: type,
                text: text,
            }).show();
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
            ? this.getEasyAskProducts()
            : false;
        },

        handleChangesOnAttributeOptions() {
            let difference = _.differenceBy(this.defaultAttributes, this.selectedAttributeOptions, 'id');
            if (difference.length > 0) {
                this.selectedAttributeOptions
                    = _.orderBy(_.concat(this.selectedAttributeOptions, difference), ['id'], ['asc']);
            }
        },

        async addMultipleSKUToList() {
            if (this.selectedSKUProductsArr.length) {
                this.loadingBtnOnAdd = true;

                this.selectedSKUProductsArr.map((async (item) => {
                    this.skuProductsCountToAdd++;
                    if (this.checkIfProductAlreadyExistInList(item.Product_Id)) {
                        this.productExistCount += 1;
                    } else {
                        await this.saveSelectedProductIntoDatabase(item, true);
                    }
                }));

                if (this.productExistCount > 0 && (this.productExistCount === this.skuProductsCountToAdd)) {
                    let duplicateMessage = this.productExistCount + ' sku product(s) already exist in the list.';
                    this.showAlertMessage("error", duplicateMessage);
                    this.loadingBtnOnAdd        = false;
                    this.productExistCount      = 0;
                    this.skuProductsCountToAdd  = 0;
                    this.selectedSKUProductsArr = [];
                    this.getEasyAskProducts();
                }
            } else {
                this.showAlertMessage("warning", "Please select at least one product to add");
            }
        },

        selectedSKUProducts(product) {
            if (this.isDataExistInArray(product, this.selectedSKUProductsArr, "Product_Id")) {
                this.selectedSKUProductsArr.forEach(((item, index) => {
                    if (product.Product_Id === item.Product_Id) {
                        this.selectedSKUProductsArr.splice(index, 1);
                    }
                }));
            } else {
                this.selectedSKUProductsArr.push(product);
            }
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

        showMessageForMultipleSelect() {
            let successMessage     = this.productAddedCount + ' sku product(s) have been added to list.';
            let failedToAddMessage = 'Failed to add ' + this.productFailedToAddCount + ' sku product(s).';
            let duplicateMessage   = this.productExistCount + ' sku product(s) already exist in the list.';

            if (this.productAddedCount > 0) {
                this.showAlertMessage("success", successMessage);
                this.multipleSelectAddEvent = true;
                this.productAddedCount      = 0;
            }
            if (this.productFailedToAddCount > 0) {
                this.showAlertMessage("error", failedToAddMessage);
                this.productFailedToAddCount = 0;
            }
            if (this.productExistCount > 0) {
                this.showAlertMessage("error", duplicateMessage);
                this.productExistCount = 0;
            }
        },

        onSearchSkuProductModalClose() {
            if (this.multipleSelectAddEvent) {
                this.selectedSKUProductsArr = [];
                this.multipleSelectAddEvent = false;
            }
        },

        setDebounce(fromSelectedList = false, site_search = null) {
            clearTimeout(this.timer);
            this.timer = setTimeout(() => {
                if (fromSelectedList) {
                    this.getSKUProductsList(site_search);
                } else {
                    this.getEasyAskProducts();
                }
            }, 500)
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

        getSKUProductsList(search = null) {
            this.searching    = true;
            this.fetchingList = true;
            let pagination    = this.selectedSKUSPagination;
            let params        = {
                parent_id : this.parent_id,
                search    : search ?? '',
                pagination: pagination,
                page      : this.selectedSKUSPagination.currentPage,
                calledFrom: 'selector',
            };

            axios.post(this.skuProductSearchURL, params)
                .then(({data}) => {
                    this.listsSKUProducts       = Object.values(data.data);
                    this.selectedSKUSPagination = {
                        currentPage   : data.current_page,
                        firstItem     : data.from ?? 0,
                        lastItem      : data.to ?? 0,
                        pageCount     : data.last_page,
                        resultsPerPage: data.per_page,
                        totalItems    : data.total,
                    };
                    this.reRenderListTable++;
                })
                .catch(error => {
                    new Noty({
                        type: "error",
                        text: error.message
                    }).show();
                })
                .finally(() => {
                    this.searching    = false;
                    this.fetchingList = false;
                });
        },

        resetFilterData() {
            this.$refs.top.site_search  = '';
            this.selectedSKUSPagination = _.cloneDeep(this.selectedSKUSPaginationBackup);
            this.getSKUProductsList();

            new Noty({
                type: "success",
                text: 'Reset Successful!',
            }).show()
        },

        onChangePaginationDropdown() {
            this.selectedSKUSPagination.currentPage = 1;

            if (this.fromSelectedList) {
                this.setDebounce(this.fromSelectedList, this.site_search)
            }
        },

        changeCurrentPageInSelectedSKUS(next = true) {
            let currentPage = this.selectedSKUSPagination.currentPage;

            next && this.selectedSKUSPagination.currentPage < this.selectedSKUSPagination.pageCount
            ? this.selectedSKUSPagination.currentPage++
            : false;

            !next && this.selectedSKUSPagination.currentPage > 1
            ? this.selectedSKUSPagination.currentPage--
            : false;

            let site_search = null;
            if (this.fromSelectedList) {
                site_search = this.site_search;
            }

            currentPage !== this.selectedSKUSPagination.currentPage
            ? this.getSKUProductsList(site_search)
            : false;
        },

        resetSelectedSKUData() {
            this.site_search            = '';
            this.selectedSKUSPagination = _.cloneDeep(this.selectedSKUSPaginationBackup);
            this.getSKUProductsList();

            new Noty({
                type: "success",
                text: 'Reset Successful!',
            }).show()
        },

        selectAllProductsOfSearchScreen(isAll = false) {
            if (this.searchResultSKUProducts.length === 0) {
                new Noty({
                    type: "warning",
                    text: 'No products found to select',
                }).show();
                return;
            }

            if (isAll) {
                this.pagination.resultsPerPage                                 = "All";
                this.$parent.$parent.isSelectAllProductsFromCategoryBtnClicked = true;
                this.$parent.$parent.getEasyAskProducts();
            } else {
                $('.checkedSearchedProducts').prop('checked', true);
                this.selectedSKUProductsArr = _.cloneDeep(this.searchResultSKUProducts);
            }
        },
        dragStart(event){
            $(".scrollable_product_grid .bbb_deals_slider_container").addClass("pointer-event-none");
            this.draggingRow = event.target;
        },
        dragOver(e){
            e.preventDefault();

            let children= Array.from(e.target.parentNode.parentNode.children);

            if(children.indexOf(e.target.parentNode)>children.indexOf(this.draggingRow))
                e.target.parentNode.after(this.draggingRow);
            else
                e.target.parentNode.before(this.draggingRow);

            this.dragOverRow = e.target.parentNode;
        },
        dragEnd(e) {
            let children= Array.from(e.target.parentNode.children);
            let orderInfo = children.map(function(item, index) {
                return {
                    id: item.dataset.id,
                    reorder: index,
                }
            });

            axios.post('/admin/product/sku-reorder', {
                reorder: orderInfo
            }).then(response => {
                this.allAttributes = response.data;
            })
            .catch(err => {
                console.error(err)
            });
            $(".scrollable_product_grid .bbb_deals_slider_container").removeClass("pointer-event-none");
        },
    },

    watch: {
        site_search: function (newVal, oldVal) {
            if (newVal !== oldVal) {
                this.setDebounce(this.fromSelectedList, newVal);
            }
        },

        returnSKUS: function (newVal, oldVal) {
            if (this.skus_search.trim().length === 0) return

            if (newVal !== oldVal && this.returnSKUSClicked) {
                this.getEasyAskProducts();
                this.returnSKUSClicked = false;
            }
        },
    },
}
</script>

<style scoped>
.btn.active {
    font-weight: bold;
}

.cursor-pointer {
    cursor: pointer;
}

.scrollable_product_list {
    max-height: 250px !important;
    overflow-y: scroll !important;
}

.tableFixHead {
    max-height: 500px !important;
    overflow-y: auto !important;
}

.tableFixHead thead th {
    position: sticky;
    top: 0;
    z-index: 1;
}

.tableFixHead table {
    border-collapse: collapse;
    width: 100%;
}

th, td {
    padding: 8px 16px;
}

th {
    background: #eee !important;
}

.scrollable_product_grid {
    max-height: 500px !important;
    overflow-y: auto !important;
}
.pointer-event-none{
    pointer-events: none;
}
</style>
