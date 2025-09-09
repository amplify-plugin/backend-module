<template>
  <div id="searchSkuProductModal">
    <div class="modal fade" id="addSkuProductModal" tabIndex="0"
         role="dialog" aria-labelledby="addSkuProductModalLabel"
         data-backdrop="static" data-keyboard="false"
         aria-modal="true" style="top: -10px!important;">
      <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
          <div class="modal-header modal-moveable">
            <h5 class="modal-title" id="addSkuProductModalLabel">
              Select products
            </h5>
            <button type="button" class="close" data-dismiss="modal"
                    @click="modalShade = ''; $parent.$parent.onSearchSkuProductModalClose()"
                    aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body bg-light" style="padding: 0.5rem!important;">
            <div class="card mb-0">
              <div class="card-body row mb-0 pb-0">
                <div class="form-group col-sm-12">
                  <div class="w-100 d-flex justify-content-between my-2">
                    <div>
                      <label class="m-0 m-0 mb-0 my-auto">
                        Search in sku products <i v-if="$parent.$parent.searching"
                                                  class="la la-spinner la-pulse"></i>
                        <small>
                          (Showing {{ $parent.$parent.pagination.firstItem }} to
                          {{ $parent.$parent.pagination.lastItem }} of
                          {{ $parent.$parent.pagination.totalItems }} items)
                        </small>
                      </label>
                      <div class="checkbox my-0 my-lg-2 ml-2">
                        <input id="return_skus" type="checkbox"
                               v-model="$parent.$parent.returnSKUS" @click="$parent.$parent.returnSKUSClicked = true;">
                        <label for="return_skus" class="form-check-label font-weight-normal">Return
                          SKUS </label>
                      </div>
                    </div>
                    <div class="pagination">
                                            <span class="btn btn-outline-default mr-1"
                                                  :class="$parent.$parent.pagination.currentPage <= 1
                                                      ? 'disabled'
                                                      : 'text-dark cursor-pointer'"
                                                  @click="$parent.$parent.changeCurrentPage(false)"
                                                  :title="`${$parent.$parent.pagination.currentPage <= 1
                                                                ? ''
                                                                : 'Previous (' + ($parent.$parent.pagination.currentPage - 1) + ')'}`">
                                                <i class="la la-less-than"></i>
                                            </span>
                      <select v-model="$parent.$parent.pagination.resultsPerPage"
                              class="rounded border border-secondary"
                              title="Results Per Page"
                              @change="$parent.onChangePaginationDropdown()">
                        <option :value="perPage" v-for="perPage in $parent.$parent.perPages"
                                :key="perPage">
                          {{ perPage }}
                        </option>
                      </select>
                      <span class="btn btn-outline-default ml-1"
                            :class="$parent.$parent.pagination.currentPage >= $parent.$parent.pagination.pageCount
                                                      ? 'disabled'
                                                      : 'text-dark cursor-pointer'"
                            @click="$parent.$parent.changeCurrentPage(true)"
                            :title="`${$parent.$parent.pagination.currentPage >= $parent.$parent.pagination.pageCount
                                                                ? ''
                                                                : 'Next (' + ($parent.$parent.pagination.currentPage + 1) + ')'}`">
                                                <i class="la la-greater-than"></i>
                                            </span>
                    </div>
                  </div>
                  <input type="text" name="search_product" class="form-control"
                         :readonly="$parent.$parent.searching"
                         v-model="$parent.$parent.skus_search"
                         @keyup="$parent.setDebounce()"
                         placeholder="Search product...">
                </div>
                <div class="form-group col-sm-12 mb-0 ">
                  <div class="d-flex justify-content-between mb-2">
                    <label class="mb-0">Results</label>
                    <div>
                      <button class="btn btn-primary btn-sm"
                              type="button"
                              @click="$parent.$parent.selectAllProductsOfSearchScreen();"
                              :disabled="$parent.$parent.fetchingList"
                              data-toggle="tooltip" data-placement="top"
                              title="Select All Products">
                        <i class="las la-object-group"></i>
                        Select All
                      </button>
                      <button class="btn btn-default btn-sm"
                              @click="$parent.$parent.resetData(true);"
                              data-toggle="tooltip" data-placement="top"
                              data-original-title="Reset Search">
                        <i class="la la-history"></i>
                      </button>

                      <!--                                            <button class="btn btn-default btn-sm"-->
                      <!--                                                    @click="dontShowAll = !dontShowAll;"-->
                      <!--                                                    data-toggle="tooltip" data-placement="top"-->
                      <!--                                                    :data-original-title="dontShowAll ? 'Show All' : 'Show Selectable'">-->
                      <!--                                                <i :class="dontShowAll ? 'la-expand-arrows-alt' : 'la-compress-arrows-alt'"-->
                      <!--                                                   class="las"></i>-->
                      <!--                                            </button>-->

                      <button class="btn btn-default btn-sm"
                              @click="$parent.setDebounce(null);"
                              data-toggle="tooltip" data-placement="top"
                              data-original-title="Refresh List">
                        <i :class="{'la-pulse': $parent.$parent.fetchingList}"
                           class="las la-sync"></i>
                      </button>

                      <div class="btn-group">
                        <button
                            @click="$parent.setSettings('view', 'list').$root.renderTooltip()"
                            :class="{'active' : $parent.settings.view === 'list'}"
                            data-toggle="tooltip" data-placement="top"
                            :data-original-title="`List ${$parent.settings.view === 'list' ? '(active)' : ''}`"
                            class="btn btn-sm btn-default">
                          <i class="las la-list"></i>
                        </button>
                        <button
                            @click="$parent.setSettings('view', 'grid').$root.renderTooltip()"
                            :class="{'active' : $parent.settings.view === 'grid'}"
                            data-toggle="tooltip" data-placement="top"
                            :data-original-title="`Grid ${$parent.settings.view === 'grid' ? '(active)' : ''}`"
                            class="btn btn-sm btn-default">
                          <i class="las la-th-large"></i>
                        </button>
                      </div>

                    </div>
                  </div>
                  <div>
                    <div v-if="$parent.settings.view === 'list'"
                         class="rounded overflow-hidden mb-3 border">
                      <table id="result-table" :key="$parent.$parent.reRenderAddTable"
                             class="table table-default table-hover m-0">
                        <thead>
                        <tr>
                          <th scope="col">ADD</th>
                          <th scope="col">ID</th>
                          <th scope="col">SKU Name</th>
                          <th scope="col">SKU Image</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-if="$parent.$parent.searchResultSKUProducts.length"
                            v-for="(product, index) in $parent.$parent.searchResultSKUProducts"
                            :class="{'already-added':product.duplicate}">
                          <td>
                            <div class="custom-control custom-checkbox">
                              <input v-model="product.is_checked" type="checkbox"
                                     @input="$parent.$parent.selectedSKUProducts(product)"
                                     :disabled="product.duplicate"
                                     class="form-check-input checkedSearchedProducts">

                              <span v-if="product.duplicate"
                                    class="badge badge-success">Added</span>
                            </div>
                          </td>
                          <td>
                            {{ product.Product_Id }}
                          </td>
                          <td>
                            {{ product.isSkuProduct ? product.Sku_Name : product.Product_Name }}
                          </td>
                          <td>
                            <img @error="$root.getDefaultImage"
                                 class="img-thumbnail height-list-product"
                                 :src="`${product.isSkuProduct ? product.Sku_ProductImage : product.Product_Image}`"
                                 alt="">
                          </td>
                        </tr>
                        <tr v-if="!$parent.$parent.searchResultSKUProducts.length">
                          <td class="text-center" colspan="100%"
                              style="width: 100%!important">
                            {{ $parent.$parent.noProductFound }}
                          </td>
                        </tr>
                        </tbody>
                        <tfoot>
                        <tr>
                          <th scope="col">ADD</th>
                          <th scope="col">ID</th>
                          <th scope="col">SKU Name</th>
                          <th scope="col">SKU Image</th>
                        </tr>
                        </tfoot>
                      </table>
                    </div>
                    <div v-if="$parent.settings.view === 'grid'">
                      <div class="container product-container mt-3 mb-0 px-0"
                           :key="$parent.$parent.reRenderAddTable">
                        <div class="form-row">
                          <div class="col-6 col-xl-4 col-xxl-4 col-xxxl-2 mb-2"
                               v-if="$parent.$parent.searchResultSKUProducts.length"
                               v-for="(product, index) in $parent.$parent.searchResultSKUProducts"
                               :title="product.isSkuProduct ? product.Sku_Name : product.Product_Name"
                               data-toggle="tooltip"
                               data-placement="top">
                            <!-- bbb_deals -->
                            <div class="bbb_deals pb-3 pt-5 px-3 px-xl-2"
                                  v-if="product.Product_Code && product.Product_Name"
                                 :class="{'already-added' : product.duplicate}">
                              <div class="bbb_deals_title">
                                <label class="custom-control custom-checkbox">
                                  <input v-model="product.is_checked" type="checkbox"
                                         @input="$parent.$parent.selectedSKUProducts(product)"
                                         :disabled="product.duplicate"
                                         class="form-check-input checkedSearchedProducts">

                                         <template v-if="product.Product_Name.includes(product.Product_Code)">
                                            <p class="ellipsis ellipsis-text">{{product.Product_Name}}</p>
                                         </template>

                                         <template v-else>
                                            <p class="ellipsis ellipsis-text"> {{product.Product_Code}} {{product.Product_Name}} </p>
                                         </template> 
                                 
                                </label>
                              </div>
                              <div class="bbb_deals_slider_container">
                                <div class=" bbb_deals_item">
                                  <div class="bbb_deals_image">
                                    <img @error="$root.getDefaultImage"
                                         class="img-thumbnail product-height modal-image"
                                         :src="`${product.isSkuProduct ? product.Sku_ProductImage : product.Product_Image}`"
                                         :alt="product.isSkuProduct ? product.Sku_Name : product.Product_Name">
                                  </div>

                                  <div class="bbb_deals_content mt-3">
                                    <div class="bbb_deals_info_line d-flex flex-row justify-content-start">
                                        <span v-if="product.duplicate" class="badge badge-success">Added</span>
                                    </div>
                                  </div>
                                  
                                </div>
                              </div>
                            </div>
                          </div>
                          <div v-if="!$parent.$parent.searchResultSKUProducts.length"
                               class="w-100">
                            <NoItemFound :message="$parent.noProductFound"
                                         ref="noItemFound"/>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer modal-moveable">
            <button type="button" class="btn btn-primary  mr-lg-0"
                    :disabled="$parent.$parent.loadingBtnOnAdd"
                    @click="$parent.$parent.addMultipleSKUToList()">

                            <span v-if="$parent.$parent.loadingBtnOnAdd">
                                <span class="spinner-border spinner-border-sm"
                                      role="status"
                                      aria-hidden="true">
                                </span>
                                <span class="sr-only">Loading...</span>
                            </span>
              <span v-else>
                                Add
                            </span>
            </button>
            <button type="button" class="btn btn-secondary mr-auto" data-dismiss="modal"
                    @click="modalShade = ''; $parent.$parent.onSearchSkuProductModalClose()"
                    aria-label="Close" id="cancelButton">
              Cancel
            </button>
          </div>
        </div>
      </div>
    </div>
    <div v-html="modalShade"></div>
  </div>
</template>

<script>
import _           from "lodash";
import $           from 'jquery';
import 'jquery-ui-dist/jquery-ui';
import NoItemFound from "../NoItemFound";

export default {
  name      : "SearchSkuProductModal",
  components: {NoItemFound},
  props     : [""],
  data() {
    return {
      loadedModal     : 'Loading modal...',
      modalShade      : '',
      modalBody       : 'Loading...',
      placeholderImage: this.$root.config.fallback_image,
      timer           : null,
      dontShowAll     : false,
    }
  },

  mounted() {

  },

  methods: {
    getModal() {
      setTimeout(() => {
        $('.modal-dialog').draggable({
          handle: ".modal-moveable"
        });
        this.$parent.$parent.skus_search             = '';
        this.$parent.$parent.returnSKUS              = false;
        this.$parent.$parent.selectedSKUProductsArr  = [];
        this.$parent.$parent.searchResultSKUProducts = [];
        this.$parent.$parent.pagination              = {
          currentPage   : 1,
          firstItem     : 0,
          pageCount     : 0,
          resultsPerPage: 12,
          totalItems    : 0
        };
        let modalShade                               = document.querySelector(".modal-backdrop.fade.show");
        modalShade ? modalShade.remove() : null;
        this.modalShade = modalShade.outerHTML;
        this.modalBody  = document.querySelector("#addSkuProductModal .modal-body").innerHTML;
      }, 100);
    },

    changeCurrentPage(next = true) {
      let currentPage = this.$parent.$parent.pagination.currentPage;

      next && this.$parent.$parent.pagination.currentPage < this.$parent.$parent.pagination.pageCount
      ? this.$parent.$parent.pagination.currentPage++
      : false;

      !next && this.$parent.$parent.pagination.currentPage > 1
      ? this.$parent.$parent.pagination.currentPage--
      : false;

      currentPage !== this.$parent.$parent.pagination.currentPage
      ? this.$parent.setDebounce()
      : false;
    },

    renderTooltip() {
      this.$root.renderTooltip();
    },

    closeSearchModal() {
      $('#cancelButton').click();
    }
  },

  computed: {
    _() {
      return _;
    },
  }
}
</script>

<style lang="scss">
#searchSkuProductModal {
  #result-table tr td:first-child,
  #result-table tr th:first-child {
    width: 16% !important;
  }

  #result-table tr td:not(first-child),
  #result-table tr th:not(first-child) {
    width: 21% !important;
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

.checkedSearchedProducts {
  transform: scale(1.3);
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

.already-added {
  background: #f7f1e3;
}

.modal-moveable {
  cursor: move;
}
.ellipsis-text{
  width: 141px;
  font-size: 12px;
  margin-top: 4px;
  position: absolute;
}
</style>
