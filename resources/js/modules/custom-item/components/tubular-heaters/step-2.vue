<template>
    <div :class="orderStep === 2 ? 'order-step-block' : 'order-step-d-none'">
        <div id="tubular_heaters_two" v-show="slectedTubularHeaters" class="row mb-4 mb-sm-5">
            <div class="col-12">
                <div class="title mb-3 d-flex align-items-center gap-2">
                    <i
                        :class="[$parent.completedSection.includes(2) ? 'text-success' : 'text-black-50']"
                        class="icon-circle-check"
                    ></i>
                    <h5
                        :class="[$parent.completedSection.includes(2) ? 'text-success' : 'text-danger']"
                        class="mb-0 text-uppercase fw-600"
                    >
                        Step 2
                    </h5>
                </div>
                <!-- Product One -->
                <div class="mb-4 border p-4 p-lg-5 rounded-md">
                    <div class="product-image position-relative">
                        <img
                            class="w-100"
                            :src="'/frontend/rhsparts/images/' + slectedTubularHeaters.img"
                            :alt="slectedTubularHeaters.title"
                        />

                        <div
                            v-for="(value, index) in slectedTubularHeaters.input_field"
                            :key="index"
                            data-toggle="tooltip"
                            data-placement="top"
                            :title="getModalTitle(index)"
                            @click="$parent.handleStepOne(index)"
                            :class="[index, { 'bg-danger': value == '0' }, { 'bg-success': value != '0' }]"
                            class="position-absolute input-box make-cursor-pointer"
                        >
                            {{ value }}
                        </div>
                        <PopoverComponent
                            :step="$parent.step"
                            :closeModel="$parent.closeModel"
                            :confirmModel="$parent.confirmModel"
                            v-if="$parent.showModal"
                        />
                    </div>
                    <div class="d-flex flex-row my-4" id="tubular_heaters_product">
                        <div class="p-2">
                            <span class="text-danger">TOTAL LENGTH NEEDED FOR YOUR CURRENT HEATER </span>: (INCHES)
                        </div>
                        <div class="p-2">
                            <input type="text" :value="totalInc" disabled class="form-control border border-1" />
                        </div>
                    </div>
                    <hr />

                    <div class="row my-4" v-if="totalInc != 0">
                        <div class="col">
                            <span class="text-danger position-relative">
                                Select a replacement straight-length heater from RHS Stock.
                            </span>
                            <br />
                            This will be bent into your chosen configuration. Please Note The Watts and Volts

                            <div
                                class="popover fade show bs-popover-left product-popover"
                                role="tooltip"
                                v-if="selectedProductErr"
                            >
                                <div class="arrow" style="top: 34px"></div>
                                <h3 class="popover-header text-warning d-flex justify-content-between">
                                    <span>Warning</span>
                                    <span class="tubular_icon">
                                        <svg
                                            data-v-74b59679=""
                                            @click="removeWarning"
                                            xmlns="http://www.w3.org/2000/svg"
                                            width="24"
                                            height="24"
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-width="2"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            class="feather feather-x-circle"
                                        >
                                            <circle data-v-74b59679="" cx="12" cy="12" r="10"></circle>
                                            <line data-v-74b59679="" x1="15" y1="9" x2="9" y2="15"></line>
                                            <line data-v-74b59679="" x1="9" y1="9" x2="15" y2="15"></line>
                                        </svg>
                                    </span>
                                </h3>
                                <div class="popover-body">
                                    <div class="row my-4">
                                        <div class="col-md-8">
                                            <span class="text-danger">
                                                YOUR REPLACEMENT HEATER IS TOO {{ errorMsg }}.
                                            </span>
                                            <br />
                                            Please adjust your dimensions in the configuration above or select a
                                            different RHS heater.
                                        </div>
                                        <div class="col-md-4">
                                            <div class="d-flex justify-content-around">
                                                <img src="https://www.rhsparts.com/images/graphic-icon-stop.png" />
                                                <span class="border border-1 p-3 border-radius"> {{ extraInc }}</span>
                                            </div>
                                            <p style="font-size: 10px; text-align: center">
                                                YOU MUST BE WITHIN ONE INCH (+ / . )
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="product-list" v-if="showOnlyProductList">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th scope="col">Select</th>
                                            <th scope="col">Part#</th>
                                            <th scope="col">Length</th>
                                            <th scope="col">Volts</th>
                                            <th scope="col">Watts</th>
                                            <th scope="col">DIA</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(item, index) in products" :key="index">
                                            <th width="1%">
                                                <div>
                                                    <input
                                                        type="radio"
                                                        @click="selectProduct(item)"
                                                        id="product"
                                                        name="length"
                                                        aria-label="Radio button for following text input"
                                                    />
                                                </div>
                                            </th>
                                            <th scope="row">{{ item.product }}</th>
                                            <td>{{ item.length }}</td>
                                            <td>{{ item.volts }}</td>
                                            <td>{{ item.watts }}</td>
                                            <td>{{ item.dia }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="tubular_heaters_two" v-show="checkConfigLength && totalPrice > 0" class="row mb-4 mb-sm-5">
            <div class="col-12">
                <div class="title mb-3 d-flex align-items-center gap-2">
                    <i class="icon-circle-check text-success"></i>
                    <h5 class="mb-0 text-uppercase fw-600 text-success">Step 3</h5>
                </div>
                <!-- Product One -->
                <div class="border rounded-md d-flex flex-row justify-content-between position-relative">
                    <div class="d-flex flex-row my-4" id="tubular_heaters_product">
                        <div class="p-2"><span class="text-danger">ROLL HEATER TO SAVE ON SHIPPING</span>:</div>
                        <div class="p-2">
                            <div class="form-check form-check-inline">
                                <input
                                    class="form-check-input"
                                    type="radio"
                                    name="flexRadioDefault"
                                    id="flexRadioDefault1"
                                    v-model="roll"
                                    value="yes"
                                    @click="getRoll"
                                />
                                <label class="form-check-label" for="flexRadioDefault1"> Y </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input
                                    class="form-check-input"
                                    type="radio"
                                    name="flexRadioDefault"
                                    id="flexRadioDefault2"
                                    v-model="roll"
                                    value="no"
                                    @click="getRoll"
                                />
                                <label class="form-check-label" for="flexRadioDefault2"> N </label>
                            </div>
                        </div>
                    </div>
                    <div class="p-2 m-4" @mouseenter="showMessage = true" @mouseleave="showMessage = false">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="35"
                            height="30"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            class="feather feather-help-circle"
                        >
                            <circle cx="12" cy="12" r="10"></circle>
                            <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"></path>
                            <line x1="12" y1="17" x2="12.01" y2="17"></line>
                        </svg>
                        <a class="text-uppercase cursor-pointer">What is this?</a>
                        <NotificationComponent v-if="showMessage" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import { mapActions, mapState, mapGetters } from 'vuex';
import PopoverComponent from './modal/popover.vue';
import NotificationComponent from './modal/notification.vue';

export default {
    name: 'tublarHeater03',
    data() {
        return {
            productErr: '',
            extraInc: 0,
            selectedProductErr: false,
            errorMsg: '',
            showMessage: false,
            selectedProduct: {},
        };
    },
    components: {
        PopoverComponent,
        NotificationComponent,
    },
    props: ['orderStep', 'stepOneValue', 'stepOne', 'handleStepOne', 'slectedTubularHeaters'],

    methods: {
        ...mapActions('tubularHeaters', ['getProduct', 'getSingleProduct', 'changeProduct', 'getRoll']),
        selectProduct(item) {
            this.selectedProduct = item;
            let totalInc = Number(this.totalInc);
            let extraInc = Number(item.key) - Number(this.totalInc);
            this.extraInc = extraInc > 0 ? `+ ${extraInc}` : extraInc;
            if (totalInc == item.key || item.key == totalInc - 1 || item.key == totalInc + 1) {
                this.getSingleProduct(item);
                this.selectedProductErr = false;
            } else {
                this.selectedProductErr = true;
            }
            this.errorMsg = extraInc > 0 ? 'LONG' : 'SHORT';
        },
        changeSelectedProduct() {
            this.changeProduct();
            this.selectedProductErr = false;
        },
        removeWarning() {
            this.selectedProductErr = false;
        },
        getModalTitle(configType) {
            switch (configType) {
                case 'config1_input_one':
                    return 'Length';
                case 'config2_input_one':
                    return 'Height';
                case 'config2_input_two':
                    return 'Length';
                case 'config2_input_three':
                    return 'Width';
                case 'config3_input_one':
                    return 'Width';
                case 'config3_input_two':
                    return 'Length';
                case 'config4_input_one':
                    return 'Height';
                case 'config4_input_two':
                    return 'Length';
                case 'config4_input_three':
                    return 'Width';
                case 'config5_input_one':
                    return 'Length';
                case 'config5_input_two':
                    return 'Width';
                case 'config6_input_one':
                    return 'Width';
                case 'config6_input_two':
                    return 'Length';
                case 'config7_input_one':
                    return 'Height';
                case 'config7_input_two':
                    return 'Width';
                case 'config7_input_three':
                    return 'Length';
                case 'config8_input_one':
                    return 'Width';
                case 'config8_input_two':
                    return 'Length';
                default:
                    break;
            }
        },
    },
    computed: {
        ...mapState('tubularHeaters', ['measurement', 'products', 'product', 'config_length_val', 'roll', 'price']),
        ...mapGetters('tubularHeaters', ['inputedMeasurement', 'totalInc', 'showOnlyProductList', 'totalPrice']),
        checkConfigLength() {
            return this.config_length_val?.val >= 60;
        },
        isProductSelected() {
            return Object.keys(this.selectedProduct).length > 0 && this.price > 0;
        },
    },

    watch: {
        inputedMeasurement: function (item) {
            item.map(function (data) {
                let itemField = document.querySelector(`.${data.step}`);
                if (itemField) {
                    itemField.innerHTML = data.dispaly;
                    itemField.classList.add('bg-success');
                    itemField.classList.remove('bg-danger');
                }
            });
        },
        totalInc: function (item) {
            this.getProduct(item);
            if (item > 0) {
                setTimeout(function () {
                    const tubutlarProduct = document.getElementById('tubular_heaters_product');
                    tubutlarProduct.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }, 200);
            }
        },
    },
    onMounted() {
        document.querySelector('[data-toggle="tooltip"]').tooltip();
    },
};
</script>
<style scoped>
.config1_input_one {
    bottom: 35%;
    left: 43%;
}

.config2_input_one {
    left: -16%;
    top: 32%;
}

.config2_input_two {
    bottom: 20%;
    left: 15%;
}

.config2_input_three {
    top: 90%;
    left: 90%;
}

.config3_input_one {
    top: 47%;
    right: -17%;
}

.config3_input_two {
    bottom: 24%;
    left: 50%;
}

.config4_input_one {
    top: 20%;
    left: -18%;
}

.config4_input_two {
    top: 67%;
    left: 20%;
}

.config4_input_three {
    bottom: 4%;
    right: -15%;
}

.config5_input_one {
    bottom: 25%;
    left: 42%;
}

.config5_input_two {
    top: 44%;
    right: -18%;
}

.config6_input_one {
    top: 50%;
    right: -17%;
}

.config6_input_two {
    bottom: 18%;
    left: 50%;
}

.config7_input_one {
    top: 35%;
    right: -15%;
}

.config7_input_two {
    bottom: 14%;
    right: -10%;
}

.config7_input_three {
    bottom: 23%;
    left: 29%;
}

.config8_input_one {
    bottom: 40%;
    right: -18%;
}

.config8_input_two {
    bottom: 20%;
    left: 50%;
}

.product-popover {
    width: 100%;
    min-width: 94%;
    top: 32%;
}

.tubular_icon {
    display: none;
}

@media (max-width: 991px) {
}

@media (max-width: 768px) {
    .config1_input_one {
        bottom: 30%;
    }
}

@media (max-width: 576px) {
    .config3_input_one {
        right: -23%;
    }

    .config3_input_two {
        bottom: 18%;
    }

    .config5_input_one {
        bottom: 19%;
    }

    .config5_input_two {
        right: -24%;
    }

    .config6_input_one {
        top: 41%;
        right: -22%;
    }

    .config6_input_two {
        bottom: 13%;
    }

    .config7_input_one {
        top: 30%;
    }

    .config7_input_two {
        bottom: 15%;
        right: -21%;
    }

    .config7_input_three {
        bottom: 20%;
        left: 23%;
    }

    .config8_input_one {
        right: -24%;
    }

    .config8_input_two {
        bottom: 14%;
    }

    .product-popover {
        max-width: 100%;
        top: 360%;
    }

    .product-popover .arrow {
        display: none;
    }

    .tubular_icon {
        display: block;
    }
}
</style>
