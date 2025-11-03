"use strict";
(self["webpackChunkbackend"] = self["webpackChunkbackend"] || []).push([["resources_vue_views_components_password_ForgotPassword_vue"],{

/***/ "./node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/components/password/ForgotPassword.vue?vue&type=script&lang=js":
/*!*************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/components/password/ForgotPassword.vue?vue&type=script&lang=js ***!
  \*************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.esm.js");
/* harmony import */ var vue2_modal__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue2-modal */ "./node_modules/vue2-modal/index.js");


vue__WEBPACK_IMPORTED_MODULE_1__["default"].use(vue2_modal__WEBPACK_IMPORTED_MODULE_0__["default"]);
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  props: {},
  data: function data() {
    return {
      email: '',
      otp: '',
      password: '',
      confirmPassword: '',
      codeSend: false,
      loading: false,
      errorMessage: {
        email: '',
        otp: '',
        password: '',
        confirmPassword: ''
      }
    };
  },
  methods: {
    closeModal: function closeModal() {
      this.otp = '', this.password = '', this.confirmPassword = '', this.codeSend = false, this.errorMessage = {
        email: '',
        otp: '',
        password: '',
        confirmPassword: ''
      };
    },
    sendOtp: function sendOtp() {
      var _this = this;
      this.otp = '';
      this.loading = true;
      axios.post('/password-reset-otp', {
        email: this.email
      }).then(function (res) {
        _this.loading = false;
        if (res.status == 200) {
          _this.errorMessage.email = '';
          _this.$modals.show('otp-modal');
        } else if (res.status == 210) {
          _this.errorMessage.email = res.data.message;
        } else {
          _this.errorMessage.email = 'Something Went Wrong';
        }
      })["catch"](function (error) {
        _this.loading = false;
        _this.errorMessage.email = 'Something Went Wrong';
      });
    },
    resendOtp: function resendOtp() {
      var _this2 = this;
      axios.post('/password-reset-otp', {
        email: this.email
      }).then(function (res) {
        if (res.status == 200) {
          _this2.codeSend = true;
        }
      })["catch"](function (error) {
        _this2.errorMessage.email = 'Something Went Wrong';
      });
    },
    otpCheck: function otpCheck() {
      var _this3 = this;
      this.loading = true;
      axios.post('/otp-check', {
        email: this.email,
        otp: this.otp
      }).then(function (res) {
        _this3.loading = false;
        if (res.status == 200) {
          _this3.$modals.hide('otp-modal');
          _this3.$modals.show('password-modal');
        } else if (res.status == 210) {
          _this3.errorMessage.otp = res.data.message;
        }
      })["catch"](function (error) {
        _this3.loading = false;
        _this3.errorMessage.otp = 'Something Went Wrong';
      });
    },
    resetPassword: function resetPassword() {
      var _this4 = this;
      this.loading = true;
      if (this.password.length < 6) {
        this.errorMessage.password = 'Password Minimum 6 Character';
        this.loading = false;
        return;
      } else {
        this.errorMessage.password = '';
      }
      if (this.password !== this.confirmPassword) {
        this.errorMessage.confirmPassword = 'Confirm Password Not Matched';
        this.loading = false;
        return;
      } else {
        this.errorMessage.confirmPassword = '';
      }
      axios.post('/reset-password', {
        email: this.email,
        password: this.password,
        otp: this.otp
      }).then(function (res) {
        _this4.loading = false;
        ShowNotification('success', 'Authentication', res.data.message);
        if (res.data.success) {
          window.location.href = '/login';
        } else {
          _this4.errorMessage.confirmPassword = res.data.message;
        }
      })["catch"](function (error) {
        _this4.loading = false;
        _this4.errorMessage.otp = 'Something Went Wrong';
      });
    }
  }
});

/***/ }),

/***/ "./node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/components/password/ForgotPassword.vue?vue&type=template&id=38885a4a&scoped=true":
/*!************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/components/password/ForgotPassword.vue?vue&type=template&id=38885a4a&scoped=true ***!
  \************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   render: () => (/* binding */ render),
/* harmony export */   staticRenderFns: () => (/* binding */ staticRenderFns)
/* harmony export */ });
var render = function render() {
  var _vm = this,
    _c = _vm._self._c;
  return _c("div", [_c("form", {
    staticClass: "login-box",
    on: {
      submit: function submit($event) {
        $event.preventDefault();
        return _vm.sendOtp.apply(null, arguments);
      }
    }
  }, [_c("h4", {
    staticClass: "margin-bottom-1x"
  }, [_vm._v("Forgot Your Password ?")]), _vm._v(" "), _c("div", {
    staticClass: "form-group"
  }, [_c("div", {
    staticClass: "input-group"
  }, [_c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.email,
      expression: "email"
    }],
    staticClass: "form-control",
    attrs: {
      type: "email",
      placeholder: "Email",
      required: ""
    },
    domProps: {
      value: _vm.email
    },
    on: {
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.email = $event.target.value;
      }
    }
  }), _vm._v(" "), _vm._m(0)]), _vm._v(" "), _vm.errorMessage.email ? _c("span", {
    staticClass: "invalid-feedback d-block",
    staticStyle: {
      position: "absolute"
    }
  }, [_c("strong", [_vm._v(_vm._s(_vm.errorMessage.email))])]) : _vm._e()]), _vm._v(" "), _c("div", {
    staticClass: "text-center text-sm-right"
  }, [_c("button", {
    staticClass: "btn btn-primary margin-bottom-none",
    attrs: {
      disabled: _vm.loading
    }
  }, [_vm.loading ? _c("span", [_vm._v("Loading...")]) : _c("span", [_vm._v(" Submit")])])])]), _vm._v(" "), _c("vue-modal", {
    attrs: {
      name: "otp-modal",
      "on-close": _vm.closeModal,
      "outer-close": false
    }
  }, [_c("h5", {
    attrs: {
      slot: "header"
    },
    slot: "header"
  }, [_vm._v("Password Reset")]), _vm._v(" "), _c("form", {
    staticClass: "login-box",
    on: {
      submit: function submit($event) {
        $event.preventDefault();
        return _vm.otpCheck.apply(null, arguments);
      }
    }
  }, [_c("h4", {
    staticClass: "margin-bottom-1x"
  }, [_vm._v("Enter The OTP")]), _vm._v(" "), _c("div", {
    staticStyle: {
      "margin-top": "0.5rem"
    }
  }, [_c("div", {
    staticClass: "input-group"
  }, [_c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.otp,
      expression: "otp"
    }],
    staticClass: "form-control",
    attrs: {
      type: "text",
      placeholder: "OTP",
      required: ""
    },
    domProps: {
      value: _vm.otp
    },
    on: {
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.otp = $event.target.value;
      }
    }
  }), _vm._v(" "), _c("span", {
    staticClass: "input-group-addon"
  }, [_c("i", {
    staticClass: "icon-lock"
  })])]), _vm._v(" "), _vm.errorMessage.otp ? _c("span", {
    staticClass: "invalid-feedback d-block"
  }, [_c("strong", [_vm._v(_vm._s(_vm.errorMessage.otp))])]) : _vm._e()]), _vm._v(" "), _vm.codeSend ? _c("span", {
    staticClass: "invalid-feedback d-block",
    staticStyle: {
      "padding-left": "0",
      color: "green"
    }
  }, [_vm._v("OTP Resend To Your Email")]) : _c("span", {
    staticClass: "resend-otp",
    staticStyle: {
      "font-size": "80%"
    },
    on: {
      click: function click($event) {
        return _vm.resendOtp();
      }
    }
  }, [_vm._v("Resend OTP ?")]), _vm._v(" "), _c("div", {
    staticClass: "text-center text-sm-right"
  }, [_c("button", {
    staticClass: "btn btn-primary margin-bottom-none",
    attrs: {
      disabled: _vm.loading
    }
  }, [_vm.loading ? _c("span", [_vm._v("Loading...")]) : _c("span", [_vm._v(" Submit")])])])])]), _vm._v(" "), _c("vue-modal", {
    attrs: {
      name: "password-modal",
      "outer-close": false
    }
  }, [_c("h5", {
    attrs: {
      slot: "header"
    },
    slot: "header"
  }, [_vm._v("Password Reset")]), _vm._v(" "), _c("form", {
    staticClass: "login-box",
    on: {
      submit: function submit($event) {
        $event.preventDefault();
        return _vm.resetPassword.apply(null, arguments);
      }
    }
  }, [_c("h4", {
    staticClass: "margin-bottom-1x"
  }, [_vm._v("Enter Your New Password")]), _vm._v(" "), _c("div", {
    staticStyle: {
      "margin-bottom": "0.5rem"
    }
  }, [_c("div", {
    staticClass: "input-group"
  }, [_c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.password,
      expression: "password"
    }],
    staticClass: "form-control",
    attrs: {
      type: "password",
      placeholder: "Password",
      minlength: "6",
      required: ""
    },
    domProps: {
      value: _vm.password
    },
    on: {
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.password = $event.target.value;
      }
    }
  }), _vm._v(" "), _c("span", {
    staticClass: "input-group-addon"
  }, [_c("i", {
    staticClass: "icon-lock"
  })])]), _vm._v(" "), _vm.errorMessage.password ? _c("span", {
    staticClass: "invalid-feedback d-block"
  }, [_c("strong", [_vm._v(_vm._s(_vm.errorMessage.password))])]) : _vm._e()]), _vm._v(" "), _c("div", {
    staticClass: "form-group"
  }, [_c("div", {
    staticClass: "input-group"
  }, [_c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.confirmPassword,
      expression: "confirmPassword"
    }],
    staticClass: "form-control",
    attrs: {
      type: "password",
      placeholder: "Confirm Password",
      minlength: "6",
      required: ""
    },
    domProps: {
      value: _vm.confirmPassword
    },
    on: {
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.confirmPassword = $event.target.value;
      }
    }
  }), _vm._v(" "), _c("span", {
    staticClass: "input-group-addon"
  }, [_c("i", {
    staticClass: "icon-lock"
  })])]), _vm._v(" "), _vm.errorMessage.confirmPassword ? _c("span", {
    staticClass: "invalid-feedback d-block"
  }, [_c("strong", [_vm._v(_vm._s(_vm.errorMessage.confirmPassword))])]) : _vm._e()]), _vm._v(" "), _c("div", {
    staticClass: "text-center text-sm-right"
  }, [_c("button", {
    staticClass: "btn btn-primary margin-bottom-none",
    attrs: {
      disabled: _vm.loading
    }
  }, [_vm.loading ? _c("span", [_vm._v("Loading...")]) : _c("span", [_vm._v(" Submit")])])])])])], 1);
};
var staticRenderFns = [function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("span", {
    staticClass: "input-group-addon"
  }, [_c("i", {
    staticClass: "icon-mail"
  })]);
}];
render._withStripped = true;


/***/ }),

/***/ "./node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-12.use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/laravel-mix/node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-12.use[2]!./node_modules/sass-loader/dist/cjs.js??clonedRuleSet-12.use[3]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./node_modules/vue2-modal/components/modal.vue?vue&type=style&index=0&id=44578f60&lang=scss":
/*!***************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-12.use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/laravel-mix/node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-12.use[2]!./node_modules/sass-loader/dist/cjs.js??clonedRuleSet-12.use[3]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./node_modules/vue2-modal/components/modal.vue?vue&type=style&index=0&id=44578f60&lang=scss ***!
  \***************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _laravel_mix_node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../laravel-mix/node_modules/css-loader/dist/runtime/api.js */ "./node_modules/laravel-mix/node_modules/css-loader/dist/runtime/api.js");
/* harmony import */ var _laravel_mix_node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_laravel_mix_node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0__);
// Imports

var ___CSS_LOADER_EXPORT___ = _laravel_mix_node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0___default()(function(i){return i[1]});
// Module
___CSS_LOADER_EXPORT___.push([module.id, ".v-modal {\n  /* Modal transition styles */\n}\n.v-modal__mask {\n  position: fixed;\n  z-index: 9998;\n  top: 0;\n  left: 0;\n  width: 100%;\n  height: 100%;\n  background-color: rgba(0, 0, 0, 0.5);\n  transition: opacity 0.3s ease;\n  overflow-y: scroll;\n}\n.v-modal__wrapper {\n  width: 100%;\n}\n.v-modal__content {\n  margin: 0px auto;\n  margin-bottom: 5%;\n  margin-top: 5%;\n  width: 50%;\n  background-color: #fff;\n  transition: all 0.5s ease;\n}\n.v-modal__content.xlg {\n  width: 85%;\n}\n.v-modal__content.lg {\n  width: 70%;\n}\n.v-modal__content.md {\n  width: 50%;\n}\n.v-modal__content.sm {\n  width: 25%;\n}\n.v-modal__content.xsm {\n  width: 15%;\n}\n.v-modal__heading {\n  padding: 20px;\n  display: flex;\n  align-items: center;\n}\n.v-modal__heading .v-modal__title h1, .v-modal__heading .v-modal__title h2, .v-modal__heading .v-modal__title h3, .v-modal__heading .v-modal__title h4, .v-modal__heading .v-modal__title h5 {\n  padding: 0px;\n  margin: 0px;\n}\n.v-modal__heading .v-modal__close-btn {\n  margin-left: auto;\n  font-size: 20px;\n  line-height: 22px;\n  cursor: pointer;\n  font-weight: 700;\n}\n.v-modal__body {\n  padding: 20px;\n  padding-top: 0px;\n}\n.v-modal__no-scroll {\n  overflow: hidden;\n}\n.v-modal-zoom-out-enter {\n  opacity: 0;\n}\n.v-modal-zoom-out-enter .v-modal__content {\n  web-kit-transform: scale(2);\n  moz-transform: scale(2);\n  ms-transform: scale(2);\n  o-transform: scale(2);\n  transform: scale(2);\n}\n.v-modal-zoom-out-leave-active {\n  opacity: 0;\n}\n.v-modal-zoom-out-leave-active .v-modal__content {\n  web-kit-transform: scale(2);\n  moz-transform: scale(2);\n  ms-transform: scale(2);\n  o-transform: scale(2);\n  transform: scale(2);\n}\n.v-modal-zoom-in-enter {\n  opacity: 0;\n}\n.v-modal-zoom-in-enter .v-modal__content {\n  web-kit-transform: scale(0.5);\n  moz-transform: scale(0.5);\n  ms-transform: scale(0.5);\n  o-transform: scale(0.5);\n  transform: scale(0.5);\n}\n.v-modal-zoom-in-leave-active {\n  opacity: 0;\n}\n.v-modal-zoom-in-leave-active .v-modal__content {\n  web-kit-transform: scale(0.5);\n  moz-transform: scale(0.5);\n  ms-transform: scale(0.5);\n  o-transform: scale(0.5);\n  transform: scale(0.5);\n}\n.v-modal-fade-enter {\n  opacity: 0;\n}\n.v-modal-fade-leave-active {\n  opacity: 0;\n}\n.v-modal-slide-in-top-enter {\n  opacity: 0;\n}\n.v-modal-slide-in-top-enter .v-modal__content {\n  web-kit-transform: translateY(-100px);\n  moz-transform: translateY(-100px);\n  ms-transform: translateY(-100px);\n  o-transform: translateY(-100px);\n  transform: translateY(-100px);\n}\n.v-modal-slide-in-top-leave-active {\n  opacity: 0;\n}\n.v-modal-slide-in-top-leave-active .v-modal__content {\n  web-kit-transform: translateY(-100px);\n  moz-transform: translateY(-100px);\n  ms-transform: translateY(-100px);\n  o-transform: translateY(-100px);\n  transform: translateY(-100px);\n}\n@media screen and (max-width: 600px) {\n.v-modal__content {\n    width: 100%;\n    margin-top: 0px;\n}\n}", ""]);
// Exports
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (___CSS_LOADER_EXPORT___);


/***/ }),

/***/ "./node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/laravel-mix/node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/components/password/ForgotPassword.vue?vue&type=style&index=0&id=38885a4a&scoped=true&lang=css":
/*!**********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/laravel-mix/node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/components/password/ForgotPassword.vue?vue&type=style&index=0&id=38885a4a&scoped=true&lang=css ***!
  \**********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_laravel_mix_node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../../../../node_modules/laravel-mix/node_modules/css-loader/dist/runtime/api.js */ "./node_modules/laravel-mix/node_modules/css-loader/dist/runtime/api.js");
/* harmony import */ var _node_modules_laravel_mix_node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_laravel_mix_node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0__);
// Imports

var ___CSS_LOADER_EXPORT___ = _node_modules_laravel_mix_node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0___default()(function(i){return i[1]});
// Module
___CSS_LOADER_EXPORT___.push([module.id, "\n.resend-otp[data-v-38885a4a] {\r\n    cursor: pointer;\r\n    color: #094a75;\n}\n.resend-otp[data-v-38885a4a]:hover {\r\n    color: #0da9ef;\n}\r\n", ""]);
// Exports
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (___CSS_LOADER_EXPORT___);


/***/ }),

/***/ "./node_modules/laravel-mix/node_modules/style-loader/dist/cjs.js!./node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-12.use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/laravel-mix/node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-12.use[2]!./node_modules/sass-loader/dist/cjs.js??clonedRuleSet-12.use[3]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./node_modules/vue2-modal/components/modal.vue?vue&type=style&index=0&id=44578f60&lang=scss":
/*!********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/laravel-mix/node_modules/style-loader/dist/cjs.js!./node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-12.use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/laravel-mix/node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-12.use[2]!./node_modules/sass-loader/dist/cjs.js??clonedRuleSet-12.use[3]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./node_modules/vue2-modal/components/modal.vue?vue&type=style&index=0&id=44578f60&lang=scss ***!
  \********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _laravel_mix_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! !../../laravel-mix/node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js */ "./node_modules/laravel-mix/node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js");
/* harmony import */ var _laravel_mix_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_laravel_mix_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _laravel_mix_node_modules_css_loader_dist_cjs_js_clonedRuleSet_12_use_1_vue_loader_lib_loaders_stylePostLoader_js_laravel_mix_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_12_use_2_sass_loader_dist_cjs_js_clonedRuleSet_12_use_3_vue_loader_lib_index_js_vue_loader_options_modal_vue_vue_type_style_index_0_id_44578f60_lang_scss__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! !!../../laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-12.use[1]!../../vue-loader/lib/loaders/stylePostLoader.js!../../laravel-mix/node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-12.use[2]!../../sass-loader/dist/cjs.js??clonedRuleSet-12.use[3]!../../vue-loader/lib/index.js??vue-loader-options!./modal.vue?vue&type=style&index=0&id=44578f60&lang=scss */ "./node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-12.use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/laravel-mix/node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-12.use[2]!./node_modules/sass-loader/dist/cjs.js??clonedRuleSet-12.use[3]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./node_modules/vue2-modal/components/modal.vue?vue&type=style&index=0&id=44578f60&lang=scss");

            

var options = {};

options.insert = "head";
options.singleton = false;

var update = _laravel_mix_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default()(_laravel_mix_node_modules_css_loader_dist_cjs_js_clonedRuleSet_12_use_1_vue_loader_lib_loaders_stylePostLoader_js_laravel_mix_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_12_use_2_sass_loader_dist_cjs_js_clonedRuleSet_12_use_3_vue_loader_lib_index_js_vue_loader_options_modal_vue_vue_type_style_index_0_id_44578f60_lang_scss__WEBPACK_IMPORTED_MODULE_1__["default"], options);



/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_laravel_mix_node_modules_css_loader_dist_cjs_js_clonedRuleSet_12_use_1_vue_loader_lib_loaders_stylePostLoader_js_laravel_mix_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_12_use_2_sass_loader_dist_cjs_js_clonedRuleSet_12_use_3_vue_loader_lib_index_js_vue_loader_options_modal_vue_vue_type_style_index_0_id_44578f60_lang_scss__WEBPACK_IMPORTED_MODULE_1__["default"].locals || {});

/***/ }),

/***/ "./node_modules/laravel-mix/node_modules/style-loader/dist/cjs.js!./node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/laravel-mix/node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/components/password/ForgotPassword.vue?vue&type=style&index=0&id=38885a4a&scoped=true&lang=css":
/*!***************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/laravel-mix/node_modules/style-loader/dist/cjs.js!./node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/laravel-mix/node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/components/password/ForgotPassword.vue?vue&type=style&index=0&id=38885a4a&scoped=true&lang=css ***!
  \***************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_laravel_mix_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! !../../../../../node_modules/laravel-mix/node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js */ "./node_modules/laravel-mix/node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js");
/* harmony import */ var _node_modules_laravel_mix_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_laravel_mix_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _node_modules_laravel_mix_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_laravel_mix_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_ForgotPassword_vue_vue_type_style_index_0_id_38885a4a_scoped_true_lang_css__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! !!../../../../../node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../node_modules/laravel-mix/node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ForgotPassword.vue?vue&type=style&index=0&id=38885a4a&scoped=true&lang=css */ "./node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/laravel-mix/node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/components/password/ForgotPassword.vue?vue&type=style&index=0&id=38885a4a&scoped=true&lang=css");

            

var options = {};

options.insert = "head";
options.singleton = false;

var update = _node_modules_laravel_mix_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default()(_node_modules_laravel_mix_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_laravel_mix_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_ForgotPassword_vue_vue_type_style_index_0_id_38885a4a_scoped_true_lang_css__WEBPACK_IMPORTED_MODULE_1__["default"], options);



/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_laravel_mix_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_laravel_mix_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_ForgotPassword_vue_vue_type_style_index_0_id_38885a4a_scoped_true_lang_css__WEBPACK_IMPORTED_MODULE_1__["default"].locals || {});

/***/ }),

/***/ "./node_modules/vue2-modal/components/modal.vue":
/*!******************************************************!*\
  !*** ./node_modules/vue2-modal/components/modal.vue ***!
  \******************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _modal_vue_vue_type_template_id_44578f60__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./modal.vue?vue&type=template&id=44578f60 */ "./node_modules/vue2-modal/components/modal.vue?vue&type=template&id=44578f60");
/* harmony import */ var _modal_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./modal.vue?vue&type=script&lang=js */ "./node_modules/vue2-modal/components/modal.vue?vue&type=script&lang=js");
/* harmony import */ var _modal_vue_vue_type_style_index_0_id_44578f60_lang_scss__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./modal.vue?vue&type=style&index=0&id=44578f60&lang=scss */ "./node_modules/vue2-modal/components/modal.vue?vue&type=style&index=0&id=44578f60&lang=scss");
/* harmony import */ var _vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! !../../vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");



;


/* normalize component */

var component = (0,_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__["default"])(
  _modal_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"],
  _modal_vue_vue_type_template_id_44578f60__WEBPACK_IMPORTED_MODULE_0__.render,
  _modal_vue_vue_type_template_id_44578f60__WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "node_modules/vue2-modal/components/modal.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./node_modules/vue-loader/lib/index.js??vue-loader-options!./node_modules/vue2-modal/components/modal.vue?vue&type=script&lang=js":
/*!*****************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/index.js??vue-loader-options!./node_modules/vue2-modal/components/modal.vue?vue&type=script&lang=js ***!
  \*****************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });

    /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
        name: 'v-modal',

        props: {
            /**
             * Defines a static height for the modal.
             *
             * @type {String|Number|null}
             */
            height: {
                type: [ String, Number ],
                required: false
            },

            /**
             * Hides the close button.
             *
             * @type Boolean
             */
            hideCloseBtn: {
                type: Boolean,
                default: false
            },

            /**
             * Lifecycle hook that runs after a modal closes.
             *
             * @type {Function|null}
             */
            onClose: {
                type: Function,
                required: false
            },

            /**
             * Lifecycle hook that runs after a modal opens.
             *
             * @type {Function|null}
             */
            onShow: {
                type: Function,
                required: false
            },

            /**
             * Disables clicking grey space around modal
             * to close the modal.
             *
             * @type {Boolean|null}
             */
            outerClose: {
                type: Boolean,
                default: true
            },

            /**
             * Unique identifier for modal.
             *
             * @type {String}
             */
            name: {
                type: String,
                required: true
            },

            /**
             * Defined sizing for modal.
             * Can be defined as xsm, sm, md, lg, or xlg
             *
             * @type {String|null}
             */
            size: {
                type: String,
                required: false,
                validator(val) {
                    return val === 'xsm' ||
                        val === 'sm' ||
                        val === 'md' ||
                        val === 'lg' ||
                        val === 'xlg';
                }
            },

            /**
             * Custom css styling to apply to modal.
             *
             * @type {String|null}
             */
            theme: {
                type: String,
                required: false
            },

            /**
             * Defines the transition that occurs when
             * a modal enters the screen. Can be defined
             * as zoom-out, zoom-in, fade and slide-in-top.
             *
             * @type {String|null}
             */
            transitionName: {
                type: String,
                default: 'zoom-out',
                validator(val) {
                    return val === 'zoom-out' ||
                           val === 'zoom-in' ||
                           val === 'fade' ||
                           val === 'slide-in-top';
                }
            },

            /**
             * Defines a static width for the modal.
             *
             * @type {String|Number|null}
             */
            width: {
                type: [ String, Number ],
                required: false
            },
        },

        data() {
            return {
                modals: null,
                show: false,
                id: null,
                style: ''
            }
        },

        watch: {
            modals() {
                this.showModal();
            },

            show(val) {
                if (val && this.onShow) {
                    this.onShow();
                }
            }
        },

        methods: {
            close (location) {
                if (location === 'outer' && !this.outerClose) return;

                this.$modals.hide(this.name);
                if (this.onClose) this.onClose();
                this.$emit('close-modal', this.name);
                document.body.classList.remove('v-modal__no-scroll');
            },

            showModal() {
                this.show = this.$modals.isActive(this.name);
                if (this.show) {
                    document.body.classList.add('v-modal__no-scroll');

                    this.centerModal();
                }
            },

            centerModal() {
                var modal = document.getElementById(this.id);

                if (modal) {
                    var margin = (window.innerWidth - modal.offsetWidth) / 2;
                    modal.style.marginLeft = margin + 'px';
                }
            }
        },

        created() {
            this.modals = this.$modals.shown();

            this.$modals.mount(this.name);
            this.id = 'v-modal-' + this.$modals.all().indexOf(this.name);
        },

        mounted() {
            if (this.width) {
                this.style = this.style + 'width: ' + this.width + 'px;';
            }

            if (this.height) {
                this.style = this.style + 'height: ' + this.height + 'px;';
            }
        }
    });


/***/ }),

/***/ "./resources/vue/views/components/password/ForgotPassword.vue":
/*!********************************************************************!*\
  !*** ./resources/vue/views/components/password/ForgotPassword.vue ***!
  \********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _ForgotPassword_vue_vue_type_template_id_38885a4a_scoped_true__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./ForgotPassword.vue?vue&type=template&id=38885a4a&scoped=true */ "./resources/vue/views/components/password/ForgotPassword.vue?vue&type=template&id=38885a4a&scoped=true");
/* harmony import */ var _ForgotPassword_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./ForgotPassword.vue?vue&type=script&lang=js */ "./resources/vue/views/components/password/ForgotPassword.vue?vue&type=script&lang=js");
/* harmony import */ var _ForgotPassword_vue_vue_type_style_index_0_id_38885a4a_scoped_true_lang_css__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./ForgotPassword.vue?vue&type=style&index=0&id=38885a4a&scoped=true&lang=css */ "./resources/vue/views/components/password/ForgotPassword.vue?vue&type=style&index=0&id=38885a4a&scoped=true&lang=css");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");



;


/* normalize component */

var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__["default"])(
  _ForgotPassword_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"],
  _ForgotPassword_vue_vue_type_template_id_38885a4a_scoped_true__WEBPACK_IMPORTED_MODULE_0__.render,
  _ForgotPassword_vue_vue_type_template_id_38885a4a_scoped_true__WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  "38885a4a",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/vue/views/components/password/ForgotPassword.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/vue/views/components/password/ForgotPassword.vue?vue&type=script&lang=js":
/*!********************************************************************************************!*\
  !*** ./resources/vue/views/components/password/ForgotPassword.vue?vue&type=script&lang=js ***!
  \********************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_laravel_mix_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ForgotPassword_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ForgotPassword.vue?vue&type=script&lang=js */ "./node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/components/password/ForgotPassword.vue?vue&type=script&lang=js");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_laravel_mix_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ForgotPassword_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/vue/views/components/password/ForgotPassword.vue?vue&type=template&id=38885a4a&scoped=true":
/*!**************************************************************************************************************!*\
  !*** ./resources/vue/views/components/password/ForgotPassword.vue?vue&type=template&id=38885a4a&scoped=true ***!
  \**************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   render: () => (/* reexport safe */ _node_modules_laravel_mix_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_ForgotPassword_vue_vue_type_template_id_38885a4a_scoped_true__WEBPACK_IMPORTED_MODULE_0__.render),
/* harmony export */   staticRenderFns: () => (/* reexport safe */ _node_modules_laravel_mix_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_ForgotPassword_vue_vue_type_template_id_38885a4a_scoped_true__WEBPACK_IMPORTED_MODULE_0__.staticRenderFns)
/* harmony export */ });
/* harmony import */ var _node_modules_laravel_mix_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_ForgotPassword_vue_vue_type_template_id_38885a4a_scoped_true__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ForgotPassword.vue?vue&type=template&id=38885a4a&scoped=true */ "./node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/components/password/ForgotPassword.vue?vue&type=template&id=38885a4a&scoped=true");


/***/ }),

/***/ "./node_modules/vue2-modal/components/modal.vue?vue&type=style&index=0&id=44578f60&lang=scss":
/*!***************************************************************************************************!*\
  !*** ./node_modules/vue2-modal/components/modal.vue?vue&type=style&index=0&id=44578f60&lang=scss ***!
  \***************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _laravel_mix_node_modules_style_loader_dist_cjs_js_laravel_mix_node_modules_css_loader_dist_cjs_js_clonedRuleSet_12_use_1_vue_loader_lib_loaders_stylePostLoader_js_laravel_mix_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_12_use_2_sass_loader_dist_cjs_js_clonedRuleSet_12_use_3_vue_loader_lib_index_js_vue_loader_options_modal_vue_vue_type_style_index_0_id_44578f60_lang_scss__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../laravel-mix/node_modules/style-loader/dist/cjs.js!../../laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-12.use[1]!../../vue-loader/lib/loaders/stylePostLoader.js!../../laravel-mix/node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-12.use[2]!../../sass-loader/dist/cjs.js??clonedRuleSet-12.use[3]!../../vue-loader/lib/index.js??vue-loader-options!./modal.vue?vue&type=style&index=0&id=44578f60&lang=scss */ "./node_modules/laravel-mix/node_modules/style-loader/dist/cjs.js!./node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-12.use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/laravel-mix/node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-12.use[2]!./node_modules/sass-loader/dist/cjs.js??clonedRuleSet-12.use[3]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./node_modules/vue2-modal/components/modal.vue?vue&type=style&index=0&id=44578f60&lang=scss");


/***/ }),

/***/ "./resources/vue/views/components/password/ForgotPassword.vue?vue&type=style&index=0&id=38885a4a&scoped=true&lang=css":
/*!****************************************************************************************************************************!*\
  !*** ./resources/vue/views/components/password/ForgotPassword.vue?vue&type=style&index=0&id=38885a4a&scoped=true&lang=css ***!
  \****************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_laravel_mix_node_modules_style_loader_dist_cjs_js_node_modules_laravel_mix_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_laravel_mix_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_ForgotPassword_vue_vue_type_style_index_0_id_38885a4a_scoped_true_lang_css__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/laravel-mix/node_modules/style-loader/dist/cjs.js!../../../../../node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../node_modules/laravel-mix/node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ForgotPassword.vue?vue&type=style&index=0&id=38885a4a&scoped=true&lang=css */ "./node_modules/laravel-mix/node_modules/style-loader/dist/cjs.js!./node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/laravel-mix/node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/components/password/ForgotPassword.vue?vue&type=style&index=0&id=38885a4a&scoped=true&lang=css");


/***/ }),

/***/ "./node_modules/vue2-modal/components/modal.vue?vue&type=script&lang=js":
/*!******************************************************************************!*\
  !*** ./node_modules/vue2-modal/components/modal.vue?vue&type=script&lang=js ***!
  \******************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _vue_loader_lib_index_js_vue_loader_options_modal_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../vue-loader/lib/index.js??vue-loader-options!./modal.vue?vue&type=script&lang=js */ "./node_modules/vue-loader/lib/index.js??vue-loader-options!./node_modules/vue2-modal/components/modal.vue?vue&type=script&lang=js");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_vue_loader_lib_index_js_vue_loader_options_modal_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./node_modules/vue2-modal/components/modal.vue?vue&type=template&id=44578f60":
/*!************************************************************************************!*\
  !*** ./node_modules/vue2-modal/components/modal.vue?vue&type=template&id=44578f60 ***!
  \************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   render: () => (/* reexport safe */ _vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_vue_loader_lib_index_js_vue_loader_options_modal_vue_vue_type_template_id_44578f60__WEBPACK_IMPORTED_MODULE_0__.render),
/* harmony export */   staticRenderFns: () => (/* reexport safe */ _vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_vue_loader_lib_index_js_vue_loader_options_modal_vue_vue_type_template_id_44578f60__WEBPACK_IMPORTED_MODULE_0__.staticRenderFns)
/* harmony export */ });
/* harmony import */ var _vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_vue_loader_lib_index_js_vue_loader_options_modal_vue_vue_type_template_id_44578f60__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!../../vue-loader/lib/index.js??vue-loader-options!./modal.vue?vue&type=template&id=44578f60 */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./node_modules/vue2-modal/components/modal.vue?vue&type=template&id=44578f60");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./node_modules/vue2-modal/components/modal.vue?vue&type=template&id=44578f60":
/*!****************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./node_modules/vue2-modal/components/modal.vue?vue&type=template&id=44578f60 ***!
  \****************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   render: () => (/* binding */ render),
/* harmony export */   staticRenderFns: () => (/* binding */ staticRenderFns)
/* harmony export */ });
var render = function render() {
  var _vm = this,
    _c = _vm._self._c
  return _c(
    "transition",
    { attrs: { name: "v-modal-" + _vm.transitionName } },
    [
      _vm.show
        ? _c(
            "div",
            {
              staticClass: "v-modal__mask",
              on: {
                click: function ($event) {
                  if ($event.target !== $event.currentTarget) return null
                  return _vm.close("outer")
                },
              },
            },
            [
              _c(
                "div",
                {
                  staticClass: "v-modal__wrapper",
                  style: _vm.theme,
                  on: {
                    click: function ($event) {
                      if ($event.target !== $event.currentTarget) return null
                      return _vm.close("outer")
                    },
                  },
                },
                [
                  _c(
                    "div",
                    {
                      staticClass: "v-modal__content",
                      class: _vm.size,
                      style: _vm.style,
                      attrs: { id: _vm.id },
                    },
                    [
                      _c("div", { staticClass: "v-modal__panel" }, [
                        _c("div", { staticClass: "v-modal__heading" }, [
                          _c(
                            "div",
                            { staticClass: "v-modal__title" },
                            [_vm._t("header")],
                            2
                          ),
                          _vm._v(" "),
                          !_vm.hideCloseBtn
                            ? _c(
                                "span",
                                {
                                  staticClass: "v-modal__close-btn",
                                  on: {
                                    click: function ($event) {
                                      return _vm.close("inner")
                                    },
                                  },
                                },
                                [_vm._v("×")]
                              )
                            : _vm._e(),
                        ]),
                        _vm._v(" "),
                        _c(
                          "div",
                          { staticClass: "v-modal__body" },
                          [_vm._t("default")],
                          2
                        ),
                      ]),
                    ]
                  ),
                ]
              ),
            ]
          )
        : _vm._e(),
    ]
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue2-modal/index.js":
/*!******************************************!*\
  !*** ./node_modules/vue2-modal/index.js ***!
  \******************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _components_modal_vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./components/modal.vue */ "./node_modules/vue2-modal/components/modal.vue");


const install = function (Vue, options) {
    Vue.component('vue-modal', _components_modal_vue__WEBPACK_IMPORTED_MODULE_0__["default"]);

    Vue.prototype.$modals = {
        /**
         * Modals that are currently shown.
         *
         * @var array
         */
        shownModals: new Array(),

        /**
         * All modals loaded to the view app.
         *
         * @var array
         */
        allModals: new Array(),

        /**
         * Shows a named modal.
         *
         * @param string modalName
         *
         * @return void
         */
        show: function (modalName) {
            this.shownModals.indexOf(modalName) == -1 ? this.shownModals.push(modalName) : null;
            if (options && options.logging) {
                console.log('Show modal: ' + modalName);
                console.log('All modals showing: ', this.shownModals);
            }
        },

        /**
         * Hides a named modal.
         *
         * @param string| array modalNames
         *
         * @return void
         */
        hide: function (modalNames) {
            /* Removes the scroll lock */
            document.body.classList.remove('v-modal__no-scroll');

            if (modalNames.constructor === Array) {
                var _this = this;
                modalNames.forEach(function (modalName) {
                    var ind = _this.shownModals.indexOf(modalName);
                    _this.shownModals.splice(ind, 1);
                });
            } else {
                var ind = this.shownModals.indexOf(modalNames);
                this.shownModals.splice(ind, 1);
            }
            if (options && options.logging) {
                console.log('Removed modal: ' + modalNames);
                console.log('All shown modals: ', this.shownModals);
            }
        },

        /**
         * Determines if a modal should be shown or not.
         *
         * @param string modalName
         *
         * @return boolean
         */
        isActive: function (modalName) {
            return this.shownModals.indexOf(modalName) > -1;
        },

        /**
         * Return all modals that are currently shown.
         *
         * @return array
         */
        shown: function () {
            return this.shownModals;
        },

        /**
         * Return all modals bound to the current Vue context.
         *
         * @return array
         */
        all: function () {
            return this.allModals;
        },

        /**
         * Mount a new modal to the state.
         *
         * @return null
         */
        mount: function (name) {
            if (this.allModals.indexOf(name) == -1) {
                this.allModals.push(name);
            } else if (options && options.logging) {
                console.log('The modal name "' + name + '" has already been mounted.');
            }
        }

    }
}

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (install);


/***/ })

}]);