<template>
    <div class="form-group mb-0 pt-3 col-sm-8">
        <div class="d-flex justify-content-between mb-2">
            <label class="mb-0">Results</label>
            <div>
                <button class="btn btn-primary btn-sm"
                    v-if="$parent.showSelectAllItems && $parent.pagination.totalItems > 0" type="button"
                    @click="$parent.selectAllProductsOfSearchScreen(true);" :disabled="$parent.fetchingList"
                    data-toggle="tooltip" data-placement="top" title="Select All Products">
                    <i class="las la-object-group"></i>
                    Select All {{ $parent.pagination.totalItems }} Items
                </button>
                <button class="btn btn-primary btn-sm" v-if="!['dataTransformationTestScreen'].includes($parent.calledFrom)"
                    type="button" @click="$parent.selectAllProductsOfSearchScreen();" :disabled="$parent.fetchingList"
                    data-toggle="tooltip" data-placement="top" title="Select All Products">
                    <i class="las la-object-group"></i>
                    Select All
                </button>
                <button class="btn btn-default btn-sm" type="button" @click="$parent.makeDebounceSearch(null);"
                    :disabled="$parent.fetchingList" data-toggle="tooltip" data-placement="top" title="Refresh List">
                    <i :class="{ 'la-pulse': $parent.fetchingList }" class="las la-sync"></i>
                </button>
                <div class="btn-group">
                    <button @click="$parent.$parent.setSettings('view', 'list').$root.renderTooltip()"
                        :disabled="$parent.fetchingList" type="button"
                        :class="{ 'active': $parent.$parent.settings.view === 'list' }" data-toggle="tooltip"
                        data-placement="top"
                        :title="`List ${$parent.$parent.settings.view === 'list' ? '(active)' : ''}`"
                        class="btn btn-sm btn-default">
                        <i class="las la-list"></i>
                    </button>
                    <button @click="$parent.$parent.setSettings('view', 'grid').$root.renderTooltip()" type="button"
                        :class="{ 'active': $parent.$parent.settings.view === 'grid' }" :disabled="$parent.fetchingList"
                        data-toggle="tooltip" data-placement="top"
                        :title="`Grid ${$parent.$parent.settings.view === 'grid' ? '(active)' : ''}`"
                        class="btn btn-sm btn-default">
                        <i class="las la-th-large"></i>
                    </button>
                </div>
            </div>
        </div>

        <div id="searchModalRight" v-if="!$parent.fetchingList">
            <div v-if="$parent.$parent.settings.view === 'grid'">

                <div class="container product-container mt-3 mb-0 px-0">
                    <div class="form-row">
                        <div class="col-6 col-xl-4 col-xxl-4 col-xxxl-3 mb-2"
                            v-for="(product, index) in $parent.searchResultProducts" :key="index"
                            :title="product.isSkuProduct ? product.Sku_Name : product.Product_Name"
                            data-toggle="tooltip" data-placement="top">
                            <!-- bbb_deals -->
                            <div class="bbb_deals pb-3 pt-5 px-3 px-xl-2"
                                :class="{ 'already-added': product.duplicate }">
                                <label class="bbb_deals_title">
                                    <input v-if="!['dataTransformationTestScreen'].includes($parent.calledFrom)"
                                        v-model="product.is_checked" type="checkbox" :disabled="product.duplicate"
                                        @input="$parent.selectedProducts(product)" class="mr-2 checkedSearchedProducts">
                                    <small>ID: #{{ product.Product_Id }}</small>
                                    <span v-if="product.duplicate" class="badge badge-success">Added</span>
                                </label>
                                <div class="bbb_deals_slider_container">
                                    <div class=" bbb_deals_item">
                                        <div class="bbb_deals_image">
                                            <img @error="$root.getDefaultImage"
                                                class="img-thumbnail product-height modal-image"
                                                :src="`${($parent.$parent.calledFrom === 'categoryModule' || $parent.calledFrom === 'productClassificationModule' || $parent.calledFrom === 'dataTransformationTestScreen')
                                                ? product.Thumbnail : (product.isSkuProduct ? product.Sku_ProductImage : product.Product_Image)}`"
                                                :alt="product.Product_Name">
                                        </div>
                                        <div class="bbb_deals_content mt-3">
                                            <div class="bbb_deals_info_line d-flex flex-row justify-content-start">
                                                <div class="bbb_deals_item_name ellipsis"><small>
                                                        {{ product.isSkuProduct ? product.Sku_Name : product.Product_Name }}
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                        <div v-if="['dataTransformationTestScreen'].includes($parent.calledFrom)"
                                            class="bbb_deals_content mt-3">
                                            <div class="btn-group d-flex w-100">
                                                <button @click="$parent.$parent.getEasyAskProducts(product.Product_Id)"
                                                    data-toggle="tooltip" data-placement="top" title="Select Product"
                                                    class="btn btn-info btn-sm" type="button"
                                                    data-original-title="Select">
                                                    <span><i disabled="disabled" class="lar la-hand-pointer"></i>&nbsp;
                                                    </span>
                                                    Select
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div v-if="!$parent.searchResultProducts.length" class="w-100">
                            <NoItemFound :message="$parent.noProductFound" ref="noItemFound" />
                        </div>
                    </div>
                </div>
            </div>

            <div v-if="$parent.$parent.settings.view === 'list'" class="rounded overflow-hidden mb-3 border">
                <table id="result-table" :key="$parent.reRenderAddTable" class="table table-default table-hover m-0">
                    <thead>
                        <tr>
                            <th scope="col">Add</th>
                            <th scope="col" class="text-nowrap">Product ID</th>
                            <th scope="col" class="text-nowrap">Product Name</th>
                            <th scope="col" class="text-nowrap">Product Image</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(product, index) in $parent.searchResultProducts" :key="index"
                            :class="{ 'already-added': product.duplicate }">
                            <td>
                                <div v-if="!['dataTransformationTestScreen'].includes($parent.calledFrom)"
                                    class="custom-control custom-checkbox">
                                    <input v-model="product.is_checked" type="checkbox" :disabled="product.duplicate"
                                        @input="$parent.selectedProducts(product)"
                                        class="form-check-input checkedSearchedProducts">
                                    <span v-if="product.duplicate" class="badge badge-success">Added</span>
                                </div>

                                <div v-if="['dataTransformationTestScreen'].includes($parent.calledFrom)"
                                    class="bbb_deals_content mt-3">
                                    <div class="btn-group d-flex w-100">
                                        <button @click="$parent.$parent.getEasyAskProducts(product.Product_Id)"
                                            data-toggle="tooltip" data-placement="top" title="Select Product"
                                            class="btn btn-info btn-sm" type="button" data-original-title="Select">
                                            <span><i disabled="disabled" class="lar la-hand-pointer"></i>&nbsp; </span>
                                        </button>
                                    </div>
                                </div>
                            </td>
                            <td>
                                {{ product.Product_Id }}
                            </td>
                            <td>
                                {{ product.isSkuProduct ? product.Sku_Name : product.Product_Name }}
                            </td>
                            <td>
                                <img @error="$root.getDefaultImage" class="img-thumbnail height-list-product"
                                    :src="`${($parent.$parent.calledFrom === 'categoryModule' || $parent.calledFrom === 'productClassificationModule' || $parent.calledFrom === 'dataTransformationTestScreen')
                                    ? product.Thumbnail : (product.isSkuProduct ? product.Sku_ProductImage : product.Product_Image)}`" alt="">
                            </td>
                        </tr>
                        <tr v-if="!$parent.searchResultProducts.length">
                            <td class="text-center" colspan="100%" style="width: 100%!important">
                                {{ $parent.$parent.noProductFound }}
                            </td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th scope="col">Add</th>
                            <th scope="col" class="text-nowrap">Product ID</th>
                            <th scope="col" class="text-nowrap">Product Name</th>
                            <th scope="col" class="text-nowrap">Product Image</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <div v-else>
            <Loader />
        </div>
    </div>
</template>

<script>
import NoItemFound from "../../NoItemFound";
import Loader from "../../../components/Loader";

export default {
    name: "Right",
    components: { NoItemFound, Loader },
    data() {
        return {}
    },
}
</script>

<style scoped>
.grid_checkbox_wrapper {
    position: absolute;
    top: 9px;
    right: 11px;
}

.already-added {
    background: #f7f1e3;
}

.checkedSearchedProducts {
    transform: scale(1.3);
}
</style>
