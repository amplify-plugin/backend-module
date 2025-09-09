<template>
    <div class="container padding-bottom-3x mb-1 custom-product custom-product-replacement-strip-curtains">
        <div class="row">
            <div class="col-12">
                <h3 class="fw-600 text-dark text-capitalize mb-4">ORDER REPLACEMENT STRIPS FOR RHS CURTAINS</h3>

                <!--STEP 01-->
                <ReplacementStripOne :curtainsStatus="curtainsStatus" :stepOneProductCurtains="stepOneProductCurtains"
                    :stepTwoProductCurtainsPerFoot="stepTwoProductCurtainsPerFoot"
                    :stepThreeProductCurtains="stepThreeProductCurtains" />

                <!--STEP 02-->
                <ReplacementStripTwo :stepTwoProductCurtainsArea="stepTwoProductCurtainsArea"
                    :curtainsStatus="curtainsStatus" :stepTwoProductCurtainsPerFoot="stepTwoProductCurtainsPerFoot"
                    :stepThreeProductCurtains="stepThreeProductCurtains" />

                <!--STEP 04-->

                <ReplacementStripFour :stepFourProductCurtainsTotalPrice="stepFourProductCurtainsTotalPrice"
                    :stepThreeProductCurtains="stepThreeProductCurtains"
                    :stepFourProductCurtainsQuantity="stepFourProductCurtainsQuantity"
                    :stepFourProductCurtainsFeet="stepFourProductCurtainsFeet" />

            </div>
        </div>
    </div>
</template>
<script>
import ReplacementStripOne from '../components/replacement-strip-curtains/step-1.vue';
import ReplacementStripTwo from '../components/replacement-strip-curtains/step-2.vue';
import ReplacementStripFour from '../components/replacement-strip-curtains/step-4.vue';
import { mapActions, mapState ,mapGetters} from 'vuex';
export default {
    name: 'ReplacementStripCurtains',
    components: {
        ReplacementStripOne,
        ReplacementStripTwo,
        ReplacementStripFour
    },
    data() {
        return {
            step: '',
            orderStep: 1,
            currentStepValue: '',
            stepTwoProductCurtainsArea: '',
            stepTwoProductCurtainsPerFoot: '',
            stepThreeProductCurtains: '',
            stepFourProductCurtainsQuantity: '',
            stepFourProductCurtainsFeet: '',
            stepFourProductCurtainsTotalPrice: '',

        }
    },
    mounted() {
        this.getStrip();
    },
    methods: {
        ...mapActions('stripCurtains', ['getStrip']),
    },
    computed: {
        ...mapGetters('stripCurtains', ['completedSection']),
        ...mapState({
            stepOneProductCurtains: state => state.stripCurtains.replacementProduct,
            curtainsStatus: state => state.stripCurtains.selectedCurtains,
        }),
    },
    watch: {
        completedSection: (pre, next) => {
            const completedTwo = document.getElementById('replacement_step_two');
            const completedThree = document.getElementById('replacement_step_three');
            const completedFour = document.getElementById('replacement_step_four');
            if (pre.includes(1)) {
              completedTwo.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
            if (pre.includes(2)) {
                completedThree.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }

            if (pre.includes(3)) {
                completedFour.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        }
    }
};
</script>