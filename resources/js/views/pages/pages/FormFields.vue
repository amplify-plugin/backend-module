<template>
    <div class="card">
        <div class="card-body">
            <div class="form-group">
                <label :class="{'error-color': validationErrors.name}">
                    Name
                    <span class="text-danger font-weight-bold">*</span>
                </label>
                <i title="This field is translatable."
                   class="la la-flag-checkered pull-right"
                   style="margin-top: 3px;"></i>
                <input @input="convertNameToSlug($parent.page.name); createBreadcrumbFromName($parent.page.name)"
                       type="text"
                       name="page_name"
                       required
                       v-model="$parent.page.name"
                       placeholder="Enter page name"
                       class="form-control" :class="{'is-invalid': $parent.validationErrors.name}"
                       :disabled="$parent.method === 'get'"
                >
                <small v-if="validationErrors.name" class="text-danger mt-3">
                    {{ validationErrors.name[0] }}
                </small>
            </div>
            <div class="form-group mb-0">
                <label :class="{'error-color': validationErrors.content}">
                    Content
                    <span class="text-danger font-weight-bold">*</span>
                </label>
                <prism-editor
                    class="my-editor language-xml-doc"
                    v-model="$parent.page.content"
                    :highlight="highlighter"
                    :line-numbers="true"
                    :readonly="$parent.method === 'get'"
                ></prism-editor>
                <small v-if="validationErrors.content" class="text-danger mt-3">
                    {{ validationErrors.content[0] }}
                </small>
            </div>
        </div>
    </div>
</template>
<script>

import {PrismEditor} from "vue-prism-editor";
import "vue-prism-editor/dist/prismeditor.min.css";
import {highlight, languages} from "prismjs/components/prism-core";
import "prismjs/components/prism-clike";
import "prismjs/components/prism-javascript";
import "prismjs/themes/prism-okaidia.css";

export default {
    name: "FormFields",
    props: [],
    data() {
        return {
            validationErrors: ""
        }
    },
    components: {PrismEditor},
    methods: {
        convertNameToSlug(Name) {
            clearTimeout(this.timer);
            this.timer = setTimeout(() => {
                let slug = Name.trim()
                    .toLowerCase()
                    .replace(/-/g, ' ')
                    .replace(/[^\w ]+/g, '')
                    .replace(/ +/g, '-');

                this.checkPageSlugUnique(slug);
            }, 500)
        },

        checkPageSlugUnique(slug) {
            let params = {};
            if (this.method === 'put') {
                params.id = this.page.id
            }
            params.slug = slug;

            axios.post(`/admin/page/fetch/page-slug`, params)
                .then(response => {
                    this.$parent.page.slug = response.data.slug;
                })
                .catch((err) => {
                    console.error(err);
                });
        },

        highlighter(code) {
            return highlight(code, languages.js); //returns html
        },
        createBreadcrumbFromName(Name) {
            console.log(Name);
            if (this.$parent.method !== 'put') {
                this.$parent.page.breadcrumb_title = Name;
            }
        }
    },
}
</script>
<style lang="scss">
// required class
.my-editor {
    background: #2d2d2d;
    color: #ccc !important;
    font-family: Consolas, Menlo, Courier, monospace;
    font-size: 14px;
    line-height: 1.5;
    padding: 5px;
    border-radius: 4px !important;
    min-height: 350px !important;
}

// optional
.prism-editor__textarea:focus {
    outline: none;
}

pre.prism-editor__editor{
    color: #ffc107!important;
}
</style>
