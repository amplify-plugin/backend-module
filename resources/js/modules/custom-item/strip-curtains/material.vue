<template>
        <div class="container padding-bottom-3x mb-1 custom-product custom-product-replacement-strip-curtains">
        <div class="row">
          <div class="col-12">
            <h3 class="fw-600 text-dark text-capitalize mb-4">Order Bulk Strip Material for Strip Curtains</h3>

            <!--STEP 01-->
            <MaterialStripOne
                :curtainsStatus="curtainsStatus"
                :stepOneProductCurtains="stepOneProductCurtains"
            />

            <!--STEP 02-->
            <MaterialStripTwo
                :stepTwoProductCurtainsArea="stepTwoProductCurtainsArea"
                :curtainsStatus="curtainsStatus"
                :stepThreeProductCurtainsFoot="stepThreeProductCurtainsFoot"
                :stepThreeProductCurtainsFeet="stepThreeProductCurtainsFeet"
                :stepFourProductCurtainsTotalPrice="stepFourProductCurtainsTotalPrice"
                :stepFourProductCurtainsQuantity="stepFourProductCurtainsQuantity"
            />

          </div>
        </div>

      </div>
</template>
<script>
import { mapActions, mapState, mapGetters } from 'vuex';
import MaterialStripOne from '../components/strip-material-curtains/step-1.vue';
import MaterialStripTwo from '../components/strip-material-curtains/step-2.vue';
export default {
    name    : 'stripMaterialCurtainsBulk',
    components:  {
        MaterialStripOne,MaterialStripTwo
    },
    data() {
        return {
            step            : '',
            orderStep            : 1,
            currentStepValue: '',
            stepTwoProductCurtainsArea:'',
            stepThreeProductCurtainsFeet:'',
            stepThreeProductCurtainsFoot:'',
            stepFourProductCurtainsQuantity:'',
            stepFourProductCurtainsTotalPrice:'',

        }
    },

    mounted() {
        this.getStrip();
    },
    methods: {
        ...mapActions('stripCurtainsBulk', ['getStrip']),
    },
    computed: {
        ...mapGetters('stripCurtainsBulk', ['completedSection']),
        ...mapState({
            stepOneProductCurtains: state => state.stripCurtainsBulk.replacementProduct,
            curtainsStatus: state => state.stripCurtainsBulk.selectedCurtains,
        }),
    },
    watch: {
        completedSection: (pre, next) => {
            const bulkTwo = document.getElementById('strip_curtains_bulk_two');
            const bulkThree = document.getElementById('strip_curtains_bulk_three');
            const bulkFour = document.getElementById('strip_curtains_bulk_four');

            if (pre.includes(1)) {
                bulkTwo.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
            if (pre.includes(1)) {
                bulkThree.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
            if (pre.includes(1)) {
                bulkFour.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        }
    }
};
</script>
