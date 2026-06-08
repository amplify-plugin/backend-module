"use strict";
(self["webpackChunkbackend"] = self["webpackChunkbackend"] || []).push([["resources_vue_views_pages_templates_Install_vue"],{

/***/ "../../node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/pages/templates/Install.vue?vue&type=script&lang=js":
/*!**********************************************************************************************************************************************************************************************************************************************!*\
  !*** ../../node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/pages/templates/Install.vue?vue&type=script&lang=js ***!
  \**********************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var lodash__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! lodash */ "../../node_modules/lodash/lodash.js");
/* harmony import */ var lodash__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(lodash__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _mixin_saveAction_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../../../mixin/saveAction.js */ "./resources/vue/mixin/saveAction.js");
function _regenerator() { /*! regenerator-runtime -- Copyright (c) 2014-present, Facebook, Inc. -- license (MIT): https://github.com/babel/babel/blob/main/packages/babel-helpers/LICENSE */ var e, t, r = "function" == typeof Symbol ? Symbol : {}, n = r.iterator || "@@iterator", o = r.toStringTag || "@@toStringTag"; function i(r, n, o, i) { var c = n && n.prototype instanceof Generator ? n : Generator, u = Object.create(c.prototype); return _regeneratorDefine2(u, "_invoke", function (r, n, o) { var i, c, u, f = 0, p = o || [], y = !1, G = { p: 0, n: 0, v: e, a: d, f: d.bind(e, 4), d: function d(t, r) { return i = t, c = 0, u = e, G.n = r, a; } }; function d(r, n) { for (c = r, u = n, t = 0; !y && f && !o && t < p.length; t++) { var o, i = p[t], d = G.p, l = i[2]; r > 3 ? (o = l === n) && (u = i[(c = i[4]) ? 5 : (c = 3, 3)], i[4] = i[5] = e) : i[0] <= d && ((o = r < 2 && d < i[1]) ? (c = 0, G.v = n, G.n = i[1]) : d < l && (o = r < 3 || i[0] > n || n > l) && (i[4] = r, i[5] = n, G.n = l, c = 0)); } if (o || r > 1) return a; throw y = !0, n; } return function (o, p, l) { if (f > 1) throw TypeError("Generator is already running"); for (y && 1 === p && d(p, l), c = p, u = l; (t = c < 2 ? e : u) || !y;) { i || (c ? c < 3 ? (c > 1 && (G.n = -1), d(c, u)) : G.n = u : G.v = u); try { if (f = 2, i) { if (c || (o = "next"), t = i[o]) { if (!(t = t.call(i, u))) throw TypeError("iterator result is not an object"); if (!t.done) return t; u = t.value, c < 2 && (c = 0); } else 1 === c && (t = i["return"]) && t.call(i), c < 2 && (u = TypeError("The iterator does not provide a '" + o + "' method"), c = 1); i = e; } else if ((t = (y = G.n < 0) ? u : r.call(n, G)) !== a) break; } catch (t) { i = e, c = 1, u = t; } finally { f = 1; } } return { value: t, done: y }; }; }(r, o, i), !0), u; } var a = {}; function Generator() {} function GeneratorFunction() {} function GeneratorFunctionPrototype() {} t = Object.getPrototypeOf; var c = [][n] ? t(t([][n]())) : (_regeneratorDefine2(t = {}, n, function () { return this; }), t), u = GeneratorFunctionPrototype.prototype = Generator.prototype = Object.create(c); function f(e) { return Object.setPrototypeOf ? Object.setPrototypeOf(e, GeneratorFunctionPrototype) : (e.__proto__ = GeneratorFunctionPrototype, _regeneratorDefine2(e, o, "GeneratorFunction")), e.prototype = Object.create(u), e; } return GeneratorFunction.prototype = GeneratorFunctionPrototype, _regeneratorDefine2(u, "constructor", GeneratorFunctionPrototype), _regeneratorDefine2(GeneratorFunctionPrototype, "constructor", GeneratorFunction), GeneratorFunction.displayName = "GeneratorFunction", _regeneratorDefine2(GeneratorFunctionPrototype, o, "GeneratorFunction"), _regeneratorDefine2(u), _regeneratorDefine2(u, o, "Generator"), _regeneratorDefine2(u, n, function () { return this; }), _regeneratorDefine2(u, "toString", function () { return "[object Generator]"; }), (_regenerator = function _regenerator() { return { w: i, m: f }; })(); }
function _regeneratorDefine2(e, r, n, t) { var i = Object.defineProperty; try { i({}, "", {}); } catch (e) { i = 0; } _regeneratorDefine2 = function _regeneratorDefine(e, r, n, t) { if (r) i ? i(e, r, { value: n, enumerable: !t, configurable: !t, writable: !t }) : e[r] = n;else { var o = function o(r, n) { _regeneratorDefine2(e, r, function (e) { return this._invoke(r, n, e); }); }; o("next", 0), o("throw", 1), o("return", 2); } }, _regeneratorDefine2(e, r, n, t); }
function asyncGeneratorStep(n, t, e, r, o, a, c) { try { var i = n[a](c), u = i.value; } catch (n) { return void e(n); } i.done ? t(u) : Promise.resolve(u).then(r, o); }
function _asyncToGenerator(n) { return function () { var t = this, e = arguments; return new Promise(function (r, o) { var a = n.apply(t, e); function _next(n) { asyncGeneratorStep(a, r, o, _next, _throw, "next", n); } function _throw(n) { asyncGeneratorStep(a, r, o, _next, _throw, "throw", n); } _next(void 0); }); }; }


function updateProgress(value) {
  var progressBar = document.getElementById('progress-bar');
  progressBar.innerText = value + '%';
  progressBar.style.width = value + '%';
  progressBar.setAttribute('aria-valuenow', value);
}
function updateBrowseLabel(text) {
  document.getElementById("browse-button").innerText = text;
}
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  name: "TemplateInstall",
  mixins: [_mixin_saveAction_js__WEBPACK_IMPORTED_MODULE_1__["default"]],
  data: function data() {
    return {
      backUrl: '/admin/theme',
      chunkFileUploadUrl: '/admin/theme/chunk-upload',
      getInstallationInfoUrl: '/admin/theme/installation-info',
      installTemplateUrl: '/admin/theme/install-template',
      templateInfo: null,
      uploader: {},
      filename: 'Browse files',
      validationErrors: {}
    };
  },
  mounted: function mounted() {
    this.setupPlupload();
  },
  methods: {
    setupPlupload: function setupPlupload() {
      var self = this;
      this.uploader = new plupload.Uploader({
        url: self.chunkFileUploadUrl,
        chunk_size: '1mb',
        runtimes: 'html5',
        browse_button: "browse-button",
        container: "container",
        filters: {
          max_file_size: '200mb',
          mime_types: [{
            title: "Zip files",
            extensions: "zip"
          }]
        },
        headers: {
          'Accept': 'application/json',
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        init: {
          FilesAdded: function FilesAdded(up, files) {
            up.files.splice(0, up.files.length - 1);
            updateBrowseLabel(files[0].name);
          },
          FileUploaded: function FileUploaded(up, files, res) {
            var data = JSON.parse(res.response);
            new Noty({
              text: data.result.message,
              type: "success"
            }).show();
            self.setUpInstallationProcess();
          },
          UploadProgress: function UploadProgress(up, files) {
            updateProgress(files.percent);
          },
          Error: function Error(up, args) {
            updateProgress(0);
            updateBrowseLabel('Browse files');
            new Noty({
              text: "Something went wrong.",
              type: "danger"
            }).show();
          }
        }
      });
      this.uploader.init();
    },
    startUpload: function startUpload() {
      if (this.uploader.files.length) {
        this.$refs.upload.disabled = true;
        this.$refs.upload.textContent = "Loading...";
        this.templateInfo = null;
        this.uploader.start();
      } else {
        new Noty({
          text: "Please select a template.",
          type: "danger"
        }).show();
      }
    },
    setUpInstallationProcess: function setUpInstallationProcess() {
      var _this = this;
      axios.get(this.getInstallationInfoUrl).then(function (res) {
        _this.templateInfo = res.data;
      })["catch"](function (err) {
        updateProgress(0);
        updateBrowseLabel('Browse files');
        new Noty({
          text: err.response.data.message,
          type: "danger"
        }).show();
      });
      this.$refs.upload.disabled = false;
      this.$refs.upload.textContent = "Upload";
    },
    installTemplate: function installTemplate() {
      var _this2 = this;
      return _asyncToGenerator(/*#__PURE__*/_regenerator().m(function _callee() {
        return _regenerator().w(function (_context) {
          while (1) switch (_context.n) {
            case 0:
              _this2.$refs.install.disabled = true;
              _this2.$refs.install.textContent = "Installing...";
              _context.n = 1;
              return axios.post(_this2.installTemplateUrl).then(function (res) {
                new Noty({
                  text: res.data.message,
                  type: "success"
                }).show();
              })["catch"](function (err) {
                new Noty({
                  text: err.response.data.message,
                  type: "danger"
                }).show();
              });
            case 1:
              _this2.$refs.install.disabled = false;
              _this2.$refs.install.textContent = "Install";
            case 2:
              return _context.a(2);
          }
        }, _callee);
      }))();
    }
  },
  watch: {
    "this.uploader": function thisUploader(value) {
      if (value.length == 0) {
        this.filename = 'Browse files';
      }
      console.log(value);
    }
  }
});

/***/ }),

/***/ "../../node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!../../node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/pages/templates/Install.vue?vue&type=template&id=34a301b0&scoped=true":
/*!*************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ../../node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!../../node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/pages/templates/Install.vue?vue&type=template&id=34a301b0&scoped=true ***!
  \*************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   render: () => (/* binding */ render),
/* harmony export */   staticRenderFns: () => (/* binding */ staticRenderFns)
/* harmony export */ });
var render = function render() {
  var _vm = this,
    _c = _vm._self._c;
  return _c('form', {
    attrs: {
      "method": "post",
      "action": _vm.backUrl
    },
    on: {
      "submit": function submit($event) {
        $event.preventDefault();
      }
    }
  }, [!_vm.templateInfo ? _c('div', {
    staticClass: "card"
  }, [_c('div', {
    staticClass: "card-body"
  }, [_c('div', {
    staticClass: "rounded",
    attrs: {
      "id": "container"
    }
  }, [_c('button', {
    staticClass: "btn btn-link",
    attrs: {
      "type": "button",
      "id": "browse-button"
    }
  }, [_vm._v("\n                    " + _vm._s(_vm.filename) + "\n                ")])]), _vm._v(" "), _vm._m(0), _vm._v(" "), _c('button', {
    ref: "upload",
    staticClass: "btn btn-primary btn-block mt-3",
    attrs: {
      "type": "button"
    },
    on: {
      "click": _vm.startUpload
    }
  }, [_vm._v("Upload\n            ")])])]) : _vm._e(), _vm._v(" "), _vm.templateInfo ? _c('div', {
    staticClass: "card mt-2"
  }, [_vm._m(1), _vm._v(" "), _c('div', {
    staticClass: "card-body"
  }, [_c('div', {
    staticClass: "table-responsive"
  }, [_c('table', {
    staticClass: "table"
  }, [_c('tr', [_c('td', [_vm._v("Template Name")]), _vm._v(" "), _c('td', [_vm._v(_vm._s(_vm.templateInfo.name))])]), _vm._v(" "), _c('tr', [_c('td', [_vm._v("Author")]), _vm._v(" "), _c('td', [_vm._v(_vm._s(_vm.templateInfo.author))])]), _vm._v(" "), _c('tr', [_c('td', [_vm._v("Preview")]), _vm._v(" "), _c('td', {
    staticClass: "text-center"
  }, [_c('img', {
    staticClass: "img-fluid",
    attrs: {
      "src": _vm.templateInfo.template_banner
    }
  })])])])]), _vm._v(" "), _c('button', {
    ref: "install",
    staticClass: "btn btn-primary btn-block",
    attrs: {
      "type": "button"
    },
    on: {
      "click": _vm.installTemplate
    }
  }, [_vm._v("\n                Install\n            ")])])]) : _vm._e()]);
};
var staticRenderFns = [function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c('div', {
    staticClass: "progress"
  }, [_c('div', {
    staticClass: "progress-bar progress-bar-striped progress-bar-animated bg-primary",
    staticStyle: {
      "width": "0"
    },
    attrs: {
      "role": "progressbar",
      "id": "progress-bar",
      "aria-valuenow": "0",
      "aria-valuemin": "0",
      "aria-valuemax": "100"
    }
  }, [_vm._v("0%\n                ")])]);
}, function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c('div', {
    staticClass: "card-header"
  }, [_c('h4', {
    staticClass: "card-title"
  }, [_vm._v("Template Detail")])]);
}];
render._withStripped = true;


/***/ }),

/***/ "../../node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-12.use[1]!../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-12.use[2]!../../node_modules/sass-loader/dist/cjs.js??clonedRuleSet-12.use[3]!../../node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/pages/templates/Install.vue?vue&type=style&index=0&id=34a301b0&scoped=true&lang=scss":
/*!*************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ../../node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-12.use[1]!../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-12.use[2]!../../node_modules/sass-loader/dist/cjs.js??clonedRuleSet-12.use[3]!../../node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/pages/templates/Install.vue?vue&type=style&index=0&id=34a301b0&scoped=true&lang=scss ***!
  \*************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_laravel_mix_node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../../../../../../node_modules/laravel-mix/node_modules/css-loader/dist/runtime/api.js */ "../../node_modules/laravel-mix/node_modules/css-loader/dist/runtime/api.js");
/* harmony import */ var _node_modules_laravel_mix_node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_laravel_mix_node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0__);
// Imports

var ___CSS_LOADER_EXPORT___ = _node_modules_laravel_mix_node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0___default()(function(i){return i[1]});
// Module
___CSS_LOADER_EXPORT___.push([module.id, ".progress[data-v-34a301b0] {\n  border-radius: 0.5rem;\n  border-top-left-radius: 0 !important;\n  border-top-right-radius: 0 !important;\n  border: 3px dashed rgba(0, 40, 100, 0.12) !important;\n  border-top: 0 !important;\n}\n.progress[data-v-34a301b0]:hover {\n  background-color: rgba(0, 40, 100, 0.12);\n}\n#container[data-v-34a301b0] {\n  height: 250px;\n  border: 3px dashed rgba(0, 40, 100, 0.12) !important;\n  border-bottom: 0 !important;\n}\n#container[data-v-34a301b0]:hover {\n  background-color: rgba(0, 40, 100, 0.12);\n}\n#browse-button[data-v-34a301b0] {\n  display: block;\n  margin: auto auto;\n  top: 40%;\n  font-size: 150%;\n  text-decoration: none;\n}\n#browse-button[data-v-34a301b0]:focus {\n  box-shadow: none;\n  border: 0;\n}", ""]);
// Exports
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (___CSS_LOADER_EXPORT___);


/***/ }),

/***/ "../../node_modules/style-loader/dist/cjs.js!../../node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-12.use[1]!../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-12.use[2]!../../node_modules/sass-loader/dist/cjs.js??clonedRuleSet-12.use[3]!../../node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/pages/templates/Install.vue?vue&type=style&index=0&id=34a301b0&scoped=true&lang=scss":
/*!*********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ../../node_modules/style-loader/dist/cjs.js!../../node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-12.use[1]!../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-12.use[2]!../../node_modules/sass-loader/dist/cjs.js??clonedRuleSet-12.use[3]!../../node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/pages/templates/Install.vue?vue&type=style&index=0&id=34a301b0&scoped=true&lang=scss ***!
  \*********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! !../../../../../../../node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js */ "../../node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js");
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _node_modules_laravel_mix_node_modules_css_loader_dist_cjs_js_clonedRuleSet_12_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_12_use_2_node_modules_sass_loader_dist_cjs_js_clonedRuleSet_12_use_3_node_modules_vue_loader_lib_index_js_vue_loader_options_Install_vue_vue_type_style_index_0_id_34a301b0_scoped_true_lang_scss__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! !!../../../../../../../node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-12.use[1]!../../../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-12.use[2]!../../../../../../../node_modules/sass-loader/dist/cjs.js??clonedRuleSet-12.use[3]!../../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Install.vue?vue&type=style&index=0&id=34a301b0&scoped=true&lang=scss */ "../../node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-12.use[1]!../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-12.use[2]!../../node_modules/sass-loader/dist/cjs.js??clonedRuleSet-12.use[3]!../../node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/pages/templates/Install.vue?vue&type=style&index=0&id=34a301b0&scoped=true&lang=scss");

            

var options = {};

options.insert = "head";
options.singleton = false;

var update = _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default()(_node_modules_laravel_mix_node_modules_css_loader_dist_cjs_js_clonedRuleSet_12_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_12_use_2_node_modules_sass_loader_dist_cjs_js_clonedRuleSet_12_use_3_node_modules_vue_loader_lib_index_js_vue_loader_options_Install_vue_vue_type_style_index_0_id_34a301b0_scoped_true_lang_scss__WEBPACK_IMPORTED_MODULE_1__["default"], options);



/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_laravel_mix_node_modules_css_loader_dist_cjs_js_clonedRuleSet_12_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_12_use_2_node_modules_sass_loader_dist_cjs_js_clonedRuleSet_12_use_3_node_modules_vue_loader_lib_index_js_vue_loader_options_Install_vue_vue_type_style_index_0_id_34a301b0_scoped_true_lang_scss__WEBPACK_IMPORTED_MODULE_1__["default"].locals || {});

/***/ }),

/***/ "./resources/vue/mixin/saveAction.js":
/*!*******************************************!*\
  !*** ./resources/vue/mixin/saveAction.js ***!
  \*******************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  data: function data() {
    return {
      actionType: 'save_and_back',
      saveAction: {
        active: {
          value: "save_and_back",
          label: "Save and back"
        },
        options: {
          save_and_edit: "Save and edit this item",
          save_and_new: "Save and new item",
          save_and_preview: "Save and preview"
        }
      }
    };
  }
});

/***/ }),

/***/ "./resources/vue/views/pages/templates/Install.vue":
/*!*********************************************************!*\
  !*** ./resources/vue/views/pages/templates/Install.vue ***!
  \*********************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _Install_vue_vue_type_template_id_34a301b0_scoped_true__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Install.vue?vue&type=template&id=34a301b0&scoped=true */ "./resources/vue/views/pages/templates/Install.vue?vue&type=template&id=34a301b0&scoped=true");
/* harmony import */ var _Install_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Install.vue?vue&type=script&lang=js */ "./resources/vue/views/pages/templates/Install.vue?vue&type=script&lang=js");
/* harmony import */ var _Install_vue_vue_type_style_index_0_id_34a301b0_scoped_true_lang_scss__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./Install.vue?vue&type=style&index=0&id=34a301b0&scoped=true&lang=scss */ "./resources/vue/views/pages/templates/Install.vue?vue&type=style&index=0&id=34a301b0&scoped=true&lang=scss");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! !../../../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "../../node_modules/vue-loader/lib/runtime/componentNormalizer.js");



;


/* normalize component */

var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__["default"])(
  _Install_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"],
  _Install_vue_vue_type_template_id_34a301b0_scoped_true__WEBPACK_IMPORTED_MODULE_0__.render,
  _Install_vue_vue_type_template_id_34a301b0_scoped_true__WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  "34a301b0",
  null
  
)

/* hot reload */
if (false) // removed by dead control flow
{ var api; }
component.options.__file = "resources/vue/views/pages/templates/Install.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/vue/views/pages/templates/Install.vue?vue&type=script&lang=js":
/*!*********************************************************************************!*\
  !*** ./resources/vue/views/pages/templates/Install.vue?vue&type=script&lang=js ***!
  \*********************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_laravel_mix_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Install_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../../node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Install.vue?vue&type=script&lang=js */ "../../node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/pages/templates/Install.vue?vue&type=script&lang=js");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_laravel_mix_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Install_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/vue/views/pages/templates/Install.vue?vue&type=style&index=0&id=34a301b0&scoped=true&lang=scss":
/*!******************************************************************************************************************!*\
  !*** ./resources/vue/views/pages/templates/Install.vue?vue&type=style&index=0&id=34a301b0&scoped=true&lang=scss ***!
  \******************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_dist_cjs_js_node_modules_laravel_mix_node_modules_css_loader_dist_cjs_js_clonedRuleSet_12_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_12_use_2_node_modules_sass_loader_dist_cjs_js_clonedRuleSet_12_use_3_node_modules_vue_loader_lib_index_js_vue_loader_options_Install_vue_vue_type_style_index_0_id_34a301b0_scoped_true_lang_scss__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../../node_modules/style-loader/dist/cjs.js!../../../../../../../node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-12.use[1]!../../../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-12.use[2]!../../../../../../../node_modules/sass-loader/dist/cjs.js??clonedRuleSet-12.use[3]!../../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Install.vue?vue&type=style&index=0&id=34a301b0&scoped=true&lang=scss */ "../../node_modules/style-loader/dist/cjs.js!../../node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-12.use[1]!../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-12.use[2]!../../node_modules/sass-loader/dist/cjs.js??clonedRuleSet-12.use[3]!../../node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/pages/templates/Install.vue?vue&type=style&index=0&id=34a301b0&scoped=true&lang=scss");


/***/ }),

/***/ "./resources/vue/views/pages/templates/Install.vue?vue&type=template&id=34a301b0&scoped=true":
/*!***************************************************************************************************!*\
  !*** ./resources/vue/views/pages/templates/Install.vue?vue&type=template&id=34a301b0&scoped=true ***!
  \***************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   render: () => (/* reexport safe */ _node_modules_laravel_mix_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_Install_vue_vue_type_template_id_34a301b0_scoped_true__WEBPACK_IMPORTED_MODULE_0__.render),
/* harmony export */   staticRenderFns: () => (/* reexport safe */ _node_modules_laravel_mix_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_Install_vue_vue_type_template_id_34a301b0_scoped_true__WEBPACK_IMPORTED_MODULE_0__.staticRenderFns)
/* harmony export */ });
/* harmony import */ var _node_modules_laravel_mix_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_Install_vue_vue_type_template_id_34a301b0_scoped_true__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../../node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!../../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Install.vue?vue&type=template&id=34a301b0&scoped=true */ "../../node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!../../node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/pages/templates/Install.vue?vue&type=template&id=34a301b0&scoped=true");


/***/ })

}]);