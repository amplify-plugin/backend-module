<template>
    <div
        :class="orderStep === 4 ? 'order-step-block' : 'order-step-d-none'"
        v-if="checkPrice && productSide !== ''"
        class="row mb-4 mb-sm-5 position-relative"
    >
        <div class="col-12" id="gaskets_five">
            <div class="title mb-3 d-flex align-items-center gap-2">
                <i
                    :class="[$parent.completedSection.includes(5) ? 'text-success' : 'text-black-50']"
                    class="icon-circle-check"
                ></i>
                <h5
                    class="mb-0 text-uppercase fw-600"
                    :class="[$parent.completedSection.includes(5) ? 'text-success' : 'text-danger ']"
                >
                    Step 5
                </h5>
            </div>
            <h6 class="mb-4">Provide Outside Dimensions (Height AND Width)</h6>
            <div class="mb-4 border p-4 p-lg-5 rounded-md">
                <div class="product-image position-relative">
                    <img
                        class="w-410px h-100"
                        v-if="productSide === '3'"
                        src="./images/step-5/CustomGasket-3Sided-DIMs.png"
                        alt="Gasket Dimensions"
                    />
                    <img
                        class="w-410px h-100"
                        v-if="productSide === '4'"
                        src="./images/step-5/CustomGasket-4Sided-DIMs.png"
                        alt="Gasket Dimensions"
                    />
                    <div
                        v-for="(value, index) in stepFiveProductGasketModal"
                        :key="index"
                        data-toggle="tooltip"
                        data-placement="top"
                        :title="getModalTitle(index)"
                        @click="handleStepOne(index)"
                        :class="depth_fract[index] ? `${index} bg-success` : `${index} bg-danger`"
                        class="position-absolute input-box make-cursor-pointer"
                    >
                        {{ depth_fract[index] }}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="border rounded-md p-3">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="fw-500 text-uppercase">TOTAL LENGTH IN FEET</div>
                            <input
                                :disabled="true"
                                type="text"
                                :value="totalFeet"
                                placeholder="0"
                                class="form-control w-90"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <PopoverComponent
            :stepOne="$parent.stepFiveProductGasketModal"
            :step="$parent.step"
            :closeModel="$parent.closeModel"
            :confirmModel="$parent.confirmModel"
            v-if="$parent.showModal"
        />
    </div>
</template>
<script>
import { mapGetters, mapState } from 'vuex';
import PopoverComponent from './components/popover.vue';
import { checkPrice } from '../../../../store/gasket/getters';
export default {
    name: 'step-5',
    props: ['orderStep', 'stepFourProductGasketProfile', 'stepOneValue', 'stepFiveProductGasketModal', 'handleStepOne'],
    components: {
        PopoverComponent,
    },
    methods: {
        checkPrice,
        getModalTitle(configType) {
            switch (configType) {
                case 'input-one':
                    return 'Width';
                case 'input-two':
                    return 'Height';
                default:
                    break;
            }
        },
    },
    computed: {
        ...mapGetters('gasket', ['depth_fract', 'totalFeet', 'checkPrice']),
        ...mapState('gasket', ['productSide']),
    },
    onMounted() {
        document.querySelector('[data-toggle="tooltip"]').tooltip();
    },
};
</script>

<style scoped>
    .w-410px {
        width: 410px;
    }
</style>
