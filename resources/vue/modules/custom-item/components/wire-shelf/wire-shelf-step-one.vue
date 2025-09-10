<template>
    <div :class="orderStep === 1 ? 'order-step-block' : 'order-step-d-none'" class="row mb-4 mb-sm-5">
        <div class="col-12">
            <div class="title mb-3 d-flex align-items-center gap-2">
                <i :class="[$parent.completedSection.includes(1) ? 'text-success' : 'text-black-50']"
                    class="icon-circle-check"></i>
                <h5 class="mb-0 text-uppercase fw-600"
                    :class="[$parent.completedSection.includes(1) ? 'text-success' : 'text-danger']">
                    Step 1
                </h5>
            </div>
            <!-- Product One -->
            <div class="mb-4 border p-4 p-lg-5 rounded-md">
                <div class="product-image position-relative">
                    <img class="w-100 h-100" src="../../images/wire-shelf/product-2.png" alt="" />
                    <div v-for="(value, index) in stepOne" :key="index"
                         data-toggle="tooltip"
                         data-placement="top"
                         :title="getModalTitle(index)"
                         @click="$parent.handleStepOne(index)"
                        :class="depth_fract[index] ? `${index} bg-success` : `${index} bg-danger`"
                        class="position-absolute input-box make-cursor-pointer">
                        {{ depth_fract[index] }}

                        <span class="text-danger error-custom-position">Required</span>
                    </div>
                    <PopoverComponent :step="$parent.step" :range="$parent.range" :fractional="$parent.fractional" :closeModel="$parent.closeModel"
                    :confirmModel="$parent.confirmModel" v-if="$parent.showModal" />
                </div>
            </div>
            <div>
                <h6 class="text-uppercase">PLEASE NOTE THE DIRECTION OF THE MESH CROSS WIRES</h6>
            </div>
        </div>
    </div>
</template>
<script>
import { mapGetters } from 'vuex';
import PopoverComponent from './popover.vue';
export default {
    name: 'WireShelfStepOne',
    props: ['orderStep', 'stepOneValue', 'stepOne', 'handleStepOne'],
    components:{
        PopoverComponent
    },
    methods: {
        getModalTitle(configType) {
            switch (configType) {
                case "input-one":
                    return "Depth"
                case "input-two":
                    return "Width"
                default:
                    break;
            }
        }
    },
    computed: {
        ...mapGetters('shelving', ['depth_fract', 'firstStep']),
    },
    onMounted(){
        document.querySelector('[data-toggle="tooltip"]').tooltip();
    }
};
</script>
