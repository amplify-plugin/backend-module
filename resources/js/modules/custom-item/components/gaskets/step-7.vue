<template>
    <div :class="orderStep === 4 ? 'order-step-block' : 'order-step-d-none'"
        v-if="currentWidth < 576 || stepSixProductGasketProfile" class="row" id="gaskets_seven">
        <div class="col-md-6 mb-4">
            <div class="title mb-3 d-flex align-items-center gap-2">
                <i :class="[$parent.completedSection.includes(7) ? 'text-success' : 'text-black-50']"
                    class="icon-circle-check"></i>
                <h5 class="mb-0 text-uppercase fw-600"
                    :class="[$parent.completedSection.includes(7) ? 'text-success' : 'text-danger']">
                    Step 7
                </h5>
            </div>
            <div class="border rounded-md p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="fw-500 text-uppercase">QUANTITY:</div>
                    <input type="text" placeholder="0" v-model="quantity" @keyup="getQuantity" class="form-control w-110" />
                </div>
                <div class="d-flex align-items-center justify-content-between my-4">
                    <div class="fw-500 text-uppercase">TOTAL MATERIAL PER FOOT:</div>
                    <input type="text" placeholder="00" disabled :value="totalQty" class="form-control w-110" />
                </div>
                <div class="d-flex align-items-center justify-content-between">
                    <div class="fw-500 text-uppercase">TOTAL PRICES:</div>
                    <input :value="totalPrice" type="text" placeholder="00" class="form-control w-110" />
                </div>
            </div>

        </div>

        <!--SUBMIT BUTTON-->
        <div class="col-12">
            <button type="submit" @click="addToCart(swal)" class="d-none d-sm-block btn btn-primary"
                :disabled="!$parent.completedSection.includes(7)">
                Submit
            </button>
        </div>
    </div>
</template>
<script>
import { mapActions, mapState, mapGetters } from 'vuex';
export default {
    name: 'step-7',
    props: ['orderStep', 'currentWidth', 'stepSixProductGasketProfile', 'stepSevenProductGasketTotalPrice'],
    data() {
        return {
            swal: this.$swal,
            quantity:1,
        };
    },
    methods: {
        ...mapActions('gasket', ['getQuantity', 'addToCart']),
    },
    computed: {
        ...mapGetters('gasket', ['totalQty', 'totalPrice','totalFeet']),
        checkSubmit() {
            Number(this.totalPrice) > 0;
        },
    },
    watch: {
            totalFeet(newval, oldval) {
                this.quantity = 1;
                this.getQuantity(1);
            }
        }

};
</script>
