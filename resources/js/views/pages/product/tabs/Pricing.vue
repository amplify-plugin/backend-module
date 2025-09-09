<template>
    <div role="tabpanel" class="tab-pane active"
         id="tab_pricing">

        <div class="row">
            <!-- load the view from type and view_namespace attribute if set -->

            <!-- hidden input -->
            <div class="hidden">
                <input type="hidden" name="pricing" value="" class="form-control">
            </div>    <!-- load the view from type and view_namespace attribute if set -->

            <!-- number input -->
            <div class="form-group col-sm-12"><label :class="{'text-danger': $parent.validationErrors.selling_price}">Selling Price</label>
                <input type="number"
                       name="price"
                       v-model="$parent.productData.selling_price"
                       min="0"
                       step="any"
                       class="form-control"
                       placeholder="Enter selling price"
                       @keypress.enter.prevent
                       @input="validateDiscount($parent.productData.selling_price, 'selling_price')"
                       :class="{'is-invalid': $parent.validationErrors.selling_price}">
                <small v-if="$parent.validationErrors.selling_price"
                       class="text-danger mt-3">{{ $parent.validationErrors.selling_price[0] }}</small>
            </div>
            <!-- load the view from type and view_namespace attribute if set -->
            <!-- number input -->
            <div class="form-group col-sm-12"><label
                :class="{'text-danger': $parent.validationErrors.msrp}">MSRP</label>
                <input type="number"
                       name="msrp"
                       v-model="$parent.productData.msrp"
                       class="form-control"
                       min="0"
                       step="any"
                       placeholder="Enter MSRP"
                       @keypress.enter.prevent
                       @input="validateDiscount($parent.productData.msrp, 'msrp')"
                       :class="{'is-invalid': $parent.validationErrors.msrp}">
                <small v-if="$parent.validationErrors.msrp"
                       class="text-danger mt-3">{{ $parent.validationErrors.msrp[0] }}</small>
            </div>    <!-- load the view from type and view_namespace attribute if set -->
            <div class="form-group col-lg-12">
                <label>Group Pricing</label>
                <div class="card">
                    <div class="card-body">
                        <div v-if="$parent.customer_group_price_list.length">
                            <div v-for="(group, index) in $parent.customer_group_price_list" class="form-group my-3">
                                <div class="form-row">
                                    <label class="col-4 my-auto">{{ group.group_name }}</label>
                                    <div class="col-1 my-auto">:</div>
                                    <input type="number" class="form-control col-7" min="0" placeholder="Enter group pricing"
                                        @keypress.enter.prevent
                                        @input="validateDiscount($parent.customer_group_price_list[index].price, 'group_price', index)"
                                        v-model="$parent.customer_group_price_list[index].price">
                                </div>
                            </div>
                        </div>
                        <div v-else>
                            <div class="alert alert-warning mb-0">
                                No Customer Group Found for Price per Products
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "Pricing",
    data() {
        return {}
    },
    mounted() {
        this.$parent.getDynamicCurrentPreviousTabIds();
    },
    methods: {
        validateDiscount(price, field_name, index = null) {
            if (parseFloat(price) < 0) {
                new Noty({
                    type: "warning",
                    text: 'Price cannot be negative',
                }).show();
                event.preventDefault();

                switch (field_name) {
                    case 'selling_price':
                        this.$parent.productData.selling_price = this.$parent.productData.selling_price.substring(1);
                        break;
                    case 'msrp':
                        this.$parent.productData.msrp = this.$parent.productData.msrp.substring(1);
                        break;
                    case 'group_price':
                        this.$parent.customer_group_price_list[index].price = this.$parent.customer_group_price_list[index].price.substring(1);
                        break;
                }
            }
        },
    }
}
</script>

<style scoped>
.card-header {
    background: aliceblue;
}
</style>
