<template>
    <div class="shopping-cart-footer">
        <div class="column">
            <a class="btn btn-outline-secondary" href="shop-grid-ls.html"><i class="icon-arrow-left"></i>&nbsp;Back to Shopping</a>
        </div>
        <div class="column">
            <a class="btn btn-primary" href="#" data-toast data-toast-type="success"
                data-toast-position="topRight" data-toast-icon="icon-circle-check" data-toast-title="Your cart"
                data-toast-message="is updated successfully!">Update Cart</a><a class="btn btn-success"
                href="checkout-address.html">
                Checkout
            </a>
        </div>
    </div>
</template>
<script>
    export default {
        name: "CartFooter"
    }
</script>
<style>
</style>
