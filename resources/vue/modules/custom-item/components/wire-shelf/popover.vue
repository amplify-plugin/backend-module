<template>
  <div class="input-popover popover fade show bs-popover-left" :class="`popover-${step}`" role="tooltip">
    <div class="arrow" style="top: 34px;"></div>
    <h3 class="popover-header text-warning">Add Wire Shelf {{ step == 'input-one' ? 'Depth' : 'Width' }}</h3>
    <div class="modal-body">
      <div class="border rounded-md d-flex align-items-center justify-content-between pr-3"
        :class="{ 'border border-warning': validationMsg }">
        <input
          @keyup="depth"
          @keyup.enter="handleEnter"
          @keydown.tab.prevent="handleEnter"
          :focus="$parent.showModal"
          id="modalfocus"
          ref="modalfocus"
          type="text"
          placeholder="0"
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
              <li>Integer Number (06 to 48)</li>
              <li>Decimal Number </li>
              <li>Fraction Value With Hyphen. Example: 26-1/2</li>
              <li>Fraction Value With Space. Example: 26 1/2</li>
              <li>Acceptable Fraction Value is: <br> <small>
                  0/8, 1/8, 1/4, 3/8, 1/2, 5/8, 3/4, 7/8
                </small></li>
            </ul>
          </span></div>
      </div>
    </div>
    <div class="ar-bg-shadow"></div>
  </div>

</template>
<script>
import { mapActions, mapState } from 'vuex';
import { getFactionalNumber, fractionalPart, checkInputValue } from '../../helper'
export default {
  name: 'CustomModal',
  props: ['range', 'fractional', 'step', 'closeModel', 'confirmModel'],
  data() {
    return {
      validationMsg: '',
      showText: false
    }
  },
  mounted() {
    this.$nextTick(() => {
      this.$refs.autofocus = true
    });
  },
  methods: {
    handleEnter(event){
        let data = checkInputValue(event);
        if (!this.validated(data)) {
            this.getDepth({
                'val': data.val,
                'step': this.step,
                'dispaly': data.display
            });
            this.showText = true;
            this.confirmModel();
            this.$refs['modalfocus'].value = '';
        }
    },

    depth(event) {
        let data = checkInputValue(event);
        if (this.validated(data)) {
            this.validationMsg = true;
            this.showText = false;
        }
    },

    ...mapActions('shelving', ['getDepth', 'getDisplayValue']),

    validated(val) {
      this.validationMsg = false
      if (typeof val != "undefined" && val.hasOwnProperty('error')) {
        this.validationMsg = true;
        return true;
      }
    },
  },
  computed: {
    ...mapState({
      price: state => state.shelving.price,
      shelf_depth: state => state.shelving.shelf_depth,
      shelf_width: state => state.shelving.shelf_width,
      depth_display: state => state.shelving.depth_display,
      width_display: state => state.shelving.width_display,
    }),

    displayValue() {
      if (this.step == 'input-one') {
        return this.depth_display;
      } else if (this.step == 'input-two') {
        return this.width_display;
      }
    }
  },

}

</script>
<style scoped>
.form-control:focus {
  border: none;
}

.popover-input-two {
  left: -17% !important;
  top: 89% !important;
}

.popover-input-one {
  left: 97% !important;
  top: 32% !important;
  width: 100%;
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

@media (max-width: 768px) {
  .popover-input-one {
    left: -4% !important;
    top: 108% !important;
    max-width: 100%;

  }

  .popover-input-two {
    left: -4% !important;
    top: 108% !important;
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
