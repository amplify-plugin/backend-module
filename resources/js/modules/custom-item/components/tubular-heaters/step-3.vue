<template>
  <div id="tubular_heaters_three" :class="orderStep === 3 ? 'order-step-block' : 'order-step-d-none'">
    <!--STEP 04-->
    <div class="row order-step-block" v-if="totalPrice > 0">
      <div class="col-md-6 mb-4">
        <div class="title mb-3 d-flex align-items-center gap-2">
          <i :class="[$parent.completedSection.includes(3) ? 'text-success' : 'text-black-50']"
            class="icon-circle-check"></i>
          <h5 :class="[$parent.completedSection.includes(3) ? 'text-success' : 'text-danger']"
            class="mb-0 text-uppercase fw-600">Step {{ checkConfigLength?'4':'3' }}</h5>
        </div>
        <div class="border rounded-md p-3">
          <div class="d-flex align-items-center justify-content-between mb-3">
            <div class="fw-500">QUANTITY:</div>
            <div class="d-flex align-items-end flex-column">
              <input v-model="qty" @keyup="getQuantity($event)" type="text" placeholder="0" class="form-control w-90">
              <p><span class="text-danger">{{ qtyErr }}</span></p>
            </div>
          </div>
          <div class="d-flex align-items-center justify-content-between">
            <div class="fw-500">TOTAL PRICE:</div>
            <input :disabled="!totalPrice" :value="totalPrice" type="text" placeholder="0" class="form-control w-90">
          </div>
        </div>
      </div>

      <div class="col-12 mb-4">
        <button type="submit" class="d-none d-sm-block btn btn-primary"
          :disabled="!$parent.completedSection.includes(3)" @click="addToOrder(swal)">Submit</button>
      </div>

      <div class="col-md-12">
        <small class="text-danger text-uppercase mb-3 fw-600 d-block">Required Field</small>
        <div class="d-flex gap-2">
          <h6 class="mb-3">Note: </h6>
          <div>
            <p class="mb-2">&#8226; Please carefully <span class="text-danger">check your order</span> All custom orders
              are
              non-returnable.</p>
            <p class="mb-2">&#8226; Please allow 1-2 days to mfg for most orders.
              Manufacturing tolerance of +/- 1"</p>
          </div>
        </div>
      </div>
    </div>

  </div>
</template>
<script>
import { mapActions, mapState, mapGetters } from 'vuex';
export default {
  name: 'tublarHeater04',
  props: ['orderStep', 'stepTwo', 'stepOneValue', 'stepThree', 'stepFour'],
  data() {
    return {
      swal: this.$swal,
      qty: 1,
      qtyErr: ''
    }
  },
  methods: {
    ...mapActions('tubularHeaters', ['setQuantity', 'addToOrder']),
    getQuantity(e) {
      this.qtyErr = "";
      let quantity = Number(e.target.value);
      if (quantity < 1) {
        this.qtyErr = "The number must be greater than zero";
        ShowNotification('error', 'Order', 'The number must be greater than zero');
      } else if (!Number.isInteger(quantity)) {
        this.qtyErr = "The value should not be a decimal number";
        ShowNotification('error', 'Order', 'The value should not be a decimal number');
      } else {
        this.setQuantity(quantity);
      }

    }
  },
  computed: {
    ...mapState('tubularHeaters', ['config_length_val']),
    ...mapGetters('tubularHeaters', ['totalPrice', 'totalInc']),
    checkConfigLength() {
      return this.config_length_val?.val >= 60;
    }
  },
}
</script>