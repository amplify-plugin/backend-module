<template>
    <div :class="orderStep === 2 ? 'order-step-block' : 'order-step-d-none'" class="row mb-4" id="gaskets_two">
      <div class="col-12">
        <div class="title mb-3 d-flex align-items-center gap-2">
          <i :class="[$parent.completedSection.includes(2)?'text-success':'text-black-50']" class="icon-circle-check"></i>
          <h5 class="mb-0 text-uppercase fw-600" :class="[$parent.completedSection.includes(2)?'text-success':'text-danger']">Step 2</h5>
        </div>
        <p class="fw-600 text-dark mb-4 text-capitalize">Select the Retainer-Mounted Gasket Profile You Need</p>
      </div>
      <div v-for="(data,index) in stepOneProducts" class="col-md-3 mb-4" :key="index">
        <div @click="$parent.retainerStatus=data.product_code; $parent.nextStep = true ; getprofile(data.product_code);$parent.selectedStep('profile')" :class="data.product_code === retainerStatus && 'active'"
             class="gasket-type position-relative p-4 d-flex flex-column justify-content-center align-items-center"
             type="button">
          <img class="w-100 mw-200" :src="data.thumbnail" :alt="data.product_code">
          <h6 class="fw-600">{{ data.product_code }}</h6>
        </div>
      </div>
      </div>
</template>
<script>
import { mapState, mapActions } from 'vuex';
export default {
    name: 'GasketsstepTwo',
    props: ['retainerStatus', 'orderStep', 'stepTwoProductRetainer', 'nextStep'],
    computed: {
        ...mapState('gasket', ['stepOneProducts']),
    },
    methods: {
        getprofile(code) {
            let data = {
                product: code,
                type: this.$parent.gasketStatus,
            };
            this.getGasketProfile(data);
        },
        ...mapActions('gasket', ['getGasketProfile']),
    },
};
</script>
