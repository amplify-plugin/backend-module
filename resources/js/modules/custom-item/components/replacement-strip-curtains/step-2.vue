<template>
  <div>
    <div class="row mb-md-5 mb-4">
      <div class="col-md-6" id="replacement_step_two">
        <div class="title mb-3 d-flex align-items-center gap-2">
          <i :class="[$parent.completedSection.includes(2)?'text-success':'text-black-50']" class="icon-circle-check"></i>
          <h5 class="mb-0 text-uppercase fw-600" :class="[$parent.completedSection.includes(2)?'text-success':'text-danger ']">Step 2</h5>
        </div>
        <div class="border rounded-md p-3">
          <div class="d-flex align-items-center justify-content-between mb-4">
            <div class="fw-500 text-uppercase">SPECIFY USAGE OF CURTAIN AREA: <span class="text-danger">*</span></div>
            <select :disabled="!curtainsStatus" @change="getCurtainArea" v-model="$parent.stepTwoProductCurtainsArea"
              class="form-control w-110">
              <option value="">Choose</option>
              <option value="CLR">Cooler</option>
              <option value="FZR">Freezer</option>
            </select>
          </div>
          <div class="d-flex align-items-center justify-content-between">
            <div class="fw-500 text-uppercase">PRICE PER FOOT: <i class="fa fa-spinner" aria-hidden="true"></i></div>
            <input :disabled="!stepTwoProductCurtainsArea" type="text" placeholder="00" :value="replacementProductPrice"
              class="form-control w-110">
          </div>
        </div>
      </div>
    </div>

    <!--STEP 03-->
    <div class="row mb-md-5 mb-4" id="replacement_step_three">
      <div class="col-md-6">
        <div class="title mb-3 d-flex align-items-center gap-2">
          <i :class="[$parent.completedSection.includes(3)?'text-success':'text-black-50']" class="icon-circle-check"></i>
          <h5 class="mb-0 text-uppercase fw-600" :class="[$parent.completedSection.includes(3)?'text-success':'text-danger ']">Step 3</h5>
        </div>
        <div class="border rounded-md p-3">
          <div class="d-flex align-items-center justify-content-between position-relative">
            <div class="fw-500 text-uppercase">LENGTH OF
              STRIP IN INCHES: <span class="text-danger">*</span></div>
            <div v-if="replacementProductPrice" @click="handleStepOne()" class="position-absolute input-box"
              :class="[replacementStripLengthInc != 0 ? 'bg-success' : 'bg-danger']">
              {{ replacementStripLengthInc }}
            </div>
            <div v-else class="position-absolute input-box bg-danger">
              {{ replacementStripLengthInc }}
            </div>
            <PopoverComponent :closeModel="closeModel" :confirmModel="confirmModel" :getStripLength="getStripLength"
            v-if="showModal" />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import { mapActions, mapState } from 'vuex';
// import CustomModal from './modal/modal.vue';
import PopoverComponent from './modal/popover.vue';
export default {
  name: 'Strip_Replacement_Curtains_two',
  props: ['stepTwoProductCurtainsArea', 'curtainsStatus', 'stepTwoProductCurtainsPerFoot', 'stepThreeProductCurtains'],
  data() {
    return {
      showModal: false
    }
  },
  methods: {
    ...mapActions('stripCurtains', ['getCurtainArea', 'getStripLength']),

    handleStepOne() {
      document.querySelector('body').classList.add('modalShow')
      this.showModal = true;
    },

    confirmModel() {
      this.showModal = false;
      document.querySelector('body').classList.remove('modalShow')
    },

    closeModel() {
      this.showModal = false;
      document.querySelector('body').classList.remove('modalShow')
    }

  },
  components: {
    PopoverComponent
  },
  computed: {
    ...mapState('stripCurtains', ['replacementProductPrice', 'replacementStripLengthInc']),
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
    
  }

}
</script>
<style scoped>
.input-box {
  right: 5%;
}
</style>
