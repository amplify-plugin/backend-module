<template>
  <div>
    <div class="cs-modal" id="cs-modal">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 bg-white shadow-lg">
          <div class="modal-header border-0">
            <h5 class="modal-title text-uppercase">Modal title</h5>
          </div>
          <div class="modal-body">
            <div class="border rounded-md d-flex align-items-center justify-content-between pr-3">
              <select class="border-0 form-control">
                <option v-for="(item,index) in range" :key="index" :value="item">{{ item }}</option>
              </select>
              <div>Inches</div>
            </div>
            <div class="py-2"></div>
            <div class="border rounded-md d-flex align-items-center justify-content-between pr-3">
              <select class="border-0 form-control">
                <option v-for="(fract , val) in fractional" :key="index" :value="val">{{ fract }}</option>
              </select>
              <div>Inches</div>
            </div>
          </div>
          <div class="modal-footer border-0">
            <button @click="closeModel" type="button" class="btn btn-outline-danger" data-dismiss="modal">
              cancel
            </button>
            <button @click="confirmModel" type="button" class="btn btn-success">Confirm</button>
          </div>
        </div>
      </div>
    </div>
    <div class="position-fixed w-100 h-100 left-0 top-0 cs-modal-backdrop"></div>
  </div>
</template>
<script>
export default {
  name: 'CustomModal',
  props: ['range','fractional','step', 'closeModel', 'confirmModel']
}

</script>

