<template>
    <div class="table-responsive shopping-cart">
        <table class="table">
            <thead>
                <tr>
                    <th>Product Code</th>
                    <th>Name</th>
                    <th class="text-center">UOM</th>
                    <th class="text-center">Qty</th>
                    <th class="text-center">Ship to</th>
                    <th class="text-center">Unit Price</th>
                    <th class="text-center">Total</th>
                    <th class="text-center">
                        <a class="btn btn-sm btn-outline-danger" href="#" @click="removeAllIteams">Clear Cart</a>
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(item, key) in $parent.cartItems.products" :key="key">
                    <td class="text-center text-lg text-medium">{{ item.product_code }}</td>
                    <td>
                        <div class="product-item">
                            <a class="product-thumb" :href="item.url">
                                <img :src="item.product_image" alt="Product">
                            </a>
                            <div class="product-info">
                                <h4 class="product-title"><a :href="item.url">{{ item.product_name }}</a></h4>
                            </div>
                        </div>
                    </td>
                    <td class="text-center text-lg text-medium">Pack</td>
                    <td class="text-center">
                        <div class="count-input">
                            <input type="number" min="1" class="form-control" v-model="item.qty" />
                        </div>
                    </td>
                    <td class="text-center">
                        <div class="count-input">
                            <select class="form-control">
                                <option>1</option>
                                <option>2</option>
                            </select>
                        </div>
                    </td>
                    <td class="text-center text-lg text-medium">${{ item.price }}</td>
                    <td class="text-center text-lg text-medium">${{ item|TotalPrice }}</td>
                    <td class="text-center">
                        <a class="remove-from-cart" href="#" data-toggle="tooltip" title="Remove item" @click="removeIteam(key)">
                            <i class="icon-cross"></i>
                        </a>
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="shopping-cart-footer">
            <div class="column text-lg">Subtotal: <span class="text-medium">${{ SubTotalPrice }}</span></div>
        </div>
    </div>
</template>
<script>
import Index from '../../pages/product/tabs/Index.vue'
    export default {
  components: { Index },
        name: "CartTable",
        methods: {
            removeIteam(index) {
                this.$parent.cartItems.products.splice(index, 1);
            },
            removeAllIteams(index) {
                this.$parent.cartItems.products = [];
            }
        },
        computed: {
            SubTotalPrice() {
                this.$parent.cartItems.total_price = 0;
                for (const item of this.$parent.cartItems.products) {
                    this.$parent.cartItems.total_price += parseFloat(item.qty)*parseFloat(item.price);
                }

                return this.$parent.cartItems.total_price.toFixed(2);
            }
        },
        filters: {
            TotalPrice(product) {
                return (parseFloat(product.qty)*parseFloat(product.price)).toFixed(2);
            }
        }
    }
</script>
<style>
</style>
