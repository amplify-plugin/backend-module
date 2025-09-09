<template>
    <div class="container padding-bottom-3x mb-1 custom-product custom-product-gaskets">
        <div class="row">
            <div class="col-12">
                <!--STEP 02-->
                <GasketStepOne
                    :orderStep="orderStep"
                    :slectedTubularHeaters="slectedTubularHeaters"
                    :stepTwoProductRetainer="stepTwoProductRetainer"
                    :nextStep="nextStep"
                />

                <!--STEP 03-->
                <GasketStepTwo
                    :orderStep="orderStep"
                    :slectedTubularHeaters="slectedTubularHeaters"
                    :stepOne="stepOne"
                    :handleStepOne="handleStepOne"
                />

                <!--STEP 04-->
                <GasketStepThree :orderStep="orderStep" :nextStep="nextStep" />

                <!-- NEXT-PREV BUTTON -->
                <div class="d-sm-none d-flex align-items-center justify-content-between mt-5">
                    <button
                        :disabled="orderStep === 1"
                        @click="handleNextPrev(orderStep, 'prev')"
                        :class="orderStep > 1 ? 'btn-primary' : 'btn-secondary'"
                        class="w-90 m-0 btn btn-sm"
                    >
                        Prev
                    </button>
                    <div class="d-flex gap-3">
                        <span :class="orderStep === 1 ? 'bg-danger' : 'bg-secondary'" class="bullet"></span>
                        <span :class="orderStep === 2 ? 'bg-danger' : 'bg-secondary'" class="bullet"></span>
                        <span :class="orderStep === 3 ? 'bg-danger' : 'bg-secondary'" class="bullet"></span>
                    </div>
                    <button
                        v-if="orderStep === 3"
                        @click="addToOrder(swal)"
                        type="submit"
                        class="m-0 btn btn-primary btn-sm w-90"
                    >
                        Submit
                    </button>
                    <button v-else @click="handleNextPrev(orderStep, 'next')" class="m-0 btn btn-primary btn-sm w-90">
                        Next
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import GasketStepOne from '../components/tubular-heaters/step-1.vue';
import GasketStepTwo from '../components/tubular-heaters/step-2.vue';
import GasketStepThree from '../components/tubular-heaters/step-3.vue';
import { mapActions, mapState, mapGetters } from 'vuex';

export default {
    name: 'TubularHeaters',
    components: {
        GasketStepOne,
        GasketStepTwo,
        GasketStepThree,
    },
    data() {
        return {
            currentWidth: 0,
            showModal: false,
            step: '',
            orderStep: 1,
            currentStepValue: '',
            slectedTubularHeaters: '',
            stepOne: {
                'input-one': '0',
                'input-two': '0',
            },
            swal: this.$swal,

            gasketStatus: '',

            stepTwoProductRetainer: [
                {
                    id: 1,
                    img: 'custom-product/tubular-heaters/01.png',
                    title: 'CONFIGURATION 01',
                    input_field: {
                        config1_input_one: '0',
                    },
                },
                {
                    id: 2,
                    img: 'custom-product/tubular-heaters/02.png',
                    title: 'CONFIGURATION 02',
                    input_field: {
                        config2_input_one: '0',
                        config2_input_two: '0',
                        config2_input_three: '0',
                    },
                },
                {
                    id: 3,
                    img: 'custom-product/tubular-heaters/03.png',
                    title: 'CONFIGURATION 03',
                    input_field: {
                        config3_input_one: '0',
                        config3_input_two: '0',
                    },
                },
                {
                    id: 4,
                    img: 'custom-product/tubular-heaters/04.png',
                    title: 'CONFIGURATION 04',
                    input_field: {
                        config4_input_one: '0',
                        config4_input_two: '0',
                        config4_input_three: '0',
                    },
                },
                {
                    id: 5,
                    img: 'custom-product/tubular-heaters/05.png',
                    title: 'CONFIGURATION 05',
                    input_field: {
                        config5_input_one: '0',
                        config5_input_two: '0',
                    },
                },
                {
                    id: 6,
                    img: 'custom-product/tubular-heaters/06.png',
                    title: 'CONFIGURATION 06',
                    input_field: {
                        config6_input_one: '0',
                        config6_input_two: '0',
                    },
                },
                {
                    id: 7,
                    img: 'custom-product/tubular-heaters/07.png',
                    title: 'CONFIGURATION 07',
                    input_field: {
                        config7_input_one: '0',
                        config7_input_two: '0',
                        config7_input_three: '0',
                    },
                },
                {
                    id: 8,
                    img: 'custom-product/tubular-heaters/08.png',
                    title: 'CONFIGURATION 08',
                    input_field: {
                        config8_input_one: '0',
                        config8_input_two: '0',
                    },
                },
            ],
            nextStep: false,
        };
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
        slectedTubularHeaters(newval, oldval) {
            this.setConfiguration(newval);
            setTimeout(function () {
                const tubutlarTwo = document.getElementById('tubular_heaters_two');
                tubutlarTwo.scrollIntoView({ behavior: 'smooth', block: 'end' });
            }, 200);
        },
        completedSection: (pre, next) => {
            const tubutlarThree = document.getElementById('tubular_heaters_three');
            if (pre.includes(2)) {
                tubutlarThree.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        },
    },
    computed: {
        ...mapGetters('tubularHeaters', ['inputedMeasurement', 'completedSection']),
    },

    created() {
        this.currentWidth = window.innerWidth;
        window.addEventListener('resize', this.handleCurrentWidth);
    },
    methods: {
        ...mapActions('tubularHeaters', ['setConfiguration', 'addToOrder']),
        handleCurrentWidth() {
            this.currentWidth = window.innerWidth;
        },

        handleNextPrev(data, order) {
            this.orderStep = data;
            this.nextStep = false;
            if (order === 'prev') {
                if (data > 1) {
                    this.orderStep -= 1;
                }
            } else {
                if (this.orderStep < 3) {
                    this.orderStep += 1;
                }
            }
        },
        handleStepOne(name) {
            document.querySelector('body').classList.add('modalShow');
            this.step = name;
            this.currentStepValue = this.slectedTubularHeaters.input_field[this.step];
            this.showModal = true;
        },
        getStepModalVal() {},
        closeModel() {
            this.slectedTubularHeaters.input_field[this.step] = this.currentStepValue;
            this.showModal = false;
            this.step = '';
            this.currentStepValue = '';
            document.querySelector('body').classList.remove('modalShow');
        },
        confirmModel() {
            const steps = Object.keys(this.slectedTubularHeaters.input_field);
            console.log(this.inputedMeasurement);

            for (const step of steps) {
                const measurement = this.inputedMeasurement.find(
                    (measurement) => Object.hasOwn(measurement, 'step') && measurement.step === step,
                );
                if(!measurement || ['', '0', 0].includes(measurement.value)) {
                    this.handleStepOne(step);
                    return;
                }
            }

            this.slectedTubularHeaters.input_field[this.step] === ''
                ? (slectedTubularHeaters.input_field[this.step] = 0)
                : this.slectedTubularHeaters.input_field[this.step];

            this.showModal = false;
            this.step = '';
            this.currentStepValue = '';
            document.querySelector('body').classList.remove('modalShow');
        },
    },
};
</script>
