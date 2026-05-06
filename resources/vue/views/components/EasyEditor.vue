<template>
  <div class="ckeditor-field">
    <ckeditor
      ref="editor"
      :value="value"
      :config="finalConfig"
      :editor-url="editorUrl"
      :type="type"
      :tag-name="tagName"
      :read-only="readOnly"
      :throttle="throttle"
      @input="handleInput"
      @ready="handleReady"
      @focus="$emit('focus', $event)"
      @blur="$emit('blur', $event)"
      @namespaceloaded="handleNamespaceLoaded"
    />
  </div>
</template>

<script>
import CKEditor from "ckeditor4-vue";

export default {
  name: "EasyEditor",

  components: {
    ckeditor: CKEditor.component,
  },

  props: {
    value: {
      type: String,
      default: "",
    },

    config: {
      type: Object,
      default: () => ({}),
    },

    editorUrl: {
      type: String,
      default: "/packages/ckeditor/ckeditor.js",
    },

    type: {
      type: String,
      default: "classic",
    },

    tagName: {
      type: String,
      default: "textarea",
    },

    readOnly: {
      type: Boolean,
      default: false,
    },

    throttle: {
      type: Number,
      default: 200,
    },

    height: {
      type: [Number, String],
      default: 400,
    },

    allowUnsafeHtml: {
      type: Boolean,
      default: true,
    },
  },

  computed: {
    finalConfig() {
      const defaultConfig = {
        height: this.height,

        allowedContent: true,
        disallowedContent: "",
        extraAllowedContent:
          "iframe[*]; div[*]; span[*]; p[*]; a[*]; img[*]; *[id,class,style];",

        protectedSource: this.allowUnsafeHtml
          ? [
              /<script[\s\S]*?<\/script>/gi,
              /<style[\s\S]*?<\/style>/gi,
            ]
          : [],

        extraPlugins: [

          "iframe",
          "justify",
          "colorbutton",
          "font",
          "find",
          "templates",
          "codesnippet",
          "div",
          "forms",
          "smiley",
          "showblocks",
        ].join(","),

        removePlugins: [
          "easyimage",
          "cloudservices",
          "exportpdf",
        ].join(","),

        entities: false,
        basicEntities: false,
        entities_greek: false,
        entities_latin: false,

        autoParagraph: false,
        fillEmptyBlocks: false,

        iframe_attributes: {
          sandbox:
            "allow-scripts allow-same-origin allow-popups allow-forms allow-presentation",
          allowfullscreen: "true",
          frameborder: "0",
        },

        toolbar: [
          {
            name: "document",
            items: ["Source", "-", "Preview", "Print", "Templates"],
          },
          {
            name: "clipboard",
            items: [
              "Cut",
              "Copy",
              "Paste",
              "PasteText",
              "PasteFromWord",
              "-",
              "Undo",
              "Redo",
            ],
          },
          {
            name: "editing",
            items: ["Find", "Replace", "-", "SelectAll"],
          },
          {
            name: "forms",
            items: [
              "Form",
              "Checkbox",
              "Radio",
              "TextField",
              "Textarea",
              "Select",
              "Button",
              "ImageButton",
              "HiddenField",
            ],
          },
          "/",
          {
            name: "basicstyles",
            items: [
              "Bold",
              "Italic",
              "Underline",
              "Strike",
              "Subscript",
              "Superscript",
              "-",
              "RemoveFormat",
            ],
          },
          {
            name: "paragraph",
            items: [
              "NumberedList",
              "BulletedList",
              "-",
              "Outdent",
              "Indent",
              "-",
              "Blockquote",
              "CreateDiv",
              "-",
              "JustifyLeft",
              "JustifyCenter",
              "JustifyRight",
              "JustifyBlock",
            ],
          },
          {
            name: "links",
            items: ["Link", "Unlink", "Anchor"],
          },
          {
            name: "insert",
            items: [
              "Image",
              "Table",
              "HorizontalRule",
              "Smiley",
              "SpecialChar",
              "Iframe",
              "CodeSnippet",
            ],
          },
          "/",
          {
            name: "styles",
            items: ["Styles", "Format", "Font", "FontSize"],
          },
          {
            name: "colors",
            items: ["TextColor", "BGColor"],
          },
          {
            name: "tools",
            items: ["Maximize", "ShowBlocks"],
          },
        ],
      };

      return {
        ...defaultConfig,
        ...this.config,
      };
    },
  },

  methods: {
    handleInput(data) {
      this.$emit("input", data);
      this.$emit("change", data);
    },

    handleReady(editor) {
      this.editorInstance = editor;
      this.$emit("ready", editor);
    },

    handleNamespaceLoaded(CKEDITOR) {
      this.$emit("namespaceloaded", CKEDITOR);
    },

    getEditor() {
      return this.editorInstance || null;
    },

    getData() {
      return this.editorInstance ? this.editorInstance.getData() : this.value;
    },

    setData(data = "") {
      if (this.editorInstance) {
        this.editorInstance.setData(data);
      }
    },

    insertHtml(html = "") {
      if (this.editorInstance) {
        this.editorInstance.insertHtml(html);
      }
    },

    insertText(text = "") {
      if (this.editorInstance) {
        this.editorInstance.insertText(text);
      }
    },

    focus() {
      if (this.editorInstance) {
        this.editorInstance.focus();
      }
    },
  },

  data() {
    return {
      editorInstance: null,
    };
  },
};
</script>
