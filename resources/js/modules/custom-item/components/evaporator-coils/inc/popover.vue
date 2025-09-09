<template>
    <div class="input-popover popover fade show bs-popover-left" :class="`popover-${step}`" role="tooltip">
        <div class="arrow" style="top: 34px;"></div>
        <h3 class="popover-header text-warning">
            {{
        step == 'input-one' ? 'FINNED WIDTH (A)'
            : step == 'input-two' ? 'BACK FLANGE LENGTH (G)'
                : step == 'input-three' ? 'FINNED HEIGHT (B)'
                    : step == 'input-four' ? 'FRONT FLANG ELENGTH (F)'
                        : step == 'input-five' ? 'FINNED LENGTH (C)'
                            : step == 'input-six' ? 'CASING HEIGHT (E)'
                                : step == 'input-seven' ? 'CASING WIDTH (D)' : ''
    }}
        </h3>

        <div class="modal-body">
            <div class="border rounded-md d-flex align-items-center justify-content-between pr-3"
                :class="{ 'border border-warning': validationMsg }">
                <input
                    @keyup="getInputValue"
                    @keyup.enter="handleEnter"
                    @keydown.tab.prevent="handleEnter"
                    id="modalfocus"
                    ref="modalfocus"
                    type="text"
                    placeholder="0"
                    class="form-control w-100 shadow-none"
                    autocomplete="off"
                >
                <div>Inches</div>
            </div>
            <div class="d-flex justify-content-between d-md-block d-lg-none">
                <button type="button" class="btn btn-sm m-0 text-danger mt-2" @click="closeModel">Cancel</button>
                <button type="button" class="btn  bg-success btn-sm m-0 text-white mt-2" @click="closeModel">Confirm</button>
            </div>
            <small v-if="showText">Please type your measurement and press enter.</small>
            <small class="text-danger" v-if="validatorData.hasOwnProperty('error')">{{ validatorData.error }}</small>

            <div v-if="validationMsg" class="popover-body">Oops! It seems like you've entered an incorrect value. Please
                enter a valid number
                in the input field. <br /> Acceptable value is: <span class="text-success">
                    <ul>
                        <li>Integer Number ({{ currentStepValue(step).low }} to {{ currentStepValue(step).high }})</li>
                        <li>Decimal Number </li>
                        <li>Fraction Value With Hyphen. Example: 26-1/2</li>
                        <li>Fraction Value With Space. Example: 26 1/2</li>
                        <li>Acceptable Fraction Value is: <br> <small>
                                0/8, 1/8, 1/4, 3/8, 1/2, 5/8, 3/4, 7/8
                            </small></li>
                    </ul>
                </span></div>
        </div>
        <div class="ar-bg-shadow" @click="closeModel"></div>
    </div>

</template>
<script>
import { getStepValue, checkInputValue } from './helper'
import { mapActions, mapState } from 'vuex';
export default {
    name: 'CustomModal',
    data() {
        return {
            validationMsg: '',
            showText: false,
            validatorData: {},
            isValidated: false,
        }
    },
    props: ['range', 'fractional', 'step', 'closeModel', 'confirmModel'],
    methods: {
        handleEnter(event){
            let data = checkInputValue(event, this.step);
            if (!this.validated(data) && this.isValidated) {
                this.setMeasurement({
                    'val': data.val,
                    'step': this.step,
                    'dispaly': data.display
                });
                this.showText = true;
                this.validatorData = {}
                this.confirmModel();
                this.$refs['modalfocus'].value = '';
            }
        },
        getInputValue(event) {
            let step = this.step;
            let measurement = this.measurement;
            let depth = event.target.value
            this.isValidated = false;

            if (step === "input-seven" && measurement.measurement_one > depth) {
                this.validatorData = { 'error': 'The Casing Width value must be greater than or equal to the Finned Width value.' }
                this.showText = false
                this.resetMeasurement();
                return;
            }
            if (step === "input-one" && measurement.measurement_seven < depth && measurement.measurement_seven !== 0) {
                this.validatorData = { 'error': 'The Casing Width value must be greater than or equal to the Finned Width value.' }
                this.showText = false
                this.resetMeasurement();
                return;
            }


            if (step === "input-six" && measurement.measurement_three > depth) {
                this.validatorData = { 'error': 'The Casing Height value must be greater than or equal to the Finned Height value.' }
                this.showText = false
                this.resetMeasurement();
                return;
            }

            if (step === "input-three" && measurement.measurement_six < depth && measurement.measurement_six_display !== 0) {
                this.validatorData = { 'error': 'The Casing Height value must be greater than or equal to the Finned Height value.' }
                this.showText = false
                this.resetMeasurement();
                return;
            }

            let data = checkInputValue(event, this.step);
            if (this.validated(data)) {
                this.validationMsg = true;
                this.showText = false;
                this.validatorData = {}
                return;
            }

            this.isValidated = true;
        },
        resetMeasurement() {
            this.setMeasurement({
                'val': 0,
                'step': this.step,
                'dispaly': 0
            });
        },
        ...mapActions('evaporatorCoils', ['setMeasurement', 'getDisplayValue']),
        validated(val) {
            this.validationMsg = false
            if (typeof val != "undefined" && val.hasOwnProperty('error')) {
                this.validationMsg = true;
                return true;
            }
        },
        currentStepValue(step) {
            return getStepValue(step);
        },


    },
    computed: {
        ...mapState('evaporatorCoils', ['measurement']),
    }
}
</script>
<style scoped>
.form-control:focus {
    border: none;
}

.ar-bg-shadow {
    background: #00000050;
    width: 100vw;
    height: 100vh;
    top: 0;
    left: 0;
    position: fixed;
    z-index: -1;
}

.modal-body {
    background: #fff;
}

.form-control:focus {
    border: none;
}

/* Styles for the popover container */
.popover-input-one {
    left: -21% !important;
    top: 5% !important;
}

.popover-input-three {
    left: -34% !important;
    top: 39% !important;
}

.popover-input-five {
    left: -16% !important;
    top: 68% !important;
}

.popover-input-seven {
    left: 83.5% !important;
    top: 75.5% !important;
    width: 100%;
}

.popover-input-seven .arrow {
    left: -3%;
    transform: rotate(180deg);
}

.popover-input-six {
    left: 93% !important;
    top: 35% !important;
    width: 100%;
}

.popover-input-six .arrow {
    left: -3%;
    transform: rotate(180deg);
}

.popover-input-four {
    left: 80.5% !important;
    top: 22% !important;
    width: 100%;
}

.popover-input-four .arrow {
    left: -3%;
    transform: rotate(180deg);
}

.popover-input-two {
    left: 60% !important;
    top: 1% !important;
    width: 100%;
}

.popover-input-two .arrow {
    left: -3%;
    transform: rotate(180deg);
}

@media (max-width: 768px) {
    .popover {
        top: 120% !important;
        left: 1% !important;
        width: 100%;
    }
    .arrow {
        display: none;
    }
}
</style>
