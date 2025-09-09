<template>
    <div class="input-popover popover fade show bs-popover-left" :class="`popover-${step}`" role="tooltip">
        <div class="arrow" style="top: 34px;"></div>
          <h3 class="popover-header text-warning">Select Door Opening {{ step == 'height' ? 'Height' : 'Width' }}</h3>
          <div class="modal-body">
            <div class="border rounded-md d-flex align-items-center justify-content-between pr-3"
              :class="{ 'border border-warning': errorMsgBox }">
              <input
                  type="text"
                  @keyup="getValue($event)"
                  @keyup.enter="handleEnter($event)"
                  @keydown.tab.prevent="handleEnter($event)"
                  placeholder="0"
                  :disabled="!stripWidth"
                  id="modalfocus"
                  class="form-control w-100 shadow-none"
                  autocomplete="off"
                  ref="modalFocus"
              />
              <div>Inches</div>
            </div>
            <small v-if="showText">Please type your measurement and press enter.</small>
            <div v-if="errorMsgBox" class="popover-body">Oops! It seems like you've entered an incorrect value. Please enter a valid number
              in the input field. <br /> Acceptable value is: <span class="text-success">
                <ul>
                  <li>Integer Number {{ getRang().low }} to {{ getRang().heigh }}</li>
                </ul>
              </span></div>
          </div>
        <div class="ar-bg-shadow" @click="closeModel"></div>
    </div>
</template>
<script>
import { mapActions, mapState } from 'vuex';
export default {
  name: 'CustomModal',
  props: ['selectedItem', 'closeModel', 'confirmModel','step'],
  data(){
    return{
      showText:false
    }
  },
  methods: {
    ...mapActions('stripCurtainsCompleted', ['setMeasurement','setValidationMsg', 'validateMeasurement']),

    handleEnter($event){
      if (this.errorMsgBox) {
          return;
      }
      this.showText = true;
      let isDecimal = this.checkValidation($event);
      if(isDecimal){
          this.setValidationMsg()
          this.showText = false;
          return;
      }
      this.setMeasurement({ 'selectedItem': this.selectedItem, 'event': $event });
      this.$refs.modalFocus.value = '';
      this.confirmModel();
    },
    getValue($event) {
      this.showText = true;
      let isDecimal = this.checkValidation($event);
      if(isDecimal){
        this.setValidationMsg()
        this.showText = false;
      }
      this.validateMeasurement({ 'selectedItem': this.selectedItem, 'event': $event })
    },
    getRang() {
      if (this.stripWidth == this.fourInchWidth.type) {
        return this.fourInchWidth;
      }
      if (this.stripWidth == this.sixInchWidth.type) {
        return this.sixInchWidth;
      }
      if (this.stripWidth == this.eightInchWidth.type) {
        return this.eightInchWidth;
      }
      if (this.stripWidth == this.twelveInchWidth.type) {
        return this.twelveInchWidth;
      }
    },
    checkValidation(event){
      let val = event.target.value;
      let regexp = /^\d+\.\d{0,2}$/;
      return regexp.test(val)
    }
  },
  computed: {
    ...mapState({
      errorMsgBox: state => state.stripCurtainsCompleted.errorMsgBox,
      fourInchWidth: state => state.stripCurtainsCompleted.fourInchWidth,
      sixInchWidth: state => state.stripCurtainsCompleted.sixInchWidth,
      eightInchWidth: state => state.stripCurtainsCompleted.eightInchWidth,
      twelveInchWidth: state => state.stripCurtainsCompleted.twelveInchWidth,
      stripWidth: state => state.stripCurtainsCompleted.stripWidth,
    }),
  },

}

</script>
<style scoped>
.form-control:focus {
    border: none;
}

.popover-height {
  top: 38% !important;
  left: 6% !important;
}

.popover-depth {
    left: 19% !important;
    top: 26% !important;
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
.modal-body {
    background: #fff;
}

@media (max-width: 768px){
    .input-popover {
        left: 1% !important;
        right: 1%;
        top: 44% !important;
        max-width: 100%;
    }

    .input-popover .arrow{
        display: none;
    }
}
</style>
