<template>
    <div class="input-popover popover fade show bs-popover-left" :class="`popover-${step}`" role="tooltip">
        <div class="arrow" style="top: 34px"></div>
        <h5 class="popover-header text-warning">
            Add Tubular Heater <span>{{ $parent.getModalTitle(step) }}</span>
        </h5>

        <div class="modal-body">
            <div
                class="border rounded-md d-flex align-items-center justify-content-between pr-3"
                :class="{ 'border border-warning': validationMsg }"
            >
                <input
                    @keyup="measurement"
                    @keyup.enter="handleEnter"
                    @keydown.tab.prevent="handleEnter"
                    autofocus
                    type="text"
                    ref="modalfocus"
                    id="modalfocus"
                    placeholder="0"
                    class="form-control w-100 shadow-none"
                    autocomplete="off"
                />
                <div>Inches</div>
            </div>
            <div class="d-flex justify-content-between d-md-block d-lg-none">
                <button type="button" class="btn btn-sm m-0 text-danger mt-2" @click="closeModel">Cancel</button>
                <button type="button" class="btn bg-success btn-sm m-0 text-white mt-2" @click="closeModel">
                    Confirm
                </button>
            </div>
            <small v-if="showText">Please type your measurement and press enter.</small>
            <div v-if="validationMsg" class="popover-body">
                Oops! It seems like you've entered an incorrect value. Please enter a valid number in the input field.
                <br />
                Acceptable value is:
                <span class="text-success">
                    <ul>
                        <li>Integer Number ({{ inputRange.low }} to {{ inputRange.high }})</li>
                        <li>Decimal Number. Example: 26.56</li>
                        <li>Fractional Value With Hyphen. Example: 26-1/2</li>
                        <li>Fractional Value With Space. Example: 26 1/2</li>
                        <li>
                            Acceptable Fractional Value is: <br />
                            <small> 0/8, 1/8, 1/4, 3/8, 1/2, 5/8, 3/4, 7/8 </small>
                        </li>
                    </ul>
                </span>
            </div>
        </div>

        <div class="ar-bg-shadow" @click="closeModel"></div>
    </div>
</template>
<script>
import { mapActions, mapState } from 'vuex';
import { getValidatedData, checkInputValue } from './helper.js';

export default {
    name: 'CustomModal',
    props: ['range', 'fractional', 'step', 'closeModel', 'confirmModel'],
    data() {
        return {
            validationMsg: '',
            inputRange: {},
            showText: false,
        };
    },
    methods: {
        handleEnter(event) {
            let data = checkInputValue(event, this.step);
            let valid = getValidatedData(this.step);
            this.inputRange = valid;
            if (!this.validated(data)) {
                this.setMeasurement({
                    val: data.val,
                    step: this.step,
                    dispaly: data.display,
                });
                this.showText = true;
                this.confirmModel();
                this.$refs['modalfocus'].value = '';
            }
        },

        measurement(event) {
            let data = checkInputValue(event, this.step);
            let valid = getValidatedData(this.step);
            this.inputRange = valid;
            if (this.validated(data)) {
                this.validationMsg = true;
                this.showText = false;
            }
        },

        ...mapActions('tubularHeaters', ['setMeasurement', 'setLengthVal']),

        validated(val) {
            this.validationMsg = false;
            if (typeof val != 'undefined' && val.hasOwnProperty('error')) {
                this.validationMsg = true;
                return true;
            }
        },
    },
    computed: {
        displayValue() {
            if (this.step == 'input-one') {
                return this.depth_display;
            } else if (this.step == 'input-two') {
                return this.width_display;
            }
        },
    },
};
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
.popover-config1_input_one {
    left: -8% !important;
    top: 53% !important;
}

.popover-config2_input_one {
    left: 51% !important;
    top: 25% !important;
}

.popover-config2_input_one .arrow {
    left: -3%;
    transform: rotate(180deg);
}

.popover-config2_input_two {
    left: -36% !important;
    top: 68% !important;
}

.popover-config2_input_three {
    left: 105% !important;
    top: 85% !important;
    width: 100%;
}

.popover-config2_input_three .arrow {
    left: -3%;
    transform: rotate(180deg);
}

.popover-config3_input_one {
    left: 120% !important;
    top: 42% !important;
    width: 100%;
}

.popover-config3_input_one .arrow {
    left: -3%;
    transform: rotate(180deg);
}

.popover-config3_input_two {
    top: 64% !important;
    left: -2% !important;
}

.popover-config4_input_one {
    top: 15% !important;
    left: -69% !important;
}

.popover-config4_input_two {
    top: 62% !important;
    left: -31% !important;
}

.popover-config4_input_three {
    top: 84% !important;
    left: 119% !important;
    width: 100%;
}

.popover-config4_input_three .arrow {
    left: -3% !important;
    transform: rotate(180deg);
}

.popover-config5_input_two {
    top: 37% !important;
    left: 120% !important;
    width: 100% !important;
}

.popover-config5_input_two .arrow {
    left: -3% !important;
    transform: rotate(180deg);
}

.popover-config5_input_one {
    top: 60% !important;
    left: -9% !important;
}

.popover-config6_input_one {
    top: 45% !important;
    left: 120% !important;
    width: 100% !important;
}

.popover-config6_input_one .arrow {
    left: -3% !important;
    transform: rotate(180deg);
}

.popover-config6_input_two {
    top: 70% !important;
}

.popover-config7_input_one {
    top: 29% !important;
    left: 118% !important;
    width: 100% !important;
}

.popover-config7_input_one .arrow {
    left: -3% !important;
    transform: rotate(180deg);
}

.popover-config7_input_two {
    top: 74% !important;
    left: 112% !important;
    width: 100% !important;
}

.popover-config7_input_two .arrow {
    left: -3% !important;
    transform: rotate(180deg);
}

.popover-config7_input_three {
    top: 65% !important;
    left: -22% !important;
}

.popover-config8_input_one {
    top: 48% !important;
    left: 121% !important;
    width: 100%;
}

.popover-config8_input_one .arrow {
    left: -3% !important;
    transform: rotate(180deg);
}

.popover-config8_input_two {
    top: 67% !important;
    left: -1% !important;
}

@media (max-width: 756px) {
    .popover-config1_input_one {
        left: 1% !important;
        right: 1%;
        top: 89% !important;
    }

    .popover-config1_input_one .arrow {
        display: none;
    }

    .popover-config2_input_one {
        left: 1% !important;
        right: 1%;
        top: 89% !important;
    }

    .popover-config2_input_one .arrow {
        display: none;
    }

    .popover-config2_input_two {
        left: 1% !important;
        right: 1%;
        top: 89% !important;
    }

    .popover-config2_input_two .arrow {
        display: none;
    }

    .popover-config2_input_three {
        left: 1% !important;
        right: 1%;
        top: 89% !important;
    }

    .popover-config2_input_three .arrow {
        display: none;
    }

    .popover-config3_input_one {
        left: 1% !important;
        right: 1%;
        top: 89% !important;
    }

    .popover-config3_input_one .arrow {
        display: none;
    }

    .popover-config3_input_two {
        left: 1% !important;
        right: 1%;
        top: 89% !important;
    }

    .popover-config3_input_two .arrow {
        display: none;
    }

    .popover-config4_input_one {
        left: 1% !important;
        right: 1%;
        top: 89% !important;
    }

    .popover-config4_input_one .arrow {
        display: none;
    }

    .popover-config4_input_two {
        left: 1% !important;
        right: 1%;
        top: 89% !important;
    }

    .popover-config4_input_two .arrow {
        display: none;
    }

    .popover-config4_input_three {
        left: 1% !important;
        right: 1%;
        top: 89% !important;
    }

    .popover-config4_input_three .arrow {
        display: none;
    }

    .popover-config5_input_one {
        left: 1% !important;
        right: 1%;
        top: 89% !important;
    }

    .popover-config5_input_one .arrow {
        display: none;
    }

    .popover-config5_input_two {
        left: 1% !important;
        right: 1%;
        top: 89% !important;
    }

    .popover-config5_input_two .arrow {
        display: none;
    }

    .popover-config6_input_two {
        left: 1% !important;
        right: 1%;
        top: 89% !important;
    }

    .popover-config6_input_two .arrow {
        display: none;
    }

    .popover-config6_input_one {
        left: 1% !important;
        right: 1%;
        top: 89% !important;
    }

    .popover-config6_input_one .arrow {
        display: none;
    }

    .popover-config7_input_three {
        left: 1% !important;
        right: 1%;
        top: 89% !important;
    }

    .popover-config7_input_three .arrow {
        display: none;
    }

    .popover-config7_input_two {
        left: 1% !important;
        right: 1%;
        top: 89% !important;
    }

    .popover-config7_input_two .arrow {
        display: none;
    }

    .popover-config7_input_one {
        left: 1% !important;
        right: 1%;
        top: 89% !important;
    }

    .popover-config7_input_one .arrow {
        display: none;
    }

    .popover-config8_input_two {
        left: 1% !important;
        right: 1%;
        top: 89% !important;
    }

    .popover-config8_input_two .arrow {
        display: none;
    }

    .popover-config8_input_one {
        left: 1% !important;
        right: 1%;
        top: 89% !important;
    }

    .popover-config8_input_one .arrow {
        display: none;
    }
}
</style>
