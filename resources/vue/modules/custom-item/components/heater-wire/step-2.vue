<template>
  <div>
    <div :class="orderStep === 2 ? 'order-step-block' : 'order-step-d-none'" class="row mb-4 mb-sm-5" id="heaters_four">
      <div class="col-md-12">
        <div class="title mb-3 d-flex align-items-center gap-2">
          <i :class="[$parent.completedSection.includes(4)?'text-success':'text-black-50']" class="icon-circle-check"></i>
          <h5 class="mb-0 text-uppercase fw-600" :class="[$parent.completedSection.includes(4)?'text-success':'text-danger']">Step 4</h5>
        </div>
        <div class="border rounded-md p-3">
          <div class="d-flex align-items-center justify-content-between">
            <div class="fw-500">TOTAL LENGTH (INCHES):<span class="text-danger">*</span></div>
            <input :value="inches" @keyup="getTotalFeet" min=0 type="text" placeholder="0" :disabled="!wireStepFour"
              class="form-control w-110">
              <br/>
          </div>
          <small class="text-danger">{{ msg }}</small>
          <div class="mt-4">
            <span class="text-danger">NOTE:</span> RHS adds 18" of non-heated lead wire to your total circuit length. Lead
            wire maybe cut for installation purposes.
          </div>
        </div>
      </div>
    </div>

    <!-- STEP 05 -->
    <div :class="orderStep === 2 ? 'order-step-block' : 'order-step-d-none'" class="row mb-4 mb-sm-5" id="heaters_five">
      <div class="col-md-12">
        <div class="title mb-3 d-flex align-items-center gap-2">
          <i :class="[$parent.completedSection.includes(5)?'text-success':'text-black-50']" class="icon-circle-check"></i>
          <h5 class="mb-0 text-uppercase fw-600" :class="[$parent.completedSection.includes(5)?'text-success':'text-danger']">Step 5</h5>
        </div>
        <div class="border rounded-md p-3">
          <div class="d-flex align-items-center justify-content-between">
            <div class="fw-500">NUMBER OF WRAPS: <span class="text-danger">*</span></div>
            <select class="form-control w-110" @change="getWraps" :disabled="!wireStepFive">
              <option value="">Choose</option>
              <option value="1">1</option>
              <option value="2">2</option>
            </select>
          </div>
          <div class="mt-4">
            <span class="text-danger">NOTE:</span> This value will only affect the wattage output (per foot) of the
            wire.It has no bearing on your total length value.
          </div>
        </div>
      </div>
    </div>

    <!-- STEP 06 -->
    <div :class="orderStep === 2 ? 'order-step-block' : 'order-step-d-none'" class="row" id="heaters_six">
      <div class="col-md-12">
        <div class="title mb-3 d-flex align-items-center gap-2">
          <i :class="[$parent.completedSection.includes(6)?'text-success':'text-black-50']" class="icon-circle-check"></i>
          <h5 class="mb-0 text-uppercase fw-600" :class="[$parent.completedSection.includes(6)?'text-success':'text-danger ']">Step 6</h5>
        </div>
        <div class="border rounded-md p-3">
          <div class="d-flex align-items-center justify-content-between">
            <div class="fw-500">QUANTITY: <span class="text-danger"> *</span></div>
            <input v-model="getQty" @keyup="calculateQty" type="text" placeholder="0" :disabled="!$parent.completedSection.includes(5)"
              class="form-control w-110">
          </div>
          <div class="d-flex align-items-center justify-content-between my-4">
            <div class="fw-500">TOTAL FEET:</div>
            <input v-model="totalFeet" type="text" placeholder="0" class="form-control w-110" disabled>
          </div>
          <div class="d-flex align-items-center justify-content-between">
            <div class="fw-500">TOTAL PRICE:</div>
            <input v-model="totalPrice" type="text" placeholder="0" class="form-control w-110" disabled>
          </div>
        </div>
      </div>

      <div class="col-12 mt-4 mt-md-4">
        <button type="submit" @click="addToCart(swal)" class="d-none d-sm-block btn btn-primary"
          :disabled="!$parent.completedSection.includes(6)">Submit</button>
      </div>
    </div>
  </div>
</template>
<script>
import { mapActions, mapState } from 'vuex';
export default {
  name: 'HeaterWireStep-2',
  data(){
    return {
      swal:this.$swal
    }
  },
  props: ['orderStep'],
  methods: {
    ...mapActions('heaterWire', ['calculateFeet', 'calculateQty', 'getWraps', 'addToCart']),
    getTotalFeet(event){
      setTimeout(() => {
        this.calculateFeet(event);
    }, 500);
    }
  },
  computed: {

    ...mapState({ 
                totalFeet: state => state.heaterWire.totalFeet,
                getQty: state => state.heaterWire.qty,
                getTotalPrice: state => state.heaterWire.totalPrice,
                inches: state => state.heaterWire.inches,
                wireStepFour: state => state.heaterWire.wireStepFour,
                wireStepFive: state => state.heaterWire.wireStepFive,
                wireStepSix: state => state.heaterWire.wireStepSix,
                completedStep: state => state.heaterWire.completedStep,
                wraps: state => state.heaterWire.wraps,
                msg: state => state.heaterWire.msg
        }),
      totalPrice(){
        return parseFloat(this.getTotalPrice).toFixed(2);
      }
  }
}
</script>
