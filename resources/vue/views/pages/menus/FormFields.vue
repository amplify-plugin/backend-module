<template>
    <div>
        <div class="form-group">
            <label>
                Name
                <span class="text-danger">*</span>
            </label>
            <i name="This field is translatable." class="la la-flag-checkered pull-right" style="margin-top: 3px"></i>

            <input type="text" name="name" v-model="$parent.menu.name" placeholder="Enter menu item name"
                   class="form-control" :class="{ 'is-invalid': $parent.menu.errors.has('name') }"
                   @keypress="$parent.menu.errors.clear('name')"/>
            <small v-if="$parent.menu.errors.has('name')" class="text-danger mt-3">
                {{ $parent.menu.errors.get("name") }}
            </small>
        </div>
        <div class="form-group">
            <label>Visibility For</label>

            <div class="form-check">
                <label class="form-check-label mr-4">
                    <input class="form-check-input" type="checkbox"
                           v-model="$parent.menu.visibility_for.authenticated"/>
                    Authenticated
                </label>
                <label class="form-check-label mr-4">
                    <input class="form-check-input" type="checkbox" v-model="$parent.menu.visibility_for.admin"/>
                    Admin
                </label>
                <label class="form-check-label mr-4">
                    <input class="form-check-input" type="checkbox" v-model="$parent.menu.visibility_for.approver"/>
                    Approver
                </label>
                <label class="form-check-label mr-4">
                    <input class="form-check-input" type="checkbox" v-model="$parent.menu.visibility_for.guest"/>
                    Guest
                </label>
            </div>
        </div>
        <div class="form-group">
            <label>
                Menu Type
                <span class="text-danger">*</span>
            </label>

            <select class="form-control" v-model="$parent.menu.type">
                <option value="default">Default</option>
                <option value="mega-menu">Mega Menu</option>
            </select>
        </div>
        <div class="form-group" v-if="$parent.menu.type == 'default'">
            <label>
                URL Type
                <span class="text-danger">*</span>
            </label>

            <select v-model="$parent.menu.url_type" class="form-control" @change="changeURLType">
                <option value="external" :selected="true">External</option>
                <option value="page">Page</option>
            </select>
        </div>
        <div class="form-group" v-if="$parent.menu.type == 'default' && page">
            <label>
                Page
                <span class="text-danger">*</span>
            </label>
            <select name="page" class="form-control" v-model="$parent.menu.page_id" required>
                <option value="" :selected="true">Select Page</option>
                <option v-for="(page, index) in $parent.pageLists" :key="index" v-bind:value="page.id">
                    {{ page.name }}
                </option>
            </select>
        </div>
        <div class="form-group col-sm-12" v-if="$parent.menu.type == 'default' && !page">
            <label>
                URL
                <span class="text-danger">*</span>
            </label>
            <input type="text" name="url" v-model="$parent.menu.url" placeholder="Enter external url"
                   class="form-control" :class="{ 'is-invalid': $parent.menu.errors.has('url') }"/>
            <small v-if="$parent.menu.errors.has('url')" class="text-danger mt-3">
                {{ $parent.menu.errors.get("url") }}</small>
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
            page: false,
        };
    },
    created() {
        this.page = (this.$parent.menu.url_type === "page");
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
