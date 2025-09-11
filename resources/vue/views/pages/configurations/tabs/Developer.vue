<template>
    <div role="tabpanel" class="tab-pane active" id="tab_basic-info">
        <fieldset>
            <div class="d-flex justify-content-between border-bottom pb-0 mb-3 mt-n3">
                <legend>
                    <i class="la la-hand-holding-usd mr-2"></i>
                    Order Configuration
                </legend>
                <div class="d-md-none custom-sidebar-ar" @click="$parent.toggleSidebar()">
                    <div class="menu-icon-ar">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                             stroke="#1b2a4e" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                             class="feather feather-menu">
                            <line x1="3" y1="12" x2="21" y2="12"></line>
                            <line x1="3" y1="6" x2="21" y2="6"></line>
                            <line x1="3" y1="18" x2="21" y2="18"></line>
                        </svg>
                    </div>
                    <div class="close-icon-ar">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                             stroke="red" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                             class="feather feather-x">
                            <line x1="18" y1="6" x2="6" y2="18"></line>
                            <line x1="6" y1="6" x2="18" y2="18"></line>
                        </svg>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <input type="checkbox" name="order_rule_check"
                       id="order_rule_check"
                       v-model="coreConfigurationData.order_rule_check"
                       :class="{ 'is-invalid': $parent.validationErrors.order_rule_check }">
                <label for="order_rule_check">Enable Order Rule Check</label>
                <small v-if="$parent.validationErrors.order_rule_check" class="text-danger mt-3">{{
                        $parent.validationErrors.order_rule_check[0]
                    }}</small>
            </div>
            <div class="form-group">
                <input type="checkbox" name="send_email_to_create_order_from_quote"
                       id="send_email_to_create_order_from_quote"
                       v-model="coreConfigurationData.send_email_to_create_order_from_quote"
                       :class="{ 'is-invalid': $parent.validationErrors.send_email_to_create_order_from_quote }">
                <label for="send_email_to_create_order_from_quote">Send Email to Create Order from Quote</label>
                <small v-if="$parent.validationErrors.send_email_to_create_order_from_quote" class="text-danger mt-3">{{
                        $parent.validationErrors.send_email_to_create_order_from_quote[0]
                    }}</small>
            </div>
            <div class="form-group">
                <input type="checkbox" name="use_pickup_enable_warehouses_as_shipping_methods"
                       id="use_pickup_enable_warehouses_as_shipping_methods"
                       v-model="coreConfigurationData.use_pickup_enable_warehouses_as_shipping_methods"
                       :class="{ 'is-invalid': $parent.validationErrors.use_pickup_enable_warehouses_as_shipping_methods }">
                <label for="use_pickup_enable_warehouses_as_shipping_methods">Use Pickup Enable Warehouses as Shipping Methods</label>
                <small v-if="$parent.validationErrors.use_pickup_enable_warehouses_as_shipping_methods" class="text-danger mt-3">{{
                        $parent.validationErrors.use_pickup_enable_warehouses_as_shipping_methods[0]
                    }}</small>
            </div>
        </fieldset>

        <div id="saveActions" class="form-group">
            <button @click="$parent.saveCoreConfigInfo(coreConfigurationData)" type="button" class="btn btn-success">
                <span class="la la-save" role="presentation" aria-hidden="true"></span> &nbsp;
                <span data-value="save_and_edit"> Save</span>
            </button>

            <button @click="$parent.saveAndAction()" type="button" class="btn btn-default">
                <span class="la la-ban"></span> Cancel
            </button>
        </div>
    </div>
</template>

<script>

export default {
    name: "Order",
    data() {
        return {
            coreConfigurationData: {
                tab: "order",
                order_rule_check: this.$parent.coreConfigurationData.order.order_rule_check ?? false,
                send_email_to_create_order_from_quote: this.$parent.coreConfigurationData.order.send_email_to_create_order_from_quote ?? false,
                use_pickup_enable_warehouses_as_shipping_methods: this.$parent.coreConfigurationData.order.use_pickup_enable_warehouses_as_shipping_methods ?? false
            }
        }
    },
}
</script>
