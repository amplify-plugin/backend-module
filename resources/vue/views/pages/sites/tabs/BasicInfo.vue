<template>
    <div role="tabpanel" class="tab-pane  active" id="tab_basic-info">
        <div v-if="$parent.validationErrors" class="alert alert-danger pb-0">
            <ul class="list-unstyled">
                <li v-for="error in $parent.validationErrors"><i class="la la-info-circle"></i>
                    {{ error[0] }}
                </li>
            </ul>
        </div>
        <div class="row">
            <div class="form-group col-sm-12 required">
                <label :class="{'text-danger': $parent.validationErrors.site_name}">Site Name<span
                    class="text-danger">*</span></label>

                <input @input="$parent.removeError('site_name')" type="text"
                       v-model="$parent.site.site_name"
                       class="form-control"
                       :class="{'is-invalid': $parent.validationErrors.site_name}">

                <small v-if="$parent.validationErrors.site_name"
                       class="text-danger mt-3">{{ $parent.validationErrors.site_name[0] }}</small>
            </div>

            <div class="form-group col-sm-12">
                <label :class="{'text-danger': $parent.validationErrors.site_description}">Site Description</label>
                <textarea v-model="$parent.site.site_description"
                          @input="$parent.removeError('site_description');"
                          class="form-control"
                          :class="{'is-invalid': $parent.validationErrors.site_description}"
                          rows="3">
                </textarea>

                <small v-if="$parent.validationErrors.site_description"
                       class="text-danger mt-3">{{ $parent.validationErrors.site_description[0] }}</small>
            </div>

            <div class="form-group col-sm-12 required">
                <label :class="{'text-danger': $parent.validationErrors.url}">Url</label>

                <input @input="$parent.removeError('url')" type="text"
                       v-model="$parent.site.url"
                       class="form-control"
                       :class="{'is-invalid': $parent.validationErrors.url}">

                <small v-if="$parent.validationErrors.url"
                       class="text-danger mt-3">{{ $parent.validationErrors.url[0] }}</small>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name      : "BasicInfo",
}
</script>

<style scoped>

</style>
