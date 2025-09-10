<template>
    <!-- if type selected product -->
    <div class="mt-2 border p-3 rounded bg-secondary">
        <div class="form-group">
            <div class="d-flex justify-content-between mb-2">
                <label class="my-auto mr-1">Products</label>
                <button class="btn btn-danger btn-sm" type="button" @click="removeAllProductsFromList()"
                    data-toggle="tooltip" data-placement="top" title="Remove All Products">
                    <i class="las la-trash-alt"></i>
                    Remove All
                </button>
            </div>

            <div v-if="loading">
                <Loader />
            </div>

            <div v-else>
                <div class="container-fluid product-container mt-3 mb-0 px-2">
                    <div class="form-row">
                        <div class="col-md-6 col-lg-3 col-xl-3 col-xxl-3 mb-2"
                            v-for="(product, index) in superParent.campaign.campaign_products" :key="index"
                            :title="product.product_name" data-toggle="tooltip" data-placement="top"
                        >
                            <!-- bbb_deals -->
                            <div class="bbb_deals  bg-light">
                                <div class="ribbon ribbon-top-right">
                                    <!--<span><small class="cross"> x </small> 4 </span>-->
                                    <span class="bg-danger cursor-pointer" title="Remove" @click="removeProduct(index)">
                                        <i class="la la-times"></i>
                                    </span>
                                </div>
                                <div class="bbb_deals_title">
                                    Product ID: # {{
                                        product.product_id
                                    }}
                                </div>
                                <div class="bbb_deals_slider_container">
                                    <div class="bbb_deals_item">
                                        <div class="bbb_deals_image"
                                            style="height:200px !important; width: auto !important;">
                                            <img @error="$root.getDefaultImage($event)" class="product-height"
                                                style="object-fit: contain; height:100%" :src="`${product.product_image}`"
                                                alt="" />
                                        </div>
                                        <div class="bbb_deals_content mt-3">
                                            <div class="bbb_deals_info_line d-flex flex-row justify-content-start">
                                                <div class="bbb_deals_item_name ellipsis" :title="product.product_name">
                                                    {{
                                                        product.product_name
                                                    }}
                                                </div>
                                            </div>

                                            <p class="mb-1"><small>Original Price: ${{ parseFloat(product.product_price) }}</small></p>
                                            <strong>Campaign Price: ${{ parseFloat(product.discount ?? product.product_price).toFixed(2) }}</strong>
                                        </div>
                                    </div>
                                </div>

                                <div v-if="product.edit_mode" class="row mt-4">
                                    <div class="col-md-12 form-group">
                                        <label>Select Discount Type</label>
                                        <select class="form-control custom-select" v-model="product.discount_type">
                                            <option
                                                v-for="(discountTypeName, discountTypeKey) in superParent.discountTypes"
                                                :key="discountTypeKey"
                                                :value="discountTypeKey"
                                            >{{ discountTypeName }}</option>
                                        </select>
                                    </div>

                                    <div class="col-md-12 form-group">
                                        <label for="">Discount Price</label>
                                        <input type="number" :max="product.product_price" v-model="product.discount"
                                            class="form-control" />
                                    </div>

                                    <div v-if="product.discount_type === 'buy_n1_get_n2'" class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="">N1</label>
                                                <input type="number" v-model="product.n1" class="form-control" />
                                            </div>

                                            <div class="col-md-6">
                                                <label for="">N2</label>
                                                <input type="number" v-model="product.n2" class="form-control" />
                                            </div>

                                        </div>
                                    </div>

                                    <div class="col-12 text-center mt-3">
                                        <button
                                            type="button"
                                            class="btn btn-outline-success"
                                            @click="product.edit_mode = false"
                                        >Save Price</button>
                                    </div>
                                </div>

                                <div v-else class="text-center mt-4">
                                    <button
                                        type="button"
                                        class="btn btn-outline-success"
                                        @click="product.edit_mode = true"
                                    >Edit Price</button>
                                </div>
                            </div>
                        </div>
                        <div v-if="!allProducts.length" class="w-100 mt-3">
                            <NoItemFound :message="noProductFound" ref="noItemFound" />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card card-body">
            <search-modal
                calledFrom="campaignScreen"
                ref="searchModal"
                type="category"
            />
            <bottom
                calledFrom="campaignScreen"
                ref="bottom"
                :getProducts="getEasyAskProducts"
                :getModal="getModal"
                buttonName="Select"
            />
        </div>
    </div>
</template>

<script>
import _ from "lodash";
import Bottom from "../../components/selected-products/Bottom.vue";
import SearchModal from "../../components/search-product-modal/SearchProductModal.vue";

import NoItemFound from "../../components/NoItemFound.vue";
import Loader from "../../components/Loader.vue";

export default {
    data() {
        return {
            getModal: null,
            settings: {
                view: null,
            },
            defaultSettings: {
                view: "grid",
            },
            noProductFound: "No Product Found",
            productByIdUrl: "/admin/product/fetch/product-from-easyask-by-id",
            EAProduct: {
                url: "/admin/product/fetch/easy-ask-products",
                data: [],
            },
            variables: [],
            isProductSelected: false,
            site_search: "",
            navPath: [],
            defaultNavPath: [
                {
                    englishName: "All Products",
                    navNodePathType: 1,
                    path: "All Products",
                    purePath: "All Products",
                    seoPath: "",
                    value: "All Products",
                },
            ],
            easyAskDefaultProductCategories: [],
            searching: false,
            error: "",
            returnSKUS: false,
            returnSKUSClicked: false,
            allProducts: [],
            loading: false,
            superParent: this.$parent.$parent,
        };
    },
    mounted() {
        this.getSettings();
        this.$root.renderTooltip();
        this.getModal = this.$refs.searchModal.getModal;
    },
    components: { SearchModal, Bottom, NoItemFound, Loader },
    methods: {
        editCampaignPrice(index) {

        },

        saveCampaignPrice(index, price) {

        },

        removeAllProductsFromList() {
            if (this.allProducts.length > 0) {
                this.$swal({
                    title: "Remove all products?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#ff6b81",
                    cancelButtonColor: "#399E7F",
                    confirmButtonText: "Remove",
                }).then(async (result) => {
                    if (result.isConfirmed) {
                        this.allProducts = [];
                        new Noty({
                            type: "success",
                            text: "All products removed from list!",
                        }).show();
                    }
                });
            } else {
                new Noty({
                    type: "error",
                    text: `There is no product to remove`,
                }).show();
            }

            this.$root.renderTooltip();
        },

        removeProduct(index) {
            this.$swal({
                title: "Remove this product?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#ff6b81",
                cancelButtonColor: "#399E7F",
                confirmButtonText: "Remove",
            }).then((result) => {
                if (result.isConfirmed) {
                    this.allProducts.splice(index, 1);

                    new Noty({
                        type: "success",
                        text: `Product removed successfully!`,
                    }).show();
                }
            });
        },

        // Category search Path related to the product search area
        setCategoryNavPath(category) {
            let navPath = {
                value: `${category.name}`,
                path: `All Products////${category.name}`,
                purePath: `All Products////${category.name}`,
                seoPath: `${category.nodeString}`,
                navNodePathType: 1,
                englishName: `${category.name}`,
            };
            this.navPath.push(navPath);
        },

        removeNavPath(index) {
            this.navPath.splice(index, 1);
        },

        isSearchStringExist(seoPath) {
            return (
                seoPath.charAt(0) === "-" &&
                seoPath.substring(seoPath.indexOf("-") + 1) ===
                this.$refs.searchModal.$refs.top.site_search
            );
        },

        // related product model search area

        getEasyAskProducts(product_id = null, notifiable = true, attributeAccess = this.superParent.defaultProductAttributeAccess, productColumnSize = this.superParent.defaultProductColumnSize) {
            // Removing error messages
            if (product_id !== null) {
                let url = `${this.productByIdUrl}?id=${product_id}&categoryProduct=true&selectAllFieldsWithAttributes=true&returnSKUS=true`;
                this.$refs.bottom.smallLoader = true;
                this.loading = true;
                axios
                    .post(url)
                    .then(({ data }) => {
                        if (!data) {
                            new Noty({
                                type: "error",
                                text: "Product not found",
                            }).show();
                            return;
                        }
                        // Check if product is already selected
                        if (this.allProducts.findIndex(e => e.Product_Id === data.Product_Id) >= 0) {
                            new Noty({
                                type: "error",
                                text: "Product is already selected.",
                            }).show();
                            return;
                        }

                        // Setting product with all related data
                        this.setProductData(data, attributeAccess, productColumnSize);
                        // After setting product data doing some other things and show product details
                        this.afterSettingProductData(notifiable);
                        // Disable modal after selecting product.
                        this.$refs.searchModal.$refs.cancelButton.click();
                    })
                    .catch((error) => {
                        if ((error?.response?.status ?? null) === 404) {
                            new Noty({
                                type: "error",
                                text: "Product not found",
                            }).show();
                        }
                    })
                    .finally(() => {
                        this.$refs.bottom.smallLoader = false;
                        this.loading = false;
                        this.$root.renderTooltip();
                    });
            } else {
                if (this.site_search.length === 0 || this.site_search.length >= 2 || this.$refs.searchModal.categories.length > 0) {
                    this.searching = true;
                    let pagination = this.$refs.searchModal.pagination;
                    let site_search = this.mergeSeoPaths(this.$refs.searchModal);
                    let pagination_url_string = new URLSearchParams(pagination).toString();
                    let url = `${this.EAProduct.url}?site_search=${site_search}&${pagination_url_string}&returnSKUS=${this.returnSKUS}&page=${pagination.currentPage}`;

                    axios
                        .post(url)
                        .then(({ data }) => {
                            this.$refs.searchModal.attributeOptions = [];
                            this.$refs.searchModal.attributes = [];
                            this.$refs.searchModal.brandOptions = [];
                            this.$refs.searchModal.categoryOptions = data.categories?.categoryList ?? [];
                            this.$refs.searchModal.searchResultProducts = data.products?.items ?? [];

                            if (this.site_search !== "") {
                                this.addSiteSearchIntoNavPath(this.site_search);
                            }

                            this.$refs.searchModal.pagination = {
                                currentPage: data.products?.itemDescription?.currentPage ?? pagination.currentPage,
                                firstItem: data.products?.itemDescription?.firstItem ?? pagination.firstItem,
                                lastItem: data.products?.itemDescription?.lastItem ?? pagination.lastItem,
                                pageCount: data.products?.itemDescription?.pageCount ?? pagination.pageCount,
                                resultsPerPage: data.products?.itemDescription?.resultsPerPage ?? pagination.resultsPerPage,
                                totalItems: data.products?.itemDescription?.totalItems ?? pagination.totalItems,
                            };
                        })
                        .finally(() => {
                            this.searching = false;
                        });
                } else {
                    new Noty({
                        type: "warning",
                        text: "Type at least 2 characters in search box",
                    }).show();
                }
            }
        },


        addSiteSearchIntoNavPath(site_search) {
            let isAlreadyExistInNavPath = this.navPath.some(
                (nav) => nav.value === site_search.trim()
            );

            if (!isAlreadyExistInNavPath) {
                let navPath = {
                    value: `${site_search}`,
                    path: `All Products////${site_search}`,
                    purePath: `All Products////${site_search}`,
                    seoPath: `-${site_search}`,
                    navNodePathType: 1,
                    englishName: `${site_search}`,
                };
                this.navPath.push(navPath);
            }
        },

        setSettings(key, value, setDefault = false) {
            if (setDefault) {
                this.settings = _.cloneDeep(this.defaultSettings);
            } else {
                this.settings[key] = value;
            }

            localStorage.setItem("settings", JSON.stringify(this.settings));

            return this;
        },

        getSettings() {
            let settings = localStorage.getItem("settings");
            if (settings) this.settings = JSON.parse(settings);
            else this.setSettings(false, false, true);
        },

        mergeSeoPaths({ brands, categories }) {
            let site_search = `-${this.site_search}`;
            if (categories.length > 0) {
                categories.forEach((item, index) => {
                    site_search += `/${item.nodeString}`;
                });
            }
            if (brands.length > 0) {
                brands.forEach((item, index) => {
                    site_search += `/${item.nodeString}`;
                });
            }

            return site_search;
        },

        resetNavPath() {
            this.navPath = _.cloneDeep(this.defaultNavPath);
        },

        setProductData(data, attributeAccess, productColumnSize) {
            data.Attribute_Access = attributeAccess;
            data.Product_Column_Size = productColumnSize;
            this.allProducts.push(JSON.parse(JSON.stringify(data)));
        },

        afterSettingProductData(notyfiable = true) {
            this.$refs.bottom.search_by_product_id = "";
            this.isProductSelected = true;

            if (notyfiable) {
                new Noty({
                    type: "success",
                    text: "Product selected successfully!",
                }).show();
            }
        },

        removeDollarSign(amount) {
            if (amount) {
                let price = String(amount).replace(/\$/g, '');
                return parseFloat(price);
            }
            return 0.00;
        }
    },
    computed: {
        _() {
            return _;
        }
    },
    watch: {
        returnSKUS: function (newVal, oldVal) {
            if (newVal !== oldVal && this.returnSKUSClicked) {
                this.getEasyAskProducts();
                this.returnSKUSClicked = false;
            }
        },
        allProducts: {
            handler: function (products) {
                const self = this;
                let local_products = self.superParent.campaign.campaign_products;

                self.superParent.campaign.campaign_products = products.map(function (product) {
                    let exists_product = local_products.find(ex_product => ex_product.product_id == product.Product_Id);

                    return {
                        product_id: product.Product_Id,
                        product_name: product.isSkuProduct ? product.Sku_Name : product.Product_Name,
                        product_price: self.removeDollarSign(product.Msrp),
                        product_image: product.isSkuProduct ? product.Sku_ProductImage : product.Product_Image,

                        discount_type: exists_product?.discount_type ?? 'fixed_price',
                        discount: exists_product?.discount ?? self.removeDollarSign(product.Msrp),
                        n1: exists_product?.n1 ?? 1,
                        n2: exists_product?.n2 ?? 2,

                        edit_mode: false,
                    }
                });
            }, deep: true
        }
    }
}
</script>
