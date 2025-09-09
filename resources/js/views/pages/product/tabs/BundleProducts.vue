<template>
    <div role="tabpanel" class="tab-pane active"
         id="tab_products">
        <SelectedProducts
            calledFrom="productModule"
            ref="selectedProducts"
            :reRenderTable="reRenderTable"
            type="product"
            module="products"
        ></SelectedProducts>
    </div>
</template>

<script>
import _                from "lodash";
import SelectedProducts from "../../../components/selected-products/SelectedProducts";

export default {
    name      : "BundleProducts",
    components: {
        SelectedProducts
    },

    data() {
        return {
            reRenderTable        : 0,
            placeholderImage     : this.$root.config.fallback_image,
            currentProductsBackup: this.$parent?.productData?.products_list ?? [],
            currentProducts      : [],
            EAProduct            : {
                url : "/admin/product/fetch/easy-ask-products",
                data: [],
            },
            productList          : {
                url : "/admin/product/fetch/bundle-products-by-id",
                data: [],
            },
            site_search          : "",
            navPath              : [],
            defaultNavPath       : [
                {
                    englishName    : "All Products",
                    navNodePathType: 1,
                    path           : "All Products",
                    purePath       : "All Products",
                    seoPath        : "",
                    value          : "All Products",
                }
            ],
            defaultHeight        : 350,
            searching            : false,
            productData          : [],
            isProductInBundle    : false,
            returnSKUS           : false,
            returnSKUSClicked    : false,
        }
    },

    mounted() {
        this.resetNavPath();

        if (this.currentProductsBackup.length > 0) {
            this.isProductInBundle = true;
            this.currentProducts   = _.cloneDeep(this.currentProductsBackup)
        }
    },

    methods: {
        //Gets Methods
        getEasyAskProducts(product_id = null, siteSearch = null) {
            let site_search = _.trim(_.cloneDeep(this.site_search));
            if (site_search.length === 0 || site_search.length >= 3) {
                this.searching                                             = true;
                this.$refs.selectedProducts.$refs.searchModal.fetchingList = true;
                let site_search                                            = siteSearch
                                                                             ?? this.mergeSeoPaths(this.$refs.selectedProducts.$refs.searchModal);

                let pagination = new URLSearchParams(this.$refs.selectedProducts.$refs.searchModal.pagination).toString();
                if (site_search === 'productModule') {
                    let isProductIdaNumber = Number.isInteger(parseFloat(product_id))
                    if (isProductIdaNumber) {
                        site_search                                                   = `-${this.$parent.product_search_by_id_prefix}=${parseFloat(product_id)}`
                        this.$refs.selectedProducts.$refs.bottom.smallLoader          = true;
                        this.$refs.selectedProducts.$refs.bottom.search_by_product_id = parseFloat(product_id);
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
                                    product.isSkuProduct = (JSON.parse(product.Sku_List).length === 1
                                                            && product?.Sku_ProductCode
                                                            && (product.Sku_ProductCode
                                                                === JSON.parse(product.Sku_List)[0][1])) ?? false;
                                });
                            }

                            if (!!site_search.match(/-Products.ProductId=/g) && data.products.items.length > 0) {
                                let productID = data.products.items[0].Product_Id;
                                let found     = this.currentProducts.find(ele => {
                                    return ele.Product_Id == productID;
                                });
                                if (!!found == false) {
                                    !!this.currentProductsBackup == false ? this.currentProductsBackup = [] : false;
                                    this.currentProductsBackup.push(data.products.items[0]);
                                    this.currentProducts.push(data.products.items[0])
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

                            this.productData          = data.products ?? [];
                            this.navPath              = data?.navPath?.navPathNodeList
                                                        ?? _.cloneDeep(this.defaultNavPath);
                            this.$refs.selectedProducts
                                .$refs.searchModal
                                .pagination           = data.products?.itemDescription
                                                        ?? _.cloneDeep(this.$refs.selectedProducts.$refs.searchModal.paginationBackup);
                            this.$refs.selectedProducts
                                .$refs.searchModal
                                .searchResultProducts = (data.products?.items ?? []);
                        } else {
                            this.getAttributes();

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
            } else {
                new Noty({
                    type: "warning",
                    text: 'Type at least 3 characters in search box'
                }).show();
            }
        },

        processProductData(apiData) {
            this.currentProducts                   = Object.values(apiData.data);
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
            if (this.isProductInBundle) {
                this.$refs.selectedProducts.loading = true;
                let pagination                      = this.$refs.selectedProducts.pagination;
                let params                          = {
                    id        : this.$parent.productData.id,
                    search    : search ?? this.search ?? '',
                    pagination: pagination,
                };
                axios.post(this.productList.url, params)
                    .then(({data}) => {
                        this.processProductData(data);
                    })
                    .catch(error => {
                        new Noty({
                            type: "error",
                            text: error.message
                        }).show();
                    })
                    .finally(() => {
                        this.$refs.selectedProducts.loading = false;
                    })
            } else if (search.length) {
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

        //Set Methods
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

        removeProduct(productID) {
            this.currentProducts.forEach(((item, index) => {
                if (productID === item.productID) {
                    this.currentProducts.splice(index, 1);
                    new Noty({
                        type: "success",
                        text: `Product removed successfully!`,
                    }).show();
                }
            }));
            this.reRenderTable++;
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

        removeAllBundleProductsFromProduct() {
            let params = {
                id        : this.$parent.productData.id,
                removeFrom: 'product',
            };
            axios.post('/admin/product/fetch/remove-all-products', params)
                .then(({data}) => {
                    if (data !== 0) {
                        this.getProductList();
                        this.currentProducts = this.currentProductsBackup = [];
                        new Noty({
                            type: "success",
                            text: "All products removed successfully.",
                        }).show();
                    } else {
                        console.log(data);
                        new Noty({
                            type: "error",
                            text: "Can not remove all products.",
                        }).show();
                    }

                    this.$root.renderTooltip();
                })
                .catch(error => {
                    console.log(error);
                    new Noty({
                        type: "error",
                        text: error.message
                    }).show();
                });
        },
    },

    watch: {
        currentProductsBackup: function (newValue, oldValue) {
            if (newValue !== oldValue)
                this.$parent.productData.products_list = this.currentProductsBackup;
        },

        returnSKUS: function (newVal, oldVal) {
            if (newVal !== oldVal && this.returnSKUSClicked) {
                this.getEasyAskProducts();
                this.returnSKUSClicked = false;
            }
        },
    }
}
</script>
