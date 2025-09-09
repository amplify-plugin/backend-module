<template>
  <div class="row mb-md-5 mb-4" id="replacement_step_one">
    <div class="col-12">
      <div class="title mb-3 d-flex align-items-center gap-2">
        <i :class="[$parent.completedSection.includes(1)?'text-success':'text-black-50']" class="icon-circle-check"></i>
        <h5 class="mb-0 text-uppercase fw-600" :class="[$parent.completedSection.includes(1)?'text-success':'text-danger']">Step 1</h5>
      </div>
      <p class="fw-600 text-dark mb-4 text-capitalize">Select your replacement strip for RHS Curtains</p>
    </div>
    <div v-for="(data, index) in stepOneProductCurtains" class="col-md-4 mb-3 mb-md-0" :key="index">
      <div @click="getCurtains(data)" :class="data.id === curtainsStatus.id && 'active'"
        class="gasket-type position-relative p-4 d-flex flex-column justify-content-center align-items-center"
        type="button">
        <img class="w-100 mw-200" :src="'/frontend/rhsparts/images/'+ data.img" :alt="data.title">
        <h6 class="mb-0 fw-600 w-100 mb-4">{{ data.type }}</h6>
        <h6 class="mb-2 fw-600 w-100">{{ data.title }}</h6>
      </div>
    </div>
    <div class="col-12">
      <div class="row" v-if="curtainsStatus">
        <!-- YOU HAVE CHOSEN-->
        <div class="col-12">
          <p class="fw-600 text-danger mb-2 text-capitalize mt-3">You Have Chosen:</p>
        </div>
        <div class="col-md-6 mb-4 mb-md-0">
          <div class="selected-img">
            <div
              class="gasket-type remove-selected-text position-relative p-4 d-flex flex-column justify-content-center align-items-center active"
              type="button">
              <img class="w-100" :src="'/frontend/rhsparts/images/'+ curtainsStatus.img" :alt="curtainsStatus.title">
              <h6 class="fw-600 w-100 text-center">{{ curtainsStatus.type }} WIDTH</h6>
              <h6 class="fw-600 position-absolute chosen-title">{{ curtainsStatus.title }}</h6>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <p>For use with cooler or freezer applications. </p>
          <p class="my-4">
            4" Strips are available in lengths of 60" to 108" <br>
            6" Strips are available in lengths of 60" to 126" <br>
            8" Strips are available in lengths of 60" to 132" <br>
          </p>
          <p>
            <span class="text-danger">NOTE:</span> These strips are for use with RHS strip curtains only. Strips are not
            compatible with other
            manufacturer's curtains.
          </p>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import { mapActions, mapState } from 'vuex';
export default {
  name: 'Replacement-step-one',
  props: ['curtainsStatus', 'stepOneProductCurtains'],
  methods:{
    ...mapActions('stripCurtains', ['getCurtains']),
  },
}
</script>
