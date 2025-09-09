<template>
    <div class="input-popover popover fade show bs-popover-left" role="tooltip">
        <div class="arrow" style="top: 34px;"></div>
        <h3 class="popover-header text-warning position-relative">LENGTH OF
            STRIP IN INCHES
            <div class="close-popover text-danger" @click="closeModel" title="Close">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x-circle"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
        </div>
        </h3>
        <div class="modal-body">
            <div class="border rounded-md d-flex align-items-center justify-content-between pr-3"
                :class="{ 'border border-warning': validationMsg }">
                <input
                    type="text"
                    autofocus
                    placeholder="0"
                    @keyup="getStripLength"
                    @keyup.enter="handleEnter"
                    @keydown.tab.prevent="handleEnter"
                    id="modalfocus"
                    class="form-control w-100 shadow-none"
                />
                <div>Inches</div>
            </div>
            <div class="d-flex justify-content-between d-md-block d-lg-none">
                <button type="button" class="btn btn-sm m-0 text-danger mt-2" @click="closeModel">Cancel</button>
                <button type="button" class="btn  bg-success btn-sm m-0 text-white mt-2" @click="closeModel">Confirm</button>
            </div>
            <small v-if="!stripLengthValidationMsg">Please type your measurement and press enter.</small>

            <div v-if="stripLengthValidationMsg">
                <div class="popover-body">Oops! It seems like you've entered an incorrect value. Please enter a valid number
              in the input field.<br/>
               <span class="text-success">The acceptable Number Range is {{ stripReplacementType.low }} to {{ stripReplacementType.heigh }}</span></div>
            </div>
        </div>
        <div class="ar-bg-shadow" @click="closeModel"></div>
    </div>

</template>
<script>
import { mapActions, mapState } from 'vuex';
export default {
    name: 'CustomModal',
    props: ['step', 'closeModel', 'confirmModel' , 'getStripLength'],
    data(){
        return{
          validationMsg:true,
        }
    },
    methods:{
        handleEnter(){
            if (this.stripLengthValidationMsg) {
                return;
            }

            this.confirmModel();
        }
    },
    computed:{
        ...mapState('stripCurtains', ['stripLengthValidationMsg','stripReplacementType']),
    }
}
</script>
<style scoped>
.form-control:focus {
    border: none;
}

.popover-input-two {
    left: -11% !important;
    top: 12% !important;
}

.popover-input-one {
    left: 14% !important;
    top: 27% !important;
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
.popover {
  top: -170% !important;
  left: 97% !important;
  width: 100% !important;
}

.input-popover .arrow {
  left: -3% !important;
  transform: rotate(180deg) !important;
}
.close-popover{
    position: absolute;
    display: block;
    right: -5%;
    top: -50%;
    width: 17px;
    height: 26px;
    cursor: pointer;
    opacity: 0.7;
}
@media (max-width: 768px){
    .input-popover {
        left: 1% !important;
        right: 1%;
        top: 194% !important;
        max-width: 100%;
    }

    .input-popover .arrow{
        display: none;
    }
}
</style>
