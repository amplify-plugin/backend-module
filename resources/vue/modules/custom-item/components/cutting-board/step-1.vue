<template>
    <div :class="$parent.orderStep === 1 ? 'order-step-block' : 'order-step-d-none'" class="row mb-4 mb-sm-5">
        <div class="col-12">
            <div class="title mb-3 d-flex align-items-center gap-2"
                :class="[$parent.completedSection.includes(1) ? 'text-success' : '']">
                <i class="icon-circle-check"></i>
                <h5 class="mb-0 text-uppercase fw-600"
                    :class="[$parent.completedSection.includes(1) ? 'text-success' : 'text-danger']">Step 1</h5>
            </div>
            <!-- Product One -->
            <div class="mb-4 border p-4 p-lg-5 rounded-md">
                <div class="product-image position-relative">
                    <img class="w-100 h-100" src="../../images/cutting-board/cuttingboard.png" alt="" />

                    <div v-for="(value, index) in stepOne" :key="index" @click="handleStepOne(index)"
                         data-toggle="tooltip"
                         data-placement="top"
                         :title="getModalTitle(index)"
                        :class="dispalyVal[index] ? `${index} bg-success` : `${index} bg-danger`"
                        class="position-absolute input-box make-cursor-pointer">
                        {{ dispalyVal[index] }}
                        <span class="text-danger error-custom-position">Required</span>
                    </div>
                    <PopoverComponent :stepOne="stepOne" :step="step" :closeModel="closeModel" :confirmModel="confirmModel"
                    v-if="showModal" />
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import PopoverComponent from './modal/popover.vue'
import { mapGetters, mapActions } from 'vuex';
export default {
    name: 'CuttingBoardStepOne',
    props:['orderStep'],
    components: {
        PopoverComponent
    },
    data() {
        return {
            showModal: false,
            step: '',
            currentStepValue: '',
            stepOne: {
                'input-one': '0',
                'input-two': '0',
            },
            stepTwo: '',
            stepThree: '',
        };
    },
    mounted() {
        this.getProducts();
    },
    computed: {
        stepOneValue() {
            let check = true;
            Object.entries(this.stepOne).forEach((item) => {
                if (item[1] !== '0') {
                    check = false;
                }
            });
            return check;
        },
        ...mapGetters('cuttingBoard', ['dispalyVal']),
    },

    methods: {
        ...mapActions('cuttingBoard', ['getProducts']),
        handleNextPrev(data, order) {
            this.orderStep = data;
            if (order === 'prev') {
                if (data > 1) {
                    this.orderStep -= 1;
                }
            } else {
                if (this.orderStep < 2) {
                    this.orderStep += 1;
                }
            }
        },
        handleStepOne(name) {
            const body = document.querySelector('body');
            if (! body.classList.contains('modalShow')) {
                body.classList.add('modalShow')
            }

            this.step = name
            this.currentStepValue = this.stepOne[this.step];
            this.showModal = true;
        },

        closeModel() {
            this.stepOne[this.step] = this.currentStepValue;
            this.showModal = false;
            this.step = '';
            this.currentStepValue = '';
            document.querySelector('body').classList.remove('modalShow');
        },
        confirmModel() {
            const steps = Object.keys(this.stepOne);
            this.stepOne[this.step] === '' ? this.stepOne[this.step] = 0 : this.stepOne[this.step]

            for(const step of steps) {
                if (step === 'input-one' && this.dispalyVal[step] === 0) {
                    this.handleStepOne(step);
                    return;
                }
                if (step === 'input-two' && this.dispalyVal[step] === 0) {
                    this.handleStepOne(step);
                    return;
                }
            }

            this.showModal = false;
            this.step = ''
            this.currentStepValue = ''
            document.querySelector('body').classList.remove('modalShow')
        },
        getModalTitle(configType) {
            switch (configType) {
                case "input-one":
                    return "Width"
                case "input-two":
                    return "Depth"
                default:
                    break;
            }
        }
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
    },
    onMounted(){
        document.querySelector('[data-toggle="tooltip"]').tooltip();
    }
};
</script>
<style scoped>
.input-one-required-field {
    top: 70% !important;
    left: 34% !important;
    font-weight: bold !important;
}

.input-two-required-field {
    top: -12% !important;
    left: 0% !important;
    font-weight: bold !important;
}

@media (max-width: 756px) {
    .input-one-required-field {
        top: 50% !important;
        left: 37% !important;
        font-weight: bold !important;
    }

    .input-two-required-field {
        top: 50% !important;
        left: 80% !important;
        font-weight: bold !important;
    }
    .error-custom-position{
        display: none;
    }
}
</style>
