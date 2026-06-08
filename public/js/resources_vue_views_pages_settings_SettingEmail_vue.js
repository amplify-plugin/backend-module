"use strict";
(self["webpackChunkbackend"] = self["webpackChunkbackend"] || []).push([["resources_vue_views_pages_settings_SettingEmail_vue"],{

/***/ "../../node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/pages/settings/SettingEmail.vue?vue&type=script&lang=js":
/*!**************************************************************************************************************************************************************************************************************************************************!*\
  !*** ../../node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/pages/settings/SettingEmail.vue?vue&type=script&lang=js ***!
  \**************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var lodash__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! lodash */ "../../node_modules/lodash/lodash.js");
/* harmony import */ var lodash__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(lodash__WEBPACK_IMPORTED_MODULE_0__);

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  name: "SettingEmail",
  components: {},
  props: ['url', 'axios_url', 'query_string', 'method', 'events', 'email_data', 'save_action'],
  data: function data() {
    return {
      host: window.location.host,
      email: {
        event_id: null,
        name: null,
        subject: null,
        email_body: null,
        notification_type: 'emailable',
        show_button: 0,
        button_text: null,
        button_url: null
      },
      backUrl: '/admin/event-template',
      validationErrors: {},
      allEvents: JSON.parse(this.events),
      copyButtonText: 'Copy',
      dynamicStrings: [],
      actionType: 'save_and_back',
      saveAction: JSON.parse(this.save_action)
    };
  },
  created: function created() {
    if (this.method === 'put') {
      this.initEdit();
    }
  },
  methods: {
    initEdit: function initEdit() {
      var emailData = JSON.parse(this.email_data);
      this.email = {
        id: emailData.id,
        event_id: emailData.event_id,
        name: emailData.name,
        subject: emailData.subject,
        email_body: emailData.email_body,
        show_button: emailData.show_button,
        notification_type: emailData.notification_type,
        button_text: emailData.button_text,
        button_url: emailData.button_url
      };
      this.onEmailTypeChange();
    },
    onEmailTypeChange: function onEmailTypeChange() {
      var _this = this;
      axios.get('/admin/event/get-variables?event_id=' + this.email.event_id + "&for_admin=false").then(function (res) {
        var _res$data;
        _this.dynamicStrings = (_res$data = res.data) !== null && _res$data !== void 0 ? _res$data : [];
      })["catch"](function (err) {
        new Noty({
          type: "error",
          text: 'Something went wrong!'
        }).show();
      });
    },
    saveData: function saveData(actionType) {
      var _this$email$id,
        _this2 = this;
      this.validationErrors = {};
      var params = {
        id: (_this$email$id = this.email.id) !== null && _this$email$id !== void 0 ? _this$email$id : '',
        event_id: this.email.event_id,
        name: this.email.name,
        subject: this.email.subject,
        email_body: this.email.email_body,
        show_button: this.email.show_button,
        notification_type: this.email.notification_type,
        button_text: this.email.button_text,
        button_url: this.email.button_url
      };
      params._save_action = actionType;
      console.log('saveData:', this.axios_url);
      axios[this.method]("".concat(this.axios_url), params).then(function (response) {
        _this2.validationErrors = "";
        switch (actionType) {
          case 'save_and_back':
            console.log('save_and_back');
            window.location = '/admin/event-template';
            break;
          case 'save_and_edit':
            console.log('save_and_edit');
            window.location = '/admin/event-template/' + params.id + '/edit';
            break;
          case 'save_and_new':
            console.log('save_and_new');
            window.location = '/admin/event-template/create';
            break;
          case 'save_and_preview':
            console.log('save_and_preview');
            window.location = '/admin/event-template/' + params.id + '/show';
            break;
        }
      })["catch"](function (err) {
        _this2.validationErrors = err.response.data.errors;
        new Noty({
          type: "error",
          text: err.response.data.message
        }).show();
        console.error(err);
      })["finally"](function () {});
    },
    removeError: function removeError(key) {
      var errorsObject = this.validationErrors;
      var errorExist = errorsObject[key];
      if (errorExist) {
        delete errorsObject[key];
      }
      if (Object.keys(errorsObject).length <= 0) {
        this.validationErrors = "";
      }
      this.validationErrors = errorsObject;
    },
    copyToClipboard: function copyToClipboard(text) {
      navigator.clipboard.writeText(text);
      new Noty({
        type: "success",
        text: 'Copied to clipboard successfully!'
      }).show();
    }
  },
  watch: {
    'email.show_button': function emailShow_button(newValue, oldValue) {
      if (newValue === 0 || newValue === false) {
        this.email.button_text = null;
        this.email.button_url = null;
      }
    }
  }
});

/***/ }),

/***/ "../../node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!../../node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/pages/settings/SettingEmail.vue?vue&type=template&id=454bb53b&scoped=true":
/*!*****************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ../../node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!../../node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/pages/settings/SettingEmail.vue?vue&type=template&id=454bb53b&scoped=true ***!
  \*****************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   render: () => (/* binding */ render),
/* harmony export */   staticRenderFns: () => (/* binding */ staticRenderFns)
/* harmony export */ });
var render = function render() {
  var _vm = this,
    _c = _vm._self._c;
  return _c('div', {
    staticClass: "animated fadeIn",
    attrs: {
      "id": "settingEmailCreate"
    }
  }, [_c('div', {
    staticClass: "row"
  }, [_c('div', {
    staticClass: "col-md-8 bold-labels"
  }, [_c('form', {
    attrs: {
      "method": "post",
      "action": _vm.backUrl
    }
  }, [_c('div', {
    staticClass: "card"
  }, [_c('div', {
    staticClass: "card-body"
  }, [_c('div', {
    staticClass: "form-group"
  }, [_vm._m(0), _vm._v(" "), _c('select', {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.email.event_id,
      expression: "email.event_id"
    }],
    staticClass: "form-control",
    "class": {
      'is-invalid': _vm.validationErrors.event_id
    },
    attrs: {
      "name": "event_id"
    },
    on: {
      "change": [function ($event) {
        var $$selectedVal = Array.prototype.filter.call($event.target.options, function (o) {
          return o.selected;
        }).map(function (o) {
          var val = "_value" in o ? o._value : o.value;
          return val;
        });
        _vm.$set(_vm.email, "event_id", $event.target.multiple ? $$selectedVal : $$selectedVal[0]);
      }, function ($event) {
        _vm.onEmailTypeChange();
        _vm.removeError('event_id');
      }]
    }
  }, _vm._l(_vm.allEvents, function (emailType) {
    return _c('option', {
      domProps: {
        "value": emailType.id
      }
    }, [_vm._v("\n                                    " + _vm._s(emailType.name) + "\n                                ")]);
  }), 0), _vm._v(" "), _vm.validationErrors.event_id ? _c('small', {
    staticClass: "text-danger mt-3"
  }, [_vm._v(_vm._s(_vm.validationErrors.event_id[0]))]) : _vm._e()]), _vm._v(" "), _c('div', {
    staticClass: "form-group"
  }, [_vm._m(1), _vm._v(" "), _c('input', {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.email.name,
      expression: "email.name"
    }],
    staticClass: "form-control",
    "class": {
      'is-invalid': _vm.validationErrors.name
    },
    attrs: {
      "type": "text",
      "name": "name"
    },
    domProps: {
      "value": _vm.email.name
    },
    on: {
      "input": [function ($event) {
        if ($event.target.composing) return;
        _vm.$set(_vm.email, "name", $event.target.value);
      }, function ($event) {
        return _vm.removeError('name');
      }]
    }
  }), _vm._v(" "), _vm.validationErrors.name ? _c('small', {
    staticClass: "text-danger mt-3"
  }, [_vm._v(_vm._s(_vm.validationErrors.name[0]))]) : _vm._e()]), _vm._v(" "), _c('div', {
    staticClass: "form-group",
    "class": {
      'text-danger': _vm.validationErrors.notification_type
    }
  }, [_vm._m(2), _vm._v(" "), _c('select', {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.email.notification_type,
      expression: "email.notification_type"
    }],
    staticClass: "form-control",
    "class": {
      'is-invalid': _vm.validationErrors.notification_type
    },
    attrs: {
      "name": "notification_type"
    },
    on: {
      "change": [function ($event) {
        var $$selectedVal = Array.prototype.filter.call($event.target.options, function (o) {
          return o.selected;
        }).map(function (o) {
          var val = "_value" in o ? o._value : o.value;
          return val;
        });
        _vm.$set(_vm.email, "notification_type", $event.target.multiple ? $$selectedVal : $$selectedVal[0]);
      }, function ($event) {
        _vm.email.email_body = '';
        _vm.removeError('notification_type');
      }]
    }
  }, [_c('option', {
    attrs: {
      "value": "emailable"
    }
  }, [_vm._v("Email")]), _vm._v(" "), _c('option', {
    attrs: {
      "value": "messageable"
    }
  }, [_vm._v("Message")])]), _vm._v(" "), _vm.validationErrors.notification_type ? _c('small', {
    staticClass: "text-danger mt-3"
  }, [_vm._v(_vm._s(_vm.validationErrors.notification_type[0]))]) : _vm._e()]), _vm._v(" "), _vm.email.notification_type === 'emailable' ? _c('div', {
    staticClass: "form-group"
  }, [_c('label', [_vm._v("\n                                Subject\n                                "), _vm.email.notification_type === 'emailable' ? _c('span', {
    staticClass: "text-danger"
  }, [_vm._v("*")]) : _vm._e()]), _vm._v(" "), _c('input', {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.email.subject,
      expression: "email.subject"
    }],
    "class": {
      'is-invalid': _vm.validationErrors.subject,
      'form-control': true
    },
    attrs: {
      "type": "text",
      "name": "subject",
      "required": _vm.email.notification_type === 'emailable'
    },
    domProps: {
      "value": _vm.email.subject
    },
    on: {
      "input": [function ($event) {
        if ($event.target.composing) return;
        _vm.$set(_vm.email, "subject", $event.target.value);
      }, function ($event) {
        return _vm.removeError('subject');
      }]
    }
  }), _vm._v(" "), _vm.validationErrors.subject ? _c('small', {
    staticClass: "text-danger mt-3"
  }, [_vm._v(_vm._s(_vm.validationErrors.subject[0]))]) : _vm._e()]) : _vm._e(), _vm._v(" "), _c('div', {
    staticClass: "form-group"
  }, [_vm._m(3), _vm._v(" "), _vm._m(4), _vm._v(" "), _vm.email.notification_type == 'emailable' ? _c('ckeditor', {
    "class": {
      'is-invalid': _vm.validationErrors.email_body
    },
    on: {
      "input": function input($event) {
        return _vm.removeError('email_body');
      }
    },
    model: {
      value: _vm.email.email_body,
      callback: function callback($$v) {
        _vm.$set(_vm.email, "email_body", $$v);
      },
      expression: "email.email_body"
    }
  }) : _vm._e(), _vm._v(" "), _vm.email.notification_type == 'messageable' ? _c('textarea', {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.email.email_body,
      expression: "email.email_body"
    }],
    staticClass: "form-control",
    "class": {
      'is-invalid': _vm.validationErrors.email_body
    },
    domProps: {
      "value": _vm.email.email_body
    },
    on: {
      "input": [function ($event) {
        if ($event.target.composing) return;
        _vm.$set(_vm.email, "email_body", $event.target.value);
      }, function ($event) {
        return _vm.removeError('email_body');
      }]
    }
  }) : _vm._e(), _vm._v(" "), _vm.validationErrors.email_body ? _c('small', {
    staticClass: "text-danger mt-3"
  }, [_vm._v(_vm._s(_vm.validationErrors.email_body[0]))]) : _vm._e()], 1), _vm._v(" "), _c('div', {
    directives: [{
      name: "show",
      rawName: "v-show",
      value: _vm.email.notification_type == 'emailable',
      expression: "email.notification_type == 'emailable'"
    }]
  }, [_c('div', {
    staticClass: "form-group"
  }, [_c('div', {
    staticClass: "checkbox my-0 my-lg-2"
  }, [_c('input', {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.email.show_button,
      expression: "email.show_button"
    }],
    attrs: {
      "id": "show_button",
      "type": "checkbox"
    },
    domProps: {
      "checked": Array.isArray(_vm.email.show_button) ? _vm._i(_vm.email.show_button, null) > -1 : _vm.email.show_button
    },
    on: {
      "change": function change($event) {
        var $$a = _vm.email.show_button,
          $$el = $event.target,
          $$c = $$el.checked ? true : false;
        if (Array.isArray($$a)) {
          var $$v = null,
            $$i = _vm._i($$a, $$v);
          if ($$el.checked) {
            $$i < 0 && _vm.$set(_vm.email, "show_button", $$a.concat([$$v]));
          } else {
            $$i > -1 && _vm.$set(_vm.email, "show_button", $$a.slice(0, $$i).concat($$a.slice($$i + 1)));
          }
        } else {
          _vm.$set(_vm.email, "show_button", $$c);
        }
      }
    }
  }), _vm._v(" "), _c('label', {
    staticClass: "form-check-label font-weight-normal",
    attrs: {
      "for": "show_button"
    }
  }, [_vm._v("\n                                        Show Button\n                                    ")])])]), _vm._v(" "), _c('div', {
    directives: [{
      name: "show",
      rawName: "v-show",
      value: _vm.email.show_button,
      expression: "email.show_button"
    }]
  }, [_c('div', {
    staticClass: "form-group",
    "class": {
      'text-danger': _vm.validationErrors.button_text
    }
  }, [_vm._m(5), _vm._v(" "), _c('input', {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.email.button_text,
      expression: "email.button_text"
    }],
    staticClass: "form-control",
    "class": {
      'is-invalid': _vm.validationErrors.button_text
    },
    attrs: {
      "type": "text",
      "name": "button_text",
      "placeholder": "See Details"
    },
    domProps: {
      "value": _vm.email.button_text
    },
    on: {
      "input": [function ($event) {
        if ($event.target.composing) return;
        _vm.$set(_vm.email, "button_text", $event.target.value);
      }, function ($event) {
        return _vm.removeError('button_text');
      }]
    }
  }), _vm._v(" "), _vm.validationErrors.button_text ? _c('small', {
    staticClass: "text-danger mt-3"
  }, [_vm._v(_vm._s(_vm.validationErrors.button_text[0]))]) : _vm._e()]), _vm._v(" "), _c('div', {
    staticClass: "form-group",
    "class": {
      'text-danger': _vm.validationErrors.button_url
    }
  }, [_vm._m(6), _vm._v(" "), _c('div', {
    staticClass: "input-group mb-2"
  }, [_c('div', {
    staticClass: "input-group-prepend"
  }, [_c('div', {
    staticClass: "input-group-text"
  }, [_vm._v(_vm._s(_vm.host))])]), _vm._v(" "), _c('input', {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.email.button_url,
      expression: "email.button_url"
    }],
    staticClass: "form-control",
    "class": {
      'is-invalid': _vm.validationErrors.button_url
    },
    attrs: {
      "type": "text",
      "name": "button_url",
      "placeholder": "/admin/customer"
    },
    domProps: {
      "value": _vm.email.button_url
    },
    on: {
      "input": [function ($event) {
        if ($event.target.composing) return;
        _vm.$set(_vm.email, "button_url", $event.target.value);
      }, function ($event) {
        return _vm.removeError('button_url');
      }]
    }
  })]), _vm._v(" "), _vm.validationErrors.button_url ? _c('small', {
    staticClass: "text-danger mt-3"
  }, [_vm._v(_vm._s(_vm.validationErrors.button_url[0]))]) : _vm._e()])])])])]), _vm._v(" "), _c('div', {
    staticClass: "form-group",
    attrs: {
      "id": "saveActions"
    }
  }, [_c('input', {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.actionType,
      expression: "actionType"
    }],
    attrs: {
      "type": "hidden",
      "name": "save_action",
      "value": "save_and_back"
    },
    domProps: {
      "value": _vm.actionType
    },
    on: {
      "input": function input($event) {
        if ($event.target.composing) return;
        _vm.actionType = $event.target.value;
      }
    }
  }), _vm._v(" "), _c('div', {
    staticClass: "btn-group",
    attrs: {
      "role": "group"
    }
  }, [_c('button', {
    staticClass: "btn btn-success",
    attrs: {
      "type": "button"
    },
    on: {
      "click": function click($event) {
        return _vm.saveData(_vm.saveAction.active.value);
      }
    }
  }, [_c('span', {
    staticClass: "la la-save",
    attrs: {
      "role": "presentation",
      "aria-hidden": "true"
    }
  }), _vm._v("  \n                            "), _c('span', [_vm._v(_vm._s(_vm.saveAction.active.label))])]), _vm._v(" "), _c('div', {
    staticClass: "btn-group",
    attrs: {
      "role": "group"
    }
  }, [_vm._m(7), _vm._v(" "), _c('div', {
    staticClass: "dropdown-menu",
    attrs: {
      "aria-labelledby": "bpSaveButtonsGroup"
    }
  }, [_vm._l(_vm.saveAction.options, function (option, k, index) {
    return [_c('button', {
      key: 'actionType-' + index,
      staticClass: "dropdown-item",
      attrs: {
        "type": "button"
      },
      on: {
        "click": function click($event) {
          return _vm.saveData(k);
        }
      }
    }, [_vm._v("\n                                        " + _vm._s(option) + "\n                                    ")])];
  })], 2)])]), _vm._v(" "), _c('a', {
    staticClass: "btn btn-default",
    attrs: {
      "href": _vm.backUrl
    }
  }, [_c('span', {
    staticClass: "la la-ban"
  }), _vm._v("  Cancel")])])])]), _vm._v(" "), _c('div', {
    staticClass: "col-md-4"
  }, [_c('div', {
    staticClass: "card"
  }, [_c('div', {
    staticClass: "card-body overflow-auto"
  }, [_c('h5', {
    staticClass: "card-title text-center border-bottom pb-1"
  }, [_vm._v("Dynamic Strings")]), _vm._v(" "), _c('div', {
    staticClass: "table-responsive"
  }, [_c('table', {
    staticClass: "table table-striped table-hover"
  }, [_vm._m(8), _vm._v(" "), _c('tbody', [_vm.dynamicStrings.length === 0 ? _c('tr', [_c('td', {
    staticClass: "text-center",
    attrs: {
      "colspan": "3"
    }
  }, [_vm._v("\n                                    No dynamic strings found.\n                                ")])]) : _vm._l(_vm.dynamicStrings, function (dynamicString, index) {
    return _c('tr', [_c('th', [_c('button', {
      staticClass: "btn-clipboard btn-primary",
      attrs: {
        "type": "button"
      },
      on: {
        "click": function click($event) {
          return _vm.copyToClipboard(dynamicString.key);
        }
      }
    }, [_vm._v("\n                                        " + _vm._s(_vm.copyButtonText) + "\n                                    ")])]), _vm._v(" "), _c('th', {
      attrs: {
        "scope": "row"
      }
    }, [_vm._v(_vm._s(dynamicString.key))]), _vm._v(" "), _c('th', [_vm._v(_vm._s(dynamicString.value))])]);
  })], 2)])])])])])])]);
};
var staticRenderFns = [function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c('label', [_vm._v("Trigger "), _c('span', {
    staticClass: "text-danger"
  }, [_vm._v("*")])]);
}, function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c('label', [_vm._v("\n                                Name\n                                "), _c('span', {
    staticClass: "text-danger"
  }, [_vm._v("*")])]);
}, function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c('label', [_vm._v("Send Via"), _c('span', {
    staticClass: "text-danger"
  }, [_vm._v("*")])]);
}, function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c('label', [_vm._v("\n                                Content\n                                "), _c('span', {
    staticClass: "text-danger"
  }, [_vm._v("*")])]);
}, function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c('p', [_c('code', [_vm._v("__company_name__")]), _vm._v(" , "), _c('code', [_vm._v("__timestamp__")]), _vm._v(" is globally available on all templates.")]);
}, function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c('label', [_vm._v("\n                                        Button Text\n                                        "), _c('span', {
    staticClass: "text-danger"
  }, [_vm._v("*")])]);
}, function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c('label', [_vm._v("\n                                        Button URL\n                                        "), _c('span', {
    staticClass: "text-danger"
  }, [_vm._v("*")])]);
}, function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c('button', {
    staticClass: "btn btn-success dropdown-toggle",
    attrs: {
      "id": "bpSaveButtonsGroup",
      "type": "button",
      "data-toggle": "dropdown",
      "aria-haspopup": "true",
      "aria-expanded": "false"
    }
  }, [_c('span', {
    staticClass: "caret"
  }), _c('span', {
    staticClass: "sr-only"
  }, [_vm._v("▼")])]);
}, function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c('thead', [_c('tr', [_c('th', {
    attrs: {
      "colspan": "2"
    }
  }, [_vm._v("String")]), _vm._v(" "), _c('th', [_vm._v("Value")])])]);
}];
render._withStripped = true;


/***/ }),

/***/ "../../node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!../../node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/pages/settings/SettingEmail.vue?vue&type=style&index=0&id=454bb53b&scoped=true&lang=css":
/*!******************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ../../node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!../../node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/pages/settings/SettingEmail.vue?vue&type=style&index=0&id=454bb53b&scoped=true&lang=css ***!
  \******************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
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
___CSS_LOADER_EXPORT___.push([module.id, "\n.btn-clipboard[data-v-454bb53b] {\n    display: block;\n    padding: .25rem .5rem;\n    font-size: 75%;\n    color: #ffffff;\n    border: 0;\n    border-radius: .25rem;\n}\n.btn-clipboard[data-v-454bb53b]:hover {\n    color: #fff;\n    background-color: #ffa000;\n}\n", ""]);
// Exports
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (___CSS_LOADER_EXPORT___);


/***/ }),

/***/ "../../node_modules/style-loader/dist/cjs.js!../../node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!../../node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/pages/settings/SettingEmail.vue?vue&type=style&index=0&id=454bb53b&scoped=true&lang=css":
/*!**************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ../../node_modules/style-loader/dist/cjs.js!../../node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!../../node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/pages/settings/SettingEmail.vue?vue&type=style&index=0&id=454bb53b&scoped=true&lang=css ***!
  \**************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! !../../../../../../../node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js */ "../../node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js");
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _node_modules_laravel_mix_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_SettingEmail_vue_vue_type_style_index_0_id_454bb53b_scoped_true_lang_css__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! !!../../../../../../../node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!../../../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!../../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./SettingEmail.vue?vue&type=style&index=0&id=454bb53b&scoped=true&lang=css */ "../../node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!../../node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/pages/settings/SettingEmail.vue?vue&type=style&index=0&id=454bb53b&scoped=true&lang=css");

            

var options = {};

options.insert = "head";
options.singleton = false;

var update = _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default()(_node_modules_laravel_mix_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_SettingEmail_vue_vue_type_style_index_0_id_454bb53b_scoped_true_lang_css__WEBPACK_IMPORTED_MODULE_1__["default"], options);



/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_laravel_mix_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_SettingEmail_vue_vue_type_style_index_0_id_454bb53b_scoped_true_lang_css__WEBPACK_IMPORTED_MODULE_1__["default"].locals || {});

/***/ }),

/***/ "./resources/vue/views/pages/settings/SettingEmail.vue":
/*!*************************************************************!*\
  !*** ./resources/vue/views/pages/settings/SettingEmail.vue ***!
  \*************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _SettingEmail_vue_vue_type_template_id_454bb53b_scoped_true__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./SettingEmail.vue?vue&type=template&id=454bb53b&scoped=true */ "./resources/vue/views/pages/settings/SettingEmail.vue?vue&type=template&id=454bb53b&scoped=true");
/* harmony import */ var _SettingEmail_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./SettingEmail.vue?vue&type=script&lang=js */ "./resources/vue/views/pages/settings/SettingEmail.vue?vue&type=script&lang=js");
/* harmony import */ var _SettingEmail_vue_vue_type_style_index_0_id_454bb53b_scoped_true_lang_css__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./SettingEmail.vue?vue&type=style&index=0&id=454bb53b&scoped=true&lang=css */ "./resources/vue/views/pages/settings/SettingEmail.vue?vue&type=style&index=0&id=454bb53b&scoped=true&lang=css");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! !../../../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "../../node_modules/vue-loader/lib/runtime/componentNormalizer.js");



;


/* normalize component */

var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__["default"])(
  _SettingEmail_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"],
  _SettingEmail_vue_vue_type_template_id_454bb53b_scoped_true__WEBPACK_IMPORTED_MODULE_0__.render,
  _SettingEmail_vue_vue_type_template_id_454bb53b_scoped_true__WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  "454bb53b",
  null
  
)

/* hot reload */
if (false) // removed by dead control flow
{ var api; }
component.options.__file = "resources/vue/views/pages/settings/SettingEmail.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/vue/views/pages/settings/SettingEmail.vue?vue&type=script&lang=js":
/*!*************************************************************************************!*\
  !*** ./resources/vue/views/pages/settings/SettingEmail.vue?vue&type=script&lang=js ***!
  \*************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_laravel_mix_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_SettingEmail_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../../node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./SettingEmail.vue?vue&type=script&lang=js */ "../../node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/pages/settings/SettingEmail.vue?vue&type=script&lang=js");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_laravel_mix_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_SettingEmail_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/vue/views/pages/settings/SettingEmail.vue?vue&type=style&index=0&id=454bb53b&scoped=true&lang=css":
/*!*********************************************************************************************************************!*\
  !*** ./resources/vue/views/pages/settings/SettingEmail.vue?vue&type=style&index=0&id=454bb53b&scoped=true&lang=css ***!
  \*********************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_dist_cjs_js_node_modules_laravel_mix_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_SettingEmail_vue_vue_type_style_index_0_id_454bb53b_scoped_true_lang_css__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../../node_modules/style-loader/dist/cjs.js!../../../../../../../node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!../../../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!../../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./SettingEmail.vue?vue&type=style&index=0&id=454bb53b&scoped=true&lang=css */ "../../node_modules/style-loader/dist/cjs.js!../../node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!../../node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/pages/settings/SettingEmail.vue?vue&type=style&index=0&id=454bb53b&scoped=true&lang=css");


/***/ }),

/***/ "./resources/vue/views/pages/settings/SettingEmail.vue?vue&type=template&id=454bb53b&scoped=true":
/*!*******************************************************************************************************!*\
  !*** ./resources/vue/views/pages/settings/SettingEmail.vue?vue&type=template&id=454bb53b&scoped=true ***!
  \*******************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   render: () => (/* reexport safe */ _node_modules_laravel_mix_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_SettingEmail_vue_vue_type_template_id_454bb53b_scoped_true__WEBPACK_IMPORTED_MODULE_0__.render),
/* harmony export */   staticRenderFns: () => (/* reexport safe */ _node_modules_laravel_mix_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_SettingEmail_vue_vue_type_template_id_454bb53b_scoped_true__WEBPACK_IMPORTED_MODULE_0__.staticRenderFns)
/* harmony export */ });
/* harmony import */ var _node_modules_laravel_mix_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_SettingEmail_vue_vue_type_template_id_454bb53b_scoped_true__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../../node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!../../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./SettingEmail.vue?vue&type=template&id=454bb53b&scoped=true */ "../../node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!../../node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/pages/settings/SettingEmail.vue?vue&type=template&id=454bb53b&scoped=true");


/***/ })

}]);