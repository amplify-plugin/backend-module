<template>
    <div class="form-group col-sm-12">
        <label>{{ addLabel }}</label>
        <div>
            <button type="button" data-toggle="modal" ref="productSearchBtn"
                    :data-target="dataTarget"
                    @click="getModal()"
                    class="btn btn-primary float-left mr-3">
                Search
            </button>
            <span class="float-left  mr-3 mt-2">or Enter {{
                    calledFrom === 'SKUS' ? 'Product SKU ID' : 'Product ID'
                }}:</span>
            <div class="btn-group">
                <input @keydown.enter.prevent="getProducts(search_by_product_id, calledFrom)" type="text"
                       :readonly="smallLoader"
                       name="search_by_product_id" class="form-control float-left no-box-shadow"
                       v-model="search_by_product_id"
                       style="width: fit-content">
                <button class="btn btn-default btn-sm no-box-shadow"
                        type="button"
                        @click="getProducts(search_by_product_id, calledFrom)">
                    <span v-if="smallLoader" class="text-center">
                        <i class="spinner-border spinner-border-sm"
                           role="status"
                           aria-hidden="true">
                        </i>
                        <span class="sr-only">Loading...</span>
                    </span>
                    <span v-else>{{ buttonName }}</span>
                </button>
            </div>

            <span class="ml-2" v-if="!['dataTransformationTestScreen', 'megaMenuScreen'].includes(calledFrom)">
                <input  id="return_skus" type="checkbox" v-model="$parent.$parent.returnSKUS">
                <label for="return_skus" class="form-check-label font-weight-normal">Return SKUS </label>
            </span>
        </div>
    </div>
</template>

<script>
export default {
    name : "Bottom",
    props: {
        calledFrom : {
            default: null,
        },
        getModal   : {
            default: null,
        },
        getProducts: {
            default: null,
        },
        dataTarget : {
            default: "#addProductModal"
        },
        buttonName : {
            default: "Add"
        },
    },

    data() {
        return {
            search_by_product_id: null,
            addLabel            : "Add Products To Bundle",
            smallLoader         : false,
        }
    },

    methods: {
        resetSearchByProductId() {
            return this.search_by_product_id = null;
        },
        initialSetup() {
            if (this.calledFrom === 'categoryModule') {
                this.addLabel = 'Add Products To Category'
            } else if (this.calledFrom === 'productModule') {
                this.addLabel = this.module === 'products' ? 'Add Products To Bundle' : 'Add Products';

            } else if (this.calledFrom === 'SKUS') {
                this.addLabel = 'Add SKU Product'
            } else if (this.calledFrom === 'productClassificationModule') {
                this.addLabel = 'Add Products To Product Classification'
            } else if (['dataTransformationTestScreen', 'megaMenuScreen'].includes(this.calledFrom)) {
                this.addLabel = 'Search Product'
            }
        }
    },

    mounted() {
        this.initialSetup();
    },

    watch: {
        search_by_product_id: function (newVal, oldVal) {
            if (newVal !== oldVal) {
                this.$parent.search_by_product_id = newVal;
            }
        }
    },
}
</script>

<style scoped>

</style>
