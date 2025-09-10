<template>
  <div class="container padding-bottom-3x mb-1 custom-product custom-product-heater-wire">
    <div class="row">
      <div class="col-12">
        <!-- BRAID IMAGE -->
        <div class="row mb-4 mb-md-5">
          <div class="col-md-6 mb-4 mb-md-0">
            <div class="rounded h-100 p-3 shadow-26">
              <img src="../../custom-item/images/heater-wire/product-heater-wire.png" alt="">
              <h3 class="my-4 fw-600">Fiber Glass Braid RHS Part #64-200</h3>
              <p>
                The most popular wire for reach-in freezers and refrigerators. This wire is normally installed
                behind
                door mullions with foil backing tape.
              </p>

              <p>
                64-200 wire is constructed of a helically wound element on a fiberglass core, insulated with 1/32"
                of
                silicone rubber and covered with a fiberglass braid. 64-200 series are usually fabricated in
                circuits
                6 ft. to 30 ft. long. Wire is 1/8" diameter.
              </p>
            </div>
          </div>
          <div class="col-md-6">
            <div class="rounded h-100 p-3 shadow-26">
              <img src="../../custom-item/images/heater-wire/product-heater-wire2.png" alt="">
              <h3 class="my-4 fw-600">Aluminum Braid RHS Part #64-250</h3>
              <p>
                A durable, abrasion resistant wire with aluminum outer braid that aids in heat transfer. In all
                other
                respects it is constructed the same as 64-200 Series wire. Normally used around walk-in door
                openings
                in circuits 15 ft. to 60 ft. long. Typically installed in double wraps around door openings.
              </p>

              <p>
                <span class="text-danger">NOTE:</span> 64-250 wire is thicker in diameter than 64-200. This style of
                wire is approximately 3/16" diameter
              </p>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6 order-1 order-md-0">

            <div class="row">
              <div class="col-12">
                <div class="h3 mb-4">Create Your Custom Heater Wire Circuit</div>
              </div>
            </div>

            <!-- STEP 01 -->
            <HeaterWireStepOne :orderStep="orderStep" />

            <!-- STEP 04 -->
            <HeaterWireStepTwo :orderStep="orderStep" />
            <!-- NEXT-PREV BUTTON -->
            <div class="d-sm-none d-flex align-items-center justify-content-between mt-5">
              <button :disabled="orderStep === 1" @click="handleNextPrev(orderStep, 'prev')"
                :class="orderStep > 1 ? 'btn-primary' : 'btn-secondary'" class="w-90 m-0 btn btn-sm">Prev
              </button>
              <div class="d-flex gap-3">
                <span :class="orderStep === 1 ? 'bg-danger' : 'bg-secondary'" class="bullet"></span>
                <span :class="orderStep === 2 ? 'bg-danger' : 'bg-secondary'" class="bullet"></span>
              </div>
              <button v-if="orderStep === 2" @click="addToCart(swal)" type="submit" class="m-0 btn btn-primary btn-sm w-90"
              :disabled="!completedSection.includes(6)">
                Submit
              </button>
              <button v-else @click="handleNextPrev(orderStep, 'next')" class="m-0 btn btn-primary btn-sm w-90">Next
              </button>
            </div>
          </div>
          <div class="col-md-6">
            <img class="img-fluid" src="../../custom-item/images/heater-wire/heater-wire.png" alt="">
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import HeaterWireStepOne from '../components/heater-wire/step-1.vue';
import HeaterWireStepTwo from '../components/heater-wire/step-2.vue';
import { mapActions, mapState, mapGetters } from 'vuex';
export default {
  name: 'Heater-wire',
  components: {
    HeaterWireStepOne, HeaterWireStepTwo
  },
  data() {
    return {
      step: '',
      orderStep: 1,
      swal:this.$swal
    }
  },
  mounted(){
    this.getProducts();
  },
  computed: {
    ...mapGetters('heaterWire', ['completedSection']),
  },
  watch: {
    completedSection: (pre, next) => {
      const heaterTwo = document.getElementById('heaters_two');
      const heaterThree = document.getElementById('heaters_three');
      const heaterFour = document.getElementById('heaters_four');
      const heaterFive = document.getElementById('heaters_five');
      if (pre.includes(1)) {
        heaterTwo.scrollIntoView({ behavior: 'smooth', block: 'start' });
      }
      if (pre.includes(2)) {
        heaterThree.scrollIntoView({ behavior: 'smooth', block: 'start' });
      }
      if (pre.includes(3)) {
        heaterFour.scrollIntoView({ behavior: 'smooth', block: 'start' });
      }
      if (pre.includes(4)) {
        heaterFive.scrollIntoView({ behavior: 'smooth', block: 'start' });
      }
    }
  },
    methods: {
      ...mapActions('heaterWire', ['addToCart','getProducts']),
        handleNextPrev(data, order) {
            this.orderStep = data;
            this.nextStep = false;
            if (order === 'prev') {
                if (data > 1) {
                    this.orderStep -= 1
                }
            } else {
                if (this.orderStep < 2) {
                    this.orderStep += 1
                }
            }
        },

    },
};
</script>
