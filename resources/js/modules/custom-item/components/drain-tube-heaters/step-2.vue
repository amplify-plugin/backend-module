<template>
  <div>
    <div class="row" id="cutting-board-two">
      <div class="col-md-6 mb-4">
        <div class="title mb-3 d-flex align-items-center gap-2 text-black-50">
          <i class="icon-circle-check" :class="[length.val !== 0 ? 'text-success' : 'text-danger']"></i>
          <h5 class="mb-0 text-uppercase fw-600" :class="[length.val !== 0 ? 'text-success' : 'text-danger']">Step 1</h5>
        </div>
        <div class="border rounded-md p-3">
          <div class="d-flex align-items-center justify-content-between mb-3">
            <div class="fw-500">VOLTAGE: <span class="text-danger">*</span></div>
            <select class="form-control w-110" v-model="voltage">
              <option value="">Select Voltage</option>
              <option value="115">115</option>
              <option value="230">230</option>
            </select>
          </div>

          <div class="">
            <div class="d-flex align-items-center justify-content-between">
              <div class="fw-500 text-uppercase">LENGTH OF DRAIN TUBE HEATERS
                IN INCHES: <span class="text-danger">*</span></div>
              <div @click="handleStepOne()" class="input-box" :class="length.dispaly ? 'bg-success' : 'bg-danger'">
                {{ length.dispaly }}
              </div>
              <PopoverComponent :closeModel="closeModel" :confirmModel="confirmModel" v-if="showModal" />
            </div>
          </div>
        </div>
      </div>
    </div>

    <!--STEP 03-->
    <div class="row" id="cutting-board-three">
      <div class="col-md-6 mb-4">
        <div class="title mb-3 d-flex align-items-center gap-2">
          <i class="icon-circle-check text-black-50"
            :class="[calculateTotalPrice !== 0 ? 'text-success' : 'text-danger']"></i>
          <h5 class="mb-0 text-uppercase fw-600" :class="[calculateTotalPrice !== 0 ? 'text-success' : 'text-danger']">
            Step
            2</h5>
        </div>
        <div class="border rounded-md p-3">
          <div class="d-flex align-items-center justify-content-between mb-3">
            <div class="fw-500">QUANTITY:</div>
            <input type="text" v-model="quantity" placeholder="0" class="form-control w-90">
          </div>
          <div class="d-flex align-items-center justify-content-between mb-3">
            <div class="fw-500 text-uppercase">Total Length:</div>
            <input type="text" v-model="calculateTotalSquareFeet" disabled placeholder="0" class="form-control w-90">
          </div>
          <div class="d-flex align-items-center justify-content-between">
            <div class="fw-500">TOTAL PRICE:</div>
            <input type="text" placeholder="0" v-model="calculateTotalPrice" disabled class="form-control w-90">
          </div>
        </div>
      </div>

      <div class="col-12 mb-4">
        <button type="submit" :disabled="calculateTotalPrice===0" @click="submit()" class="d-none d-sm-block btn btn-primary">Submit</button>
      </div>
    </div>
  </div>
</template>
<script>
import PopoverComponent from './modal/popover.vue'
import { sweetAlertToasterForERPerror } from '../../helper';
import customAxios from "../../../../utilities/customAxios";
import { sweetAlertToaster } from '../../helper';
export default {
  name: 'DrainTubeHeaterStepTwo',
  components: {
    PopoverComponent
  },
  data() {
    return {
      showModal: false,
      voltage: '',
      length: {
        'val': 0,
        'dispaly': 0
      },
      quantity: 1,
      totalSquareInc: '',
      totalPrice: '',
      product: []
    };
  },
  mounted() {
    this.getProduct();
  },


  methods: {
    handleStepOne() {
      this.showModal = true;
    },

    closeModel() {
      this.showModal = false;
    },
    confirmModel() {
      this.showModal = false;
    },
    getProduct() {
      getFullPageLoader();
      customAxios.get('/custom-item/drain-tube-heater/product').then((res) => {
        if (res?.data?.status !== 'error') {
          this.product = res?.data
        } else {
          sweetAlertToasterForERPerror(this.$swal, res.data.message)
        }
        removeFullPageLoader();
      })
        .catch((err) => {
          ShowNotification('error', 'Order', err.response.data.error);

        });
    },
    submit() {
      let OrderSpec = `${this.quantity}EA, ${this.voltage}V , ${this.length.val}L`;
      const formData = new FormData();
      formData.append('product', this.product?.ItemNumber);
      formData.append('voltage', this.voltage);
      formData.append('length', this.length?.val);
      formData.append('quantity', this.quantity);
      formData.append('total_square_feet', this.calculateTotalSquareFeet);
      formData.append('total_price', this.calculateTotalPrice);
      formData.append('price', this.product.Price);
      formData.append('order_spec', OrderSpec);


      customAxios.post('/custom-item/drain-tube-heater/add-to-cart', formData).then((res) => {
        sweetAlertToaster(this.$swal, res.data.cart_summary, res.data.shop);

      })
        .catch((err) => {
          console.log(err)
          ShowNotification('error', 'Order', err.response.data.error);

        });
    }
  },
  computed: {
    calculateTotalSquareFeet() {
      if (this.length.val) {
        let length = this.length?.val;
        let feet = Math.ceil(Number(length) / 12);
        let totalFeet = Number(feet) * Number(this.quantity);
        return totalFeet;
      }
      return 0;
    },
    calculateTotalPrice() {
      let totalFeet = this.calculateTotalSquareFeet;
      let productPrice = this.product.Price;
      return Number(totalFeet) * Number(productPrice);
    }
  },
  watch: {
    showModal(newval, oldval) {
      if (newval) {
        setTimeout(function () {
          var el = document.querySelector('#modalfocus');
          el.focus();
        }, 200);
      }
    },
    voltage() {
      this.length = {
        'val': 0,
        'dispaly': 0
      }
    },
  }
}
</script>
