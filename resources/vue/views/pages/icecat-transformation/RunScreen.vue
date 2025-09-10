<template>
    <div id="icecatTransformationRunScreen" class="animated fadeIn">
        <div class="row">
            <div class="col-md-12 bold-labels">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group"
                                :class="{'text-danger': validationErrors.name}">

                            <div class="d-flex justify-content-between">
                                <label>Transformation Name <span class="text-danger">*</span></label>
                            </div>
                            <input :class="{'is-invalid': validationErrors.name, 'form-control': true}"
                                                    type="text"
                                                    v-model="icecatTransformationName"
                                                    >

                            <small v-if="validationErrors.name"
                                    class="text-danger mt-3">{{
                                    validationErrors.name[0]
                                }}</small>

                            <small v-if="validationErrors.name"
                                    class="text-danger mt-3">{{ validationErrors.name[0] }}</small>
                        </div>
                        <div class="form-group"
                                :class="{'text-danger': validationErrors.name}">

                            <div class="d-flex justify-content-between">
                                <label>Transformation Definition <span class="text-danger">*</span></label>
                            </div>
                            <multiselect :class="{'is-invalid': validationErrors.name}"
                                                    v-model="icecatTransformation.id"
                                                    :options="transformationNames"
                                                    :multiple="false"
                                                    :close-on-select="true"
                                                    :clear-on-select="false"
                                                    :preserve-search="true"
                                                    :hide-selected="true"
                                                    placeholder="Pick an option"
                                                    label="name"
                                                    track-by="name">
                            </multiselect>
                            <small v-if="validationErrors.name"
                                    class="text-danger mt-3">{{
                                    validationErrors.name[0]
                                }}</small>

                            <small v-if="validationErrors.name"
                                    class="text-danger mt-3">{{ validationErrors.name[0] }}</small>
                        </div>
                        <SelectedProducts
                            calledFrom="productModule"
                            ref="selectedProducts"
                            :reRenderTable="reRenderTable"
                            type="category"
                            module="icecat-transformations"
                        ></SelectedProducts>

                        <div class="form-check-inline">
                            <label class="form-check-label">
                                <input type="radio" class="form-check-input" name="optradio" value="local" v-model="productFrom">Local Products
                            </label>
                        </div>

                        <div class="form-check-inline disabled">
                            <label class="form-check-label">
                                <input type="radio" class="form-check-input" name="optradio" value="easyask" v-model="productFrom">EasyAsk Products
                            </label>
                        </div>

                    </div>
                </div>

                <div id="saveActions" class="form-group">
                    <div class="btn-group" role="group">
                        <button type="submit" class="btn btn-success">
                            <span class="la la-save" role="presentation" aria-hidden="true"></span> &nbsp;
                            <span @click="actionType=saveAction.active.value; saveData()">{{ saveAction.active.label }}</span>
                        </button>
                        <div class="btn-group" role="group">
                            <button id="btnGroupDrop1" type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="caret"></span><span class="sr-only">▼</span></button>
                            <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">

                                <template v-for="(option, index) in saveAction.options">
                                    <button class="dropdown-item" @click="actionType=index; saveData()">{{ option }}</button>
                                </template>

                            </div>
                        </div>
                    </div>

                    <a :href="backUrl" class="btn btn-warning"><span
                        class="la la-ban"></span> &nbsp;Cancel</a>

                    <button class="btn btn-danger"
                            type="button"
                            @click="$refs.selectedProducts.removeAllProductsFromList();"
                            data-toggle="tooltip" data-placement="top" title="Remove All Products">
                        <i class="las la-trash-alt"></i>
                        Remove All
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import _                from "lodash";
import SelectedProducts from "../../components/icecat-selected-products/SelectedProducts";

export default {
    name      : "RunScreen",
    components: {
        SelectedProducts
    },
    props     : [
        'icecat_transformation_data', 'easy_ask_default_product_categories', 'locale', 'categories',
        'product_search_by_id_prefix', 'transformation_names', 'save_action'
    ],
    data() {
        return {
            backUrl                                  : '/admin/icecat-transformation',
            reRenderTable                            : 0,
            placeholderImage                         : this.$root.config.fallback_image,
            currentProductsBackup                    : [],
            currentProducts                          : [],
            allProducts                              : [],
            productFrom                              : 'easyask',
            productByIdUrl                           : "/admin/product/fetch/product-by-id",
            EAProduct                                : {
                localUrl : "/admin/product/fetch/products-list",
                easyAskUrl : "/admin/product/fetch/easy-ask-products",
                data: [],
            },
            icecatTransformation    : {
                id                  : null,
                name                : '',
            },
            icecatTransformationName: '',
            productList                              : {
                url : "/admin/icecat-transformation/fetch/selected-products-by-id",
                data: [],
            },
            site_search                              : "",
            navPath                                  : [],
            defaultNavPath                           : [
                {
                    englishName    : "All Products",
                    navNodePathType: 1,
                    path           : "All Products",
                    purePath       : "All Products",
                    seoPath        : "",
                    value          : "All Products",
                }
            ],
            defaultHeight                            : 350,
            searching                                : false,
            productData                              : [],
            isProductInList                          : false,
            categoryLoader                           : false,
            paginationBackup                         : {
                currentPage      : 1,
                firstItem        : 0,
                isDrillDownActive: false,
                lastItem         : 0,
                pageCount        : 0,
                resultsPerPage   : 1000,
                totalItems       : 0,
            },
            pagination                               : {},
            loadingAllCategories                     : true,
            paginationDataFromAPI                    : _.cloneDeep(this.paginationBackup),
            file_path                                : null,
            fileSaveURL                              : "/admin/icecat-transformation/fetch/save-to-session",
            runScriptUrl                             : "/admin/icecat-transformation/fetch/run-script",
            isSelectAllProductsFromCategoryBtnClicked: false,
            returnSKUS                               : false,
            returnSKUSClicked                        : false,
            validationErrors                         : {},
            transformationNames                      : JSON.parse(this.transformation_names),
            saveAction      : JSON.parse(this.save_action),
            actionType      : ""

        }
    },

    mounted() {
        this.resetNavPath();

        this.file_path                             = null;
        this.isProductInList                       = true;
        this.pagination                            = _.cloneDeep(this.paginationBackup);
        this.$refs.selectedProducts.noProductFound = 'No product has been selected';
        if (!_.isNull(this.file_path)) {
            this.allProducts = [];
            this.saveDataToSession();
        }
        // this.getProductList();
        this.$refs.selectedProducts.$refs.searchModal.showSelectAllItems = true;
    },

    methods: {
        //Gets Methods
        getProductsFromEasyAsk(product_id = null, siteSearch = null) {
                this.searching = true;
                this.$refs.selectedProducts.$refs.searchModal.fetchingList = true;
                let site_search = siteSearch ?? this.mergeSeoPaths(this.$refs.selectedProducts.$refs.searchModal);
                let pagination = new URLSearchParams(this.$refs.selectedProducts.$refs.searchModal.pagination).toString();

                if (site_search === 'productModule') {
                    let isProductIdaNumber = Number.isInteger(parseFloat(product_id))
                    if (isProductIdaNumber) {
                        site_search = `-${this.product_search_by_id_prefix}=${parseFloat(product_id)}`;
                        this.$refs.selectedProducts.$refs.bottom.smallLoader = true;
                        this.$refs.selectedProducts.$refs.bottom.search_by_product_id = parseFloat(product_id);
                    } else {
                        new Noty({type: "warning", text: 'Product ID must be integer'}).show();
                        return;
                    }
                }

                let url = `${this.EAProduct.easyAskUrl}?site_search=${site_search}&categoryProduct=true&categoryId=${this.category_id}&${pagination}&returnSKUS=${this.returnSKUS}`;

                axios.post(url)
                    .then(({data}) => {
                        if (!data.noResultsMessage) {
                            if (data.products?.items && data.products.items.length > 0) {
                                data.products.items.map((product, index) => {
                                    product.isSkuProduct = (
                                        JSON.parse(product.Sku_List).length === 1
                                        && product?.Sku_ProductCode
                                        && (product.Sku_ProductCode === JSON.parse(product.Sku_List)[0][1])
                                    ) ?? false;

                                    product.Product_Id = product.isSkuProduct? JSON.parse(product.Sku_List)[0][0] : product.Product_Id;
                                });
                            }

                            if (this.isSelectAllProductsFromCategoryBtnClicked) {
                                this.$refs.selectedProducts.$refs.searchModal.allProductsSelectedItems = data.products.items;
                                this.$refs.selectedProducts.$refs.searchModal.addProducts(true);
                                this.isSelectAllProductsFromCategoryBtnClicked = false;
                            }

                            let matching_string = new RegExp(`-${data?.product_search_by_id_prefix}=`, 'g');
                            if (!!matching_string.exec(site_search) && data.products.items.length > 0) {
                                let productID = data.products.items[0].isSkuProduct? JSON.parse(data.products.items[0].Sku_List)[0][0] : data.products.items[0].Product_Id;
                                let found     = this.currentProducts.find(ele => {
                                    return ele.Product_Id == productID;
                                });

                                if (!!found == false) {
                                    !!this.currentProductsBackup == false ? this.currentProductsBackup = [] : false;
                                    this.currentProductsBackup.push(data.products.items[0]);
                                    this.currentProducts.push(data.products.items[0]);
                                    this.allProducts.push(data.products.items[0]);

                                    this.$refs.selectedProducts.pagination    = {
                                        ...this.$refs.selectedProducts.pagination,
                                        ...{
                                            firstItem : this.$refs.selectedProducts.pagination.totalItems > 1
                                                        ? this.$refs.selectedProducts.pagination.firstItem : 0,
                                            lastItem  : this.$refs.selectedProducts.pagination.lastItem + 1,
                                            totalItems: this.$refs.selectedProducts.pagination.totalItems + 1,
                                        }
                                    }
                                    this.saveDataToSession(true);
                                    new Noty({type: "success", text: 'Product added successfully'}).show();
                                } else {
                                    new Noty({type: "warning", text: 'Product already exist in the list'}).show();
                                }
                                this.$refs.selectedProducts.$refs.bottom.search_by_product_id = null;
                                return
                            }
                            (data.products?.items ?? []).filter(item => item.is_checked = false);

                            this.getAttributes(data);
                            this.getCategories(data);

                            this.productData = data.products ?? [];
                            this.navPath = data?.navPath?.navPathNodeList ?? _.cloneDeep(this.defaultNavPath);
                            this.$refs.selectedProducts.$refs.searchModal.pagination = data.products?.itemDescription ?? _.cloneDeep(this.$refs.selectedProducts.$refs.searchModal.paginationBackup);
                            this.$refs.selectedProducts.$refs.searchModal.searchResultProducts = (data.products?.items ?? []);
                        } else {
                            this.getAttributes();

                            new Noty({
                                type: "warning",
                                text: data.noResultsMessage
                            }).show();
                        }
                    })
                    .catch((error) => {
                        console.log(error);
                        new Noty({
                            type: "error",
                            text: error.message
                        }).show();
                    })
                    .finally(() => {
                        this.$refs.selectedProducts.$refs.bottom.smallLoader = false;
                        this.searching                                       = false;
                        this.$refs.selectedProducts
                            .$refs.searchModal
                            .fetchingList                                    = false;
                        this.$refs.selectedProducts
                            .$refs.searchModal
                            .selectedProductsArr                             = [];
                        this.$root.renderTooltip();
                    });
        },


        getEasyAskProducts(product_id = null, siteSearch = null) {
            if (product_id !== null) {
                let url = `${this.productByIdUrl}?id=${product_id}&categoryProduct=true&selectAllFieldsWithAttributes=true`;
                this.$refs.selectedProducts.$refs.bottom.smallLoader = true;

                axios.post(url)
                    .then(({data}) => {
                        let product = {
                            'Product_Id'  : data.id,
                            'Product_Name': data.local_product_name,
                            'Thumbnail'   : data?.product_image?.main ?? null,
                            'duplicate'   : data.duplicate,
                        };

                        // Check if product is already selected
                        let product_exists = this.currentProducts.findIndex(item => item.Product_Id == product.Product_Id);
                        if (product_exists > -1) {
                            new Noty({
                                type: "error",
                                text: 'Product is already selected.'
                            }).show();

                            return;
                        }

                        // Setting product with all related data
                        this.currentProductsBackup.push(product);
                        this.currentProducts.push(product);

                        // After setting product data doing some other things and show product details
                        new Noty({
                            type: "success",
                            text: 'Product selected successfully!'
                        }).show();
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
                        this.$refs.selectedProducts.$refs.bottom.smallLoader = false;
                        this.$root.renderTooltip();
                    });
            } else {
                if (_.trim(this.site_search).length === 0 || _.trim(this.site_search).length >= 2) {
                    if (this.productFrom == 'easyask') {
                        this.getProductsFromEasyAsk(siteSearch);
                    } else {
                        this.getProductsFromLocal(siteSearch);
                    }
                } else {
                    new Noty({
                        type: "warning",
                        text: 'Type at least 2 characters in search box'
                    }).show();
                }
            }
        },

        getProductsFromLocal(siteSearch = null) {
            this.searching  = true;
            let site_search = siteSearch ?? this.mergeSeoPaths(this.$refs.selectedProducts.$refs.searchModal);
            let pagination  = new URLSearchParams(this.$refs.selectedProducts.$refs.searchModal.pagination).toString();
            let url         = `${this.EAProduct.localUrl}?site_search=${site_search}&categoryProduct=true&categoryId=${this.category_id}&${pagination}&returnSKUS=${this.returnSKUS}&page=${this.$refs.selectedProducts.$refs.searchModal.pagination.currentPage}`;

            axios.post(url)
                .then(({data}) => {
                    this.$refs.selectedProducts.$refs.searchModal.attributeOptions = [];
                    this.$refs.selectedProducts.$refs.searchModal.attributes       = [];
                    this.$refs.selectedProducts.$refs.searchModal.brandOptions     = [];
                    this.$refs.selectedProducts.$refs.searchModal.categoryOptions  = data.categories;

                    let searchResult = data.mappedProductData;
                    data.mappedProductData.forEach((ele, index) => {
                        this.currentProductsBackup.forEach((list_ele) => {
                            if (ele.product_id === list_ele.Product_Id) {
                                searchResult[index].duplicate = true;
                            }
                        });
                    });

                    this.$refs.selectedProducts.$refs.searchModal.searchResultProducts = searchResult.map((product) => {
                        return {
                            'Product_Id'  : product.product_id,
                            'Product_Name': product.local_product_name,
                            'Thumbnail'   : product?.product_image?.main ?? null,
                            'duplicate'   : product.duplicate,
                        };
                    });

                    this.$refs.selectedProducts.$refs.searchModal.pagination = {
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
        },

        processProductData(apiData) {
            this.currentProducts                   = Object.values(apiData.data);
            this.currentProductsBackup             = Object.values(apiData.data);
            this.$refs.selectedProducts.pagination = {
                currentPage   : apiData.current_page,
                firstItem     : apiData.from,
                lastItem      : apiData.to,
                pageCount     : apiData.last_page,
                resultsPerPage: apiData.per_page,
                totalItems    : apiData.total,
            };

            this.reRenderTable++;
        },

        getProductList(search = null) {
            if (this.isProductInList) {
                this.$refs.selectedProducts.loading = true;
                let pagination                      = this.$refs.selectedProducts.pagination;
                let params                          = {
                    search    : search ?? this.search ?? '',
                    pagination: pagination,
                };
                axios.post(this.productList.url, params)
                    .then(({data}) => {
                        this.processProductData(data);
                    })
                    .catch(error => {
                        console.log(error);
                        new Noty({
                            type: "error",
                            text: error.message
                        }).show();
                    })
                    .finally(() => {
                        this.$refs.selectedProducts.loading = false;
                    })
            } else if (search?.length) {
                if (this.currentProductsBackup.length < 1) {
                    new Noty({
                        type: "warning",
                        text: 'Please add product first.',
                    }).show()
                } else {
                    new Noty({
                        type: "warning",
                        text: 'Please save product first.',
                    }).show()
                }
            }
        },

        getAttributes(data = null) {
            let attributeOptions = data
                                   ? (data?.attributes?.attribute ?? [])
                                   : _.cloneDeep(this.$refs.selectedProducts.$refs.searchModal.attributeOptions);
            let price            = {};

            attributeOptions.filter((attrGroup, index) => {
                if (data) {
                    attrGroup.attributeValueList?.filter(attr => {
                        attr.checked = attr.selected ?? attr.checked ?? false;
                    });
                    attrGroup.initialAttributeValueList?.filter(attr => {
                        attr.checked = attr.selected ?? attr.checked ?? false;
                    });
                }

                if (attrGroup.name === 'Price') {
                    price            = attrGroup.attributeValueList[0];
                    this.$refs.selectedProducts
                        .$refs.searchModal
                        .$refs.left
                        .sliderValue = [
                        price.minValue,
                        price.maxValue
                    ];
                    this.$refs.selectedProducts
                        .$refs.searchModal
                        .$refs.left
                        .priceIndex  = index;
                }

            })

            this.$refs.selectedProducts
                .$refs.searchModal
                .attributeOptions = attributeOptions;
        },

        getCategories(data) {
            let categoryList     = data?.categories?.categoryList ?? [];
            this.$refs.selectedProducts
                .$refs.searchModal
                .categoryOptions = categoryList;

            if (!this.$refs.selectedProducts.$refs.searchModal.categoryOptionsBackup.length)
                this.$refs.selectedProducts
                    .$refs.searchModal
                    .categoryOptionsBackup = _.cloneDeep(categoryList);
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

        setDynamicHeight() {
            let searchModalLeft  = document.querySelector('#searchModalLeft')
            let searchModalRight = document.querySelector('#searchModalRight')
            let height           = searchModalLeft.offsetHeight
                                   - searchModalRight.querySelector('thead').offsetHeight;
            height               = height < this.defaultHeight
                                   ? this.defaultHeight
                                   : height;

            searchModalRight.querySelector('tbody').style.height = height + "px";
        },

        resetNavPath() {
            this.navPath = _.cloneDeep(this.defaultNavPath);
        },

        //Remove Methods
        removeNavPath(index) {
            this.navPath.splice(index, 1);
        },

        removeProduct(productID, fromList = true) {
            this.allProducts.forEach(((item, index) => {
                if (productID === item.Product_Id) {
                    this.allProducts.splice(index, 1);
                }
            }));

            if (fromList) {
                this.currentProducts.forEach(((item, index) => {
                    if (productID === item.Product_Id) {
                        this.currentProducts.splice(index, 1);
                        new Noty({
                            type: "success",
                            text: `Product removed successfully!`,
                        }).show();
                    }
                }));
                this.currentProductsBackup                  = this.currentProducts;
                this.reRenderTable++;
                this.$refs.selectedProducts.pagination = {
                    ...this.$refs.selectedProducts.pagination,
                    ...{
                        firstItem : this.$refs.selectedProducts.pagination.totalItems > 1
                                    ? this.$refs.selectedProducts.pagination.firstItem : 0,
                        lastItem  : this.$refs.selectedProducts.pagination.lastItem - 1,
                        totalItems: this.$refs.selectedProducts.pagination.totalItems - 1,
                    }
                }

                this.saveDataToSession();
            }
        },

        //Other Methods
        mergeSeoPaths({brands, categories}) {
            //console.log('brands, categories', brands, categories)
            let site_search = `-${_.cloneDeep(this.site_search)}`;
            if (categories.length > 0) {
                categories.forEach((item => {
                    site_search += `/${item.nodeString}`
                }));
            }
            if (brands.length > 0) {
                brands.forEach((item => {
                    site_search += `/${item.nodeString}`
                }));
            }

            return site_search;
        },

        resetSearch() {
            this.$refs.selectedProducts.$refs.top.site_search = '';
            this.restoreDefaultCurrentProducts();
        },

        restoreDefaultCurrentProducts() {
            this.currentProducts = _.cloneDeep(this.currentProductsBackup);
            this.reRenderTable++;
        },

        async saveData() {

            let params = {
                transformationNamesId: this.icecatTransformation.id,
                transformationName   : this.icecatTransformationName,
                productList          : this.currentProducts,
            };
            params._save_action = this.actionType;


            if(params.transformationName.length == 0) {
                new Noty({
                    type: "error",
                    text: 'Transformation Name is required',
                }).show();

                return
            }

            if(params.transformationNamesId == null) {
                new Noty({
                    type: "error",
                    text: 'Definition is required',
                }).show();

                return
            }

            axios.post(`/admin/icecat-transformation/fetch/save-jobs`, params)
                .then(response => {
                    this.getProductList();
                    new Noty({
                        type: "success",
                        text: 'Saved successfully',
                    }).show();
                    let id = response.data.id;
                    if(this.actionType == 'save_and_preview'){
                            let show = '/admin/icecat-transformation/'+id+'/show';
                            window.location.href = show;
                    }else if(this.actionType == 'save_and_edit'){
                            let edit = '/admin/icecat-transformation/'+id+'/edit';
                            window.location.href = edit;
                    }else if(this.actionType == 'save_and_new'){
                            window.location.href = this.newUrl;

                    }else if(this.actionType == 'save_and_back'){
                            window.location.href = this.backUrl;
                    }
                })
                .catch((err) => {
                    console.error(err);
                    new Noty({
                        type: "error",
                        text: err.response.data.message,
                    }).show();
                });
        },

        async loadFromCategory(category_name, dom_reference, load_all_category = false) {
            let dom_id = '#cat_' + dom_reference;
            $(dom_id).prop("disabled", true);
            this.$refs.selectedProducts.loading = true;
            let site_search                     = `-/${category_name}`;

            while (this.loadingAllCategories) {
                let pagination = new URLSearchParams(this.pagination).toString();
                let url        = `${this.EAProduct.url}?site_search=${site_search}&${pagination}`;

                await axios.post(url)
                    .then(({data}) => {
                        if (!data.noResultsMessage) {
                            if (data.products?.items && data.products.items.length > 0) {
                                data.products.items.map((product, index) => {
                                    product.isSkuProduct = (JSON.parse(product.Sku_List).length === 1
                                                            && product?.Sku_ProductCode
                                                            && (product.Sku_ProductCode
                                                                === JSON.parse(product.Sku_List)[0][1])) ?? false;
                                });
                            }
                            let productItems = data.products.items;
                            this.checkAndRemoveProductsFromCurrentProducts(productItems);
                            this.allProducts                          = this.allProducts.concat(productItems);
                            this.paginationDataFromAPI                = data.products.itemDescription;

                            if (this.pagination.currentPage === this.paginationDataFromAPI.pageCount) {
                                this.loadingAllCategories = false;
                            }

                            this.pagination.currentPage += 1;
                        } else {
                            this.loadingAllCategories = false;
                            new Noty({
                                type: "warning",
                                text: data.noResultsMessage
                            }).show();
                        }
                    })
                    .catch((error) => {
                        this.loadingAllCategories = false;
                        new Noty({
                            type: "error",
                            text: error.message
                        }).show();
                    });

                if (!this.loadingAllCategories) {
                    this.loadingAllCategories = true;
                    this.pagination           = _.cloneDeep(this.paginationBackup);
                    break;
                }
            }

            if (!load_all_category) {
                this.afterLoadingCategory(dom_id);
            }
        },

        async loadAllCategory() {
            for (const item of this.allCategories) {
                await this.loadFromCategory(item.label, 'load_all', true);
            }

            await this.afterLoadingCategory('#cat_load_all');
        },

        async afterLoadingCategory(dom_id) {
            this.$refs.selectedProducts.loading = false;
            $(dom_id).prop("disabled", false);
            this.$root.renderTooltip();
            await this.saveDataToSession(true);

            new Noty({
                type: "success",
                text: 'Products has been loaded successfully',
            }).show();
        },

        checkAndRemoveProductsFromCurrentProducts(productItems) {
            productItems.map(((importItem, importIndex) => {
                let result = _.find(this.allProducts, ['Product_Id', importItem.Product_Id]);
                if (!_.isEmpty(result)) {
                    this.removeProduct(importItem.Product_Id, false);
                }
            }));
        },

        async saveDataToSession(saveDataTransformation = false) {

            let data = {
                products_list: this.allProducts,
                file_path    : this.file_path,
            };


            axios.post(this.fileSaveURL, data)
                .then(({data}) => {
                    if (data.success) {
                        this.file_path = data.file_path;
                        if (saveDataTransformation) {
                            this.getProductList();
                        }
                    } else {
                        new Noty({
                            type: "error",
                            text: 'Can not save file',
                        }).show();
                    }
                })
                .catch((error) => {
                    new Noty({
                        type: "error",
                        text: error.message
                    }).show();
                });
        },

        runScript() {
            if (_.isNull(this.file_path) || this.allProducts.length < 1) {
                new Noty({
                    type: "warning",
                    text: 'Please select some products first'
                }).show();
                return;
            }

            axios.post(this.runScriptUrl)
                .then(({data}) => {
                    if (data.success) {
                        new Noty({
                            type: "success",
                            text: "Script has been run successfully"
                        }).show();
                    } else {
                        new Noty({
                            type: "error",
                            text: "Can not run script"
                        }).show();
                    }
                })
                .catch((error) => {
                    new Noty({
                        type: "error",
                        text: error.message
                    }).show();
                });
        },
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
.card {
    margin-bottom: 0.5rem;
}

.load-from-category {
    cursor: pointer;
}
</style>
