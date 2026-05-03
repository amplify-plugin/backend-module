<template>
    <div role="tabpanel" class="tab-pane active" id="tab_basic-info">
        <fieldset>
            <div class="d-flex justify-content-between border-bottom pb-0 mb-3 mt-n3">
                <legend>
                    <i class="la la-globe mr-2"></i>
                    Frontend Settings
                </legend>
                <div class="d-md-none custom-sidebar-ar" @click="$parent.toggleSidebar()">
                    <div class="menu-icon-ar">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="24"
                            height="24"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="#1b2a4e"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            class="feather feather-menu"
                        >
                            <line x1="3" y1="12" x2="21" y2="12"></line>
                            <line x1="3" y1="6" x2="21" y2="6"></line>
                            <line x1="3" y1="18" x2="21" y2="18"></line>
                        </svg>
                    </div>
                    <div class="close-icon-ar">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="24"
                            height="24"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="red"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            class="feather feather-x"
                        >
                            <line x1="18" y1="6" x2="6" y2="18"></line>
                            <line x1="6" y1="6" x2="18" y2="18"></line>
                        </svg>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group" :class="{ 'text-danger': $parent.validationErrors.shop_page_default_view }">
                        <label> Shop Page Default View </label>
                        <select
                            name="shop_page_default_view"
                            class="form-control"
                            v-model="coreConfigurationData.shop_page_default_view"
                            :class="{ 'is-invalid': $parent.validationErrors.shop_page_default_view }"
                        >
                            <option value="grid">Grid View</option>
                            <option value="list">List View</option>
                        </select>
                        <small v-if="$parent.validationErrors.shop_page_default_view" class="text-danger mt-3">{{
                            $parent.validationErrors.shop_page_default_view[0]
                        }}</small>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group" :class="{ 'text-danger': $parent.validationErrors.product_type }">
                        <label>Single Product Index</label>
                        <select
                            name="easyask_single_product_index"
                            class="form-control"
                            v-model="coreConfigurationData.easyask_single_product_index"
                            :class="{ 'is-invalid': $parent.validationErrors.easyask_single_product_index }"
                        >
                            <option
                                :value="product_index.code"
                                v-for="(product_index, index) in $parent.productIndexes"
                                :key="index"
                                :selected="
                                    product_index.code == coreConfigurationData.easyask_single_product_index
                                        ? true
                                        : false
                                "
                            >
                                {{ product_index.name }}
                            </option>
                        </select>
                        <small v-if="$parent.validationErrors.easyask_single_product_index" class="text-danger mt-3">{{
                            $parent.validationErrors.easyask_single_product_index[0]
                        }}</small>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="product_available_text">Product Available Text</label>
                        <input
                            type="text"
                            id="product_available_text"
                            name="product_available_text"
                            class="form-control"
                            v-model="coreConfigurationData.product_available_text"
                        />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="product_not_available_text">Product Not Available Text</label>
                        <input
                            type="text"
                            id="product_not_available_text"
                            name="product_not_available_text"
                            class="form-control"
                            v-model="coreConfigurationData.product_not_available_text"
                        />
                    </div>
                </div>
            </div>
            <div class="form-group custom-control custom-checkbox pl-0">
                <input
                    type="checkbox"
                    name="enable_language_changer"
                    id="enable_language_changer"
                    v-model="coreConfigurationData.enable_language"
                    :class="{ 'is-invalid': $parent.validationErrors.enable_language }"
                />
                <label for="enable_language_changer">Enable Language Switcher</label>
                <small v-if="$parent.validationErrors.enable_language" class="text-danger mt-3">
                    {{ $parent.validationErrors.enable_language[0] }}
                </small>
            </div>
            <div class="form-group custom-control custom-checkbox pl-0">
                <input
                    type="checkbox"
                    name="enable_exchange_reward"
                    id="enable_exchange_reward"
                    v-model="coreConfigurationData.enable_exchange_reward"
                    :class="{ 'is-invalid': $parent.validationErrors.enable_exchange_reward }"
                />
                <label for="enable_exchange_reward">Enable Exchange Reward Options Into Header</label>
                <small v-if="$parent.validationErrors.enable_exchange_reward" class="text-danger mt-3">
                    {{ $parent.validationErrors.enable_exchange_reward[0] }}
                </small>
            </div>

            <div class="form-group custom-control custom-checkbox pl-0">
                <input
                    type="checkbox"
                    name="right_sidebar"
                    id="right_sidebar"
                    v-model="coreConfigurationData.right_sidebar"
                    :class="{ 'is-invalid': $parent.validationErrors.right_sidebar }"
                />
                <label for="right_sidebar">Use Right Side Panel Globally</label>
                <small v-if="$parent.validationErrors.right_sidebar" class="text-danger mt-3">
                    {{ $parent.validationErrors.right_sidebar[0] }}
                </small>
            </div>

            <div class="form-group custom-control custom-checkbox pl-0">
                <input
                    type="checkbox"
                    name="redirect_to_product_detail_page_on_search"
                    id="redirect_to_product_detail_page_on_search"
                    v-model="coreConfigurationData.redirect_to_product_detail_page_on_search"
                    :class="{ 'is-invalid': $parent.validationErrors.redirect_to_product_detail_page_on_search }"
                />
                <label for="redirect_to_product_detail_page_on_search">Redirect to Product Details Page if Search Return 1 Product for Searching by Product Code</label>
                <small v-if="$parent.validationErrors.redirect_to_product_detail_page_on_search" class="text-danger mt-3">
                    {{ $parent.validationErrors.redirect_to_product_detail_page_on_search[0] }}
                </small>
            </div>

            <div class="form-group custom-control custom-checkbox pl-0">
                <input
                    type="checkbox"
                    name="show_parent_product_for_sku"
                    id="show_parent_product_for_sku"
                    v-model="coreConfigurationData.show_parent_product_for_sku"
                    :class="{ 'is-invalid': $parent.validationErrors.show_parent_product_for_sku }"
                />
                <label for="show_parent_product_for_sku">Redirect to SKU product to master product</label>
                <small v-if="$parent.validationErrors.show_parent_product_for_sku" class="text-danger mt-3">
                    {{ $parent.validationErrors.show_parent_product_for_sku[0] }}
                </small>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label> Exchange Reward Client Token </label>
                        <input
                            type="text"
                            name="enable_exchange_reward_client_token"
                            class="form-control"
                            v-model="coreConfigurationData.exchange_reward_client_token"
                        />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label> Exchange Reward Secret </label>
                        <input
                            type="text"
                            name="enable_exchange_reward_client_secret"
                            class="form-control"
                            v-model="coreConfigurationData.exchange_reward_secret"
                        />
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <div>
                            <label>Guest Customer ID</label>
                            <input
                                type="text"
                                name="guest_default"
                                placeholder="Enter Guest Customer ID"
                                v-model="coreConfigurationData.guest_default"
                                class="form-control"
                                :class="{ 'is-invalid': $parent.validationErrors.guest_default }"
                            />
                            <small v-if="$parent.validationErrors.guest_default" class="text-danger mt-3">{{
                                $parent.validationErrors.guest_default[0]
                            }}</small>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label>Guest Checkout Warehouse</label>
                        <input
                            type="text"
                            name="guest_checkout_warehouse"
                            class="form-control"
                            v-model="coreConfigurationData.guest_checkout_warehouse"
                        />
                        <small v-if="$parent.validationErrors.guest_checkout_warehouse" class="text-danger mt-3">
                            {{ $parent.validationErrors.guest_checkout_warehouse[0] }}
                        </small>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group custom-control custom-checkbox pl-0 mt-md-5">
                        <input
                            type="checkbox"
                            name="guest_checkout"
                            id="guest_checkout"
                            :class="{ 'is-invalid': $parent.validationErrors.guest_checkout }"
                            v-model="coreConfigurationData.guest_checkout"
                        />
                        <label for="guest_checkout">Enable Guest Checkout</label>
                        <small v-if="$parent.validationErrors.guest_checkout" class="text-danger mt-3">
                            {{ $parent.validationErrors.guest_checkout[0] }}
                        </small>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group custom-control custom-checkbox pl-0 mt-md-5">
                        <input
                            type="checkbox"
                            name="guest_add_to_cart"
                            id="guest_add_to_cart"
                            :class="{ 'is-invalid': $parent.validationErrors.guest_add_to_cart }"
                            v-model="coreConfigurationData.guest_add_to_cart"
                        />
                        <label for="guest_add_to_cart">Enable Guest Add To Cart</label>
                        <small v-if="$parent.validationErrors.guest_add_to_cart" class="text-danger mt-3">
                            {{ $parent.validationErrors.guest_add_to_cart[0] }}
                        </small>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <div>
                            <label>Force Select Shipping Address Customer Code</label>
                            <input
                                type="text"
                                name="force_shipping_address_customer_id"
                                placeholder="Enter Force Select Shipping Address Customer Code"
                                v-model="coreConfigurationData.force_shipping_address_customer_id"
                                class="form-control"
                                :class="{ 'is-invalid': $parent.validationErrors.force_shipping_address_customer_id }"
                            />
                            <small v-if="$parent.validationErrors.force_shipping_address_customer_id" class="text-danger mt-3">{{
                                    $parent.validationErrors.force_shipping_address_customer_id[0]
                                }}</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group" :class="{ 'text-danger': $parent.validationErrors.mega_menu_max_height }">
                        <label> Mega Menu Maximum Height </label>
                        <input
                            type="text"
                            name="mobile_menu"
                            class="form-control"
                            v-model="coreConfigurationData.mega_menu_max_height"
                            :class="{ 'is-invalid': $parent.validationErrors.mega_menu_max_height }"
                        />
                        <small class="text-muted">Default Height calculation unit is pixel(px)</small>
                        <small v-if="$parent.validationErrors.mega_menu_max_height" class="text-danger mt-3">{{
                                $parent.validationErrors.mega_menu_max_height[0]
                            }}</small>
                    </div>
                </div>
            </div>
        </fieldset>
        <fieldset class="mt-3">
            <legend>
                <i class="la la-arrows mr-2"></i>
                Navigation
            </legend>
            <!--            <div class="form-group" :class="{ 'text-danger': $parent.validationErrors.mobile_screen_menu }">-->
            <!--                <label>-->
            <!--                    Navigation Header Layout-->
            <!--                </label>-->
            <!--                <select name="mobile_menu" class="form-control"-->
            <!--                        v-model="coreConfigurationData.mobile_screen_menu"-->
            <!--                        :class="{ 'is-invalid': $parent.validationErrors.mobile_screen_menu }">-->
            <!--                    <option v-for="(menu, index) in $parent.menuGroupOptions"-->
            <!--                            :key="index"-->
            <!--                            :selected="menu.short_code == coreConfigurationData.mobile_screen_menu"-->
            <!--                            :value="menu.short_code">-->
            <!--                        {{ menu.name }}-->
            <!--                    </option>-->
            <!--                </select>-->
            <!--                <small v-if="$parent.validationErrors.mobile_screen_menu" class="text-danger mt-3">{{-->
            <!--                        $parent.validationErrors.mobile_screen_menu[0]-->
            <!--                    }}</small>-->
            <!--            </div>-->
            <div class="form-group" :class="{ 'text-danger': $parent.validationErrors.mobile_screen_menu }">
                <label> Mobile Screen Menu </label>
                <select
                    name="mobile_menu"
                    class="form-control"
                    v-model="coreConfigurationData.mobile_screen_menu"
                    :class="{ 'is-invalid': $parent.validationErrors.mobile_screen_menu }"
                >
                    <option
                        v-for="(menu, index) in $parent.menuGroupOptions"
                        :key="index"
                        :selected="menu.short_code == coreConfigurationData.mobile_screen_menu"
                        :value="menu.short_code"
                    >
                        {{ menu.name }}
                    </option>
                </select>
                <small v-if="$parent.validationErrors.mobile_screen_menu" class="text-danger mt-3">{{
                    $parent.validationErrors.mobile_screen_menu[0]
                }}</small>
            </div>
            <div class="form-group" :class="{ 'text-danger': $parent.validationErrors.user_account_top_menu }">
                <label> User Account Top Menu </label>
                <select
                    name="mobile_menu"
                    class="form-control"
                    v-model="coreConfigurationData.user_account_top_menu"
                    :class="{ 'is-invalid': $parent.validationErrors.user_account_top_menu }"
                >
                    <option
                        v-for="(menu, index) in $parent.menuGroupOptions"
                        :key="index"
                        :selected="menu.short_code == coreConfigurationData.user_account_top_menu"
                        :value="menu.short_code"
                    >
                        {{ menu.name }}
                    </option>
                </select>
                <small v-if="$parent.validationErrors.user_account_top_menu" class="text-danger mt-3">{{
                    $parent.validationErrors.user_account_top_menu[0]
                }}</small>
            </div>
            <div class="form-group" :class="{ 'text-danger': $parent.validationErrors.user_account_sidebar_menu }">
                <label> User Account Sidebar Menu </label>
                <select
                    name="mobile_menu"
                    class="form-control"
                    v-model="coreConfigurationData.user_account_sidebar_menu"
                    :class="{ 'is-invalid': $parent.validationErrors.user_account_sidebar_menu }"
                >
                    <option
                        v-for="(menu, index) in $parent.menuGroupOptions"
                        :key="index"
                        :selected="menu.short_code == coreConfigurationData.user_account_sidebar_menu"
                        :value="menu.short_code"
                    >
                        {{ menu.name }}
                    </option>
                </select>
                <small v-if="$parent.validationErrors.user_account_sidebar_menu" class="text-danger mt-3">{{
                    $parent.validationErrors.user_account_sidebar_menu[0]
                }}</small>
            </div>
            <div class="form-group" :class="{ 'text-danger': $parent.validationErrors.site_primary_menu }">
                <label> Site Main Menu </label>
                <select
                    name="mobile_menu"
                    class="form-control"
                    v-model="coreConfigurationData.site_primary_menu"
                    :class="{ 'is-invalid': $parent.validationErrors.site_primary_menu }"
                >
                    <option
                        v-for="(menu, index) in $parent.menuGroupOptions"
                        :key="index"
                        :selected="menu.short_code == coreConfigurationData.site_primary_menu"
                        :value="menu.short_code"
                    >
                        {{ menu.name }}
                    </option>
                </select>
                <small v-if="$parent.validationErrors.site_primary_menu" class="text-danger mt-3">{{
                    $parent.validationErrors.site_primary_menu[0]
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
    name: 'Frontend',
    data() {
        return {
            pageData: [],
            coreConfigurationData: {
                tab: 'frontend',
            },
        };
    },

    mounted() {
        this.coreConfigurationData = this.$parent.coreConfigurationData.frontend;
        this.coreConfigurationData.tab = 'frontend';
    },
};
</script>
