<template>
    <section
        class="checkout checkout-step"
        :class="[`checkout-${stepId}`, { active: isActive }]"
        :data-parent="`#${stepId}`"
    >
        <h4><i class="icon-bag"></i> Shipping Method</h4>
        <hr class="padding-bottom-1x" />
        <div>
            <ShippingTab />
            <div class="tab-content" id="nav-tabContent" v-if="Object.keys(shippingMethods).length > 0">
                <div
                    class="tab-pane fade"
                    :class="[showProducts === key ? 'active show' : 'hide']"
                    :id="`nav-home-${stringToSlug(key)}`"
                    role="tabpanel"
                    aria-labelledby="nav-home-tab"
                    v-for="(methods, key) in shippingMethods"
                    :key="key"
                >
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="thead-default">
                                <tr>
                                    <th></th>
                                    <th>Shipping method</th>
                                    <th v-if="key !== 'WILL CALL'">Delivery time</th>
                                    <th>Handling fee</th>
                                </tr>
                            </thead>
                            <tbody v-for="(items, itemKey) in methods" :key="itemKey">
                                <tr v-for="(data, methodkey) in items" :key="methodkey" @click="selectMethod(data)">
                                    <td class="align-middle">
                                        <div class="custom-control custom-radio mb-0">
                                            <input
                                                class="custom-control-input shipping_Input_field"
                                                required
                                                type="radio"
                                                :value="data"
                                                v-model="$parent.shippingMethod"
                                                name="shipping-method"
                                            />
                                            <label class="custom-control-label"></label>
                                        </div>
                                    </td>
                                    <td class="align-middle">
                                        <span class="text-medium">{{ methodkey }}</span
                                        ><br /><span class="text-muted text-sm">{{ data.date }}</span>
                                    </td>
                                    <td v-if="key !== 'WILL CALL'" class="align-middle">{{ data.fullday }}</td>
                                    <td class="align-middle">${{ data.amount }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
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
import ShippingTab from './shipping-tab.vue';
import MethodNotFound from './method-not-found.vue';

export default {
    name: 'Shipping',

    props: ['isActive', 'stepId'],
    components: { Multiselect, ShippingTab, MethodNotFound },

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
        showProducts() {
            for (const [key, items] of Object.entries(this.shippingMethods)) {
                return key;
            }
        },
    },
    methods: {
        changeTab(id) {
            let ele = document.querySelector(`#nav-${this.stringToSlug(id)}`);
            let ele_home = document.querySelector(`#nav-home-${this.stringToSlug(id)}`);
            let tab_pane = document.querySelectorAll('.tab-pane');
            let nav_link = document.querySelectorAll('.nav-link');

            tab_pane.forEach(function (tabPane) {
                tabPane.classList.remove('active');
                tabPane.classList.remove('show');
            });

            nav_link.forEach(function (tabPane) {
                tabPane.classList.remove('active');
            });

            ele.classList.add('active');
            ele_home.classList.add('active');
            ele_home.classList.add('show');
            this.$parent.shippingVia = id;
            this.$parent.shippingMethod = '';
        },
        selectMethod(data) {
            this.$parent.shippingMethod = data;
        },
        stringToSlug(str) {
            return str
                .toLowerCase()
                .trim()
                .replace(/[\s\W-]+/g, '-') // Replace spaces and non-word characters with a single hyphen
                .replace(/^-+|-+$/g, ''); // Remove leading and trailing hyphens
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
