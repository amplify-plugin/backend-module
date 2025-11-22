<script>
import {highlight, languages} from "prismjs/components/prism-core";
import "prismjs/components/prism-clike";
import "prismjs/components/prism-javascript";
import 'prismjs/themes/prism-tomorrow.css';
import {PrismEditor} from "vue-prism-editor";
import "vue-prism-editor/dist/prismeditor.min.css";

export default {
    name: "EnvVariableEditor",
    components: {PrismEditor},
    props: [
        'url', 'content', 'saveAction', 'backUrl', 'errors', 'csrfToken'],
    data() {

        return {
            variables: this.content,
        }
    },
    methods: {
        saveData() {

        },
        highlighter(code) {
            return highlight(code, languages.js); //returns html
        },
    },
    watch: {
        // variables: (value) => this.$refs.envValues.value = value
    }
}
</script>

<template>
    <form method="post" :action="url">
        <input type="hidden" name="_token" :value="csrfToken"/>
        <textarea class="d-none" name="content" v-model="variables"/>
        <div class="form-group">
            <slot name="header"/>
            <prism-editor
                class="my-editor language-xml-doc"
                v-model="variables"
                :highlight="highlighter"
                :line-numbers="true"
            ></prism-editor>
            <small v-if="errors?.content?.length > 0" class="text-danger mt-3">
                {{ errors.content[0] ?? '' }}
            </small>
            <slot name="footer"/>
        </div>
        <div id="saveActions" class="form-group mb-0">
            <input type="hidden" name="save_action" value="save_and_back" v-model="actionType">
            <div class="btn-group" role="group">
                <button type="submit" class="btn btn-success">
                    <i class="la la-save" role="presentation" aria-hidden="true"></i>
                    <span>Save</span>
                </button>
            </div>
            <a :href="backUrl" class="btn btn-default"><span
                class="la la-ban"></span> &nbsp;Cancel</a>
        </div>
    </form>
</template>

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

pre.prism-editor__editor {
    color: #ffc107 !important;
}

prism-editor__container > textarea {
    display: none;
}
</style>

