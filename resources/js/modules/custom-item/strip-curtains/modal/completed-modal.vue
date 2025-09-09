<template>
  <div>
    <div class="cs-modal" id="cs-modal">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 bg-white shadow-lg">
          <div class="modal-header border-0">
            <h5 class="modal-title text-uppercase">SELECT DOOR
              OPENING HEIGHT</h5>
          </div>
          <div class="modal-body">
            <div class="border rounded-md d-flex align-items-center justify-content-between pr-3"
              :class="{ 'border border-warning': errorMsgBox }">
              <input type="text" placeholder="0" id="modalfocus" @keyup="getValue($event)"
                v-on:keyup.enter="confirmModel" class="form-control w-100 shadow-none">
              <div>Inches</div>
            </div>
          </div>
          <div class="popover fade show bs-popover-left" role="tooltip" v-if="errorMsgBox">
            <div class="arrow" style="top: 34px;"></div>
            <h3 class="popover-header text-warning">Warning</h3>
            <div class="popover-body">Oops! It seems like you've entered an incorrect value. Please enter a valid number
              in the input field. <br /> Acceptable value is: <span class="text-success">
                <ul>
                  <li>Integer Number {{ getRang().low }} to {{ getRang().heigh }}</li>
                </ul>
              </span></div>
          </div>
          <div class="modal-footer border-0">
            <button @click="closeModel" type="button" class="btn btn-outline-danger" data-dismiss="modal">
              cancel
            </button>
            <button v-if="errorMsgBox" type="button" class="btn btn-secondary">Confirm</button>
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
export default {
  name: 'CustomModal',
  props: ['selectedItem', 'closeModel', 'confirmModel'],
  methods: {
    ...mapActions('stripCurtainsCompleted', ['setMeasurement','setValidationMsg']),
    getValue($event) {
      let isDecimal = this.checkValidation($event);
      if(isDecimal){
        this.setValidationMsg()
        return;
      }
      this.setMeasurement({ 'selectedItem': this.selectedItem, 'event': $event })
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
      stripWidth: state => state.stripCurtainsCompleted.stripWidth,
      fourInchWidth: state => state.stripCurtainsCompleted.fourInchWidth,
      sixInchWidth: state => state.stripCurtainsCompleted.sixInchWidth,
      eightInchWidth: state => state.stripCurtainsCompleted.eightInchWidth,
      twelveInchWidth: state => state.stripCurtainsCompleted.twelveInchWidth,
    }),
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
