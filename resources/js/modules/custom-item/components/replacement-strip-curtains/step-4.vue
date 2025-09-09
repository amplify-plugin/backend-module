<template>
  <div class="row">
    <div class="col-md-6 mb-4" id="replacement_step_four">
      <div class="title mb-3 d-flex align-items-center gap-2">
        <i :class="[$parent.completedSection.includes(4)?'text-success':'text-black-50']" class="icon-circle-check"></i>
        <h5 class="mb-0 text-uppercase fw-600" :class="[$parent.completedSection.includes(4)?'text-success':'text-danger ']">Step 4</h5>
      </div>
      <div class="border rounded-md p-3">
        <div class="d-flex align-items-center justify-content-between">
          <div class="fw-500 text-uppercase">QUANTITY: <span class="text-danger">*</span></div>
          <div class="d-flex align-items-end flex-column">
            <input type="text" :disabled="!$parent.completedSection.includes(3)" v-model="quantity" placeholder="00" class="form-control w-110" @keyup="checkQty">
            <span class="text-danger">{{ checkQtyMsg }}</span>
          </div>

        </div>
        <div class="d-flex align-items-center justify-content-between my-4">
          <div class="fw-500 text-uppercase">TOTAL FEET:</div>
          <input :disabled="!stepFourProductCurtainsQuantity" v-model="totalFeet" type="text" placeholder="00"
            class="form-control w-110">
        </div>
        <div class="d-flex align-items-center justify-content-between">
          <div class="fw-500 text-uppercase">TOTAL PRICE:</div>
          <input :disabled="!stepFourProductCurtainsFeet" v-model="totalPrice" type="text" placeholder="00"
            class="form-control w-110">
        </div>
      </div>
    </div>

    <!--SUBMIT BUTTON-->
    <div class="col-12">
      <button type="submit" :disabled="!$parent.completedSection.includes(4)" class="btn btn-primary" @click="addToCart(swal)">Submit
      </button>
    </div>
  </div>
</template>
<script>
import { mapActions, mapGetters,mapState } from 'vuex';
export default {
  name: 'stripReplacementFour',
  data(){
    return{
      checkQtyMsg:'',
      swal:this.$swal,
      quantity: 1,
    }
  },
  props: ['stepFourProductCurtainsTotalPrice', 'stepThreeProductCurtains', 'stepFourProductCurtainsQuantity', 'stepFourProductCurtainsFeet'],
  methods: {
    ...mapActions('stripCurtains', ['getQty', 'addToCart']),
    checkQty(e) {
      let val = e.target.value;
      this.checkQtyMsg = ''
      if(Number(val) < 1 || val > 100 ){
        this.checkQtyMsg = "Please enter a number between 1 and 100."
      }else{
        this.getQty(e);
      }
      
    }
  },
  computed: {
    ...mapGetters('stripCurtains', ['totalFeet', 'totalPrice']),
    ...mapState('stripCurtains', ['replacementStripLengthInc']),
  },
  watch: {
    replacementStripLengthInc(newval, oldval) {
      this.quantity = 1;
      this.getQty(1);
    }
  }
}
</script>
