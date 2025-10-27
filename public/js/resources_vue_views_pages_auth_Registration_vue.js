"use strict";
(self["webpackChunkbackend"] = self["webpackChunkbackend"] || []).push([["resources_vue_views_pages_auth_Registration_vue"],{

/***/ "./node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/pages/auth/Registration.vue?vue&type=script&lang=js":
/*!**************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/pages/auth/Registration.vue?vue&type=script&lang=js ***!
  \**************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _register_default_Index__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./register/default/Index */ "./resources/vue/views/pages/auth/register/default/Index.vue");
/* harmony import */ var _register_cal_tool_Index__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./register/cal-tool/Index */ "./resources/vue/views/pages/auth/register/cal-tool/Index.vue");


/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  name: 'Registration',
  props: ['register_button_title', 'axios_url', 'honeypot_config', 'admin_tab_title', 'company_tab_title', 'captcha_verification', 'token', 'industry_classifications', 'amplify_client_code'],
  components: {
    DefaultRegistration: _register_default_Index__WEBPACK_IMPORTED_MODULE_0__["default"],
    CalToolRegistration: _register_cal_tool_Index__WEBPACK_IMPORTED_MODULE_1__["default"]
  },
  data: function data() {
    return {
      registrationScreen: null,
      honeypot: JSON.parse(this.honeypot_config),
      form: {
        _token: this.token,
        customer_name: '',
        admin_name: '',
        admin_phone: '',
        admin_email: '',
        password: '',
        password_confirmation: '',
        email: '',
        phone: '',
        industry_classification_id: '',
        captcha: '',
        address: [{
          address_name: '',
          address_1: '',
          address_2: '',
          address_3: '',
          city: '',
          state: '',
          country_code: '',
          zip_code: ''
        }]
      },
      calToolProps: {
        register_button_title: this.register_button_title,
        axios_url: this.axios_url,
        honeypot_config: this.honeypot_config,
        current_customer_tab_title: "I AM A CURRENT CUSTOMER BUT NEED AN ONLINE ACCOUNT",
        new_commercial_account_tab_title: "NEW COMMERCIAL ACCOUNT",
        new_retail_customer_tab_title: "NEW RETAIL CUSTOMER ACCOUNT",
        captcha_verification: this.captcha_verification,
        token: this.token,
        industry_classifications: this.industry_classifications,
        amplify_client_code: this.amplify_client_code
      }
    };
  },
  mounted: function mounted() {
    if (this.amplify_client_code === 'ACT') {
      this.registrationScreen = _register_cal_tool_Index__WEBPACK_IMPORTED_MODULE_1__["default"];
    } else {
      this.registrationScreen = _register_default_Index__WEBPACK_IMPORTED_MODULE_0__["default"];
    }
  }
});

/***/ }),

/***/ "./node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/pages/auth/register/cal-tool/CommercialAccount.vue?vue&type=script&lang=js":
/*!*************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/pages/auth/register/cal-tool/CommercialAccount.vue?vue&type=script&lang=js ***!
  \*************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  name: 'CommercialAccount',
  data: function data() {
    return {
      creditApplicationLink: 'https://www.commercialcreditapps.com/BusinessIQ/credec/caps/pla/loadAppInternalPLAPage?addEditFlag=A&appTemplateId=7hFczQIRXD8WXIzHVmS%2BHg%3D%3D&appTemplateToken=3166'
    };
  }
});

/***/ }),

/***/ "./node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/pages/auth/register/cal-tool/CurrentCustomer.vue?vue&type=script&lang=js":
/*!***********************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/pages/auth/register/cal-tool/CurrentCustomer.vue?vue&type=script&lang=js ***!
  \***********************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  name: 'CurrentCustomer',
  props: [],
  data: function data() {
    return {};
  },
  methods: {
    validateData: function validateData() {
      // Reset previous validation errors
      this.$parent.removeErrors();
      var form = this.$parent.form;

      // Validate account number
      if (!form.account_number) {
        this.$parent.pushError('account_number', 'Account number is required.');
      }

      // Validate first name
      if (!form.name) {
        this.$parent.pushError('name', 'Name is required.');
      }

      // Validate email
      if (!form.email) {
        this.$parent.pushError('email', 'Email is required.');
      } else if (!this.validateEmail(form.email)) {
        this.$parent.pushError('email', 'Email format is invalid.');
      }

      // Validate password
      if (!form.password) {
        this.$parent.pushError('password', 'Password is required.');
      }

      // Validate password confirmation
      if (!form.password_confirmation) {
        this.$parent.pushError('password_confirmation', 'Password confirmation is required.');
      } else if (form.password !== form.password_confirmation) {
        this.$parent.pushError('password_confirmation', 'Passwords do not match.');
      }

      // If no validation errors, proceed to save data
      if (Object.keys(this.$parent.validationErrors).length === 0) {
        this.$parent.saveData();
      } else {
        // Show notification for validation errors
        ShowNotification('error', 'Registration', 'Please correct the errors in the form.');
      }
    },
    validateEmail: function validateEmail(email) {
      var re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      return re.test(String(email).toLowerCase());
    }
  }
});

/***/ }),

/***/ "./node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/pages/auth/register/cal-tool/Index.vue?vue&type=script&lang=js":
/*!*************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/pages/auth/register/cal-tool/Index.vue?vue&type=script&lang=js ***!
  \*************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _CurrentCustomer_vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./CurrentCustomer.vue */ "./resources/vue/views/pages/auth/register/cal-tool/CurrentCustomer.vue");
/* harmony import */ var _CommercialAccount_vue__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./CommercialAccount.vue */ "./resources/vue/views/pages/auth/register/cal-tool/CommercialAccount.vue");
/* harmony import */ var _RetailCustomer_vue__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./RetailCustomer.vue */ "./resources/vue/views/pages/auth/register/cal-tool/RetailCustomer.vue");



/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  name: 'CalToolRegistration',
  components: {
    CurrentCustomer: _CurrentCustomer_vue__WEBPACK_IMPORTED_MODULE_0__["default"],
    CommercialAccount: _CommercialAccount_vue__WEBPACK_IMPORTED_MODULE_1__["default"],
    RetailCustomer: _RetailCustomer_vue__WEBPACK_IMPORTED_MODULE_2__["default"]
  },
  props: ['register_button_title', 'axios_url', 'honeypot_config', 'new_retail_customer_tab_title', 'current_customer_tab_title', 'new_commercial_account_tab_title', 'captcha_verification', 'token', 'industry_classifications', 'amplify_client_code'],
  data: function data() {
    return {
      step: 'current_customer',
      captchaVerificationEnabled: this.captcha_verification === 'true',
      captchaVerified: false,
      honeypot: JSON.parse(this.honeypot_config),
      industryClassifications: JSON.parse(this.industry_classifications),
      form: {},
      validationErrors: {}
    };
  },
  mounted: function mounted() {
    if (!this.captchaVerificationEnabled) {
      this.captchaVerified = true;
    }
    if (this.honeypot.enabled) {
      this.form[this.honeypot.nameFieldName] = '';
      this.form[this.honeypot.validFromFieldName] = this.honeypot.encryptedValidFrom;
    }
    this.initializeForm('current_customer');
    removeFullPageLoader();
  },
  methods: {
    initializeForm: function initializeForm(step) {
      this.step = step;
      this.validationErrors = {};
      if (step === 'current_customer') {
        // Set form structure for Current Customer
        this.form = {
          account_number: '',
          name: '',
          email: '',
          password: '',
          password_confirmation: '',
          newsletter_subscription: true,
          form_type: 'current_customer'
        };
      } else if (step === 'new_retail_customer') {
        // Set form structure for Retail Customer
        this.form = {
          name: '',
          company_name: '',
          email: '',
          phone_number: '',
          password: '',
          password_confirmation: '',
          industry_classification_id: '',
          address: [{
            address_name: '',
            address_1: '',
            address_2: '',
            address_3: '',
            city: '',
            state: '',
            country_code: '',
            zip_code: ''
          }],
          newsletter_subscription: true,
          form_type: 'new_retail_customer'
        };
      }
    },
    pushError: function pushError(field, message) {
      this.validationErrors[field] = [];
      this.validationErrors[field][0] = message;
    },
    removeErrors: function removeErrors() {
      this.validationErrors = {};
    },
    saveData: function saveData() {
      var _this = this;
      if (this.form.form_type === 'current_customer') {
        this.axios_url = '/registration/request-account';
      } else if (this.form.form_type === 'new_retail_customer') {
        this.axios_url = '/registration/create-cash-customer';
      }
      axios.post(this.axios_url, this.form).then(function (response) {
        ShowNotification(response.data.type, 'Registration', response.data.message);
        if (response.data.redirect_url.length > 0) {
          setTimeout(function () {
            window.location.href = response.data.redirect_url;
          }, 1000);
        }
      })["catch"](function (err) {
        var _err$response$data$me;
        ShowNotification('error', 'Registration', (_err$response$data$me = err.response.data.message) !== null && _err$response$data$me !== void 0 ? _err$response$data$me : 'The given data is invalid.');
        _this.validationErrors = err.response.data.errors;
        console.error(err);
      });
    }
  }
});

/***/ }),

/***/ "./node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/pages/auth/register/cal-tool/RetailCustomer.vue?vue&type=script&lang=js":
/*!**********************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/pages/auth/register/cal-tool/RetailCustomer.vue?vue&type=script&lang=js ***!
  \**********************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  name: 'RetailCustomer',
  data: function data() {
    return {
      productClassifications: [{
        id: 1,
        name: 'Industrial Products'
      }, {
        id: 2,
        name: 'Consumer Goods'
      }, {
        id: 3,
        name: 'Electronics'
      }
      // Add more product classifications as needed
      ]
    };
  },
  methods: {
    removeAddress: function removeAddress(index) {
      this.$parent.form.address.splice(index, 1);
    },
    addAddress: function addAddress() {
      this.$parent.form.address.push({
        address_name: '',
        address_1: '',
        address_2: '',
        address_3: '',
        city: '',
        state: '',
        country_code: '',
        zip_code: ''
      });
    },
    validateData: function validateData() {
      this.$parent.removeErrors();
      var form = this.$parent.form;
      if (!form.name) {
        this.$parent.pushError('name', 'Name is required.');
      }
      if (!form.company_name) {
        this.$parent.pushError('company_name', 'Company name is required.');
      }
      if (!form.email) {
        this.$parent.pushError('email', 'Email is required.');
      } else if (!this.validateEmail(form.email)) {
        this.$parent.pushError('email', 'Email format is invalid.');
      }

      // Validate password
      if (!form.password) {
        this.$parent.pushError('password', 'Password is required.');
      }

      // Validate password confirmation
      if (!form.password_confirmation) {
        this.$parent.pushError('password_confirmation', 'Password confirmation is required.');
      } else if (form.password !== form.password_confirmation) {
        this.$parent.pushError('password_confirmation', 'Passwords do not match.');
      }
      if (!form.phone_number) {
        this.$parent.pushError('phone_number', 'Phone number is required.');
      }
      if (this.$parent.amplify_client_code === 'ACT' && !form.industry_classification_id) {
        this.$parent.pushError('industry_classification_id', 'This Company Industry Classification field is required.');
      }
      for (var i = 0; i < form.address.length; i++) {
        if (form.address[i].address_name.length === 0) {
          this.$parent.pushError("address.".concat(i, ".address_name"), 'This address name field is required.');
        }
        if (form.address[i].address_1.length === 0) {
          this.$parent.pushError("address.".concat(i, ".address_1"), 'This address line 1 field is required.');
        }
        if (form.address[i].city.length === 0) {
          this.$parent.pushError("address.".concat(i, ".city"), 'This address city field is required.');
        }
        if (form.address[i].state.length === 0) {
          this.$parent.pushError("address.".concat(i, ".state"), 'This address state field is required.');
        }
        if (form.address[i].zip_code.length === 0) {
          this.$parent.pushError("address.".concat(i, ".zip_code"), 'This zip code field is required.');
        }
      }
      if (!_.isEmpty(this.$parent.validationErrors)) {
        ShowNotification('error', 'Registration', 'Please correct the errors in the form.');
      } else {
        this.$parent.saveData();
      }
    },
    validateEmail: function validateEmail(email) {
      var re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      return re.test(String(email).toLowerCase());
    }
  }
});

/***/ }),

/***/ "./node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/pages/auth/register/default/Admin.vue?vue&type=script&lang=js":
/*!************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/pages/auth/register/default/Admin.vue?vue&type=script&lang=js ***!
  \************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  name: 'Admin',
  data: function data() {
    return {
      captchaImage: null
    };
  },
  mounted: function mounted() {
    this.reloadCaptcha();
  },
  methods: {
    back: function back() {
      this.$parent.step = "company";
    },
    reloadCaptcha: function reloadCaptcha() {
      var _this = this;
      axios.get('reload-captcha').then(function (response) {
        _this.captchaImage = response.data.captcha;
      })["catch"](function (err) {
        var _err$response$data$me;
        ShowNotification('error', 'Registration', (_err$response$data$me = err.response.data.message) !== null && _err$response$data$me !== void 0 ? _err$response$data$me : 'The given data is invalid.');
        _this.validationErrors = err.response.data.errors;
        console.error(err);
      });
    }
  },
  computed: {
    captchaNeedCheck: function captchaNeedCheck() {
      if (this.$parent.captchaVerificationEnabled) {
        if (this.$parent.form.captcha.length === 0) {
          this.$parent.captchaVerified = false;
          return true;
        }
        this.$parent.captchaVerified = true;
        return false;
      }
      return false;
    }
  }
});

/***/ }),

/***/ "./node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/pages/auth/register/default/Company.vue?vue&type=script&lang=js":
/*!**************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/pages/auth/register/default/Company.vue?vue&type=script&lang=js ***!
  \**************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  name: 'Company',
  data: function data() {
    return {};
  },
  props: [],
  methods: {
    removeAddress: function removeAddress(index) {
      this.$parent.form.address.splice(index, 1);
    },
    addAddress: function addAddress() {
      this.$parent.form.address.push({
        address_name: '',
        address_1: '',
        address_2: '',
        address_3: '',
        city: '',
        state: '',
        country_code: '',
        zip_code: ''
      });
    },
    validateData: function validateData() {
      this.$parent.removeErrors();
      var form = this.$parent.form;
      if (form.customer_name.length === 0) {
        this.$parent.pushError('customer_name', 'This Company Name field is required.');
      }
      if (form.email.length === 0) {
        this.$parent.pushError('email', 'This Company Email field is required.');
      }
      if (form.phone.length === 0) {
        this.$parent.pushError('phone', 'This Company Phone field is required.');
      }
      if (this.$parent.amplify_client_code === 'ACT' && form.industry_classification_id.length === 0) {
        this.$parent.pushError('industry_classification_id', 'This Company Industry Classification field is required.');
      }
      for (var i = 0; i < form.address.length; i++) {
        if (form.address[i].address_name.length === 0) {
          this.$parent.pushError("address.".concat(i, ".address_name"), 'This address name field is required.');
        }
        if (form.address[i].address_1.length === 0) {
          this.$parent.pushError("address.".concat(i, ".address_1"), 'This address line 1 field is required.');
        }
        if (form.address[i].city.length === 0) {
          this.$parent.pushError("address.".concat(i, ".city"), 'This address city field is required.');
        }
        if (form.address[i].state.length === 0) {
          this.$parent.pushError("address.".concat(i, ".state"), 'This address state field is required.');
        }
        if (form.address[i].zip_code.length === 0) {
          this.$parent.pushError("address.".concat(i, ".zip_code"), 'This zip code field is required.');
        }
      }
      if (!_.isEmpty(this.$parent.validationErrors)) {
        ShowNotification('error', 'Registration', 'The given data is invalid.');
      } else {
        this.$parent.step = 'admin';
      }
    }
  }
});

/***/ }),

/***/ "./node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/pages/auth/register/default/Index.vue?vue&type=script&lang=js":
/*!************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/pages/auth/register/default/Index.vue?vue&type=script&lang=js ***!
  \************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _Company_vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Company.vue */ "./resources/vue/views/pages/auth/register/default/Company.vue");
/* harmony import */ var _Admin_vue__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Admin.vue */ "./resources/vue/views/pages/auth/register/default/Admin.vue");


/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  name: 'DefaultRegistration',
  components: {
    Company: _Company_vue__WEBPACK_IMPORTED_MODULE_0__["default"],
    Admin: _Admin_vue__WEBPACK_IMPORTED_MODULE_1__["default"]
  },
  props: ['register_button_title', 'axios_url', 'honeypot_config', 'admin_tab_title', 'company_tab_title', 'captcha_verification', 'token', 'industry_classifications', 'amplify_client_code'],
  data: function data() {
    return {
      step: 'company',
      captchaVerificationEnabled: this.captcha_verification === 'true',
      captchaVerified: false,
      honeypot: JSON.parse(this.honeypot_config),
      industryClassifications: JSON.parse(this.industry_classifications),
      validationErrors: {}
    };
  },
  mounted: function mounted() {
    if (!this.captchaVerificationEnabled) {
      this.captchaVerified = true;
    }
    if (this.honeypot.enabled) {
      this.form[this.honeypot.nameFieldName] = '';
      this.form[this.honeypot.validFromFieldName] = this.honeypot.encryptedValidFrom;
    }
    removeFullPageLoader();
  },
  methods: {
    pushError: function pushError(field, message) {
      this.validationErrors[field] = [];
      this.validationErrors[field][0] = message;
    },
    removeErrors: function removeErrors() {
      this.validationErrors = {};
    },
    validateData: function validateData() {
      this.removeErrors();
      var form = this.form;
      if (form.admin_name.length === 0) {
        this.pushError('admin_name', 'This contact name field is required.');
      }
      if (form.admin_phone.length === 0) {
        this.pushError('admin_phone', 'This phone field is required.');
      }
      if (form.admin_email.length === 0) {
        this.pushError('admin_email', 'This email field is required.');
      }
      if (form.password.length === 0) {
        this.pushError('password', 'This password field is required.');
      }
      if (form.password_confirmation.length === 0) {
        this.pushError('password_confirmation', 'This retype password field is required.');
      }
      if (this.captchaVerificationEnabled && form.captcha.length === 0) {
        this.pushError('captcha', 'This captcha verification is required.');
      }
      if (!_.isEmpty(this.validationErrors)) {
        ShowNotification('error', 'Registration', 'The given data is invalid.');
        return false;
      }
      return true;
    },
    saveData: function saveData() {
      var _this = this;
      if (this.validateData()) {
        if (!this.captchaVerificationEnabled) {
          delete this.form.captcha;
        }
        axios.post(this.axios_url, this.form).then(function (response) {
          ShowNotification(response.data.type, 'Registration', response.data.message);
          if (response.data.redirect_url.length > 0) {
            setTimeout(function () {
              window.location.href = response.data.redirect_url;
            }, 1000);
          }
        })["catch"](function (err) {
          var _err$response$data$me;
          ShowNotification('error', 'Registration', (_err$response$data$me = err.response.data.message) !== null && _err$response$data$me !== void 0 ? _err$response$data$me : 'The given data is invalid.');
          _this.validationErrors = err.response.data.errors;
          console.error(err);
        });
      }
    }
  }
});

/***/ }),

/***/ "./node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/pages/auth/Registration.vue?vue&type=template&id=6eb8123a":
/*!*************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/pages/auth/Registration.vue?vue&type=template&id=6eb8123a ***!
  \*************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   render: () => (/* binding */ render),
/* harmony export */   staticRenderFns: () => (/* binding */ staticRenderFns)
/* harmony export */ });
var render = function render() {
  var _vm = this,
    _c = _vm._self._c;
  return _c("form", [_c(_vm.registrationScreen, _vm._b({
    ref: "component",
    tag: "component"
  }, "component", _vm.calToolProps, false)), _vm._v(" "), _vm.honeypot.enabled ? _c("div", {
    staticStyle: {
      display: "none"
    },
    attrs: {
      name: "".concat(_vm.honeypot.nameFieldName, "_wrap")
    }
  }, [_c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.form[_vm.honeypot.nameFieldName],
      expression: "form[honeypot.nameFieldName]"
    }],
    attrs: {
      type: "text",
      name: _vm.honeypot.nameFieldName,
      id: _vm.honeypot.nameFieldName
    },
    domProps: {
      value: _vm.form[_vm.honeypot.nameFieldName]
    },
    on: {
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.$set(_vm.form, _vm.honeypot.nameFieldName, $event.target.value);
      }
    }
  }), _vm._v(" "), _c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.form[_vm.honeypot.validFromFieldName],
      expression: "form[honeypot.validFromFieldName]"
    }],
    attrs: {
      type: "text",
      name: _vm.honeypot.validFromFieldName
    },
    domProps: {
      value: _vm.form[_vm.honeypot.validFromFieldName]
    },
    on: {
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.$set(_vm.form, _vm.honeypot.validFromFieldName, $event.target.value);
      }
    }
  })]) : _vm._e()], 1);
};
var staticRenderFns = [];
render._withStripped = true;


/***/ }),

/***/ "./node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/pages/auth/register/cal-tool/CommercialAccount.vue?vue&type=template&id=fe4ced46":
/*!************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/pages/auth/register/cal-tool/CommercialAccount.vue?vue&type=template&id=fe4ced46 ***!
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
  return _c("div", {
    staticClass: "registration-container"
  }, [_c("p", [_vm._v("Please fill out the provided credit application to open a new commercial account:")]), _vm._v(" "), _c("p", [_c("a", {
    staticClass: "font-weight-bold text-primary",
    attrs: {
      href: _vm.creditApplicationLink,
      target: "_blank"
    }
  }, [_c("h4", [_vm._v(" Credit Application")])])])]);
};
var staticRenderFns = [];
render._withStripped = true;


/***/ }),

/***/ "./node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/pages/auth/register/cal-tool/CurrentCustomer.vue?vue&type=template&id=13ce50d1&scoped=true":
/*!**********************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/pages/auth/register/cal-tool/CurrentCustomer.vue?vue&type=template&id=13ce50d1&scoped=true ***!
  \**********************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
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
    staticClass: "registration-container"
  }, [_vm._m(0), _vm._v(" "), _c("div", {
    staticClass: "form-row"
  }, [_c("div", {
    staticClass: "col-md-12 col-sm-12 form-group"
  }, [_vm._m(1), _vm._v(" "), _c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.$parent.form.account_number,
      expression: "$parent.form.account_number"
    }],
    staticClass: "form-control",
    "class": {
      "is-invalid": _vm.$parent.validationErrors.hasOwnProperty("account_number")
    },
    attrs: {
      type: "text",
      id: "account_number",
      placeholder: "Account Number"
    },
    domProps: {
      value: _vm.$parent.form.account_number
    },
    on: {
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.$set(_vm.$parent.form, "account_number", $event.target.value);
      }
    }
  }), _vm._v(" "), _vm.$parent.validationErrors.hasOwnProperty("account_number") ? _c("p", {
    staticClass: "text-danger"
  }, [_vm._v("\n                " + _vm._s(_vm.$parent.validationErrors.account_number[0]) + "\n            ")]) : _vm._e()])]), _vm._v(" "), _c("div", {
    staticClass: "form-row"
  }, [_c("div", {
    staticClass: "col-md-6 col-sm-12 form-group"
  }, [_vm._m(2), _vm._v(" "), _c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.$parent.form.name,
      expression: "$parent.form.name"
    }],
    staticClass: "form-control",
    "class": {
      "is-invalid": _vm.$parent.validationErrors.hasOwnProperty("name")
    },
    attrs: {
      type: "text",
      id: "name",
      placeholder: "Name"
    },
    domProps: {
      value: _vm.$parent.form.name
    },
    on: {
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.$set(_vm.$parent.form, "name", $event.target.value);
      }
    }
  }), _vm._v(" "), _vm.$parent.validationErrors.hasOwnProperty("name") ? _c("p", {
    staticClass: "text-danger"
  }, [_vm._v("\n                " + _vm._s(_vm.$parent.validationErrors.name[0]) + "\n            ")]) : _vm._e()]), _vm._v(" "), _c("div", {
    staticClass: "col-md-6 col-sm-12 form-group"
  }, [_vm._m(3), _vm._v(" "), _c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.$parent.form.email,
      expression: "$parent.form.email"
    }],
    staticClass: "form-control",
    "class": {
      "is-invalid": _vm.$parent.validationErrors.hasOwnProperty("email")
    },
    attrs: {
      type: "email",
      id: "email",
      placeholder: "Email"
    },
    domProps: {
      value: _vm.$parent.form.email
    },
    on: {
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.$set(_vm.$parent.form, "email", $event.target.value);
      }
    }
  }), _vm._v(" "), _c("small", {
    staticClass: "text-muted"
  }, [_vm._v("Your E-Mail Address will serve as your User ID when you Login")]), _vm._v(" "), _vm.$parent.validationErrors.hasOwnProperty("email") ? _c("p", {
    staticClass: "text-danger"
  }, [_vm._v("\n                " + _vm._s(_vm.$parent.validationErrors.email[0]) + "\n            ")]) : _vm._e()])]), _vm._v(" "), _c("div", {
    staticClass: "form-row"
  }, [_c("div", {
    staticClass: "col-md-6 col-sm-12 form-group"
  }, [_vm._m(4), _vm._v(" "), _c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.$parent.form.password,
      expression: "$parent.form.password"
    }],
    staticClass: "form-control",
    "class": {
      "is-invalid": _vm.$parent.validationErrors.hasOwnProperty("password")
    },
    attrs: {
      type: "password",
      id: "password",
      placeholder: "Password"
    },
    domProps: {
      value: _vm.$parent.form.password
    },
    on: {
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.$set(_vm.$parent.form, "password", $event.target.value);
      }
    }
  }), _vm._v(" "), _vm.$parent.validationErrors.hasOwnProperty("password") ? _c("p", {
    staticClass: "text-danger"
  }, [_vm._v("\n                " + _vm._s(_vm.$parent.validationErrors.password[0]) + "\n            ")]) : _vm._e()]), _vm._v(" "), _c("div", {
    staticClass: "col-md-6 col-sm-12 form-group"
  }, [_vm._m(5), _vm._v(" "), _c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.$parent.form.password_confirmation,
      expression: "$parent.form.password_confirmation"
    }],
    staticClass: "form-control",
    "class": {
      "is-invalid": _vm.$parent.validationErrors.hasOwnProperty("password_confirmation")
    },
    attrs: {
      type: "password",
      id: "password_confirmation",
      placeholder: "Password Confirmation"
    },
    domProps: {
      value: _vm.$parent.form.password_confirmation
    },
    on: {
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.$set(_vm.$parent.form, "password_confirmation", $event.target.value);
      }
    }
  }), _vm._v(" "), _vm.$parent.validationErrors.hasOwnProperty("password_confirmation") ? _c("p", {
    staticClass: "text-danger"
  }, [_vm._v("\n                " + _vm._s(_vm.$parent.validationErrors.password_confirmation[0]) + "\n            ")]) : _vm._e()])]), _vm._v(" "), _c("small", {
    staticClass: "text-muted d-block mb-2"
  }, [_vm._v('\n        Click on "I Accept" button to agree to the California Tool & Welding Supply Terms and Conditions and to submit your registration.\n    ')]), _vm._v(" "), _c("div", {
    staticClass: "form-group mt-2"
  }, [_c("div", {
    staticClass: "form-check"
  }, [_c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.$parent.form.newsletter_subscription,
      expression: "$parent.form.newsletter_subscription"
    }],
    staticClass: "form-check-input",
    attrs: {
      type: "checkbox",
      id: "newsletter_subscription"
    },
    domProps: {
      checked: Array.isArray(_vm.$parent.form.newsletter_subscription) ? _vm._i(_vm.$parent.form.newsletter_subscription, null) > -1 : _vm.$parent.form.newsletter_subscription
    },
    on: {
      change: function change($event) {
        var $$a = _vm.$parent.form.newsletter_subscription,
          $$el = $event.target,
          $$c = $$el.checked ? true : false;
        if (Array.isArray($$a)) {
          var $$v = null,
            $$i = _vm._i($$a, $$v);
          if ($$el.checked) {
            $$i < 0 && _vm.$set(_vm.$parent.form, "newsletter_subscription", $$a.concat([$$v]));
          } else {
            $$i > -1 && _vm.$set(_vm.$parent.form, "newsletter_subscription", $$a.slice(0, $$i).concat($$a.slice($$i + 1)));
          }
        } else {
          _vm.$set(_vm.$parent.form, "newsletter_subscription", $$c);
        }
      }
    }
  }), _vm._v(" "), _c("label", {
    staticClass: "form-check-label",
    attrs: {
      "for": "newsletter_subscription"
    }
  }, [_vm._v("\n                California Tool & Welding Supply newsletter subscription.\n            ")])])]), _vm._v(" "), _c("div", {
    staticClass: "text-right mt-4"
  }, [_c("button", {
    staticClass: "btn btn-danger margin-bottom-none mr-0",
    attrs: {
      type: "button"
    },
    on: {
      click: function click($event) {
        $event.preventDefault();
        return _vm.validateData.apply(null, arguments);
      }
    }
  }, [_vm._v("I ACCEPT")])])]);
};
var staticRenderFns = [function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("div", {
    staticClass: "d-flex justify-content-between align-items-center mb-3"
  }, [_c("h5", [_vm._v("New On Account User Web Store Access Request")]), _vm._v(" "), _c("h5", [_c("span", {
    staticClass: "text-danger"
  }, [_vm._v("*")]), _vm._v(" Indicates a Required Field")])]);
}, function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("label", {
    attrs: {
      "for": "account_number"
    }
  }, [_vm._v("Account Number "), _c("span", {
    staticClass: "text-danger"
  }, [_vm._v("*")])]);
}, function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("label", {
    attrs: {
      "for": "name"
    }
  }, [_vm._v("Name "), _c("span", {
    staticClass: "text-danger"
  }, [_vm._v("*")])]);
}, function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("label", {
    attrs: {
      "for": "email"
    }
  }, [_vm._v("Email "), _c("span", {
    staticClass: "text-danger"
  }, [_vm._v("*")])]);
}, function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("label", {
    attrs: {
      "for": "password"
    }
  }, [_vm._v("Password "), _c("span", {
    staticClass: "text-danger"
  }, [_vm._v("*")])]);
}, function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("label", {
    attrs: {
      "for": "password_confirmation"
    }
  }, [_vm._v("Password Confirmation "), _c("span", {
    staticClass: "text-danger"
  }, [_vm._v("*")])]);
}];
render._withStripped = true;


/***/ }),

/***/ "./node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/pages/auth/register/cal-tool/Index.vue?vue&type=template&id=45c1062c&scoped=true":
/*!************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/pages/auth/register/cal-tool/Index.vue?vue&type=template&id=45c1062c&scoped=true ***!
  \************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   render: () => (/* binding */ render),
/* harmony export */   staticRenderFns: () => (/* binding */ staticRenderFns)
/* harmony export */ });
var render = function render() {
  var _vm$current_customer_, _vm$new_commercial_ac, _vm$new_retail_custom;
  var _vm = this,
    _c = _vm._self._c;
  return _c("div", [_c("ul", {
    staticClass: "nav nav-tabs nav-justified"
  }, [_c("li", {
    staticClass: "nav-item"
  }, [_c("a", {
    staticClass: "nav-link",
    "class": {
      active: _vm.step === "current_customer"
    },
    attrs: {
      href: "#current_customer",
      "data-toggle": "tab",
      role: "tab"
    },
    on: {
      click: function click($event) {
        return _vm.initializeForm("current_customer");
      }
    }
  }, [_vm._v("\n                " + _vm._s((_vm$current_customer_ = _vm.current_customer_tab_title) !== null && _vm$current_customer_ !== void 0 ? _vm$current_customer_ : "") + "\n            ")])]), _vm._v(" "), _c("li", {
    staticClass: "nav-item"
  }, [_c("a", {
    staticClass: "nav-link",
    "class": {
      active: _vm.step === "new_commercial_account"
    },
    attrs: {
      href: "#new_commercial_account",
      "data-toggle": "tab",
      role: "tab"
    },
    on: {
      click: function click($event) {
        _vm.step = "new_commercial_account";
      }
    }
  }, [_vm._v("\n                " + _vm._s((_vm$new_commercial_ac = _vm.new_commercial_account_tab_title) !== null && _vm$new_commercial_ac !== void 0 ? _vm$new_commercial_ac : "") + "\n            ")])]), _vm._v(" "), _c("li", {
    staticClass: "nav-item"
  }, [_c("a", {
    staticClass: "nav-link",
    "class": {
      active: _vm.step === "new_retail_customer"
    },
    attrs: {
      href: "#new_retail_customer",
      "data-toggle": "tab",
      role: "tab"
    },
    on: {
      click: function click($event) {
        return _vm.initializeForm("new_retail_customer");
      }
    }
  }, [_vm._v("\n                " + _vm._s((_vm$new_retail_custom = _vm.new_retail_customer_tab_title) !== null && _vm$new_retail_custom !== void 0 ? _vm$new_retail_custom : "") + "\n            ")])])]), _vm._v(" "), _c("div", {
    staticClass: "tab-content p-3"
  }, [_c("div", {
    staticClass: "tab-pane fade home-tab",
    "class": {
      "show active": _vm.step === "current_customer"
    },
    attrs: {
      id: "current_customer",
      role: "tabpanel"
    }
  }, [_c("CurrentCustomer")], 1), _vm._v(" "), _c("div", {
    staticClass: "tab-pane fade home-tab",
    "class": {
      "show active": _vm.step === "new_commercial_account"
    },
    attrs: {
      id: "new_commercial_account",
      role: "tabpanel"
    }
  }, [_c("CommercialAccount")], 1), _vm._v(" "), _c("div", {
    staticClass: "tab-pane fade home-tab",
    "class": {
      "show active": _vm.step === "new_retail_customer"
    },
    attrs: {
      id: "new_retail_customer",
      role: "tabpanel"
    }
  }, [_c("RetailCustomer")], 1)])]);
};
var staticRenderFns = [];
render._withStripped = true;


/***/ }),

/***/ "./node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/pages/auth/register/cal-tool/RetailCustomer.vue?vue&type=template&id=2985bad2&scoped=true":
/*!*********************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/pages/auth/register/cal-tool/RetailCustomer.vue?vue&type=template&id=2985bad2&scoped=true ***!
  \*********************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   render: () => (/* binding */ render),
/* harmony export */   staticRenderFns: () => (/* binding */ staticRenderFns)
/* harmony export */ });
var render = function render() {
  var _vm$$parent$validatio;
  var _vm = this,
    _c = _vm._self._c;
  return _c("div", {
    staticClass: "registration-container"
  }, [_vm._m(0), _vm._v(" "), _c("div", {
    staticClass: "form-row"
  }, [_c("div", {
    staticClass: "col-md-12 col-sm-12 form-group"
  }, [_vm._m(1), _vm._v(" "), _c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.$parent.form.name,
      expression: "$parent.form.name"
    }],
    staticClass: "form-control",
    "class": {
      "is-invalid": _vm.$parent.validationErrors.hasOwnProperty("name")
    },
    attrs: {
      type: "text",
      id: "name",
      placeholder: "Name"
    },
    domProps: {
      value: _vm.$parent.form.name
    },
    on: {
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.$set(_vm.$parent.form, "name", $event.target.value);
      }
    }
  }), _vm._v(" "), _vm.$parent.validationErrors.hasOwnProperty("name") ? _c("p", {
    staticClass: "text-danger"
  }, [_vm._v("\n                " + _vm._s(_vm.$parent.validationErrors.name[0]) + "\n            ")]) : _vm._e()])]), _vm._v(" "), _c("div", {
    staticClass: "form-row"
  }, [_c("div", {
    staticClass: "col-md-6 col-sm-12 form-group"
  }, [_vm._m(2), _vm._v(" "), _c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.$parent.form.company_name,
      expression: "$parent.form.company_name"
    }],
    staticClass: "form-control",
    "class": {
      "is-invalid": _vm.$parent.validationErrors.hasOwnProperty("company_name")
    },
    attrs: {
      type: "text",
      id: "company_name",
      placeholder: "Company Name"
    },
    domProps: {
      value: _vm.$parent.form.company_name
    },
    on: {
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.$set(_vm.$parent.form, "company_name", $event.target.value);
      }
    }
  }), _vm._v(" "), _vm.$parent.validationErrors.hasOwnProperty("company_name") ? _c("p", {
    staticClass: "text-danger"
  }, [_vm._v("\n                " + _vm._s(_vm.$parent.validationErrors.company_name[0]) + "\n            ")]) : _vm._e()]), _vm._v(" "), _c("div", {
    staticClass: "col-md-6 col-sm-12 form-group"
  }, [_vm._m(3), _vm._v(" "), _c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.$parent.form.email,
      expression: "$parent.form.email"
    }],
    staticClass: "form-control",
    "class": {
      "is-invalid": _vm.$parent.validationErrors.hasOwnProperty("email")
    },
    attrs: {
      type: "email",
      id: "email",
      placeholder: "Email"
    },
    domProps: {
      value: _vm.$parent.form.email
    },
    on: {
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.$set(_vm.$parent.form, "email", $event.target.value);
      }
    }
  }), _vm._v(" "), _c("small", {
    staticClass: "text-muted"
  }, [_vm._v("Your E-Mail Address will serve as your User ID when you Login")]), _vm._v(" "), _vm.$parent.validationErrors.hasOwnProperty("email") ? _c("p", {
    staticClass: "text-danger"
  }, [_vm._v("\n                " + _vm._s(_vm.$parent.validationErrors.email[0]) + "\n            ")]) : _vm._e()])]), _vm._v(" "), _c("div", {
    staticClass: "form-row"
  }, [_c("div", {
    staticClass: "col-md-6 col-sm-12 form-group"
  }, [_vm._m(4), _vm._v(" "), _c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.$parent.form.password,
      expression: "$parent.form.password"
    }],
    staticClass: "form-control",
    "class": {
      "is-invalid": _vm.$parent.validationErrors.hasOwnProperty("password")
    },
    attrs: {
      type: "password",
      id: "password",
      placeholder: "Password"
    },
    domProps: {
      value: _vm.$parent.form.password
    },
    on: {
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.$set(_vm.$parent.form, "password", $event.target.value);
      }
    }
  }), _vm._v(" "), _vm.$parent.validationErrors.hasOwnProperty("password") ? _c("p", {
    staticClass: "text-danger"
  }, [_vm._v("\n                " + _vm._s(_vm.$parent.validationErrors.password[0]) + "\n            ")]) : _vm._e()]), _vm._v(" "), _c("div", {
    staticClass: "col-md-6 col-sm-12 form-group"
  }, [_vm._m(5), _vm._v(" "), _c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.$parent.form.password_confirmation,
      expression: "$parent.form.password_confirmation"
    }],
    staticClass: "form-control",
    "class": {
      "is-invalid": _vm.$parent.validationErrors.hasOwnProperty("password_confirmation")
    },
    attrs: {
      type: "password",
      id: "password_confirmation",
      placeholder: "Password Confirmation"
    },
    domProps: {
      value: _vm.$parent.form.password_confirmation
    },
    on: {
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.$set(_vm.$parent.form, "password_confirmation", $event.target.value);
      }
    }
  }), _vm._v(" "), _vm.$parent.validationErrors.hasOwnProperty("password_confirmation") ? _c("p", {
    staticClass: "text-danger"
  }, [_vm._v("\n                " + _vm._s(_vm.$parent.validationErrors.password_confirmation[0]) + "\n            ")]) : _vm._e()])]), _vm._v(" "), _c("div", {
    staticClass: "form-row"
  }, [_c("div", {
    staticClass: "col-md-6 col-sm-12 form-group"
  }, [_vm._m(6), _vm._v(" "), _c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.$parent.form.phone_number,
      expression: "$parent.form.phone_number"
    }],
    staticClass: "form-control",
    "class": {
      "is-invalid": _vm.$parent.validationErrors.hasOwnProperty("phone_number")
    },
    attrs: {
      type: "text",
      id: "phone_number",
      placeholder: "Phone Number"
    },
    domProps: {
      value: _vm.$parent.form.phone_number
    },
    on: {
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.$set(_vm.$parent.form, "phone_number", $event.target.value);
      }
    }
  }), _vm._v(" "), _vm.$parent.validationErrors.hasOwnProperty("phone_number") ? _c("p", {
    staticClass: "text-danger"
  }, [_vm._v("\n                " + _vm._s(_vm.$parent.validationErrors.phone_number[0]) + "\n            ")]) : _vm._e()]), _vm._v(" "), this.$parent.amplify_client_code === "ACT" ? _c("div", {
    staticClass: "col-md-6 col-sm-12 form-group"
  }, [_vm._m(7), _vm._v(" "), _c("select", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.$parent.form.industry_classification_id,
      expression: "$parent.form.industry_classification_id"
    }],
    staticClass: "form-control",
    "class": {
      "is-invalid": _vm.$parent.validationErrors.hasOwnProperty("industry_classification_id")
    },
    on: {
      change: function change($event) {
        var $$selectedVal = Array.prototype.filter.call($event.target.options, function (o) {
          return o.selected;
        }).map(function (o) {
          var val = "_value" in o ? o._value : o.value;
          return val;
        });
        _vm.$set(_vm.$parent.form, "industry_classification_id", $event.target.multiple ? $$selectedVal : $$selectedVal[0]);
      }
    }
  }, _vm._l(_vm.$parent.industryClassifications, function (in_class) {
    return _c("option", {
      domProps: {
        value: in_class.id
      }
    }, [_vm._v("\n                    " + _vm._s(in_class.name) + "\n                ")]);
  }), 0), _vm._v(" "), _vm.$parent.validationErrors.hasOwnProperty("industry_classification_id") ? _c("p", {
    staticClass: "text-danger d-block"
  }, [_vm._v("\n                " + _vm._s((_vm$$parent$validatio = _vm.$parent.validationErrors.industry_classification_id[0]) !== null && _vm$$parent$validatio !== void 0 ? _vm$$parent$validatio : "") + "\n            ")]) : _vm._e()]) : _vm._e()]), _vm._v(" "), _c("div", {
    staticClass: "form-group"
  }, [_vm._m(8), _vm._v(" "), _vm._l(_vm.$parent.form.address, function (item, index) {
    var _vm$$parent$validatio2, _vm$$parent$validatio3, _vm$$parent$validatio4, _vm$$parent$validatio5, _vm$$parent$validatio6;
    return _c("div", {
      key: index,
      staticClass: "border rounded pl-4 pr-4 py-2 my-2",
      "class": {
        "bg-secondary": index !== 0
      }
    }, [_c("h6", {
      staticClass: "font-weight-bold mb-2"
    }, [_vm._v(_vm._s(index === 0 ? "Default Address" : "Address #" + (index + 1)))]), _vm._v(" "), _c("button", {
      directives: [{
        name: "show",
        rawName: "v-show",
        value: index != 0,
        expression: "index != 0"
      }],
      staticClass: "btn btn-sm btn-secondary rounded-circle p-0 position-absolute",
      staticStyle: {
        left: "11px",
        width: "40px",
        height: "40px"
      },
      attrs: {
        type: "button",
        role: "button"
      },
      on: {
        click: function click($event) {
          return _vm.removeAddress(index);
        }
      }
    }, [_c("i", {
      staticClass: "icon-cross font-weight-bold",
      staticStyle: {
        "font-size": "1.2rem"
      }
    })]), _vm._v(" "), _c("div", {
      staticClass: "form-group"
    }, [_c("label", {
      attrs: {
        "for": "address_name" + index
      }
    }, [_vm._v("Address Name "), _c("span", {
      staticClass: "text-danger"
    }, [_vm._v("*")])]), _vm._v(" "), _c("div", {
      staticClass: "pl-0"
    }, [_c("input", {
      directives: [{
        name: "model",
        rawName: "v-model",
        value: item.address_name,
        expression: "item.address_name"
      }],
      staticClass: "form-control",
      "class": {
        "is-invalid": _vm.$parent.validationErrors.hasOwnProperty("address.".concat(index, ".address_name"))
      },
      attrs: {
        type: "text",
        id: "address_name" + index,
        placeholder: "Enter Address Name",
        required: ""
      },
      domProps: {
        value: item.address_name
      },
      on: {
        input: function input($event) {
          if ($event.target.composing) return;
          _vm.$set(item, "address_name", $event.target.value);
        }
      }
    })]), _vm._v(" "), _vm.$parent.validationErrors.hasOwnProperty("address.".concat(index, ".address_name")) ? _c("p", {
      staticClass: "text-danger d-block"
    }, [_vm._v("\n                    " + _vm._s((_vm$$parent$validatio2 = _vm.$parent.validationErrors["address.".concat(index, ".address_name")][0]) !== null && _vm$$parent$validatio2 !== void 0 ? _vm$$parent$validatio2 : "") + "\n                ")]) : _vm._e()]), _vm._v(" "), _c("div", {
      staticClass: "form-group"
    }, [_c("label", {
      attrs: {
        "for": "address_1" + index
      }
    }, [_vm._v("Street Address "), _c("span", {
      staticClass: "text-danger"
    }, [_vm._v("*")])]), _vm._v(" "), _c("div", {
      staticClass: "mb-1"
    }, [_c("input", {
      directives: [{
        name: "model",
        rawName: "v-model",
        value: item.address_1,
        expression: "item.address_1"
      }],
      staticClass: "form-control",
      "class": {
        "is-invalid": _vm.$parent.validationErrors.hasOwnProperty("address.".concat(index, ".address_1"))
      },
      attrs: {
        type: "text",
        id: "address_1" + index,
        placeholder: "Line 1",
        required: ""
      },
      domProps: {
        value: item.address_1
      },
      on: {
        input: function input($event) {
          if ($event.target.composing) return;
          _vm.$set(item, "address_1", $event.target.value);
        }
      }
    }), _vm._v(" "), _vm.$parent.validationErrors.hasOwnProperty("address.".concat(index, ".address_1")) ? _c("p", {
      staticClass: "text-danger d-block"
    }, [_vm._v("\n                        " + _vm._s((_vm$$parent$validatio3 = _vm.$parent.validationErrors["address.".concat(index, ".address_1")][0]) !== null && _vm$$parent$validatio3 !== void 0 ? _vm$$parent$validatio3 : "") + "\n                    ")]) : _vm._e()]), _vm._v(" "), _c("div", {
      staticClass: "mb-1"
    }, [_c("input", {
      directives: [{
        name: "model",
        rawName: "v-model",
        value: item.address_2,
        expression: "item.address_2"
      }],
      staticClass: "form-control",
      attrs: {
        type: "text",
        id: "address_2" + index,
        placeholder: "Line 2",
        required: ""
      },
      domProps: {
        value: item.address_2
      },
      on: {
        input: function input($event) {
          if ($event.target.composing) return;
          _vm.$set(item, "address_2", $event.target.value);
        }
      }
    })]), _vm._v(" "), _c("div", {
      staticClass: "mb-1"
    }, [_c("input", {
      directives: [{
        name: "model",
        rawName: "v-model",
        value: item.address_3,
        expression: "item.address_3"
      }],
      staticClass: "form-control",
      attrs: {
        type: "text",
        id: "address_3" + index,
        placeholder: "Line 3",
        required: ""
      },
      domProps: {
        value: item.address_3
      },
      on: {
        input: function input($event) {
          if ($event.target.composing) return;
          _vm.$set(item, "address_3", $event.target.value);
        }
      }
    })])]), _vm._v(" "), _c("div", {
      staticClass: "form-row"
    }, [_c("div", {
      staticClass: "col-md-6 col-sm-12"
    }, [_c("div", {
      staticClass: "form-group"
    }, [_c("label", {
      attrs: {
        "for": "city_" + index
      }
    }, [_vm._v("City"), _c("span", {
      staticClass: "text-danger"
    }, [_vm._v("*")])]), _vm._v(" "), _c("input", {
      directives: [{
        name: "model",
        rawName: "v-model",
        value: item.city,
        expression: "item.city"
      }],
      staticClass: "form-control",
      "class": {
        "is-invalid": _vm.$parent.validationErrors.hasOwnProperty("address.".concat(index, ".city"))
      },
      attrs: {
        type: "text",
        id: "city_" + index,
        placeholder: "Enter City",
        required: ""
      },
      domProps: {
        value: item.city
      },
      on: {
        input: function input($event) {
          if ($event.target.composing) return;
          _vm.$set(item, "city", $event.target.value);
        }
      }
    }), _vm._v(" "), _vm.$parent.validationErrors.hasOwnProperty("address.".concat(index, ".city")) ? _c("p", {
      staticClass: "text-danger d-block"
    }, [_vm._v("\n                            " + _vm._s((_vm$$parent$validatio4 = _vm.$parent.validationErrors["address.".concat(index, ".city")][0]) !== null && _vm$$parent$validatio4 !== void 0 ? _vm$$parent$validatio4 : "") + "\n                        ")]) : _vm._e()])]), _vm._v(" "), _c("div", {
      staticClass: "col-md-6 col-sm-12"
    }, [_c("div", {
      staticClass: "form-group"
    }, [_c("label", {
      attrs: {
        "for": "state_" + index
      }
    }, [_vm._v("State"), _c("span", {
      staticClass: "text-danger"
    }, [_vm._v("*")])]), _vm._v(" "), _c("input", {
      directives: [{
        name: "model",
        rawName: "v-model",
        value: item.state,
        expression: "item.state"
      }],
      staticClass: "form-control",
      "class": {
        "is-invalid": _vm.$parent.validationErrors.hasOwnProperty("address.".concat(index, ".state"))
      },
      attrs: {
        type: "text",
        id: "state_" + index,
        placeholder: "Enter State",
        required: ""
      },
      domProps: {
        value: item.state
      },
      on: {
        input: function input($event) {
          if ($event.target.composing) return;
          _vm.$set(item, "state", $event.target.value);
        }
      }
    }), _vm._v(" "), _vm.$parent.validationErrors.hasOwnProperty("address.".concat(index, ".state")) ? _c("p", {
      staticClass: "text-danger d-block"
    }, [_vm._v("\n                            " + _vm._s((_vm$$parent$validatio5 = _vm.$parent.validationErrors["address.".concat(index, ".state")][0]) !== null && _vm$$parent$validatio5 !== void 0 ? _vm$$parent$validatio5 : "") + "\n                        ")]) : _vm._e()])]), _vm._v(" "), _c("div", {
      staticClass: "col-md-6 col-sm-12"
    }, [_c("div", {
      staticClass: "form-group"
    }, [_c("label", {
      attrs: {
        "for": "country_code_" + index
      }
    }, [_vm._v("Country Code")]), _vm._v(" "), _c("input", {
      directives: [{
        name: "model",
        rawName: "v-model",
        value: item.country_code,
        expression: "item.country_code"
      }],
      staticClass: "form-control",
      attrs: {
        type: "text",
        id: "country_code_" + index,
        placeholder: "Enter Country Code"
      },
      domProps: {
        value: item.country_code
      },
      on: {
        input: function input($event) {
          if ($event.target.composing) return;
          _vm.$set(item, "country_code", $event.target.value);
        }
      }
    })])]), _vm._v(" "), _c("div", {
      staticClass: "col-md-6 col-sm-12"
    }, [_c("div", {
      staticClass: "form-group"
    }, [_c("label", {
      attrs: {
        "for": "zip_code_" + index
      }
    }, [_vm._v("Zip Code "), _c("span", {
      staticClass: "text-danger"
    }, [_vm._v("*")])]), _vm._v(" "), _c("input", {
      directives: [{
        name: "model",
        rawName: "v-model",
        value: item.zip_code,
        expression: "item.zip_code"
      }],
      staticClass: "form-control",
      "class": {
        "is-invalid": _vm.$parent.validationErrors.hasOwnProperty("address.".concat(index, ".zip_code"))
      },
      attrs: {
        type: "text",
        id: "zip_code_" + index,
        placeholder: "Enter Zip Code",
        required: ""
      },
      domProps: {
        value: item.zip_code
      },
      on: {
        input: function input($event) {
          if ($event.target.composing) return;
          _vm.$set(item, "zip_code", $event.target.value);
        }
      }
    }), _vm._v(" "), _vm.$parent.validationErrors.hasOwnProperty("address.".concat(index, ".zip_code")) ? _c("p", {
      staticClass: "text-danger d-block"
    }, [_vm._v("\n                            " + _vm._s((_vm$$parent$validatio6 = _vm.$parent.validationErrors["address.".concat(index, ".zip_code")][0]) !== null && _vm$$parent$validatio6 !== void 0 ? _vm$$parent$validatio6 : "") + "\n                        ")]) : _vm._e()])])])]);
  })], 2), _vm._v(" "), _c("small", {
    staticClass: "text-muted d-block mb-2"
  }, [_vm._v('\n        Click on "I Accept" button to agree to the California Tool & Welding Supply Terms and Conditions and to submit your registration.\n    ')]), _vm._v(" "), _c("div", {
    staticClass: "form-group mt-2"
  }, [_c("div", {
    staticClass: "form-check"
  }, [_c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.$parent.form.newsletter_subscription,
      expression: "$parent.form.newsletter_subscription"
    }],
    staticClass: "form-check-input",
    attrs: {
      type: "checkbox",
      id: "newsletter_subscription"
    },
    domProps: {
      checked: Array.isArray(_vm.$parent.form.newsletter_subscription) ? _vm._i(_vm.$parent.form.newsletter_subscription, null) > -1 : _vm.$parent.form.newsletter_subscription
    },
    on: {
      change: function change($event) {
        var $$a = _vm.$parent.form.newsletter_subscription,
          $$el = $event.target,
          $$c = $$el.checked ? true : false;
        if (Array.isArray($$a)) {
          var $$v = null,
            $$i = _vm._i($$a, $$v);
          if ($$el.checked) {
            $$i < 0 && _vm.$set(_vm.$parent.form, "newsletter_subscription", $$a.concat([$$v]));
          } else {
            $$i > -1 && _vm.$set(_vm.$parent.form, "newsletter_subscription", $$a.slice(0, $$i).concat($$a.slice($$i + 1)));
          }
        } else {
          _vm.$set(_vm.$parent.form, "newsletter_subscription", $$c);
        }
      }
    }
  }), _vm._v(" "), _c("label", {
    staticClass: "form-check-label",
    attrs: {
      "for": "newsletter_subscription"
    }
  }, [_vm._v("\n                California Tool & Welding Supply newsletter subscription.\n            ")])])]), _vm._v(" "), _c("div", {
    staticClass: "text-right mt-4"
  }, [_c("button", {
    staticClass: "btn btn-danger margin-bottom-none mr-0",
    attrs: {
      type: "button"
    },
    on: {
      click: function click($event) {
        $event.preventDefault();
        return _vm.validateData.apply(null, arguments);
      }
    }
  }, [_vm._v("I ACCEPT")])])]);
};
var staticRenderFns = [function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("div", {
    staticClass: "text-right mb-3"
  }, [_c("h5", [_c("span", {
    staticClass: "text-danger"
  }, [_vm._v("*")]), _vm._v(" Indicates a Required Field")])]);
}, function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("label", {
    attrs: {
      "for": "name"
    }
  }, [_vm._v("Name "), _c("span", {
    staticClass: "text-danger"
  }, [_vm._v("*")])]);
}, function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("label", {
    attrs: {
      "for": "company_name"
    }
  }, [_vm._v("Company Name "), _c("span", {
    staticClass: "text-danger"
  }, [_vm._v("*")])]);
}, function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("label", {
    attrs: {
      "for": "email"
    }
  }, [_vm._v("Email "), _c("span", {
    staticClass: "text-danger"
  }, [_vm._v("*")])]);
}, function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("label", {
    attrs: {
      "for": "password"
    }
  }, [_vm._v("Password "), _c("span", {
    staticClass: "text-danger"
  }, [_vm._v("*")])]);
}, function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("label", {
    attrs: {
      "for": "password_confirmation"
    }
  }, [_vm._v("Password Confirmation "), _c("span", {
    staticClass: "text-danger"
  }, [_vm._v("*")])]);
}, function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("label", {
    attrs: {
      "for": "phone_number"
    }
  }, [_vm._v("Phone Number "), _c("span", {
    staticClass: "text-danger"
  }, [_vm._v("*")])]);
}, function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("label", {
    attrs: {
      "for": "industry_classification_id"
    }
  }, [_vm._v("Industry Classification"), _c("span", {
    staticClass: "text-danger"
  }, [_vm._v("*")])]);
}, function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("label", {
    attrs: {
      "for": "password"
    }
  }, [_vm._v("Addresses"), _c("span", {
    staticClass: "text-danger"
  }, [_vm._v("*")])]);
}];
render._withStripped = true;


/***/ }),

/***/ "./node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/pages/auth/register/default/Admin.vue?vue&type=template&id=2d82d8ff":
/*!***********************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/pages/auth/register/default/Admin.vue?vue&type=template&id=2d82d8ff ***!
  \***********************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   render: () => (/* binding */ render),
/* harmony export */   staticRenderFns: () => (/* binding */ staticRenderFns)
/* harmony export */ });
var render = function render() {
  var _vm$$parent$validatio, _vm$$parent$validatio2, _vm$$parent$validatio3, _vm$$parent$validatio4, _vm$$parent$validatio5, _vm$$parent$validatio6, _vm$$parent$validatio7, _vm$$parent$validatio8, _vm$$parent$validatio9, _vm$$parent$validatio10, _vm$$parent$validatio11, _vm$$parent$validatio12, _vm$$parent$registerB;
  var _vm = this,
    _c = _vm._self._c;
  return _c("div", [_c("div", {
    staticClass: "form-group"
  }, [_vm._m(0), _vm._v(" "), _c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.$parent.form.admin_name,
      expression: "$parent.form.admin_name"
    }],
    staticClass: "form-control",
    "class": {
      "is-invalid": _vm.$parent.validationErrors.hasOwnProperty("admin_name")
    },
    attrs: {
      type: "text"
    },
    domProps: {
      value: _vm.$parent.form.admin_name
    },
    on: {
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.$set(_vm.$parent.form, "admin_name", $event.target.value);
      }
    }
  }), _vm._v(" "), (_vm$$parent$validatio = _vm.$parent.validationErrors) !== null && _vm$$parent$validatio !== void 0 && _vm$$parent$validatio.admin_name ? _c("p", {
    staticClass: "text-danger d-block"
  }, [_vm._v("\n            " + _vm._s((_vm$$parent$validatio2 = _vm.$parent.validationErrors.admin_name[0]) !== null && _vm$$parent$validatio2 !== void 0 ? _vm$$parent$validatio2 : "") + "\n        ")]) : _vm._e()]), _vm._v(" "), _c("div", {
    staticClass: "form-group"
  }, [_vm._m(1), _vm._v(" "), _c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.$parent.form.admin_phone,
      expression: "$parent.form.admin_phone"
    }],
    staticClass: "form-control",
    "class": {
      "is-invalid": _vm.$parent.validationErrors.hasOwnProperty("admin_phone")
    },
    attrs: {
      type: "text"
    },
    domProps: {
      value: _vm.$parent.form.admin_phone
    },
    on: {
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.$set(_vm.$parent.form, "admin_phone", $event.target.value);
      }
    }
  }), _vm._v(" "), (_vm$$parent$validatio3 = _vm.$parent.validationErrors) !== null && _vm$$parent$validatio3 !== void 0 && _vm$$parent$validatio3.admin_phone ? _c("p", {
    staticClass: "text-danger d-block"
  }, [_vm._v("\n            " + _vm._s((_vm$$parent$validatio4 = _vm.$parent.validationErrors.admin_phone[0]) !== null && _vm$$parent$validatio4 !== void 0 ? _vm$$parent$validatio4 : "") + "\n        ")]) : _vm._e()]), _vm._v(" "), _c("div", {
    staticClass: "form-group"
  }, [_vm._m(2), _vm._v(" "), _c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.$parent.form.admin_email,
      expression: "$parent.form.admin_email"
    }],
    staticClass: "form-control",
    "class": {
      "is-invalid": _vm.$parent.validationErrors.hasOwnProperty("admin_email")
    },
    attrs: {
      type: "email"
    },
    domProps: {
      value: _vm.$parent.form.admin_email
    },
    on: {
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.$set(_vm.$parent.form, "admin_email", $event.target.value);
      }
    }
  }), _vm._v(" "), (_vm$$parent$validatio5 = _vm.$parent.validationErrors) !== null && _vm$$parent$validatio5 !== void 0 && _vm$$parent$validatio5.admin_email ? _c("p", {
    staticClass: "text-danger d-block"
  }, [_vm._v("\n            " + _vm._s((_vm$$parent$validatio6 = _vm.$parent.validationErrors.admin_email[0]) !== null && _vm$$parent$validatio6 !== void 0 ? _vm$$parent$validatio6 : "") + "\n        ")]) : _vm._e()]), _vm._v(" "), _c("div", {
    staticClass: "form-group"
  }, [_vm._m(3), _vm._v(" "), _c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.$parent.form.password,
      expression: "$parent.form.password"
    }],
    staticClass: "form-control",
    "class": {
      "is-invalid": _vm.$parent.validationErrors.hasOwnProperty("password")
    },
    attrs: {
      type: "password"
    },
    domProps: {
      value: _vm.$parent.form.password
    },
    on: {
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.$set(_vm.$parent.form, "password", $event.target.value);
      }
    }
  }), _vm._v(" "), (_vm$$parent$validatio7 = _vm.$parent.validationErrors) !== null && _vm$$parent$validatio7 !== void 0 && _vm$$parent$validatio7.password ? _c("p", {
    staticClass: "text-danger d-block"
  }, [_vm._v("\n            " + _vm._s((_vm$$parent$validatio8 = _vm.$parent.validationErrors.password[0]) !== null && _vm$$parent$validatio8 !== void 0 ? _vm$$parent$validatio8 : "") + "\n        ")]) : _vm._e()]), _vm._v(" "), _c("div", {
    staticClass: "form-group"
  }, [_vm._m(4), _vm._v(" "), _c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.$parent.form.password_confirmation,
      expression: "$parent.form.password_confirmation"
    }],
    staticClass: "form-control",
    "class": {
      "is-invalid": _vm.$parent.validationErrors.hasOwnProperty("password")
    },
    attrs: {
      type: "password"
    },
    domProps: {
      value: _vm.$parent.form.password_confirmation
    },
    on: {
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.$set(_vm.$parent.form, "password_confirmation", $event.target.value);
      }
    }
  }), _vm._v(" "), (_vm$$parent$validatio9 = _vm.$parent.validationErrors) !== null && _vm$$parent$validatio9 !== void 0 && _vm$$parent$validatio9.password ? _c("p", {
    staticClass: "text-danger d-block"
  }, [_vm._v("\n            " + _vm._s((_vm$$parent$validatio10 = _vm.$parent.validationErrors.password[0]) !== null && _vm$$parent$validatio10 !== void 0 ? _vm$$parent$validatio10 : "") + "\n        ")]) : _vm._e()]), _vm._v(" "), _vm.$parent.captchaVerificationEnabled ? _c("div", {
    staticClass: "form-group"
  }, [_vm._m(5), _vm._v(" "), _c("div", {
    staticClass: "bg-secondary border d-flex rounded px-3 gap-3"
  }, [_c("div", {
    staticClass: "d-flex gap-3 justify-content-between align-items-baseline"
  }, [_c("div", {
    staticClass: "captcha-container",
    domProps: {
      innerHTML: _vm._s(_vm.captchaImage)
    }
  }), _vm._v(" "), _c("button", {
    staticClass: "btn btn-outline-secondary px-3 m-0",
    on: {
      click: _vm.reloadCaptcha
    }
  }, [_c("i", {
    staticClass: "icon-reload"
  })])]), _vm._v(" "), _c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.$parent.form.captcha,
      expression: "$parent.form.captcha"
    }],
    staticClass: "form-control mt-2",
    "class": {
      "is-invalid": _vm.$parent.validationErrors.hasOwnProperty("captcha")
    },
    attrs: {
      type: "text",
      placeholder: "Enter Captcha Character"
    },
    domProps: {
      value: _vm.$parent.form.captcha
    },
    on: {
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.$set(_vm.$parent.form, "captcha", $event.target.value);
      }
    }
  })]), _vm._v(" "), (_vm$$parent$validatio11 = _vm.$parent.validationErrors) !== null && _vm$$parent$validatio11 !== void 0 && _vm$$parent$validatio11.captcha ? _c("p", {
    staticClass: "text-danger d-block"
  }, [_vm._v("\n            " + _vm._s((_vm$$parent$validatio12 = _vm.$parent.validationErrors.captcha[0]) !== null && _vm$$parent$validatio12 !== void 0 ? _vm$$parent$validatio12 : "") + "\n        ")]) : _vm._e()]) : _vm._e(), _vm._v(" "), _c("div", {
    staticClass: "col-12 d-flex justify-content-between p-0"
  }, [_c("button", {
    staticClass: "align-items-center btn btn-info d-flex d-inline-block margin-bottom-none",
    attrs: {
      type: "button"
    },
    on: {
      click: _vm.back
    }
  }, [_c("i", {
    staticClass: "icon-rewind",
    attrs: {
      "aria-hidden": "true"
    }
  }), _vm._v("Back\n        ")]), _vm._v(" "), _c("button", {
    staticClass: "btn btn-success margin-bottom-none mr-0",
    attrs: {
      type: "button",
      disabled: _vm.captchaNeedCheck
    },
    on: {
      click: function click($event) {
        return _vm.$parent.saveData();
      }
    }
  }, [_c("i", {
    staticClass: "icon-location"
  }), _vm._v(" " + _vm._s((_vm$$parent$registerB = _vm.$parent.registerButtonTitle) !== null && _vm$$parent$registerB !== void 0 ? _vm$$parent$registerB : "Register") + "\n        ")])])]);
};
var staticRenderFns = [function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("label", {
    attrs: {
      "for": "admin_name"
    }
  }, [_vm._v("Contact Name "), _c("span", {
    staticClass: "text-danger"
  }, [_vm._v("*")])]);
}, function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("label", {
    attrs: {
      "for": "admin_phone"
    }
  }, [_vm._v("Phone "), _c("span", {
    staticClass: "text-danger"
  }, [_vm._v("*")])]);
}, function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("label", {
    attrs: {
      "for": "admin_email"
    }
  }, [_vm._v("Email Address "), _c("span", {
    staticClass: "text-danger"
  }, [_vm._v("*")])]);
}, function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("label", {
    attrs: {
      "for": "password"
    }
  }, [_vm._v("Password "), _c("span", {
    staticClass: "text-danger"
  }, [_vm._v("*")])]);
}, function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("label", {
    attrs: {
      "for": "password_confirmation"
    }
  }, [_vm._v("Retype Password"), _c("span", {
    staticClass: "text-danger"
  }, [_vm._v("*")])]);
}, function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("label", [_vm._v("Captcha Verification"), _c("span", {
    staticClass: "text-danger"
  }, [_vm._v("*")])]);
}];
render._withStripped = true;


/***/ }),

/***/ "./node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/pages/auth/register/default/Company.vue?vue&type=template&id=15d9852d":
/*!*************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/pages/auth/register/default/Company.vue?vue&type=template&id=15d9852d ***!
  \*************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   render: () => (/* binding */ render),
/* harmony export */   staticRenderFns: () => (/* binding */ staticRenderFns)
/* harmony export */ });
var render = function render() {
  var _vm$$parent$validatio, _vm$$parent$validatio2, _vm$$parent$validatio3, _vm$$parent$validatio4;
  var _vm = this,
    _c = _vm._self._c;
  return _c("div", [_c("div", {
    staticClass: "form-group"
  }, [_vm._m(0), _vm._v(" "), _c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.$parent.form.customer_name,
      expression: "$parent.form.customer_name"
    }],
    staticClass: "form-control",
    "class": {
      "is-invalid": _vm.$parent.validationErrors.hasOwnProperty("customer_name")
    },
    attrs: {
      type: "text"
    },
    domProps: {
      value: _vm.$parent.form.customer_name
    },
    on: {
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.$set(_vm.$parent.form, "customer_name", $event.target.value);
      }
    }
  }), _vm._v(" "), _vm.$parent.validationErrors.hasOwnProperty("customer_name") ? _c("p", {
    staticClass: "text-danger d-block"
  }, [_vm._v("\n            " + _vm._s((_vm$$parent$validatio = _vm.$parent.validationErrors.customer_name[0]) !== null && _vm$$parent$validatio !== void 0 ? _vm$$parent$validatio : "") + "\n        ")]) : _vm._e()]), _vm._v(" "), _c("div", {
    staticClass: "form-group"
  }, [_vm._m(1), _vm._v(" "), _c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.$parent.form.email,
      expression: "$parent.form.email"
    }],
    staticClass: "form-control",
    "class": {
      "is-invalid": _vm.$parent.validationErrors.hasOwnProperty("email")
    },
    attrs: {
      type: "email"
    },
    domProps: {
      value: _vm.$parent.form.email
    },
    on: {
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.$set(_vm.$parent.form, "email", $event.target.value);
      }
    }
  }), _vm._v(" "), _vm.$parent.validationErrors.hasOwnProperty("email") ? _c("p", {
    staticClass: "text-danger d-block"
  }, [_vm._v("\n            " + _vm._s((_vm$$parent$validatio2 = _vm.$parent.validationErrors.email[0]) !== null && _vm$$parent$validatio2 !== void 0 ? _vm$$parent$validatio2 : "") + "\n        ")]) : _vm._e()]), _vm._v(" "), _c("div", {
    staticClass: "form-group"
  }, [_vm._m(2), _vm._v(" "), _c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.$parent.form.phone,
      expression: "$parent.form.phone"
    }],
    staticClass: "form-control",
    "class": {
      "is-invalid": _vm.$parent.validationErrors.hasOwnProperty("phone")
    },
    attrs: {
      type: "text"
    },
    domProps: {
      value: _vm.$parent.form.phone
    },
    on: {
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.$set(_vm.$parent.form, "phone", $event.target.value);
      }
    }
  }), _vm._v(" "), _vm.$parent.validationErrors.hasOwnProperty("phone") ? _c("p", {
    staticClass: "text-danger d-block"
  }, [_vm._v("\n            " + _vm._s((_vm$$parent$validatio3 = _vm.$parent.validationErrors.phone[0]) !== null && _vm$$parent$validatio3 !== void 0 ? _vm$$parent$validatio3 : "") + "\n        ")]) : _vm._e()]), _vm._v(" "), this.$parent.amplify_client_code === "ACT" ? _c("div", {
    staticClass: "form-group"
  }, [_vm._m(3), _vm._v(" "), _c("select", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.$parent.form.industry_classification_id,
      expression: "$parent.form.industry_classification_id"
    }],
    staticClass: "form-control",
    "class": {
      "is-invalid": _vm.$parent.validationErrors.hasOwnProperty("industry_classification_id")
    },
    on: {
      change: function change($event) {
        var $$selectedVal = Array.prototype.filter.call($event.target.options, function (o) {
          return o.selected;
        }).map(function (o) {
          var val = "_value" in o ? o._value : o.value;
          return val;
        });
        _vm.$set(_vm.$parent.form, "industry_classification_id", $event.target.multiple ? $$selectedVal : $$selectedVal[0]);
      }
    }
  }, _vm._l(_vm.$parent.industryClassifications, function (in_class) {
    return _c("option", {
      domProps: {
        value: in_class.id
      }
    }, [_vm._v("\n                " + _vm._s(in_class.name) + "\n            ")]);
  }), 0), _vm._v(" "), _vm.$parent.validationErrors.hasOwnProperty("industry_classification_id") ? _c("p", {
    staticClass: "text-danger d-block"
  }, [_vm._v("\n            " + _vm._s((_vm$$parent$validatio4 = _vm.$parent.validationErrors.industry_classification_id[0]) !== null && _vm$$parent$validatio4 !== void 0 ? _vm$$parent$validatio4 : "") + "\n        ")]) : _vm._e()]) : _vm._e(), _vm._v(" "), _c("div", {
    staticClass: "form-group"
  }, [_vm._m(4), _vm._v(" "), _vm._l(_vm.$parent.form.address, function (item, index) {
    var _vm$$parent$validatio5, _vm$$parent$validatio6, _vm$$parent$validatio7, _vm$$parent$validatio8, _vm$$parent$validatio9;
    return _c("div", {
      key: index,
      staticClass: "border rounded pl-4 pr-4 py-2 my-2",
      "class": {
        "bg-secondary": index !== 0
      }
    }, [_c("h6", {
      staticClass: "font-weight-bold mb-2"
    }, [_vm._v(_vm._s(index === 0 ? "Default Address" : "Address #" + (index + 1)))]), _vm._v(" "), _c("button", {
      directives: [{
        name: "show",
        rawName: "v-show",
        value: index != 0,
        expression: "index != 0"
      }],
      staticClass: "btn btn-sm btn-secondary rounded-circle p-0 position-absolute",
      staticStyle: {
        left: "11px",
        width: "40px",
        height: "40px"
      },
      attrs: {
        type: "button",
        role: "button"
      },
      on: {
        click: function click($event) {
          return _vm.removeAddress(index);
        }
      }
    }, [_c("i", {
      staticClass: "icon-cross font-weight-bold",
      staticStyle: {
        "font-size": "1.2rem"
      }
    })]), _vm._v(" "), _c("div", {
      staticClass: "form-group"
    }, [_c("label", {
      attrs: {
        "for": "address_name" + index
      }
    }, [_vm._v("Address Name "), _c("span", {
      staticClass: "text-danger"
    }, [_vm._v("*")])]), _vm._v(" "), _c("div", {
      staticClass: "pl-0"
    }, [_c("input", {
      directives: [{
        name: "model",
        rawName: "v-model",
        value: item.address_name,
        expression: "item.address_name"
      }],
      staticClass: "form-control",
      "class": {
        "is-invalid": _vm.$parent.validationErrors.hasOwnProperty("address.".concat(index, ".address_name"))
      },
      attrs: {
        type: "text",
        id: "address_name" + index,
        placeholder: "Enter Address Name",
        required: ""
      },
      domProps: {
        value: item.address_name
      },
      on: {
        input: function input($event) {
          if ($event.target.composing) return;
          _vm.$set(item, "address_name", $event.target.value);
        }
      }
    })]), _vm._v(" "), _vm.$parent.validationErrors.hasOwnProperty("address.".concat(index, ".address_name")) ? _c("p", {
      staticClass: "text-danger d-block"
    }, [_vm._v("\n                    " + _vm._s((_vm$$parent$validatio5 = _vm.$parent.validationErrors["address.".concat(index, ".address_name")][0]) !== null && _vm$$parent$validatio5 !== void 0 ? _vm$$parent$validatio5 : "") + "\n                ")]) : _vm._e()]), _vm._v(" "), _c("div", {
      staticClass: "form-group"
    }, [_c("label", {
      attrs: {
        "for": "address_1" + index
      }
    }, [_vm._v("Street Address "), _c("span", {
      staticClass: "text-danger"
    }, [_vm._v("*")])]), _vm._v(" "), _c("div", {
      staticClass: "mb-1"
    }, [_c("input", {
      directives: [{
        name: "model",
        rawName: "v-model",
        value: item.address_1,
        expression: "item.address_1"
      }],
      staticClass: "form-control",
      "class": {
        "is-invalid": _vm.$parent.validationErrors.hasOwnProperty("address.".concat(index, ".address_1"))
      },
      attrs: {
        type: "text",
        id: "address_1" + index,
        placeholder: "Line 1",
        required: ""
      },
      domProps: {
        value: item.address_1
      },
      on: {
        input: function input($event) {
          if ($event.target.composing) return;
          _vm.$set(item, "address_1", $event.target.value);
        }
      }
    }), _vm._v(" "), _vm.$parent.validationErrors.hasOwnProperty("address.".concat(index, ".address_1")) ? _c("p", {
      staticClass: "text-danger d-block"
    }, [_vm._v("\n                        " + _vm._s((_vm$$parent$validatio6 = _vm.$parent.validationErrors["address.".concat(index, ".address_1")][0]) !== null && _vm$$parent$validatio6 !== void 0 ? _vm$$parent$validatio6 : "") + "\n                    ")]) : _vm._e()]), _vm._v(" "), _c("div", {
      staticClass: "mb-1"
    }, [_c("input", {
      directives: [{
        name: "model",
        rawName: "v-model",
        value: item.address_2,
        expression: "item.address_2"
      }],
      staticClass: "form-control",
      attrs: {
        type: "text",
        id: "address_2" + index,
        placeholder: "Line 2",
        required: ""
      },
      domProps: {
        value: item.address_2
      },
      on: {
        input: function input($event) {
          if ($event.target.composing) return;
          _vm.$set(item, "address_2", $event.target.value);
        }
      }
    })]), _vm._v(" "), _c("div", {
      staticClass: "mb-1"
    }, [_c("input", {
      directives: [{
        name: "model",
        rawName: "v-model",
        value: item.address_3,
        expression: "item.address_3"
      }],
      staticClass: "form-control",
      attrs: {
        type: "text",
        id: "address_3" + index,
        placeholder: "Line 3",
        required: ""
      },
      domProps: {
        value: item.address_3
      },
      on: {
        input: function input($event) {
          if ($event.target.composing) return;
          _vm.$set(item, "address_3", $event.target.value);
        }
      }
    })])]), _vm._v(" "), _c("div", {
      staticClass: "form-row"
    }, [_c("div", {
      staticClass: "col-md-6 col-sm-12"
    }, [_c("div", {
      staticClass: "form-group"
    }, [_c("label", {
      attrs: {
        "for": "city_" + index
      }
    }, [_vm._v("City"), _c("span", {
      staticClass: "text-danger"
    }, [_vm._v("*")])]), _vm._v(" "), _c("input", {
      directives: [{
        name: "model",
        rawName: "v-model",
        value: item.city,
        expression: "item.city"
      }],
      staticClass: "form-control",
      "class": {
        "is-invalid": _vm.$parent.validationErrors.hasOwnProperty("address.".concat(index, ".city"))
      },
      attrs: {
        type: "text",
        id: "city_" + index,
        placeholder: "Enter City",
        required: ""
      },
      domProps: {
        value: item.city
      },
      on: {
        input: function input($event) {
          if ($event.target.composing) return;
          _vm.$set(item, "city", $event.target.value);
        }
      }
    }), _vm._v(" "), _vm.$parent.validationErrors.hasOwnProperty("address.".concat(index, ".city")) ? _c("p", {
      staticClass: "text-danger d-block"
    }, [_vm._v("\n                            " + _vm._s((_vm$$parent$validatio7 = _vm.$parent.validationErrors["address.".concat(index, ".city")][0]) !== null && _vm$$parent$validatio7 !== void 0 ? _vm$$parent$validatio7 : "") + "\n                        ")]) : _vm._e()])]), _vm._v(" "), _c("div", {
      staticClass: "col-md-6 col-sm-12"
    }, [_c("div", {
      staticClass: "form-group"
    }, [_c("label", {
      attrs: {
        "for": "state_" + index
      }
    }, [_vm._v("State"), _c("span", {
      staticClass: "text-danger"
    }, [_vm._v("*")])]), _vm._v(" "), _c("input", {
      directives: [{
        name: "model",
        rawName: "v-model",
        value: item.state,
        expression: "item.state"
      }],
      staticClass: "form-control",
      "class": {
        "is-invalid": _vm.$parent.validationErrors.hasOwnProperty("address.".concat(index, ".state"))
      },
      attrs: {
        type: "text",
        id: "state_" + index,
        placeholder: "Enter State",
        required: ""
      },
      domProps: {
        value: item.state
      },
      on: {
        input: function input($event) {
          if ($event.target.composing) return;
          _vm.$set(item, "state", $event.target.value);
        }
      }
    }), _vm._v(" "), _vm.$parent.validationErrors.hasOwnProperty("address.".concat(index, ".state")) ? _c("p", {
      staticClass: "text-danger d-block"
    }, [_vm._v("\n                            " + _vm._s((_vm$$parent$validatio8 = _vm.$parent.validationErrors["address.".concat(index, ".state")][0]) !== null && _vm$$parent$validatio8 !== void 0 ? _vm$$parent$validatio8 : "") + "\n                        ")]) : _vm._e()])]), _vm._v(" "), _c("div", {
      staticClass: "col-md-6 col-sm-12"
    }, [_c("div", {
      staticClass: "form-group"
    }, [_c("label", {
      attrs: {
        "for": "country_code_" + index
      }
    }, [_vm._v("Country Code")]), _vm._v(" "), _c("input", {
      directives: [{
        name: "model",
        rawName: "v-model",
        value: item.country_code,
        expression: "item.country_code"
      }],
      staticClass: "form-control",
      attrs: {
        type: "text",
        id: "country_code_" + index,
        placeholder: "Enter Country Code"
      },
      domProps: {
        value: item.country_code
      },
      on: {
        input: function input($event) {
          if ($event.target.composing) return;
          _vm.$set(item, "country_code", $event.target.value);
        }
      }
    })])]), _vm._v(" "), _c("div", {
      staticClass: "col-md-6 col-sm-12"
    }, [_c("div", {
      staticClass: "form-group"
    }, [_c("label", {
      attrs: {
        "for": "zip_code_" + index
      }
    }, [_vm._v("Zip Code "), _c("span", {
      staticClass: "text-danger"
    }, [_vm._v("*")])]), _vm._v(" "), _c("input", {
      directives: [{
        name: "model",
        rawName: "v-model",
        value: item.zip_code,
        expression: "item.zip_code"
      }],
      staticClass: "form-control",
      "class": {
        "is-invalid": _vm.$parent.validationErrors.hasOwnProperty("address.".concat(index, ".zip_code"))
      },
      attrs: {
        type: "text",
        id: "zip_code_" + index,
        placeholder: "Enter Zip Code",
        required: ""
      },
      domProps: {
        value: item.zip_code
      },
      on: {
        input: function input($event) {
          if ($event.target.composing) return;
          _vm.$set(item, "zip_code", $event.target.value);
        }
      }
    }), _vm._v(" "), _vm.$parent.validationErrors.hasOwnProperty("address.".concat(index, ".zip_code")) ? _c("p", {
      staticClass: "text-danger d-block"
    }, [_vm._v("\n                            " + _vm._s((_vm$$parent$validatio9 = _vm.$parent.validationErrors["address.".concat(index, ".zip_code")][0]) !== null && _vm$$parent$validatio9 !== void 0 ? _vm$$parent$validatio9 : "") + "\n                        ")]) : _vm._e()])])])]);
  })], 2), _vm._v(" "), _c("div", {
    staticClass: "col-12 d-flex justify-content-between p-0"
  }, [_c("button", {
    staticClass: "btn btn-outline-primary",
    attrs: {
      type: "button",
      role: "button"
    },
    on: {
      click: function click($event) {
        return _vm.addAddress();
      }
    }
  }, [_vm._v("\n            +Add More Address\n        ")]), _vm._v(" "), _c("button", {
    staticClass: "btn btn-info margin-bottom-none mr-0",
    attrs: {
      type: "button"
    },
    on: {
      click: function click($event) {
        return _vm.validateData();
      }
    }
  }, [_c("i", {
    staticClass: "pe-7s-angle-right-circle"
  }), _vm._v(" Next\n        ")])])]);
};
var staticRenderFns = [function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("label", {
    attrs: {
      "for": "customer_name"
    }
  }, [_vm._v("Customer Name "), _c("span", {
    staticClass: "text-danger"
  }, [_vm._v("*")])]);
}, function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("label", {
    attrs: {
      "for": "email"
    }
  }, [_vm._v("Email Address "), _c("span", {
    staticClass: "text-danger"
  }, [_vm._v("*")])]);
}, function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("label", {
    attrs: {
      "for": "phone"
    }
  }, [_vm._v("Phone Number"), _c("span", {
    staticClass: "text-danger"
  }, [_vm._v("*")])]);
}, function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("label", {
    attrs: {
      "for": "industry_classification_id"
    }
  }, [_vm._v("Industry Classification"), _c("span", {
    staticClass: "text-danger"
  }, [_vm._v("*")])]);
}, function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("label", {
    attrs: {
      "for": "password"
    }
  }, [_vm._v("Addresses"), _c("span", {
    staticClass: "text-danger"
  }, [_vm._v("*")])]);
}];
render._withStripped = true;


/***/ }),

/***/ "./node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/pages/auth/register/default/Index.vue?vue&type=template&id=07d8f5fc&scoped=true":
/*!***********************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/pages/auth/register/default/Index.vue?vue&type=template&id=07d8f5fc&scoped=true ***!
  \***********************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   render: () => (/* binding */ render),
/* harmony export */   staticRenderFns: () => (/* binding */ staticRenderFns)
/* harmony export */ });
var render = function render() {
  var _vm$company_tab_title, _vm$admin_tab_title;
  var _vm = this,
    _c = _vm._self._c;
  return _c("div", [_c("ul", {
    staticClass: "nav nav-tabs nav-justified"
  }, [_c("li", {
    staticClass: "nav-item"
  }, [_c("a", {
    staticClass: "nav-link",
    "class": {
      active: _vm.step == "company",
      disabled: _vm.step != "company"
    },
    attrs: {
      href: "#home2",
      "data-toggle": "tab",
      role: "tab"
    }
  }, [_vm._v("\n                " + _vm._s((_vm$company_tab_title = _vm.company_tab_title) !== null && _vm$company_tab_title !== void 0 ? _vm$company_tab_title : "") + "\n            ")])]), _vm._v(" "), _c("li", {
    staticClass: "nav-item"
  }, [_c("a", {
    staticClass: "nav-link",
    "class": {
      active: _vm.step == "admin",
      disabled: _vm.step != "admin"
    },
    attrs: {
      href: "#profile2",
      "data-toggle": "tab",
      role: "tab"
    }
  }, [_vm._v("\n                " + _vm._s((_vm$admin_tab_title = _vm.admin_tab_title) !== null && _vm$admin_tab_title !== void 0 ? _vm$admin_tab_title : "") + "\n            ")])])]), _vm._v(" "), _c("div", {
    staticClass: "tab-content p-3"
  }, [_c("div", {
    staticClass: "tab-pane fade home-tab",
    "class": {
      "show active": _vm.step == "company"
    },
    attrs: {
      id: "home2",
      role: "tabpanel"
    }
  }, [_c("Company")], 1), _vm._v(" "), _c("div", {
    staticClass: "tab-pane fade home-tab",
    "class": {
      "show active": _vm.step == "admin"
    },
    attrs: {
      id: "profile2",
      role: "tabpanel"
    }
  }, [_c("Admin")], 1)])]);
};
var staticRenderFns = [];
render._withStripped = true;


/***/ }),

/***/ "./node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/laravel-mix/node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/pages/auth/register/default/Admin.vue?vue&type=style&index=0&id=2d82d8ff&lang=css":
/*!*********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/laravel-mix/node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/pages/auth/register/default/Admin.vue?vue&type=style&index=0&id=2d82d8ff&lang=css ***!
  \*********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_laravel_mix_node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../../../../../../node_modules/laravel-mix/node_modules/css-loader/dist/runtime/api.js */ "./node_modules/laravel-mix/node_modules/css-loader/dist/runtime/api.js");
/* harmony import */ var _node_modules_laravel_mix_node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_laravel_mix_node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0__);
// Imports

var ___CSS_LOADER_EXPORT___ = _node_modules_laravel_mix_node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0___default()(function(i){return i[1]});
// Module
___CSS_LOADER_EXPORT___.push([module.id, "\n.captcha-container {\n    height: 60px !important;\n}\n.captcha-container > img {\n    width: 100% !important;\n    height: 100% !important;\n    -o-object-fit: contain;\n       object-fit: contain;\n}\n", ""]);
// Exports
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (___CSS_LOADER_EXPORT___);


/***/ }),

/***/ "./node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/laravel-mix/node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/pages/auth/register/default/Company.vue?vue&type=style&index=0&id=15d9852d&lang=css":
/*!***********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/laravel-mix/node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/pages/auth/register/default/Company.vue?vue&type=style&index=0&id=15d9852d&lang=css ***!
  \***********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_laravel_mix_node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../../../../../../node_modules/laravel-mix/node_modules/css-loader/dist/runtime/api.js */ "./node_modules/laravel-mix/node_modules/css-loader/dist/runtime/api.js");
/* harmony import */ var _node_modules_laravel_mix_node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_laravel_mix_node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0__);
// Imports

var ___CSS_LOADER_EXPORT___ = _node_modules_laravel_mix_node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0___default()(function(i){return i[1]});
// Module
___CSS_LOADER_EXPORT___.push([module.id, "\n.form-control:invalid,\n.form-control.is-invalid {\n    background-position: 99%;\n}\n", ""]);
// Exports
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (___CSS_LOADER_EXPORT___);


/***/ }),

/***/ "./node_modules/laravel-mix/node_modules/style-loader/dist/cjs.js!./node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/laravel-mix/node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/pages/auth/register/default/Admin.vue?vue&type=style&index=0&id=2d82d8ff&lang=css":
/*!**************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/laravel-mix/node_modules/style-loader/dist/cjs.js!./node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/laravel-mix/node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/pages/auth/register/default/Admin.vue?vue&type=style&index=0&id=2d82d8ff&lang=css ***!
  \**************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_laravel_mix_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! !../../../../../../../node_modules/laravel-mix/node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js */ "./node_modules/laravel-mix/node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js");
/* harmony import */ var _node_modules_laravel_mix_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_laravel_mix_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _node_modules_laravel_mix_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_laravel_mix_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_Admin_vue_vue_type_style_index_0_id_2d82d8ff_lang_css__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! !!../../../../../../../node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!../../../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../../../node_modules/laravel-mix/node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!../../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Admin.vue?vue&type=style&index=0&id=2d82d8ff&lang=css */ "./node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/laravel-mix/node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/pages/auth/register/default/Admin.vue?vue&type=style&index=0&id=2d82d8ff&lang=css");

            

var options = {};

options.insert = "head";
options.singleton = false;

var update = _node_modules_laravel_mix_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default()(_node_modules_laravel_mix_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_laravel_mix_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_Admin_vue_vue_type_style_index_0_id_2d82d8ff_lang_css__WEBPACK_IMPORTED_MODULE_1__["default"], options);



/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_laravel_mix_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_laravel_mix_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_Admin_vue_vue_type_style_index_0_id_2d82d8ff_lang_css__WEBPACK_IMPORTED_MODULE_1__["default"].locals || {});

/***/ }),

/***/ "./node_modules/laravel-mix/node_modules/style-loader/dist/cjs.js!./node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/laravel-mix/node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/pages/auth/register/default/Company.vue?vue&type=style&index=0&id=15d9852d&lang=css":
/*!****************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/laravel-mix/node_modules/style-loader/dist/cjs.js!./node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/laravel-mix/node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/pages/auth/register/default/Company.vue?vue&type=style&index=0&id=15d9852d&lang=css ***!
  \****************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_laravel_mix_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! !../../../../../../../node_modules/laravel-mix/node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js */ "./node_modules/laravel-mix/node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js");
/* harmony import */ var _node_modules_laravel_mix_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_laravel_mix_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _node_modules_laravel_mix_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_laravel_mix_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_Company_vue_vue_type_style_index_0_id_15d9852d_lang_css__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! !!../../../../../../../node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!../../../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../../../node_modules/laravel-mix/node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!../../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Company.vue?vue&type=style&index=0&id=15d9852d&lang=css */ "./node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/laravel-mix/node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/pages/auth/register/default/Company.vue?vue&type=style&index=0&id=15d9852d&lang=css");

            

var options = {};

options.insert = "head";
options.singleton = false;

var update = _node_modules_laravel_mix_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default()(_node_modules_laravel_mix_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_laravel_mix_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_Company_vue_vue_type_style_index_0_id_15d9852d_lang_css__WEBPACK_IMPORTED_MODULE_1__["default"], options);



/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_laravel_mix_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_laravel_mix_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_Company_vue_vue_type_style_index_0_id_15d9852d_lang_css__WEBPACK_IMPORTED_MODULE_1__["default"].locals || {});

/***/ }),

/***/ "./resources/vue/views/pages/auth/Registration.vue":
/*!*********************************************************!*\
  !*** ./resources/vue/views/pages/auth/Registration.vue ***!
  \*********************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _Registration_vue_vue_type_template_id_6eb8123a__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Registration.vue?vue&type=template&id=6eb8123a */ "./resources/vue/views/pages/auth/Registration.vue?vue&type=template&id=6eb8123a");
/* harmony import */ var _Registration_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Registration.vue?vue&type=script&lang=js */ "./resources/vue/views/pages/auth/Registration.vue?vue&type=script&lang=js");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _Registration_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"],
  _Registration_vue_vue_type_template_id_6eb8123a__WEBPACK_IMPORTED_MODULE_0__.render,
  _Registration_vue_vue_type_template_id_6eb8123a__WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/vue/views/pages/auth/Registration.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/vue/views/pages/auth/register/cal-tool/CommercialAccount.vue":
/*!********************************************************************************!*\
  !*** ./resources/vue/views/pages/auth/register/cal-tool/CommercialAccount.vue ***!
  \********************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _CommercialAccount_vue_vue_type_template_id_fe4ced46__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./CommercialAccount.vue?vue&type=template&id=fe4ced46 */ "./resources/vue/views/pages/auth/register/cal-tool/CommercialAccount.vue?vue&type=template&id=fe4ced46");
/* harmony import */ var _CommercialAccount_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./CommercialAccount.vue?vue&type=script&lang=js */ "./resources/vue/views/pages/auth/register/cal-tool/CommercialAccount.vue?vue&type=script&lang=js");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _CommercialAccount_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"],
  _CommercialAccount_vue_vue_type_template_id_fe4ced46__WEBPACK_IMPORTED_MODULE_0__.render,
  _CommercialAccount_vue_vue_type_template_id_fe4ced46__WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/vue/views/pages/auth/register/cal-tool/CommercialAccount.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/vue/views/pages/auth/register/cal-tool/CurrentCustomer.vue":
/*!******************************************************************************!*\
  !*** ./resources/vue/views/pages/auth/register/cal-tool/CurrentCustomer.vue ***!
  \******************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _CurrentCustomer_vue_vue_type_template_id_13ce50d1_scoped_true__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./CurrentCustomer.vue?vue&type=template&id=13ce50d1&scoped=true */ "./resources/vue/views/pages/auth/register/cal-tool/CurrentCustomer.vue?vue&type=template&id=13ce50d1&scoped=true");
/* harmony import */ var _CurrentCustomer_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./CurrentCustomer.vue?vue&type=script&lang=js */ "./resources/vue/views/pages/auth/register/cal-tool/CurrentCustomer.vue?vue&type=script&lang=js");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _CurrentCustomer_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"],
  _CurrentCustomer_vue_vue_type_template_id_13ce50d1_scoped_true__WEBPACK_IMPORTED_MODULE_0__.render,
  _CurrentCustomer_vue_vue_type_template_id_13ce50d1_scoped_true__WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  "13ce50d1",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/vue/views/pages/auth/register/cal-tool/CurrentCustomer.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/vue/views/pages/auth/register/cal-tool/Index.vue":
/*!********************************************************************!*\
  !*** ./resources/vue/views/pages/auth/register/cal-tool/Index.vue ***!
  \********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _Index_vue_vue_type_template_id_45c1062c_scoped_true__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Index.vue?vue&type=template&id=45c1062c&scoped=true */ "./resources/vue/views/pages/auth/register/cal-tool/Index.vue?vue&type=template&id=45c1062c&scoped=true");
/* harmony import */ var _Index_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Index.vue?vue&type=script&lang=js */ "./resources/vue/views/pages/auth/register/cal-tool/Index.vue?vue&type=script&lang=js");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _Index_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"],
  _Index_vue_vue_type_template_id_45c1062c_scoped_true__WEBPACK_IMPORTED_MODULE_0__.render,
  _Index_vue_vue_type_template_id_45c1062c_scoped_true__WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  "45c1062c",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/vue/views/pages/auth/register/cal-tool/Index.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/vue/views/pages/auth/register/cal-tool/RetailCustomer.vue":
/*!*****************************************************************************!*\
  !*** ./resources/vue/views/pages/auth/register/cal-tool/RetailCustomer.vue ***!
  \*****************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _RetailCustomer_vue_vue_type_template_id_2985bad2_scoped_true__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./RetailCustomer.vue?vue&type=template&id=2985bad2&scoped=true */ "./resources/vue/views/pages/auth/register/cal-tool/RetailCustomer.vue?vue&type=template&id=2985bad2&scoped=true");
/* harmony import */ var _RetailCustomer_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./RetailCustomer.vue?vue&type=script&lang=js */ "./resources/vue/views/pages/auth/register/cal-tool/RetailCustomer.vue?vue&type=script&lang=js");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _RetailCustomer_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"],
  _RetailCustomer_vue_vue_type_template_id_2985bad2_scoped_true__WEBPACK_IMPORTED_MODULE_0__.render,
  _RetailCustomer_vue_vue_type_template_id_2985bad2_scoped_true__WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  "2985bad2",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/vue/views/pages/auth/register/cal-tool/RetailCustomer.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/vue/views/pages/auth/register/default/Admin.vue":
/*!*******************************************************************!*\
  !*** ./resources/vue/views/pages/auth/register/default/Admin.vue ***!
  \*******************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _Admin_vue_vue_type_template_id_2d82d8ff__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Admin.vue?vue&type=template&id=2d82d8ff */ "./resources/vue/views/pages/auth/register/default/Admin.vue?vue&type=template&id=2d82d8ff");
/* harmony import */ var _Admin_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Admin.vue?vue&type=script&lang=js */ "./resources/vue/views/pages/auth/register/default/Admin.vue?vue&type=script&lang=js");
/* harmony import */ var _Admin_vue_vue_type_style_index_0_id_2d82d8ff_lang_css__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./Admin.vue?vue&type=style&index=0&id=2d82d8ff&lang=css */ "./resources/vue/views/pages/auth/register/default/Admin.vue?vue&type=style&index=0&id=2d82d8ff&lang=css");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! !../../../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");



;


/* normalize component */

var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__["default"])(
  _Admin_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"],
  _Admin_vue_vue_type_template_id_2d82d8ff__WEBPACK_IMPORTED_MODULE_0__.render,
  _Admin_vue_vue_type_template_id_2d82d8ff__WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/vue/views/pages/auth/register/default/Admin.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/vue/views/pages/auth/register/default/Company.vue":
/*!*********************************************************************!*\
  !*** ./resources/vue/views/pages/auth/register/default/Company.vue ***!
  \*********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _Company_vue_vue_type_template_id_15d9852d__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Company.vue?vue&type=template&id=15d9852d */ "./resources/vue/views/pages/auth/register/default/Company.vue?vue&type=template&id=15d9852d");
/* harmony import */ var _Company_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Company.vue?vue&type=script&lang=js */ "./resources/vue/views/pages/auth/register/default/Company.vue?vue&type=script&lang=js");
/* harmony import */ var _Company_vue_vue_type_style_index_0_id_15d9852d_lang_css__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./Company.vue?vue&type=style&index=0&id=15d9852d&lang=css */ "./resources/vue/views/pages/auth/register/default/Company.vue?vue&type=style&index=0&id=15d9852d&lang=css");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! !../../../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");



;


/* normalize component */

var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__["default"])(
  _Company_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"],
  _Company_vue_vue_type_template_id_15d9852d__WEBPACK_IMPORTED_MODULE_0__.render,
  _Company_vue_vue_type_template_id_15d9852d__WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/vue/views/pages/auth/register/default/Company.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/vue/views/pages/auth/register/default/Index.vue":
/*!*******************************************************************!*\
  !*** ./resources/vue/views/pages/auth/register/default/Index.vue ***!
  \*******************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _Index_vue_vue_type_template_id_07d8f5fc_scoped_true__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Index.vue?vue&type=template&id=07d8f5fc&scoped=true */ "./resources/vue/views/pages/auth/register/default/Index.vue?vue&type=template&id=07d8f5fc&scoped=true");
/* harmony import */ var _Index_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Index.vue?vue&type=script&lang=js */ "./resources/vue/views/pages/auth/register/default/Index.vue?vue&type=script&lang=js");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _Index_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"],
  _Index_vue_vue_type_template_id_07d8f5fc_scoped_true__WEBPACK_IMPORTED_MODULE_0__.render,
  _Index_vue_vue_type_template_id_07d8f5fc_scoped_true__WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  "07d8f5fc",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/vue/views/pages/auth/register/default/Index.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/vue/views/pages/auth/Registration.vue?vue&type=script&lang=js":
/*!*********************************************************************************!*\
  !*** ./resources/vue/views/pages/auth/Registration.vue?vue&type=script&lang=js ***!
  \*********************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_laravel_mix_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Registration_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Registration.vue?vue&type=script&lang=js */ "./node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/pages/auth/Registration.vue?vue&type=script&lang=js");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_laravel_mix_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Registration_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/vue/views/pages/auth/register/cal-tool/CommercialAccount.vue?vue&type=script&lang=js":
/*!********************************************************************************************************!*\
  !*** ./resources/vue/views/pages/auth/register/cal-tool/CommercialAccount.vue?vue&type=script&lang=js ***!
  \********************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_laravel_mix_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_CommercialAccount_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../../node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./CommercialAccount.vue?vue&type=script&lang=js */ "./node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/pages/auth/register/cal-tool/CommercialAccount.vue?vue&type=script&lang=js");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_laravel_mix_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_CommercialAccount_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/vue/views/pages/auth/register/cal-tool/CurrentCustomer.vue?vue&type=script&lang=js":
/*!******************************************************************************************************!*\
  !*** ./resources/vue/views/pages/auth/register/cal-tool/CurrentCustomer.vue?vue&type=script&lang=js ***!
  \******************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_laravel_mix_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_CurrentCustomer_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../../node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./CurrentCustomer.vue?vue&type=script&lang=js */ "./node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/pages/auth/register/cal-tool/CurrentCustomer.vue?vue&type=script&lang=js");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_laravel_mix_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_CurrentCustomer_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/vue/views/pages/auth/register/cal-tool/Index.vue?vue&type=script&lang=js":
/*!********************************************************************************************!*\
  !*** ./resources/vue/views/pages/auth/register/cal-tool/Index.vue?vue&type=script&lang=js ***!
  \********************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_laravel_mix_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../../node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Index.vue?vue&type=script&lang=js */ "./node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/pages/auth/register/cal-tool/Index.vue?vue&type=script&lang=js");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_laravel_mix_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/vue/views/pages/auth/register/cal-tool/RetailCustomer.vue?vue&type=script&lang=js":
/*!*****************************************************************************************************!*\
  !*** ./resources/vue/views/pages/auth/register/cal-tool/RetailCustomer.vue?vue&type=script&lang=js ***!
  \*****************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_laravel_mix_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_RetailCustomer_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../../node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./RetailCustomer.vue?vue&type=script&lang=js */ "./node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/pages/auth/register/cal-tool/RetailCustomer.vue?vue&type=script&lang=js");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_laravel_mix_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_RetailCustomer_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/vue/views/pages/auth/register/default/Admin.vue?vue&type=script&lang=js":
/*!*******************************************************************************************!*\
  !*** ./resources/vue/views/pages/auth/register/default/Admin.vue?vue&type=script&lang=js ***!
  \*******************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_laravel_mix_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Admin_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../../node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Admin.vue?vue&type=script&lang=js */ "./node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/pages/auth/register/default/Admin.vue?vue&type=script&lang=js");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_laravel_mix_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Admin_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/vue/views/pages/auth/register/default/Company.vue?vue&type=script&lang=js":
/*!*********************************************************************************************!*\
  !*** ./resources/vue/views/pages/auth/register/default/Company.vue?vue&type=script&lang=js ***!
  \*********************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_laravel_mix_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Company_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../../node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Company.vue?vue&type=script&lang=js */ "./node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/pages/auth/register/default/Company.vue?vue&type=script&lang=js");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_laravel_mix_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Company_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/vue/views/pages/auth/register/default/Index.vue?vue&type=script&lang=js":
/*!*******************************************************************************************!*\
  !*** ./resources/vue/views/pages/auth/register/default/Index.vue?vue&type=script&lang=js ***!
  \*******************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_laravel_mix_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../../node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Index.vue?vue&type=script&lang=js */ "./node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/pages/auth/register/default/Index.vue?vue&type=script&lang=js");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_laravel_mix_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/vue/views/pages/auth/Registration.vue?vue&type=template&id=6eb8123a":
/*!***************************************************************************************!*\
  !*** ./resources/vue/views/pages/auth/Registration.vue?vue&type=template&id=6eb8123a ***!
  \***************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   render: () => (/* reexport safe */ _node_modules_laravel_mix_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_Registration_vue_vue_type_template_id_6eb8123a__WEBPACK_IMPORTED_MODULE_0__.render),
/* harmony export */   staticRenderFns: () => (/* reexport safe */ _node_modules_laravel_mix_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_Registration_vue_vue_type_template_id_6eb8123a__WEBPACK_IMPORTED_MODULE_0__.staticRenderFns)
/* harmony export */ });
/* harmony import */ var _node_modules_laravel_mix_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_Registration_vue_vue_type_template_id_6eb8123a__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Registration.vue?vue&type=template&id=6eb8123a */ "./node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/pages/auth/Registration.vue?vue&type=template&id=6eb8123a");


/***/ }),

/***/ "./resources/vue/views/pages/auth/register/cal-tool/CommercialAccount.vue?vue&type=template&id=fe4ced46":
/*!**************************************************************************************************************!*\
  !*** ./resources/vue/views/pages/auth/register/cal-tool/CommercialAccount.vue?vue&type=template&id=fe4ced46 ***!
  \**************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   render: () => (/* reexport safe */ _node_modules_laravel_mix_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_CommercialAccount_vue_vue_type_template_id_fe4ced46__WEBPACK_IMPORTED_MODULE_0__.render),
/* harmony export */   staticRenderFns: () => (/* reexport safe */ _node_modules_laravel_mix_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_CommercialAccount_vue_vue_type_template_id_fe4ced46__WEBPACK_IMPORTED_MODULE_0__.staticRenderFns)
/* harmony export */ });
/* harmony import */ var _node_modules_laravel_mix_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_CommercialAccount_vue_vue_type_template_id_fe4ced46__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../../node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!../../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./CommercialAccount.vue?vue&type=template&id=fe4ced46 */ "./node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/pages/auth/register/cal-tool/CommercialAccount.vue?vue&type=template&id=fe4ced46");


/***/ }),

/***/ "./resources/vue/views/pages/auth/register/cal-tool/CurrentCustomer.vue?vue&type=template&id=13ce50d1&scoped=true":
/*!************************************************************************************************************************!*\
  !*** ./resources/vue/views/pages/auth/register/cal-tool/CurrentCustomer.vue?vue&type=template&id=13ce50d1&scoped=true ***!
  \************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   render: () => (/* reexport safe */ _node_modules_laravel_mix_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_CurrentCustomer_vue_vue_type_template_id_13ce50d1_scoped_true__WEBPACK_IMPORTED_MODULE_0__.render),
/* harmony export */   staticRenderFns: () => (/* reexport safe */ _node_modules_laravel_mix_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_CurrentCustomer_vue_vue_type_template_id_13ce50d1_scoped_true__WEBPACK_IMPORTED_MODULE_0__.staticRenderFns)
/* harmony export */ });
/* harmony import */ var _node_modules_laravel_mix_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_CurrentCustomer_vue_vue_type_template_id_13ce50d1_scoped_true__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../../node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!../../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./CurrentCustomer.vue?vue&type=template&id=13ce50d1&scoped=true */ "./node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/pages/auth/register/cal-tool/CurrentCustomer.vue?vue&type=template&id=13ce50d1&scoped=true");


/***/ }),

/***/ "./resources/vue/views/pages/auth/register/cal-tool/Index.vue?vue&type=template&id=45c1062c&scoped=true":
/*!**************************************************************************************************************!*\
  !*** ./resources/vue/views/pages/auth/register/cal-tool/Index.vue?vue&type=template&id=45c1062c&scoped=true ***!
  \**************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   render: () => (/* reexport safe */ _node_modules_laravel_mix_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_template_id_45c1062c_scoped_true__WEBPACK_IMPORTED_MODULE_0__.render),
/* harmony export */   staticRenderFns: () => (/* reexport safe */ _node_modules_laravel_mix_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_template_id_45c1062c_scoped_true__WEBPACK_IMPORTED_MODULE_0__.staticRenderFns)
/* harmony export */ });
/* harmony import */ var _node_modules_laravel_mix_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_template_id_45c1062c_scoped_true__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../../node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!../../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Index.vue?vue&type=template&id=45c1062c&scoped=true */ "./node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/pages/auth/register/cal-tool/Index.vue?vue&type=template&id=45c1062c&scoped=true");


/***/ }),

/***/ "./resources/vue/views/pages/auth/register/cal-tool/RetailCustomer.vue?vue&type=template&id=2985bad2&scoped=true":
/*!***********************************************************************************************************************!*\
  !*** ./resources/vue/views/pages/auth/register/cal-tool/RetailCustomer.vue?vue&type=template&id=2985bad2&scoped=true ***!
  \***********************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   render: () => (/* reexport safe */ _node_modules_laravel_mix_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_RetailCustomer_vue_vue_type_template_id_2985bad2_scoped_true__WEBPACK_IMPORTED_MODULE_0__.render),
/* harmony export */   staticRenderFns: () => (/* reexport safe */ _node_modules_laravel_mix_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_RetailCustomer_vue_vue_type_template_id_2985bad2_scoped_true__WEBPACK_IMPORTED_MODULE_0__.staticRenderFns)
/* harmony export */ });
/* harmony import */ var _node_modules_laravel_mix_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_RetailCustomer_vue_vue_type_template_id_2985bad2_scoped_true__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../../node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!../../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./RetailCustomer.vue?vue&type=template&id=2985bad2&scoped=true */ "./node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/pages/auth/register/cal-tool/RetailCustomer.vue?vue&type=template&id=2985bad2&scoped=true");


/***/ }),

/***/ "./resources/vue/views/pages/auth/register/default/Admin.vue?vue&type=template&id=2d82d8ff":
/*!*************************************************************************************************!*\
  !*** ./resources/vue/views/pages/auth/register/default/Admin.vue?vue&type=template&id=2d82d8ff ***!
  \*************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   render: () => (/* reexport safe */ _node_modules_laravel_mix_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_Admin_vue_vue_type_template_id_2d82d8ff__WEBPACK_IMPORTED_MODULE_0__.render),
/* harmony export */   staticRenderFns: () => (/* reexport safe */ _node_modules_laravel_mix_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_Admin_vue_vue_type_template_id_2d82d8ff__WEBPACK_IMPORTED_MODULE_0__.staticRenderFns)
/* harmony export */ });
/* harmony import */ var _node_modules_laravel_mix_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_Admin_vue_vue_type_template_id_2d82d8ff__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../../node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!../../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Admin.vue?vue&type=template&id=2d82d8ff */ "./node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/pages/auth/register/default/Admin.vue?vue&type=template&id=2d82d8ff");


/***/ }),

/***/ "./resources/vue/views/pages/auth/register/default/Company.vue?vue&type=template&id=15d9852d":
/*!***************************************************************************************************!*\
  !*** ./resources/vue/views/pages/auth/register/default/Company.vue?vue&type=template&id=15d9852d ***!
  \***************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   render: () => (/* reexport safe */ _node_modules_laravel_mix_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_Company_vue_vue_type_template_id_15d9852d__WEBPACK_IMPORTED_MODULE_0__.render),
/* harmony export */   staticRenderFns: () => (/* reexport safe */ _node_modules_laravel_mix_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_Company_vue_vue_type_template_id_15d9852d__WEBPACK_IMPORTED_MODULE_0__.staticRenderFns)
/* harmony export */ });
/* harmony import */ var _node_modules_laravel_mix_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_Company_vue_vue_type_template_id_15d9852d__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../../node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!../../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Company.vue?vue&type=template&id=15d9852d */ "./node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/pages/auth/register/default/Company.vue?vue&type=template&id=15d9852d");


/***/ }),

/***/ "./resources/vue/views/pages/auth/register/default/Index.vue?vue&type=template&id=07d8f5fc&scoped=true":
/*!*************************************************************************************************************!*\
  !*** ./resources/vue/views/pages/auth/register/default/Index.vue?vue&type=template&id=07d8f5fc&scoped=true ***!
  \*************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   render: () => (/* reexport safe */ _node_modules_laravel_mix_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_template_id_07d8f5fc_scoped_true__WEBPACK_IMPORTED_MODULE_0__.render),
/* harmony export */   staticRenderFns: () => (/* reexport safe */ _node_modules_laravel_mix_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_template_id_07d8f5fc_scoped_true__WEBPACK_IMPORTED_MODULE_0__.staticRenderFns)
/* harmony export */ });
/* harmony import */ var _node_modules_laravel_mix_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_template_id_07d8f5fc_scoped_true__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../../node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!../../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Index.vue?vue&type=template&id=07d8f5fc&scoped=true */ "./node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/pages/auth/register/default/Index.vue?vue&type=template&id=07d8f5fc&scoped=true");


/***/ }),

/***/ "./resources/vue/views/pages/auth/register/default/Admin.vue?vue&type=style&index=0&id=2d82d8ff&lang=css":
/*!***************************************************************************************************************!*\
  !*** ./resources/vue/views/pages/auth/register/default/Admin.vue?vue&type=style&index=0&id=2d82d8ff&lang=css ***!
  \***************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_laravel_mix_node_modules_style_loader_dist_cjs_js_node_modules_laravel_mix_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_laravel_mix_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_Admin_vue_vue_type_style_index_0_id_2d82d8ff_lang_css__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../../node_modules/laravel-mix/node_modules/style-loader/dist/cjs.js!../../../../../../../node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!../../../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../../../node_modules/laravel-mix/node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!../../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Admin.vue?vue&type=style&index=0&id=2d82d8ff&lang=css */ "./node_modules/laravel-mix/node_modules/style-loader/dist/cjs.js!./node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/laravel-mix/node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/pages/auth/register/default/Admin.vue?vue&type=style&index=0&id=2d82d8ff&lang=css");


/***/ }),

/***/ "./resources/vue/views/pages/auth/register/default/Company.vue?vue&type=style&index=0&id=15d9852d&lang=css":
/*!*****************************************************************************************************************!*\
  !*** ./resources/vue/views/pages/auth/register/default/Company.vue?vue&type=style&index=0&id=15d9852d&lang=css ***!
  \*****************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_laravel_mix_node_modules_style_loader_dist_cjs_js_node_modules_laravel_mix_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_laravel_mix_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_Company_vue_vue_type_style_index_0_id_15d9852d_lang_css__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../../node_modules/laravel-mix/node_modules/style-loader/dist/cjs.js!../../../../../../../node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!../../../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../../../node_modules/laravel-mix/node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!../../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Company.vue?vue&type=style&index=0&id=15d9852d&lang=css */ "./node_modules/laravel-mix/node_modules/style-loader/dist/cjs.js!./node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/laravel-mix/node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/pages/auth/register/default/Company.vue?vue&type=style&index=0&id=15d9852d&lang=css");


/***/ })

}]);