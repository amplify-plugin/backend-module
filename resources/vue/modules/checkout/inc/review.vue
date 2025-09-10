<template>
    <section
        class="checkout checkout-step"
        :class="[`checkout-${stepId}`, { active: isActive }]"
        :data-parent="`#${stepId}`"
    >
        <h4>Review Your Order</h4>
        <hr class="padding-bottom-1x" />
        <div class="row">
            <div class="col-sm-12">
                <div class="form-group">
                    <label for="order_reference"
                        >PO Number
                        <span v-if="$parent.customerData.PoRequired == 'Y'" class="text-danger font-weight-bold"
                            >*</span
                        >
                    </label>
                    <input
                        :required="$parent.customerData.PoRequired == 'Y'"
                        class="form-control"
                        type="text"
                        id="order_reference"
                        name="order_reference"
                        v-model="$parent.checkout_payload.po_number"
                    />
                    <div class="invalid-feedback"></div>
                    <small v-if="$parent.validationErrors.customer_order_ref" class="text-danger mt-3"
                        >A purchase order number is required to complete the order.</small
                    >
                </div>
            </div>
            <div class="col-sm-12">
                <div class="form-group">
                    <label for="order_reference">Notes</label>
                    <textarea
                        class="form-control"
                        id="note"
                        name="note"
                        rows="3"
                        v-model="$parent.checkout_payload.notes"
                    ></textarea>
                    <span class="invalid-feedback"></span>
                </div>
            </div>
        </div>
        <h4>Cart Items</h4>
        <hr class="padding-bottom-1x" />
        <div class="shopping-cart table-responsive mb-0">
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
                    <tr v-for="(product, index) in products" :key="index">
                        <td data-label="Product" style="vertical-align: middle">
                            <div class="product-thumb d-flex gap-1 justify-content-end justify-content-md-start">
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
                                        {{ product.source_type === 'CUSTOM_ITEM' ? 'CUSTOM ITEM' : product.source }}
                                    </div>

                                    <img
                                        :src="product.product_image"
                                        class="img-fluid"
                                        :alt="product.product_name"
                                        style="width: 128px; height: 90px; object-fit: contain"
                                    />
                                </a>
                                <div class="product-info">
                                    <h4 class="product-title">{{ product.product_name }}</h4>
                                    <p class="mb-0"><b>Product Code: </b>{{ product.product_code }}</p>
                                    <p class="text-danger font-italic">{{ product.note }}</p>
                                </div>
                            </div>
                        </td>
                        <td data-label="Quantity" class="text-right font-weight-bold" style="vertical-align: middle">
                            {{ product.qty }}
                        </td>
                        <td data-label="Quantity" class="text-right font-weight-bold" style="vertical-align: middle">
                            {{ priceFormatter(product.price) + '/' + product.uom }}
                        </td>
                        <td data-label="Subtotal" class="text-right font-weight-bold" style="vertical-align: middle">
                            {{ priceFormatter(product.subtotal) }}
                        </td>
                        <td data-label="Action" class="text-center font-weight-bold" style="vertical-align: middle">
                            <button type="button" @click="$parent.goToCart" class="btn btn-sm btn-outline-info"><i class="icon-edit"></i> Edit</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="shopping-cart-footer">
            <div class="column text-lg">
                Total: <span class="text-medium">{{ total_products }}</span> item(s)
            </div>
            <div class="column text-lg">
                Subtotal: <span class="text-medium">{{ sub_total }}</span>
            </div>
        </div>
    </section>
</template>

<script>
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
        sub_total() {
            return this.priceFormatter(this.cart.total_price);
        },
        total_products() {
            return this.products.reduce((totalQty, product) => totalQty + product.qty, 0);
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
                currency: AMPLIFY_BASE_CURRENCY,
            }).format(parseFloat(price ?? 0));
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
                case 'CUSTOM_ITEM':
                    badgeType = 'text-success';
                    break;
            }

            return badgeType;
        },
    },
};
</script>

<style scoped>
@media screen and (max-width: 600px) {
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
        /*
                * aria-label has no advantage, it won't be read inside a table
                content: attr(aria-label);
                */
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
