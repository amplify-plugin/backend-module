<template>
    <div class="container padding-bottom-3x mb-1 custom-product custom-product-gaskets">
        <div class="row">
            <div class="col-12">
                <!--STEP 01-->
                <GasketStepOne :gasketStatus="gasketStatus" :nextStep="nextStep" :orderStep="orderStep"
                    :stepOneProductGaskets="products" />

                <!--STEP 02-->
                <GasketStepTwo :retainerStatus="retainerStatus" :orderStep="orderStep"
                    :stepTwoProductRetainer="products" :nextStep="nextStep" />

                <!--STEP 03-->
                <GasketStepThree :retainerStatus="retainerStatus" :gasketProfileStatus="gasketProfileStatus"
                    :orderStep="orderStep" :stepThreeProductGasketProfileFinal="stepThreeProductGasketProfileFinal"
                    :stepThreeProductGasketProfile="stepThreeProductGasketProfile"
                    :stepThreeProductGasket="stepThreeProductGasket" />

                <!--STEP 04-->
                <GasketStepFour :orderStep="orderStep" :gasketProfileStatus="gasketProfileStatus"
                    :stepFourProductGasketProfile="stepFourProductGasketProfile" :nextStep="nextStep" />

                <!--STEP 05-->
                <GasketStepFive :orderStep="orderStep" :stepFourProductGasketProfile="stepFourProductGasketProfile"
                    :stepOneValue="stepOneValue" :stepFiveProductGasketModal="stepFiveProductGasketModal"
                    :handleStepOne="handleStepOne" />

                <!--STEP 06-->
                <GasketStepSix :orderStep="orderStep" :currentWidth="currentWidth" :stepOneValue="stepOneValue"
                    :stepSixProductGasketProfile="stepSixProductGasketProfile"
                    :stepSixProductGasketDoor="stepSixProductGasketDoor" />

                <!--STEP 07-->
                <GasketStepSeven :orderStep="orderStep" :currentWidth="currentWidth"
                    :stepSixProductGasketProfile="stepSixProductGasketProfile"
                    :stepSevenProductGasketTotalPrice="stepSevenProductGasketTotalPrice" />


                <!-- NEXT-PREV BUTTON -->
                <div class="d-sm-none d-flex align-items-center justify-content-between mt-5">
                    <button :disabled="orderStep === 1" @click="handleNextPrev(orderStep, 'prev')"
                        :class="orderStep > 1 ? 'btn-primary' : 'btn-secondary'" class="w-90 m-0 btn btn-sm">Prev
                    </button>
                    <div class="d-flex gap-3">
                        <span :class="orderStep === 1 ? 'bg-danger' : 'bg-secondary'" class="bullet"></span>
                        <span :class="orderStep === 2 ? 'bg-danger' : 'bg-secondary'" class="bullet"></span>
                        <span :class="orderStep === 3 ? 'bg-danger' : 'bg-secondary'" class="bullet"></span>
                        <span :class="orderStep === 4 ? 'bg-danger' : 'bg-secondary'" class="bullet"></span>
                    </div>
                    <button v-if="orderStep === 4" type="submit" class="m-0 btn btn-primary btn-sm w-90"
                    :disabled="!completedSection.includes(7)" @click="addToCart(swal)">
                        Submit
                    </button>
                    <button v-else @click="handleNextPrev(orderStep, 'next')" class="m-0 btn btn-primary btn-sm w-90"
                        >Next
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import GasketStepOne from '../components/gaskets/step-1.vue';
import GasketStepTwo from '../components/gaskets/step-2.vue';
import GasketStepThree from '../components/gaskets/step-3.vue';
import GasketStepFour from '../components/gaskets/step-4.vue';
import GasketStepFive from '../components/gaskets/step-5.vue';
import GasketStepSix from '../components/gaskets/step-6.vue';
import GasketStepSeven from '../components/gaskets/step-7.vue';
import { mapState, mapActions, mapGetters } from 'vuex';
import { nextTick } from 'vue';

export default {
    name: 'Gaskets',
    components: {
        GasketStepOne,
        GasketStepTwo,
        GasketStepThree,
        GasketStepFour,
        GasketStepFive,
        GasketStepSix,
        GasketStepSeven
    },
    mixins: ['sweetAlertToaster'],
    data() {
        return {
            swal: this.$swal,
            currentWidth: 0,
            showModal: false,
            step: '',
            orderStep: 1,
            currentStepValue: '',
            gasketStatus: 'dart-mounted',
            retainerStatus: '',

            stepTwoProductRetainer: [
                {
                    img: 'frontend/custom-product/gaskets/step-2/1.png',
                    title: '02-070',
                },
                {
                    img: 'images/gaskets/step-2/2.png',
                    title: '02-090',
                },
                {
                    img: 'images/gaskets/step-2/3.png',
                    title: '02-050',
                },
                {
                    img: 'images/gaskets/step-2/4.png',
                    title: '02-068',
                },
                {
                    img: 'images/gaskets/step-2/5.png',
                    title: '02-051',
                },
                {
                    img: 'images/gaskets/step-2/6.png',
                    title: '02-076',
                },
                {
                    img: 'images/gaskets/step-2/7.png',
                    title: '02-066',
                },
                {
                    img: 'images/gaskets/step-2/8.png',
                    title: '02-094',
                },
                {
                    img: 'images/gaskets/step-2/9.png',
                    title: '02-062',
                },
                {
                    img: 'images/gaskets/step-2/10.png',
                    title: '02-117',
                },
                {
                    img: 'images/gaskets/step-2/11.png',
                    title: '02-171',
                },
            ],

            stepThreeProductGasketProfile: [
                {
                    img: 'images/gaskets/step-3/1.png',
                    order: '02-070',
                    color: 'Gray',
                    material: 'Vinyl',
                    note: 'Standard Mount'
                },
                {
                    img: 'images/gaskets/step-3/2.png',
                    order: '02-126',
                    color: 'Gray',
                    material: 'Vinyl',
                    note: 'Standard Mount'
                },
                {
                    img: 'images/gaskets/step-3/3.png',
                    order: '02-315',
                    color: 'Gray',
                    material: 'Santoprene',
                    note: 'Standard Mount'
                }
            ],
            stepThreeProductGasketProfileFinal: [
                {
                    img: 'images/gaskets/step-3/final.png',
                    order: '02-068',
                }
            ],

            gasketProfileStatus: '',

            stepThreeProductGasket: '',
            stepFourProductGasketProfile: '',

            stepFiveProductGasketModal: {
                'input-one': '0',
                'input-two': '0',
            },

            stepSixProductGasketProfile: '',
            stepSixProductGasketDoor: '',
            stepSevenProductGasketTotalPrice: '',
            nextStep: false
        }

    },
    computed: {
        ...mapState('gasket', ['products', 'selected_type']),
        ...mapGetters('gasket', ['depth_fract', 'completedSection']),
        stepOneValue() {
            let check = true;
            Object.entries(this.stepFiveProductGasketModal).forEach(item => {
                if (item[1] !== '0') {
                    check = false
                }
            })
            return check
        }
    },
    watch: {
        showModal(newval, oldval) {
            if (newval) {
                setTimeout(function () {
                    var el = document.querySelector("#modalfocus");
                    el.focus()
                }, 200);
            }
        },
        selected_type(newval) {
            if (newval != 'profile') {
                const gasketsTwo = document.getElementById('gaskets_two');
                gasketsTwo.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        },
        completedSection(pre) {
            if (pre[pre.length - 1] === 2) {
                setTimeout(() => this.scrollToElementWhenReady('gaskets_three'), 200);
                return;
            }
            if (pre[pre.length - 1] === 3) {
                setTimeout(() => this.scrollToElementWhenReady('gaskets_four'), 200);
                return;
            }
            if (pre[pre.length - 1] === 4) {
                setTimeout(() => this.scrollToElementWhenReady('gaskets_five'), 200);
                return;
            }
            if (pre[pre.length - 1] === 5) {
                setTimeout(() => this.scrollToElementWhenReady('gaskets_six'), 200);
                return;
            }
            if (pre[pre.length - 1] === 6) {
                setTimeout(() => this.scrollToElementWhenReady('gaskets_seven'), 200);
            }
        }

    },
    created() {
        this.getProductType();
        this.getProductList(this.gasketStatus)
        this.currentWidth = window.innerWidth;
        window.addEventListener("resize", this.handleCurrentWidth);
    },

    methods: {
        ...mapActions('gasket', ['getProductType', 'getProductList', 'getGasketProfile', 'selectedStep','addToCart']),
        handleCurrentWidth() {
            this.currentWidth = window.innerWidth;
        },
        handleNextPrev(data, order) {
            this.orderStep = data;
            this.nextStep = false;
            if (order === 'prev') {
                if (data > 1) {
                    this.orderStep -= 1
                }
            } else {
                if (this.orderStep < 4) {
                    this.orderStep += 1
                }
            }
        },
        handleStepOne(name) {
            this.step = name
            this.currentStepValue = this.stepFiveProductGasketModal[this.step];
            this.showModal = true;
        },

        closeModel() {
            this.stepFiveProductGasketModal[this.step] = this.currentStepValue;
            this.showModal = false;
            this.step = ''
            this.currentStepValue = ''
            document.querySelector('body').classList.remove('modalShow')
        },
        confirmModel() {
            const steps = Object.keys(this.stepFiveProductGasketModal);
            this.stepFiveProductGasketModal[this.step] === '' ? this.stepFiveProductGasketModal[this.step] = 0 : this.stepFiveProductGasketModal[this.step]

            for(const step of steps) {
                if (step === 'input-one' && (this.depth_fract[step] === 0 || this.depth_fract[step] === '')) {
                    this.handleStepOne(step);
                    return;
                }
                if (step === 'input-two' && (this.depth_fract[step] === 0 || this.depth_fract[step] === '')) {
                    this.handleStepOne(step);
                    return;
                }
            }
            this.showModal = false;
            this.step = ''
            this.currentStepValue = ''
            document.querySelector('body').classList.remove('modalShow')
        },
        scrollToElementWhenReady(id, attempt = 0) {
            const el = document.getElementById(id);
            if (el) {
                el.scrollIntoView({ behavior: 'smooth', block: 'start' });
            } else if (attempt < 10) {
                setTimeout(() => {
                    this.scrollToElementWhenReady(id, attempt + 1);
                }, 100);
            }
        }
    },
};
</script>
