<template>
    <div class="container padding-bottom-3x mb-1 custom-product custom-product-cutting-board">
        <div class="row">
            <div class="col-12">
                <p class="fw-600 text-dark mb-4 mb-sm-5 text-capitalize">Create Your Custom Cutting Board</p>

                <!--STEP 01-->
                <CuttingBoardStepOne :orderStep="orderStep" :stepOneValue="stepOneValue" :stepOne="stepOne"
                    :handleStepOne="handleStepOne" />

                <!--STEP 02-->
                <CuttingBoardStepTwo :orderStep="orderStep" :stepTwo="stepTwo" :stepOneValue="stepOneValue"
                    :stepThree="stepThree" />


                <!-- NEXT-PREV BUTTON -->
                <div class="d-sm-none d-flex align-items-center justify-content-between mt-5">
                    <button :disabled="orderStep === 1" @click="handleNextPrev(orderStep, 'prev')"
                        :class="orderStep > 1 ? 'btn-primary' : 'btn-secondary'" class="w-90 m-0 btn btn-sm">Prev
                    </button>
                    <div class="d-flex gap-3">
                        <span :class="orderStep === 1 ? 'bg-danger' : 'bg-secondary'" class="bullet"></span>
                        <span :class="orderStep === 2 ? 'bg-danger' : 'bg-secondary'" class="bullet"></span>
                    </div>
                    <button v-if="orderStep === 2" type="submit" class="m-0 btn btn-primary btn-sm w-90"
                        :disabled="!completedSection.includes(3)" @click="addToCart(swal)">
                        Submit
                    </button>
                    <button v-else @click="handleNextPrev(orderStep, 'next')"
                        class="m-0 btn btn-primary btn-sm w-90">Next
                    </button>
                </div>

            </div>
        </div>
    </div>
</template>
<script>
import CuttingBoardStepOne from '../components/cutting-board/step-1.vue';
import CuttingBoardStepTwo from '../components/cutting-board/step-2.vue';
import { mapActions} from 'vuex';
import { mapGetters } from 'vuex';
export default {
    name: 'CuttingBoard',
    components: {
        CuttingBoardStepOne, CuttingBoardStepTwo
    },
    data() {
        return {
            showModal: false,
            step: '',
            orderStep: 1,
            currentStepValue: '',
            stepOne: {
                'input-one': '0',
                'input-two': '0',
            },
            stepTwo: '',
            stepThree: '',
            swal:this.$swal
        }
    },
    computed: {
        ...mapGetters('cuttingBoard', ['completedSection']),
        stepOneValue() {
            let check = true;
            Object.entries(this.stepOne).forEach(item => {
                if (item[1] !== '0') {
                    check = false
                }
            })
            return check
        }
    },

    methods: {
        ...mapActions('cuttingBoard', ['addToCart']),
        handleNextPrev(data, order) {
            this.orderStep = data;
            if (order === 'prev') {
                if (data > 1) {
                    this.orderStep -= 1
                }
            } else {
                if (this.orderStep < 2) {
                    this.orderStep += 1
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
            this.step = ''
            this.currentStepValue = ''
            document.querySelector('body').classList.remove('modalShow')
        },
    },
    watch: {
        completedSection: (pre, next) => {
            const cuttingBoardTwo = document.getElementById('cutting-board-two');
            const cuttingBoardThree = document.getElementById('cutting-board-three');
            if (pre.includes(1)) {
                cuttingBoardTwo.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
            if (pre.includes(2)) {
                cuttingBoardThree.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }

        }
    }
};
</script>
