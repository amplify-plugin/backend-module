"use strict";
(self["webpackChunkbackend"] = self["webpackChunkbackend"] || []).push([["resources_vue_views_components_order-waiting-approval_OrderWaitingApproval_vue"],{

/***/ "./node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/components/order-waiting-approval/OrderWaitingApproval.vue?vue&type=script&lang=js":
/*!*********************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/components/order-waiting-approval/OrderWaitingApproval.vue?vue&type=script&lang=js ***!
  \*********************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var lodash__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! lodash */ "./node_modules/lodash/lodash.js");
/* harmony import */ var lodash__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(lodash__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var vue_multiselect__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! vue-multiselect */ "./node_modules/vue-multiselect/dist/vue-multiselect.min.js");
/* harmony import */ var vue_multiselect__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(vue_multiselect__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var axios__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! axios */ "./node_modules/axios/lib/axios.js");



/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  components: {
    Multiselect: (vue_multiselect__WEBPACK_IMPORTED_MODULE_1___default())
  },
  props: ['approval_data', 'path'],
  data: function data() {
    return {
      approvalData: JSON.parse(this.approval_data),
      isReadOnly: false
    };
  },
  methods: {
    updateAction: function updateAction(status) {
      var _this = this;
      var notes = this.approvalData.notes;
      if (status == "rejected" && notes.length === 0) {
        ShowNotification('error', 'err_message', 'Please provide order rejected note');
        return;
      }
      axios__WEBPACK_IMPORTED_MODULE_2__["default"].post('/order-rule-track-approval', {
        id: this.approvalData.id,
        notes: notes,
        status: status
      }).then(function (res) {
        if (res.status == 200) {
          ShowNotification('success', 'err_message', res.data.message);
          window.location.href = "/" + _this.path;
        } else {
          ShowNotification('error', 'err_message', 'Something Wrong');
        }
      })["catch"](function (error) {
        ShowNotification('error', 'err_message', error.response.data.message);
      });
    }
  },
  created: function created() {
    this.isReadOnly = this.approvalData.status == 'approved';
  }
});

/***/ }),

/***/ "./node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/components/order-waiting-approval/OrderWaitingApproval.vue?vue&type=template&id=63fd8918&scoped=true":
/*!********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/components/order-waiting-approval/OrderWaitingApproval.vue?vue&type=template&id=63fd8918&scoped=true ***!
  \********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
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
    staticClass: "card"
  }, [_c("div", {
    staticClass: "card-body"
  }, [_c("div", {
    staticClass: "form-group"
  }, [_c("label", [_vm._v(" Order Rule")]), _vm._v(" "), _c("input", {
    staticClass: "form-control",
    attrs: {
      type: "text",
      disabled: ""
    },
    domProps: {
      value: _vm.approvalData.order_rule.name
    }
  })]), _vm._v(" "), _c("div", {
    staticClass: "form-group"
  }, [_c("label", [_vm._v(" Note ")]), _vm._v(" "), _c("textarea", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.approvalData.notes,
      expression: "approvalData.notes"
    }],
    staticClass: "form-control",
    attrs: {
      placeholder: "Enter Approval Note",
      rows: "3",
      readonly: _vm.isReadOnly
    },
    domProps: {
      value: _vm.approvalData.notes
    },
    on: {
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.$set(_vm.approvalData, "notes", $event.target.value);
      }
    }
  })]), _vm._v(" "), _vm.approvalData.status == "pending" ? _c("div", {
    staticClass: "form-group"
  }, [_c("button", {
    staticClass: "btn btn-danger",
    attrs: {
      type: "submit"
    },
    on: {
      click: function click($event) {
        return _vm.updateAction("rejected");
      }
    }
  }, [_vm._v("Rejected")]), _vm._v(" "), _c("button", {
    staticClass: "btn btn-success",
    attrs: {
      type: "submit"
    },
    on: {
      click: function click($event) {
        return _vm.updateAction("approved");
      }
    }
  }, [_vm._v("Approved")])]) : _vm._e()])]);
};
var staticRenderFns = [];
render._withStripped = true;


/***/ }),

/***/ "./resources/vue/views/components/order-waiting-approval/OrderWaitingApproval.vue":
/*!****************************************************************************************!*\
  !*** ./resources/vue/views/components/order-waiting-approval/OrderWaitingApproval.vue ***!
  \****************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _OrderWaitingApproval_vue_vue_type_template_id_63fd8918_scoped_true__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./OrderWaitingApproval.vue?vue&type=template&id=63fd8918&scoped=true */ "./resources/vue/views/components/order-waiting-approval/OrderWaitingApproval.vue?vue&type=template&id=63fd8918&scoped=true");
/* harmony import */ var _OrderWaitingApproval_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./OrderWaitingApproval.vue?vue&type=script&lang=js */ "./resources/vue/views/components/order-waiting-approval/OrderWaitingApproval.vue?vue&type=script&lang=js");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _OrderWaitingApproval_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"],
  _OrderWaitingApproval_vue_vue_type_template_id_63fd8918_scoped_true__WEBPACK_IMPORTED_MODULE_0__.render,
  _OrderWaitingApproval_vue_vue_type_template_id_63fd8918_scoped_true__WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  "63fd8918",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/vue/views/components/order-waiting-approval/OrderWaitingApproval.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/vue/views/components/order-waiting-approval/OrderWaitingApproval.vue?vue&type=script&lang=js":
/*!****************************************************************************************************************!*\
  !*** ./resources/vue/views/components/order-waiting-approval/OrderWaitingApproval.vue?vue&type=script&lang=js ***!
  \****************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_laravel_mix_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_OrderWaitingApproval_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./OrderWaitingApproval.vue?vue&type=script&lang=js */ "./node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/components/order-waiting-approval/OrderWaitingApproval.vue?vue&type=script&lang=js");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_laravel_mix_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_OrderWaitingApproval_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/vue/views/components/order-waiting-approval/OrderWaitingApproval.vue?vue&type=template&id=63fd8918&scoped=true":
/*!**********************************************************************************************************************************!*\
  !*** ./resources/vue/views/components/order-waiting-approval/OrderWaitingApproval.vue?vue&type=template&id=63fd8918&scoped=true ***!
  \**********************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   render: () => (/* reexport safe */ _node_modules_laravel_mix_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_OrderWaitingApproval_vue_vue_type_template_id_63fd8918_scoped_true__WEBPACK_IMPORTED_MODULE_0__.render),
/* harmony export */   staticRenderFns: () => (/* reexport safe */ _node_modules_laravel_mix_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_OrderWaitingApproval_vue_vue_type_template_id_63fd8918_scoped_true__WEBPACK_IMPORTED_MODULE_0__.staticRenderFns)
/* harmony export */ });
/* harmony import */ var _node_modules_laravel_mix_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_OrderWaitingApproval_vue_vue_type_template_id_63fd8918_scoped_true__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./OrderWaitingApproval.vue?vue&type=template&id=63fd8918&scoped=true */ "./node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/components/order-waiting-approval/OrderWaitingApproval.vue?vue&type=template&id=63fd8918&scoped=true");


/***/ })

}]);