<template>
    <div class="container padding-bottom-3x mb-1 custom-product custom-product-cutting-board">
        <div class="row">
            <div class="col-12">
                <p class="fw-600 text-dark text-capitalize">Create Your Custom Drain Tube Heaters</p>

                <!--STEP 01-->
                <DrainTubeHeaterStepOne/>

                <!--STEP 02-->
                <DrainTubeHeaterStepTwo  />


                <!-- NEXT-PREV BUTTON -->
                <div class="d-sm-none d-flex align-items-center justify-content-between">
                    <button type="submit" class="m-0 btn btn-primary btn-sm w-90">
                        Submit
                    </button>
                </div>

            </div>
        </div>
    </div>
</template>
<script>
import DrainTubeHeaterStepOne from '../components/drain-tube-heaters/step-1.vue';
import DrainTubeHeaterStepTwo from '../components/drain-tube-heaters/step-2.vue';
export default {
    name: 'DrainTubeHeatersComponent',
    components: {
        DrainTubeHeaterStepOne, DrainTubeHeaterStepTwo
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
        }
    },
};
</script>
