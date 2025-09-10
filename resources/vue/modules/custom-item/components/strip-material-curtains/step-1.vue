<template>
   <div class="row mb-md-5 mb-4">
        <div class="col-12">
          <div class="title mb-3 d-flex align-items-center gap-2">
            <i :class="[$parent.completedSection.includes(1)?'text-success':'text-black-50']" class="icon-circle-check"></i>
            <h5 class="mb-0 text-uppercase fw-600" :class="[$parent.completedSection.includes(1)?'text-success':'text-danger']">Step 1</h5>
          </div>
          <p class="fw-600 text-dark mb-4 text-capitalize">Select your replacement strip for RHS Curtains </p>
        </div>
        <div v-for="(data,index) in stepOneProductCurtains" class="col-md-3 mb-3 mb-md-0" :key="index">
          <div @click="getCurtains(data);" :class="data.img === curtainsStatus.img && 'active'"
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
            <div class="col-12"><p class="fw-600 text-danger mb-2 text-capitalize mt-3">You Have Chosen:</p></div>
            <div class="col-md-6 mb-4 mb-md-0">
              <div class="selected-img">
                <div
                    class="gasket-type remove-selected-text position-relative p-4 d-flex flex-column justify-content-center align-items-center active"
                    type="button">
                  <img class="w-100" :src="'/frontend/rhsparts/images/'+ curtainsStatus.img"
                       :alt="curtainsStatus.title">
                  <h6 class="fw-600 w-100 text-center">{{ curtainsStatus.type }}</h6>
                  <h6 class="fw-600 position-absolute chosen-title">{{ curtainsStatus.title }}</h6>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <p>For use with cooler or freezer applications.</p>
              <p class="my-4">
                4", 6", and 8" strip widths are available per foot, up to 300-ft rolls. 12" strips widths are available per foot, up to 200-ft. rolls.
              </p>
              <p>
                UPS shipping available up to 150 lbs. <br>
                (includes 4", 6", 8" rolls up to 300 ft.)
              </p>
              <p>12" 200 ft. rolls are shipped motor freight.</p>
              <p>
                <span class="text-danger">NOTE:</span> Bulk strip material has no special cuts or mounting hardware.
              </p>
            </div>
          </div>
        </div>
      </div>
</template>
<script>
import { mapActions, mapState } from 'vuex';
export default  {
    name : 'step-one',
    props:['curtainsStatus','stepOneProductCurtains'],
    methods:{
    ...mapActions('stripCurtainsBulk', ['getCurtains']),
  },
}
</script>
