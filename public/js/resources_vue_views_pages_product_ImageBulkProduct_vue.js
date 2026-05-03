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

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  name: 'ImageUpdateForBulkProduct',
  mixins: [_allDisks_mixin__WEBPACK_IMPORTED_MODULE_0__["default"]],
  props: ['class_name', 'axios_url'],
  components: {},
  data: function data() {
    return {
      backUrl: '/admin/products/bulk-image-update',
      searchUrl: '/admin/product/fetch/product-by-id',
      validationErrors: {},
      actionType: 'save_and_edit',
      selectedFiles: [],
      modalShade: '',
      productSearchKey: '',
      productImage: {
        image_path: ''
      },
      selectedProducts: [],
      isSearching: false
    };
  },
  mounted: function mounted() {},
  methods: {
    saveImageForSelectedProducts: function saveImageForSelectedProducts() {
      var _this$productImage;
      var productIds = this.selectedProducts.map(function (product) {
        return product.id;
      });
      this.validationErrors = {};
      var productIdsError = false;
      var imagePathError = false;
      if (productIds.length === 0) {
        this.validationErrors.productIds = 'Please select at-least 1 product';
        productIdsError = true;
      }
      if (!((_this$productImage = this.productImage) !== null && _this$productImage !== void 0 && _this$productImage.image_path) || this.productImage.image_path === '') {
        this.validationErrors.imagePath = 'Image path cannot be empty';
        imagePathError = true;
      }
      if (productIdsError || imagePathError) {
        return;
      }
      getFullPageLoader();
      axios.post(this.axios_url, {
        image_path: this.productImage.image_path,
        product_ids: productIds
      }).then(function (response) {
        new Noty({
          type: response.data.status,
          text: response.data.message
        }).show();
        window.location.reload();
      })["catch"](function (err) {
        var _err$response;
        var errorMessage = (_err$response = err.response) !== null && _err$response !== void 0 && _err$response.data ? err.response.data.message : 'Something went wrong please try again';
        new Noty({
          type: 'error',
          text: errorMessage
        }).show();
      })["finally"](function () {
        removeFullPageLoader();
      });
    },
    searchProduct: function searchProduct() {
      var _this = this;
      var searchKey = this.productSearchKey.trim();
      if (searchKey && typeof searchKey === 'string' && searchKey.length > 0) {
        this.isSearching = true;
        axios.post(this.searchUrl, {
          search_key: searchKey
        }).then(function (res) {
          if (res.data) {
            var found = _this.selectedProducts.find(function (prod) {
              return prod.id === res.data.id;
            });
            _this.productSearchKey = '';
            if (!!found) {
              new Noty({
                type: 'error',
                text: 'Product already selected'
              }).show();
              return;
            }
            _this.selectedProducts.push(res.data);
          }
        })["catch"](function (err) {
          var message = err.response.data ? err.response.data.message : 'Something went wrong try again';
          new Noty({
            type: 'error',
            text: message
          }).show();
        })["finally"](function () {
          _this.isSearching = false;
          _this.$nextTick(function () {
            var el = _this.$refs.searchKeyInput;
            if (el && !el.disabled) el.focus();
          });
        });
      }
    },
    productImagePath: function productImagePath(image) {
      if (!!(image !== null && image !== void 0 && image.main) && image.main !== '') {
        return image.main;
      }
      return this.$root.config.fallback_image;
    },
    // File Manager methods
    prepareModal: function prepareModal(type) {
      var _this2 = this;
      setTimeout(function () {
        var modalShade = document.querySelector('.modal-backdrop.fade.show');
        modalShade ? modalShade.remove() : null;
        _this2.modalShade = modalShade.outerHTML;
        _this2.activeModelFor = type;
        _this2.modalBody = document.querySelector('#widget-attributes-modal .modal-body').innerHTML;
      }, 10);
    },
    processImagesByType: function processImagesByType() {
      var indexOfAttributes = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : 0;
      this.indexOfAttributes = indexOfAttributes;
      this.selectedFiles = this.productImage.image_path;
    },
    deleteImage: function deleteImage() {
      var _this3 = this;
      this.$swal({
        title: 'Remove this Image?',
        //icon              : 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ff6b81',
        cancelButtonColor: '#399E7F',
        confirmButtonText: 'Remove'
      }).then(function (result) {
        if (result.isConfirmed) {
          _this3.productImage.image_path = '';
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
  }, [_c("label", [_vm._v("Search By Product Code/ID")]), _vm._v(" "), _c("div", {
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
  }), _vm._v(" Search ")]], 2)])])])]), _vm._v(" "), _vm.selectedProducts.length ? _c("table", {
    staticClass: "table table-bordered"
  }, [_vm._m(0), _vm._v(" "), _c("tbody", _vm._l(_vm.selectedProducts, function (product, index) {
    return _c("tr", [_c("td", {
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
    })]), _vm._v(" "), _c("td", [_c("p", [_vm._v(_vm._s(product.product_code))])]), _vm._v(" "), _c("td", [_vm._v(_vm._s(product.local_product_name))]), _vm._v(" "), _c("td", {
      staticStyle: {
        width: "100px"
      }
    }, [_c("button", {
      staticClass: "btn btn-sm btn-danger mx-auto d-flex justify-content-center align-items-center",
      staticStyle: {
        height: "30px",
        width: "30px"
      },
      attrs: {
        form: ""
      },
      on: {
        click: function click($event) {
          return _vm.removeSelectedProduct(index);
        }
      }
    }, [_c("i", {
      staticClass: "la la-trash font-lg"
    })])])]);
  }), 0)]) : _vm._e(), _vm._v(" "), !!_vm.validationErrors.productIds && _vm.selectedProducts.length === 0 ? _c("div", {
    staticClass: "alert alert-danger px-4 py-2"
  }, [_vm._v("\n                        " + _vm._s(_vm.validationErrors.productIds) + "\n                    ")]) : _vm._e(), _vm._v(" "), _c("div", {
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
  }, [_vm._m(1), _vm._v(" "), _c("button", {
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
  return _c("thead", [_c("tr", [_c("th", [_vm._v("Current Product Image")]), _vm._v(" "), _c("th", [_vm._v("Product Code")]), _vm._v(" "), _c("th", [_vm._v("Product Name")]), _vm._v(" "), _c("th", {
    staticClass: "text-center"
  }, [_vm._v("Action")])])]);
}, function () {
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