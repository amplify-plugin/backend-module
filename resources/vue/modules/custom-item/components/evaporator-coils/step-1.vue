<template>
    <div>
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
                        <img class="w-100 h-100" src="../../images/evaporator-coils/custom-coil.png" alt="" />
                        <div v-for="(value, index) in stepOne" :key="index"
                             data-toggle="tooltip"
                             data-placement="top"
                             :title="getModalTitle(index)"
                             @click="$parent.handleStepOne(index)"
                            :class="[
                                index,
                                { 'bg-danger': isGetValue(index) == false },
                                { 'bg-success': isGetValue(index) == true },
                            ]"
                             class="position-absolute input-box make-cursor-pointer"
                        >
                            {{
                                index == 'input-one'
                                    ? measurement.measurement_one_display
                                    : index == 'input-two'
                                        ? measurement.measurement_two_display
                                        : index == 'input-three'
                                            ? measurement.measurement_three_display
                                            : index == 'input-four'
                                                ? measurement.measurement_four_display
                                                : index == 'input-five'
                                                    ? measurement.measurement_five_display
                                                    : index == 'input-six'
                                                        ? measurement.measurement_six_display
                                                        : index == 'input-seven'
                                                            ? measurement.measurement_seven_display
                                                            : '0'
                            }}
                            <span class="error-custom-position" :class="[
                                { 'text-danger': isGetValue(index) == false },
                                { 'text-success': isGetValue(index) == true },
                            ]" v-html="inputFieldText(index)">

                            </span>
                        </div>

        <PopoverComponent :stepOne="$parent.stepOne" :step="$parent.step" :closeModel="$parent.closeModel" :confirmModel="$parent.confirmModel"
            v-if="$parent.showModal" />
                    </div>
                </div>
                <div>
                    <small class="text-danger text-uppercase fw-500 d-block mb-3">Required Field</small>
                    <h6 class="mb-2">Must be filled out to continue to Step two</h6>
                    <small>FINNED LENGTH, FINNED HEIGHT, FINNED WIDTH</small>
                </div>
            </div>
        </div>
        <div>
            <small class="text-danger text-uppercase fw-500 d-block mb-3">Required Field</small>
            <h6 class="mb-2">Must be filled out to continue to Step 2.</h6>
            <small>FINNED LENGTH, FINNED HEIGHT, FINNED WIDTH</small>
        </div>
    </div>
</template>
<script>
import { mapState, mapGetters } from 'vuex';
import PopoverComponent from './inc/popover.vue';
export default {
    name: 'step-one',
    props: ['orderStep', 'stepOneValue', 'handleStepOne', 'stepOne'],
    components:{PopoverComponent},
    methods: {
        isGetValue(index) {
            if (this.measurement.measurement_one_display != 0 && index == 'input-one') {
                return true;
            }

            if (this.measurement.measurement_two_display != 0 && index == 'input-two') {
                return true;
            }

            if (this.measurement.measurement_three_display != 0 && index == 'input-three') {
                return true;
            }

            if (this.measurement.measurement_four_display != 0 && index == 'input-four') {
                return true;
            }

            if (this.measurement.measurement_five_display != 0 && index == 'input-five') {
                return true;
            }
            if (this.measurement.measurement_six_display != 0 && index == 'input-six') {
                return true;
            }
            if (this.measurement.measurement_seven_display != 0 && index == 'input-seven') {
                return true;
            }
            return false;
        },
        requiredField(index) {
            return ['input-one', 'input-three', 'input-five'].includes(index);
        },
        inputFieldText(index) {
            if (index == 'input-one') {
                return '<p class="header_text">(A)</p><p class="field_text">FINNED WIDTH</p>';
            }
            if (index == 'input-three') {
                return '<p class="header_text">(B)</p><p class="field_text">FINNED HEIGHT</p>';
            }
            if (index == 'input-five') {
                return '<p class="header_text">(C)</p><p class="field_text">FINNED LENGTH</p>';
            }

            if (index == 'input-seven') {
                return '<p class="field_text">CASING WIDTH</p>';
            }

            if (index == 'input-six') {
                return '<p class="field_text">CASING HEIGHT</p>';
            }

            if (index == 'input-four') {
                return '<p class="field_text">FRONT FLANGE LENGTH</p>';
            }

            if (index == 'input-two') {
                return '<p class="field_text">BACK FLANGE LENGTH</p>';
            }
        },
        getModalTitle(configType) {
            switch (configType) {
                case "input-one":
                    return "FINNED WIDTH"
                case "input-two":
                    return "BACK FLANGE LENGTH"
                case "input-three":
                    return "FINNED HEIGHT"
                case "input-four":
                    return "FRONT FLANGE LENGTH"
                case "input-five":
                    return "FINNED LENGTH"
                case "input-six":
                    return "CASING HEIGHT"
                case "input-seven":
                    return "CASING WIDTH"
                default:
                    break;
            }
        }
    },
    computed: {
        ...mapState({
            measurement: (state) => state.evaporatorCoils.measurement,
        }),
    },
    onMounted(){
        document.querySelector('[data-toggle="tooltip"]').tooltip();
    }
};
</script>
<style>
.error-custom-position {
    top: -35px;
    position: absolute;
    left: 0;
    text-align: center;
    width: 100%;
    font-weight: bold;
    font-size: 8px;
}

.header_text {
    line-height: 0px;
    margin: 0px;
    padding: 0px;
}

.input-three .error-custom-position {
    top: 48px;
}

.input-seven .error-custom-position {
    top: 30px;
}

.input-six .error-custom-position {
    top: 30px;
    left: 0px;
}
.input-four .error-custom-position{
    top: -30px;
    line-height: 12px;
}
.input-two .error-custom-position{
    top: -30px;
    line-height: 12px;
}

@media (max-width: 991px) {
    .error-custom-position {
        top: -25px;
        font-size: 12px;
        text-align: center;
    }
}

@media (max-width: 768px) {
    .error-custom-position {
        top: -23px;
        font-size: 10px;
        text-align: center;
    }
    .input-five .error-custom-position{
        top: 125%;
    }
    .input-one .error-custom-position{
        top: -112%;
    }
    .input-three .error-custom-position{
        top: 108%;
    }
    .error-custom-position p{
        line-height: 121%;
        font-size: 8px;
    }
}
</style>
