<template>
    <div class="input-popover popover fade show bs-popover-left" role="tooltip">
        <div class="arrow" style="top: 34px;"></div>
        <h3 class="popover-header text-warning">LENGTH OF MATERIAL IN INCHES</h3>

        <div class="modal-body">
            <div class="border rounded-md d-flex align-items-center justify-content-between pr-3"
                :class="{ 'border border-warning': stripLengthValidationMsg }">
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
                <div>INCHES</div>
            </div>
            <div class="d-flex justify-content-between d-md-block d-lg-none">
                <button type="button" class="btn btn-sm m-0 text-danger mt-2" @click="closeModel">Cancel</button>
                <button type="button" class="btn  bg-success btn-sm m-0 text-white mt-2" @click="closeModel">Confirm</button>
            </div>
            <div class="popover-body" v-if="stripLengthValidationMsg">Oops! It seems like you've entered an incorrect value. Please enter a valid number
              in the input field.<br/>
               <span class="text-success">The acceptable Number Range is {{ stripReplacementType.low }} to {{ stripReplacementType.heigh }}</span></div>
        </div>
        <div class="ar-bg-shadow" @click="closeModel"></div>
    </div>

</template>
<script>
import { mapState } from 'vuex';
export default {
    name: 'CustomModal',
    props: ['closeModel', 'confirmModel', 'getStripLength'],
    data() {
        return {
            validationMsg: true,
            showText:false
        }
    },
    methods:{
        handleEnter(){
            this.confirmModel();
        }
    },
    computed: {
        ...mapState('stripCurtainsBulk', ['stripLengthValidationMsg', 'stripReplacementType']),
    }
}

</script>
<style scoped>
.form-control:focus {
    border: none;
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
  top: -78% !important;
  left: 104% !important;
  min-width: 300px !important;
}
.input-popover .arrow {
  left: -3% !important;
  transform: rotate(180deg) !important;
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
