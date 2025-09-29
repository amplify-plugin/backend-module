<template>
    <div role="tabpanel" class="tab-pane active" id="tab_extra-data">
        <div class="hidden">
            <input type="hidden" name="extra-data" value="" class="form-control" />
        </div>
        <div class="row">
            <div class="col-md-6 form-group">
                <label :class="{ 'text-danger': $parent.validationErrors.min_order_qty }">Min. Order Qty</label>
                <input type="number" v-model="$parent.productData.min_order_qty" min="0" step="1" class="form-control"
                    placeholder="Enter Min. Order Qty"
                    :class="{ 'is-invalid': $parent.validationErrors.min_order_qty }" />
                <small v-if="$parent.validationErrors.min_order_qty" class="text-danger mt-3">{{
                    $parent.validationErrors.min_order_qty[0]
                    }}</small>
            </div>
            <div class="form-group col-md-6">
                <label :class="{ 'text-danger': $parent.validationErrors.qty_interval }">Qty Interval</label>
                <input type="number" v-model="$parent.productData.qty_interval" min="0" step="1" class="form-control"
                    placeholder="Enter Qty Interval" :class="{ 'is-invalid': $parent.validationErrors.qty_interval }" />
                <small v-if="$parent.validationErrors.qty_interval" class="text-danger mt-3">{{
                    $parent.validationErrors.qty_interval[0]
                    }}</small>
            </div>
            <div class="form-group col-md-12">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" v-model="$parent.productData.own_truck_only"
                        id="own_truck_only" :class="{ 'is-invalid': $parent.validationErrors.own_truck_only }" />
                    <label class="form-check-label" for="own_truck_only">
                        Shipped by own truck only
                    </label>
                </div>
                <small v-if="$parent.validationErrors.own_truck_only" class="text-danger mt-3">
                    {{ $parent.validationErrors.own_truck_only[0] }}</small>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-4">
                <label :class="{ 'text-danger': $parent.validationErrors.availability }">Availability</label>
                <select v-model="$parent.flags.availability" class="form-control"
                    :class="{ 'is-invalid': $parent.validationErrors.availability }">
                    <option value="A">A - Actual Quantities (Displays actual quantities)</option>
                    <option value="I">I - Increment (Display increments, actual quantities, 25+, 50+, 100+, 500+)
                    </option>
                    <option value="R">R - Restrict to 25+ (Displays actual quantity up to 25, if we have more, it will
                        display 25+)</option>
                    <option value="S">S - Special Order (Display actual qty if > 0, otherwise display “Special Order”.
                        We only order if we get an order.)</option>
                </select>
                <small v-if="$parent.validationErrors.availability" class="text-danger mt-3">{{ $parent.validationErrors.availability[0] }}</small>
            </div>
            <div class="form-group col-md-4">
                <label :class="{ 'text-danger': $parent.validationErrors.price }">Price</label>
                <select v-model="$parent.flags.price" class="form-control"
                    :class="{ 'is-invalid': $parent.validationErrors.price }">
                    <option value="D">D - Display Price</option>
                    <option value="Y">Y - Display Call For Price</option>
                </select>
                <small v-if="$parent.validationErrors.price" class="text-danger mt-3">{{ $parent.validationErrors.price[0] }}</small>
            </div>
            <div class="form-group col-md-4">
                <label :class="{ 'text-danger': $parent.validationErrors.special }">Special</label>
                <select v-model="$parent.flags.special" class="form-control"
                    :class="{ 'is-invalid': $parent.validationErrors.special }">
                    <option value="B">B - Discontinued</option>
                    <option value="C">C - Closeout</option>
                    <option value="F">F - Flyer Items</option>
                    <option value="M">M - Made in USA</option>
                    <option value="N">N - New Products</option>
                    <option value="O">O - Overstock Items</option>
                    <option value="U">U - Used Equipment</option>
                    <option value="Z">Z - Nothing</option>
                </select>
                <small v-if="$parent.validationErrors.special" class="text-danger mt-3">{{ $parent.validationErrors.special[0] }}</small>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-md-6">
                <label :class="{ 'text-danger': $parent.validationErrors.ship_restriction }">Shipping
                    Restriction</label>
                <input type="text" v-model="$parent.flags.ship_restriction" class="form-control"
                    placeholder="Enter Shipping Restriction"
                    :class="{ 'is-invalid': $parent.validationErrors.ship_restriction }" />
                <small v-if="$parent.validationErrors.ship_restriction" class="text-danger mt-3">{{ $parent.validationErrors.ship_restriction[0] }}</small>
            </div>
        </div>

    </div>
</template>

<script>
export default {
    name: 'ExtraData',
};
</script>
