<template>
  <div class="row">
    <!-- load the view from type and view_namespace attribute if set -->

    <!-- hidden input -->
    <div class="hidden">
      <input type="hidden" name="products" value="" class="form-control" />
    </div>


    <!-- searchTop -->
    <Top
      ref="top"
      :fromSelectedList="fromSelectedList"
      :calledFrom="calledFrom"
      :module="module"
    />

    <div class="form-group col-sm-12">
      <hr class="mb-0" />
    </div>

    <div class="form-group col-sm-12">
      <div class="d-flex justify-content-between mb-2">
        <div>
          <label class="my-auto mr-1">{{ labelSelectedProducts }}</label>
          <button
            class="btn btn-danger btn-sm"
            type="button"
            @click="removeAllProductsFromList()"
            data-toggle="tooltip"
            data-placement="top"
            title="Remove All Products"
          >
            <i class="las la-trash-alt"></i>
            Remove All
          </button>
        </div>
        <div>
          <button
            class="btn btn-default btn-sm"
            type="button"
            @click="$parent.resetSearch()"
            data-toggle="tooltip"
            data-placement="top"
            title="Reset Search"
          >
            <i class="la la-history"></i>
          </button>

          <div class="btn-group">
            <button
              @click="setSettings('view', 'list').$root.renderTooltip()"
              type="button"
              :class="{ active: settings.view === 'list' }"
              :title="`List ${settings.view === 'list' ? '(active)' : ''}`"
              class="btn btn-sm btn-default"
            >
              <i class="las la-list"></i>
            </button>
            <button
              @click="setSettings('view', 'grid').$root.renderTooltip()"
              type="button"
              :class="{ active: settings.view === 'grid' }"
              :title="`Grid ${settings.view === 'grid' ? '(active)' : ''}`"
              class="btn btn-sm btn-default"
            >
              <i class="las la-th-large"></i>
            </button>
          </div>
        </div>
      </div>

      <div v-if="loading">
        <Loader />
      </div>

      <div v-else>
        <div v-if="settings.view === 'grid'">
          <div
            class="container product-container mt-3 mb-0 px-0"
            :key="$parent.reRenderTable"
          >
            <div class="form-row">
              <div
                class="col-6 col-xl-4 col-xxl-4 col-xxxl-3 mb-2"
                v-if="$parent.currentProducts.length"
                v-for="(product, index) in $parent.currentProducts"
                :title="
                  product.isSkuProduct ? product.Sku_Name : product.Product_Name
                "
                data-toggle="tooltip"
                data-placement="top"
              >
                <!-- bbb_deals -->
                <div class="bbb_deals pb-3 pt-5 px-3 px-xl-2">
                  <div class="ribbon ribbon-top-right">
                    <!--<span><small class="cross"> x </small> 4 </span>-->
                    <span
                      class="bg-danger cursor-pointer"
                      title="Remove"
                      @click="removeProduct(product.Product_Id, index)"
                    >
                      <i class="la la-times"></i>
                    </span>
                  </div>
                  <div class="bbb_deals_title">
                    Product ID: #
                    {{
                      product.isSkuProduct
                        ? JSON.parse(product.Sku_List)[0][0]
                        : product.Product_Id
                    }}
                  </div>
                  <div class="bbb_deals_slider_container">
                    <div class="bbb_deals_item">
                      <div class="bbb_deals_image">
                        <img
                          v-if="
                            module === 'icecat-transformations' ||
                            module === 'products'
                          "
                          @error="$root.getDefaultImage($event)"
                          class="img-thumbnail product-height"
                          :src="`${
                            product.isSkuProduct
                              ? product.Sku_ProductImage
                              : product.Product_Image
                          }`"
                          alt=""
                        />

                        <img
                          v-else
                          @error="$root.getDefaultImage($event)"
                          class="img-thumbnail product-height"
                          :src="`${
                            product.Thumbnail
                              ? product.Thumbnail
                              : placeholderImage
                          }`"
                          alt=""
                        />
                      </div>
                      <div class="bbb_deals_content mt-3">
                        <div
                          class="
                            bbb_deals_info_line
                            d-flex
                            flex-row
                            justify-content-start
                          "
                        >
                          <div class="bbb_deals_item_name ellipsis">
                            {{
                              product.isSkuProduct
                                ? product.Sku_Name
                                : product.Product_Name
                            }}
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div v-if="!$parent.currentProducts.length" class="w-100 mt-3">
                <NoItemFound :message="noProductFound" ref="noItemFound" />
              </div>
            </div>
          </div>
        </div>
        <div
          v-if="settings.view === 'list'"
          class="rounded overflow-hidden mb-3 border"
        >
          <table
            :key="$parent.reRenderTable"
            class="table table-default table-hover mb-0"
          >
            <thead>
              <tr>
                <th scope="col" class="text-nowrap">Product ID</th>
                <th scope="col" class="text-nowrap">Product Name</th>
                <th scope="col" class="text-nowrap">Product Image</th>
                <th scope="col">Action</th>
              </tr>
            </thead>
            <tbody>
              <tr
                v-if="$parent.currentProducts.length"
                v-for="(product, index) in $parent.currentProducts"
                :key="index"
              >
                <td>
                  {{
                    product.isSkuProduct
                      ? JSON.parse(product.Sku_List)[0][0]
                      : product.Product_Id
                  }}
                </td>

                <td>
                  {{
                    product.isSkuProduct
                      ? product.Sku_Name
                      : product.Product_Name
                  }}
                </td>
                <td>
                  <img
                    v-if="
                      module === 'icecat-transformations' || module === 'products'
                    "
                    @error="$root.getDefaultImage($event)"
                    class="img-thumbnail height-list-product"
                    :src="`${
                      product.isSkuProduct
                        ? product.Sku_ProductImage
                        : product.Product_Image
                    }`"
                    alt=""
                  />

                  <img
                    v-else
                    @error="$root.getDefaultImage($event)"
                    class="img-thumbnail height-list-product"
                    :src="`${
                      product.Thumbnail ? product.Thumbnail : placeholderImage
                    }`"
                    alt=""
                  />
                </td>
                <td>
                  <button
                    type="button"
                    class="btn btn-danger btn-sm"
                    @click="removeProduct(product.Product_Id, index)"
                    data-toggle="tooltip"
                    data-placement="top"
                    title="Remove"
                  >
                    <i class="lar la-trash-alt"></i>
                  </button>
                </td>
              </tr>
              <tr v-if="!$parent.currentProducts.length">
                <td class="text-center w-100" colspan="100%">
                  {{ noProductFound }}
                </td>
              </tr>
            </tbody>
            <tfoot>
              <tr>
                <th scope="col" class="text-nowrap">Product ID</th>
                <th scope="col" class="text-nowrap">Product Name</th>
                <th scope="col" class="text-nowrap">Product Image</th>
                <th scope="col">Action</th>
              </tr>
            </tfoot>
          </table>
        </div>
      </div>
    </div>

    <hr class="w-100" />

    <SearchModal
      :calledFrom="calledFrom"
      :module="module"
      ref="searchModal"
      :type="type"
    />

    <Bottom
      ref="bottom"
      :calledFrom="calledFrom"
      :module="module"
      :getProducts="$parent.getEasyAskProducts"
      :getModal="getModal"
    />
  </div>
</template>

<script>
import Bottom      from "../../components/selected-products/Bottom";
import SearchModal from "../../components/search-product-modal/SearchProductModal";
import Top from "../search-product-modal/body/Top";
import NoItemFound from "../NoItemFound";
import Loader from "../../components/Loader";
import _ from "lodash";

export default {
  name: "SelectedProducts",
  props: ["currentProducts", "reRenderTable", "type", "calledFrom", "module"],

  components: { NoItemFound, Top, Bottom, SearchModal, Loader },

  data() {
    return {
      settings: {
        view: null,
      },
      defaultSettings: {
        view: "grid",
      },
      noProductFound: "No Product Found",
      search_by_product_id: null,
      placeholderImage: this.$root.config.fallback_image,
      getModal: null,
      paginationBackup: {
        currentPage: 1,
        firstItem: 0,
        isDrillDownActive: false,
        lastItem: 0,
        pageCount: 0,
        resultsPerPage: 12,
        totalItems: 0,
        //sortOrder        : "EAScore,f,EAFeatured Weight,f,Bestseller Rank,t",
      },
      pagination: {},
      perPages: this.$root.config.pagination_options,
      fromSelectedList: true,
      labelSelectedProducts: "",
      loading: false,
    };
  },

  mounted() {
    this.pagination = _.cloneDeep(this.paginationBackup);

    this.getSettings();

    this.$root.renderTooltip();

    this.getModal = this.$refs.searchModal.getModal;

    this.initialSetup();
  },

  methods: {
    removeProduct(Product_Id, index = null) {
      this.$swal({
        title: "Remove this product?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#ff6b81",
        cancelButtonColor: "#399E7F",
        confirmButtonText: "Remove",
      }).then((result) => {
        if (result.isConfirmed) {
          let product_id =
            _.cloneDeep(this.$parent.currentProducts[index]).Product_Id ?? "";

          if (this.module === "icecat-transformations") {
            this.$parent.removeProduct(product_id);
          } else {
            if (this.$parent.removeAProduct) {
              this.$parent.removeAProduct(product_id);
            }

            this.$parent.currentProducts.splice(index, 1);
            this.$parent.currentProductsBackup.splice(index, 1);
            this.pagination = {
              ...this.pagination,
              ...{
                firstItem:
                  this.pagination.totalItems > 1
                    ? this.pagination.firstItem
                    : 0,
                lastItem: this.pagination.lastItem - 1,
                totalItems: this.pagination.totalItems - 1,
              },
            };

            new Noty({
              type: "success",
              text: `Product removed successfully!`,
            }).show();
          }
        }
      });

      //this.reRenderTable++;
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

    setDebounce(fromSelectedList = false, site_search = null) {
      clearTimeout(this.timer);
      this.timer = setTimeout(() => {
        if (fromSelectedList) {
          this.$parent.getProductList(site_search);
        } else if (
          this.calledFrom === "categoryModule" ||
          this.calledFrom === "productClassificationModule"
        ) {
          this.resetData(false, false);
          this.$parent.resetNavPath();
          this.$parent.getEasyAskProducts();
        } else if (this.calledFrom === "productModule") {
          this.resetData(false, false);
          this.$parent.resetNavPath();
          this.$parent.getEasyAskProducts();
        }
      }, 600);
    },

    resetData(resetSiteSearch = false, showResetMessage = true) {
      if (resetSiteSearch) {
        this.$parent.site_search = "";
        this.$refs.top.site_search = "";

        this.$parent.navPath = _.cloneDeep(this.$parent.defaultNavPath);
      }

      this.attributes = [];
      this.attributeOptions = [];
      this.brands = [];
      this.brandOptions = [];
      this.categories = [];

      if (this.calledFrom === "productModule" && resetSiteSearch) {
        this.categoryOptions = _.cloneDeep(this.categoryOptionsBackup);
      } else if (this.calledFrom === "categoryModule") {
        this.categoryOptions =
          this.$parent.$parent.easyAskDefaultProductCategories;
      }

      this.searchResultProducts = [];
      this.selectedProductsArr = [];
      this.pagination = _.cloneDeep(this.paginationBackup);

      showResetMessage
        ? new Noty({
            type: "success",
            text: "Reset Successful!",
          }).show()
        : false;
    },

    changeCurrentPage(next = true) {
      let currentPage = this.pagination.currentPage;

      next && this.pagination.currentPage < this.pagination.pageCount
        ? this.pagination.currentPage++
        : false;

      !next && this.pagination.currentPage > 1
        ? this.pagination.currentPage--
        : false;

      let site_search = null;
      if (this.fromSelectedList) {
        site_search = this.$refs.top.site_search;
      }

      currentPage !== this.pagination.currentPage
        ? this.$parent.getProductList(site_search)
        : false;
    },

    initialSetup() {
      if (this.calledFrom === "categoryModule") {
        this.labelSelectedProducts = "Products In Category";
      } else if (this.calledFrom === "productModule") {
        this.labelSelectedProducts =
          this.module === "products"
            ? "Products In Bundle"
            : "Selected Products";
      } else if (this.calledFrom === "productClassificationModule") {
        this.labelSelectedProducts = "Products In Product Classification";
      }
    },

    async removeAllProductsFromList() {
      if (this.$parent.currentProducts.length > 0) {
        this.$swal({
          title: "Remove all products?",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#ff6b81",
          cancelButtonColor: "#399E7F",
          confirmButtonText: "Remove",
        }).then(async (result) => {
          if (result.isConfirmed) {
            if (this.module === "icecat-transformations") {
              this.$parent.allProducts = [];
              this.$parent.currentProducts = [];
              await this.$parent.saveDataToSession();
              new Noty({
                type: "success",
                text: "All products removed from list!",
              }).show();
            //   await this.$parent.getProductList();
            } else {
              if (this.calledFrom === "categoryModule") {
                this.$parent.removeAllProductsFromCategory();
              }

              if (this.calledFrom === "productClassificationModule") {
                this.$parent.removeAllProductsFromProductClassification();
              }

              if (this.calledFrom === "productModule") {
                this.$parent.removeAllBundleProductsFromProduct();
              }
            }
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
  },
};
</script>

<style scoped>
</style>

<style>
@media (min-width: 576px) {
  .product-height {
    height: 200px !important;
  }
}

@media (min-width: 768px) {
  .product-height {
    height: 200px !important;
  }
}

@media (min-width: 992px) {
  .product-height {
    height: 200px !important;
  }
}

@media (min-width: 1200px) {
  .product-height {
    height: 200px !important;
  }
}

@media (min-width: 1440px) {
  .product-height {
    height: 200px !important;
  }
}

@media (min-width: 1600px) {
  .product-height {
    height: 178px !important;
  }

  .product-height.modal-image {
    height: 132px !important;
  }
}

.bbb_deals_image img {
  width: 100%;
  object-fit: contain;
}
</style>
