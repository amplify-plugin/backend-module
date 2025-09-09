<template>
    <div class="container padding-bottom-3x mb-1 custom-product custom-product-wire-shelf">
        <div class="row">
            <div class="col-12">
                <p class="fw-600 text-dark mb-5 text-capitalize">Create Your Custom Wire Shelf</p>

                <!--STEP 01-->
                <WireShelfStepOne :orderStep="orderStep" :stepOneValue="stepOneValue" :stepOne="stepOne"
                    :handleStepOne="handleStepOne" />

                <!--STEP 02-04-->
                <WireShelfStepTwo :orderStep="orderStep" :stepTwo="stepTwo" :stepOneValue="stepOneValue"
                    :stepThree="stepThree" :stepFour="stepFour" />

                <!-- NEXT-PREV BUTTON -->
                <div class="d-sm-none d-flex align-items-center justify-content-between mt-5">
                    <button :disabled="orderStep === 1" @click="handleNextPrev(orderStep, 'prev')"
                        :class="orderStep > 1 ? 'btn-primary' : 'btn-secondary'" class="w-90 m-0 btn btn-sm">Prev
                    </button>
                    <div class="d-flex gap-3">
                        <span :class="orderStep === 1 ? 'bg-danger' : 'bg-secondary'" class="bullet"></span>
                        <span :class="orderStep === 2 ? 'bg-danger' : 'bg-secondary'" class="bullet"></span>
                    </div>
                    <button v-if="orderStep === 2" @click="addToCart(swal)" type="submit" class="m-0 btn btn-primary btn-sm w-90"
                        :disabled="!completedSection.includes(4)">
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
import WireShelfStepOne from '../components/wire-shelf/wire-shelf-step-one.vue';
import WireShelfStepTwo from '../components/wire-shelf/wire-shelf-step-two.vue';
import { mapActions, mapState ,mapGetters} from 'vuex';
export default {
    name: 'WireShelf',
    components: {
        WireShelfStepOne, WireShelfStepTwo
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
            stepFour: '',
            swal: this.$swal,
        }
    },
    computed: {
        ...mapGetters('shelving', ['depth_fract', 'completedSection']),
        stepOneValue() {
            let check = true;
            Object.entries(this.stepOne).forEach(item => {
                if (item[1] !== '0') {
                    check = false
                }
            })
            return check
        },
        ...mapState({ range: state => state.shelving.range }),
        ...mapState({ fractional: state => state.shelving.fractional }),

    },

    methods: {
        ...mapActions('shelving', ['cancelModal','addToCart']),
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
            this.cancelModal(this.step);
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
        completedSection: (pre, next) => {
            const wireShelfStepTwo = document.getElementById('wire_shelf_step_two');
            const wireShelfStepThree = document.getElementById('wire_shelf_step_three');
            const wireShelfStepFour = document.getElementById('wire_shelf_step_four');
            if (pre.includes(1)) {
                wireShelfStepTwo.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }

            if (pre.includes(2)) {
                wireShelfStepThree.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }

            if (pre.includes(3)) {
                wireShelfStepFour.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        }
    }
};
</script>
