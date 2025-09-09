<template>
  <div class="input-popover popover fade show bs-popover-left" :class="`popover-${step}`" role="tooltip">
    <div class="arrow" style="top: 34px;"></div>
    <h3 class="popover-header text-warning">Add Wire Shelf {{ step == 'input-one' ? 'Width' : 'Height' }}</h3>
    <div class="modal-body">
      <div class="border rounded-md d-flex align-items-center justify-content-between pr-3"
        :class="{ 'border border-warning': validationMsg }">
        <input
          @keyup="measurement"
          @keyup.enter="handleEnter"
          @keydown.tab.prevent="handleEnter"
          autofocus type="text"
          ref="modalfocus"
          id="modalfocus"
          placeholder="0"
          :disabled="!productSide"
          class="form-control w-100 shadow-none"
        />
        <div>Inches</div>
      </div>
      <div class="d-flex justify-content-between d-md-block d-lg-none">
        <button type="button" class="btn btn-sm m-0 text-danger mt-2" @click="closeModel">Cancel</button>
        <button type="button" class="btn  bg-success btn-sm m-0 text-white mt-2" @click="closeModel">Confirm</button>
      </div>
      <small v-if="showText">Please type your measurement and press enter.</small>
      <div>
        <div v-if="validationMsg" class="popover-body">Oops! It seems like you've entered an incorrect value. Please
          enter a valid number
          in the input field. <br /> Acceptable value is: <span class="text-success">
            <ul>
              <li>Integer Number (06 to 95)</li>
              <li>Decimal Number. Example: 26.56 </li>
              <li>Fractional Value With Hyphen. Example: 26-1/2</li>
              <li>Fractional Value With Space. Example: 26 1/2</li>
              <li>Acceptable Fractional Value is: <br> <small>
                  0/8, 1/8, 1/4, 3/8, 1/2, 5/8, 3/4, 7/8
                </small></li>
            </ul>
          </span>
        </div>
      </div>

    </div>
    <div class="ar-bg-shadow" @click="closeModel"></div>
  </div>

</template>
<script>
import { mapActions, mapState } from 'vuex';
import { checkInputValue } from './helper.js'
export default {
  name: 'CustomModal',
  props: ['range', 'fractional', 'step', 'closeModel', 'confirmModel'],
  data() {
    return {
      validationMsg: '',
      showText: false
    }
  },
  methods: {
      handleEnter(event){
          let data = checkInputValue(event);
          if (!this.validated(data)) {
              this.setMeasurement({
                  'val': data.val,
                  'step': this.step,
                  'dispaly': data.display
              });
              this.showText = true;
              this.confirmModel();
              this.$refs['modalfocus'].value = '';
          }
      },

    measurement(event) {
      let data = checkInputValue(event);
      if (this.validated(data)) {
        this.validationMsg = true;
        this.showText = false;
      }
    },

    ...mapActions('gasket', ['setMeasurement']),

    validated(val) {
      this.validationMsg = false
      if (typeof val != "undefined" && val.hasOwnProperty('error')) {
        this.validationMsg = true;
        return true;
      }
    },
  },
  computed: {
    ...mapState('gasket', ['productSide']),
  },
}

</script>
<style scoped>
.form-control:focus {
  border: none;
}

.popover-input-two {
  left: 0% !important;
  top: 48% !important;
}

.popover-input-one {
  left: 51.5% !important;
  top: 17.5% !important;
}

.ar-bg-shadow {
  background: #00000050;
  width: 100vw;
  height: 100vh;
  top: 0;
  left: 0;
  position: fixed;
  z-index: -1;
}

.popover-input-one .arrow {
  left: -3%;
  transform: rotate(180deg);
}

.modal-body {
  background: #fff;
}

@media (max-width: 756px) {
  .popover-input-two {
    left: 1% !important;
    right: 1%;
    top: 80% !important;
    max-width: 100%;
  }

  .popover-input-one {
    left: 1% !important;
    right: 1%;
    top: 80% !important;
    max-width: 100%;
  }

  .popover-input-one .arrow {
    display: none;
  }

  .popover-input-two .arrow {
    display: none;
  }

}
</style>
