<template>
  <div :class="orderStep === 3 ? 'order-step-block' : 'order-step-d-none'" class="row mb-4 mb-sm-5"
    id="evaporator_coils_seven">
    <div class="col-md-12">
      <div class="title mb-3 d-flex align-items-center gap-2">
        <i :class="[$parent.completedSection.includes(7) ? 'text-success' : 'text-black-50']"
          class="icon-circle-check"></i>
        <h5 class="mb-0 text-uppercase fw-600"
          :class="[$parent.completedSection.includes(7) ? 'text-success' : 'text-danger']">Step 7</h5>
      </div>

      <div class="border rounded-md p-3">
        <form class="row g-3">
          <div class="col-md-4 mb-4">
            <label for="contactName" class="form-label text-uppercase">CONTACT NAME <span
                class="text-danger">*</span></label>
            <input :disabled="!$parent.completedSection.includes(6)" v-model="$parent.coilItems.contact_name"
              type="text" class="form-control" id="contactName" placeholder="Input your name ">
          </div>
          <div class="col-md-4 mb-4">
            <label for="contactMethod" class="form-label text-uppercase">Method of contact <span
                class="text-danger">*</span></label>
            <input :disabled="!$parent.completedSection.includes(6)" v-model="$parent.coilItems.method_of_contact"
              type="email" class="form-control" id="contactMethod" placeholder="Input your email address">
          </div>
          <div class="col-md-4 mb-4">
            <label for="companyName" class="form-label text-uppercase">Company Name <span
                class="text-danger">*</span></label>
            <input :disabled="!$parent.completedSection.includes(6)" v-model="$parent.coilItems.company_name"
              type="text" class="form-control" id="companyName" placeholder="Input your name">
          </div>

          <div class="col-md-4 mb-4">
            <label for="city" class="form-label text-uppercase">CITY <span class="text-danger">*</span></label>
            <input :disabled="!$parent.completedSection.includes(6)" v-model="$parent.coilItems.city" type="text"
              class="form-control" id="city" placeholder="Input your city">
          </div>

          <div class="col-md-4 mb-4">
            <label for="city" class="form-label text-uppercase">Country <span class="text-danger">*</span></label>
            <multiselect class="form-select form-select-lg mb-3" @select="selectCountry" name="tags" label="name"
              track-by="id" placeholder="Select Country" :options="$parent.countries"
              v-model="$parent.coilItems.country">
            </multiselect>
          </div>
          <div class="col-md-4 mb-4">
            <label for="state" class="form-label text-uppercase">STATE <span class="text-danger">*</span></label>
            <multiselect class="form-select form-select-lg mb-3" name="tags" label="name" track-by="id"
              placeholder="Select State" :options="filteredStates" v-model="$parent.coilItems.state"
              @search-change="searchState">
            </multiselect>
          </div>
          <div class="col-md-6 mb-6">
            <label for="zipcode" class="form-label text-uppercase">ZIPCODE <span class="text-danger">*</span></label>
            <input :disabled="!$parent.completedSection.includes(6)" v-model="$parent.coilItems.zipcode" type="text"
              class="form-control" id="zipcode" placeholder="Input your zip code">
          </div>

          <div class="col-md-6 mb-6">
            <label for="address" class="form-label text-uppercase">Address <span class="text-danger">*</span></label>
            <input :disabled="!$parent.completedSection.includes(6)" v-model="$parent.coilItems.address" type="text"
              class="form-control" id="address" placeholder="Input your address">
          </div>

          <div class="col-md-12 mb-4">
            <label for="notes" class="form-label text-uppercase">ADDITIONAL NOTES</label>
            <textarea :disabled="!$parent.completedSection.includes(6)" v-model="$parent.coilItems.note" name=""
              class="form-control" placeholder="Enter a description..." id="notes" rows="4"></textarea>
          </div>

          <div class="col-12">
            <button type="button" class="d-none d-sm-block btn btn-primary" @click="$parent.submit"
              :disabled="!$parent.completedSection.includes(6)">SUBMIT FOR QUOTE</button>
          </div>
        </form>
      </div>
    </div>
    <permission :isShoing="true">
      <div class="col-md-12 mt-4">
        <div class="mb-5">
          <small class="text-danger text-uppercase mb-3 d-block">Required Field</small>
          <div class="d-flex gap-2">
            <h6 class="mb-3">Note: </h6>
            <div>
              <p class="mb-2">Please <span class="text-danger">carefully check</span> your quote. All custom items
                are
                non-returnable.</p>
              <p class="mb-2">&#8226; An RHS sales representative will contact you the next business day to
                confirm
                your custom evaporator coil quote.</p>
              <p class="mb-2">&#8226; If your quote is approved and updated to an order, depending on job
                requirements, custom coil manufacture times range between 4 and 6 weeks.</p>
            </div>
          </div>
        </div>
      </div>
    </permission>
  </div>
</template>
<script>
import 'vue-multiselect/dist/vue-multiselect.min.css';
import Multiselect from "vue-multiselect";
import { mapActions, mapState } from 'vuex';
import permission from './inc/permission.vue';
export default {
  name: 'step-7',
  data() {
    return {
      filteredStates: [],
    }
  },
  props: ['orderStep', 'stepSeven', 'stepSix', 'states'],
  components: { Multiselect, permission },
  mounted() {
    this.getCountryStateList();
  },
  methods: {
    ...mapActions('evaporatorCoils', ['getCountryStateList']),
    selectCountry(event) {
      let iso = event.iso2;
      let items = this.states.filter(function (item) {
        return item.country_code === iso;
      });

      this.filteredStates = items;
    },
    searchState(query) {
      this.filteredStates = this.states.filter(state => {
        const escapedSubstr = query.toLowerCase().replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
        const pattern = new RegExp('^' + escapedSubstr);
        return pattern.test(state.name.toLowerCase());
      });
    },
  },
  watch: {
    async states(newval, prev) {
      let self = this;
      let data = await self.states.filter(
        (option) => option.country_code == self.$parent.defaultCountryCode,
      );
      self.filteredStates = data;
    },
  }
}
</script>
