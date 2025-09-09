<template>
    <div>
        <div v-if="cartItems && cartItems.products.length>0">
            <cart-customer-details></cart-customer-details>
            <cart-table></cart-table>
            <cart-footer></cart-footer>
        </div>
        <div v-else>
            <div class="card">
                <div class="collapse show" role="tabpanel">
                    <div class="card-body text-center">
                        <p>No Product Found</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import CartCustomerDetails from './CartCustomerDetails.vue';
    import CartTable from './CartTable.vue';
    import CartFooter from './CartFooter.vue';
    export default {
        name: "CartPage",
        components: {CartTable, CartFooter, CartCustomerDetails},
        data() {
            return {
                cartItems: JSON.parse(getCookie('cart_items'))
            }
        },
        watch: {
            cartItems: {
                handler(items) {
                    if (items.products.length>0) setCookie('cart_items', JSON.stringify(items), 10000);
                    else removeCookie('cart_items');

                    renderCartItems();
                },
                deep: true
            }
        }
    }
</script>
<style>
</style>
