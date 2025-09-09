<template>
  <div>
    <div class="cs-modal" id="cs-modal">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 bg-white shadow-lg">
          <div class="modal-header border-0">
            <h5 class="modal-title text-uppercase">Add Wire Shelf {{ step == 'input-one' ? 'Depth' : 'Width' }}</h5>
          </div>
          <div class="modal-body">
            <div class="border rounded-md d-flex align-items-center justify-content-between pr-3"
              :class="{ 'border border-warning': validationMsg }">
              <input @keyup="depth" v-on:keyup.enter="confirmModel" :focus="$parent.showModal" id="modalfocus" ref="modalfocus" type="text" placeholder="0" class="form-control w-100 shadow-none">
              <div>Inches</div>
            </div>
            <div>
              <span class="text-danger"></span>
            </div>
          </div>
          <div class="ar-popover popover fade show bs-popover-left" role="tooltip" v-if="validationMsg">
            <div class="arrow" style="top: 34px;"></div>
            <h3 class="popover-header text-warning">Warning</h3>
            <div class="popover-body">Oops! It seems like you've entered an incorrect value. Please enter a valid number
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
          <div class="modal-footer border-0">
            <button @click="closeModel" type="button" class="btn btn-outline-danger" data-dismiss="modal">
              cancel
            </button>
            <button v-if="validationMsg" type="button" class="btn btn-secondary">Confirm</button>
            <button v-else @click="confirmModel" type="button" class="btn btn-success">Confirm</button>
          </div>
        </div>
      </div>
    </div>
    <div class="position-fixed w-100 h-100 left-0 top-0 cs-modal-backdrop"></div>
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
    }
  },
  mounted(){
    this.$nextTick(() => {
      this.$refs.autofocus = true
    });
  },
  methods: {
    depth(event) {
      let data = checkInputValue(event);
      if (this.validated(data)) {
        this.validationMsg = true;
      } else {
        this.getDepth({
          'val': data.val,
          'step': this.step,
          'dispaly': data.display
        });
      }
    },
    
    ...mapActions('shelving', ['getDepth','getDisplayValue']),

    validated(val) {
      this.validationMsg = false
      if (typeof val != "undefined" && val.hasOwnProperty('error')) {
        this.validationMsg = true;
        return true;
      }
    },
  },
  computed:{
    ...mapState({
      price: state => state.shelving.price,
      shelf_depth: state => state.shelving.shelf_depth,
      shelf_width: state => state.shelving.shelf_width,
      depth_display: state => state.shelving.depth_display,
      width_display: state => state.shelving.width_display,
    }),

    displayValue(){
      if(this.step =='input-one'){
        return this.depth_display;
      }else if(this.step =='input-two'){
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

/* Styles for the popover container */
.popover {
  left: -53% !important;
  top: 22% !important;
}
</style>

