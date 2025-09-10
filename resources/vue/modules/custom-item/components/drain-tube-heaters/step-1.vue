<template>
    <div :class="orderStep === 1 ? 'order-step-block' : 'order-step-d-none'" class="row mb-4 mb-sm-5">
        <div class="col-12">
            <!-- Product One -->
            <div class="mb-4 border p-4 p-lg-5 rounded-md">
                <div class="product-image position-relative text-center">
                    <img class="" src="../../images/drain-tube-heaters/Custom-Drain-Tube-Heaters.png" alt="" />
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import PopoverComponent from './modal/popover.vue'
export default {
    name: 'DrainTubeHeaterStepOne',
    data(){
        return{
            orderStep:1
        }
    },
    components: {
        PopoverComponent
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
    },

    methods: {
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
            document.querySelector('body').classList.add('modalShow');
            this.step = name;
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
            this.stepOne[this.step] === '' ? (this.stepOne[this.step] = 0) : this.stepOne[this.step];
            this.showModal = false;
            this.step = '';
            this.currentStepValue = '';
            document.querySelector('body').classList.remove('modalShow');
        },
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

@media only screen and (max-width: 576px) {
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
}
</style>
