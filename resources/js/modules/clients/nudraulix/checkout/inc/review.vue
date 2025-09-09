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
                                            <h4 class="product-title">{{ product.product_name }}</h4>
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
                                            <h4 class="product-title">{{ product.product_name }}</h4>
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
                <div class="row padding-top-1x mt-3 shipping-lg">
                    <div class="col-sm-6">
                        <h5>Shipping to:</h5>
                        <ul class="list-unstyled">
                            <li><span class="text-muted">Client:</span> {{ getName }}</li>
                            <li><span class="text-muted">Address:</span> {{ getCustomerAddress }}</li>
                            <li><span class="text-muted">Phone:</span> {{ this.$parent.getCustomerAddress.phone }}</li>
                        </ul>
                    </div>
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
                            <tr>
                                <td>Shipping:</td>
                                <td class="text-medium">$ {{ $parent.shippingMethod?.amount }}</td>
                            </tr>
                            <tr>
                                <td>Estimated tax:</td>
                                <td class="text-medium">$ {{ methods.SalesTaxAmount }}</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td class="text-lg text-medium">{{ calculateTotal }}</td>
                            </tr>
                        </table>
                    </section>
                </aside>
            </div>
            <div class="col-md-12 shipping-sm">
                <h5>Shipping to:</h5>
                <ul class="list-unstyled">
                    <li><span class="text-muted">Client:</span> {{ getName }}</li>
                    <li><span class="text-muted">Address:</span> {{ getCustomerAddress }}</li>
                    <li><span class="text-muted">Phone:</span> {{ this.$parent.getCustomerAddress.phone }}</li>
                </ul>
            </div>
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
            let shippingAmount = this.$parent.shippingMethod?.amount ?? 0;
            let taxAmount = this.methods.SalesTaxAmount;
            return this.priceFormatter(Number(this.cart.total_price) + Number(shippingAmount) + Number(taxAmount));
        },
        getName() {
            return this.$parent.checkout_payload?.customer_name;
        },
        getCustomerAddress() {
            let addressOne =
                this.$parent.getCustomerAddress.addressOne != null
                    ? `${this.$parent.getCustomerAddress.addressOne}, `
                    : '';
            let addressTwo =
                this.$parent.getCustomerAddress.addressTwo != null
                    ? `${this.$parent.getCustomerAddress.addressTwo},`
                    : '';
            let addressThree =
                this.$parent.getCustomerAddress.addressThree != null
                    ? `${this.$parent.getCustomerAddress.addressThree},`
                    : '';
            let country =
                this.$parent.getCustomerAddress.country != null
                    ? `${this.$parent.getCustomerAddress.country?.name}`
                    : '';
            let state =
                this.$parent.getCustomerAddress.state != null ? `${this.$parent.getCustomerAddress.state?.name},` : '';
            let zipCode =
                this.$parent.getCustomerAddress.zipCode != null ? `${this.$parent.getCustomerAddress.zipCode},` : '';
            let phone = this.$parent.getCustomerAddress.phone != null ? `${this.$parent.getCustomerAddress.phone}` : '';
            return `${addressOne} ${addressTwo} ${addressThree} ${state} ${zipCode} ${country}`;
        },
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
        },
        priceFormatter(price) {
            return new Intl.NumberFormat('en-US', {
                style: 'currency',
                currency: 'USD',
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
