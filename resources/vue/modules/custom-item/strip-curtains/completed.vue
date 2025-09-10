<template>
    <div class="container padding-bottom-3x mb-1 custom-product custom-product-complete-strip-curtains">
        <div class="row">
            <div class="col-12">
                <h3 class="fw-600 text-dark text-capitalize">Create Your Custom Strip Curtain Order</h3>
                <p class="mb-4">
                    <span class="text-danger">NOTE:</span> Strip curtains will be larger than door opening size.
                </p>

                <!--STEP 01-->
                <div :class="orderStep === 1 ? 'order-step-block' : 'order-step-d-none'" class="row mb-4 mb-sm-5">
                    <div class="col-md-6">
                        <div class="title mb-3 d-flex align-items-center gap-2">
                            <i
                                :class="[completedSection.includes(1) ? 'text-success' : 'text-black-50']"
                                class="icon-circle-check"
                            ></i>
                            <h5
                                class="mb-0 text-uppercase fw-600"
                                :class="[completedSection.includes(1) ? 'text-success' : 'text-danger']"
                            >
                                Step 1
                            </h5>
                        </div>
                        <div class="border rounded-md text-uppercase p-3">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="fw-500">
                                    Specify Usage of Curtain Area <span class="text-danger">*</span>
                                </div>
                                <select
                                    v-model="curtainOrderStepOne"
                                    @change="setCurtainArea"
                                    class="form-control w-110"
                                >
                                    <option value="">Choose</option>
                                    <option value="CLR">Cooler</option>
                                    <option value="FZR">Freezer</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!--STEP 02-->
                <div
                    :class="orderStep === 1 ? 'order-step-block' : 'order-step-d-none'"
                    class="row mb-md-5 mb-4"
                    id="strip_curtains_completed_two"
                >
                    <div class="col-md-6">
                        <div class="title mb-3 d-flex align-items-center gap-2">
                            <i
                                :class="[completedSection.includes(2) ? 'text-success' : 'text-black-50']"
                                class="icon-circle-check"
                            ></i>
                            <h5
                                class="mb-0 text-uppercase fw-600"
                                :class="[completedSection.includes(2) ? 'text-success' : 'text-danger']"
                            >
                                Step 2
                            </h5>
                        </div>
                        <div class="border rounded-md text-uppercase p-3 mb-md-5 mb-4">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="fw-500">Select Strip Width <span class="text-danger">*</span></div>
                                <select
                                    :disabled="!curtainOrderStepOne"
                                    v-model="curtainOrderStepTwo"
                                    @change="setStripWidth"
                                    class="form-control w-110"
                                >
                                    <option value="">Choose</option>
                                    <option value="4">4"</option>
                                    <option value="6">6"</option>
                                    <option value="8">8"</option>
                                    <option value="12">12"</option>
                                </select>
                            </div>
                        </div>

                        <div class="product-image position-relative">
                            <img class="w-100 h-100" src="../images/strip-curtains/door-opening-size.png" alt="" />

                            <small class="position-absolute input-box required-input-one text-danger">* Required</small>
                            <div
                                data-toggle="tooltip"
                                data-placement="top"
                                :title="getModalTitle('required-input-one')"
                                @click="handleStepOne('depth')"
                                class="position-absolute input-box input-one make-cursor-pointer"
                                :class="depth ? 'bg-success' : 'bg-danger'"
                            >
                                {{ depth }}
                            </div>

                            <small class="position-absolute input-box required-input-two text-danger">* Required</small>
                            <div
                                data-toggle="tooltip"
                                data-placement="top"
                                :title="getModalTitle('required-input-two')"
                                @click="handleStepOne('height')"
                                class="position-absolute input-box input-two make-cursor-pointer"
                                :class="height ? 'bg-success' : 'bg-danger'"
                            >
                                {{ height }}
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="fw-600 h3 mt-3 mb-4">
                            REMEMBER: Strip curtains will be larger than door opening size
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="border rounded-md text-uppercase p-3">
                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <div class="fw-500">Price Per Square Inch <span class="text-danger">*</span></div>
                                <div>
                                    <input
                                        disabled="true"
                                        v-model="productPrice"
                                        type="text"
                                        placeholder="0"
                                        class="form-control w-90"
                                    />
                                    <div v-if="!productPrice">
                                        <!-- <spinner-component /> -->
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="fw-500">TOTAL CURTAIN PRICE: <span class="text-danger">*</span></div>
                                <input
                                    :disabled="!curtainOrderStepTwoInch"
                                    v-model="totalCurrentPrice"
                                    type="text"
                                    placeholder="0"
                                    class="form-control w-90"
                                />
                                <div>
                                    <!-- <spinner-component /> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!--STEP 03-->
                <div :class="orderStep === 1 ? 'order-step-block' : 'order-step-d-none'" class="row mb-4 mb-sm-5">
                    <div class="col-md-6" id="strip_curtains_completed_three">
                        <div class="title mb-3 d-flex align-items-center gap-2">
                            <i
                                :class="[completedSection.includes(3) ? 'text-success' : 'text-black-50']"
                                class="icon-circle-check"
                            ></i>
                            <h5
                                class="mb-0 text-uppercase fw-600"
                                :class="[completedSection.includes(3) ? 'text-success' : 'text-danger']"
                            >
                                Step 3
                            </h5>
                        </div>

                        <p>
                            <span class="text-danger">NOTE:</span> If you want the mounting bar cut, to save on
                            shipping, select YES.If you do NOT want the mounting bar cut, select NO. EXAMPLE: A 100" bar
                            could be cut into two 50" sections.Each 50" section is mounted side-by-side to create the
                            full 100" length.
                        </p>

                        <div class="border rounded-md text-uppercase p-3 mb-3">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="fw-500 text-uppercase">CUT MOUNTING BAR TO SAVE ON SHIPPING:</div>
                                <div class="d-flex gap-3">
                                    <div class="form-check">
                                        <input
                                            v-model="curtainOrderStepThree"
                                            @change="cutMountingBar"
                                            value="1"
                                            class="form-check-input custom-radio-color"
                                            :disabled="!totalPrice"
                                            type="radio"
                                            id="door-yes"
                                        />
                                        <label class="form-check-label" for="door-yes">Y</label>
                                    </div>
                                    <div class="form-check">
                                        <input
                                            v-model="curtainOrderStepThree"
                                            value="0"
                                            class="form-check-input custom-radio-color"
                                            @change="cutMountingBar"
                                            :disabled="!totalPrice"
                                            type="radio"
                                            id="door-no"
                                        />
                                        <label class="form-check-label" for="door-no">N</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <p class="mb-0">
                            <span class="text-danger">NOTE:</span>
                            Any strip curtain mounting bar over 104" in length will be subject to Motor Freight charges.
                            Motor Freight charges can range from an extra $150 to $250.
                        </p>
                    </div>
                </div>

                <!--STEP 04-->
                <div
                    :class="orderStep === 1 ? 'order-step-block' : 'order-step-d-none'"
                    class="row"
                    id="strip_curtains_completed_four"
                >
                    <div class="col-md-6 mb-4">
                        <div class="title mb-3 d-flex align-items-center gap-2">
                            <i
                                :class="[completedSection.includes(4) ? 'text-success' : 'text-black-50']"
                                class="icon-circle-check"
                            ></i>
                            <h5
                                class="mb-0 text-uppercase fw-600"
                                :class="[completedSection.includes(4) ? 'text-success' : 'text-danger']"
                            >
                                Step 4
                            </h5>
                        </div>
                        <div class="border rounded-md p-3">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="fw-500 text-uppercase">QUANTITY: <span class="text-danger">*</span></div>
                                <input
                                    type="text"
                                    v-model="quantity"
                                    placeholder="0"
                                    @keyup="getQuantity"
                                    class="form-control w-110"
                                    min="1"
                                    max="100"
                                />
                            </div>
                            <div class="d-flex align-items-center justify-content-between my-4">
                                <div class="fw-500 text-uppercase">TOTAL SQUARE INCHES</div>
                                <input
                                    :disabled="true"
                                    v-model="totalSquareInc"
                                    type="text"
                                    placeholder="00"
                                    class="form-control w-110"
                                />
                            </div>
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="fw-500 text-uppercase">TOTAL PRICES:</div>
                                <input
                                    :disabled="true"
                                    v-model="totalPrice"
                                    type="text"
                                    placeholder="00"
                                    class="form-control w-110"
                                />
                            </div>
                        </div>
                    </div>

                    <!--SUBMIT BUTTON-->
                    <div class="col-12">
                        <button
                            type="submit"
                            @click="addToCart(swal)"
                            class="btn btn-primary"
                            :disabled="!completedSection.includes(4)"
                        >
                            Submit
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <PopoverComponent
            :selectedItem="selectedItem"
            :step="selectedItem"
            :closeModel="closeModel"
            :confirmModel="confirmModel"
            v-if="showModal"
        />
    </div>
</template>
<script>
import PopoverComponent from './modal/completed-popover.vue';
import { mapActions, mapState, mapGetters } from 'vuex';
import SpinnerComponent from '../components/spinner.vue';

export default {
    name: 'CompleteStripCurtains',
    components: {
        PopoverComponent,
        SpinnerComponent,
    },
    data() {
        return {
            showModal: false,
            step: '',
            orderStep: 1,
            currentStepValue: '',
            curtainOrderStepOne: '',
            curtainOrderStepTwo: '',
            curtainOrderStepTwoInch: '',
            curtainOrderStepTwoPrice: '',
            curtainOrderStepThree: '0',
            curtainOrderStepFour: '',
            curtainOrderStepFourQuantity: '',
            curtainOrderStepFourInches: '',
            curtainOrderStepFourPrice: '',
            selectedItem: '',
            swal: this.$swal,
            quantity: 0,
        };
    },
    computed: {
        ...mapState({
            depth: (state) => state.stripCurtainsCompleted.depth,
            height: (state) => state.stripCurtainsCompleted.height,
            productPrice: (state) => state.stripCurtainsCompleted.productPrice,
        }),
        ...mapGetters('stripCurtainsCompleted', [
            'totalCurrentPrice',
            'totalSquareInc',
            'totalPrice',
            'completedSection',
        ]),
    },

    methods: {
        closeModel() {
            this.showModal = false;
            document.querySelector('body').classList.remove('modalShow');
        },
        confirmModel() {
            if(!this.depth) {
                this.handleStepOne('depth');
                return;
            }

            if(!this.height) {
                this.handleStepOne('height');
                return;
            }

            this.showModal = false;
            document.querySelector('body').classList.remove('modalShow');
        },
        handleStepOne(section) {
            this.selectedItem = section;
            this.showModal = true;
        },
        getModalTitle(configType) {
            switch (configType) {
                case 'required-input-one':
                    return 'Width';
                case 'required-input-two':
                    return 'Height';
                default:
                    break;
            }
        },
        ...mapActions('stripCurtainsCompleted', [
            'setStripWidth',
            'setCurtainArea',
            'cutMountingBar',
            'getQuantity',
            'addToCart',
        ]),
    },
    watch: {
        showModal(newval, oldval) {
            if (newval) {
                setTimeout(function () {
                    var el = document.querySelector('#modalfocus');
                    el.focus();
                }, 200);
            }
        },

        totalCurrentPrice(newval, oldval) {
            this.quantity = 1;
            this.getQuantity(1);
        },
        completedSection: (pre, next) => {
            const completedTwo = document.getElementById('strip_curtains_completed_two');
            const completedThree = document.getElementById('strip_curtains_completed_three');
            const completedFour = document.getElementById('strip_curtains_completed_four');
            if (pre.includes(1)) {
                completedTwo.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }

            if (pre.includes(2)) {
                completedThree.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }

            if (pre.includes(3)) {
                completedFour.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        },
    },
};
</script>
<style scoped>
.required-input-one {
    top: 0%;
    left: 49%;
    font-weight: bold;
}

.required-input-two {
    top: 50%;
    left: 4%;
    font-weight: bold;
}
</style>
