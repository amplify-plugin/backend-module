<template>
    <div class="container padding-bottom-3x mb-1 custom-product custom-product-evaporator-coils ">
        <div class="row">
            <div class="col-12">
                <p class="fw-600 text-dark mb-5">Create Your Custom Evaporator Coil</p>

                <!--STEP 01-->
                <CoilStepOne :orderStep="orderStep" :stepOneValue="stepOneValue" :handleStepOne="handleStepOne"
                    :stepOne="stepOne" />
                <!--STEP 02-->
                <CoilStepTwoSix :orderStep="orderStep" :stepTwo="stepTwo" :stepOneValue="stepOneValue"
                    :stepThree="stepThree" :stepFour="stepFour" :stepFive="stepFive" :stepSix="stepSix" />

                <!--STEP 07-->
                <CoilStepTwoSeven :orderStep="orderStep" :stepSeven="stepSeven" :stepSix="stepSix" :states="states"/>

                <!-- NEXT-PREV BUTTON -->
                <div class="d-sm-none d-flex align-items-center justify-content-between">
                    <button :disabled="orderStep === 1" @click="handleNextPrev(orderStep, 'prev')"
                        :class="orderStep > 1 ? 'btn-primary' : 'btn-secondary'" class="w-90 m-0 btn btn-sm">Prev
                    </button>
                    <div class="d-flex gap-3">
                        <span :class="orderStep === 1 ? 'bg-danger' : 'bg-secondary'" class="bullet"></span>
                        <span :class="orderStep === 2 ? 'bg-danger' : 'bg-secondary'" class="bullet"></span>
                        <span :class="orderStep === 3 ? 'bg-danger' : 'bg-secondary'" class="bullet"></span>
                    </div>
                    <button v-if="orderStep === 3" @click="submit" type="submit" class="m-0 btn btn-primary btn-sm w-90"
                        :disabled="!completedSection.includes(7)">
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
import { mapActions, mapState ,mapGetters} from 'vuex';
import CoilStepOne from '../components/evaporator-coils/step-1.vue';
import CoilStepTwoSix from '../components/evaporator-coils/step-2-6.vue';
import CoilStepTwoSeven from '../components/evaporator-coils/step-7.vue';
import { isString } from 'lodash/lang';
export default {
    name: 'EvaporateCoil',
    components: {
        CoilStepOne,
        CoilStepTwoSix,
        CoilStepTwoSeven
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
                'input-three': '0',
                'input-four': '0',
                'input-five': '0',
                'input-six': '0',
                'input-seven': '0',
            },
            stepTwo: '',
            stepThree: '',
            stepFour: '',
            stepFive: '',
            stepSix: '',
            stepSeven: '',
            swal:this.$swal,
            defaultCountryCode:'US',

            coilItems:{
                coil_is_coated:'',
                copper_tube:'',
                number_of_fins_per_inc:'',
                number_of_tubes:'',
                qty:'',

                contact_name:'',
                method_of_contact:"",
                company_name:"",
                address:'',
                city:'',
                country:"",
                state:'',
                zipcode:'',
                note:''
            }
        }
    },
    computed: {
        ...mapGetters('evaporatorCoils', ['completedSection']),
        ...mapState({
            countries: state => isString(state.evaporatorCoils.countries) ? [] : state.evaporatorCoils.countries,
            states: state => isString(state.evaporatorCoils.states) ? [] : state.evaporatorCoils.states,
            measurement: state => isString(state.evaporatorCoils.measurement) ? [] : state.evaporatorCoils.measurement,
        }),
        stepOneValue() {
            let check = true;
            Object.entries(this.stepOne).forEach(item => {
                if (item[1] !== '0') {
                    check = false
                }
            })
            return check
        },

    },
    methods: {
        ...mapActions('evaporatorCoils', ['setCoilValue','submitEvaporatorCoils']),

        coilVal(){
            this.setCoilValue(this.coilItems)
        },
        handleNextPrev(data, order) {
            this.orderStep = data;
            if (order === 'prev') {
                if (data > 1) {
                    this.orderStep -= 1
                }
            } else {
                if (this.orderStep < 3) {
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
        confirmModel() {
            const steps = Object.keys(this.stepOne);
            this.stepOne[this.step] === '' ? this.stepOne[this.step] = 0 : this.stepOne[this.step]

            for(const step of steps) {
                if (step === 'input-one' && this.measurement.measurement_one === 0) {
                    this.handleStepOne(step);
                    return;
                }
                if (step === 'input-two' && this.measurement.measurement_two === 0) {
                    this.handleStepOne(step);
                    return;
                }
                if (step === 'input-three' && this.measurement.measurement_three === 0) {
                    this.handleStepOne(step);
                    return;
                }
                if (step === 'input-four' && this.measurement.measurement_four === 0) {
                    this.handleStepOne(step);
                    return;
                }
                if (step === 'input-five' && this.measurement.measurement_five === 0) {
                    this.handleStepOne(step);
                    return;
                }
                if (step === 'input-six' && this.measurement.measurement_six === 0) {
                    this.handleStepOne(step);
                    return;
                }
                if (step === 'input-seven' && this.measurement.measurement_seven === 0) {
                    this.handleStepOne(step);
                    return;
                }
            }

            this.showModal = false;
            this.step = ''
            this.currentStepValue = ''
            document.querySelector('body').classList.remove('modalShow')
        },
        submit(){
            this.submitEvaporatorCoils(this.swal)
        }
    },
    watch: {
        countries(newval,prev){
            this.coilItems.country = this.countries.find(
            (option) => option.iso2 ===  this.defaultCountryCode,
        );
        },
        showModal(newval, oldval) {
            if (newval) {
                setTimeout(function () {
                    var el = document.querySelector("#modalfocus");
                    el.focus()
                }, 200);
            }
        },
        completedSection: (pre, next) => {
            const evaporator_coils_two = document.getElementById('evaporator_coils_two');
            const evaporator_coils_three = document.getElementById('evaporator_coils_three');
            const evaporator_coils_four = document.getElementById('evaporator_coils_four');
            const evaporator_coils_five = document.getElementById('evaporator_coils_five');
            const evaporator_coils_six = document.getElementById('evaporator_coils_six');
            const evaporator_coils_seven = document.getElementById('evaporator_coils_seven');
            if (pre.includes(1)) {
                evaporator_coils_two.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }

            if (pre.includes(2)) {
                evaporator_coils_three.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }

            if (pre.includes(3)) {
                evaporator_coils_four.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }

            if (pre.includes(4)) {
                evaporator_coils_five.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }

            if (pre.includes(5)) {
                evaporator_coils_six.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }

            if (pre.includes(6)) {
                evaporator_coils_seven.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        }
    }
};
</script>
