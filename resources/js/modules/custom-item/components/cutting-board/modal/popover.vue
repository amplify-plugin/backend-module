<template>
    <div class="input-popover popover fade show bs-popover-left" :class="`popover-${step}`" role="tooltip">
        <div class="arrow" style="top: 34px;"></div>
        <h3 class="popover-header text-warning">Add Cutting Board {{ step == 'input-one' ? 'Length' : 'Width' }}</h3>
        <div class="modal-body">
            <div class="border rounded-md d-flex align-items-center justify-content-between pr-3"
                :class="{ 'border border-warning': validationMsg }">
                <input
                    @keyup="depth"
                    @keyup.enter="handleEnter"
                    @keydown.tab.prevent="handleEnter"
                    id="modalfocus"
                    ref="modalfocus"
                    type="text"
                    placeholder="0"
                    class="form-control w-100 shadow-none"
                />
                <div>Inches</div>
            </div>
            <div class="d-flex justify-content-between d-md-block d-lg-none">
                <button type="button" class="btn btn-sm m-0 text-danger mt-2" @click="closeModel">Cancel</button>
                <button type="button" class="btn  bg-success btn-sm m-0 text-white mt-2" @click="closeModel">Confirm</button>
            </div>
            <small v-if="showText">Please type your measurement and press enter.</small>
            <div v-if="validationMsg">
                <div class="popover-body">Oops! It seems like you've entered an incorrect value. Please enter a valid
                    number
                    in the input field. <br /> Acceptable value is: <span class="text-success">
                        <ul>
                            <li>Integer Number ( {{ setValidationMsg.low }} to {{ setValidationMsg.heigh }} )</li>
                            <li>Decimal Number </li>
                            <li>Fraction Value With Hyphen. Example: 26-1/2</li>
                            <li>Fraction Value With Space. Example: 26 1/2</li>
                            <li>Acceptable Fraction Value is: <br> <small>
                                    0/8, 1/8, 1/4, 3/8, 1/2, 5/8, 3/4, 7/8
                                </small></li>
                        </ul>
                    </span></div>
            </div>
        </div>
        <div class="ar-bg-shadow" @click="closeModel"></div>
    </div>

</template>
<script>
import { mapActions } from 'vuex';
import { checkInputValue } from '../lib/helper'
export default {
    name: 'CustomModal',
    props: ['range', 'fractional', 'step', 'closeModel', 'confirmModel'],
    data() {
        return {
            validationMsg: '',
            xRange: { low: 18, heigh: 120 },
            yRange: { low: 12, heigh: 48 },
            showText: false
        }
    },
    methods: {
        handleEnter(){
            let data = checkInputValue(event, this.step);
            if (!this.validated(data)) {
                this.getDepth({
                    'val': data.val,
                    'step': this.step,
                    'dispaly': data.display
                });
                this.showText = true;
                this.confirmModel();
                this.$refs['modalfocus'].value = '';
            }
        },

        depth(event) {
            let data = checkInputValue(event, this.step);
            if (this.validated(data)) {
                this.validationMsg = true;
                this.showText = false;
            }
        },

        ...mapActions('cuttingBoard', ['getDepth']),

        validated(val) {
            this.validationMsg = false
            if (typeof val != "undefined" && val.hasOwnProperty('error')) {
                this.validationMsg = true;
                return true;
            }
        },
    },
    computed: {
        setValidationMsg() {
            return this.step == 'input-two' ? this.yRange : this.xRange;
        }
    }
}

</script>
<style scoped>
.form-control:focus {
    border: none;
}

.popover-input-two {
    left: -34% !important;
    top: -8% !important;
}

.popover-input-one {
    left: 1% !important;
    top: 71% !important;
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

@media (max-width: 768px) {
    .popover-input-two {
        left: 1% !important;
        right: 1%;
        top: 134% !important;
        max-width: 100%;
    }

    .popover-input-one {
        left: 1% !important;
        right: 1%;
        top: 134% !important;
        max-width: 100%;
    }

    .popover-input-two .arrow {
        display: none;
    }

    .popover-input-one .arrow {
        display: none;
    }
}
</style>
