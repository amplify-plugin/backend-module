<template>
    <div>
        <div class="form-group required">
            <label>
                Name
            </label>
            <i name="This field is translatable." class="la la-flag-checkered pull-right" style="margin-top: 3px"></i>

            <input type="text" name="name" v-model="$parent.form.name" placeholder="Enter menu item name"
                   class="form-control" :class="{ 'is-invalid': $parent.form.errors.has('name') }"
                   @keypress="$parent.form.errors.clear('name')"/>
            <small v-if="$parent.form.errors.has('name')" class="text-danger mt-3">
                {{ $parent.form.errors.get("name") }}
            </small>
        </div>

        <div class="form-group required">
            <label>Menu Column Size</label>

            <select class="form-control" v-model="$parent.form.menu_column_size">
                <option v-for="i in parseInt($parent.available_menu_column)" :key="i" :value="i">
                    {{ i + (i > 1 ? ` Columns` : ` Column`) }}
                </option>
            </select>
            <small v-if="$parent.form.errors.has('menu_column_size')" class="text-danger mt-3">
                {{ $parent.form.errors.get("menu_column_size") }}
            </small>
        </div>

        <div class="form-group required">
            <label>
                Type
            </label>

            <select class="form-control" v-model="$parent.form.type" @change="onMegaMenuTypeChange($parent.form.type)">
                <option v-for="(item,index) in $parent.megaMenuTypes" :key="index" :value="index">{{ item }}</option>
            </select>
        </div>

        <div class="form-group form-check">
            <input type="checkbox" v-model="$parent.form.enabled" class="form-check-input" id="exampleCheck1">
            <label class="form-check-label" for="exampleCheck1">Enabled?</label>
        </div>
        <div class="form-group form-check">
            <input type="checkbox" v-model="$parent.form.show_name" class="form-check-input" id="exampleCheck2">
            <label class="form-check-label" for="exampleCheck2">Display Name as Heading?</label>
        </div>

        <div class="" v-if="$parent.form.type == 'default'">
            <button class="btn btn-primary btn-sm m-3" @click="addNewLinkItem">
                <i class="la la-plus"></i>
                Add
            </button>
            <div class="card-body bg-gray-300 d-flex p-2 m-1 rounded" v-for="(link, index) in $parent.form.links"
                 :key="index">
                <div class="form-group col-md-5 required">
                    <label>Link Title</label>
                    <input type="text" name="name" v-model="link.name" placeholder="Enter link title"
                           class="form-control"/>
                </div>
                <div class="form-group col-md-5 required">
                    <label>Link</label>
                    <input type="text" name="link" v-model="link.link" placeholder="https://example.com"
                           class="form-control"/>
                </div>
                <div class="form-group col-md-2 mt-4">
                    <button type="button" class="btn btn-danger btn-sm" @click="removeLinkItem(index)">
                        <i class="la la-times la-2x"></i>
                    </button>
                </div>
            </div>
        </div>
        <!-- If type Sub Category Selected -->
        <div v-if="$parent.form.type == 'sub-category'">
            <div class="form-group">
                <label>Categories</label>

                <select class="form-control" v-model="$parent.form.category_seopath" placeholder="Select Category"
                        :class="{ 'is-invalid': $parent.form.errors.has('category_seopath') }"
                        @change="$parent.form.errors.clear('category_seopath')">
                    <option v-for="(category, index) in $parent.categoriesForSubCategory" :key="index"
                            :value="category.seoPath">
                        {{ category.name }}
                    </option>
                </select>
                <small v-if="$parent.form.errors.has('category_seopath')" class="text-danger mt-3">
                    {{ $parent.form.errors.get("category_seopath") }}
                </small>
            </div>
        </div>
        <!-- If type Category Selected -->
        <div v-if="$parent.form.type == 'category'">
            <div class="form-group">
                <label>Number of Categories</label>

                <input type="number" step="any" name="number_of_categories" v-model="$parent.form.number_of_categories"
                       placeholder="Enter number of category" class="form-control"
                       :class="{ 'is-invalid': $parent.form.errors.has('number_of_categories') }"
                       @keypress="$parent.form.errors.clear('number_of_categories')"/>
                <small v-if="$parent.form.errors.has('number_of_categories')" class="text-danger mt-3">
                    {{ $parent.form.errors.get("number_of_categories") }}
                </small>
            </div>
        </div>
        <!-- If type Merchandising Zones Selected -->
        <div v-if="$parent.form.type == 'merchandise-zone'">

            <div class="form-group">
                <label>Merchandising Zone</label>

                <select class="form-control"
                        v-model="$parent.form.merchandising_zone_id"
                        placeholder="Select Merchandising Zone"
                        :class="{ 'is-invalid': $parent.form.errors.has('merchandising_zone_id') }">
                    <option selected disabled v-if="$parent.merchandisingZones.length === 0">
                        No Merchandising Zone Available
                    </option>
                    <option v-else v-for="(merchandisingZone, index) in $parent.merchandisingZones" :key="index"
                            :value="merchandisingZone.id">{{ merchandisingZone.name }}
                    </option>
                </select>
                <small v-if="$parent.form.errors.has('merchandising_zone_id')" class="text-danger mt-3">
                    {{ $parent.form.errors.get("merchandising_zone_id") }}
                </small>
            </div>

            <div class="form-group">
                <label>Number of merchandising zone products</label>

                <input type="number" name="number_of_merchandising_products"
                       v-model="$parent.form.number_of_merchandising_products" placeholder="Enter number of product"
                       class="form-control"
                       :class="{ 'is-invalid': $parent.form.errors.has('number_of_merchandising_products') }"
                       @keypress="$parent.form.errors.clear('number_of_merchandising_products')"/>
                <small v-if="$parent.form.errors.has('number_of_merchandising_products')" class="text-danger mt-3">
                    {{ $parent.form.errors.get("number_of_merchandising_products") }}
                </small>
            </div>

            <div class="form-group">
                <label>Number of column(per product)</label>

                <input type="number" name="number_of_column_merchandising_zone"
                       v-model="$parent.form.number_of_column_merchandising_zone" placeholder="Enter number of product"
                       class="form-control"
                       :class="{ 'is-invalid': $parent.form.errors.has('number_of_column_merchandising_zone') }"
                       @keypress="$parent.form.errors.clear('number_of_column_merchandising_zone')"/>
                <small v-if="$parent.form.errors.has('number_of_column_merchandising_zone')" class="text-danger mt-3">
                    {{ $parent.form.errors.get("number_of_column_merchandising_zone") }}
                </small>
            </div>

            <div class="form-group">
                <label class="d-block">Merchandising product attributes will show</label>

                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="checkbox" name="is_show_product_name"
                               v-model="$parent.form.merchandising_attribute_access.name">
                        Product Name
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="checkbox" name="is_show_product_image"
                               v-model="$parent.form.merchandising_attribute_access.image">
                        Product Image
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="checkbox" name="is_show_product_price"
                               v-model="$parent.form.merchandising_attribute_access.price">
                        Product Price
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="checkbox" name="is_show_product_short_desc"
                               v-model="$parent.form.merchandising_attribute_access.short_desc">
                        Product Short description
                    </label>
                </div>
            </div>
        </div>
        <!-- If type is html -->
        <div v-if="$parent.form.type == 'html'">
            <div class="form-group required">
                <label>
                    HTML Code
                </label>

                <textarea name="html_content"
                          v-model="$parent.form.html_content" placeholder="Write or past html code"
                          class="form-control"
                          rows="10"
                          :class="{ 'is-invalid': $parent.form.errors.has('html_content') }"
                          @keypress="$parent.form.errors.clear('html_content')"></textarea>
                <small v-if="$parent.form.errors.has('html_content')" class="text-danger mt-3">
                    {{ $parent.form.errors.get("html_content") }}
                </small>
            </div>
        </div>
        <!-- if type selected product -->
        <div v-if="$parent.form.type == 'product'">
            <div class="form-group">
                <div class="d-flex justify-content-between mb-2">
                    <div>
                        <label class="my-auto mr-1">Selected Products</label>
                        <button class="btn btn-danger btn-sm" type="button" @click="removeAllProductsFromList()"
                                data-toggle="tooltip" data-placement="top" title="Remove All Products">
                            <i class="las la-trash-alt"></i>
                            Remove All
                        </button>
                    </div>
                    <div>
                        <button class="btn btn-default btn-sm" type="button" @click="$refs.searchModal.resetSearch()"
                                data-toggle="tooltip" data-placement="top" title="Reset Search">
                            <i class="la la-history"></i>
                        </button>

                        <div class="btn-group">
                            <button @click="setSettings('view', 'list').$root.renderTooltip()" type="button"
                                    :class="{ active: settings.view === 'list' }"
                                    :title="`List ${settings.view === 'list' ? '(active)' : ''}`"
                                    class="btn btn-sm btn-default">
                                <i class="las la-list"></i>
                            </button>
                            <button @click="setSettings('view', 'grid').$root.renderTooltip()" type="button"
                                    :class="{ active: settings.view === 'grid' }"
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
                    <div v-if="settings.view === 'grid'">
                        <div class="container product-container mt-3 mb-0 px-0">
                            <div class="form-row">
                                <div class="col-6 col-xl-4 col-xxl-4 col-xxxl-3 mb-2"
                                     v-for="(product, index) in allProducts" :key="index"
                                     :title="product.isSkuProduct ? product.Sku_Name : product.Product_Name"
                                     data-toggle="tooltip" data-placement="top">
                                    <!-- bbb_deals -->
                                    <div class="bbb_deals pb-3 pt-5 px-3 px-xl-2">
                                        <div class="ribbon ribbon-top-right">
                                            <!--<span><small class="cross"> x </small> 4 </span>-->
                                            <span class="bg-danger cursor-pointer" title="Remove"
                                                  @click="removeProduct(index)">
                                                <i class="la la-times"></i>
                                            </span>
                                        </div>
                                        <div class="bbb_deals_title">
                                            Product ID: # {{
                                                product.isSkuProduct ? JSON.parse(product.Sku_List)[0][0] :
                                                    product.Product_Id
                                            }}
                                        </div>
                                        <div class="bbb_deals_slider_container">
                                            <div class="bbb_deals_item">
                                                <div class="bbb_deals_image">
                                                    <img @error="$root.getDefaultImage($event)"
                                                         class="img-thumbnail product-height"
                                                         :src="`${product.isSkuProduct ? product.Sku_ProductImage : product.Product_Image}`"
                                                         alt=""/>
                                                </div>
                                                <div class="bbb_deals_content mt-3">
                                                    <div
                                                        class="bbb_deals_info_line d-flex flex-row justify-content-start">
                                                        <div class="bbb_deals_item_name ellipsis">
                                                            {{
                                                                product.isSkuProduct ? product.Sku_Name :
                                                                    product.Product_Name
                                                            }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            <p class="d-block">Product attributes will show</p>

                                            <div class="form-check form-check-inline">
                                                <label class="form-check-label">
                                                    <input class="form-check-input" type="checkbox"
                                                           name="is_show_product_name"
                                                           v-model="product.Attribute_Access.name">
                                                    Product Name
                                                </label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <label class="form-check-label">
                                                    <input class="form-check-input" type="checkbox"
                                                           name="is_show_product_image"
                                                           v-model="product.Attribute_Access.image">
                                                    Product Image
                                                </label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <label class="form-check-label">
                                                    <input class="form-check-input" type="checkbox"
                                                           name="is_show_product_price"
                                                           v-model="product.Attribute_Access.price">
                                                    Product Price
                                                </label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <label class="form-check-label">
                                                    <input class="form-check-input" type="checkbox"
                                                           name="is_show_product_short_desc"
                                                           v-model="product.Attribute_Access.short_desc">
                                                    Product Short description
                                                </label>
                                            </div>

                                            <div class="form-group">
                                                <label>Product Column Size</label>
                                                <input type="number" max="12" v-model="product.Product_Column_Size"
                                                       class="form-control"/>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div v-if="!allProducts.length" class="w-100 mt-3">
                                    <NoItemFound :message="noProductFound" ref="noItemFound"/>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div v-if="settings.view === 'list'" class="rounded overflow-hidden mb-3 border">
                        <table class="table table-default table-hover mb-0">
                            <thead>
                            <tr>
                                <th scope="col" class="text-nowrap">Product ID</th>
                                <th scope="col" class="text-nowrap">Product Name</th>
                                <th scope="col" class="text-nowrap">Access Attribute</th>
                                <th scope="col" class="text-nowrap">Product Column Size</th>
                                <th scope="col" class="text-nowrap">Product Image</th>
                                <th scope="col">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(product, index) in allProducts" :key="index">
                                <td>
                                    {{ product.isSkuProduct ? JSON.parse(product.Sku_List)[0][0] : product.Product_Id }}
                                </td>

                                <td>
                                    {{ product.isSkuProduct ? product.Sku_Name : product.Product_Name }}
                                </td>
                                <td>
                                    <label class="form-check-label mr-4">
                                        <input class="form-check-input" type="checkbox" name="is_show_product_name"
                                               v-model="product.Attribute_Access.name">
                                        Product Name
                                    </label>
                                    <label class="form-check-label mr-4">
                                        <input class="form-check-input" type="checkbox" name="is_show_product_image"
                                               v-model="product.Attribute_Access.image">
                                        Product Image
                                    </label>
                                    <label class="form-check-label mr-4">
                                        <input class="form-check-input" type="checkbox" name="is_show_product_price"
                                               v-model="product.Attribute_Access.price">
                                        Product Price
                                    </label>
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="checkbox"
                                               name="is_show_product_short_desc"
                                               v-model="product.Attribute_Access.short_desc">
                                        Product Short description
                                    </label>
                                </td>
                                <td>
                                    <input class="form-control" style="width: 4rem" type="number" min="1" max="12"
                                           v-model="product.Product_Column_Size"/>
                                </td>
                                <td>
                                    <img @error="$root.getDefaultImage($event)"
                                         class="img-thumbnail height-list-product"
                                         :src="`${product.isSkuProduct ? product.Sku_ProductImage : product.Product_Image}`"
                                         alt=""/>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-danger btn-sm" @click="removeProduct(index)"
                                            data-toggle="tooltip" data-placement="top" title="Remove">
                                        <i class="lar la-trash-alt"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr v-if="!allProducts.length">
                                <td class="text-center w-100" colspan="100%">
                                    {{ noProductFound }}
                                </td>
                            </tr>
                            </tbody>
                            <tfoot>
                            <tr>
                                <th scope="col" class="text-nowrap">Product ID</th>
                                <th scope="col" class="text-nowrap">Product Name</th>
                                <th scope="col" class="text-nowrap">Access Attribute</th>
                                <th scope="col" class="text-nowrap">Product Column Size</th>
                                <th scope="col" class="text-nowrap">Product Image</th>
                                <th scope="col">Action</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <small v-if="$parent.form.errors.has('products')" class="text-danger mt-3">{{
                        $parent.form.errors.get("products")
                    }}</small>
            </div>

            <div class="card card-body">
                <search-modal calledFrom="megaMenuScreen" ref="searchModal" type="category"
                              @hook:mounted="$parent.mountedChild"/>
                <bottom ref="bottom" calledFrom="megaMenuScreen" :getProducts="getEasyAskProducts" :getModal="getModal"
                        buttonName="Select"/>
            </div>
        </div>
        <!-- If type Category Selected -->
        <div v-if="$parent.form.type == 'manufacturer'">
            <div class="form-group form-check">
                <input type="checkbox"
                       v-model="$parent.form.only_featured_manufacturer"
                       class="form-check-input" id="only_featured_manufacturer">
                <label class="form-check-label" for="only_featured_manufacturer">
                    Display Only Featured Manufacturers?
                </label>
            </div>
            <div class="form-group">
                <label>Number of Manufacturers</label>
                <input type="number" step="any" name="number_of_categories"
                       v-model="$parent.form.number_of_categories"
                       placeholder="If left empty then display all" class="form-control"
                       :class="{ 'is-invalid': $parent.form.errors.has('number_of_categories') }"
                       @keypress="$parent.form.errors.clear('number_of_categories')"/>
                <small v-if="$parent.form.errors.has('number_of_categories')" class="text-danger mt-3">
                    {{ $parent.form.errors.get("number_of_categories") }}
                </small>
            </div>
        </div>
    </div>
</template>

<script>
import _ from "lodash";
import Bottom from "../../components/selected-products/Bottom";
import SearchModal from "../../components/search-product-modal/SearchProductModal";

import NoItemFound from "../../components/NoItemFound.vue";
import Loader from "../../components/Loader.vue";

export default {
    name: "FormFields",
    props: [],
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
        };
    },
    mounted() {
        this.getSettings();
        this.$root.renderTooltip();
    },
    components: {SearchModal, Bottom, NoItemFound, Loader},
    methods: {
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

        addNewLinkItem() {
            this.$parent.form.links.unshift({
                name: "",
                link: "",
            });
        },

        removeLinkItem(index) {
            this.$parent.form.links.splice(index, 1);
        },

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

        reStructureSeoPath(seoPath) {
            if (
                this.isSearchStringExist(seoPath) &&
                this.$refs.searchModal.categories.length === 0
            ) {
                this.$refs.searchModal.resetData(true);
            } else if (this.isSearchStringExist(seoPath)) {
                this.$refs.searchModal.$refs.top.site_search = "";
                this.site_search = "";
            } else if (
                this.$refs.searchModal.categories.some(
                    (category) => category.nodeString === seoPath
                )
            ) {
                _.remove(
                    this.$refs.searchModal.categories,
                    (category) => category.nodeString === seoPath
                );

                if (
                    this.$refs.searchModal.categories.length > 0 ||
                    this.$refs.searchModal.$refs.top.site_search !== ""
                ) {
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
            return (
                seoPath.charAt(0) === "-" &&
                seoPath.substring(seoPath.indexOf("-") + 1) ===
                this.$refs.searchModal.$refs.top.site_search
            );
        },

        getEasyAskProducts(product_id = null, notifiable = true, attributeAccess = this.$parent.defaultProductAttributeAccess, productColumnSize = this.$parent.defaultProductColumnSize) {
            // Removing error messages
            this.$parent.form.errors.clear('products');

            if (product_id !== null) {
                let url = `${this.productByIdUrl}?id=${product_id}&categoryProduct=true&selectAllFieldsWithAttributes=true`;
                this.$refs.bottom.smallLoader = true;

                axios
                    .post(url)
                    .then(({data}) => {
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
                        .then(({data}) => {
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

        mergeSeoPaths({brands, categories}) {
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

        onMegaMenuTypeChange(type) {
            if (type === "product") {
                this.$nextTick(() => {
                    this.getModal = this.$refs.searchModal.getModal;
                });
            }
        },
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
                this.$parent.form.products = products.map(product => ({
                    product_id: product.Product_Id,
                    attribute_access: product.Attribute_Access,
                    product_column_size: product.Product_Column_Size
                }));
            }, deep: true
        }
    }
};
</script>

<style>
.product-attribute {
    height: 50vh;
    overflow-y: auto;
}

#searchModalRight {
    height: 54vh;
    overflow-y: auto;
}
</style>
