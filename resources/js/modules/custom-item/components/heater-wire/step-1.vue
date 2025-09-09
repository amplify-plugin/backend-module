<template>
  <div>
    <div :class="orderStep === 1 ? 'order-step-block' : 'order-step-d-none'" class="row mb-4 mb-sm-5">
      <div class="col-md-12">
        <div class="title mb-3 d-flex align-items-center gap-2">
          <i :class="[$parent.completedSection.includes(1)?'text-success':'text-black-50']" class="icon-circle-check"></i>
          <h5 class="mb-0 text-uppercase fw-600" :class="[$parent.completedSection.includes(1)?'text-success':'text-danger']">Step 1</h5>
        </div>
        <div class="border rounded-md p-3">
          <div class="d-flex align-items-center justify-content-between mb-3">
            <div class="fw-500">TYPE OF HEATER WIRE: <span class="text-danger"> *</span></div>
            <select @change="getPrice" class="form-control w-110">
              <option value="">Choose</option>
              <option v-for="(product,key) in products" :key="key" :value="product">{{ key }}</option>
            </select>
          </div>
          <div class="d-flex align-items-center justify-content-between">
            <div class="fw-500">PRICE PER FOOT:</div>
            <input v-model="price" type="text" placeholder="0" class="form-control w-110" disabled="disabled">
          </div>
        </div>
      </div>
    </div>

    <!-- STEP 02 -->
    <div :class="orderStep === 1 ? 'order-step-block' : 'order-step-d-none'" class="row mb-4 mb-sm-5" id="heaters_two">
      <div class="col-md-12">
        <div class="title mb-3 d-flex align-items-center gap-2">
          <i :class="[$parent.completedSection.includes(2)?'text-success':'text-black-50']" class="icon-circle-check"></i>
          <h5 class="mb-0 text-uppercase fw-600" :class="[$parent.completedSection.includes(2)?'text-success':'text-danger']">Step 2</h5>
        </div>
        <div class="border rounded-md p-3">
          <div class="d-flex align-items-center justify-content-between">
            <div class="fw-500">VOLTAGE: <span class="text-danger"> *</span></div>
            <select class="form-control w-110" @change="getVoltage" :disabled="!wireStepTwo">
              <option value="">Choose</option>
              <option value="115V">115V</option>
              <option value="230V">230V</option>
            </select>
          </div>
        </div>
      </div>
    </div>

    <!-- STEP 03 -->
    <div :class="orderStep === 1 ? 'order-step-block' : 'order-step-d-none'" class="row mb-4 mb-sm-5" id="heaters_three">
      <div class="col-md-12">
        <div class="title mb-3 d-flex align-items-center gap-2">
          <i :class="[$parent.completedSection.includes(3)?'text-success':'text-black-50']" class="icon-circle-check"></i>
          <h5 class="mb-0 text-uppercase fw-600" :class="[$parent.completedSection.includes(3)?'text-success':'text-danger']">Step 3</h5>
        </div>
        <div class="border rounded-md p-3">
          <div class="d-flex align-items-center justify-content-between">
            <div class="fw-500">HOLDING TEMP OF BOX (F):<span class="text-danger"> *</span></div>
            <select class="form-control w-110" @change="getHoldingTemp" :disabled="!wireStepThree">
              <option value="">Choose</option>
              <option value="-45">-45</option>
              <option value="-40">-40</option>
              <option value="-35">-35</option>
              <option value="-30">-30</option>
              <option value="-25">-25</option>
              <option value="-20">-20</option>
              <option value="-15">-15</option>
              <option value="-10">-10</option>
              <option value="-5">-5</option>
              <option value="0">0</option>
              <option value="5">5</option>
              <option value="10">10</option>
              <option value="15">15</option>
              <option value="20">20</option>
              <option value="25">25</option>
              <option value="30">30</option>
              <option value="35">35</option>
              <option value="40">40</option>
              <option value="45">45</option>
            </select>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import { mapActions, mapState} from 'vuex';
export default {
  name: 'HeaterWireStep-1',
  props: ['orderStep'],

  methods:{
    ...mapActions('heaterWire', ['getPrice','getVoltage','getHoldingTemp'])
  },
  computed: {
    ...mapState({price: state => state.heaterWire.productPrice}),
    ...mapState({wireStepTwo: state => state.heaterWire.wireStepTwo}),
    ...mapState({wireStepThree: state => state.heaterWire.wireStepThree}),
    ...mapState({wireStepFour: state => state.heaterWire.wireStepFour}),
    ...mapState({products: state => state.heaterWire.products}),
  }
}
</script>
