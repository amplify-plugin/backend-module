<template>
    <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
            <button
                class="nav-link mr-2"
                :class="[showProducts === key ? 'active' : '']"
                :id="`nav-${$parent.stringToSlug(key)}`"
                data-bs-toggle="tab"
                data-bs-target="#nav-home"
                type="button"
                role="tab"
                aria-controls="nav-home"
                aria-selected="true"
                v-for="(data, key) in shippingMethods"
                :key="key"
                @click="$parent.changeTab(key)"
            >
                {{ key }}
            </button>
        </div>
    </nav>
</template>
<script>
import { mapState, mapGetters } from 'vuex';

export default {
    name: 'Shipping_Tab',
    mounted() {
        this.$parent.$parent.shippingVia = this.shippingMethodVia;
    },
    computed: {
        ...mapState('checkout', ['products']),
        ...mapGetters('checkout', ['shippingMethodVia', 'shippingMethods']),
        showProducts() {
            for (const [key, items] of Object.entries(this.shippingMethods)) {
                return key;
            }
        },
    },
};
</script>
