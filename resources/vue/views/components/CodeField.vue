<script>
import {highlight, languages} from "prismjs/components/prism-core";
import "prismjs/components/prism-clike";
import "prismjs/components/prism-javascript";
import 'prismjs/themes/prism-tomorrow.css';
import {PrismEditor} from "vue-prism-editor";
import "vue-prism-editor/dist/prismeditor.min.css";

export default {
  name: "CodeEditor",
  components: {PrismEditor},
  props: {
    target: {
      type: String,
      required: true
    }
  },
  data() {
    return {
      code: "",
      textarea: null
    }
  },
  methods: {
    highlighter(code) {
      return highlight(code, languages.js);
    },
  },
  mounted() {

    this.textarea = document.querySelector(this.target);

    if (!this.target) {
      alert("Please set ID for this field");
      return;
    }
    this.code = this.textarea.value;
  },
  watch: {
    code(value) {
      if (this.textarea && this.textarea.value !== value) {
        this.textarea.value = value;
      }
    }
  }
}
</script>

<template>
  <prism-editor
      class="my-editor language-xml-doc"
      v-model="code"
      :highlight="highlighter"
      :line-numbers="true"
  ></prism-editor>
</template>

