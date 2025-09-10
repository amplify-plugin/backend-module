<template>
    <section
        class="checkout checkout-step"
        :class="[`checkout-${stepId}`, { active: isActive }]"
        :data-parent="`#${stepId}`"
    >
        <h4>Review Your Order</h4>
        <!-- <hr class="padding-bottom-1x"> -->
        <div class="row">
            <div class="col-xl-9 col-lg-8 col-md-12">
                <div class="table-responsive shopping-cart">
                    <table class="table table-hover table-sm" id="checkout-cart">
                        <thead>
                            <tr>
                                <th class="align-content-around" scope="col">Product</th>
                                <th class="align-content-around text-center" scope="col">Qty</th>
                                <th class="align-content-around text-center" scope="col">Price</th>
                                <th class="align-content-around text-center" scope="col">Subtotal</th>
                                <th class="align-content-around" scope="col"></th>
                            </tr>
                        </thead>
                        <tbody id="checkout-cart-item">
                            <tr
                                v-for="(product, index) in products"
                                :key="index"
                                v-if="product.source_type === 'custom_item'"
                            >
                                <td data-label="Product" style="vertical-align: middle">
                                    <div
                                        class="product-thumb d-flex gap-1 justify-content-end justify-content-md-start"
                                    >
                                        <a :href="product.url" class="product-thumbnail">
                                            <img
                                                :src="product.product_image"
                                                class="img-fluid"
                                                style="width: 128px; height: 90px; object-fit: contain"
                                                alt=""
                                            />
                                        </a>
                                        <div class="product-info pl-2">
                                            <p class="badge bg-info text-uppercase m-0">Custom Item</p>
                                            <h4 class="product-title" v-html="product.product_name"></h4>
                                            <p class="mb-0"><b>Product Code: </b>{{ product.product_code }}</p>
                                            <p class="mb-0"><b>Warehouse: </b>{{ product.warehouse_name }}</p>
                                            <br />
                                            <p class="text-danger font-italic">{{ product.note }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td
                                    data-label="Quantity"
                                    class="text-right font-weight-bold"
                                    style="vertical-align: middle"
                                >
                                    {{ product.custom_item_info.uom_qty ?? 1 }}
                                </td>

                                <td
                                    data-label="Quantity"
                                    class="text-right font-weight-bold"
                                    style="vertical-align: middle"
                                >
                                    {{
                                        priceFormatter(
                                            product.custom_item_info?.total_price / product.custom_item_info.uom_qty,
                                        ) +
                                        '/' +
                                        product.custom_item_info?.uom
                                    }}
                                </td>

                                <td
                                    data-label="Subtotal"
                                    class="text-right font-weight-bold"
                                    style="vertical-align: middle"
                                >
                                    {{ priceFormatter(product.custom_item_info?.total_price) }}
                                </td>
                            </tr>

                            <tr
                                v-for="(product, index) in products"
                                :key="index"
                                v-if="product.source_type !== 'custom_item'"
                            >
                                <td data-label="Product" style="vertical-align: middle">
                                    <div
                                        class="product-thumb d-flex gap-1 justify-content-end justify-content-md-start"
                                    >
                                        <a :href="product.url" class="product-thumbnail">
                                            <div
                                                v-if="product.source"
                                                :id="`product-badge-${index}`"
                                                class="product-badge badge-sm mt-2 ml-2"
                                                :class="getBadgeType(product.source_type)"
                                                data-toggle="tooltip"
                                                :title="product.source_type"
                                                style="font-size: 0.65rem; padding: 0 6px; text-transform: uppercase"
                                            >
                                                {{
                                                    product.source_type === 'CUSTOM_ITEM'
                                                        ? 'CUSTOM ITEM'
                                                        : product.source
                                                }}
                                            </div>

                                            <img
                                                :src="product.product_image"
                                                class="img-fluid"
                                                style="width: 128px; height: 90px; object-fit: contain"
                                                alt=""
                                            />
                                        </a>
                                        <div class="product-info">
                                            <h4 class="product-title" v-html="product.product_name"></h4>
                                            <p class="mb-0"><b>Product Code: </b>{{ product.product_code }}</p>
                                            <p class="mb-0"><b>Warehouse: </b>{{ product.warehouse_name }}</p>
                                            <br />
                                            <p class="text-danger font-italic">{{ product.note }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td
                                    data-label="Quantity"
                                    class="text-right font-weight-bold"
                                    style="vertical-align: middle"
                                >
                                    {{ product.qty }}
                                </td>
                                <td
                                    data-label="Quantity"
                                    class="text-right font-weight-bold"
                                    style="vertical-align: middle"
                                >
                                    {{ priceFormatter(product.price) + '/' + product.uom }}
                                </td>
                                <td
                                    data-label="Subtotal"
                                    class="text-right font-weight-bold"
                                    style="vertical-align: middle"
                                >
                                    {{ priceFormatter(product.subtotal) }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="shopping-cart-footer">
                    <div class="column"></div>
                    <div class="column text-lg">
                        Subtotal: <span class="text-medium">{{ sub_total }}</span>
                    </div>
                </div>

                <div class="form-group mt-3">
                    <label for="poNumber" class="font-weight-bold">PO Number
                        <span class="text-danger font-weight-bold">*</span>
                    </label>
                    <input
                        type="text"
                        id="poNumber"
                        class="form-control"
                        v-model="$parent.checkout_payload.po_number"
                        placeholder="Enter your PO number"
                    />
                </div>

                <div class="form-group mt-3">
                    <label for="orderNotes" class="font-weight-bold">Order Notes</label>
                    <textarea
                        id="orderNotes"
                        class="form-control"
                        rows="3"
                        v-model="$parent.checkout_payload.notes"
                        placeholder="Write any order-related notes here..."
                    ></textarea>
                </div>

                <div class="form-group mt-3">
                    <label for="internalComments" class="font-weight-bold">Internal Comments</label>
                    <textarea
                        id="internalComments"
                        class="form-control"
                        rows="3"
                        v-model="$parent.checkout_payload.internal_notes"
                        placeholder="Add any internal comments (for office use)..."
                    ></textarea>
                </div>

            </div>
            <!-- Sidebar          -->
            <div class="col-xl-3 col-lg-4 col-md-12">
                <aside class="sidebar">
                    <div class="padding-top-2x hidden-lg-up"></div>
                    <!-- Order Summary Widget-->
                    <section class="widget widget-order-summary p-2">
                        <h3 class="widget-title">Order Summary</h3>
                        <table class="table">
                            <tr>
                                <td>Cart Subtotal:</td>
                                <td class="text-medium">{{ sub_total }}</td>
                            </tr>
                            <tr v-if="Number(methods.SalesTaxAmount) > 0">
                                <td>Taxes:</td>
                                <td class="text-medium">{{ priceFormatter(methods.SalesTaxAmount) }}</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td class="text-lg text-medium">{{ calculateTotal }}</td>
                            </tr>
                        </table>
                    </section>

                    <section class="widget widget-shipping-info p-2 mt-3">
                        <h5 class="widget-title">Billing to:</h5>
                        <ul class="list-unstyled mb-0">
                            <li><span class="text-muted">Client:</span> {{ getName }}</li>
                            <li><span class="text-muted">Address:</span> {{ getBillingAddress }}</li>
                        </ul>
                    </section>

                     <section class="widget widget-shipping-info p-2 mt-3">
                        <h5 class="widget-title">Shipping to:</h5>
                        <ul class="list-unstyled mb-0">
                            <li><span class="text-muted">Address:</span> {{ getShippingAddress }}</li>
                            <li><span class="text-muted">Phone:</span> {{ this.$parent.shipping_checkout.shipping_phone }}</li>
                        </ul>
                    </section>

                </aside>
            </div>
        </div>

         <div class="alert alert-danger mt-2" role="alert" v-if="$parent.validationError">
                {{ $parent.validationError }}
        </div>
    </section>
</template>

<script>
import { mapState, mapGetters } from 'vuex';

export default {
    name: 'Review',
    props: ['isActive', 'stepId'],
    data() {
        return {
            cart: {},
            products: [],
            termsAccepted: false,
        };
    },
    computed: {
        ...mapState('checkout', ['methods']),
        sub_total() {
            return this.priceFormatter(this.cart.total_price);
        },
        total_products() {
            return this.products.reduce((totalQty, product) => totalQty + product.qty, 0);
        },
        calculateTotal() {
            let taxAmount = this.methods.SalesTaxAmount;
            return this.priceFormatter(Number(this.cart.total_price)  + Number(taxAmount));
        },
        getName() {
            return this.$parent.checkout_payload?.customer_name;
        },
        getShippingAddress() {
            const shipping = this.$parent.shipping_checkout;
            return this.formatAddress(shipping);
        },
        getBillingAddress() {
            const billing = this.$parent.checkout_payload;
            return this.formatAddress(billing);
        }


    },
    async mounted() {
        await this.fetchCartItems();
    },
    methods: {
        async fetchCartItems() {
            this.cart = await fetch('/get/carts')
                .then((res) => res.json())
                .then((res) => res.data);
            this.products = this.cart.products;
            this.$parent.checkout_payload.sub_total = this.cart.total_price;
        },
        priceFormatter(price) {
            return new Intl.NumberFormat('en-US', {
                style: 'currency',
                currency: AMPLIFY_BASE_CURRENCY,
            }).format(parseFloat(price) ?? 0);
        },
        getBadgeType(source_type) {
            let badgeType = 'text-primary';

            switch (source_type) {
                case 'PROMO':
                    badgeType = 'text-danger';
                    break;
                case 'QUOTE':
                    badgeType = 'text-info';
                    break;
                case 'source_type':
                    badgeType = 'text-success';
                    break;
            }

            return badgeType;
        },

        formatAddress(data) {
            let parts = [
                data?.customer_address_one ?? data?.ship_to_address1,
                data?.customer_address_two ?? data?.ship_to_address2,
                data?.customer_address_three ?? data?.ship_to_address3,
                data?.customer_city ?? data?.ship_to_city,
                data?.customer_state?.name ?? data?.ship_to_state?.name,
                data?.customer_zip_code ?? data?.ship_to_zip_code,
                data?.customer_country?.name ?? data?.ship_to_country?.name
            ].filter(Boolean);
            return parts.join(', ');
        },
    },
};
</script>

<style scoped>
.shipping-sm {
    display: none;
}

@media (min-width: 320px) and (max-width: 767px) {
    .shipping-sm {
        display: block !important;
        margin: 0 12px;
    }

    .shopping-cart-footer > .column:last-child {
        text-align: end;
    }

    .shipping-lg {
        display: none !important;
    }

    .widget-title {
        color: #374250;
    }

    table#checkout-cart {
        border: 0;
    }

    table#checkout-cart thead {
        border: none;
        clip: rect(0 0 0 0);
        height: 1px;
        margin: -1px;
        overflow: hidden;
        padding: 0;
        position: absolute;
        width: 1px;
    }

    table#checkout-cart tr {
        border-top: 1px solid #ddd;
        border-left: 1px solid #ddd;
        border-right: 1px solid #ddd;
        border-bottom: 3px solid #ddd;
        border-radius: 0.3rem;
        display: block;
        margin-bottom: 0.625em;
    }

    table#checkout-cart td {
        border-bottom: 1px solid #ddd;
        display: block;
        font-size: 0.8em;
        text-align: right;
        padding: 8px;
    }

    table#checkout-cart td::before {
        content: attr(data-label);
        float: left;
        font-weight: bold;
        text-transform: uppercase;
    }

    table#checkout-cart td:last-child {
        border-bottom: 0;
    }
}
</style>
