"use strict";
(self["webpackChunkbackend"] = self["webpackChunkbackend"] || []).push([["resources_vue_views_pages_product_ImageBulkProduct_vue"],{

/***/ "./node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/pages/product/ImageBulkProduct.vue?vue&type=script&lang=js":
/*!*********************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/pages/product/ImageBulkProduct.vue?vue&type=script&lang=js ***!
  \*********************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _allDisks_mixin__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../../allDisks.mixin */ "./resources/vue/allDisks.mixin.js");
function _typeof(o) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (o) { return typeof o; } : function (o) { return o && "function" == typeof Symbol && o.constructor === Symbol && o !== Symbol.prototype ? "symbol" : typeof o; }, _typeof(o); }
function _toConsumableArray(r) { return _arrayWithoutHoles(r) || _iterableToArray(r) || _unsupportedIterableToArray(r) || _nonIterableSpread(); }
function _nonIterableSpread() { throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); }
function _unsupportedIterableToArray(r, a) { if (r) { if ("string" == typeof r) return _arrayLikeToArray(r, a); var t = {}.toString.call(r).slice(8, -1); return "Object" === t && r.constructor && (t = r.constructor.name), "Map" === t || "Set" === t ? Array.from(r) : "Arguments" === t || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(t) ? _arrayLikeToArray(r, a) : void 0; } }
function _iterableToArray(r) { if ("undefined" != typeof Symbol && null != r[Symbol.iterator] || null != r["@@iterator"]) return Array.from(r); }
function _arrayWithoutHoles(r) { if (Array.isArray(r)) return _arrayLikeToArray(r); }
function _arrayLikeToArray(r, a) { (null == a || a > r.length) && (a = r.length); for (var e = 0, n = Array(a); e < a; e++) n[e] = r[e]; return n; }
function _regeneratorRuntime() { "use strict"; /*! regenerator-runtime -- Copyright (c) 2014-present, Facebook, Inc. -- license (MIT): https://github.com/facebook/regenerator/blob/main/LICENSE */ _regeneratorRuntime = function _regeneratorRuntime() { return e; }; var t, e = {}, r = Object.prototype, n = r.hasOwnProperty, o = Object.defineProperty || function (t, e, r) { t[e] = r.value; }, i = "function" == typeof Symbol ? Symbol : {}, a = i.iterator || "@@iterator", c = i.asyncIterator || "@@asyncIterator", u = i.toStringTag || "@@toStringTag"; function define(t, e, r) { return Object.defineProperty(t, e, { value: r, enumerable: !0, configurable: !0, writable: !0 }), t[e]; } try { define({}, ""); } catch (t) { define = function define(t, e, r) { return t[e] = r; }; } function wrap(t, e, r, n) { var i = e && e.prototype instanceof Generator ? e : Generator, a = Object.create(i.prototype), c = new Context(n || []); return o(a, "_invoke", { value: makeInvokeMethod(t, r, c) }), a; } function tryCatch(t, e, r) { try { return { type: "normal", arg: t.call(e, r) }; } catch (t) { return { type: "throw", arg: t }; } } e.wrap = wrap; var h = "suspendedStart", l = "suspendedYield", f = "executing", s = "completed", y = {}; function Generator() {} function GeneratorFunction() {} function GeneratorFunctionPrototype() {} var p = {}; define(p, a, function () { return this; }); var d = Object.getPrototypeOf, v = d && d(d(values([]))); v && v !== r && n.call(v, a) && (p = v); var g = GeneratorFunctionPrototype.prototype = Generator.prototype = Object.create(p); function defineIteratorMethods(t) { ["next", "throw", "return"].forEach(function (e) { define(t, e, function (t) { return this._invoke(e, t); }); }); } function AsyncIterator(t, e) { function invoke(r, o, i, a) { var c = tryCatch(t[r], t, o); if ("throw" !== c.type) { var u = c.arg, h = u.value; return h && "object" == _typeof(h) && n.call(h, "__await") ? e.resolve(h.__await).then(function (t) { invoke("next", t, i, a); }, function (t) { invoke("throw", t, i, a); }) : e.resolve(h).then(function (t) { u.value = t, i(u); }, function (t) { return invoke("throw", t, i, a); }); } a(c.arg); } var r; o(this, "_invoke", { value: function value(t, n) { function callInvokeWithMethodAndArg() { return new e(function (e, r) { invoke(t, n, e, r); }); } return r = r ? r.then(callInvokeWithMethodAndArg, callInvokeWithMethodAndArg) : callInvokeWithMethodAndArg(); } }); } function makeInvokeMethod(e, r, n) { var o = h; return function (i, a) { if (o === f) throw Error("Generator is already running"); if (o === s) { if ("throw" === i) throw a; return { value: t, done: !0 }; } for (n.method = i, n.arg = a;;) { var c = n.delegate; if (c) { var u = maybeInvokeDelegate(c, n); if (u) { if (u === y) continue; return u; } } if ("next" === n.method) n.sent = n._sent = n.arg;else if ("throw" === n.method) { if (o === h) throw o = s, n.arg; n.dispatchException(n.arg); } else "return" === n.method && n.abrupt("return", n.arg); o = f; var p = tryCatch(e, r, n); if ("normal" === p.type) { if (o = n.done ? s : l, p.arg === y) continue; return { value: p.arg, done: n.done }; } "throw" === p.type && (o = s, n.method = "throw", n.arg = p.arg); } }; } function maybeInvokeDelegate(e, r) { var n = r.method, o = e.iterator[n]; if (o === t) return r.delegate = null, "throw" === n && e.iterator["return"] && (r.method = "return", r.arg = t, maybeInvokeDelegate(e, r), "throw" === r.method) || "return" !== n && (r.method = "throw", r.arg = new TypeError("The iterator does not provide a '" + n + "' method")), y; var i = tryCatch(o, e.iterator, r.arg); if ("throw" === i.type) return r.method = "throw", r.arg = i.arg, r.delegate = null, y; var a = i.arg; return a ? a.done ? (r[e.resultName] = a.value, r.next = e.nextLoc, "return" !== r.method && (r.method = "next", r.arg = t), r.delegate = null, y) : a : (r.method = "throw", r.arg = new TypeError("iterator result is not an object"), r.delegate = null, y); } function pushTryEntry(t) { var e = { tryLoc: t[0] }; 1 in t && (e.catchLoc = t[1]), 2 in t && (e.finallyLoc = t[2], e.afterLoc = t[3]), this.tryEntries.push(e); } function resetTryEntry(t) { var e = t.completion || {}; e.type = "normal", delete e.arg, t.completion = e; } function Context(t) { this.tryEntries = [{ tryLoc: "root" }], t.forEach(pushTryEntry, this), this.reset(!0); } function values(e) { if (e || "" === e) { var r = e[a]; if (r) return r.call(e); if ("function" == typeof e.next) return e; if (!isNaN(e.length)) { var o = -1, i = function next() { for (; ++o < e.length;) if (n.call(e, o)) return next.value = e[o], next.done = !1, next; return next.value = t, next.done = !0, next; }; return i.next = i; } } throw new TypeError(_typeof(e) + " is not iterable"); } return GeneratorFunction.prototype = GeneratorFunctionPrototype, o(g, "constructor", { value: GeneratorFunctionPrototype, configurable: !0 }), o(GeneratorFunctionPrototype, "constructor", { value: GeneratorFunction, configurable: !0 }), GeneratorFunction.displayName = define(GeneratorFunctionPrototype, u, "GeneratorFunction"), e.isGeneratorFunction = function (t) { var e = "function" == typeof t && t.constructor; return !!e && (e === GeneratorFunction || "GeneratorFunction" === (e.displayName || e.name)); }, e.mark = function (t) { return Object.setPrototypeOf ? Object.setPrototypeOf(t, GeneratorFunctionPrototype) : (t.__proto__ = GeneratorFunctionPrototype, define(t, u, "GeneratorFunction")), t.prototype = Object.create(g), t; }, e.awrap = function (t) { return { __await: t }; }, defineIteratorMethods(AsyncIterator.prototype), define(AsyncIterator.prototype, c, function () { return this; }), e.AsyncIterator = AsyncIterator, e.async = function (t, r, n, o, i) { void 0 === i && (i = Promise); var a = new AsyncIterator(wrap(t, r, n, o), i); return e.isGeneratorFunction(r) ? a : a.next().then(function (t) { return t.done ? t.value : a.next(); }); }, defineIteratorMethods(g), define(g, u, "Generator"), define(g, a, function () { return this; }), define(g, "toString", function () { return "[object Generator]"; }), e.keys = function (t) { var e = Object(t), r = []; for (var n in e) r.push(n); return r.reverse(), function next() { for (; r.length;) { var t = r.pop(); if (t in e) return next.value = t, next.done = !1, next; } return next.done = !0, next; }; }, e.values = values, Context.prototype = { constructor: Context, reset: function reset(e) { if (this.prev = 0, this.next = 0, this.sent = this._sent = t, this.done = !1, this.delegate = null, this.method = "next", this.arg = t, this.tryEntries.forEach(resetTryEntry), !e) for (var r in this) "t" === r.charAt(0) && n.call(this, r) && !isNaN(+r.slice(1)) && (this[r] = t); }, stop: function stop() { this.done = !0; var t = this.tryEntries[0].completion; if ("throw" === t.type) throw t.arg; return this.rval; }, dispatchException: function dispatchException(e) { if (this.done) throw e; var r = this; function handle(n, o) { return a.type = "throw", a.arg = e, r.next = n, o && (r.method = "next", r.arg = t), !!o; } for (var o = this.tryEntries.length - 1; o >= 0; --o) { var i = this.tryEntries[o], a = i.completion; if ("root" === i.tryLoc) return handle("end"); if (i.tryLoc <= this.prev) { var c = n.call(i, "catchLoc"), u = n.call(i, "finallyLoc"); if (c && u) { if (this.prev < i.catchLoc) return handle(i.catchLoc, !0); if (this.prev < i.finallyLoc) return handle(i.finallyLoc); } else if (c) { if (this.prev < i.catchLoc) return handle(i.catchLoc, !0); } else { if (!u) throw Error("try statement without catch or finally"); if (this.prev < i.finallyLoc) return handle(i.finallyLoc); } } } }, abrupt: function abrupt(t, e) { for (var r = this.tryEntries.length - 1; r >= 0; --r) { var o = this.tryEntries[r]; if (o.tryLoc <= this.prev && n.call(o, "finallyLoc") && this.prev < o.finallyLoc) { var i = o; break; } } i && ("break" === t || "continue" === t) && i.tryLoc <= e && e <= i.finallyLoc && (i = null); var a = i ? i.completion : {}; return a.type = t, a.arg = e, i ? (this.method = "next", this.next = i.finallyLoc, y) : this.complete(a); }, complete: function complete(t, e) { if ("throw" === t.type) throw t.arg; return "break" === t.type || "continue" === t.type ? this.next = t.arg : "return" === t.type ? (this.rval = this.arg = t.arg, this.method = "return", this.next = "end") : "normal" === t.type && e && (this.next = e), y; }, finish: function finish(t) { for (var e = this.tryEntries.length - 1; e >= 0; --e) { var r = this.tryEntries[e]; if (r.finallyLoc === t) return this.complete(r.completion, r.afterLoc), resetTryEntry(r), y; } }, "catch": function _catch(t) { for (var e = this.tryEntries.length - 1; e >= 0; --e) { var r = this.tryEntries[e]; if (r.tryLoc === t) { var n = r.completion; if ("throw" === n.type) { var o = n.arg; resetTryEntry(r); } return o; } } throw Error("illegal catch attempt"); }, delegateYield: function delegateYield(e, r, n) { return this.delegate = { iterator: values(e), resultName: r, nextLoc: n }, "next" === this.method && (this.arg = t), y; } }, e; }
function asyncGeneratorStep(n, t, e, r, o, a, c) { try { var i = n[a](c), u = i.value; } catch (n) { return void e(n); } i.done ? t(u) : Promise.resolve(u).then(r, o); }
function _asyncToGenerator(n) { return function () { var t = this, e = arguments; return new Promise(function (r, o) { var a = n.apply(t, e); function _next(n) { asyncGeneratorStep(a, r, o, _next, _throw, "next", n); } function _throw(n) { asyncGeneratorStep(a, r, o, _next, _throw, "throw", n); } _next(void 0); }); }; }

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  name: 'ImageUpdateForBulkProduct',
  mixins: [_allDisks_mixin__WEBPACK_IMPORTED_MODULE_0__["default"]],
  props: ['class_name', 'axios_url'],
  components: {},
  data: function data() {
    return {
      backUrl: '/admin/products/bulk-image-update',
      searchUrl: '/admin/product/fetch/product-by-name',
      validationErrors: {},
      actionType: 'save_and_edit',
      selectedFiles: [],
      modalShade: '',
      productSearchKey: '',
      productImage: {
        image_path: ''
      },
      searchResults: [],
      selectedProducts: [],
      isSearching: false
    };
  },
  mounted: function mounted() {},
  methods: {
    saveImageForSelectedProducts: function saveImageForSelectedProducts() {
      var _this = this;
      return _asyncToGenerator(/*#__PURE__*/_regeneratorRuntime().mark(function _callee() {
        var _this$productImage;
        var productIds, productIdsError, imagePathError, chunkSize, i, productIdsChunk, _err$response, errorMessage;
        return _regeneratorRuntime().wrap(function _callee$(_context) {
          while (1) switch (_context.prev = _context.next) {
            case 0:
              productIds = _this.selectedProducts.map(function (product) {
                return product.id;
              });
              _this.validationErrors = {};
              productIdsError = false;
              imagePathError = false;
              if (productIds.length === 0) {
                _this.validationErrors.productIds = 'Please select at-least 1 product';
                productIdsError = true;
              }
              if (!((_this$productImage = _this.productImage) !== null && _this$productImage !== void 0 && _this$productImage.image_path) || _this.productImage.image_path === '') {
                _this.validationErrors.imagePath = 'Image path cannot be empty';
                imagePathError = true;
              }
              if (!(productIdsError || imagePathError)) {
                _context.next = 8;
                break;
              }
              return _context.abrupt("return");
            case 8:
              getFullPageLoader();
              _context.prev = 9;
              chunkSize = 500;
              i = 0;
            case 12:
              if (!(i < productIds.length)) {
                _context.next = 19;
                break;
              }
              productIdsChunk = productIds.slice(i, i + chunkSize);
              _context.next = 16;
              return axios.post(_this.axios_url, {
                image_path: _this.productImage.image_path,
                product_ids: productIdsChunk
              });
            case 16:
              i += chunkSize;
              _context.next = 12;
              break;
            case 19:
              new Noty({
                type: 'success',
                text: "Image updated for ".concat(productIds.length, " products")
              }).show();
              _this.selectedProducts = [];
              _this.searchResults = [];
              _this.productImage = {
                image_path: ''
              };
              _this.productSearchKey = '';
              _context.next = 30;
              break;
            case 26:
              _context.prev = 26;
              _context.t0 = _context["catch"](9);
              errorMessage = (_err$response = _context.t0.response) !== null && _err$response !== void 0 && _err$response.data ? _context.t0.response.data.message : 'Something went wrong please try again';
              new Noty({
                type: 'error',
                text: errorMessage
              }).show();
            case 30:
              _context.prev = 30;
              removeFullPageLoader();
              return _context.finish(30);
            case 33:
            case "end":
              return _context.stop();
          }
        }, _callee, null, [[9, 26, 30, 33]]);
      }))();
    },
    searchProduct: function searchProduct() {
      var _this2 = this;
      var searchKey = this.productSearchKey.trim();
      if (searchKey && typeof searchKey === 'string' && searchKey.length > 0) {
        this.isSearching = true;
        axios.post(this.searchUrl, {
          search_key: searchKey
        }).then(function (res) {
          if (res.data && res.data.length) {
            _this2.searchResults = res.data;
            _this2.selectedProducts = [];
            return;
          }
          _this2.searchResults = [];
          _this2.selectedProducts = [];
        })["catch"](function (err) {
          var message = err.response.data ? err.response.data.message : 'Something went wrong try again';
          new Noty({
            type: 'error',
            text: message
          }).show();
        })["finally"](function () {
          _this2.isSearching = false;
          _this2.$nextTick(function () {
            var el = _this2.$refs.searchKeyInput;
            if (el && !el.disabled) el.focus();
          });
        });
      }
    },
    toggleProductSelection: function toggleProductSelection(product) {
      var index = this.selectedProducts.findIndex(function (p) {
        return p.id === product.id;
      });
      if (index > -1) {
        this.selectedProducts.splice(index, 1);
      } else {
        this.selectedProducts.push(product);
      }
    },
    isSelected: function isSelected(productId) {
      return this.selectedProducts.some(function (product) {
        return product.id === productId;
      });
    },
    toggleSelectAll: function toggleSelectAll() {
      if (this.selectedProducts.length === this.searchResults.length) {
        this.selectedProducts = [];
        return;
      }
      this.selectedProducts = _toConsumableArray(this.searchResults);
    },
    productImagePath: function productImagePath(image) {
      if (!!(image !== null && image !== void 0 && image.main) && image.main !== '') {
        return image.main;
      }
      return this.$root.config.fallback_image;
    },
    // File Manager methods
    prepareModal: function prepareModal(type) {
      var _this3 = this;
      setTimeout(function () {
        var modalShade = document.querySelector('.modal-backdrop.fade.show');
        modalShade ? modalShade.remove() : null;
        _this3.modalShade = modalShade.outerHTML;
        _this3.activeModelFor = type;
        _this3.modalBody = document.querySelector('#widget-attributes-modal .modal-body').innerHTML;
      }, 10);
    },
    processImagesByType: function processImagesByType() {
      var indexOfAttributes = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : 0;
      this.indexOfAttributes = indexOfAttributes;
      this.selectedFiles = this.productImage.image_path;
    },
    deleteImage: function deleteImage() {
      var _this4 = this;
      this.$swal({
        title: 'Remove this Image?',
        //icon              : 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ff6b81',
        cancelButtonColor: '#399E7F',
        confirmButtonText: 'Remove'
      }).then(function (result) {
        if (result.isConfirmed) {
          _this4.productImage.image_path = '';
        }
      });
    },
    removeSelectedProduct: function removeSelectedProduct(index) {
      this.selectedProducts.splice(index, 1);
    },
    removeSelectedFiles: function removeSelectedFiles(index) {
      var length = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 1;
      var path = this.selectedFiles.splice(index, length);
      var noty = {
        type: 'success',
        text: "File (".concat(path, ") removed!")
      };
      new Noty(noty).show();
    },
    getFileExtension: function getFileExtension(file) {
      var regexp = /\.([0-9a-z]+)(?:[\?#]|$)/i;
      var extension = file.match(regexp);
      return extension && extension[1];
    },
    getFileAddedMessage: function getFileAddedMessage() {
      var noty = {
        type: 'success',
        text: 'File path added!'
      };
      new Noty(noty).show();
    }
  },
  watch: {
    '$store.state.fm.left.selected.files': {
      handler: function handler(files) {
        if (files.length) {
          var self = this;
          if (self.canMultiple) {
            var filesPath = files.filter(function (file) {
              return ['jpg', 'jpeg', 'png'].includes(self.getFileExtension(file.toLowerCase()));
            });
            if (filesPath) {
              self.$parent.selectedFiles = filesPath.map(function (filePath) {
                return self.all_disks[self.$store.state.fm.left.selectedDisk].url ? self.all_disks[self.$store.state.fm.left.selectedDisk].url + '/' + filePath : '/' + filePath;
              });
            }
          } else {
            var filePath = files.find(function (file) {
              return ['jpg', 'jpeg', 'png'].includes(self.getFileExtension(file.toLowerCase()));
            });
            if (filePath) {
              self.$parent.selectedFiles = self.all_disks[self.$store.state.fm.left.selectedDisk].url ? self.all_disks[self.$store.state.fm.left.selectedDisk].url + '/' + filePath : '/' + filePath;
            }
          }
          self.productImage.image_path = self.$parent.selectedFiles;
          delete self.validationErrors.imagePath;
          self.getFileAddedMessage();
        }
      }
    }
  }
});

/***/ }),

/***/ "./node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/pages/product/ImageBulkProduct.vue?vue&type=template&id=5d66192f":
/*!********************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/pages/product/ImageBulkProduct.vue?vue&type=template&id=5d66192f ***!
  \********************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   render: () => (/* binding */ render),
/* harmony export */   staticRenderFns: () => (/* binding */ staticRenderFns)
/* harmony export */ });
var render = function render() {
  var _vm = this,
    _c = _vm._self._c;
  return _c("div", {
    staticClass: "row"
  }, [_c("div", {
    "class": _vm.class_name
  }, [_c("form", {
    attrs: {
      method: "post",
      action: _vm.backUrl,
      id: "image-add-to-bulk-products"
    },
    on: {
      submit: function submit($event) {
        $event.preventDefault();
      }
    }
  }, [_c("div", {
    staticClass: "card"
  }, [_c("div", {
    staticClass: "card-body rounded"
  }, [_c("div", {
    staticClass: "form-group required"
  }, [_c("label", [_vm._v("Product Image")]), _vm._v(" "), _c("div", {
    staticClass: "controls"
  }, [_c("div", {
    staticClass: "input-group"
  }, [_c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.productImage.image_path,
      expression: "productImage.image_path"
    }],
    staticClass: "form-control",
    "class": {
      "border-danger": !!_vm.validationErrors.imagePath
    },
    attrs: {
      type: "text",
      name: "logo_path",
      id: "logo_path"
    },
    domProps: {
      value: _vm.productImage.image_path
    },
    on: {
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.$set(_vm.productImage, "image_path", $event.target.value);
      }
    }
  }), _vm._v(" "), _c("span", {
    staticClass: "input-group-append"
  }, [_c("button", {
    staticClass: "btn btn-light btn-sm popup_selector",
    "class": {
      "border-danger": !!_vm.validationErrors.imagePath
    },
    attrs: {
      form: "",
      type: "button",
      "data-toggle": "modal",
      "data-target": "#widget-attributes-modal"
    },
    on: {
      click: function click($event) {
        _vm.prepareModal("header");
        _vm.processImagesByType();
        _vm.canMultiple = false;
      }
    }
  }, [_c("i", {
    staticClass: "la la-cloud-upload"
  }), _vm._v(" Browse\n                                    ")]), _vm._v(" "), _c("button", {
    staticClass: "btn btn-light btn-sm clear_elfinder_picker",
    "class": {
      "border-danger": !!_vm.validationErrors.imagePath
    },
    attrs: {
      form: "",
      type: "button"
    },
    on: {
      click: function click($event) {
        return _vm.deleteImage();
      }
    }
  }, [_c("i", {
    staticClass: "la la-eraser"
  }), _vm._v(" Clear\n                                    ")])])]), _vm._v(" "), !!_vm.validationErrors.imagePath ? _c("small", {
    staticClass: "text-danger"
  }, [_vm._v("\n                                " + _vm._s(_vm.validationErrors.imagePath) + "\n                            ")]) : _vm._e()]), _vm._v(" "), _c("label", {
    staticClass: "d-block"
  }, [_vm._v("Preview")]), _vm._v(" "), _c("div", {
    staticClass: "img-preview-wrapper border p-2"
  }, [_c("img", {
    staticClass: "rounded d-block mx-auto",
    attrs: {
      src: _vm.productImage.image_path === "" ? _vm.$root.config.fallback_image : _vm.productImage.image_path,
      alt: "Product image",
      height: "150"
    }
  })])]), _vm._v(" "), _c("div", {
    staticClass: "form-group required"
  }, [_c("label", [_vm._v("Search By Product Name/Code")]), _vm._v(" "), _c("div", {
    staticClass: "controls"
  }, [_c("div", {
    staticClass: "input-group w-25"
  }, [_c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.productSearchKey,
      expression: "productSearchKey"
    }],
    ref: "searchKeyInput",
    staticClass: "form-control",
    attrs: {
      type: "text",
      name: "search-key",
      id: "search-key",
      disabled: _vm.isSearching
    },
    domProps: {
      value: _vm.productSearchKey
    },
    on: {
      keyup: function keyup($event) {
        if (!$event.type.indexOf("key") && _vm._k($event.keyCode, "enter", 13, $event.key, "Enter")) return null;
        return _vm.searchProduct.apply(null, arguments);
      },
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.productSearchKey = $event.target.value;
      }
    }
  }), _vm._v(" "), _c("span", {
    staticClass: "input-group-append"
  }, [_c("button", {
    staticClass: "btn btn-warning btn-sm",
    attrs: {
      form: "",
      type: "button",
      disabled: _vm.isSearching
    },
    on: {
      click: _vm.searchProduct
    }
  }, [_vm.isSearching ? [_c("i", {
    staticClass: "la la-spinner la-pulse"
  }), _vm._v(" Searching\n                                        ")] : [_c("i", {
    staticClass: "la la-search"
  }), _vm._v(" Search ")]], 2)])])])]), _vm._v(" "), _vm.searchResults.length ? _c("div", {
    staticClass: "alert alert-info py-2 px-3"
  }, [_vm._v("\n                        Total Products Found:\n                        "), _c("strong", [_vm._v(_vm._s(_vm.searchResults.length))])]) : _vm._e(), _vm._v(" "), _vm.searchResults.length ? _c("table", {
    staticClass: "table table-bordered table-hover"
  }, [_c("thead", [_c("tr", [_c("th", {
    attrs: {
      width: "50"
    }
  }, [_c("input", {
    attrs: {
      type: "checkbox"
    },
    domProps: {
      checked: _vm.searchResults.length && _vm.selectedProducts.length === _vm.searchResults.length
    },
    on: {
      change: _vm.toggleSelectAll
    }
  })]), _vm._v(" "), _c("th", [_vm._v("Current Product Image")]), _vm._v(" "), _c("th", [_vm._v("Product Code")]), _vm._v(" "), _c("th", [_vm._v("Product Name")])])]), _vm._v(" "), _c("tbody", _vm._l(_vm.searchResults, function (product) {
    return _c("tr", {
      key: product.id,
      "class": {
        "table-primary": _vm.isSelected(product.id)
      },
      staticStyle: {
        cursor: "pointer"
      },
      on: {
        click: function click($event) {
          return _vm.toggleProductSelection(product);
        }
      }
    }, [_c("td", {
      staticClass: "text-center align-middle",
      on: {
        click: function click($event) {
          $event.stopPropagation();
        }
      }
    }, [_c("input", {
      attrs: {
        type: "checkbox"
      },
      domProps: {
        checked: _vm.isSelected(product.id)
      },
      on: {
        change: function change($event) {
          return _vm.toggleProductSelection(product);
        }
      }
    })]), _vm._v(" "), _c("td", {
      staticClass: "p-2",
      staticStyle: {
        width: "200px",
        height: "80px"
      }
    }, [_c("img", {
      staticClass: "w-auto mr-2",
      staticStyle: {
        height: "80px"
      },
      attrs: {
        src: _vm.productImagePath(product.product_image),
        alt: product.local_product_name
      }
    })]), _vm._v(" "), _c("td", [_vm._v("\n                                " + _vm._s(product.product_code) + "\n                            ")]), _vm._v(" "), _c("td", [_vm._v("\n                                " + _vm._s(product.local_product_name) + "\n                            ")])]);
  }), 0)]) : _vm._e(), _vm._v(" "), !!_vm.validationErrors.productIds && _vm.selectedProducts.length === 0 ? _c("div", {
    staticClass: "alert alert-danger px-4 py-2"
  }, [_vm._v("\n                        " + _vm._s(_vm.validationErrors.productIds) + "\n                    ")]) : _vm._e(), _vm._v(" "), _vm.selectedProducts.length ? _c("div", {
    staticClass: "alert alert-success py-2 px-3"
  }, [_vm._v("\n                        Selected Products: "), _c("strong", [_vm._v(_vm._s(_vm.selectedProducts.length))])]) : _vm._e(), _vm._v(" "), _c("div", {
    staticClass: "form-group",
    attrs: {
      id: "saveActions"
    }
  }, [_c("button", {
    staticClass: "btn btn-success",
    attrs: {
      form: "image-add-to-bulk-products",
      type: "button"
    },
    on: {
      click: function click($event) {
        return _vm.saveImageForSelectedProducts();
      }
    }
  }, [_c("span", {
    staticClass: "la la-save",
    attrs: {
      role: "presentation",
      "aria-hidden": "true"
    }
  }), _vm._v("  \n                            "), _c("span", {
    attrs: {
      "data-value": "save_and_edit"
    }
  }, [_vm._v(" Save")])]), _vm._v(" "), _c("button", {
    staticClass: "btn btn-default",
    attrs: {
      form: "",
      type: "button"
    },
    on: {
      click: function click($event) {
        return _vm.window.location.reload();
      }
    }
  }, [_c("span", {
    staticClass: "la la-ban"
  }), _vm._v(" Cancel\n                        ")])])])])])]), _vm._v(" "), _c("div", {
    staticClass: "modal fade",
    attrs: {
      id: "widget-attributes-modal",
      tabIndex: "0",
      role: "dialog",
      "aria-labelledby": "widget-attributes-modal-dialog-label",
      "data-backdrop": "static",
      "data-keyboard": "false",
      "aria-modal": "true"
    }
  }, [_c("div", {
    staticClass: "modal-dialog modal-xl",
    attrs: {
      role: "document"
    }
  }, [_c("div", {
    staticClass: "modal-content"
  }, [_c("div", {
    staticClass: "modal-header"
  }, [_vm._m(0), _vm._v(" "), _c("button", {
    staticClass: "close",
    attrs: {
      form: "",
      type: "button",
      "data-dismiss": "modal",
      "aria-label": "Close"
    },
    on: {
      click: function click($event) {
        _vm.modalShade = "";
      }
    }
  }, [_c("span", {
    attrs: {
      "aria-hidden": "true"
    }
  }, [_vm._v("×")])])]), _vm._v(" "), _c("div", {
    staticClass: "modal-body bg-light"
  }, [_c("div", {
    staticClass: "card",
    staticStyle: {
      "margin-bottom": "0 !important"
    }
  }, [_c("div", {
    staticClass: "card-body"
  }, [_c("div", {
    staticClass: "col-12 mt-2"
  }, [_c("div", {
    staticClass: "card"
  }, [_c("div", {
    staticClass: "card-body"
  }, [_c("file-manager", {
    ref: "fileManager"
  })], 1)])])])])]), _vm._v(" "), _c("div", {
    staticClass: "modal-footer"
  }, [_c("button", {
    staticClass: "btn btn-secondary",
    attrs: {
      form: "",
      type: "button",
      "data-dismiss": "modal",
      "aria-label": "Close",
      id: "cancelWidgetAttributesModalBtn"
    },
    on: {
      click: function click($event) {
        _vm.modalShade = "";
      }
    }
  }, [_vm._v("\n                        Cancel\n                    ")])])])])])]);
};
var staticRenderFns = [function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("h5", {
    staticClass: "modal-title",
    attrs: {
      id: "attribute-inline-create-dialog-label"
    }
  }, [_vm._v("\n                        Set image for adding to multiple products "), _c("strong")]);
}];
render._withStripped = true;


/***/ }),

/***/ "./resources/vue/allDisks.mixin.js":
/*!*****************************************!*\
  !*** ./resources/vue/allDisks.mixin.js ***!
  \*****************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var axios__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! axios */ "./node_modules/axios/lib/axios.js");

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  data: function data() {
    return {
      all_disks: []
    };
  },
  created: function created() {
    var _this = this;
    axios__WEBPACK_IMPORTED_MODULE_0__["default"].get('/admin/disks').then(function (res) {
      _this.all_disks = res.data;
    });
  }
});

/***/ }),

/***/ "./resources/vue/views/pages/product/ImageBulkProduct.vue":
/*!****************************************************************!*\
  !*** ./resources/vue/views/pages/product/ImageBulkProduct.vue ***!
  \****************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _ImageBulkProduct_vue_vue_type_template_id_5d66192f__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./ImageBulkProduct.vue?vue&type=template&id=5d66192f */ "./resources/vue/views/pages/product/ImageBulkProduct.vue?vue&type=template&id=5d66192f");
/* harmony import */ var _ImageBulkProduct_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./ImageBulkProduct.vue?vue&type=script&lang=js */ "./resources/vue/views/pages/product/ImageBulkProduct.vue?vue&type=script&lang=js");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _ImageBulkProduct_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"],
  _ImageBulkProduct_vue_vue_type_template_id_5d66192f__WEBPACK_IMPORTED_MODULE_0__.render,
  _ImageBulkProduct_vue_vue_type_template_id_5d66192f__WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/vue/views/pages/product/ImageBulkProduct.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/vue/views/pages/product/ImageBulkProduct.vue?vue&type=script&lang=js":
/*!****************************************************************************************!*\
  !*** ./resources/vue/views/pages/product/ImageBulkProduct.vue?vue&type=script&lang=js ***!
  \****************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_laravel_mix_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ImageBulkProduct_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ImageBulkProduct.vue?vue&type=script&lang=js */ "./node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/pages/product/ImageBulkProduct.vue?vue&type=script&lang=js");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_laravel_mix_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ImageBulkProduct_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/vue/views/pages/product/ImageBulkProduct.vue?vue&type=template&id=5d66192f":
/*!**********************************************************************************************!*\
  !*** ./resources/vue/views/pages/product/ImageBulkProduct.vue?vue&type=template&id=5d66192f ***!
  \**********************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   render: () => (/* reexport safe */ _node_modules_laravel_mix_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_ImageBulkProduct_vue_vue_type_template_id_5d66192f__WEBPACK_IMPORTED_MODULE_0__.render),
/* harmony export */   staticRenderFns: () => (/* reexport safe */ _node_modules_laravel_mix_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_ImageBulkProduct_vue_vue_type_template_id_5d66192f__WEBPACK_IMPORTED_MODULE_0__.staticRenderFns)
/* harmony export */ });
/* harmony import */ var _node_modules_laravel_mix_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_ImageBulkProduct_vue_vue_type_template_id_5d66192f__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ImageBulkProduct.vue?vue&type=template&id=5d66192f */ "./node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/pages/product/ImageBulkProduct.vue?vue&type=template&id=5d66192f");


/***/ })

}]);