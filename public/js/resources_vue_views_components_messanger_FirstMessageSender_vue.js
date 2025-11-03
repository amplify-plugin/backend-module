"use strict";
(self["webpackChunkbackend"] = self["webpackChunkbackend"] || []).push([["resources_vue_views_components_messanger_FirstMessageSender_vue"],{

/***/ "./node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/components/messanger/FirstMessageSender.vue?vue&type=script&lang=js":
/*!******************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/components/messanger/FirstMessageSender.vue?vue&type=script&lang=js ***!
  \******************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  name: "FirstMessageSender",
  props: {
    url: String,
    csrf_token: String,
    send_icon: {
      type: String,
      "default": "la la-send"
    }
  },
  data: function data() {
    return {
      messageAbleUserList: [],
      messageType: ''
    };
  },
  methods: {
    changeMessageAbleUser: function changeMessageAbleUser(userType) {
      var _this = this;
      if (userType.target.value) {
        axios.get("".concat(this.url, "/recipients/").concat(userType.target.value)).then(function (res) {
          _this.messageAbleUserList = res.data;
          _this.messageType = res.data.type;
          _this.messageAbleUserList = res.data.account;
        });
      }
    }
  }
});

/***/ }),

/***/ "./node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/components/messanger/FirstMessageSender.vue?vue&type=template&id=249d8f5a":
/*!*****************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/components/messanger/FirstMessageSender.vue?vue&type=template&id=249d8f5a ***!
  \*****************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   render: () => (/* binding */ render),
/* harmony export */   staticRenderFns: () => (/* binding */ staticRenderFns)
/* harmony export */ });
var render = function render() {
  var _vm = this,
    _c = _vm._self._c;
  return _c("div", [_vm._m(0), _vm._v(" "), _c("div", {
    staticClass: "chat-message clearfix"
  }, [_c("form", {
    attrs: {
      action: "".concat(_vm.url, "/new"),
      method: "post",
      enctype: "multipart/form-data"
    }
  }, [_c("input", {
    attrs: {
      type: "hidden",
      name: "_token"
    },
    domProps: {
      value: _vm.csrf_token
    }
  }), _vm._v(" "), _c("div", {
    staticClass: "form-row"
  }, [_c("div", {
    staticClass: "form-group col-md-4"
  }, [_c("label", [_vm._v("User type")]), _vm._v(" "), _c("select", {
    staticClass: "form-control",
    attrs: {
      name: "user_type"
    },
    on: {
      change: _vm.changeMessageAbleUser
    }
  }, [_c("option", {
    attrs: {
      value: ""
    }
  }, [_vm._v("Select one")]), _vm._v(" "), _c("option", {
    attrs: {
      value: "user",
      title: "Admin panel users"
    }
  }, [_vm._v("User")]), _vm._v(" "), _c("option", {
    attrs: {
      value: "contact",
      title: "Customer contact accounts"
    }
  }, [_vm._v("Contact")])])]), _vm._v(" "), _c("div", {
    staticClass: "form-group col-md-8"
  }, [_c("label", [_vm._v("Message to")]), _vm._v(" "), _c("select", {
    staticClass: "form-control",
    attrs: {
      name: "msg_to"
    }
  }, [_c("option", [_vm._v("Select one")]), _vm._v(" "), _vm._l(_vm.messageAbleUserList, function (customer, key) {
    return _vm.messageType === "contact" ? _c("optgroup", {
      key: key,
      attrs: {
        label: customer.customer_name
      }
    }, _vm._l(customer.contacts, function (contact, ckey) {
      return _c("option", {
        key: ckey,
        domProps: {
          value: contact.id
        }
      }, [_vm._v("\n                                    " + _vm._s(contact.name) + "\n                                ")]);
    }), 0) : _vm._e();
  }), _vm._v(" "), _vm._l(_vm.messageAbleUserList, function (user, ukey) {
    return _vm.messageType === "user" ? _c("option", {
      key: ukey,
      domProps: {
        value: user.id
      }
    }, [_vm._v("\n                                " + _vm._s(user.name) + "\n                            ")]) : _vm._e();
  })], 2)])]), _vm._v(" "), _c("div", {
    staticClass: "input-group mb-0"
  }, [_c("input", {
    staticClass: "form-control",
    staticStyle: {
      "padding-left": "0.75rem"
    },
    attrs: {
      type: "text",
      name: "msg",
      placeholder: "Enter text here..."
    }
  }), _vm._v(" "), _c("div", {
    staticClass: "input-group-prepend"
  }, [_c("button", {
    staticClass: "btn btn-info rounded-right mt-0"
  }, [_c("i", {
    "class": _vm.send_icon
  })])])]), _vm._v(" "), _vm._m(1)])])]);
};
var staticRenderFns = [function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("div", {
    staticClass: "chat-history"
  }, [_c("ul", {
    staticStyle: {
      height: "480px"
    }
  })]);
}, function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("div", {
    staticClass: "form-group mt-3"
  }, [_c("input", {
    staticClass: "form-control",
    attrs: {
      type: "file",
      name: "attachment",
      id: "customFile"
    }
  })]);
}];
render._withStripped = true;


/***/ }),

/***/ "./resources/vue/views/components/messanger/FirstMessageSender.vue":
/*!*************************************************************************!*\
  !*** ./resources/vue/views/components/messanger/FirstMessageSender.vue ***!
  \*************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _FirstMessageSender_vue_vue_type_template_id_249d8f5a__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./FirstMessageSender.vue?vue&type=template&id=249d8f5a */ "./resources/vue/views/components/messanger/FirstMessageSender.vue?vue&type=template&id=249d8f5a");
/* harmony import */ var _FirstMessageSender_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./FirstMessageSender.vue?vue&type=script&lang=js */ "./resources/vue/views/components/messanger/FirstMessageSender.vue?vue&type=script&lang=js");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _FirstMessageSender_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"],
  _FirstMessageSender_vue_vue_type_template_id_249d8f5a__WEBPACK_IMPORTED_MODULE_0__.render,
  _FirstMessageSender_vue_vue_type_template_id_249d8f5a__WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/vue/views/components/messanger/FirstMessageSender.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/vue/views/components/messanger/FirstMessageSender.vue?vue&type=script&lang=js":
/*!*************************************************************************************************!*\
  !*** ./resources/vue/views/components/messanger/FirstMessageSender.vue?vue&type=script&lang=js ***!
  \*************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_laravel_mix_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_FirstMessageSender_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./FirstMessageSender.vue?vue&type=script&lang=js */ "./node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/components/messanger/FirstMessageSender.vue?vue&type=script&lang=js");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_laravel_mix_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_FirstMessageSender_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/vue/views/components/messanger/FirstMessageSender.vue?vue&type=template&id=249d8f5a":
/*!*******************************************************************************************************!*\
  !*** ./resources/vue/views/components/messanger/FirstMessageSender.vue?vue&type=template&id=249d8f5a ***!
  \*******************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   render: () => (/* reexport safe */ _node_modules_laravel_mix_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_FirstMessageSender_vue_vue_type_template_id_249d8f5a__WEBPACK_IMPORTED_MODULE_0__.render),
/* harmony export */   staticRenderFns: () => (/* reexport safe */ _node_modules_laravel_mix_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_FirstMessageSender_vue_vue_type_template_id_249d8f5a__WEBPACK_IMPORTED_MODULE_0__.staticRenderFns)
/* harmony export */ });
/* harmony import */ var _node_modules_laravel_mix_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_FirstMessageSender_vue_vue_type_template_id_249d8f5a__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./FirstMessageSender.vue?vue&type=template&id=249d8f5a */ "./node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/components/messanger/FirstMessageSender.vue?vue&type=template&id=249d8f5a");


/***/ })

}]);