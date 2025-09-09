<template>
  <div :class="$parent.orderStep === 2 ? 'order-step-block' : 'order-step-d-none'">
    <div class="row" id="cutting-board-two">
      <div class="col-md-6 mb-4">
        <div class="title mb-3 d-flex align-items-center gap-2">
          <i :class="[$parent.completedSection.includes(2)?'text-success':'text-black-50']" class="icon-circle-check"></i>
          <h5 class="mb-0 text-uppercase fw-600" :class="[$parent.completedSection.includes(2)?'text-success':'text-danger']">Step 2</h5>
        </div>
        <div class="border rounded-md p-3">
          <div class="d-flex align-items-center justify-content-between mb-3">
            <div class="fw-500">THICKNESS: <span class="text-danger">*</span></div>
            <select :disabled="!totalSquareInches" class="form-control w-110" @change="setThickness">
              <option value="">Select</option>
              <option value="0.25">1/4"</option>
              <option value="0.5">1/2"</option>
              <option value="0.75">3/4"</option>
              <option value="1">1"</option>
            </select>
          </div>
          <div class="d-flex align-items-center justify-content-between">
            <div class="fw-500">PRICE PER SQUARE INCH:<span class="text-danger">*</span></div>
            <input disabled="true" v-model="selling_price" type="text" placeholder="0"
              class="form-control w-90">
          </div>
        </div>
      </div>
    </div>

    <!--STEP 03-->
    <div :class="orderStep === 2 ? 'order-step-block' : 'order-step-d-none'" class="row" id="cutting-board-three">
      <div class="col-md-6 mb-4">
        <div class="title mb-3 d-flex align-items-center gap-2">
          <i :class="[$parent.completedSection.includes(3)?'text-success':'text-black-50']" class="icon-circle-check"></i>
          <h5 class="mb-0 text-uppercase fw-600" :class="[$parent.completedSection.includes(3)?'text-success':'text-danger']">Step 3</h5>
        </div>
        <div class="border rounded-md p-3">
          <div class="d-flex align-items-center justify-content-between mb-3">
            <div class="fw-500">QUANTITY:</div>
            <input  :disabled="!selling_price" @keyup="setQty" v-model="$parent.stepThree" onkeydown="if(event.key==='.'){event.preventDefault();}"  type="text" placeholder="0" class="form-control w-90">
          </div>
          <div class="d-flex align-items-center justify-content-between mb-3">
            <div class="fw-500">TOTAL SQUARE INCHES:</div>
            <input :disabled="true" v-model="totalSquareInchesWithQty" type="text" placeholder="0" class="form-control w-90">
          </div>
          <div class="d-flex align-items-center justify-content-between">
            <div class="fw-500">TOTAL PRICE:</div>
            <input :disabled="true" v-model="totalPrice" type="text" placeholder="0" class="form-control w-90">
          </div>
        </div>
      </div>

      <div class="col-12 mb-4">
        <button type="submit" @click="addToCart(swal)" class="d-none d-sm-block btn btn-primary" :disabled="totalPrice == 0.00">Submit</button>
      </div>

      <div class="col-md-12">
        <small class="text-danger text-uppercase mb-3 fw-600 d-block">Required Field</small>
        <div class="d-flex gap-2">
          <h6 class="mb-3">Note: </h6>
          <div>
            <p class="mb-2">Please carefully <span class="text-danger">check your order</span>. All custom orders are
              non-returnable.</p>
            <p class="mb-2">&#8226; Any cutting board over 104" long may be subject to Motor Freight charges.Price
              shown above does not include shipping.</p>
            <p>Custom cutting board manufacture times range between 2 and 3 weeks.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import { mapActions, mapState, mapGetters } from 'vuex';
export default {
  name: 'Cutting-Board-Step-2',
  data(){
    return {
      swal:this.$swal
    }
  },
  props: ['orderStep', 'stepTwo', 'stepOneValue', 'stepThree'],
  methods:{
    ...mapActions('cuttingBoard', ['setThickness','setQty','addToCart']),
  },
  computed:{
    ...mapState('cuttingBoard', ['selling_price']),
    ...mapGetters('cuttingBoard', ['totalSquareInches','totalSquareInchesWithQty','totalPrice'])
  },
  watch:{
    selling_price(newValue, oldValue) {
      this.$parent.stepThree = 1
      this.setQty(1);
    }
    
  }
}
</script>