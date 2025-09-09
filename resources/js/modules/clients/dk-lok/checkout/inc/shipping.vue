<template>
    <section
        class="checkout checkout-step"
        :class="[`checkout-${stepId}`, { active: isActive }]"
        :data-parent="`#${stepId}`"
    >
        <h4><i class="icon-bag"></i> Shipping Method</h4>
        <hr class="padding-bottom-1x" />
        <div>
            <div v-if="Object.keys(shippingMethods).length > 0">
                <multiselect
                    name="Shipping Method"
                    id="shipping-method-select"
                    v-model="$parent.shippingMethod"
                    :options="flattenedMethods"
                    :allow-empty="false"
                    @select="selectMethod"
                    placeholder="Select a Shipping Method"
                    required
                    :custom-label="customLabel"
                    label="name"
                    track-by="shipvia"
                >
                </multiselect>
            </div>
            <div v-else class="text-center">
                <MethodNotFound />
            </div>
            <div class="alert alert-danger mt-2" role="alert" v-if="$parent.validationError">
                {{ $parent.validationError }}
            </div>
        </div>
    </section>
</template>

<script>
import Multiselect from 'vue-multiselect';
import { mapState, mapGetters } from 'vuex';
import MethodNotFound from './method-not-found.vue';

export default {
    name: 'Shipping',

    props: ['isActive', 'stepId'],
    components: { Multiselect, MethodNotFound },
    computed: {
        ...mapState('checkout', ['methods', 'loader']),
        ...mapGetters('checkout', ['shippingMethods']),
        states() {
            if (this.$parent.checkout_payload.ship_to_country) {
                return this.$parent.states.filter(
                    (item) => item.country_id === this.$parent.checkout_payload.ship_to_country.id,
                );
            }
            return [];
        },
        flattenedMethods() {
            return Object.values(this.shippingMethods).flatMap(methods => Object.values(methods).flat()).map(data => Object.values(data)[0]);
        },
    },
    watch: {
        shippingMethods: {
            handler(newVal) {
                if (newVal && Object.keys(newVal).length > 0 && this.$parent.customerData && this.$parent.customerData.CarrierCode) {
                    const carrierCode = this.$parent.customerData.CarrierCode;
                    const method = this.flattenedMethods.find(m => m.shipvia === carrierCode);
                    if (method && !this.$parent.shippingMethod) {
                        this.$parent.shippingMethod = method;
                    }
                }
            },
            deep: true,
            immediate: true
        }
    },
    methods: {
        selectMethod(data) {
            this.$parent.shippingMethod = data;
        },
        customLabel(option) {
            return `${option.shipvia} - ${option.name}`;
        },
    },
};
</script>
<style scoped>
.shipping_Input_field {
    z-index: 1000;
}

.loader {
    top: 50%;
    left: 50%;
    position: relative;
    width: 50px;
    margin: 6% 0;
    padding: 8px;
    aspect-ratio: 1;
    border-radius: 50%;
    background: #050505;
    --_m: conic-gradient(#0000 10%, #000), linear-gradient(#000 0 0) content-box;
    -webkit-mask: var(--_m);
    mask: var(--_m);
    -webkit-mask-composite: source-out;
    mask-composite: subtract;
    animation: l3 1s infinite linear;
}

@keyframes l3 {
    to {
        transform: rotate(1turn);
    }
}
</style>
