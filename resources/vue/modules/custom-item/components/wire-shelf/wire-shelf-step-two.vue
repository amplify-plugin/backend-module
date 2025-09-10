<template>
  <div id="wire_shelf_step_two">
    <div :class="orderStep === 2 ? 'order-step-block' : 'order-step-d-none'" class="row mb-4 mb-sm-5">
      <div class="col-md-6">
        <div class="title mb-3 d-flex align-items-center gap-2">
          <i :class="[$parent.completedSection.includes(2) ? 'text-success' : 'text-black-50']"
            class="icon-circle-check"></i>
          <h5 class="mb-0 text-uppercase fw-600"
            :class="[$parent.completedSection.includes(2) ? 'text-success' : 'text-danger']">Step 2</h5>
        </div>
        <div class="border rounded-md p-3">
          <div class="d-flex align-items-center mb-4 gap-3">
            <div class="fw-500">DIAMETER OF OUTER FRAME WIRE: <span class="text-danger">*</span></div>
            <select class="form-control w-110" @change="getDiameter" :disabled="!firstStep">
              <option value="">Select</option>
              <option value="5/16">5/16</option>
              <option value="3/8">3/8</option>
              <option value="HD">HD</option>
            </select>
          </div>
          <div class="d-flex gap-2">
            <b>Note:</b>
            <div>
              <span class="d-block">3/8" or 5/16" frames are considered COMMERCIAL GRADE. These shelves have 1/8" mesh
                crosswire.</span>
              <br>
              <b>HD (HEAVY DUTY) frames have 3/8" frames, but thicker 5/32" mesh crosswire. HD shelving is for
                maximum strength</b>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!--STEP 03-->
    <div :class="orderStep === 2 ? 'order-step-block' : 'order-step-d-none'" class="row mb-4 mb-sm-5"
      id="wire_shelf_step_three">
      <div class="col-md-6">
        <div class="title mb-3 d-flex align-items-center gap-2">
          <i :class="[$parent.completedSection.includes(3) ? 'text-success' : 'text-black-50']"
            class="icon-circle-check"></i>
          <h5 class="mb-0 text-uppercase fw-600"
            :class="[$parent.completedSection.includes(3) ? 'text-success' : 'text-danger']">Step 3</h5>
        </div>
        <div class="border rounded-md p-3">
          <div class="mb-3 d-flex align-items-center justify-content-between">
            <div class="fw-500">FINISH: <span class="text-danger">*</span></div>
            <select class="form-control w-110" @change="getFinishandPrice" :disabled="!stepTwo">
              <option value="">Select Finish</option>
              <option value="ZN">Zinc</option>
              <option value="CH">Chrome</option>
              <option value="EX">Gray Epoxy</option>
              <option value="EXW">White Epoxy</option>
              <option value="SS">Stainless Steel</option>
            </select>
          </div>

          <div class="mb-3 d-flex align-items-center justify-content-between">
            <div class="fw-500">PRICE PER SQUARE INCH: <span class="text-danger">*</span></div>
            <div class="price-per-square-inch">
              <input :disabled="true" v-model="price" type="text" placeholder="0" class="form-control w-110" />
              <div v-if="loader" class="pricing-loader">
                <spinner-component />
              </div>
            </div>
          </div>

          <div class="d-flex gap-2">
            <b>Note:</b>
            <div>ALL finishes are F.D.A. approved.</div>
          </div>
        </div>
      </div>
    </div>

    <!--STEP 04-->
    <div :class="orderStep === 2 ? 'order-step-block' : 'order-step-d-none'" class="row" id="wire_shelf_step_four">
      <div class="col-md-6 mb-4">
        <div class="title mb-3 d-flex align-items-center gap-2">
          <i :class="[$parent.completedSection.includes(4) ? 'text-success' : 'text-black-50']"
            class="icon-circle-check"></i>
          <h5 class="mb-0 text-uppercase fw-600"
            :class="[$parent.completedSection.includes(4) ? 'text-success' : 'text-danger']">Step 4</h5>
        </div>
        <div class="border rounded-md p-3">
          <div class="d-flex align-items-center justify-content-between mb-3">
            <div class="fw-500">QUANTITY:</div>
            <input type="text" placeholder="0" v-model="quantity" @keyup="getQuantity" :disabled="!stepThree" class="form-control w-110">
          </div>
          <div class="d-flex align-items-center justify-content-between">
            <div class="fw-500">TOTAL PRICE:</div>
            <input disabled="true" :value="totalPrice.toFixed(2)" type="text" placeholder="0"
              class="form-control w-110">
          </div>
        </div>
      </div>

      <div class="col-12 mb-4">
        <button type="submit" class="d-none d-sm-block btn btn-primary" @click="addToCart(swal)"
          :disabled="!activeButton">
          Submit
        </button>
      </div>

      <div class="col-md-12">
        <small class="text-danger text-uppercase mb-3 fw-600 d-block">Required Field <span class="text-danger">
            *</span></small>
        <div class="d-flex gap-2">
          <h6 class="mb-3">Note:</h6>
          <div>
            <p class="mb-2">
              Please carefully <span class="text-danger">check your order</span> All custom orders are
              non-returnable.
            </p>
            <p class="mb-2">
              &#8226; RHS also offers wire shelving with cut-outs, extensions, legs & risers.
            </p>
            <p class="mb-2">
              &#8226; Please call if you require a more complex custom wire shelf. Depending upon job
              requirements, custom wire shelf manufacture times range between 4 to 6 weeks.
            </p>
            <p>Manufacturing tolerance of +/- 1/8"</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import { mapActions, mapState, mapGetters } from 'vuex';
import SpinnerComponent from '../spinner.vue';
export default {
  name: 'WireShelfStepTwo',
  data() {
    return {
      swal: this.$swal,
      quantity:1
    };
  },
  props: ['orderStep'],
  components: {
    SpinnerComponent,
  },
  methods: {
    ...mapActions('shelving', ['getDiameter', 'getFinish', 'getFinishandPrice', 'getQuantity', 'addToCart']),
  },
  computed: {
    ...mapState({ loader: (state) => state.shelving.loader }),
    ...mapGetters('shelving', ['totalPrice','price', 'firstStep', 'stepTwo', 'stepThree', 'stepFour', 'activeButton']),
  },
  // watch: {
  //   price(newValue, oldValue) {
  //     this.quantity = 1
  //     this.getQuantity(1);
  //   }

  // }
};
</script>
<style scoped>
.price-per-square-inch {
  position: relative;
}

.pricing-loader {
  top: 0;
  position: absolute;
  left: 0;
  width: 100%;
  height: 100%;
  display: flex;
  align-items: center;
  justify-content: center;
}
</style>
