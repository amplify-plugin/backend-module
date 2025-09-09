<template>
  <div>
    <div class="form-group col-sm-12">
      <div v-if="$parent.config.errors.any()" class="alert alert-danger pb-0">
        <ul class="list-unstyled">
          <div v-for="(error, index) in $parent.config.errors" :key="index">
            <li v-for="(message, index) in error" :key="index">
              <i class="la la-info-circle"></i>
              {{ message[0] }}
            </li>
          </div>
        </ul>
      </div>
    </div>

    <!-- text input -->
    <div class="form-group col-sm-12 required">
      <label>
        Name
        <span class="text-danger font-weight-bold">*</span>
      </label>

      <input
        type="text"
        name="name"
        v-model="$parent.config.name"
        placeholder="Enter config name"
        class="form-control"
        :class="{ 'is-invalid': $parent.config.errors.has('name') }"
      />
      <small class="text-danger mt-3" v-if="$parent.config.errors.has('name')">
        {{ $parent.config.errors.get("name") }}
      </small>
    </div>

    <div class="form-group col-sm-12 required">
      <label>
        Key
        <span class="text-danger font-weight-bold">*</span>
      </label>

      <input
        type="text"
        name="key"
        v-model="$parent.config.key"
        placeholder="Enter config key"
        class="form-control"
        :class="{ 'is-invalid': $parent.config.errors.has('key') }"
      />
    <small class="text-danger mt-3" v-if="$parent.config.errors.has('key')">
        {{ $parent.config.errors.get("key") }}
      </small>
    </div>

    <div class="form-group col-sm-12 required">
      <label>
        Value Type
        <span class="text-danger font-weight-bold">*</span>
      </label>

      <select name="value_type" class="form-control" v-model="$parent.config.value_type">
        <option value="string">String</option>
        <option value="image">Image</option>
      </select>
      <small class="text-danger mt-3" v-if="$parent.config.errors.has('value_type')">
        {{ $parent.config.errors.get("value_type") }}
      </small>

    </div>
  </div>
</template>

<script>
import _ from "lodash";

export default {
  name: "FormFields",
  props: [],
  data() {
    return {
      validationErrors: "",
    };
  },
  created() {
    //
  },
  components: {},
  methods: {
    changeURLType(e) {
      let urlType = e.target.value;
      if (urlType == "page") {
        this.$parent.menu.url = "";
        this.page = true;
      } else {
        this.page = false;
      }
    },
  },
  watch: {},
};
</script>

