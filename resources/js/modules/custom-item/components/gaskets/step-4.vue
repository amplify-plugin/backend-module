<template>
   <div :class="orderStep === 3 ? 'order-step-block' : 'order-step-d-none'" v-if="gasketProfileStatus"
           class="row mb-4 mb-sm-5" id="gaskets_four">
      <div class="col-md-6">
        <div class="title mb-3 d-flex align-items-center gap-2">
          <i :class="[$parent.completedSection.includes(4)?'text-success':'text-black-50']"
             class="icon-circle-check"></i>
          <h5 class="mb-0 text-uppercase fw-600" :class="[$parent.completedSection.includes(4)?'text-success':'text-danger']">Step 4</h5>
        </div>
        <div class="border rounded-md d-flex align-items-center justify-content-between p-3">
          <div class="fw-500 text-uppercase">Number of Sides:</div>
          <div class="d-flex gap-3">
            <div class="form-check">
              <input
                  @change="$parent.nextStep = true"
                  v-model="productSide"
                  value="3"
                  class="form-check-input custom-radio-color"
                  type="radio"
                  id="step-1"
              >
              <label class="form-check-label" for="step-1">3</label>
            </div>
            <div class="form-check">
              <input
                  @change="$parent.nextStep = true"
                  v-model="productSide"
                  value="4"
                  class="form-check-input custom-radio-color"
                  type="radio"
                  id="step-2"
              >
              <label class="form-check-label" for="step-2">4</label>
            </div>
          </div>
        </div>
      </div>
      </div>
</template>
<script>
import { mapActions } from 'vuex';
export default {
    name: 'step-4',
    props: ['orderStep', 'gasketProfileStatus', 'stepFourProductGasketProfile', 'nextStep'],
    data() {
        return {
            productSide: ''
        }
    },
    methods: {
        ...mapActions('gasket', ['numberOfSide']),
    },
    watch: {
        productSide(value) {
            this.numberOfSide(value);
        }
    },
};
</script>
