<template>
  <div>
    <div class="row mb-md-5 mb-4">
      <div class="col-md-6" id="strip_curtains_bulk_two">
        <div class="title mb-3 d-flex align-items-center gap-2">
          <i
          :class="[$parent.completedSection.includes(2)?'text-success':'text-black-50']"
            class="icon-circle-check"
          ></i>
          <h5 class="mb-0 text-uppercase fw-600" :class="[$parent.completedSection.includes(2)?'text-success':'text-danger']">Step 2</h5>
        </div>
        <div class="border rounded-md p-3">
          <div class="d-flex align-items-center justify-content-between">
            <div class="fw-500 text-uppercase">
              SPECIFY USAGE OF CURTAIN AREA:<span class="text-danger">*</span>
            </div>
            <select
              :disabled="!curtainsStatus"
              @change="getCurtainArea"
              v-model="$parent.stepTwoProductCurtainsArea"
              class="form-control w-110"
            >
              <option value="">Choose</option>
              <option value="CLR">Cooler</option>
              <option value="FZR">Freezer</option>
            </select>
          </div>
        </div>
      </div>
    </div>

    <!--STEP 03-->
    <div class="row mb-md-5 mb-4">
      <div class="col-md-6" id="strip_curtains_bulk_three">
        <div class="title mb-3 d-flex align-items-center gap-2">
          <i
          :class="[$parent.completedSection.includes(3)?'text-success':'text-black-50']"
            class="icon-circle-check"
          ></i>
          <h5 class="mb-0 text-uppercase fw-600" :class="[$parent.completedSection.includes(3)?'text-success':'text-danger']">Step 3</h5>
        </div>
        <div class="border rounded-md p-3">
          <div class="d-flex align-items-center justify-content-between mb-4 position-relative">
            <div class="fw-500 text-uppercase">
              LENGTH OF MATERIAL IN INCHES: <span class="text-danger"> *</span>
            </div>
            <div v-if="replacementProductPrice" @click="handleStepOne()" class=" input-box" :class="[replacementStripLengthInc!=0?'bg-success':'bg-danger']">
              {{ replacementStripLengthInc }}

            </div>
            <div v-else class="position-absolute input-box bg-danger">
              {{ replacementStripLengthInc }}
            </div>

            <PopoverComponent :closeModel="closeModel" :confirmModel="confirmModel" :getStripLength="getStripLength" v-if="showModal" />
          </div>

          <div class="d-flex align-items-center justify-content-between">
            <div class="fw-500 text-uppercase">PRICE PER FOOT: <span class="text-danger"> *</span></div>
            <input
              :disabled="true"
              v-model="replacementProductPrice"
              type="text"
              placeholder="00"
              class="form-control w-110"
            />
          </div>
        </div>
      </div>
    </div>

    <!--STEP 04-->
    <div class="row">
      <div class="col-md-6 mb-4" id="strip_curtains_bulk_three">
        <div class="title mb-3 d-flex align-items-center gap-2">
          <i
          :class="[$parent.completedSection.includes(4)?'text-success':'text-black-50']"
            class="icon-circle-check"
          ></i>
          <h5 class="mb-0 text-uppercase fw-600" :class="[$parent.completedSection.includes(4)?'text-success':'text-danger']">Step 4</h5>
        </div>
        <div class="border rounded-md p-3">
          <div class="d-flex align-items-center justify-content-between mb-4">
            <div class="fw-500 text-uppercase">
              QUANTITY: <span class="text-danger">*</span>
            </div>
            <input type="text" v-model="qty" placeholder="00" class="form-control w-110" @keyup="getQty">
          </div>

          <div class="d-flex align-items-center justify-content-between">
            <div class="fw-500 text-uppercase">TOTAL PRICES:</div>
            <input
              :disabled="true"
              v-model="totalPrice"
              type="text"
              placeholder="00"
              class="form-control w-110"
            />
          </div>
        </div>
      </div>

      <!--SUBMIT BUTTON-->
      <div class="col-12">
        <p class="my-4">
          <span class="text-danger">NOTE:</span> Please carefully check your
          order. All custom orders are non-returnable.
        </p>
        <button
          type="submit"
          class="btn btn-primary"
          :disabled="!$parent.completedSection.includes(4)"
          @click="addToCart(swal)"
        >
          Submit
        </button>
      </div>
    </div>
  </div>
</template>
<script>
import { mapActions, mapState, mapGetters } from "vuex";
import PopoverComponent from "./modal/popover.vue";
export default {
  name: "step-two",
  props: [
    "stepTwoProductCurtainsArea",
    "curtainsStatus",
    "stepThreeProductCurtainsFoot",
    "stepThreeProductCurtainsFeet",
    "stepFourProductCurtainsTotalPrice",
    "stepFourProductCurtainsQuantity",
  ],
  data() {
    return {
      showModal: false,
      swal:this.$swal,
      qty:1,
    };
  },
  methods: {
    ...mapActions("stripCurtainsBulk", ["getCurtainArea", "getStripLength","getQty","addToCart"]),

    handleStepOne() {
      document.querySelector("body").classList.add("modalShow");
      this.showModal = true;
    },

    confirmModel() {
      this.showModal = false;
      document.querySelector("body").classList.remove("modalShow");
    },
    closeModel() {
      this.showModal = false;
    },
  },
  components: {
    PopoverComponent,
  },
  computed: {
    ...mapState("stripCurtainsBulk", [
      "replacementProductPrice",
      "replacementStripLengthInc",
    ]),
    ...mapGetters('stripCurtainsBulk',['totalPrice'])
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
        replacementProductPrice(newval, oldval) {
           this.qty = 1;
           this.getQty(1);
        }
    }
};
</script>

<style scoped>
.input-box{
  right: 5%;
}
</style>
