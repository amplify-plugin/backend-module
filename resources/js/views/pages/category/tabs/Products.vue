<template>
    <div role="tabpanel" class="tab-pane active"
         id="tab_products">
        <SelectedProducts
            calledFrom="categoryModule"
            ref="selectedProducts"
            :currentProducts="currentProducts"
            :reRenderTable="reRenderTable"
            type="category"
        ></SelectedProducts>
    </div>
</template>

<script>
import SelectedProducts from "../../../components/selected-products/SelectedProducts";
import _                from "lodash";

export default {
    name      : "Products",
    components: {
        SelectedProducts
    },
    data() {
        return {
            reRenderTable                   : 0,
            currentProductsBackup           : this.$parent?.selectedProducts ?? [],
            currentProducts                 : [],
            newProductIds                   : [],
            EAProduct                       : {
                url : "/admin/product/fetch/products-list",
                data: [],
            },
            productList                     : {
                url : "/admin/category/fetch/products-by-id",
                data: [],
            },
            productByIdUrl                  : "/admin/product/fetch/product-by-id",
            addProductCategoryToProducts    : "/admin/category/fetch/add-product-category-to-products",
            removeProductCategoryFromProduct: "/admin/category/fetch/remove-product-category-from-product",
            site_search                     : '',
            searching                       : false,
            productData                     : null,
            navPath                         : [],
            defaultNavPath                  : [
                {
                    englishName    : "All Products",
                    navNodePathType: 1,
                    path           : "All Products",
                    purePath       : "All Products",
                    seoPath        : "",
                    value          : "All Products",
                }
            ],
            returnSKUS                      : false,
        }
    },
    mounted() {
        this.init();
    },

    methods: {
        init() {
            this.resetNavPath();
            if (this.$parent.method === 'put') {
                this.getProductList(null);
            }
        },

        resetNavPath() {
            this.navPath = _.cloneDeep(this.defaultNavPath);
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

        removeNavPath(index) {
            this.navPath.splice(index, 1);
        },

        reStructureSeoPath(seoPath) {
            if (this.isSearchStringExist(seoPath)
                && this.$refs.selectedProducts.$refs.searchModal.categories.length
                === 0) {
                this.$refs.selectedProducts.$refs.searchModal.resetData(true);
            } else if (this.isSearchStringExist(seoPath)) {
                this.$refs.selectedProducts.$refs.searchModal.$refs.top.site_search = '';
                this.site_search                                                    = '';
            } else if (this.$refs.selectedProducts.$refs.searchModal.categories.some(category => category.nodeString
                                                                                                 === seoPath)) {
                _.remove(this.$refs.selectedProducts.$refs.searchModal.categories, category => category.nodeString
                                                                                               === seoPath);

                if (this.$refs.selectedProducts.$refs.searchModal.categories.length
                    > 0
                    || this.$refs.selectedProducts.$refs.searchModal.$refs.top.site_search
                    !== '') {
                    this.getEasyAskProducts();
                } else {
                    this.$refs.selectedProducts.$refs.searchModal.resetData(true);
                }
            }
        },

        isSearchStringExist(seoPath) {
            return seoPath.charAt(0) === '-' && (seoPath.substring(seoPath.indexOf('-') + 1)
                                                 === this.$refs.selectedProducts.$refs.searchModal.$refs.top.site_search)
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

        getEasyAskProducts(product_id = null) {
            if (this.$parent.method === 'post') {
                new Noty({
                    type: "warning",
                    text: 'Please save the category first before adding product'
                }).show();
                return;
            }

            if (product_id !== null) {
                let url = `${this.productByIdUrl}?id=${product_id}
                &categoryProduct=true
                &categoryId=${this.$parent?.category?.id ?? ''}`;

                this.$refs.selectedProducts.$refs.bottom.smallLoader = true;

                axios.post(url)
                    .then(({data}) => {
                        this.$refs.selectedProducts.$refs.searchModal.attributeOptions = [];
                        this.$refs.selectedProducts.$refs.searchModal.attributes       = [];
                        this.$refs.selectedProducts.$refs.searchModal.brandOptions     = [];
                        this.$refs.selectedProducts.$refs.searchModal.pagination       = [];
                        this.$refs.selectedProducts.$refs.searchModal.categoryOptions  = [];

                        let product = {
                            'Product_Id'  : data.id,
                            'Product_Name': data.local_product_name,
                            'Thumbnail'   : data?.product_image?.main ?? null,
                        };

                        if (this.$refs.selectedProducts.$refs.searchModal.isDataExistInArray(product, this.currentProducts, 'Product_Id')) {
                            new Noty({
                                type: "error",
                                text: 'Product already selected'
                            }).show();
                        } else {
                            this.currentProducts.push(product);
                            this.currentProductsBackup.push(product);
                            this.updatePagination(1);
                            new Noty({
                                type: "success",
                                text: 'Product added successfully!'
                            }).show();
                            this.$refs.selectedProducts.$refs.bottom.search_by_product_id = "";
                        }

                    })
                    .catch(error => {
                        if ((error?.response?.status ?? null) === 404) {
                            new Noty({
                                type: "error",
                                text: 'Product not found'
                            }).show();
                        }
                        //console.log(error);
                    })
                    .finally(() => {
                        this.$refs.selectedProducts.$refs.bottom.smallLoader = false;
                        this.$root.renderTooltip();
                    });
            } else {
                if (this.site_search.length >= 2 ||
                    this.$refs.selectedProducts.$refs.searchModal.categories.length > 0) {

                    this.searching  = true;
                    let site_search = this.mergeSeoPaths(this.$refs.selectedProducts.$refs.searchModal);
                    let pagination  = new URLSearchParams(this.$refs.selectedProducts.$refs.searchModal.pagination).toString();
                    let url         = `${this.EAProduct.url}?site_search=${site_search}
                    &categoryProduct=true&${pagination}
                    &returnSKUS=${this.returnSKUS}
                    &page=${this.$refs.selectedProducts.$refs.searchModal.pagination.currentPage}`;

                    axios.post(url)
                        .then(({data}) => {
                            this.$refs.selectedProducts.$refs.searchModal.attributeOptions = [];
                            this.$refs.selectedProducts.$refs.searchModal.attributes       = [];
                            this.$refs.selectedProducts.$refs.searchModal.brandOptions     = [];
                            this.$refs.selectedProducts.$refs.searchModal.categoryOptions  = data.categories;
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

                            this.$refs.selectedProducts.$refs.searchModal.searchResultProducts
                                = searchResult.map((product) => {
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
                } else {
                    new Noty({
                        type: "warning",
                        text: 'Type at least 2 characters in search box Or Select a category'
                    }).show();
                }
            }
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

        getProductList(search = null) {
            search = search ?? this.search ?? '';
            if (this.$parent.method === 'put') {
                if (this.currentProductsBackup.length < 1 && search.length) {
                    new Noty({
                        type: "warning",
                        text: 'Please add product first.',
                    }).show()
                } else {
                    let pagination                      = this.$refs.selectedProducts.pagination;
                    let params                          = {
                        id        : this.$parent.category.id,
                        search,
                        pagination: pagination,
                        page      : this.$refs.selectedProducts.pagination.currentPage,
                    };
                    this.$refs.selectedProducts.loading = true;
                    axios.post(this.productList.url, params)
                        .then(({data}) => {
                            this.currentProductsBackup             = data.data.map((product) => {
                                return {
                                    'Product_Id'  : product.id,
                                    'Product_Name': product.local_product_name,
                                    'Thumbnail'   : product?.product_image?.main ?? null,
                                };
                            });
                            this.currentProducts                   = _.cloneDeep(this.currentProductsBackup);
                            this.$refs.selectedProducts.pagination = {
                                currentPage   : data.current_page,
                                firstItem     : data.from,
                                lastItem      : data.to,
                                pageCount     : data.last_page,
                                resultsPerPage: data.per_page,
                                totalItems    : data.total,
                            };
                            this.reRenderTable++;
                        })
                        .catch(error => {
                            new Noty({
                                type: "error",
                                text: error.message
                            }).show();
                        }).finally(() => {
                        this.$refs.selectedProducts.loading = false;
                    });
                }
            } else {
                this.$refs.selectedProducts.loading = false;
                if (search.length) {
                    if (this.$parent.method === 'post' && this.currentProducts.length > 0) {
                        new Noty({
                            type: "warning",
                            text: 'Please save the category first.',
                        }).show()
                    } else {
                        new Noty({
                            type: "warning",
                            text: 'Please add product in category first.',
                        }).show()
                    }
                }
            }
        },

        resetSearch() {
            this.$refs.selectedProducts.$refs.top.site_search = '';
            this.$refs.selectedProducts.pagination
                                                              = _.cloneDeep(this.$refs.selectedProducts.paginationBackup);
            this.getProductList();
            this.reRenderTable++;
        },

        saveProductCategoryToProducts(products = []) {
            let productCategoryId = this.$parent.category?.id ?? '';
            axios.post(this.addProductCategoryToProducts, {products, productCategoryId});
        },

        removeAProduct(product_id) {
            let category_id = this.$parent.category?.id ?? '';
            axios.post(this.removeProductCategoryFromProduct, {product_id, category_id});
        },

        updatePagination(newProductIdCount = 0) {
            let pagination                         = this.$refs.selectedProducts.pagination
            this.$refs.selectedProducts.pagination = {
                ...pagination,
                ...{
                    lastItem  : pagination.lastItem + newProductIdCount,
                    totalItems: pagination.totalItems + newProductIdCount,
                }
            }
        },

        removeAllProductsFromCategory() {
            let params = {
                id        : this.$parent.category.id,
                removeFrom: 'category',
            };
            axios.post('/admin/product/fetch/remove-all-products', params)
                .then(({data}) => {
                    if (data !== 0) {
                        this.getProductList();
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
    watch  : {
        currentProductsBackup: function (newValue, oldValue) {
            this.$parent.category.products = this.currentProductsBackup.map(ele => ele.Product_Id);
        },
        newProductIds        : function (newValue, oldValue) {
            if (newValue.length) {
                this.saveProductCategoryToProducts(newValue);
                let newProductIdCount = this.newProductIds.length;
                this.updatePagination(newProductIdCount);
                this.newProductIds = [];
            }
        },
        returnSKUS           : function (newVal, oldVal) {
            if (newVal !== oldVal) {
                this.getEasyAskProducts();
            }
        },
    }
}
</script>

<style scoped>

</style>
