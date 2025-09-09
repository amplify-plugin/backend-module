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
                    <div class="table-scroll-wrapper">
                        <table class="table table-hover">
                            <thead class="thead-default">
                                <tr>
                                    <th></th>
                                    <th>Shipping method</th>
                                    <!-- <th v-if="key !== 'WILL CALL'">Delivery time</th>
                                    <th v-if="key === 'WILL CALL'">Address</th>
                                    <th>Handling fee</th> -->
                                </tr>
                            </thead>
                            <tbody v-for="(items, itemKey) in methods" :key="itemKey">
                                <tr v-for="(data, methodkey) in items" :key="methodkey" @click="selectMethod(data)" :ref="'row-' + methodkey">
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
                                        <span v-if="data.frttermscd === 'CPU'">{{ data.address1 }}</span>
                                        <span v-else>{{ data.name || data.shipvia }}</span>
                                    </td>
                                    <!-- <td v-if="key !== 'WILL CALL'" class="align-middle">{{ data.fullday }}</td>
                                    <td v-if="key === 'WILL CALL'" class="align-middle">{{ data.address1 ?? '' }} {{data.address2 ?? '' }} {{data.zip ?? '' }}</td>
                                    <td class="align-middle">${{ data.amount }}</td> -->
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Freight Collect Account Number Input -->
                    <div v-if="key?.toString().trim().toLowerCase() === 'freight collect'" class="form-group mt-3">
                        <label for="freight-account-number">Freight Account Number <span class="text-danger font-weight-bold">*</span></label>
                        <input
                            type="text"
                            class="form-control"
                            id="freight-account-number"
                            placeholder="Enter your freight account number"
                            v-model="$parent.checkout_payload.freight_account_number"
                            :required="$parent.shippingVia === 'FREIGHT COLLECT'"
                        />
                    </div>

                </div>
            </div>
            <!-- <div v-else class="text-center">
                <MethodNotFound />
            </div> -->
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
    watch: {
        shippingMethods: {
            handler(val) {
                if (val && Object.keys(val).length > 0) {
                    this.preselectShippingByShipToType();
                }
            },
            immediate: true, // triggers immediately on component load
            deep: true
        }
    },
    methods: {
        preselectShippingByShipToType() {
            const shipToType = this.$parent.shipping_checkout?.ship_to_carrier_code.trim()?.toLowerCase();
            if (!shipToType) return;

            for (const shippingOptionKey of Object.keys(this.shippingMethods)) {
                const methods = this.shippingMethods[shippingOptionKey];

                for (const methodObj of methods) {
                    const methodKey = Object.keys(methodObj)[0];
                    const method = methodObj[methodKey];

                    const methodType = method.shipvia?.trim()?.toLowerCase();
                    if (methodType === shipToType) {
                        // Preselect matched method
                        this.$parent.shippingVia = shippingOptionKey;
                        this.$parent.shippingMethod = method;

                        // Handle freight account number ONLY for 'freight collect'
                        if (
                            'account_number' in method &&
                            method.account_number.trim() !== ''
                        ) {
                            this.$parent.checkout_payload.freight_account_number = method.account_number.trim();
                        } else {
                            this.$parent.checkout_payload.freight_account_number = ''; // Clear or skip
                        }

                        this.$nextTick(() => {
                            this.changeTab(shippingOptionKey);
                            const refName = 'row-' + methodKey;
                            const row = this.$refs[refName];
                            if (row && row[0] && row[0].scrollIntoView) {
                                row[0].scrollIntoView({ behavior: 'smooth', block: 'center' });
                            }
                        });

                        return; // Stop after selecting first match
                    }
                }
            }
        },

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

            if(id.toLowerCase() === 'freight collect') {
                const shipToType = this.$parent.shipping_checkout?.ship_to_carrier_code.trim()?.toLowerCase();
                if (!shipToType) return;

                const freightMethods = this.shippingMethods['Freight Collect'] || [];
                for (const option of freightMethods) {
                    for (const key in option) {
                        if (option[key].shipvia?.trim()?.toLowerCase() === shipToType) {
                            this.$parent.shippingMethod = option[key];
                            return;
                        }
                    }
                }
            }
            if (id.toLowerCase() === 'customer pick up') {
                const pickupMethods = this.shippingMethods['Customer Pick Up'] || [];
                const key = Object.keys(pickupMethods[0])[0];
                this.$parent.shippingMethod = pickupMethods[0][key];
            }
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

.table-scroll-wrapper {
    max-height: 300px; /* adjust height as needed */
    overflow-y: auto;
    overflow-x: hidden;
    border: 1px solid #eaeaea;
    border-radius: 5px;
}

@keyframes l3 {
    to {
        transform: rotate(1turn);
    }
}
</style>
