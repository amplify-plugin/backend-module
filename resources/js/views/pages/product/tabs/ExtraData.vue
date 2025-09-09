<template>
    <div role="tabpanel" class="tab-pane active" id="tab_extra-data">
        <div class="hidden">
            <input type="hidden" name="extra-data" value="" class="form-control" />
        </div>
        <div class="form-group">
            <label :class="{ 'text-danger': $parent.validationErrors.min_order_qty }">Min. Order Qty</label>
            <input
                type="number"
                v-model="$parent.productData.min_order_qty"
                min="0"
                step="1"
                class="form-control"
                placeholder="Enter Min. Order Qty"
                :class="{ 'is-invalid': $parent.validationErrors.min_order_qty }"
            />
            <small v-if="$parent.validationErrors.min_order_qty" class="text-danger mt-3">{{
                $parent.validationErrors.min_order_qty[0]
            }}</small>
        </div>

        <div class="form-group">
            <label :class="{ 'text-danger': $parent.validationErrors.qty_interval }">Qty Interval</label>
            <input
                type="number"
                v-model="$parent.productData.qty_interval"
                min="0"
                step="1"
                class="form-control"
                placeholder="Enter Qty Interval"
                :class="{ 'is-invalid': $parent.validationErrors.qty_interval }"
            />
            <small v-if="$parent.validationErrors.qty_interval" class="text-danger mt-3">{{
                $parent.validationErrors.qty_interval[0]
            }}</small>
        </div>
        <div class="form-group">
            <div class="form-check">
                <input
                    class="form-check-input"
                    type="checkbox"
                    v-model="$parent.productData.own_truck_only"
                    id="own_truck_only"
                    :class="{ 'is-invalid': $parent.validationErrors.own_truck_only }"
                />
                <label class="form-check-label" for="own_truck_only">
                    Shipped by own truck only
                </label>
            </div>
            <small v-if="$parent.validationErrors.own_truck_only" class="text-danger mt-3">
                {{$parent.validationErrors.own_truck_only[0] }}</small>
        </div>
    </div>
</template>

<script>
export default {
    name: 'ExtraData',
};
</script>
