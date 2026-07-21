(self["webpackChunkbackend"] = self["webpackChunkbackend"] || []).push([["resources_vue_views_pages_pages_Create_vue"],{

/***/ "./node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/pages/pages/Create.vue?vue&type=script&lang=js":
/*!*********************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/pages/pages/Create.vue?vue&type=script&lang=js ***!
  \*********************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _allDisks_mixin__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../../allDisks.mixin */ "./resources/vue/allDisks.mixin.js");
/* harmony import */ var lodash__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! lodash */ "./node_modules/lodash/lodash.js");
/* harmony import */ var lodash__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(lodash__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _FormFields__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./FormFields */ "./resources/vue/views/pages/pages/FormFields.vue");
/* harmony import */ var prismjs_components_prism_core__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! prismjs/components/prism-core */ "./node_modules/prismjs/components/prism-core.js");
/* harmony import */ var prismjs_components_prism_core__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(prismjs_components_prism_core__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var prismjs_components_prism_clike__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! prismjs/components/prism-clike */ "./node_modules/prismjs/components/prism-clike.js");
/* harmony import */ var prismjs_components_prism_clike__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(prismjs_components_prism_clike__WEBPACK_IMPORTED_MODULE_4__);
/* harmony import */ var prismjs_components_prism_javascript__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! prismjs/components/prism-javascript */ "./node_modules/prismjs/components/prism-javascript.js");
/* harmony import */ var prismjs_components_prism_javascript__WEBPACK_IMPORTED_MODULE_5___default = /*#__PURE__*/__webpack_require__.n(prismjs_components_prism_javascript__WEBPACK_IMPORTED_MODULE_5__);
/* harmony import */ var prismjs_themes_prism_tomorrow_css__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! prismjs/themes/prism-tomorrow.css */ "./node_modules/prismjs/themes/prism-tomorrow.css");
/* harmony import */ var vue_prism_editor__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! vue-prism-editor */ "./node_modules/vue-prism-editor/dist/prismeditor.esm.js");
/* harmony import */ var _WidgetAttributesModal__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! ./WidgetAttributesModal */ "./resources/vue/views/pages/pages/WidgetAttributesModal.vue");
function _typeof(o) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (o) { return typeof o; } : function (o) { return o && "function" == typeof Symbol && o.constructor === Symbol && o !== Symbol.prototype ? "symbol" : typeof o; }, _typeof(o); }
function _createForOfIteratorHelper(r, e) { var t = "undefined" != typeof Symbol && r[Symbol.iterator] || r["@@iterator"]; if (!t) { if (Array.isArray(r) || (t = _unsupportedIterableToArray(r)) || e && r && "number" == typeof r.length) { t && (r = t); var _n = 0, F = function F() {}; return { s: F, n: function n() { return _n >= r.length ? { done: !0 } : { done: !1, value: r[_n++] }; }, e: function e(r) { throw r; }, f: F }; } throw new TypeError("Invalid attempt to iterate non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); } var o, a = !0, u = !1; return { s: function s() { t = t.call(r); }, n: function n() { var r = t.next(); return a = r.done, r; }, e: function e(r) { u = !0, o = r; }, f: function f() { try { a || null == t["return"] || t["return"](); } finally { if (u) throw o; } } }; }
function _unsupportedIterableToArray(r, a) { if (r) { if ("string" == typeof r) return _arrayLikeToArray(r, a); var t = {}.toString.call(r).slice(8, -1); return "Object" === t && r.constructor && (t = r.constructor.name), "Map" === t || "Set" === t ? Array.from(r) : "Arguments" === t || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(t) ? _arrayLikeToArray(r, a) : void 0; } }
function _arrayLikeToArray(r, a) { (null == a || a > r.length) && (a = r.length); for (var e = 0, n = Array(a); e < a; e++) n[e] = r[e]; return n; }
function _regeneratorRuntime() { "use strict"; /*! regenerator-runtime -- Copyright (c) 2014-present, Facebook, Inc. -- license (MIT): https://github.com/facebook/regenerator/blob/main/LICENSE */ _regeneratorRuntime = function _regeneratorRuntime() { return e; }; var t, e = {}, r = Object.prototype, n = r.hasOwnProperty, o = Object.defineProperty || function (t, e, r) { t[e] = r.value; }, i = "function" == typeof Symbol ? Symbol : {}, a = i.iterator || "@@iterator", c = i.asyncIterator || "@@asyncIterator", u = i.toStringTag || "@@toStringTag"; function define(t, e, r) { return Object.defineProperty(t, e, { value: r, enumerable: !0, configurable: !0, writable: !0 }), t[e]; } try { define({}, ""); } catch (t) { define = function define(t, e, r) { return t[e] = r; }; } function wrap(t, e, r, n) { var i = e && e.prototype instanceof Generator ? e : Generator, a = Object.create(i.prototype), c = new Context(n || []); return o(a, "_invoke", { value: makeInvokeMethod(t, r, c) }), a; } function tryCatch(t, e, r) { try { return { type: "normal", arg: t.call(e, r) }; } catch (t) { return { type: "throw", arg: t }; } } e.wrap = wrap; var h = "suspendedStart", l = "suspendedYield", f = "executing", s = "completed", y = {}; function Generator() {} function GeneratorFunction() {} function GeneratorFunctionPrototype() {} var p = {}; define(p, a, function () { return this; }); var d = Object.getPrototypeOf, v = d && d(d(values([]))); v && v !== r && n.call(v, a) && (p = v); var g = GeneratorFunctionPrototype.prototype = Generator.prototype = Object.create(p); function defineIteratorMethods(t) { ["next", "throw", "return"].forEach(function (e) { define(t, e, function (t) { return this._invoke(e, t); }); }); } function AsyncIterator(t, e) { function invoke(r, o, i, a) { var c = tryCatch(t[r], t, o); if ("throw" !== c.type) { var u = c.arg, h = u.value; return h && "object" == _typeof(h) && n.call(h, "__await") ? e.resolve(h.__await).then(function (t) { invoke("next", t, i, a); }, function (t) { invoke("throw", t, i, a); }) : e.resolve(h).then(function (t) { u.value = t, i(u); }, function (t) { return invoke("throw", t, i, a); }); } a(c.arg); } var r; o(this, "_invoke", { value: function value(t, n) { function callInvokeWithMethodAndArg() { return new e(function (e, r) { invoke(t, n, e, r); }); } return r = r ? r.then(callInvokeWithMethodAndArg, callInvokeWithMethodAndArg) : callInvokeWithMethodAndArg(); } }); } function makeInvokeMethod(e, r, n) { var o = h; return function (i, a) { if (o === f) throw Error("Generator is already running"); if (o === s) { if ("throw" === i) throw a; return { value: t, done: !0 }; } for (n.method = i, n.arg = a;;) { var c = n.delegate; if (c) { var u = maybeInvokeDelegate(c, n); if (u) { if (u === y) continue; return u; } } if ("next" === n.method) n.sent = n._sent = n.arg;else if ("throw" === n.method) { if (o === h) throw o = s, n.arg; n.dispatchException(n.arg); } else "return" === n.method && n.abrupt("return", n.arg); o = f; var p = tryCatch(e, r, n); if ("normal" === p.type) { if (o = n.done ? s : l, p.arg === y) continue; return { value: p.arg, done: n.done }; } "throw" === p.type && (o = s, n.method = "throw", n.arg = p.arg); } }; } function maybeInvokeDelegate(e, r) { var n = r.method, o = e.iterator[n]; if (o === t) return r.delegate = null, "throw" === n && e.iterator["return"] && (r.method = "return", r.arg = t, maybeInvokeDelegate(e, r), "throw" === r.method) || "return" !== n && (r.method = "throw", r.arg = new TypeError("The iterator does not provide a '" + n + "' method")), y; var i = tryCatch(o, e.iterator, r.arg); if ("throw" === i.type) return r.method = "throw", r.arg = i.arg, r.delegate = null, y; var a = i.arg; return a ? a.done ? (r[e.resultName] = a.value, r.next = e.nextLoc, "return" !== r.method && (r.method = "next", r.arg = t), r.delegate = null, y) : a : (r.method = "throw", r.arg = new TypeError("iterator result is not an object"), r.delegate = null, y); } function pushTryEntry(t) { var e = { tryLoc: t[0] }; 1 in t && (e.catchLoc = t[1]), 2 in t && (e.finallyLoc = t[2], e.afterLoc = t[3]), this.tryEntries.push(e); } function resetTryEntry(t) { var e = t.completion || {}; e.type = "normal", delete e.arg, t.completion = e; } function Context(t) { this.tryEntries = [{ tryLoc: "root" }], t.forEach(pushTryEntry, this), this.reset(!0); } function values(e) { if (e || "" === e) { var r = e[a]; if (r) return r.call(e); if ("function" == typeof e.next) return e; if (!isNaN(e.length)) { var o = -1, i = function next() { for (; ++o < e.length;) if (n.call(e, o)) return next.value = e[o], next.done = !1, next; return next.value = t, next.done = !0, next; }; return i.next = i; } } throw new TypeError(_typeof(e) + " is not iterable"); } return GeneratorFunction.prototype = GeneratorFunctionPrototype, o(g, "constructor", { value: GeneratorFunctionPrototype, configurable: !0 }), o(GeneratorFunctionPrototype, "constructor", { value: GeneratorFunction, configurable: !0 }), GeneratorFunction.displayName = define(GeneratorFunctionPrototype, u, "GeneratorFunction"), e.isGeneratorFunction = function (t) { var e = "function" == typeof t && t.constructor; return !!e && (e === GeneratorFunction || "GeneratorFunction" === (e.displayName || e.name)); }, e.mark = function (t) { return Object.setPrototypeOf ? Object.setPrototypeOf(t, GeneratorFunctionPrototype) : (t.__proto__ = GeneratorFunctionPrototype, define(t, u, "GeneratorFunction")), t.prototype = Object.create(g), t; }, e.awrap = function (t) { return { __await: t }; }, defineIteratorMethods(AsyncIterator.prototype), define(AsyncIterator.prototype, c, function () { return this; }), e.AsyncIterator = AsyncIterator, e.async = function (t, r, n, o, i) { void 0 === i && (i = Promise); var a = new AsyncIterator(wrap(t, r, n, o), i); return e.isGeneratorFunction(r) ? a : a.next().then(function (t) { return t.done ? t.value : a.next(); }); }, defineIteratorMethods(g), define(g, u, "Generator"), define(g, a, function () { return this; }), define(g, "toString", function () { return "[object Generator]"; }), e.keys = function (t) { var e = Object(t), r = []; for (var n in e) r.push(n); return r.reverse(), function next() { for (; r.length;) { var t = r.pop(); if (t in e) return next.value = t, next.done = !1, next; } return next.done = !0, next; }; }, e.values = values, Context.prototype = { constructor: Context, reset: function reset(e) { if (this.prev = 0, this.next = 0, this.sent = this._sent = t, this.done = !1, this.delegate = null, this.method = "next", this.arg = t, this.tryEntries.forEach(resetTryEntry), !e) for (var r in this) "t" === r.charAt(0) && n.call(this, r) && !isNaN(+r.slice(1)) && (this[r] = t); }, stop: function stop() { this.done = !0; var t = this.tryEntries[0].completion; if ("throw" === t.type) throw t.arg; return this.rval; }, dispatchException: function dispatchException(e) { if (this.done) throw e; var r = this; function handle(n, o) { return a.type = "throw", a.arg = e, r.next = n, o && (r.method = "next", r.arg = t), !!o; } for (var o = this.tryEntries.length - 1; o >= 0; --o) { var i = this.tryEntries[o], a = i.completion; if ("root" === i.tryLoc) return handle("end"); if (i.tryLoc <= this.prev) { var c = n.call(i, "catchLoc"), u = n.call(i, "finallyLoc"); if (c && u) { if (this.prev < i.catchLoc) return handle(i.catchLoc, !0); if (this.prev < i.finallyLoc) return handle(i.finallyLoc); } else if (c) { if (this.prev < i.catchLoc) return handle(i.catchLoc, !0); } else { if (!u) throw Error("try statement without catch or finally"); if (this.prev < i.finallyLoc) return handle(i.finallyLoc); } } } }, abrupt: function abrupt(t, e) { for (var r = this.tryEntries.length - 1; r >= 0; --r) { var o = this.tryEntries[r]; if (o.tryLoc <= this.prev && n.call(o, "finallyLoc") && this.prev < o.finallyLoc) { var i = o; break; } } i && ("break" === t || "continue" === t) && i.tryLoc <= e && e <= i.finallyLoc && (i = null); var a = i ? i.completion : {}; return a.type = t, a.arg = e, i ? (this.method = "next", this.next = i.finallyLoc, y) : this.complete(a); }, complete: function complete(t, e) { if ("throw" === t.type) throw t.arg; return "break" === t.type || "continue" === t.type ? this.next = t.arg : "return" === t.type ? (this.rval = this.arg = t.arg, this.method = "return", this.next = "end") : "normal" === t.type && e && (this.next = e), y; }, finish: function finish(t) { for (var e = this.tryEntries.length - 1; e >= 0; --e) { var r = this.tryEntries[e]; if (r.finallyLoc === t) return this.complete(r.completion, r.afterLoc), resetTryEntry(r), y; } }, "catch": function _catch(t) { for (var e = this.tryEntries.length - 1; e >= 0; --e) { var r = this.tryEntries[e]; if (r.tryLoc === t) { var n = r.completion; if ("throw" === n.type) { var o = n.arg; resetTryEntry(r); } return o; } } throw Error("illegal catch attempt"); }, delegateYield: function delegateYield(e, r, n) { return this.delegate = { iterator: values(e), resultName: r, nextLoc: n }, "next" === this.method && (this.arg = t), y; } }, e; }
function asyncGeneratorStep(n, t, e, r, o, a, c) { try { var i = n[a](c), u = i.value; } catch (n) { return void e(n); } i.done ? t(u) : Promise.resolve(u).then(r, o); }
function _asyncToGenerator(n) { return function () { var t = this, e = arguments; return new Promise(function (r, o) { var a = n.apply(t, e); function _next(n) { asyncGeneratorStep(a, r, o, _next, _throw, "next", n); } function _throw(n) { asyncGeneratorStep(a, r, o, _next, _throw, "throw", n); } _next(void 0); }); }; }









/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  name: "PageCreate",
  mixins: [_allDisks_mixin__WEBPACK_IMPORTED_MODULE_0__["default"]],
  components: {
    FormFields: _FormFields__WEBPACK_IMPORTED_MODULE_2__["default"],
    PrismEditor: vue_prism_editor__WEBPACK_IMPORTED_MODULE_7__.PrismEditor,
    WidgetAttributesModal: _WidgetAttributesModal__WEBPACK_IMPORTED_MODULE_8__["default"]
  },
  props: ['class_name', 'url', 'method', 'axios_url', 'local_page', 'save_action', 'query_string', 'active_template', 'active_widgets', 'page_types_array', 'middleware_list', 'use_right_sidebar'],
  data: function data() {
    return {
      page: {
        name: '',
        slug: '',
        breadcrumb_title: '',
        paramModel: '',
        modelFindColumn: '',
        meta_description: '',
        meta_key: '',
        meta_image_path: '',
        title: '',
        page_type: this.method !== 'post' ? null : 'static_page',
        content: '',
        middleware: [],
        is_new: this.method !== 'post',
        is_updated: false,
        has_breadcrumb: true,
        has_footer: true,
        has_right_sidebar: true,
        styles: ''
      },
      currentPageType: null,
      selectedFiles: [],
      backUrl: '/admin/page',
      newUrl: '/admin/page/create',
      actionType: 'save_and_back',
      saveAction: JSON.parse(this.save_action),
      validationErrors: {},
      widgetLists: [],
      widgetListBackUp: [],
      showBannerCode: false,
      code: '',
      description: '',
      activeWidgetIndex: undefined,
      copyButtonText: 'copy',
      activeWidget: null,
      activeTemplateId: null,
      pageTypesArray: JSON.parse(this.page_types_array),
      middlewareList: JSON.parse(this.middleware_list),
      sidebarNav: false,
      rightSideBarOptionEnabled: this.use_right_sidebar || false
    };
  },
  mounted: function mounted() {
    var _this = this;
    return _asyncToGenerator(/*#__PURE__*/_regeneratorRuntime().mark(function _callee() {
      return _regeneratorRuntime().wrap(function _callee$(_context) {
        while (1) switch (_context.prev = _context.next) {
          case 0:
            _context.next = 2;
            return _this.getWidgetLists();
          case 2:
            if (_this.method !== 'post') {
              _this.initEdit();
            } else {
              _this.setPageType(_this.page.page_type);
            }
          case 3:
          case "end":
            return _context.stop();
        }
      }, _callee);
    }))();
  },
  methods: {
    toggleSidebar: function toggleSidebar() {
      this.sidebarNav = !this.sidebarNav;
    },
    initEdit: function initEdit() {
      var local_page = this.local_page;
      this.page = {
        name: local_page.name,
        slug: local_page.slug,
        title: local_page.title,
        meta_description: local_page.meta_description,
        meta_image_path: local_page.meta_image_path,
        meta_key: local_page.meta_key,
        page_type: local_page.page_type,
        paramModel: local_page.paramModel,
        modelFindColumn: local_page.modelFindColumn,
        id: local_page.id,
        content: local_page.content,
        is_updated: false,
        has_breadcrumb: local_page.has_breadcrumb,
        breadcrumb_title: local_page.breadcrumb_title,
        has_footer: local_page.has_footer,
        styles: local_page.styles
      };
      this.page.middleware = this.middlewareList.filter(function (middleware) {
        if (local_page.middleware) {
          return local_page.middleware.includes(middleware.guard);
        }
      });
      if (local_page.page_type) {
        this.setPageType(local_page.page_type);
      }
    },
    setPageType: function setPageType(type) {
      var _iterator = _createForOfIteratorHelper(this.pageTypesArray),
        _step;
      try {
        for (_iterator.s(); !(_step = _iterator.n()).done;) {
          var pageType = _step.value;
          if (pageType.code === type) {
            this.currentPageType = pageType;
            return;
          }
        }
      } catch (err) {
        _iterator.e(err);
      } finally {
        _iterator.f();
      }
    },
    onCopy: function onCopy(e) {
      var _this2 = this;
      this.copyButtonText = 'copied';
      setTimeout(function () {
        _this2.copyButtonText = 'copy';
      }, 2000);
      //alert('You just copied: ' + e.text)
    },
    onError: function onError(e) {
      alert('Failed to copy texts');
    },
    highlighter: function highlighter(code) {
      return (0,prismjs_components_prism_core__WEBPACK_IMPORTED_MODULE_3__.highlight)(code, prismjs_components_prism_core__WEBPACK_IMPORTED_MODULE_3__.languages.js); //returns html
    },
    saveAndAction: function saveAndAction(argument) {
      if (argument === 'cancel') {
        window.location = '/admin/page';
      }
    },
    saveData: function saveData(actionType) {
      var _this3 = this;
      this.validationErrors = {};
      this.page._save_action = actionType;
      var params = lodash__WEBPACK_IMPORTED_MODULE_1___default().cloneDeep(this.page);
      params.values = JSON.stringify(this.page.values);
      params.template_id = JSON.parse(this.active_template).id;
      /*params.middleware = params.middleware.map(function (middleware) {
          return middleware.guard;
      });*/

      axios[this.method]("".concat(this.axios_url), params).then(function (response) {
        _this3.validationErrors = "";
        switch (actionType) {
          case 'save_and_back':
            console.log('save_and_back');
            window.location = '/admin/page';
            break;
          case 'save_and_edit':
            console.log('save_and_edit');
            window.location = '/admin/page/' + params.id + '/edit';
            break;
          case 'save_and_new':
            console.log('save_and_new');
            window.location = '/admin/page/create';
            break;
          case 'save_and_preview':
            console.log('save_and_preview');
            window.location = '/admin/page/' + params.id + '/show';
            break;
        }
      })["catch"](function (err) {
        _this3.validationErrors = err.response.data.errors;
        new Noty({
          type: "error",
          text: err.response.data.message
        }).show();
        console.error(err);
      });
    },
    showCode: function showCode(widget) {
      this.description = widget.description;
      this.activeWidget = widget;
    },
    getDataSource: function getDataSource(source) {
      var pages = [];
      var _iterator2 = _createForOfIteratorHelper(source),
        _step2;
      try {
        for (_iterator2.s(); !(_step2 = _iterator2.n()).done;) {
          var sourceElement = _step2.value;
          var _iterator3 = _createForOfIteratorHelper(this.pageTypesArray),
            _step3;
          try {
            for (_iterator3.s(); !(_step3 = _iterator3.n()).done;) {
              var pageTypesArrayElement = _step3.value;
              if (pageTypesArrayElement.code === sourceElement) {
                pages.push(pageTypesArrayElement.label);
                break;
              }
            }
          } catch (err) {
            _iterator3.e(err);
          } finally {
            _iterator3.f();
          }
        }
      } catch (err) {
        _iterator2.e(err);
      } finally {
        _iterator2.f();
      }
      return pages.length > 0 ? '<span class="badge badge-info">Page</span>' + pages.join(", ") : '';
      // if (source === 'easy-ask') {
      //     return 'Data Source: <span class="badge bg-danger">Easy Ask Server</span>';
      // } else if (source !== null && source !== 'easy-ask') {
      //     return 'Data Source: <span class="badge bg-success">Model</span>'
      // } else if (source === null) {
      //     return 'Data Source:  <span class="badge bg-dark">Static</span>'
      // }
    },
    filterWidgetByName: function filterWidgetByName(e) {
      var name = e.target.value;
      if (name.length > 0) {
        this.widgetLists = this.widgetLists.filter(function (widget) {
          return widget.name.search(new RegExp(name.trim(), "i")) >= 0;
        });
      } else {
        this.widgetLists = this.widgetListBackUp;
      }
    },
    getWidgetLists: function getWidgetLists() {
      var _arguments = arguments,
        _this4 = this;
      return _asyncToGenerator(/*#__PURE__*/_regeneratorRuntime().mark(function _callee2() {
        var pageType, widgetLists;
        return _regeneratorRuntime().wrap(function _callee2$(_context2) {
          while (1) switch (_context2.prev = _context2.next) {
            case 0:
              pageType = _arguments.length > 0 && _arguments[0] !== undefined ? _arguments[0] : null;
              _context2.next = 3;
              return axios.get("/admin/page/get-widget");
            case 3:
              widgetLists = _context2.sent;
              widgetLists = Object.values(widgetLists.data);

              // Filtering widgets if page type is selected
              if (pageType !== null) {
                _this4.widgetLists = widgetLists.filter(function (widget) {
                  return true;
                });
              } else {
                _this4.widgetLists = widgetLists;
              }
              // Backing up the widget list
              _this4.widgetListBackUp = _this4.widgetLists;
            case 7:
            case "end":
              return _context2.stop();
          }
        }, _callee2);
      }))();
    },
    changeURLType: function changeURLType(e) {
      var urlType = e.target.value;
      if (urlType === "page") {
        this.$parent.menu.url = "";
        this.page = true;
      } else {
        this.page = false;
      }
    },
    // File Manager methods
    prepareModal: function prepareModal() {
      var _this5 = this;
      setTimeout(function () {
        var modalShade = document.querySelector(".modal-backdrop.fade.show");
        modalShade ? modalShade.remove() : null;
        _this5.modalShade = modalShade.outerHTML;
        _this5.modalBody = document.querySelector("#file-manager-modal .modal-body").innerHTML;
      }, 10);
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
    browseMainImage: function browseMainImage(event) {
      event.preventDefault();
    },
    processImagesByType: function processImagesByType() {
      var indexOfAttributes = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : 0;
      this.indexOfAttributes = indexOfAttributes;
      this.selectedFiles = this.page.meta_image_path;
    },
    getFileAddedMessage: function getFileAddedMessage() {
      var noty = {
        type: "success",
        text: "File path added!"
      };
      new Noty(noty).show();
    },
    deleteImage: function deleteImage() {
      var _this6 = this;
      var indexOfAttributes = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : 0;
      this.$swal({
        title: 'Remove this Image?',
        //icon              : 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ff6b81',
        cancelButtonColor: '#399E7F',
        confirmButtonText: 'Remove'
      }).then(function (result) {
        if (result.isConfirmed) {
          _this6.page.meta_image_path = '';
        }
      });
    },
    getFileExtension: function getFileExtension(file) {
      var regexp = /\.([0-9a-z]+)(?:[\?#]|$)/i;
      var extension = file.match(regexp);
      return extension && extension[1];
    },
    labelWithDescription: function labelWithDescription(option, field) {
      return option.label;
    },
    displayMiddleware: function displayMiddleware(guard) {
      if (guard !== '') {
        var _iterator4 = _createForOfIteratorHelper(this.middlewareList),
          _step4;
        try {
          for (_iterator4.s(); !(_step4 = _iterator4.n()).done;) {
            var middleware = _step4.value;
            if (middleware.guard === guard) {
              return middleware.label + ',';
            }
          }
        } catch (err) {
          _iterator4.e(err);
        } finally {
          _iterator4.f();
        }
        return guard[0].toUpperCase() + guard.slice(1) + ',';
      }
      return guard;
    },
    humanStyleWidgetName: function humanStyleWidgetName(name) {
      var content = name.replaceAll(".", ' ').replace('x-', '').replace('-', ' ');
      return content.split(' ').map(function (word) {
        return word[0].toUpperCase() + word.substr(1);
      }).join(" ");
    }
  },
  watch: {
    "this.page.page_type": function thisPagePage_type(newVal, oldVal) {
      if (newVal !== oldVal) {
        this.getWidgetLists(newVal);
      }
    },
    "$store.state.fm.left.selected.files": {
      handler: function handler(files) {
        if (files.length) {
          var self = this;
          if (self.canMultiple) {
            var filesPath = files.filter(function (file) {
              return ['jpg', 'jpeg', 'png'].includes(self.getFileExtension(file.toLowerCase()));
            });
            if (filesPath) {
              self.selectedFiles = filesPath.map(function (filePath) {
                return self.all_disks[self.$store.state.fm.left.selectedDisk].url ? self.all_disks[self.$store.state.fm.left.selectedDisk].url + "/" + filePath : "/" + filePath;
              });
            }
          } else {
            var filePath = files.find(function (file) {
              return ['jpg', 'jpeg', 'png'].includes(self.getFileExtension(file.toLowerCase()));
            });
            if (filePath) {
              self.selectedFiles = self.all_disks[self.$store.state.fm.left.selectedDisk].url ? self.all_disks[self.$store.state.fm.left.selectedDisk].url + "/" + filePath : "/" + filePath;
            }
          }
          self.page.meta_image_path = self.selectedFiles;
          self.getFileAddedMessage();
        }
      }
    },
    currentPageType: function currentPageType(value) {
      if (value) {
        this.page.page_type = value.code;
        this.page.middleware = value.middleware;
      } else {
        this.page.page_type = '';
        this.page.middleware = [];
      }
    }
  }
});
function alignSidebar() {
  var prevScrollpos = window.scrollY;
  var scrollTop = document.getElementById('scroll-top');
  if (scrollTop) {
    if (prevScrollpos > 110) {
      scrollTop.classList.add('fixed-nav');
    } else {
      scrollTop.classList.remove('fixed-nav');
    }
  }
}
window.onscroll = function () {
  return alignSidebar();
};
document.addEventListener('DOMContentLoaded', function () {
  var sidebar = document.getElementById('custom-sidebar-ar');
  if (sidebar) {
    sidebar.addEventListener('click', function () {
      return alignSidebar();
    });
  }
});

/***/ }),

/***/ "./node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/pages/pages/FormFields.vue?vue&type=script&lang=js":
/*!*************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/pages/pages/FormFields.vue?vue&type=script&lang=js ***!
  \*************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var vue_prism_editor__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue-prism-editor */ "./node_modules/vue-prism-editor/dist/prismeditor.esm.js");
/* harmony import */ var vue_prism_editor_dist_prismeditor_min_css__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! vue-prism-editor/dist/prismeditor.min.css */ "./node_modules/vue-prism-editor/dist/prismeditor.min.css");
/* harmony import */ var prismjs_components_prism_core__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! prismjs/components/prism-core */ "./node_modules/prismjs/components/prism-core.js");
/* harmony import */ var prismjs_components_prism_core__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(prismjs_components_prism_core__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var prismjs_components_prism_clike__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! prismjs/components/prism-clike */ "./node_modules/prismjs/components/prism-clike.js");
/* harmony import */ var prismjs_components_prism_clike__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(prismjs_components_prism_clike__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var prismjs_components_prism_javascript__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! prismjs/components/prism-javascript */ "./node_modules/prismjs/components/prism-javascript.js");
/* harmony import */ var prismjs_components_prism_javascript__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(prismjs_components_prism_javascript__WEBPACK_IMPORTED_MODULE_4__);
/* harmony import */ var prismjs_themes_prism_okaidia_css__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! prismjs/themes/prism-okaidia.css */ "./node_modules/prismjs/themes/prism-okaidia.css");






/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  name: "FormFields",
  props: [],
  data: function data() {
    return {
      validationErrors: ""
    };
  },
  components: {
    PrismEditor: vue_prism_editor__WEBPACK_IMPORTED_MODULE_0__.PrismEditor
  },
  methods: {
    convertNameToSlug: function convertNameToSlug(Name) {
      var _this = this;
      clearTimeout(this.timer);
      this.timer = setTimeout(function () {
        var slug = Name.trim().toLowerCase().replace(/-/g, ' ').replace(/[^\w ]+/g, '').replace(/ +/g, '-');
        _this.checkPageSlugUnique(slug);
      }, 500);
    },
    checkPageSlugUnique: function checkPageSlugUnique(slug) {
      var _this2 = this;
      var params = {};
      if (this.method === 'put') {
        params.id = this.page.id;
      }
      params.slug = slug;
      axios.post("/admin/page/fetch/page-slug", params).then(function (response) {
        _this2.$parent.page.slug = response.data.slug;
      })["catch"](function (err) {
        console.error(err);
      });
    },
    highlighter: function highlighter(code) {
      return (0,prismjs_components_prism_core__WEBPACK_IMPORTED_MODULE_2__.highlight)(code, prismjs_components_prism_core__WEBPACK_IMPORTED_MODULE_2__.languages.js); //returns html
    },
    createBreadcrumbFromName: function createBreadcrumbFromName(Name) {
      console.log(Name);
      if (this.$parent.method !== 'put') {
        this.$parent.page.breadcrumb_title = Name;
      }
    }
  }
});

/***/ }),

/***/ "./node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/pages/pages/WidgetAttributesModal.vue?vue&type=script&lang=js":
/*!************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/pages/pages/WidgetAttributesModal.vue?vue&type=script&lang=js ***!
  \************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _allDisks_mixin__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../../allDisks.mixin */ "./resources/vue/allDisks.mixin.js");
/* harmony import */ var lodash__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! lodash */ "./node_modules/lodash/lodash.js");
/* harmony import */ var lodash__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(lodash__WEBPACK_IMPORTED_MODULE_1__);
function _typeof(o) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (o) { return typeof o; } : function (o) { return o && "function" == typeof Symbol && o.constructor === Symbol && o !== Symbol.prototype ? "symbol" : typeof o; }, _typeof(o); }
function _regeneratorRuntime() { "use strict"; /*! regenerator-runtime -- Copyright (c) 2014-present, Facebook, Inc. -- license (MIT): https://github.com/facebook/regenerator/blob/main/LICENSE */ _regeneratorRuntime = function _regeneratorRuntime() { return e; }; var t, e = {}, r = Object.prototype, n = r.hasOwnProperty, o = Object.defineProperty || function (t, e, r) { t[e] = r.value; }, i = "function" == typeof Symbol ? Symbol : {}, a = i.iterator || "@@iterator", c = i.asyncIterator || "@@asyncIterator", u = i.toStringTag || "@@toStringTag"; function define(t, e, r) { return Object.defineProperty(t, e, { value: r, enumerable: !0, configurable: !0, writable: !0 }), t[e]; } try { define({}, ""); } catch (t) { define = function define(t, e, r) { return t[e] = r; }; } function wrap(t, e, r, n) { var i = e && e.prototype instanceof Generator ? e : Generator, a = Object.create(i.prototype), c = new Context(n || []); return o(a, "_invoke", { value: makeInvokeMethod(t, r, c) }), a; } function tryCatch(t, e, r) { try { return { type: "normal", arg: t.call(e, r) }; } catch (t) { return { type: "throw", arg: t }; } } e.wrap = wrap; var h = "suspendedStart", l = "suspendedYield", f = "executing", s = "completed", y = {}; function Generator() {} function GeneratorFunction() {} function GeneratorFunctionPrototype() {} var p = {}; define(p, a, function () { return this; }); var d = Object.getPrototypeOf, v = d && d(d(values([]))); v && v !== r && n.call(v, a) && (p = v); var g = GeneratorFunctionPrototype.prototype = Generator.prototype = Object.create(p); function defineIteratorMethods(t) { ["next", "throw", "return"].forEach(function (e) { define(t, e, function (t) { return this._invoke(e, t); }); }); } function AsyncIterator(t, e) { function invoke(r, o, i, a) { var c = tryCatch(t[r], t, o); if ("throw" !== c.type) { var u = c.arg, h = u.value; return h && "object" == _typeof(h) && n.call(h, "__await") ? e.resolve(h.__await).then(function (t) { invoke("next", t, i, a); }, function (t) { invoke("throw", t, i, a); }) : e.resolve(h).then(function (t) { u.value = t, i(u); }, function (t) { return invoke("throw", t, i, a); }); } a(c.arg); } var r; o(this, "_invoke", { value: function value(t, n) { function callInvokeWithMethodAndArg() { return new e(function (e, r) { invoke(t, n, e, r); }); } return r = r ? r.then(callInvokeWithMethodAndArg, callInvokeWithMethodAndArg) : callInvokeWithMethodAndArg(); } }); } function makeInvokeMethod(e, r, n) { var o = h; return function (i, a) { if (o === f) throw Error("Generator is already running"); if (o === s) { if ("throw" === i) throw a; return { value: t, done: !0 }; } for (n.method = i, n.arg = a;;) { var c = n.delegate; if (c) { var u = maybeInvokeDelegate(c, n); if (u) { if (u === y) continue; return u; } } if ("next" === n.method) n.sent = n._sent = n.arg;else if ("throw" === n.method) { if (o === h) throw o = s, n.arg; n.dispatchException(n.arg); } else "return" === n.method && n.abrupt("return", n.arg); o = f; var p = tryCatch(e, r, n); if ("normal" === p.type) { if (o = n.done ? s : l, p.arg === y) continue; return { value: p.arg, done: n.done }; } "throw" === p.type && (o = s, n.method = "throw", n.arg = p.arg); } }; } function maybeInvokeDelegate(e, r) { var n = r.method, o = e.iterator[n]; if (o === t) return r.delegate = null, "throw" === n && e.iterator["return"] && (r.method = "return", r.arg = t, maybeInvokeDelegate(e, r), "throw" === r.method) || "return" !== n && (r.method = "throw", r.arg = new TypeError("The iterator does not provide a '" + n + "' method")), y; var i = tryCatch(o, e.iterator, r.arg); if ("throw" === i.type) return r.method = "throw", r.arg = i.arg, r.delegate = null, y; var a = i.arg; return a ? a.done ? (r[e.resultName] = a.value, r.next = e.nextLoc, "return" !== r.method && (r.method = "next", r.arg = t), r.delegate = null, y) : a : (r.method = "throw", r.arg = new TypeError("iterator result is not an object"), r.delegate = null, y); } function pushTryEntry(t) { var e = { tryLoc: t[0] }; 1 in t && (e.catchLoc = t[1]), 2 in t && (e.finallyLoc = t[2], e.afterLoc = t[3]), this.tryEntries.push(e); } function resetTryEntry(t) { var e = t.completion || {}; e.type = "normal", delete e.arg, t.completion = e; } function Context(t) { this.tryEntries = [{ tryLoc: "root" }], t.forEach(pushTryEntry, this), this.reset(!0); } function values(e) { if (e || "" === e) { var r = e[a]; if (r) return r.call(e); if ("function" == typeof e.next) return e; if (!isNaN(e.length)) { var o = -1, i = function next() { for (; ++o < e.length;) if (n.call(e, o)) return next.value = e[o], next.done = !1, next; return next.value = t, next.done = !0, next; }; return i.next = i; } } throw new TypeError(_typeof(e) + " is not iterable"); } return GeneratorFunction.prototype = GeneratorFunctionPrototype, o(g, "constructor", { value: GeneratorFunctionPrototype, configurable: !0 }), o(GeneratorFunctionPrototype, "constructor", { value: GeneratorFunction, configurable: !0 }), GeneratorFunction.displayName = define(GeneratorFunctionPrototype, u, "GeneratorFunction"), e.isGeneratorFunction = function (t) { var e = "function" == typeof t && t.constructor; return !!e && (e === GeneratorFunction || "GeneratorFunction" === (e.displayName || e.name)); }, e.mark = function (t) { return Object.setPrototypeOf ? Object.setPrototypeOf(t, GeneratorFunctionPrototype) : (t.__proto__ = GeneratorFunctionPrototype, define(t, u, "GeneratorFunction")), t.prototype = Object.create(g), t; }, e.awrap = function (t) { return { __await: t }; }, defineIteratorMethods(AsyncIterator.prototype), define(AsyncIterator.prototype, c, function () { return this; }), e.AsyncIterator = AsyncIterator, e.async = function (t, r, n, o, i) { void 0 === i && (i = Promise); var a = new AsyncIterator(wrap(t, r, n, o), i); return e.isGeneratorFunction(r) ? a : a.next().then(function (t) { return t.done ? t.value : a.next(); }); }, defineIteratorMethods(g), define(g, u, "Generator"), define(g, a, function () { return this; }), define(g, "toString", function () { return "[object Generator]"; }), e.keys = function (t) { var e = Object(t), r = []; for (var n in e) r.push(n); return r.reverse(), function next() { for (; r.length;) { var t = r.pop(); if (t in e) return next.value = t, next.done = !1, next; } return next.done = !0, next; }; }, e.values = values, Context.prototype = { constructor: Context, reset: function reset(e) { if (this.prev = 0, this.next = 0, this.sent = this._sent = t, this.done = !1, this.delegate = null, this.method = "next", this.arg = t, this.tryEntries.forEach(resetTryEntry), !e) for (var r in this) "t" === r.charAt(0) && n.call(this, r) && !isNaN(+r.slice(1)) && (this[r] = t); }, stop: function stop() { this.done = !0; var t = this.tryEntries[0].completion; if ("throw" === t.type) throw t.arg; return this.rval; }, dispatchException: function dispatchException(e) { if (this.done) throw e; var r = this; function handle(n, o) { return a.type = "throw", a.arg = e, r.next = n, o && (r.method = "next", r.arg = t), !!o; } for (var o = this.tryEntries.length - 1; o >= 0; --o) { var i = this.tryEntries[o], a = i.completion; if ("root" === i.tryLoc) return handle("end"); if (i.tryLoc <= this.prev) { var c = n.call(i, "catchLoc"), u = n.call(i, "finallyLoc"); if (c && u) { if (this.prev < i.catchLoc) return handle(i.catchLoc, !0); if (this.prev < i.finallyLoc) return handle(i.finallyLoc); } else if (c) { if (this.prev < i.catchLoc) return handle(i.catchLoc, !0); } else { if (!u) throw Error("try statement without catch or finally"); if (this.prev < i.finallyLoc) return handle(i.finallyLoc); } } } }, abrupt: function abrupt(t, e) { for (var r = this.tryEntries.length - 1; r >= 0; --r) { var o = this.tryEntries[r]; if (o.tryLoc <= this.prev && n.call(o, "finallyLoc") && this.prev < o.finallyLoc) { var i = o; break; } } i && ("break" === t || "continue" === t) && i.tryLoc <= e && e <= i.finallyLoc && (i = null); var a = i ? i.completion : {}; return a.type = t, a.arg = e, i ? (this.method = "next", this.next = i.finallyLoc, y) : this.complete(a); }, complete: function complete(t, e) { if ("throw" === t.type) throw t.arg; return "break" === t.type || "continue" === t.type ? this.next = t.arg : "return" === t.type ? (this.rval = this.arg = t.arg, this.method = "return", this.next = "end") : "normal" === t.type && e && (this.next = e), y; }, finish: function finish(t) { for (var e = this.tryEntries.length - 1; e >= 0; --e) { var r = this.tryEntries[e]; if (r.finallyLoc === t) return this.complete(r.completion, r.afterLoc), resetTryEntry(r), y; } }, "catch": function _catch(t) { for (var e = this.tryEntries.length - 1; e >= 0; --e) { var r = this.tryEntries[e]; if (r.tryLoc === t) { var n = r.completion; if ("throw" === n.type) { var o = n.arg; resetTryEntry(r); } return o; } } throw Error("illegal catch attempt"); }, delegateYield: function delegateYield(e, r, n) { return this.delegate = { iterator: values(e), resultName: r, nextLoc: n }, "next" === this.method && (this.arg = t), y; } }, e; }
function asyncGeneratorStep(n, t, e, r, o, a, c) { try { var i = n[a](c), u = i.value; } catch (n) { return void e(n); } i.done ? t(u) : Promise.resolve(u).then(r, o); }
function _asyncToGenerator(n) { return function () { var t = this, e = arguments; return new Promise(function (r, o) { var a = n.apply(t, e); function _next(n) { asyncGeneratorStep(a, r, o, _next, _throw, "next", n); } function _throw(n) { asyncGeneratorStep(a, r, o, _next, _throw, "throw", n); } _next(void 0); }); }; }


/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  name: 'WidgetAttributesModal',
  mixins: [_allDisks_mixin__WEBPACK_IMPORTED_MODULE_0__["default"]],
  props: [],
  data: function data() {
    return {
      loadedModal: 'Loading modal...',
      modalShade: '',
      modalBody: 'Loading...',
      validationErrors: '',
      widget: {
        name: '',
        code: {
          name: null,
          '@inside': null,
          '@attributes': [],
          '@nestedItems': []
        }
      },
      backupWidget: {},
      showAttributes: false,
      showNestedItems: false,
      titles: {
        upload_file: ' Upload File',
        choose_file: ' Choose File',
        close_file_manager: ' Close File Manager'
      },
      menu: {
        title: '',
        url: '',
        children: [{
          title: '',
          url: ''
        }]
      },
      selectedFiles: [],
      showFileManagerIFrame: false,
      canMultiple: false,
      indexOfAttributes: 0,
      selectedPage: '',
      showPageSelect: false,
      menuGroupOptions: [],
      merchandiseOptions: [],
      bannerZoneOptions: [],
      bannerItemCodeOptions: [],
      formOptions: [],
      pageOptions: [],
      contentOptions: [],
      categoryOptions: []
    };
  },
  mounted: function mounted() {
    this.backupWidget = lodash__WEBPACK_IMPORTED_MODULE_1___default().cloneDeep(this.widget);
    this.configureWidgetData('menu_group_lists', 'menuGroupOptions');
    this.configureWidgetData('merchandising_zones', 'merchandiseOptions');
    this.configureWidgetData('banner_zones', 'bannerZoneOptions');
    this.configureWidgetData('banner_item_codes', 'bannerItemCodeOptions');
    this.configureWidgetData('content_lists', 'contentOptions');
    this.configureWidgetData('category_lists', 'categoryOptions');
    this.configureWidgetData('form_lists', 'formOptions');
    this.configureWidgetData('page_lists', 'pageOptions');
    this.configureWidgetData('permissions', 'permissionOptions');
  },
  methods: {
    getModal: function getModal() {
      var _this = this;
      this.widget = this.$parent.activeWidget;
      this.showAttributes = this.widget['@attributes'].length > 0;
      this.showNestedItems = this.widget['@nestedItems'] !== null ? this.widget['@nestedItems'].length > 0 : false;
      setTimeout(function () {
        var modalShade = document.querySelector('.modal-backdrop.fade.show');
        modalShade ? modalShade.remove() : null;
        _this.modalShade = modalShade.outerHTML;
        _this.modalBody = document.querySelector('#widget-attributes-modal .modal-body').innerHTML;
      }, 100);
    },
    saveData: function saveData() {
      var _this2 = this;
      axios.post("/admin/page/fetch/convert-object-to-code", {
        page_type: this.$parent.page.page_type,
        code: JSON.stringify(this.widget)
      }).then(function (response) {
        new Noty({
          type: response.data.type,
          text: response.data.message
        }).show();
        _this2.$parent.code = response.data.code;
        document.querySelector('#cancelWidgetAttributesModalBtn').click();
      })["catch"](function (err) {
        var error = err.response.data;
        new Noty({
          type: error.type,
          text: error.message
        }).show();
        document.querySelector('#cancelWidgetAttributesModalBtn').click();
      });
    },
    makeTitleCase: function makeTitleCase(title) {
      if (!title) return '';
      title = title.replace(':', '').toString().split('-').map(function (w) {
        return w[0].toUpperCase() + w.substring(1).toLowerCase();
      }).join(' ');
      return title.replace('X ', '');
    },
    resetWidgetData: function resetWidgetData() {
      this.widget = lodash__WEBPACK_IMPORTED_MODULE_1___default().cloneDeep(this.backupWidget);
      this.$parent.activeWidget = null;
      this.$parent.activeWidgetIndex = undefined;
    },
    addArrayItem: function addArrayItem(attribute) {
      var format = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : [];
      var newfield;
      if (format.length) {
        newfield = {};
        format.forEach(function (item) {
          return newfield[item.name] = '';
        });
      }
      attribute.push(newfield);
    },
    // File Manager methods
    removeSelectedFiles: function removeSelectedFiles(index) {
      var length = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 1;
      var path = this.selectedFiles.splice(index, length);
      var noty = {
        type: 'success',
        text: "File (".concat(path, ") removed!")
      };
      new Noty(noty).show();
    },
    browseMainImage: function browseMainImage(event) {
      event.preventDefault();
    },
    onChangeBannerZoneDropdown: function onChangeBannerZoneDropdown(event) {
      if (!event) return;
      if (event.fetch_data_from_easyask == 1) {
        this.$parent.showBannerCode = false;
        this.widget['@attributes'][1].value = null;
      } else {
        this.$parent.showBannerCode = true;
      }
    },
    processImagesByType: function processImagesByType() {
      var indexOfAttributes = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : 0;
      this.indexOfAttributes = indexOfAttributes;
      this.selectedFiles = this.widget['@attributes'][indexOfAttributes].value;
    },
    getFileAddedMessage: function getFileAddedMessage() {
      var noty = {
        type: 'success',
        text: 'File path added!'
      };
      new Noty(noty).show();
    },
    deleteImage: function deleteImage() {
      var _this3 = this;
      var indexOfAttributes = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : 0;
      this.$swal({
        title: 'Remove this Image?',
        //icon              : 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ff6b81',
        cancelButtonColor: '#399E7F',
        confirmButtonText: 'Remove'
      }).then(function (result) {
        if (result.isConfirmed) {
          _this3.widget['@attributes'][indexOfAttributes].value = '';
        }
      });
    },
    getFileExtension: function getFileExtension(file) {
      var regexp = /\.([0-9a-z]+)(?:[\?#]|$)/i;
      var extension = file.match(regexp);
      return extension && extension[1];
    },
    configureWidgetData: function configureWidgetData(field, target) {
      var _this4 = this;
      return _asyncToGenerator(/*#__PURE__*/_regeneratorRuntime().mark(function _callee() {
        return _regeneratorRuntime().wrap(function _callee$(_context) {
          while (1) switch (_context.prev = _context.next) {
            case 0:
              _context.next = 2;
              return axios.get("/admin/page/get-widget-data/" + field, {
                headers: {
                  Accept: 'application/json',
                  'Content-Type': 'application/json'
                }
              }).then(function (response) {
                return _this4[target] = response.data;
              });
            case 2:
            case "end":
              return _context.stop();
          }
        }, _callee);
      }))();
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
          self.widget['@attributes'][self.indexOfAttributes].value = self.$parent.selectedFiles;
          self.getFileAddedMessage();
        }
      }
    }
  }
});

/***/ }),

/***/ "./node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/pages/pages/Create.vue?vue&type=template&id=12322794&scoped=true":
/*!********************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/pages/pages/Create.vue?vue&type=template&id=12322794&scoped=true ***!
  \********************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   render: () => (/* binding */ render),
/* harmony export */   staticRenderFns: () => (/* binding */ staticRenderFns)
/* harmony export */ });
var render = function render() {
  var _vm = this,
    _c = _vm._self._c;
  return _c("div", {
    staticClass: "row",
    "class": _vm.sidebarNav ? "sidebarNav" : "",
    attrs: {
      id: "scroll-top"
    }
  }, [_c("div", {
    "class": _vm.class_name
  }, [_c("div", {
    staticClass: "row"
  }, [_c("div", {
    staticClass: "col-lg-8"
  }, [_c("form", {
    attrs: {
      method: "post",
      action: _vm.backUrl
    },
    on: {
      submit: function submit($event) {
        $event.preventDefault();
      }
    }
  }, [_c("FormFields", {
    ref: "formFields"
  }), _vm._v(" "), _c("div", {
    staticClass: "form-group",
    attrs: {
      id: "saveActions"
    }
  }, [_c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.actionType,
      expression: "actionType"
    }],
    attrs: {
      type: "hidden",
      name: "save_action",
      value: "save_and_back"
    },
    domProps: {
      value: _vm.actionType
    },
    on: {
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.actionType = $event.target.value;
      }
    }
  }), _vm._v(" "), _c("div", {
    staticClass: "btn-group",
    attrs: {
      role: "group"
    }
  }, [_c("button", {
    staticClass: "btn btn-success",
    attrs: {
      type: "button"
    },
    on: {
      click: function click($event) {
        return _vm.saveData(_vm.saveAction.active.value);
      }
    }
  }, [_c("span", {
    staticClass: "la la-save",
    attrs: {
      role: "presentation",
      "aria-hidden": "true"
    }
  }), _vm._v("  \n                                    "), _c("span", [_vm._v(_vm._s(_vm.saveAction.active.label))])])]), _vm._v(" "), _c("a", {
    staticClass: "btn btn-default",
    attrs: {
      href: _vm.backUrl
    }
  }, [_c("span", {
    staticClass: "la la-ban"
  }), _vm._v("  Cancel")])])], 1)]), _vm._v(" "), _c("div", {
    staticClass: "col-lg-4 px-0"
  }, [_c("div", {
    staticClass: "d-lg-none custom-sidebar-ar btn btn-light",
    attrs: {
      id: "custom-sidebar-ar"
    },
    on: {
      click: function click($event) {
        return _vm.toggleSidebar();
      }
    }
  }, [_c("div", {
    directives: [{
      name: "show",
      rawName: "v-show",
      value: _vm.sidebarNav === false,
      expression: "sidebarNav === false"
    }],
    staticClass: "menu-icon-ar"
  }, [_c("svg", {
    staticClass: "feather feather-menu",
    attrs: {
      xmlns: "http://www.w3.org/2000/svg",
      width: "24",
      height: "24",
      viewBox: "0 0 24 24",
      fill: "none",
      stroke: "#1b2a4e",
      "stroke-width": "2",
      "stroke-linecap": "round",
      "stroke-linejoin": "round"
    }
  }, [_c("line", {
    attrs: {
      x1: "3",
      y1: "12",
      x2: "21",
      y2: "12"
    }
  }), _vm._v(" "), _c("line", {
    attrs: {
      x1: "3",
      y1: "6",
      x2: "21",
      y2: "6"
    }
  }), _vm._v(" "), _c("line", {
    attrs: {
      x1: "3",
      y1: "18",
      x2: "21",
      y2: "18"
    }
  })])]), _vm._v(" "), _c("div", {
    directives: [{
      name: "show",
      rawName: "v-show",
      value: _vm.sidebarNav === true,
      expression: "sidebarNav === true"
    }],
    staticClass: "close-icon-ar"
  }, [_c("svg", {
    staticClass: "feather feather-x",
    attrs: {
      xmlns: "http://www.w3.org/2000/svg",
      width: "24",
      height: "24",
      viewBox: "0 0 24 24",
      fill: "none",
      stroke: "red",
      "stroke-width": "2",
      "stroke-linecap": "round",
      "stroke-linejoin": "round"
    }
  }, [_c("line", {
    attrs: {
      x1: "18",
      y1: "6",
      x2: "6",
      y2: "18"
    }
  }), _vm._v(" "), _c("line", {
    attrs: {
      x1: "6",
      y1: "6",
      x2: "18",
      y2: "18"
    }
  })])])]), _vm._v(" "), _vm._m(0), _vm._v(" "), _c("div", {
    staticClass: "tab-content",
    staticStyle: {
      "min-height": "469px",
      "overflow-y": "auto"
    },
    attrs: {
      id: "myTabContent"
    }
  }, [_c("div", {
    staticClass: "tab-pane fade show active",
    attrs: {
      id: "home",
      role: "tabpanel",
      "aria-labelledby": "home-tab"
    }
  }, [_c("div", {
    staticClass: "form-group"
  }, [_c("input", {
    staticClass: "form-control",
    attrs: {
      type: "text",
      placeholder: "Type widget name to search"
    },
    on: {
      keyup: _vm.filterWidgetByName
    }
  })]), _vm._v(" "), _c("ul", {
    staticClass: "list-group fixed-height"
  }, _vm._l(_vm.widgetLists, function (wl, index) {
    return _c("li", {
      key: index,
      staticClass: "list-group-item cursor-pointer",
      "class": {
        active: index === _vm.activeWidgetIndex
      },
      attrs: {
        "data-toggle": "modal",
        "data-target": "#widget-attributes-modal",
        "data-wizard-value": wl.name
      },
      on: {
        click: function click($event) {
          _vm.activeWidget = wl;
          _vm.activeWidgetIndex = index;
          _vm.$refs.widgetAttributesModal.getModal();
        }
      }
    }, [_c("p", {
      staticClass: "mb-1"
    }, [_vm._v("\n                                        " + _vm._s(_vm.humanStyleWidgetName(wl.name)) + "\n                                        "), _c("i", {
      directives: [{
        name: "show",
        rawName: "v-show",
        value: wl.description,
        expression: "wl.description"
      }],
      staticClass: "la la-info-circle",
      attrs: {
        "data-toggle": "tooltip",
        title: wl.description
      }
    })]), _vm._v(" "), _c("div", {
      domProps: {
        innerHTML: _vm._s(_vm.getDataSource(wl.model))
      }
    }), _vm._v(" "), _c("p", {
      staticClass: "mb-1 mt-2"
    }, [_c("span", {
      staticClass: "badge badge-danger mr-1"
    }, [_vm._v("Permission")]), _vm._v("\n                                      " + _vm._s(wl.permissions.join(", ")) + "\n                                    ")])]);
  }), 0), _vm._v(" "), _c("div", {
    staticClass: "d-flex justify-content-between my-2"
  }, [_c("p", {
    staticClass: "font-weight-bold mb-0"
  }, [_vm._v("Snippet")]), _vm._v(" "), _vm.code.length > 0 ? _c("div", [_c("button", {
    directives: [{
      name: "clipboard",
      rawName: "v-clipboard:copy",
      value: _vm.code,
      expression: "code",
      arg: "copy"
    }, {
      name: "clipboard",
      rawName: "v-clipboard:success",
      value: _vm.onCopy,
      expression: "onCopy",
      arg: "success"
    }, {
      name: "clipboard",
      rawName: "v-clipboard:error",
      value: _vm.onError,
      expression: "onError",
      arg: "error"
    }],
    staticClass: "btn-clipboard position-static",
    style: {
      background: _vm.copyButtonText === "copy" ? "black" : "green"
    },
    attrs: {
      type: "button"
    }
  }, [_vm._v("\n                                        " + _vm._s(_vm.copyButtonText) + "\n                                    ")])]) : _vm._e()]), _vm._v(" "), _c("div", {
    staticClass: "d-flex justify-content-between"
  }, [_c("prism-editor", {
    staticClass: "my-editor height-150 language-xml-doc",
    attrs: {
      highlight: _vm.highlighter,
      "line-numbers": true,
      readonly: true
    },
    model: {
      value: _vm.code,
      callback: function callback($$v) {
        _vm.code = $$v;
      },
      expression: "code"
    }
  })], 1)]), _vm._v(" "), _c("div", {
    staticClass: "tab-pane fade",
    attrs: {
      id: "options",
      role: "tabpanel",
      "aria-labelledby": "options-tab"
    }
  }, [_c("div", {
    staticClass: "form-group"
  }, [_c("label", {
    "class": {
      "error-color": _vm.validationErrors.slug
    }
  }, [_vm._v("\n                                    Slug\n                                    "), _c("span", {
    staticClass: "text-danger font-weight-bold"
  }, [_vm._v("*")])]), _vm._v(" "), _c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.page.slug,
      expression: "page.slug"
    }],
    staticClass: "form-control",
    "class": {
      "is-invalid": _vm.validationErrors.slug
    },
    attrs: {
      name: "description",
      type: "text",
      required: "",
      disabled: _vm.method === "get"
    },
    domProps: {
      value: _vm.page.slug
    },
    on: {
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.$set(_vm.page, "slug", $event.target.value);
      }
    }
  }), _vm._v(" "), _vm.validationErrors.slug ? _c("small", {
    staticClass: "text-danger mt-3"
  }, [_vm._v("\n                                    " + _vm._s(_vm.validationErrors.slug[0]) + "\n                                ")]) : _vm._e()]), _vm._v(" "), _c("div", {
    staticClass: "form-group"
  }, [_c("label", {
    "class": {
      "error-color": _vm.validationErrors.page_type
    }
  }, [_vm._v("\n                                    Page Type "), _c("span", {
    staticClass: "text-danger font-weight-bold"
  }, [_vm._v("*")])]), _vm._v(" "), _c("multiselect", {
    attrs: {
      placeholder: "Select an page type",
      options: _vm.pageTypesArray,
      "custom-label": _vm.labelWithDescription,
      label: "label",
      "track-by": "code",
      disabled: _vm.method === "get"
    },
    scopedSlots: _vm._u([{
      key: "option",
      fn: function fn(props) {
        return [_c("span", {
          staticClass: "font-weight-bold d-block",
          attrs: {
            title: props.option.description
          }
        }, [_vm._v("\n                            " + _vm._s(props.option.label) + " "), props.option.description.length !== 0 ? _c("i", {
          staticClass: "mr-1 la la-info-circle"
        }) : _vm._e()]), _vm._v(" "), _c("div", {
          staticClass: "text-sm text-gray-dark mt-1"
        }, [_c("small", [_c("b", [_vm._v("Accessibility")]), _vm._v(":\n                                                "), _vm._l(props.option.middleware, function (middleware, index) {
          return _c("span", {
            key: index,
            staticClass: "mr-1"
          }, [_vm._v(_vm._s(_vm.displayMiddleware(middleware)))]);
        }), _vm._v(" "), props.option.middleware.length == 0 ? _c("span", {
          staticClass: "mr-1"
        }, [_vm._v("None")]) : _vm._e()], 2)])];
      }
    }]),
    model: {
      value: _vm.currentPageType,
      callback: function callback($$v) {
        _vm.currentPageType = $$v;
      },
      expression: "currentPageType"
    }
  }), _vm._v(" "), _vm.validationErrors.page_type ? _c("small", {
    staticClass: "text-danger mt-3"
  }, [_vm._v("\n                                    " + _vm._s(_vm.validationErrors.page_type[0]) + "\n                                ")]) : _vm._e()], 1), _vm._v(" "), _vm.page.page_type === "static_page" || _vm.page.page_type == "" ? _c("div", {
    staticClass: "form-group"
  }, [_c("label", {
    "class": {
      "error-color": _vm.validationErrors.middleware
    }
  }, [_vm._v("\n                                    Accessibility\n                                ")]), _vm._v(" "), _c("multiselect", {
    attrs: {
      placeholder: "Select Accessibility Level(s)",
      options: _vm.middlewareList,
      "custom-label": _vm.labelWithDescription,
      label: "label",
      "track-by": "guard",
      multiple: true,
      "preserve-search": true,
      disabled: _vm.method === "get"
    },
    scopedSlots: _vm._u([{
      key: "option",
      fn: function fn(props) {
        return [_c("span", {
          staticClass: "font-weight-bold d-block"
        }, [_vm._v(_vm._s(props.option.label))]), _vm._v(" "), _c("small", {
          staticClass: "text-sm d-block text-gray-dark"
        }, [_vm._v(_vm._s(props.option.description))])];
      }
    }], null, false, 404609147),
    model: {
      value: _vm.page.middleware,
      callback: function callback($$v) {
        _vm.$set(_vm.page, "middleware", $$v);
      },
      expression: "page.middleware"
    }
  }), _vm._v(" "), _vm.validationErrors.middleware ? _c("small", {
    staticClass: "text-danger mt-3"
  }, [_vm._v("\n                                    " + _vm._s(_vm.validationErrors.middleware[0]) + "\n                                ")]) : _vm._e()], 1) : _vm._e(), _vm._v(" "), _c("div", {
    staticClass: "form-group"
  }, [_c("div", {
    staticClass: "form-check form-check-inline d-block mb-3 mb-lg-0 d-lg-inline-flex"
  }, [_c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.page.has_breadcrumb,
      expression: "page.has_breadcrumb"
    }],
    staticClass: "form-check-input",
    attrs: {
      type: "checkbox",
      id: "has-breadcrumbs"
    },
    domProps: {
      checked: Array.isArray(_vm.page.has_breadcrumb) ? _vm._i(_vm.page.has_breadcrumb, null) > -1 : _vm.page.has_breadcrumb
    },
    on: {
      change: function change($event) {
        var $$a = _vm.page.has_breadcrumb,
          $$el = $event.target,
          $$c = $$el.checked ? true : false;
        if (Array.isArray($$a)) {
          var $$v = null,
            $$i = _vm._i($$a, $$v);
          if ($$el.checked) {
            $$i < 0 && _vm.$set(_vm.page, "has_breadcrumb", $$a.concat([$$v]));
          } else {
            $$i > -1 && _vm.$set(_vm.page, "has_breadcrumb", $$a.slice(0, $$i).concat($$a.slice($$i + 1)));
          }
        } else {
          _vm.$set(_vm.page, "has_breadcrumb", $$c);
        }
      }
    }
  }), _vm._v(" "), _c("label", {
    staticClass: "form-check-label",
    attrs: {
      "for": "has-breadcrumbs"
    }
  }, [_vm._v("Show Breadcrumbs")])])]), _vm._v(" "), _vm.page.has_breadcrumb ? _c("div", {
    staticClass: "form-group"
  }, [_c("label", [_vm._v("Breadcrumb Title")]), _vm._v(" "), _c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.page.breadcrumb_title,
      expression: "page.breadcrumb_title"
    }],
    "class": {
      "form-control": true,
      "is-invalid": _vm.validationErrors.breadcrumb_title
    },
    attrs: {
      type: "text"
    },
    domProps: {
      value: _vm.page.breadcrumb_title
    },
    on: {
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.$set(_vm.page, "breadcrumb_title", $event.target.value);
      }
    }
  }), _vm._v(" "), _vm.validationErrors.breadcrumb_title ? _c("small", {
    staticClass: "text-danger mt-3"
  }, [_vm._v("\n                                    " + _vm._s(_vm.validationErrors.breadcrumb_title[0]) + "\n                                ")]) : _vm._e()]) : _vm._e(), _vm._v(" "), _c("div", {
    staticClass: "form-group"
  }, [_c("div", {
    staticClass: "form-check form-check-inline d-block mb-3 mb-lg-0 d-lg-inline-flex"
  }, [_c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.page.has_footer,
      expression: "page.has_footer"
    }],
    staticClass: "form-check-input",
    attrs: {
      type: "checkbox",
      id: "has-footer"
    },
    domProps: {
      checked: Array.isArray(_vm.page.has_footer) ? _vm._i(_vm.page.has_footer, null) > -1 : _vm.page.has_footer
    },
    on: {
      change: function change($event) {
        var $$a = _vm.page.has_footer,
          $$el = $event.target,
          $$c = $$el.checked ? true : false;
        if (Array.isArray($$a)) {
          var $$v = null,
            $$i = _vm._i($$a, $$v);
          if ($$el.checked) {
            $$i < 0 && _vm.$set(_vm.page, "has_footer", $$a.concat([$$v]));
          } else {
            $$i > -1 && _vm.$set(_vm.page, "has_footer", $$a.slice(0, $$i).concat($$a.slice($$i + 1)));
          }
        } else {
          _vm.$set(_vm.page, "has_footer", $$c);
        }
      }
    }
  }), _vm._v(" "), _c("label", {
    staticClass: "form-check-label",
    attrs: {
      "for": "has-footer"
    }
  }, [_vm._v("Display Footer")])])]), _vm._v(" "), _vm.rightSideBarOptionEnabled ? _c("div", {
    staticClass: "form-group"
  }, [_c("div", {
    staticClass: "form-check form-check-inline d-block mb-3 mb-lg-0 d-lg-inline-flex"
  }, [_c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.page.has_right_sidebar,
      expression: "page.has_right_sidebar"
    }],
    staticClass: "form-check-input",
    attrs: {
      type: "checkbox",
      id: "has_right_sidebar"
    },
    domProps: {
      checked: Array.isArray(_vm.page.has_right_sidebar) ? _vm._i(_vm.page.has_right_sidebar, null) > -1 : _vm.page.has_right_sidebar
    },
    on: {
      change: function change($event) {
        var $$a = _vm.page.has_right_sidebar,
          $$el = $event.target,
          $$c = $$el.checked ? true : false;
        if (Array.isArray($$a)) {
          var $$v = null,
            $$i = _vm._i($$a, $$v);
          if ($$el.checked) {
            $$i < 0 && _vm.$set(_vm.page, "has_right_sidebar", $$a.concat([$$v]));
          } else {
            $$i > -1 && _vm.$set(_vm.page, "has_right_sidebar", $$a.slice(0, $$i).concat($$a.slice($$i + 1)));
          }
        } else {
          _vm.$set(_vm.page, "has_right_sidebar", $$c);
        }
      }
    }
  }), _vm._v(" "), _c("label", {
    staticClass: "form-check-label",
    attrs: {
      "for": "has_right_sidebar"
    }
  }, [_vm._v("Display Right Side Panel")])])]) : _vm._e()]), _vm._v(" "), _c("div", {
    staticClass: "tab-pane fade",
    attrs: {
      id: "profile",
      role: "tabpanel",
      "aria-labelledby": "profile-tab"
    }
  }, [_c("div", {
    staticClass: "form-group"
  }, [_c("label", [_vm._v("Meta Description:")]), _vm._v(" "), _c("textarea", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.page.meta_description,
      expression: "page.meta_description"
    }],
    staticClass: "form-control",
    attrs: {
      type: "text",
      id: "meta_description",
      name: "meta_description",
      placeholder: "Enter meta description"
    },
    domProps: {
      value: _vm.page.meta_description
    },
    on: {
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.$set(_vm.page, "meta_description", $event.target.value);
      }
    }
  })]), _vm._v(" "), _c("div", {
    staticClass: "form-group"
  }, [_c("label", [_vm._v("Meta Keywords:")]), _vm._v(" "), _c("textarea", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.page.meta_key,
      expression: "page.meta_key"
    }],
    staticClass: "form-control",
    attrs: {
      type: "text",
      id: "meta_key",
      name: "meta_key",
      placeholder: "Enter meta keyword"
    },
    domProps: {
      value: _vm.page.meta_key
    },
    on: {
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.$set(_vm.page, "meta_key", $event.target.value);
      }
    }
  })]), _vm._v(" "), _c("div", {
    staticClass: "form-group"
  }, [_c("label", [_vm._v("\n                                    Meta Image\n                                ")]), _vm._v(" "), _c("div", {
    staticClass: "controls"
  }, [_c("div", {
    staticClass: "input-group"
  }, [_c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.page.meta_image_path,
      expression: "page.meta_image_path"
    }],
    staticClass: "form-control",
    attrs: {
      type: "text",
      name: "meta_image_path",
      id: "meta_image_path"
    },
    domProps: {
      value: _vm.page.meta_image_path
    },
    on: {
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.$set(_vm.page, "meta_image_path", $event.target.value);
      }
    }
  }), _vm._v(" "), _c("span", {
    staticClass: "input-group-append"
  }, [_c("button", {
    staticClass: "btn btn-light btn-sm popup_selector",
    attrs: {
      type: "button",
      "data-toggle": "modal",
      "data-target": "#file-manager-modal"
    },
    on: {
      click: function click($event) {
        _vm.prepareModal();
        _vm.processImagesByType();
        _vm.canMultiple = false;
      }
    }
  }, [_c("i", {
    staticClass: "la la-cloud-upload"
  }), _vm._v(" Browse\n                                        ")]), _vm._v(" "), _c("button", {
    staticClass: "btn btn-light btn-sm",
    attrs: {
      type: "button"
    },
    on: {
      click: function click($event) {
        return _vm.deleteImage();
      }
    }
  }, [_c("i", {
    staticClass: "la la-eraser"
  }), _vm._v(" Clear")])])])])]), _vm._v(" "), _c("div", {
    staticClass: "form-group"
  }, [_c("label", [_vm._v("Title:")]), _vm._v(" "), _c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.page.title,
      expression: "page.title"
    }],
    staticClass: "form-control",
    attrs: {
      type: "text",
      id: "title",
      name: "title",
      placeholder: "Enter title"
    },
    domProps: {
      value: _vm.page.title
    },
    on: {
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.$set(_vm.page, "title", $event.target.value);
      }
    }
  })])]), _vm._v(" "), _c("div", {
    staticClass: "tab-pane fade",
    attrs: {
      id: "style",
      role: "tabpanel",
      "aria-labelledby": "style-tab"
    }
  }, [_c("div", {
    staticClass: "form-group"
  }, [_c("label", [_vm._v("Styles:")]), _vm._v(" "), _c("textarea", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.page.styles,
      expression: "page.styles"
    }],
    staticClass: "form-control",
    staticStyle: {
      height: "100%"
    },
    attrs: {
      type: "text",
      id: "styles",
      name: "styles",
      placeholder: "Enter custom css styles"
    },
    domProps: {
      value: _vm.page.styles
    },
    on: {
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.$set(_vm.page, "styles", $event.target.value);
      }
    }
  })])])])])])]), _vm._v(" "), _c("WidgetAttributesModal", {
    ref: "widgetAttributesModal"
  }), _vm._v(" "), _c("div", {
    staticClass: "modal fade",
    attrs: {
      id: "file-manager-modal",
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
      "margin-bottom": "0!important"
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
  }, [_vm._v("Cancel\n                        ")])])])])])], 1);
};
var staticRenderFns = [function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("ul", {
    staticClass: "nav nav-tabs nav-justified",
    attrs: {
      id: "myTab",
      role: "tablist"
    }
  }, [_c("li", {
    staticClass: "nav-item"
  }, [_c("a", {
    staticClass: "nav-link active",
    attrs: {
      id: "home-tab",
      "data-toggle": "tab",
      href: "#home",
      role: "tab",
      "aria-controls": "home",
      "aria-selected": "false"
    }
  }, [_vm._v("Widget\n                            ")])]), _vm._v(" "), _c("li", {
    staticClass: "nav-item"
  }, [_c("a", {
    staticClass: "nav-link",
    attrs: {
      id: "options-tab",
      "data-toggle": "tab",
      href: "#options",
      role: "tab",
      "aria-controls": "options",
      "aria-selected": "true"
    }
  }, [_vm._v("Options")])]), _vm._v(" "), _c("li", {
    staticClass: "nav-item"
  }, [_c("a", {
    staticClass: "nav-link",
    attrs: {
      id: "profile-tab",
      "data-toggle": "tab",
      href: "#profile",
      role: "tab",
      "aria-controls": "profile",
      "aria-selected": "false"
    }
  }, [_vm._v("SEO")])]), _vm._v(" "), _c("li", {
    staticClass: "nav-item"
  }, [_c("a", {
    staticClass: "nav-link",
    attrs: {
      id: "style-tab",
      "data-toggle": "tab",
      href: "#style",
      role: "tab",
      "aria-controls": "style",
      title: "Custom Style for this page",
      "aria-selected": "false"
    }
  }, [_vm._v("CSS")])])]);
}, function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("h5", {
    staticClass: "modal-title",
    attrs: {
      id: "attribute-inline-create-dialog-label"
    }
  }, [_vm._v("\n                            Set image for Seo Meta Image "), _c("strong")]);
}];
render._withStripped = true;


/***/ }),

/***/ "./node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/pages/pages/FormFields.vue?vue&type=template&id=c054ba96":
/*!************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/pages/pages/FormFields.vue?vue&type=template&id=c054ba96 ***!
  \************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
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
  }, [_c("label", {
    "class": {
      "error-color": _vm.validationErrors.name
    }
  }, [_vm._v("\n                Name\n                "), _c("span", {
    staticClass: "text-danger font-weight-bold"
  }, [_vm._v("*")])]), _vm._v(" "), _c("i", {
    staticClass: "la la-flag-checkered pull-right",
    staticStyle: {
      "margin-top": "3px"
    },
    attrs: {
      title: "This field is translatable."
    }
  }), _vm._v(" "), _c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.$parent.page.name,
      expression: "$parent.page.name"
    }],
    staticClass: "form-control",
    "class": {
      "is-invalid": _vm.$parent.validationErrors.name
    },
    attrs: {
      type: "text",
      name: "page_name",
      required: "",
      placeholder: "Enter page name",
      disabled: _vm.$parent.method === "get"
    },
    domProps: {
      value: _vm.$parent.page.name
    },
    on: {
      input: [function ($event) {
        if ($event.target.composing) return;
        _vm.$set(_vm.$parent.page, "name", $event.target.value);
      }, function ($event) {
        _vm.convertNameToSlug(_vm.$parent.page.name);
        _vm.createBreadcrumbFromName(_vm.$parent.page.name);
      }]
    }
  }), _vm._v(" "), _vm.validationErrors.name ? _c("small", {
    staticClass: "text-danger mt-3"
  }, [_vm._v("\n                " + _vm._s(_vm.validationErrors.name[0]) + "\n            ")]) : _vm._e()]), _vm._v(" "), _c("div", {
    staticClass: "form-group mb-0"
  }, [_c("label", {
    "class": {
      "error-color": _vm.validationErrors.content
    }
  }, [_vm._v("\n                Content\n                "), _c("span", {
    staticClass: "text-danger font-weight-bold"
  }, [_vm._v("*")])]), _vm._v(" "), _c("prism-editor", {
    staticClass: "my-editor language-xml-doc",
    attrs: {
      highlight: _vm.highlighter,
      "line-numbers": true,
      readonly: _vm.$parent.method === "get"
    },
    model: {
      value: _vm.$parent.page.content,
      callback: function callback($$v) {
        _vm.$set(_vm.$parent.page, "content", $$v);
      },
      expression: "$parent.page.content"
    }
  }), _vm._v(" "), _vm.validationErrors.content ? _c("small", {
    staticClass: "text-danger mt-3"
  }, [_vm._v("\n                " + _vm._s(_vm.validationErrors.content[0]) + "\n            ")]) : _vm._e()], 1)])]);
};
var staticRenderFns = [];
render._withStripped = true;


/***/ }),

/***/ "./node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/pages/pages/WidgetAttributesModal.vue?vue&type=template&id=1d5c776c&scoped=true":
/*!***********************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/pages/pages/WidgetAttributesModal.vue?vue&type=template&id=1d5c776c&scoped=true ***!
  \***********************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   render: () => (/* binding */ render),
/* harmony export */   staticRenderFns: () => (/* binding */ staticRenderFns)
/* harmony export */ });
var render = function render() {
  var _vm = this,
    _c = _vm._self._c;
  return _c("div", [_c("div", {
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
    staticClass: "modal-dialog modal-dialog-scrollable modal-xl",
    attrs: {
      role: "document"
    }
  }, [_c("div", {
    staticClass: "modal-content"
  }, [_c("div", {
    staticClass: "modal-header"
  }, [_c("h5", {
    staticClass: "modal-title",
    attrs: {
      id: "attribute-inline-create-dialog-label"
    }
  }, [_vm._v("\n                        Set attributes for "), _c("strong", [_vm._v(" " + _vm._s(_vm.makeTitleCase(_vm.widget.name)) + " ")])]), _vm._v(" "), _c("button", {
    staticClass: "close",
    attrs: {
      type: "button",
      "data-dismiss": "modal",
      "aria-label": "Close"
    },
    on: {
      click: function click($event) {
        _vm.modalShade = "";
        _vm.resetWidgetData();
      }
    }
  }, [_c("span", {
    attrs: {
      "aria-hidden": "true"
    }
  }, [_vm._v("×")])])]), _vm._v(" "), _c("div", {
    staticClass: "modal-body bg-light"
  }, [_c("div", {
    directives: [{
      name: "show",
      rawName: "v-show",
      value: _vm.showFileManagerIFrame,
      expression: "showFileManagerIFrame"
    }]
  }, [_c("div", {
    staticClass: "col-12 mt-2"
  }, [_c("div", {
    staticClass: "card"
  }, [_c("div", {
    staticClass: "card-body"
  }, [_c("file-manager", {
    ref: "fileManager"
  })], 1), _vm._v(" "), _c("div", {
    staticClass: "card-footer text-right"
  }, [_c("label", {
    staticClass: "btn btn-danger btn-sm btn-file py-2 mb-0 cursor-pointer",
    attrs: {
      title: "close file manager",
      "for": "elfinder-iframe-close-button"
    }
  }, [_c("i", {
    staticClass: "la la-times-circle"
  }), _vm._v(_vm._s(_vm.titles.close_file_manager) + "\n                                        "), _c("input", {
    staticClass: "form-control d-none file_design",
    attrs: {
      id: "elfinder-iframe-close-button",
      type: "text",
      title: "close file manager"
    },
    on: {
      click: function click($event) {
        _vm.showFileManagerIFrame = !_vm.showFileManagerIFrame;
      }
    }
  })])])])])]), _vm._v(" "), !_vm.showFileManagerIFrame ? _c("div", [_vm.widget["@inside"] ? _c("div", {
    staticClass: "form-row"
  }, [_c("div", {
    staticClass: "form-group col-12"
  }, [_c("label", [_vm._v("Inside text of the tag")]), _vm._v(" "), _c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.widget["@inside"],
      expression: "widget['@inside']"
    }],
    staticClass: "form-control",
    attrs: {
      type: "text"
    },
    domProps: {
      value: _vm.widget["@inside"]
    },
    on: {
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.$set(_vm.widget, "@inside", $event.target.value);
      }
    }
  })])]) : _vm._e(), _vm._v(" "), _vm.showAttributes ? _c("div", _vm._l(_vm.widget["@attributes"], function (attribute, indexOfAttributes) {
    var _attribute$min, _attribute$max, _attribute$step;
    return _c("div", {
      key: indexOfAttributes,
      staticClass: "form-group"
    }, [attribute.type !== "banner-code" || attribute.type === "banner-code" && _vm.$parent.showBannerCode ? _c("label", {
      attrs: {
        "for": attribute.name
      }
    }, [_vm._v("\n                                    " + _vm._s(_vm.makeTitleCase(attribute.name)) + "\n                                ")]) : _vm._e(), _vm._v(" "), attribute.type === "boolean" || attribute.type === "bool" ? _c("div", [_c("div", {
      staticClass: "form-check form-check-inline"
    }, [_c("input", {
      directives: [{
        name: "model",
        rawName: "v-model",
        value: attribute.value,
        expression: "attribute.value"
      }],
      staticClass: "form-check-input",
      attrs: {
        id: attribute.name + "true",
        type: "radio",
        value: "true",
        name: attribute.name
      },
      domProps: {
        checked: _vm._q(attribute.value, "true")
      },
      on: {
        change: function change($event) {
          return _vm.$set(attribute, "value", "true");
        }
      }
    }), _vm._v(" "), _c("label", {
      staticClass: "form-check-label",
      attrs: {
        "for": attribute.name + "true"
      }
    }, [_vm._v("Yes")])]), _vm._v(" "), _c("div", {
      staticClass: "form-check form-check-inline"
    }, [_c("input", {
      directives: [{
        name: "model",
        rawName: "v-model",
        value: attribute.value,
        expression: "attribute.value"
      }],
      staticClass: "form-check-input",
      attrs: {
        id: attribute.name + "false",
        type: "radio",
        value: "false",
        name: attribute.name
      },
      domProps: {
        checked: _vm._q(attribute.value, "false")
      },
      on: {
        change: function change($event) {
          return _vm.$set(attribute, "value", "false");
        }
      }
    }), _vm._v(" "), _c("label", {
      staticClass: "form-check-label",
      attrs: {
        "for": attribute.name + "false"
      }
    }, [_vm._v("No")])])]) : _vm._e(), _vm._v(" "), attribute.type === "text" ? _c("div", [_c("input", {
      directives: [{
        name: "model",
        rawName: "v-model",
        value: attribute.value,
        expression: "attribute.value"
      }],
      staticClass: "form-control",
      attrs: {
        type: "text",
        id: attribute.name
      },
      domProps: {
        value: attribute.value
      },
      on: {
        input: function input($event) {
          if ($event.target.composing) return;
          _vm.$set(attribute, "value", $event.target.value);
        }
      }
    })]) : _vm._e(), _vm._v(" "), attribute.type === "textarea" ? _c("div", [_c("textarea", {
      directives: [{
        name: "model",
        rawName: "v-model",
        value: attribute.value,
        expression: "attribute.value"
      }],
      staticClass: "form-control",
      attrs: {
        id: attribute.name,
        rows: "3"
      },
      domProps: {
        value: attribute.value
      },
      on: {
        input: function input($event) {
          if ($event.target.composing) return;
          _vm.$set(attribute, "value", $event.target.value);
        }
      }
    })]) : _vm._e(), _vm._v(" "), attribute.type === "range" ? _c("div", [_c("input", {
      directives: [{
        name: "model",
        rawName: "v-model",
        value: attribute.value,
        expression: "attribute.value"
      }],
      staticClass: "form-control custom-range",
      attrs: {
        type: "range",
        id: attribute.name,
        min: (_attribute$min = attribute.min) !== null && _attribute$min !== void 0 ? _attribute$min : 0,
        max: (_attribute$max = attribute.max) !== null && _attribute$max !== void 0 ? _attribute$max : 0,
        step: (_attribute$step = attribute.step) !== null && _attribute$step !== void 0 ? _attribute$step : "any"
      },
      domProps: {
        value: attribute.value
      },
      on: {
        __r: function __r($event) {
          return _vm.$set(attribute, "value", $event.target.value);
        }
      }
    })]) : _vm._e(), _vm._v(" "), attribute.type === "number" ? _c("div", [_c("input", {
      directives: [{
        name: "model",
        rawName: "v-model",
        value: attribute.value,
        expression: "attribute.value"
      }],
      staticClass: "form-control",
      attrs: {
        type: "number",
        id: attribute.name
      },
      domProps: {
        value: attribute.value
      },
      on: {
        input: function input($event) {
          if ($event.target.composing) return;
          _vm.$set(attribute, "value", $event.target.value);
        }
      }
    })]) : _vm._e(), _vm._v(" "), attribute.type === "url" ? _c("div", [_c("input", {
      directives: [{
        name: "model",
        rawName: "v-model",
        value: attribute.value,
        expression: "attribute.value"
      }],
      staticClass: "form-control",
      attrs: {
        type: "url",
        id: attribute.name
      },
      domProps: {
        value: attribute.value
      },
      on: {
        input: function input($event) {
          if ($event.target.composing) return;
          _vm.$set(attribute, "value", $event.target.value);
        }
      }
    })]) : _vm._e(), _vm._v(" "), attribute.type === "email" ? _c("div", [_c("input", {
      directives: [{
        name: "model",
        rawName: "v-model",
        value: attribute.value,
        expression: "attribute.value"
      }],
      staticClass: "form-control",
      attrs: {
        type: "email",
        id: attribute.name
      },
      domProps: {
        value: attribute.value
      },
      on: {
        input: function input($event) {
          if ($event.target.composing) return;
          _vm.$set(attribute, "value", $event.target.value);
        }
      }
    })]) : _vm._e(), _vm._v(" "), attribute.type === "color" ? _c("div", [_c("input", {
      directives: [{
        name: "model",
        rawName: "v-model",
        value: attribute.value,
        expression: "attribute.value"
      }],
      staticClass: "form-control",
      attrs: {
        type: "color",
        id: attribute.name
      },
      domProps: {
        value: attribute.value
      },
      on: {
        input: function input($event) {
          if ($event.target.composing) return;
          _vm.$set(attribute, "value", $event.target.value);
        }
      }
    })]) : _vm._e(), _vm._v(" "), attribute.type === "select" ? _c("div", [_c("select", {
      directives: [{
        name: "model",
        rawName: "v-model",
        value: attribute.value,
        expression: "attribute.value"
      }],
      staticClass: "form-control custom-select",
      attrs: {
        id: attribute.name
      },
      on: {
        change: function change($event) {
          var $$selectedVal = Array.prototype.filter.call($event.target.options, function (o) {
            return o.selected;
          }).map(function (o) {
            var val = "_value" in o ? o._value : o.value;
            return val;
          });
          _vm.$set(attribute, "value", $event.target.multiple ? $$selectedVal : $$selectedVal[0]);
        }
      }
    }, [_c("option", {
      attrs: {
        value: ""
      }
    }, [_vm._v("Select an option")]), _vm._v(" "), _vm._l(attribute.options, function (option, value) {
      return _c("option", {
        key: value,
        domProps: {
          value: value,
          selected: value === attribute.value
        }
      }, [_vm._v("\n                                            " + _vm._s(option) + "\n                                        ")]);
    })], 2)]) : _vm._e(), _vm._v(" "), attribute.type === "merchandises-dropdown" ? _c("div", {
      staticClass: "d-block"
    }, [_c("multiselect", {
      attrs: {
        id: attribute.name,
        options: _vm.merchandiseOptions,
        placeholder: "Select a merchandising zone",
        label: "name",
        "track-by": "name"
      },
      model: {
        value: attribute.value,
        callback: function callback($$v) {
          _vm.$set(attribute, "value", $$v);
        },
        expression: "attribute.value"
      }
    })], 1) : _vm._e(), _vm._v(" "), attribute.type === "permission-dropdown" ? _c("div", {
      staticClass: "d-block"
    }, [_c("multiselect", {
      attrs: {
        id: attribute.name,
        options: _vm.permissionOptions,
        placeholder: "Select a permission",
        label: "name",
        "track-by": "name"
      },
      model: {
        value: attribute.value,
        callback: function callback($$v) {
          _vm.$set(attribute, "value", $$v);
        },
        expression: "attribute.value"
      }
    })], 1) : _vm._e(), _vm._v(" "), attribute.type === "form-dropdown" ? _c("div", {
      staticClass: "d-block"
    }, [_c("multiselect", {
      attrs: {
        id: attribute.name,
        options: _vm.formOptions,
        placeholder: "Select a form",
        label: "name",
        "track-by": "code"
      },
      model: {
        value: attribute.value,
        callback: function callback($$v) {
          _vm.$set(attribute, "value", $$v);
        },
        expression: "attribute.value"
      }
    })], 1) : _vm._e(), _vm._v(" "), attribute.type === "banner-zone" ? _c("div", {
      staticClass: "d-block"
    }, [_c("multiselect", {
      attrs: {
        id: attribute.name,
        options: _vm.bannerZoneOptions,
        placeholder: "Select a banner zone code",
        label: "name",
        "track-by": "code"
      },
      on: {
        input: function input($event) {
          return _vm.onChangeBannerZoneDropdown($event);
        }
      },
      model: {
        value: attribute.value,
        callback: function callback($$v) {
          _vm.$set(attribute, "value", $$v);
        },
        expression: "attribute.value"
      }
    })], 1) : _vm._e(), _vm._v(" "), attribute.type === "banner-code" && _vm.$parent.showBannerCode ? _c("div", {
      staticClass: "d-block"
    }, [_c("multiselect", {
      attrs: {
        id: attribute.name,
        options: _vm.bannerItemCodeOptions,
        placeholder: "Select a banner item code",
        label: "code",
        "track-by": "code"
      },
      model: {
        value: attribute.value,
        callback: function callback($$v) {
          _vm.$set(attribute, "value", $$v);
        },
        expression: "attribute.value"
      }
    })], 1) : _vm._e(), _vm._v(" "), attribute.type === "content-dropdown" ? _c("div", {
      staticClass: "d-block"
    }, [_c("multiselect", {
      attrs: {
        id: attribute.name,
        options: _vm.contentOptions,
        placeholder: "Select a content",
        label: "name",
        "track-by": "name"
      },
      model: {
        value: attribute.value,
        callback: function callback($$v) {
          _vm.$set(attribute, "value", $$v);
        },
        expression: "attribute.value"
      }
    })], 1) : _vm._e(), _vm._v(" "), attribute.type === "menugroup-dropdown" ? _c("div", {
      staticClass: "d-block"
    }, [_c("multiselect", {
      attrs: {
        id: attribute.name,
        options: _vm.menuGroupOptions,
        placeholder: "Select a menu group",
        label: "name",
        "track-by": "name"
      },
      model: {
        value: attribute.value,
        callback: function callback($$v) {
          _vm.$set(attribute, "value", $$v);
        },
        expression: "attribute.value"
      }
    })], 1) : _vm._e(), _vm._v(" "), attribute.type === "page-dropdown" ? _c("div", {
      staticClass: "d-block"
    }, [_c("multiselect", {
      attrs: {
        id: attribute.name,
        options: _vm.pageOptions,
        placeholder: "Select a page",
        label: "name",
        "group-values": "pages",
        "group-label": "name",
        "track-by": "id"
      },
      model: {
        value: attribute.value,
        callback: function callback($$v) {
          _vm.$set(attribute, "value", $$v);
        },
        expression: "attribute.value"
      }
    })], 1) : _vm._e(), _vm._v(" "), attribute.type === "category-dropdown" ? _c("div", {
      staticClass: "d-block"
    }, [_c("multiselect", {
      attrs: {
        id: attribute.name,
        options: _vm.categoryOptions,
        searchable: true,
        multiple: true,
        placeholder: "Select Category",
        label: "value",
        "track-by": "id"
      },
      model: {
        value: attribute.value,
        callback: function callback($$v) {
          _vm.$set(attribute, "value", $$v);
        },
        expression: "attribute.value"
      }
    }, [_vm._v("\n                                        >\n                                    ")])], 1) : _vm._e(), _vm._v(" "), attribute.type === "array" && typeof attribute.array_format == "undefined" ? _c("div", {
      staticClass: "d-block"
    }, [_vm._l(attribute.value, function (item, indexOfvalue) {
      return _c("div", {
        key: indexOfvalue,
        staticClass: "row"
      }, [_c("div", {
        staticClass: "col"
      }, [_c("label", [_vm._v(_vm._s("".concat(_vm.makeTitleCase(attribute.name), "-").concat(indexOfvalue + 1)))]), _vm._v(" "), _c("input", {
        directives: [{
          name: "model",
          rawName: "v-model",
          value: attribute.value[indexOfvalue],
          expression: "attribute.value[indexOfvalue]"
        }],
        staticClass: "form-control",
        attrs: {
          type: "text"
        },
        domProps: {
          value: attribute.value[indexOfvalue]
        },
        on: {
          input: function input($event) {
            if ($event.target.composing) return;
            _vm.$set(attribute.value, indexOfvalue, $event.target.value);
          }
        }
      })]), _vm._v(" "), attribute.value.length > 1 ? _c("div", {
        staticClass: "col-auto"
      }, [_c("button", {
        staticClass: "btn btn-danger",
        staticStyle: {
          "margin-top": "2.5rem"
        },
        on: {
          click: function click($event) {
            return attribute.value.splice(indexOfvalue, 1);
          }
        }
      }, [_c("i", {
        staticClass: "la la-remove"
      })])]) : _vm._e()]);
    }), _vm._v(" "), _c("button", {
      staticClass: "btn btn-success float-right",
      on: {
        click: function click($event) {
          return _vm.addArrayItem(attribute.value);
        }
      }
    }, [_c("i", {
      staticClass: "la la-plus"
    })])], 2) : _vm._e(), _vm._v(" "), attribute.type === "array" && typeof attribute.array_format != "undefined" ? _c("div", {
      staticClass: "d-block"
    }, [_vm._l(attribute.value, function (item, indexOfvalue) {
      return _c("div", {
        key: indexOfvalue,
        staticClass: "d-flex bg-secondary my-2 rounded border"
      }, [_vm._l(attribute.array_format, function (format, indexOfFormat) {
        return _c("div", {
          key: indexOfFormat,
          staticClass: "mt-2 mb-3 col-md"
        }, [_c("label", [_vm._v(_vm._s(_vm.makeTitleCase(format.name)))]), _vm._v(" "), format.type === "checkbox" && format.type !== "select" ? _c("input", {
          directives: [{
            name: "model",
            rawName: "v-model",
            value: item[format.name],
            expression: "item[format.name]"
          }],
          staticClass: "form-control",
          attrs: {
            type: "checkbox"
          },
          domProps: {
            checked: Array.isArray(item[format.name]) ? _vm._i(item[format.name], null) > -1 : item[format.name]
          },
          on: {
            change: function change($event) {
              var $$a = item[format.name],
                $$el = $event.target,
                $$c = $$el.checked ? true : false;
              if (Array.isArray($$a)) {
                var $$v = null,
                  $$i = _vm._i($$a, $$v);
                if ($$el.checked) {
                  $$i < 0 && _vm.$set(item, format.name, $$a.concat([$$v]));
                } else {
                  $$i > -1 && _vm.$set(item, format.name, $$a.slice(0, $$i).concat($$a.slice($$i + 1)));
                }
              } else {
                _vm.$set(item, format.name, $$c);
              }
            }
          }
        }) : format.type === "radio" && format.type !== "select" ? _c("input", {
          directives: [{
            name: "model",
            rawName: "v-model",
            value: item[format.name],
            expression: "item[format.name]"
          }],
          staticClass: "form-control",
          attrs: {
            type: "radio"
          },
          domProps: {
            checked: _vm._q(item[format.name], null)
          },
          on: {
            change: function change($event) {
              return _vm.$set(item, format.name, null);
            }
          }
        }) : format.type !== "select" ? _c("input", {
          directives: [{
            name: "model",
            rawName: "v-model",
            value: item[format.name],
            expression: "item[format.name]"
          }],
          staticClass: "form-control",
          attrs: {
            type: format.type
          },
          domProps: {
            value: item[format.name]
          },
          on: {
            input: function input($event) {
              if ($event.target.composing) return;
              _vm.$set(item, format.name, $event.target.value);
            }
          }
        }) : _c("select", {
          directives: [{
            name: "model",
            rawName: "v-model",
            value: item[format.name],
            expression: "item[format.name]"
          }],
          staticClass: "form-control custom-select",
          on: {
            change: function change($event) {
              var $$selectedVal = Array.prototype.filter.call($event.target.options, function (o) {
                return o.selected;
              }).map(function (o) {
                var val = "_value" in o ? o._value : o.value;
                return val;
              });
              _vm.$set(item, format.name, $event.target.multiple ? $$selectedVal : $$selectedVal[0]);
            }
          }
        }, _vm._l(format.options, function (option, indexOfOption) {
          return _c("option", {
            key: indexOfOption,
            domProps: {
              value: option.value,
              selected: format.value === option.value
            }
          }, [_vm._v("\n                                                    " + _vm._s(option.name) + "\n                                                ")]);
        }), 0)]);
      }), _vm._v(" "), attribute.value.length > 1 ? _c("div", {
        staticClass: "col-auto"
      }, [_c("button", {
        staticClass: "btn btn-danger",
        staticStyle: {
          "margin-top": "2rem"
        },
        on: {
          click: function click($event) {
            return attribute.value.splice(indexOfvalue, 1);
          }
        }
      }, [_c("i", {
        staticClass: "la la-remove"
      })])]) : _vm._e()], 2);
    }), _vm._v(" "), _c("button", {
      staticClass: "btn btn-success float-right",
      on: {
        click: function click($event) {
          return _vm.addArrayItem(attribute.value, attribute.array_format);
        }
      }
    }, [_c("i", {
      staticClass: "la la-plus"
    })])], 2) : _vm._e(), _vm._v(" "), attribute.type === "image" ? _c("div", {
      staticClass: "d-block"
    }, [_c("div", {
      staticClass: "d-flex"
    }, [_c("div", {
      staticClass: "w-75"
    }, [_c("input", {
      directives: [{
        name: "model",
        rawName: "v-model",
        value: attribute.value,
        expression: "attribute.value"
      }],
      staticClass: "form-control",
      attrs: {
        placeholder: "upload path",
        type: "text"
      },
      domProps: {
        value: attribute.value
      },
      on: {
        input: function input($event) {
          if ($event.target.composing) return;
          _vm.$set(attribute, "value", $event.target.value);
        }
      }
    })]), _vm._v(" "), _c("div", {
      staticClass: "w-25 text-center px-3 m-auto"
    }, [_c("div", {
      staticClass: "btn-group"
    }, [_c("label", {
      staticClass: "btn btn-light btn-sm btn-file py-2 mb-0 cursor-pointer",
      attrs: {
        title: "select file",
        "for": "main-image-browse"
      }
    }, [_c("i", {
      staticClass: "la la-hand-pointer"
    }), _vm._v(_vm._s(_vm.titles.choose_file) + "\n                                                    "), _c("input", {
      staticClass: "form-control d-none file_design",
      attrs: {
        id: "main-image-browse",
        type: "text",
        title: "select file"
      },
      on: {
        click: function click($event) {
          _vm.showFileManagerIFrame = !_vm.showFileManagerIFrame;
          _vm.processImagesByType(indexOfAttributes);
          _vm.canMultiple = false;
        }
      }
    })]), _vm._v(" "), _c("button", {
      staticClass: "btn btn-danger btn-sm",
      attrs: {
        "data-handle": "remove",
        type: "button"
      },
      on: {
        click: function click($event) {
          return _vm.deleteImage(indexOfAttributes);
        }
      }
    }, [_c("i", {
      staticClass: "la la-trash"
    })])])])])]) : _vm._e(), _vm._v(" "), _c("small", {
      directives: [{
        name: "show",
        rawName: "v-show",
        value: typeof attribute.hint != "undefined",
        expression: "typeof attribute.hint != 'undefined'"
      }],
      staticClass: "text-muted font-italic"
    }, [_c("span", {
      staticClass: "font-weight-bold"
    }, [_vm._v("Hint:")]), _vm._v(" " + _vm._s(attribute.hint) + "\n                                ")])]);
  }), 0) : _vm._e(), _vm._v(" "), _vm.showNestedItems ? _c("div", {
    staticClass: "border rounded p-3"
  }, [_vm._m(0), _vm._v(" "), _vm._l(_vm.widget["@nestedItems"], function (nestedItem, indexOfNestedItems) {
    return _c("div", {
      key: indexOfNestedItems,
      staticClass: "mb-3"
    }, [_c("fieldset", {
      staticClass: "form-group border p-3"
    }, [_c("legend", {
      staticClass: "w-auto px-2",
      staticStyle: {
        "font-size": "1rem !important"
      }
    }, [_c("strong", [_vm._v("\n                                            " + _vm._s(_vm.makeTitleCase(nestedItem.name)) + "\n                                        ")])]), _vm._v(" "), nestedItem["@inside"] ? _c("div", {
      staticClass: "form-row"
    }, [_c("div", {
      staticClass: "form-group col-12"
    }, [_vm._m(1, true), _vm._v(" "), _c("input", {
      directives: [{
        name: "model",
        rawName: "v-model",
        value: nestedItem["@inside"],
        expression: "nestedItem['@inside']"
      }],
      staticClass: "form-control",
      attrs: {
        type: "text"
      },
      domProps: {
        value: nestedItem["@inside"]
      },
      on: {
        input: function input($event) {
          if ($event.target.composing) return;
          _vm.$set(nestedItem, "@inside", $event.target.value);
        }
      }
    })])]) : _vm._e(), _vm._v(" "), nestedItem["@attributes"].length > 0 ? _c("div", _vm._l(nestedItem["@attributes"], function (attribute, indexOfAtt) {
      return _c("div", {
        key: indexOfAtt,
        staticClass: "form-row"
      }, [attribute.type === "boolean" ? _c("div", {
        staticClass: "form-group col-12"
      }, [_c("label", [_c("strong", [_vm._v("\n                                                        " + _vm._s(_vm.makeTitleCase(attribute.name)) + "\n                                                    ")])]), _vm._v(" "), _c("div", [_c("div", {
        staticClass: "form-check form-check-inline"
      }, [_c("input", {
        directives: [{
          name: "model",
          rawName: "v-model",
          value: attribute.value,
          expression: "attribute.value"
        }],
        staticClass: "form-check-input",
        attrs: {
          type: "radio",
          value: "true",
          name: attribute.name
        },
        domProps: {
          checked: _vm._q(attribute.value, "true")
        },
        on: {
          change: function change($event) {
            return _vm.$set(attribute, "value", "true");
          }
        }
      }), _vm._v(" "), _c("label", {
        staticClass: "form-check-label"
      }, [_vm._v("Yes")])]), _vm._v(" "), _c("div", {
        staticClass: "form-check form-check-inline"
      }, [_c("input", {
        directives: [{
          name: "model",
          rawName: "v-model",
          value: attribute.value,
          expression: "attribute.value"
        }],
        staticClass: "form-check-input",
        attrs: {
          type: "radio",
          value: "false",
          name: attribute.name
        },
        domProps: {
          checked: _vm._q(attribute.value, "false")
        },
        on: {
          change: function change($event) {
            return _vm.$set(attribute, "value", "false");
          }
        }
      }), _vm._v(" "), _c("label", {
        staticClass: "form-check-label"
      }, [_vm._v("No")])])])]) : _vm._e(), _vm._v(" "), attribute.type === "text" ? _c("div", {
        staticClass: "form-group col-12"
      }, [_c("label", [_c("strong", [_vm._v("\n                                                        " + _vm._s(_vm.makeTitleCase(attribute.name)) + "\n                                                    ")])]), _vm._v(" "), _c("input", {
        directives: [{
          name: "model",
          rawName: "v-model",
          value: attribute.value,
          expression: "attribute.value"
        }],
        staticClass: "form-control",
        attrs: {
          type: "text"
        },
        domProps: {
          value: attribute.value
        },
        on: {
          input: function input($event) {
            if ($event.target.composing) return;
            _vm.$set(attribute, "value", $event.target.value);
          }
        }
      })]) : _vm._e(), _vm._v(" "), attribute.type === "select" ? _c("div", [_c("select", {
        directives: [{
          name: "model",
          rawName: "v-model",
          value: attribute.value,
          expression: "attribute.value"
        }],
        staticClass: "form-control custom-select",
        attrs: {
          id: attribute.name
        },
        on: {
          change: function change($event) {
            var $$selectedVal = Array.prototype.filter.call($event.target.options, function (o) {
              return o.selected;
            }).map(function (o) {
              var val = "_value" in o ? o._value : o.value;
              return val;
            });
            _vm.$set(attribute, "value", $event.target.multiple ? $$selectedVal : $$selectedVal[0]);
          }
        }
      }, [_c("option", {
        attrs: {
          value: ""
        }
      }, [_vm._v("Select an option")]), _vm._v(" "), _vm._l(attribute.options, function (option, value) {
        return _c("option", {
          key: value,
          domProps: {
            value: value,
            selected: value === attribute.value
          }
        }, [_vm._v("\n                                                        " + _vm._s(option) + "\n                                                    ")]);
      })], 2)]) : _vm._e()]);
    }), 0) : _vm._e()])]);
  })], 2) : _vm._e(), _vm._v(" "), !_vm.widget["@inside"] && !_vm.showAttributes && !_vm.showNestedItems ? _c("div", {
    staticClass: "form-row"
  }, [_c("div", {
    staticClass: "col-12 text-center"
  }, [_vm._v("No attributes / nested items found")])]) : _vm._e()]) : _vm._e()]), _vm._v(" "), _c("div", {
    staticClass: "modal-footer"
  }, [_c("button", {
    staticClass: "btn btn-secondary",
    attrs: {
      type: "button",
      "data-dismiss": "modal",
      "aria-label": "Close",
      id: "cancelWidgetAttributesModalBtn"
    },
    on: {
      click: function click($event) {
        _vm.modalShade = "";
        _vm.resetWidgetData();
      }
    }
  }, [_vm._v("\n                        Cancel\n                    ")]), _vm._v(" "), _c("button", {
    staticClass: "btn btn-primary",
    attrs: {
      type: "button",
      id: "saveButton"
    },
    on: {
      click: function click($event) {
        return _vm.saveData();
      }
    }
  }, [_vm._v("\n                        Generate Widget\n                    ")])])])])]), _vm._v(" "), _c("div", {
    domProps: {
      innerHTML: _vm._s(_vm.modalShade)
    }
  })]);
};
var staticRenderFns = [function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("h5", [_c("span", {
    staticClass: "text"
  }, [_vm._v("Nested Tags")])]);
}, function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("label", [_c("strong", [_vm._v(" Inside text of the tag ")])]);
}];
render._withStripped = true;


/***/ }),

/***/ "./resources/vue/allDisks.mixin.js":
/*!*****************************************!*\
  !*** ./resources/vue/allDisks.mixin.js ***!
  \*****************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
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

/***/ "./node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-12.use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/laravel-mix/node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-12.use[2]!./node_modules/sass-loader/dist/cjs.js??clonedRuleSet-12.use[3]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/pages/pages/FormFields.vue?vue&type=style&index=0&id=c054ba96&lang=scss":
/*!*****************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-12.use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/laravel-mix/node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-12.use[2]!./node_modules/sass-loader/dist/cjs.js??clonedRuleSet-12.use[3]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/pages/pages/FormFields.vue?vue&type=style&index=0&id=c054ba96&lang=scss ***!
  \*****************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_laravel_mix_node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../../../../node_modules/laravel-mix/node_modules/css-loader/dist/runtime/api.js */ "./node_modules/laravel-mix/node_modules/css-loader/dist/runtime/api.js");
/* harmony import */ var _node_modules_laravel_mix_node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_laravel_mix_node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0__);
// Imports

var ___CSS_LOADER_EXPORT___ = _node_modules_laravel_mix_node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0___default()(function(i){return i[1]});
// Module
___CSS_LOADER_EXPORT___.push([module.id, ".my-editor {\n  background: #2d2d2d;\n  color: #ccc !important;\n  font-family: Consolas, Menlo, Courier, monospace;\n  font-size: 14px;\n  line-height: 1.5;\n  padding: 5px;\n  border-radius: 4px !important;\n  min-height: 350px !important;\n}\n.prism-editor__textarea:focus {\n  outline: none;\n}\npre.prism-editor__editor {\n  color: #ffc107 !important;\n}", ""]);
// Exports
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (___CSS_LOADER_EXPORT___);


/***/ }),

/***/ "./node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!./node_modules/laravel-mix/node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!./node_modules/prismjs/themes/prism-okaidia.css":
/*!*****************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!./node_modules/laravel-mix/node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!./node_modules/prismjs/themes/prism-okaidia.css ***!
  \*****************************************************************************************************************************************************************************************************************************************/
/***/ ((module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _laravel_mix_node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../laravel-mix/node_modules/css-loader/dist/runtime/api.js */ "./node_modules/laravel-mix/node_modules/css-loader/dist/runtime/api.js");
/* harmony import */ var _laravel_mix_node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_laravel_mix_node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0__);
// Imports

var ___CSS_LOADER_EXPORT___ = _laravel_mix_node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0___default()(function(i){return i[1]});
// Module
___CSS_LOADER_EXPORT___.push([module.id, "/**\n * okaidia theme for JavaScript, CSS and HTML\n * Loosely based on Monokai textmate theme by http://www.monokai.nl/\n * @author ocodia\n */\n\ncode[class*=\"language-\"],\npre[class*=\"language-\"] {\n\tcolor: #f8f8f2;\n\tbackground: none;\n\ttext-shadow: 0 1px rgba(0, 0, 0, 0.3);\n\tfont-family: Consolas, Monaco, 'Andale Mono', 'Ubuntu Mono', monospace;\n\tfont-size: 1em;\n\ttext-align: left;\n\twhite-space: pre;\n\tword-spacing: normal;\n\tword-break: normal;\n\tword-wrap: normal;\n\tline-height: 1.5;\n\n\t-moz-tab-size: 4;\n\t-o-tab-size: 4;\n\ttab-size: 4;\n\n\t-webkit-hyphens: none;\n\thyphens: none;\n}\n\n/* Code blocks */\npre[class*=\"language-\"] {\n\tpadding: 1em;\n\tmargin: .5em 0;\n\toverflow: auto;\n\tborder-radius: 0.3em;\n}\n\n:not(pre) > code[class*=\"language-\"],\npre[class*=\"language-\"] {\n\tbackground: #272822;\n}\n\n/* Inline code */\n:not(pre) > code[class*=\"language-\"] {\n\tpadding: .1em;\n\tborder-radius: .3em;\n\twhite-space: normal;\n}\n\n.token.comment,\n.token.prolog,\n.token.doctype,\n.token.cdata {\n\tcolor: #8292a2;\n}\n\n.token.punctuation {\n\tcolor: #f8f8f2;\n}\n\n.token.namespace {\n\topacity: .7;\n}\n\n.token.property,\n.token.tag,\n.token.constant,\n.token.symbol,\n.token.deleted {\n\tcolor: #f92672;\n}\n\n.token.boolean,\n.token.number {\n\tcolor: #ae81ff;\n}\n\n.token.selector,\n.token.attr-name,\n.token.string,\n.token.char,\n.token.builtin,\n.token.inserted {\n\tcolor: #a6e22e;\n}\n\n.token.operator,\n.token.entity,\n.token.url,\n.language-css .token.string,\n.style .token.string,\n.token.variable {\n\tcolor: #f8f8f2;\n}\n\n.token.atrule,\n.token.attr-value,\n.token.function,\n.token.class-name {\n\tcolor: #e6db74;\n}\n\n.token.keyword {\n\tcolor: #66d9ef;\n}\n\n.token.regex,\n.token.important {\n\tcolor: #fd971f;\n}\n\n.token.important,\n.token.bold {\n\tfont-weight: bold;\n}\n.token.italic {\n\tfont-style: italic;\n}\n\n.token.entity {\n\tcursor: help;\n}\n", ""]);
// Exports
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (___CSS_LOADER_EXPORT___);


/***/ }),

/***/ "./node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!./node_modules/laravel-mix/node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!./node_modules/prismjs/themes/prism-tomorrow.css":
/*!******************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!./node_modules/laravel-mix/node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!./node_modules/prismjs/themes/prism-tomorrow.css ***!
  \******************************************************************************************************************************************************************************************************************************************/
/***/ ((module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _laravel_mix_node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../laravel-mix/node_modules/css-loader/dist/runtime/api.js */ "./node_modules/laravel-mix/node_modules/css-loader/dist/runtime/api.js");
/* harmony import */ var _laravel_mix_node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_laravel_mix_node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0__);
// Imports

var ___CSS_LOADER_EXPORT___ = _laravel_mix_node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0___default()(function(i){return i[1]});
// Module
___CSS_LOADER_EXPORT___.push([module.id, "/**\n * prism.js tomorrow night eighties for JavaScript, CoffeeScript, CSS and HTML\n * Based on https://github.com/chriskempson/tomorrow-theme\n * @author Rose Pritchard\n */\n\ncode[class*=\"language-\"],\npre[class*=\"language-\"] {\n\tcolor: #ccc;\n\tbackground: none;\n\tfont-family: Consolas, Monaco, 'Andale Mono', 'Ubuntu Mono', monospace;\n\tfont-size: 1em;\n\ttext-align: left;\n\twhite-space: pre;\n\tword-spacing: normal;\n\tword-break: normal;\n\tword-wrap: normal;\n\tline-height: 1.5;\n\n\t-moz-tab-size: 4;\n\t-o-tab-size: 4;\n\ttab-size: 4;\n\n\t-webkit-hyphens: none;\n\thyphens: none;\n\n}\n\n/* Code blocks */\npre[class*=\"language-\"] {\n\tpadding: 1em;\n\tmargin: .5em 0;\n\toverflow: auto;\n}\n\n:not(pre) > code[class*=\"language-\"],\npre[class*=\"language-\"] {\n\tbackground: #2d2d2d;\n}\n\n/* Inline code */\n:not(pre) > code[class*=\"language-\"] {\n\tpadding: .1em;\n\tborder-radius: .3em;\n\twhite-space: normal;\n}\n\n.token.comment,\n.token.block-comment,\n.token.prolog,\n.token.doctype,\n.token.cdata {\n\tcolor: #999;\n}\n\n.token.punctuation {\n\tcolor: #ccc;\n}\n\n.token.tag,\n.token.attr-name,\n.token.namespace,\n.token.deleted {\n\tcolor: #e2777a;\n}\n\n.token.function-name {\n\tcolor: #6196cc;\n}\n\n.token.boolean,\n.token.number,\n.token.function {\n\tcolor: #f08d49;\n}\n\n.token.property,\n.token.class-name,\n.token.constant,\n.token.symbol {\n\tcolor: #f8c555;\n}\n\n.token.selector,\n.token.important,\n.token.atrule,\n.token.keyword,\n.token.builtin {\n\tcolor: #cc99cd;\n}\n\n.token.string,\n.token.char,\n.token.attr-value,\n.token.regex,\n.token.variable {\n\tcolor: #7ec699;\n}\n\n.token.operator,\n.token.entity,\n.token.url {\n\tcolor: #67cdcc;\n}\n\n.token.important,\n.token.bold {\n\tfont-weight: bold;\n}\n.token.italic {\n\tfont-style: italic;\n}\n\n.token.entity {\n\tcursor: help;\n}\n\n.token.inserted {\n\tcolor: green;\n}\n", ""]);
// Exports
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (___CSS_LOADER_EXPORT___);


/***/ }),

/***/ "./node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!./node_modules/laravel-mix/node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!./node_modules/vue-prism-editor/dist/prismeditor.min.css":
/*!**************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!./node_modules/laravel-mix/node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!./node_modules/vue-prism-editor/dist/prismeditor.min.css ***!
  \**************************************************************************************************************************************************************************************************************************************************/
/***/ ((module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _laravel_mix_node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../laravel-mix/node_modules/css-loader/dist/runtime/api.js */ "./node_modules/laravel-mix/node_modules/css-loader/dist/runtime/api.js");
/* harmony import */ var _laravel_mix_node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_laravel_mix_node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0__);
// Imports

var ___CSS_LOADER_EXPORT___ = _laravel_mix_node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0___default()(function(i){return i[1]});
// Module
___CSS_LOADER_EXPORT___.push([module.id, ".prism-editor-wrapper{width:100%;height:100%;display:flex;align-items:flex-start;overflow:auto;-o-tab-size:1.5em;tab-size:1.5em;-moz-tab-size:1.5em}@media (-ms-high-contrast:active),(-ms-high-contrast:none){.prism-editor-wrapper .prism-editor__textarea{color:transparent!important}.prism-editor-wrapper .prism-editor__textarea::-moz-selection{background-color:#accef7!important;color:transparent!important}.prism-editor-wrapper .prism-editor__textarea::selection{background-color:#accef7!important;color:transparent!important}}.prism-editor-wrapper .prism-editor__container{position:relative;text-align:left;box-sizing:border-box;padding:0;overflow:hidden;width:100%}.prism-editor-wrapper .prism-editor__line-numbers{height:100%;overflow:hidden;flex-shrink:0;padding-top:4px;margin-top:0;margin-right:10px}.prism-editor-wrapper .prism-editor__line-number{text-align:right;white-space:nowrap}.prism-editor-wrapper .prism-editor__textarea{position:absolute;top:0;left:0;height:100%;width:100%;resize:none;color:inherit;overflow:hidden;-moz-osx-font-smoothing:grayscale;-webkit-font-smoothing:antialiased;-webkit-text-fill-color:transparent}.prism-editor-wrapper .prism-editor__editor,.prism-editor-wrapper .prism-editor__textarea{margin:0;border:0;background:none;box-sizing:inherit;display:inherit;font-family:inherit;font-size:inherit;font-style:inherit;font-variant-ligatures:inherit;font-weight:inherit;letter-spacing:inherit;line-height:inherit;-moz-tab-size:inherit;-o-tab-size:inherit;tab-size:inherit;text-indent:inherit;text-rendering:inherit;text-transform:inherit;white-space:pre-wrap;word-wrap:keep-all;overflow-wrap:break-word;padding:0}.prism-editor-wrapper .prism-editor__textarea--empty{-webkit-text-fill-color:inherit!important}.prism-editor-wrapper .prism-editor__editor{position:relative;pointer-events:none}", ""]);
// Exports
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (___CSS_LOADER_EXPORT___);


/***/ }),

/***/ "./node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/laravel-mix/node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/pages/pages/Create.vue?vue&type=style&index=0&id=12322794&scoped=true&lang=css":
/*!******************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/laravel-mix/node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/pages/pages/Create.vue?vue&type=style&index=0&id=12322794&scoped=true&lang=css ***!
  \******************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_laravel_mix_node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../../../../node_modules/laravel-mix/node_modules/css-loader/dist/runtime/api.js */ "./node_modules/laravel-mix/node_modules/css-loader/dist/runtime/api.js");
/* harmony import */ var _node_modules_laravel_mix_node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_laravel_mix_node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0__);
// Imports

var ___CSS_LOADER_EXPORT___ = _node_modules_laravel_mix_node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0___default()(function(i){return i[1]});
// Module
___CSS_LOADER_EXPORT___.push([module.id, "\n.height-100[data-v-12322794] {\r\n    height: 100px;\n}\n.height-150[data-v-12322794] {\r\n    height: 150px !important;\n}\n.fixed-height[data-v-12322794] {\r\n    height: 300px;\r\n    overflow: auto;\n}\n.btn-clipboard[data-v-12322794] {\r\n    position: absolute;\r\n    top: .5rem;\r\n    right: .5rem;\r\n    z-index: 10;\r\n    display: block;\r\n    padding: .25rem .5rem;\r\n    font-size: 75%;\r\n    color: #ffffff;\r\n    background-color: transparent;\r\n    border: 0;\r\n    border-radius: .25rem;\n}\n.btn-clipboard[data-v-12322794]:hover {\r\n    color: #fff;\r\n    background-color: #ffa000;\n}\n@media (max-width: 991px) {\n.sidebarNav[data-v-12322794] {\r\n        position: relative;\r\n        overflow: hidden;\n}\n.col-lg-4[data-v-12322794] {\r\n        position: fixed;\r\n        top: 110px;\r\n        right: -340px;\r\n        background: #f1f4f8;\r\n        height: 100%;\r\n        width: calc(90% - 15px);\r\n        transition: all .5s;\r\n        max-width: 340px;\r\n        padding: 15px;\r\n        border: 1px solid rgba(0, 40, 100, .12);\r\n        border-radius: 4px;\r\n        box-shadow: 0 0 16px 0 #00000073;\n}\n.sidebarNav .col-lg-4[data-v-12322794] {\r\n        right: 0;\n}\n.custom-sidebar-ar[data-v-12322794] {\r\n        z-index: 9010;\r\n        top: 50%;\r\n        position: fixed;\r\n        right: 0;\r\n        transition: all .5s;\n}\n.sidebarNav .custom-sidebar-ar[data-v-12322794] {\r\n        right: 340px;\n}\n.fixed-nav .col-lg-4[data-v-12322794] {\r\n        top: 0;\n}\n}\r\n", ""]);
// Exports
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (___CSS_LOADER_EXPORT___);


/***/ }),

/***/ "./node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/laravel-mix/node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/pages/pages/WidgetAttributesModal.vue?vue&type=style&index=0&id=1d5c776c&scoped=true&lang=css":
/*!*********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/laravel-mix/node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/pages/pages/WidgetAttributesModal.vue?vue&type=style&index=0&id=1d5c776c&scoped=true&lang=css ***!
  \*********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_laravel_mix_node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../../../../node_modules/laravel-mix/node_modules/css-loader/dist/runtime/api.js */ "./node_modules/laravel-mix/node_modules/css-loader/dist/runtime/api.js");
/* harmony import */ var _node_modules_laravel_mix_node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_laravel_mix_node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0__);
// Imports

var ___CSS_LOADER_EXPORT___ = _node_modules_laravel_mix_node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0___default()(function(i){return i[1]});
// Module
___CSS_LOADER_EXPORT___.push([module.id, "\nh5[data-v-1d5c776c] {\r\n    text-align: center;\r\n    position: relative;\r\n    background-color: #fff;\n}\nh5 .border[data-v-1d5c776c] {\r\n    border-bottom: 3px solid #999;\r\n    position: absolute;\r\n    width: 100%;\r\n    left: 0;\r\n    top: 50%;\r\n    margin-top: -1px;\r\n    z-index: 1;\n}\nh5 .text[data-v-1d5c776c] {\r\n    background-color: #fff;\r\n    position: relative;\r\n    z-index: 2;\r\n    padding: 10px;\r\n    display: inline-block;\n}\r\n", ""]);
// Exports
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (___CSS_LOADER_EXPORT___);


/***/ }),

/***/ "./node_modules/laravel-mix/node_modules/style-loader/dist/cjs.js!./node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-12.use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/laravel-mix/node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-12.use[2]!./node_modules/sass-loader/dist/cjs.js??clonedRuleSet-12.use[3]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/pages/pages/FormFields.vue?vue&type=style&index=0&id=c054ba96&lang=scss":
/*!**********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/laravel-mix/node_modules/style-loader/dist/cjs.js!./node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-12.use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/laravel-mix/node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-12.use[2]!./node_modules/sass-loader/dist/cjs.js??clonedRuleSet-12.use[3]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/pages/pages/FormFields.vue?vue&type=style&index=0&id=c054ba96&lang=scss ***!
  \**********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_laravel_mix_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! !../../../../../node_modules/laravel-mix/node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js */ "./node_modules/laravel-mix/node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js");
/* harmony import */ var _node_modules_laravel_mix_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_laravel_mix_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _node_modules_laravel_mix_node_modules_css_loader_dist_cjs_js_clonedRuleSet_12_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_laravel_mix_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_12_use_2_node_modules_sass_loader_dist_cjs_js_clonedRuleSet_12_use_3_node_modules_vue_loader_lib_index_js_vue_loader_options_FormFields_vue_vue_type_style_index_0_id_c054ba96_lang_scss__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! !!../../../../../node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-12.use[1]!../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../node_modules/laravel-mix/node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-12.use[2]!../../../../../node_modules/sass-loader/dist/cjs.js??clonedRuleSet-12.use[3]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./FormFields.vue?vue&type=style&index=0&id=c054ba96&lang=scss */ "./node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-12.use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/laravel-mix/node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-12.use[2]!./node_modules/sass-loader/dist/cjs.js??clonedRuleSet-12.use[3]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/pages/pages/FormFields.vue?vue&type=style&index=0&id=c054ba96&lang=scss");

            

var options = {};

options.insert = "head";
options.singleton = false;

var update = _node_modules_laravel_mix_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default()(_node_modules_laravel_mix_node_modules_css_loader_dist_cjs_js_clonedRuleSet_12_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_laravel_mix_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_12_use_2_node_modules_sass_loader_dist_cjs_js_clonedRuleSet_12_use_3_node_modules_vue_loader_lib_index_js_vue_loader_options_FormFields_vue_vue_type_style_index_0_id_c054ba96_lang_scss__WEBPACK_IMPORTED_MODULE_1__["default"], options);



/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_laravel_mix_node_modules_css_loader_dist_cjs_js_clonedRuleSet_12_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_laravel_mix_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_12_use_2_node_modules_sass_loader_dist_cjs_js_clonedRuleSet_12_use_3_node_modules_vue_loader_lib_index_js_vue_loader_options_FormFields_vue_vue_type_style_index_0_id_c054ba96_lang_scss__WEBPACK_IMPORTED_MODULE_1__["default"].locals || {});

/***/ }),

/***/ "./node_modules/prismjs/themes/prism-okaidia.css":
/*!*******************************************************!*\
  !*** ./node_modules/prismjs/themes/prism-okaidia.css ***!
  \*******************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _laravel_mix_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! !../../laravel-mix/node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js */ "./node_modules/laravel-mix/node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js");
/* harmony import */ var _laravel_mix_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_laravel_mix_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _laravel_mix_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_use_1_laravel_mix_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_use_2_prism_okaidia_css__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! !!../../laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!../../laravel-mix/node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!./prism-okaidia.css */ "./node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!./node_modules/laravel-mix/node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!./node_modules/prismjs/themes/prism-okaidia.css");

            

var options = {};

options.insert = "head";
options.singleton = false;

var update = _laravel_mix_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default()(_laravel_mix_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_use_1_laravel_mix_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_use_2_prism_okaidia_css__WEBPACK_IMPORTED_MODULE_1__["default"], options);



/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_laravel_mix_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_use_1_laravel_mix_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_use_2_prism_okaidia_css__WEBPACK_IMPORTED_MODULE_1__["default"].locals || {});

/***/ }),

/***/ "./node_modules/prismjs/themes/prism-tomorrow.css":
/*!********************************************************!*\
  !*** ./node_modules/prismjs/themes/prism-tomorrow.css ***!
  \********************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _laravel_mix_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! !../../laravel-mix/node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js */ "./node_modules/laravel-mix/node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js");
/* harmony import */ var _laravel_mix_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_laravel_mix_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _laravel_mix_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_use_1_laravel_mix_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_use_2_prism_tomorrow_css__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! !!../../laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!../../laravel-mix/node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!./prism-tomorrow.css */ "./node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!./node_modules/laravel-mix/node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!./node_modules/prismjs/themes/prism-tomorrow.css");

            

var options = {};

options.insert = "head";
options.singleton = false;

var update = _laravel_mix_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default()(_laravel_mix_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_use_1_laravel_mix_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_use_2_prism_tomorrow_css__WEBPACK_IMPORTED_MODULE_1__["default"], options);



/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_laravel_mix_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_use_1_laravel_mix_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_use_2_prism_tomorrow_css__WEBPACK_IMPORTED_MODULE_1__["default"].locals || {});

/***/ }),

/***/ "./node_modules/vue-prism-editor/dist/prismeditor.min.css":
/*!****************************************************************!*\
  !*** ./node_modules/vue-prism-editor/dist/prismeditor.min.css ***!
  \****************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _laravel_mix_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! !../../laravel-mix/node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js */ "./node_modules/laravel-mix/node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js");
/* harmony import */ var _laravel_mix_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_laravel_mix_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _laravel_mix_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_use_1_laravel_mix_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_use_2_prismeditor_min_css__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! !!../../laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!../../laravel-mix/node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!./prismeditor.min.css */ "./node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!./node_modules/laravel-mix/node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!./node_modules/vue-prism-editor/dist/prismeditor.min.css");

            

var options = {};

options.insert = "head";
options.singleton = false;

var update = _laravel_mix_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default()(_laravel_mix_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_use_1_laravel_mix_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_use_2_prismeditor_min_css__WEBPACK_IMPORTED_MODULE_1__["default"], options);



/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_laravel_mix_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_use_1_laravel_mix_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_use_2_prismeditor_min_css__WEBPACK_IMPORTED_MODULE_1__["default"].locals || {});

/***/ }),

/***/ "./node_modules/laravel-mix/node_modules/style-loader/dist/cjs.js!./node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/laravel-mix/node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/pages/pages/Create.vue?vue&type=style&index=0&id=12322794&scoped=true&lang=css":
/*!***********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/laravel-mix/node_modules/style-loader/dist/cjs.js!./node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/laravel-mix/node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/pages/pages/Create.vue?vue&type=style&index=0&id=12322794&scoped=true&lang=css ***!
  \***********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_laravel_mix_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! !../../../../../node_modules/laravel-mix/node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js */ "./node_modules/laravel-mix/node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js");
/* harmony import */ var _node_modules_laravel_mix_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_laravel_mix_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _node_modules_laravel_mix_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_laravel_mix_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_Create_vue_vue_type_style_index_0_id_12322794_scoped_true_lang_css__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! !!../../../../../node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../node_modules/laravel-mix/node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Create.vue?vue&type=style&index=0&id=12322794&scoped=true&lang=css */ "./node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/laravel-mix/node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/pages/pages/Create.vue?vue&type=style&index=0&id=12322794&scoped=true&lang=css");

            

var options = {};

options.insert = "head";
options.singleton = false;

var update = _node_modules_laravel_mix_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default()(_node_modules_laravel_mix_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_laravel_mix_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_Create_vue_vue_type_style_index_0_id_12322794_scoped_true_lang_css__WEBPACK_IMPORTED_MODULE_1__["default"], options);



/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_laravel_mix_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_laravel_mix_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_Create_vue_vue_type_style_index_0_id_12322794_scoped_true_lang_css__WEBPACK_IMPORTED_MODULE_1__["default"].locals || {});

/***/ }),

/***/ "./node_modules/laravel-mix/node_modules/style-loader/dist/cjs.js!./node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/laravel-mix/node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/pages/pages/WidgetAttributesModal.vue?vue&type=style&index=0&id=1d5c776c&scoped=true&lang=css":
/*!**************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/laravel-mix/node_modules/style-loader/dist/cjs.js!./node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/laravel-mix/node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/pages/pages/WidgetAttributesModal.vue?vue&type=style&index=0&id=1d5c776c&scoped=true&lang=css ***!
  \**************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_laravel_mix_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! !../../../../../node_modules/laravel-mix/node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js */ "./node_modules/laravel-mix/node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js");
/* harmony import */ var _node_modules_laravel_mix_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_laravel_mix_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _node_modules_laravel_mix_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_laravel_mix_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_WidgetAttributesModal_vue_vue_type_style_index_0_id_1d5c776c_scoped_true_lang_css__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! !!../../../../../node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../node_modules/laravel-mix/node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./WidgetAttributesModal.vue?vue&type=style&index=0&id=1d5c776c&scoped=true&lang=css */ "./node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/laravel-mix/node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/pages/pages/WidgetAttributesModal.vue?vue&type=style&index=0&id=1d5c776c&scoped=true&lang=css");

            

var options = {};

options.insert = "head";
options.singleton = false;

var update = _node_modules_laravel_mix_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default()(_node_modules_laravel_mix_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_laravel_mix_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_WidgetAttributesModal_vue_vue_type_style_index_0_id_1d5c776c_scoped_true_lang_css__WEBPACK_IMPORTED_MODULE_1__["default"], options);



/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_laravel_mix_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_laravel_mix_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_WidgetAttributesModal_vue_vue_type_style_index_0_id_1d5c776c_scoped_true_lang_css__WEBPACK_IMPORTED_MODULE_1__["default"].locals || {});

/***/ }),

/***/ "./node_modules/prismjs/components/prism-clike.js":
/*!********************************************************!*\
  !*** ./node_modules/prismjs/components/prism-clike.js ***!
  \********************************************************/
/***/ (() => {

Prism.languages.clike = {
	'comment': [
		{
			pattern: /(^|[^\\])\/\*[\s\S]*?(?:\*\/|$)/,
			lookbehind: true,
			greedy: true
		},
		{
			pattern: /(^|[^\\:])\/\/.*/,
			lookbehind: true,
			greedy: true
		}
	],
	'string': {
		pattern: /(["'])(?:\\(?:\r\n|[\s\S])|(?!\1)[^\\\r\n])*\1/,
		greedy: true
	},
	'class-name': {
		pattern: /(\b(?:class|extends|implements|instanceof|interface|new|trait)\s+|\bcatch\s+\()[\w.\\]+/i,
		lookbehind: true,
		inside: {
			'punctuation': /[.\\]/
		}
	},
	'keyword': /\b(?:break|catch|continue|do|else|finally|for|function|if|in|instanceof|new|null|return|throw|try|while)\b/,
	'boolean': /\b(?:false|true)\b/,
	'function': /\b\w+(?=\()/,
	'number': /\b0x[\da-f]+\b|(?:\b\d+(?:\.\d*)?|\B\.\d+)(?:e[+-]?\d+)?/i,
	'operator': /[<>]=?|[!=]=?=?|--?|\+\+?|&&?|\|\|?|[?*/~^%]/,
	'punctuation': /[{}[\];(),.:]/
};


/***/ }),

/***/ "./node_modules/prismjs/components/prism-core.js":
/*!*******************************************************!*\
  !*** ./node_modules/prismjs/components/prism-core.js ***!
  \*******************************************************/
/***/ ((module, __unused_webpack_exports, __webpack_require__) => {

/// <reference lib="WebWorker"/>

var _self = (typeof window !== 'undefined')
	? window   // if in browser
	: (
		(typeof WorkerGlobalScope !== 'undefined' && self instanceof WorkerGlobalScope)
			? self // if in worker
			: {}   // if in node js
	);

/**
 * Prism: Lightweight, robust, elegant syntax highlighting
 *
 * @license MIT <https://opensource.org/licenses/MIT>
 * @author Lea Verou <https://lea.verou.me>
 * @namespace
 * @public
 */
var Prism = (function (_self) {

	// Private helper vars
	var lang = /(?:^|\s)lang(?:uage)?-([\w-]+)(?=\s|$)/i;
	var uniqueId = 0;

	// The grammar object for plaintext
	var plainTextGrammar = {};


	var _ = {
		/**
		 * By default, Prism will attempt to highlight all code elements (by calling {@link Prism.highlightAll}) on the
		 * current page after the page finished loading. This might be a problem if e.g. you wanted to asynchronously load
		 * additional languages or plugins yourself.
		 *
		 * By setting this value to `true`, Prism will not automatically highlight all code elements on the page.
		 *
		 * You obviously have to change this value before the automatic highlighting started. To do this, you can add an
		 * empty Prism object into the global scope before loading the Prism script like this:
		 *
		 * ```js
		 * window.Prism = window.Prism || {};
		 * Prism.manual = true;
		 * // add a new <script> to load Prism's script
		 * ```
		 *
		 * @default false
		 * @type {boolean}
		 * @memberof Prism
		 * @public
		 */
		manual: _self.Prism && _self.Prism.manual,
		/**
		 * By default, if Prism is in a web worker, it assumes that it is in a worker it created itself, so it uses
		 * `addEventListener` to communicate with its parent instance. However, if you're using Prism manually in your
		 * own worker, you don't want it to do this.
		 *
		 * By setting this value to `true`, Prism will not add its own listeners to the worker.
		 *
		 * You obviously have to change this value before Prism executes. To do this, you can add an
		 * empty Prism object into the global scope before loading the Prism script like this:
		 *
		 * ```js
		 * window.Prism = window.Prism || {};
		 * Prism.disableWorkerMessageHandler = true;
		 * // Load Prism's script
		 * ```
		 *
		 * @default false
		 * @type {boolean}
		 * @memberof Prism
		 * @public
		 */
		disableWorkerMessageHandler: _self.Prism && _self.Prism.disableWorkerMessageHandler,

		/**
		 * A namespace for utility methods.
		 *
		 * All function in this namespace that are not explicitly marked as _public_ are for __internal use only__ and may
		 * change or disappear at any time.
		 *
		 * @namespace
		 * @memberof Prism
		 */
		util: {
			encode: function encode(tokens) {
				if (tokens instanceof Token) {
					return new Token(tokens.type, encode(tokens.content), tokens.alias);
				} else if (Array.isArray(tokens)) {
					return tokens.map(encode);
				} else {
					return tokens.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/\u00a0/g, ' ');
				}
			},

			/**
			 * Returns the name of the type of the given value.
			 *
			 * @param {any} o
			 * @returns {string}
			 * @example
			 * type(null)      === 'Null'
			 * type(undefined) === 'Undefined'
			 * type(123)       === 'Number'
			 * type('foo')     === 'String'
			 * type(true)      === 'Boolean'
			 * type([1, 2])    === 'Array'
			 * type({})        === 'Object'
			 * type(String)    === 'Function'
			 * type(/abc+/)    === 'RegExp'
			 */
			type: function (o) {
				return Object.prototype.toString.call(o).slice(8, -1);
			},

			/**
			 * Returns a unique number for the given object. Later calls will still return the same number.
			 *
			 * @param {Object} obj
			 * @returns {number}
			 */
			objId: function (obj) {
				if (!obj['__id']) {
					Object.defineProperty(obj, '__id', { value: ++uniqueId });
				}
				return obj['__id'];
			},

			/**
			 * Creates a deep clone of the given object.
			 *
			 * The main intended use of this function is to clone language definitions.
			 *
			 * @param {T} o
			 * @param {Record<number, any>} [visited]
			 * @returns {T}
			 * @template T
			 */
			clone: function deepClone(o, visited) {
				visited = visited || {};

				var clone; var id;
				switch (_.util.type(o)) {
					case 'Object':
						id = _.util.objId(o);
						if (visited[id]) {
							return visited[id];
						}
						clone = /** @type {Record<string, any>} */ ({});
						visited[id] = clone;

						for (var key in o) {
							if (o.hasOwnProperty(key)) {
								clone[key] = deepClone(o[key], visited);
							}
						}

						return /** @type {any} */ (clone);

					case 'Array':
						id = _.util.objId(o);
						if (visited[id]) {
							return visited[id];
						}
						clone = [];
						visited[id] = clone;

						(/** @type {Array} */(/** @type {any} */(o))).forEach(function (v, i) {
							clone[i] = deepClone(v, visited);
						});

						return /** @type {any} */ (clone);

					default:
						return o;
				}
			},

			/**
			 * Returns the Prism language of the given element set by a `language-xxxx` or `lang-xxxx` class.
			 *
			 * If no language is set for the element or the element is `null` or `undefined`, `none` will be returned.
			 *
			 * @param {Element} element
			 * @returns {string}
			 */
			getLanguage: function (element) {
				while (element) {
					var m = lang.exec(element.className);
					if (m) {
						return m[1].toLowerCase();
					}
					element = element.parentElement;
				}
				return 'none';
			},

			/**
			 * Sets the Prism `language-xxxx` class of the given element.
			 *
			 * @param {Element} element
			 * @param {string} language
			 * @returns {void}
			 */
			setLanguage: function (element, language) {
				// remove all `language-xxxx` classes
				// (this might leave behind a leading space)
				element.className = element.className.replace(RegExp(lang, 'gi'), '');

				// add the new `language-xxxx` class
				// (using `classList` will automatically clean up spaces for us)
				element.classList.add('language-' + language);
			},

			/**
			 * Returns the script element that is currently executing.
			 *
			 * This does __not__ work for line script element.
			 *
			 * @returns {HTMLScriptElement | null}
			 */
			currentScript: function () {
				if (typeof document === 'undefined') {
					return null;
				}
				if ('currentScript' in document && 1 < 2 /* hack to trip TS' flow analysis */) {
					return /** @type {any} */ (document.currentScript);
				}

				// IE11 workaround
				// we'll get the src of the current script by parsing IE11's error stack trace
				// this will not work for inline scripts

				try {
					throw new Error();
				} catch (err) {
					// Get file src url from stack. Specifically works with the format of stack traces in IE.
					// A stack will look like this:
					//
					// Error
					//    at _.util.currentScript (http://localhost/components/prism-core.js:119:5)
					//    at Global code (http://localhost/components/prism-core.js:606:1)

					var src = (/at [^(\r\n]*\((.*):[^:]+:[^:]+\)$/i.exec(err.stack) || [])[1];
					if (src) {
						var scripts = document.getElementsByTagName('script');
						for (var i in scripts) {
							if (scripts[i].src == src) {
								return scripts[i];
							}
						}
					}
					return null;
				}
			},

			/**
			 * Returns whether a given class is active for `element`.
			 *
			 * The class can be activated if `element` or one of its ancestors has the given class and it can be deactivated
			 * if `element` or one of its ancestors has the negated version of the given class. The _negated version_ of the
			 * given class is just the given class with a `no-` prefix.
			 *
			 * Whether the class is active is determined by the closest ancestor of `element` (where `element` itself is
			 * closest ancestor) that has the given class or the negated version of it. If neither `element` nor any of its
			 * ancestors have the given class or the negated version of it, then the default activation will be returned.
			 *
			 * In the paradoxical situation where the closest ancestor contains __both__ the given class and the negated
			 * version of it, the class is considered active.
			 *
			 * @param {Element} element
			 * @param {string} className
			 * @param {boolean} [defaultActivation=false]
			 * @returns {boolean}
			 */
			isActive: function (element, className, defaultActivation) {
				var no = 'no-' + className;

				while (element) {
					var classList = element.classList;
					if (classList.contains(className)) {
						return true;
					}
					if (classList.contains(no)) {
						return false;
					}
					element = element.parentElement;
				}
				return !!defaultActivation;
			}
		},

		/**
		 * This namespace contains all currently loaded languages and the some helper functions to create and modify languages.
		 *
		 * @namespace
		 * @memberof Prism
		 * @public
		 */
		languages: {
			/**
			 * The grammar for plain, unformatted text.
			 */
			plain: plainTextGrammar,
			plaintext: plainTextGrammar,
			text: plainTextGrammar,
			txt: plainTextGrammar,

			/**
			 * Creates a deep copy of the language with the given id and appends the given tokens.
			 *
			 * If a token in `redef` also appears in the copied language, then the existing token in the copied language
			 * will be overwritten at its original position.
			 *
			 * ## Best practices
			 *
			 * Since the position of overwriting tokens (token in `redef` that overwrite tokens in the copied language)
			 * doesn't matter, they can technically be in any order. However, this can be confusing to others that trying to
			 * understand the language definition because, normally, the order of tokens matters in Prism grammars.
			 *
			 * Therefore, it is encouraged to order overwriting tokens according to the positions of the overwritten tokens.
			 * Furthermore, all non-overwriting tokens should be placed after the overwriting ones.
			 *
			 * @param {string} id The id of the language to extend. This has to be a key in `Prism.languages`.
			 * @param {Grammar} redef The new tokens to append.
			 * @returns {Grammar} The new language created.
			 * @public
			 * @example
			 * Prism.languages['css-with-colors'] = Prism.languages.extend('css', {
			 *     // Prism.languages.css already has a 'comment' token, so this token will overwrite CSS' 'comment' token
			 *     // at its original position
			 *     'comment': { ... },
			 *     // CSS doesn't have a 'color' token, so this token will be appended
			 *     'color': /\b(?:red|green|blue)\b/
			 * });
			 */
			extend: function (id, redef) {
				var lang = _.util.clone(_.languages[id]);

				for (var key in redef) {
					lang[key] = redef[key];
				}

				return lang;
			},

			/**
			 * Inserts tokens _before_ another token in a language definition or any other grammar.
			 *
			 * ## Usage
			 *
			 * This helper method makes it easy to modify existing languages. For example, the CSS language definition
			 * not only defines CSS highlighting for CSS documents, but also needs to define highlighting for CSS embedded
			 * in HTML through `<style>` elements. To do this, it needs to modify `Prism.languages.markup` and add the
			 * appropriate tokens. However, `Prism.languages.markup` is a regular JavaScript object literal, so if you do
			 * this:
			 *
			 * ```js
			 * Prism.languages.markup.style = {
			 *     // token
			 * };
			 * ```
			 *
			 * then the `style` token will be added (and processed) at the end. `insertBefore` allows you to insert tokens
			 * before existing tokens. For the CSS example above, you would use it like this:
			 *
			 * ```js
			 * Prism.languages.insertBefore('markup', 'cdata', {
			 *     'style': {
			 *         // token
			 *     }
			 * });
			 * ```
			 *
			 * ## Special cases
			 *
			 * If the grammars of `inside` and `insert` have tokens with the same name, the tokens in `inside`'s grammar
			 * will be ignored.
			 *
			 * This behavior can be used to insert tokens after `before`:
			 *
			 * ```js
			 * Prism.languages.insertBefore('markup', 'comment', {
			 *     'comment': Prism.languages.markup.comment,
			 *     // tokens after 'comment'
			 * });
			 * ```
			 *
			 * ## Limitations
			 *
			 * The main problem `insertBefore` has to solve is iteration order. Since ES2015, the iteration order for object
			 * properties is guaranteed to be the insertion order (except for integer keys) but some browsers behave
			 * differently when keys are deleted and re-inserted. So `insertBefore` can't be implemented by temporarily
			 * deleting properties which is necessary to insert at arbitrary positions.
			 *
			 * To solve this problem, `insertBefore` doesn't actually insert the given tokens into the target object.
			 * Instead, it will create a new object and replace all references to the target object with the new one. This
			 * can be done without temporarily deleting properties, so the iteration order is well-defined.
			 *
			 * However, only references that can be reached from `Prism.languages` or `insert` will be replaced. I.e. if
			 * you hold the target object in a variable, then the value of the variable will not change.
			 *
			 * ```js
			 * var oldMarkup = Prism.languages.markup;
			 * var newMarkup = Prism.languages.insertBefore('markup', 'comment', { ... });
			 *
			 * assert(oldMarkup !== Prism.languages.markup);
			 * assert(newMarkup === Prism.languages.markup);
			 * ```
			 *
			 * @param {string} inside The property of `root` (e.g. a language id in `Prism.languages`) that contains the
			 * object to be modified.
			 * @param {string} before The key to insert before.
			 * @param {Grammar} insert An object containing the key-value pairs to be inserted.
			 * @param {Object<string, any>} [root] The object containing `inside`, i.e. the object that contains the
			 * object to be modified.
			 *
			 * Defaults to `Prism.languages`.
			 * @returns {Grammar} The new grammar object.
			 * @public
			 */
			insertBefore: function (inside, before, insert, root) {
				root = root || /** @type {any} */ (_.languages);
				var grammar = root[inside];
				/** @type {Grammar} */
				var ret = {};

				for (var token in grammar) {
					if (grammar.hasOwnProperty(token)) {

						if (token == before) {
							for (var newToken in insert) {
								if (insert.hasOwnProperty(newToken)) {
									ret[newToken] = insert[newToken];
								}
							}
						}

						// Do not insert token which also occur in insert. See #1525
						if (!insert.hasOwnProperty(token)) {
							ret[token] = grammar[token];
						}
					}
				}

				var old = root[inside];
				root[inside] = ret;

				// Update references in other language definitions
				_.languages.DFS(_.languages, function (key, value) {
					if (value === old && key != inside) {
						this[key] = ret;
					}
				});

				return ret;
			},

			// Traverse a language definition with Depth First Search
			DFS: function DFS(o, callback, type, visited) {
				visited = visited || {};

				var objId = _.util.objId;

				for (var i in o) {
					if (o.hasOwnProperty(i)) {
						callback.call(o, i, o[i], type || i);

						var property = o[i];
						var propertyType = _.util.type(property);

						if (propertyType === 'Object' && !visited[objId(property)]) {
							visited[objId(property)] = true;
							DFS(property, callback, null, visited);
						} else if (propertyType === 'Array' && !visited[objId(property)]) {
							visited[objId(property)] = true;
							DFS(property, callback, i, visited);
						}
					}
				}
			}
		},

		plugins: {},

		/**
		 * This is the most high-level function in Prism’s API.
		 * It fetches all the elements that have a `.language-xxxx` class and then calls {@link Prism.highlightElement} on
		 * each one of them.
		 *
		 * This is equivalent to `Prism.highlightAllUnder(document, async, callback)`.
		 *
		 * @param {boolean} [async=false] Same as in {@link Prism.highlightAllUnder}.
		 * @param {HighlightCallback} [callback] Same as in {@link Prism.highlightAllUnder}.
		 * @memberof Prism
		 * @public
		 */
		highlightAll: function (async, callback) {
			_.highlightAllUnder(document, async, callback);
		},

		/**
		 * Fetches all the descendants of `container` that have a `.language-xxxx` class and then calls
		 * {@link Prism.highlightElement} on each one of them.
		 *
		 * The following hooks will be run:
		 * 1. `before-highlightall`
		 * 2. `before-all-elements-highlight`
		 * 3. All hooks of {@link Prism.highlightElement} for each element.
		 *
		 * @param {ParentNode} container The root element, whose descendants that have a `.language-xxxx` class will be highlighted.
		 * @param {boolean} [async=false] Whether each element is to be highlighted asynchronously using Web Workers.
		 * @param {HighlightCallback} [callback] An optional callback to be invoked on each element after its highlighting is done.
		 * @memberof Prism
		 * @public
		 */
		highlightAllUnder: function (container, async, callback) {
			var env = {
				callback: callback,
				container: container,
				selector: 'code[class*="language-"], [class*="language-"] code, code[class*="lang-"], [class*="lang-"] code'
			};

			_.hooks.run('before-highlightall', env);

			env.elements = Array.prototype.slice.apply(env.container.querySelectorAll(env.selector));

			_.hooks.run('before-all-elements-highlight', env);

			for (var i = 0, element; (element = env.elements[i++]);) {
				_.highlightElement(element, async === true, env.callback);
			}
		},

		/**
		 * Highlights the code inside a single element.
		 *
		 * The following hooks will be run:
		 * 1. `before-sanity-check`
		 * 2. `before-highlight`
		 * 3. All hooks of {@link Prism.highlight}. These hooks will be run by an asynchronous worker if `async` is `true`.
		 * 4. `before-insert`
		 * 5. `after-highlight`
		 * 6. `complete`
		 *
		 * Some the above hooks will be skipped if the element doesn't contain any text or there is no grammar loaded for
		 * the element's language.
		 *
		 * @param {Element} element The element containing the code.
		 * It must have a class of `language-xxxx` to be processed, where `xxxx` is a valid language identifier.
		 * @param {boolean} [async=false] Whether the element is to be highlighted asynchronously using Web Workers
		 * to improve performance and avoid blocking the UI when highlighting very large chunks of code. This option is
		 * [disabled by default](https://prismjs.com/faq.html#why-is-asynchronous-highlighting-disabled-by-default).
		 *
		 * Note: All language definitions required to highlight the code must be included in the main `prism.js` file for
		 * asynchronous highlighting to work. You can build your own bundle on the
		 * [Download page](https://prismjs.com/download.html).
		 * @param {HighlightCallback} [callback] An optional callback to be invoked after the highlighting is done.
		 * Mostly useful when `async` is `true`, since in that case, the highlighting is done asynchronously.
		 * @memberof Prism
		 * @public
		 */
		highlightElement: function (element, async, callback) {
			// Find language
			var language = _.util.getLanguage(element);
			var grammar = _.languages[language];

			// Set language on the element, if not present
			_.util.setLanguage(element, language);

			// Set language on the parent, for styling
			var parent = element.parentElement;
			if (parent && parent.nodeName.toLowerCase() === 'pre') {
				_.util.setLanguage(parent, language);
			}

			var code = element.textContent;

			var env = {
				element: element,
				language: language,
				grammar: grammar,
				code: code
			};

			function insertHighlightedCode(highlightedCode) {
				env.highlightedCode = highlightedCode;

				_.hooks.run('before-insert', env);

				env.element.innerHTML = env.highlightedCode;

				_.hooks.run('after-highlight', env);
				_.hooks.run('complete', env);
				callback && callback.call(env.element);
			}

			_.hooks.run('before-sanity-check', env);

			// plugins may change/add the parent/element
			parent = env.element.parentElement;
			if (parent && parent.nodeName.toLowerCase() === 'pre' && !parent.hasAttribute('tabindex')) {
				parent.setAttribute('tabindex', '0');
			}

			if (!env.code) {
				_.hooks.run('complete', env);
				callback && callback.call(env.element);
				return;
			}

			_.hooks.run('before-highlight', env);

			if (!env.grammar) {
				insertHighlightedCode(_.util.encode(env.code));
				return;
			}

			if (async && _self.Worker) {
				var worker = new Worker(_.filename);

				worker.onmessage = function (evt) {
					insertHighlightedCode(evt.data);
				};

				worker.postMessage(JSON.stringify({
					language: env.language,
					code: env.code,
					immediateClose: true
				}));
			} else {
				insertHighlightedCode(_.highlight(env.code, env.grammar, env.language));
			}
		},

		/**
		 * Low-level function, only use if you know what you’re doing. It accepts a string of text as input
		 * and the language definitions to use, and returns a string with the HTML produced.
		 *
		 * The following hooks will be run:
		 * 1. `before-tokenize`
		 * 2. `after-tokenize`
		 * 3. `wrap`: On each {@link Token}.
		 *
		 * @param {string} text A string with the code to be highlighted.
		 * @param {Grammar} grammar An object containing the tokens to use.
		 *
		 * Usually a language definition like `Prism.languages.markup`.
		 * @param {string} language The name of the language definition passed to `grammar`.
		 * @returns {string} The highlighted HTML.
		 * @memberof Prism
		 * @public
		 * @example
		 * Prism.highlight('var foo = true;', Prism.languages.javascript, 'javascript');
		 */
		highlight: function (text, grammar, language) {
			var env = {
				code: text,
				grammar: grammar,
				language: language
			};
			_.hooks.run('before-tokenize', env);
			if (!env.grammar) {
				throw new Error('The language "' + env.language + '" has no grammar.');
			}
			env.tokens = _.tokenize(env.code, env.grammar);
			_.hooks.run('after-tokenize', env);
			return Token.stringify(_.util.encode(env.tokens), env.language);
		},

		/**
		 * This is the heart of Prism, and the most low-level function you can use. It accepts a string of text as input
		 * and the language definitions to use, and returns an array with the tokenized code.
		 *
		 * When the language definition includes nested tokens, the function is called recursively on each of these tokens.
		 *
		 * This method could be useful in other contexts as well, as a very crude parser.
		 *
		 * @param {string} text A string with the code to be highlighted.
		 * @param {Grammar} grammar An object containing the tokens to use.
		 *
		 * Usually a language definition like `Prism.languages.markup`.
		 * @returns {TokenStream} An array of strings and tokens, a token stream.
		 * @memberof Prism
		 * @public
		 * @example
		 * let code = `var foo = 0;`;
		 * let tokens = Prism.tokenize(code, Prism.languages.javascript);
		 * tokens.forEach(token => {
		 *     if (token instanceof Prism.Token && token.type === 'number') {
		 *         console.log(`Found numeric literal: ${token.content}`);
		 *     }
		 * });
		 */
		tokenize: function (text, grammar) {
			var rest = grammar.rest;
			if (rest) {
				for (var token in rest) {
					grammar[token] = rest[token];
				}

				delete grammar.rest;
			}

			var tokenList = new LinkedList();
			addAfter(tokenList, tokenList.head, text);

			matchGrammar(text, tokenList, grammar, tokenList.head, 0);

			return toArray(tokenList);
		},

		/**
		 * @namespace
		 * @memberof Prism
		 * @public
		 */
		hooks: {
			all: {},

			/**
			 * Adds the given callback to the list of callbacks for the given hook.
			 *
			 * The callback will be invoked when the hook it is registered for is run.
			 * Hooks are usually directly run by a highlight function but you can also run hooks yourself.
			 *
			 * One callback function can be registered to multiple hooks and the same hook multiple times.
			 *
			 * @param {string} name The name of the hook.
			 * @param {HookCallback} callback The callback function which is given environment variables.
			 * @public
			 */
			add: function (name, callback) {
				var hooks = _.hooks.all;

				hooks[name] = hooks[name] || [];

				hooks[name].push(callback);
			},

			/**
			 * Runs a hook invoking all registered callbacks with the given environment variables.
			 *
			 * Callbacks will be invoked synchronously and in the order in which they were registered.
			 *
			 * @param {string} name The name of the hook.
			 * @param {Object<string, any>} env The environment variables of the hook passed to all callbacks registered.
			 * @public
			 */
			run: function (name, env) {
				var callbacks = _.hooks.all[name];

				if (!callbacks || !callbacks.length) {
					return;
				}

				for (var i = 0, callback; (callback = callbacks[i++]);) {
					callback(env);
				}
			}
		},

		Token: Token
	};
	_self.Prism = _;


	// Typescript note:
	// The following can be used to import the Token type in JSDoc:
	//
	//   @typedef {InstanceType<import("./prism-core")["Token"]>} Token

	/**
	 * Creates a new token.
	 *
	 * @param {string} type See {@link Token#type type}
	 * @param {string | TokenStream} content See {@link Token#content content}
	 * @param {string|string[]} [alias] The alias(es) of the token.
	 * @param {string} [matchedStr=""] A copy of the full string this token was created from.
	 * @class
	 * @global
	 * @public
	 */
	function Token(type, content, alias, matchedStr) {
		/**
		 * The type of the token.
		 *
		 * This is usually the key of a pattern in a {@link Grammar}.
		 *
		 * @type {string}
		 * @see GrammarToken
		 * @public
		 */
		this.type = type;
		/**
		 * The strings or tokens contained by this token.
		 *
		 * This will be a token stream if the pattern matched also defined an `inside` grammar.
		 *
		 * @type {string | TokenStream}
		 * @public
		 */
		this.content = content;
		/**
		 * The alias(es) of the token.
		 *
		 * @type {string|string[]}
		 * @see GrammarToken
		 * @public
		 */
		this.alias = alias;
		// Copy of the full string this token was created from
		this.length = (matchedStr || '').length | 0;
	}

	/**
	 * A token stream is an array of strings and {@link Token Token} objects.
	 *
	 * Token streams have to fulfill a few properties that are assumed by most functions (mostly internal ones) that process
	 * them.
	 *
	 * 1. No adjacent strings.
	 * 2. No empty strings.
	 *
	 *    The only exception here is the token stream that only contains the empty string and nothing else.
	 *
	 * @typedef {Array<string | Token>} TokenStream
	 * @global
	 * @public
	 */

	/**
	 * Converts the given token or token stream to an HTML representation.
	 *
	 * The following hooks will be run:
	 * 1. `wrap`: On each {@link Token}.
	 *
	 * @param {string | Token | TokenStream} o The token or token stream to be converted.
	 * @param {string} language The name of current language.
	 * @returns {string} The HTML representation of the token or token stream.
	 * @memberof Token
	 * @static
	 */
	Token.stringify = function stringify(o, language) {
		if (typeof o == 'string') {
			return o;
		}
		if (Array.isArray(o)) {
			var s = '';
			o.forEach(function (e) {
				s += stringify(e, language);
			});
			return s;
		}

		var env = {
			type: o.type,
			content: stringify(o.content, language),
			tag: 'span',
			classes: ['token', o.type],
			attributes: {},
			language: language
		};

		var aliases = o.alias;
		if (aliases) {
			if (Array.isArray(aliases)) {
				Array.prototype.push.apply(env.classes, aliases);
			} else {
				env.classes.push(aliases);
			}
		}

		_.hooks.run('wrap', env);

		var attributes = '';
		for (var name in env.attributes) {
			attributes += ' ' + name + '="' + (env.attributes[name] || '').replace(/"/g, '&quot;') + '"';
		}

		return '<' + env.tag + ' class="' + env.classes.join(' ') + '"' + attributes + '>' + env.content + '</' + env.tag + '>';
	};

	/**
	 * @param {RegExp} pattern
	 * @param {number} pos
	 * @param {string} text
	 * @param {boolean} lookbehind
	 * @returns {RegExpExecArray | null}
	 */
	function matchPattern(pattern, pos, text, lookbehind) {
		pattern.lastIndex = pos;
		var match = pattern.exec(text);
		if (match && lookbehind && match[1]) {
			// change the match to remove the text matched by the Prism lookbehind group
			var lookbehindLength = match[1].length;
			match.index += lookbehindLength;
			match[0] = match[0].slice(lookbehindLength);
		}
		return match;
	}

	/**
	 * @param {string} text
	 * @param {LinkedList<string | Token>} tokenList
	 * @param {any} grammar
	 * @param {LinkedListNode<string | Token>} startNode
	 * @param {number} startPos
	 * @param {RematchOptions} [rematch]
	 * @returns {void}
	 * @private
	 *
	 * @typedef RematchOptions
	 * @property {string} cause
	 * @property {number} reach
	 */
	function matchGrammar(text, tokenList, grammar, startNode, startPos, rematch) {
		for (var token in grammar) {
			if (!grammar.hasOwnProperty(token) || !grammar[token]) {
				continue;
			}

			var patterns = grammar[token];
			patterns = Array.isArray(patterns) ? patterns : [patterns];

			for (var j = 0; j < patterns.length; ++j) {
				if (rematch && rematch.cause == token + ',' + j) {
					return;
				}

				var patternObj = patterns[j];
				var inside = patternObj.inside;
				var lookbehind = !!patternObj.lookbehind;
				var greedy = !!patternObj.greedy;
				var alias = patternObj.alias;

				if (greedy && !patternObj.pattern.global) {
					// Without the global flag, lastIndex won't work
					var flags = patternObj.pattern.toString().match(/[imsuy]*$/)[0];
					patternObj.pattern = RegExp(patternObj.pattern.source, flags + 'g');
				}

				/** @type {RegExp} */
				var pattern = patternObj.pattern || patternObj;

				for ( // iterate the token list and keep track of the current token/string position
					var currentNode = startNode.next, pos = startPos;
					currentNode !== tokenList.tail;
					pos += currentNode.value.length, currentNode = currentNode.next
				) {

					if (rematch && pos >= rematch.reach) {
						break;
					}

					var str = currentNode.value;

					if (tokenList.length > text.length) {
						// Something went terribly wrong, ABORT, ABORT!
						return;
					}

					if (str instanceof Token) {
						continue;
					}

					var removeCount = 1; // this is the to parameter of removeBetween
					var match;

					if (greedy) {
						match = matchPattern(pattern, pos, text, lookbehind);
						if (!match || match.index >= text.length) {
							break;
						}

						var from = match.index;
						var to = match.index + match[0].length;
						var p = pos;

						// find the node that contains the match
						p += currentNode.value.length;
						while (from >= p) {
							currentNode = currentNode.next;
							p += currentNode.value.length;
						}
						// adjust pos (and p)
						p -= currentNode.value.length;
						pos = p;

						// the current node is a Token, then the match starts inside another Token, which is invalid
						if (currentNode.value instanceof Token) {
							continue;
						}

						// find the last node which is affected by this match
						for (
							var k = currentNode;
							k !== tokenList.tail && (p < to || typeof k.value === 'string');
							k = k.next
						) {
							removeCount++;
							p += k.value.length;
						}
						removeCount--;

						// replace with the new match
						str = text.slice(pos, p);
						match.index -= pos;
					} else {
						match = matchPattern(pattern, 0, str, lookbehind);
						if (!match) {
							continue;
						}
					}

					// eslint-disable-next-line no-redeclare
					var from = match.index;
					var matchStr = match[0];
					var before = str.slice(0, from);
					var after = str.slice(from + matchStr.length);

					var reach = pos + str.length;
					if (rematch && reach > rematch.reach) {
						rematch.reach = reach;
					}

					var removeFrom = currentNode.prev;

					if (before) {
						removeFrom = addAfter(tokenList, removeFrom, before);
						pos += before.length;
					}

					removeRange(tokenList, removeFrom, removeCount);

					var wrapped = new Token(token, inside ? _.tokenize(matchStr, inside) : matchStr, alias, matchStr);
					currentNode = addAfter(tokenList, removeFrom, wrapped);

					if (after) {
						addAfter(tokenList, currentNode, after);
					}

					if (removeCount > 1) {
						// at least one Token object was removed, so we have to do some rematching
						// this can only happen if the current pattern is greedy

						/** @type {RematchOptions} */
						var nestedRematch = {
							cause: token + ',' + j,
							reach: reach
						};
						matchGrammar(text, tokenList, grammar, currentNode.prev, pos, nestedRematch);

						// the reach might have been extended because of the rematching
						if (rematch && nestedRematch.reach > rematch.reach) {
							rematch.reach = nestedRematch.reach;
						}
					}
				}
			}
		}
	}

	/**
	 * @typedef LinkedListNode
	 * @property {T} value
	 * @property {LinkedListNode<T> | null} prev The previous node.
	 * @property {LinkedListNode<T> | null} next The next node.
	 * @template T
	 * @private
	 */

	/**
	 * @template T
	 * @private
	 */
	function LinkedList() {
		/** @type {LinkedListNode<T>} */
		var head = { value: null, prev: null, next: null };
		/** @type {LinkedListNode<T>} */
		var tail = { value: null, prev: head, next: null };
		head.next = tail;

		/** @type {LinkedListNode<T>} */
		this.head = head;
		/** @type {LinkedListNode<T>} */
		this.tail = tail;
		this.length = 0;
	}

	/**
	 * Adds a new node with the given value to the list.
	 *
	 * @param {LinkedList<T>} list
	 * @param {LinkedListNode<T>} node
	 * @param {T} value
	 * @returns {LinkedListNode<T>} The added node.
	 * @template T
	 */
	function addAfter(list, node, value) {
		// assumes that node != list.tail && values.length >= 0
		var next = node.next;

		var newNode = { value: value, prev: node, next: next };
		node.next = newNode;
		next.prev = newNode;
		list.length++;

		return newNode;
	}
	/**
	 * Removes `count` nodes after the given node. The given node will not be removed.
	 *
	 * @param {LinkedList<T>} list
	 * @param {LinkedListNode<T>} node
	 * @param {number} count
	 * @template T
	 */
	function removeRange(list, node, count) {
		var next = node.next;
		for (var i = 0; i < count && next !== list.tail; i++) {
			next = next.next;
		}
		node.next = next;
		next.prev = node;
		list.length -= i;
	}
	/**
	 * @param {LinkedList<T>} list
	 * @returns {T[]}
	 * @template T
	 */
	function toArray(list) {
		var array = [];
		var node = list.head.next;
		while (node !== list.tail) {
			array.push(node.value);
			node = node.next;
		}
		return array;
	}


	if (!_self.document) {
		if (!_self.addEventListener) {
			// in Node.js
			return _;
		}

		if (!_.disableWorkerMessageHandler) {
			// In worker
			_self.addEventListener('message', function (evt) {
				var message = JSON.parse(evt.data);
				var lang = message.language;
				var code = message.code;
				var immediateClose = message.immediateClose;

				_self.postMessage(_.highlight(code, _.languages[lang], lang));
				if (immediateClose) {
					_self.close();
				}
			}, false);
		}

		return _;
	}

	// Get current script and highlight
	var script = _.util.currentScript();

	if (script) {
		_.filename = script.src;

		if (script.hasAttribute('data-manual')) {
			_.manual = true;
		}
	}

	function highlightAutomaticallyCallback() {
		if (!_.manual) {
			_.highlightAll();
		}
	}

	if (!_.manual) {
		// If the document state is "loading", then we'll use DOMContentLoaded.
		// If the document state is "interactive" and the prism.js script is deferred, then we'll also use the
		// DOMContentLoaded event because there might be some plugins or languages which have also been deferred and they
		// might take longer one animation frame to execute which can create a race condition where only some plugins have
		// been loaded when Prism.highlightAll() is executed, depending on how fast resources are loaded.
		// See https://github.com/PrismJS/prism/issues/2102
		var readyState = document.readyState;
		if (readyState === 'loading' || readyState === 'interactive' && script && script.defer) {
			document.addEventListener('DOMContentLoaded', highlightAutomaticallyCallback);
		} else {
			if (window.requestAnimationFrame) {
				window.requestAnimationFrame(highlightAutomaticallyCallback);
			} else {
				window.setTimeout(highlightAutomaticallyCallback, 16);
			}
		}
	}

	return _;

}(_self));

if ( true && module.exports) {
	module.exports = Prism;
}

// hack for components to work correctly in node.js
if (typeof __webpack_require__.g !== 'undefined') {
	__webpack_require__.g.Prism = Prism;
}

// some additional documentation/types

/**
 * The expansion of a simple `RegExp` literal to support additional properties.
 *
 * @typedef GrammarToken
 * @property {RegExp} pattern The regular expression of the token.
 * @property {boolean} [lookbehind=false] If `true`, then the first capturing group of `pattern` will (effectively)
 * behave as a lookbehind group meaning that the captured text will not be part of the matched text of the new token.
 * @property {boolean} [greedy=false] Whether the token is greedy.
 * @property {string|string[]} [alias] An optional alias or list of aliases.
 * @property {Grammar} [inside] The nested grammar of this token.
 *
 * The `inside` grammar will be used to tokenize the text value of each token of this kind.
 *
 * This can be used to make nested and even recursive language definitions.
 *
 * Note: This can cause infinite recursion. Be careful when you embed different languages or even the same language into
 * each another.
 * @global
 * @public
 */

/**
 * @typedef Grammar
 * @type {Object<string, RegExp | GrammarToken | Array<RegExp | GrammarToken>>}
 * @property {Grammar} [rest] An optional grammar object that will be appended to this grammar.
 * @global
 * @public
 */

/**
 * A function which will invoked after an element was successfully highlighted.
 *
 * @callback HighlightCallback
 * @param {Element} element The element successfully highlighted.
 * @returns {void}
 * @global
 * @public
 */

/**
 * @callback HookCallback
 * @param {Object<string, any>} env The environment variables of the hook.
 * @returns {void}
 * @global
 * @public
 */


/***/ }),

/***/ "./node_modules/prismjs/components/prism-javascript.js":
/*!*************************************************************!*\
  !*** ./node_modules/prismjs/components/prism-javascript.js ***!
  \*************************************************************/
/***/ (() => {

Prism.languages.javascript = Prism.languages.extend('clike', {
	'class-name': [
		Prism.languages.clike['class-name'],
		{
			pattern: /(^|[^$\w\xA0-\uFFFF])(?!\s)[_$A-Z\xA0-\uFFFF](?:(?!\s)[$\w\xA0-\uFFFF])*(?=\.(?:constructor|prototype))/,
			lookbehind: true
		}
	],
	'keyword': [
		{
			pattern: /((?:^|\})\s*)catch\b/,
			lookbehind: true
		},
		{
			pattern: /(^|[^.]|\.\.\.\s*)\b(?:as|assert(?=\s*\{)|async(?=\s*(?:function\b|\(|[$\w\xA0-\uFFFF]|$))|await|break|case|class|const|continue|debugger|default|delete|do|else|enum|export|extends|finally(?=\s*(?:\{|$))|for|from(?=\s*(?:['"]|$))|function|(?:get|set)(?=\s*(?:[#\[$\w\xA0-\uFFFF]|$))|if|implements|import|in|instanceof|interface|let|new|null|of|package|private|protected|public|return|static|super|switch|this|throw|try|typeof|undefined|var|void|while|with|yield)\b/,
			lookbehind: true
		},
	],
	// Allow for all non-ASCII characters (See http://stackoverflow.com/a/2008444)
	'function': /#?(?!\s)[_$a-zA-Z\xA0-\uFFFF](?:(?!\s)[$\w\xA0-\uFFFF])*(?=\s*(?:\.\s*(?:apply|bind|call)\s*)?\()/,
	'number': {
		pattern: RegExp(
			/(^|[^\w$])/.source +
			'(?:' +
			(
				// constant
				/NaN|Infinity/.source +
				'|' +
				// binary integer
				/0[bB][01]+(?:_[01]+)*n?/.source +
				'|' +
				// octal integer
				/0[oO][0-7]+(?:_[0-7]+)*n?/.source +
				'|' +
				// hexadecimal integer
				/0[xX][\dA-Fa-f]+(?:_[\dA-Fa-f]+)*n?/.source +
				'|' +
				// decimal bigint
				/\d+(?:_\d+)*n/.source +
				'|' +
				// decimal number (integer or float) but no bigint
				/(?:\d+(?:_\d+)*(?:\.(?:\d+(?:_\d+)*)?)?|\.\d+(?:_\d+)*)(?:[Ee][+-]?\d+(?:_\d+)*)?/.source
			) +
			')' +
			/(?![\w$])/.source
		),
		lookbehind: true
	},
	'operator': /--|\+\+|\*\*=?|=>|&&=?|\|\|=?|[!=]==|<<=?|>>>?=?|[-+*/%&|^!=<>]=?|\.{3}|\?\?=?|\?\.?|[~:]/
});

Prism.languages.javascript['class-name'][0].pattern = /(\b(?:class|extends|implements|instanceof|interface|new)\s+)[\w.\\]+/;

Prism.languages.insertBefore('javascript', 'keyword', {
	'regex': {
		pattern: RegExp(
			// lookbehind
			// eslint-disable-next-line regexp/no-dupe-characters-character-class
			/((?:^|[^$\w\xA0-\uFFFF."'\])\s]|\b(?:return|yield))\s*)/.source +
			// Regex pattern:
			// There are 2 regex patterns here. The RegExp set notation proposal added support for nested character
			// classes if the `v` flag is present. Unfortunately, nested CCs are both context-free and incompatible
			// with the only syntax, so we have to define 2 different regex patterns.
			/\//.source +
			'(?:' +
			/(?:\[(?:[^\]\\\r\n]|\\.)*\]|\\.|[^/\\\[\r\n])+\/[dgimyus]{0,7}/.source +
			'|' +
			// `v` flag syntax. This supports 3 levels of nested character classes.
			/(?:\[(?:[^[\]\\\r\n]|\\.|\[(?:[^[\]\\\r\n]|\\.|\[(?:[^[\]\\\r\n]|\\.)*\])*\])*\]|\\.|[^/\\\[\r\n])+\/[dgimyus]{0,7}v[dgimyus]{0,7}/.source +
			')' +
			// lookahead
			/(?=(?:\s|\/\*(?:[^*]|\*(?!\/))*\*\/)*(?:$|[\r\n,.;:})\]]|\/\/))/.source
		),
		lookbehind: true,
		greedy: true,
		inside: {
			'regex-source': {
				pattern: /^(\/)[\s\S]+(?=\/[a-z]*$)/,
				lookbehind: true,
				alias: 'language-regex',
				inside: Prism.languages.regex
			},
			'regex-delimiter': /^\/|\/$/,
			'regex-flags': /^[a-z]+$/,
		}
	},
	// This must be declared before keyword because we use "function" inside the look-forward
	'function-variable': {
		pattern: /#?(?!\s)[_$a-zA-Z\xA0-\uFFFF](?:(?!\s)[$\w\xA0-\uFFFF])*(?=\s*[=:]\s*(?:async\s*)?(?:\bfunction\b|(?:\((?:[^()]|\([^()]*\))*\)|(?!\s)[_$a-zA-Z\xA0-\uFFFF](?:(?!\s)[$\w\xA0-\uFFFF])*)\s*=>))/,
		alias: 'function'
	},
	'parameter': [
		{
			pattern: /(function(?:\s+(?!\s)[_$a-zA-Z\xA0-\uFFFF](?:(?!\s)[$\w\xA0-\uFFFF])*)?\s*\(\s*)(?!\s)(?:[^()\s]|\s+(?![\s)])|\([^()]*\))+(?=\s*\))/,
			lookbehind: true,
			inside: Prism.languages.javascript
		},
		{
			pattern: /(^|[^$\w\xA0-\uFFFF])(?!\s)[_$a-z\xA0-\uFFFF](?:(?!\s)[$\w\xA0-\uFFFF])*(?=\s*=>)/i,
			lookbehind: true,
			inside: Prism.languages.javascript
		},
		{
			pattern: /(\(\s*)(?!\s)(?:[^()\s]|\s+(?![\s)])|\([^()]*\))+(?=\s*\)\s*=>)/,
			lookbehind: true,
			inside: Prism.languages.javascript
		},
		{
			pattern: /((?:\b|\s|^)(?!(?:as|async|await|break|case|catch|class|const|continue|debugger|default|delete|do|else|enum|export|extends|finally|for|from|function|get|if|implements|import|in|instanceof|interface|let|new|null|of|package|private|protected|public|return|set|static|super|switch|this|throw|try|typeof|undefined|var|void|while|with|yield)(?![$\w\xA0-\uFFFF]))(?:(?!\s)[_$a-zA-Z\xA0-\uFFFF](?:(?!\s)[$\w\xA0-\uFFFF])*\s*)\(\s*|\]\s*\(\s*)(?!\s)(?:[^()\s]|\s+(?![\s)])|\([^()]*\))+(?=\s*\)\s*\{)/,
			lookbehind: true,
			inside: Prism.languages.javascript
		}
	],
	'constant': /\b[A-Z](?:[A-Z_]|\dx?)*\b/
});

Prism.languages.insertBefore('javascript', 'string', {
	'hashbang': {
		pattern: /^#!.*/,
		greedy: true,
		alias: 'comment'
	},
	'template-string': {
		pattern: /`(?:\\[\s\S]|\$\{(?:[^{}]|\{(?:[^{}]|\{[^}]*\})*\})+\}|(?!\$\{)[^\\`])*`/,
		greedy: true,
		inside: {
			'template-punctuation': {
				pattern: /^`|`$/,
				alias: 'string'
			},
			'interpolation': {
				pattern: /((?:^|[^\\])(?:\\{2})*)\$\{(?:[^{}]|\{(?:[^{}]|\{[^}]*\})*\})+\}/,
				lookbehind: true,
				inside: {
					'interpolation-punctuation': {
						pattern: /^\$\{|\}$/,
						alias: 'punctuation'
					},
					rest: Prism.languages.javascript
				}
			},
			'string': /[\s\S]+/
		}
	},
	'string-property': {
		pattern: /((?:^|[,{])[ \t]*)(["'])(?:\\(?:\r\n|[\s\S])|(?!\2)[^\\\r\n])*\2(?=\s*:)/m,
		lookbehind: true,
		greedy: true,
		alias: 'property'
	}
});

Prism.languages.insertBefore('javascript', 'operator', {
	'literal-property': {
		pattern: /((?:^|[,{])[ \t]*)(?!\s)[_$a-zA-Z\xA0-\uFFFF](?:(?!\s)[$\w\xA0-\uFFFF])*(?=\s*:)/m,
		lookbehind: true,
		alias: 'property'
	},
});

if (Prism.languages.markup) {
	Prism.languages.markup.tag.addInlined('script', 'javascript');

	// add attribute support for all DOM events.
	// https://developer.mozilla.org/en-US/docs/Web/Events#Standard_events
	Prism.languages.markup.tag.addAttribute(
		/on(?:abort|blur|change|click|composition(?:end|start|update)|dblclick|error|focus(?:in|out)?|key(?:down|up)|load|mouse(?:down|enter|leave|move|out|over|up)|reset|resize|scroll|select|slotchange|submit|unload|wheel)/.source,
		'javascript'
	);
}

Prism.languages.js = Prism.languages.javascript;


/***/ }),

/***/ "./resources/vue/views/pages/pages/Create.vue":
/*!****************************************************!*\
  !*** ./resources/vue/views/pages/pages/Create.vue ***!
  \****************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _Create_vue_vue_type_template_id_12322794_scoped_true__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Create.vue?vue&type=template&id=12322794&scoped=true */ "./resources/vue/views/pages/pages/Create.vue?vue&type=template&id=12322794&scoped=true");
/* harmony import */ var _Create_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Create.vue?vue&type=script&lang=js */ "./resources/vue/views/pages/pages/Create.vue?vue&type=script&lang=js");
/* harmony import */ var _Create_vue_vue_type_style_index_0_id_12322794_scoped_true_lang_css__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./Create.vue?vue&type=style&index=0&id=12322794&scoped=true&lang=css */ "./resources/vue/views/pages/pages/Create.vue?vue&type=style&index=0&id=12322794&scoped=true&lang=css");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");



;


/* normalize component */

var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__["default"])(
  _Create_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"],
  _Create_vue_vue_type_template_id_12322794_scoped_true__WEBPACK_IMPORTED_MODULE_0__.render,
  _Create_vue_vue_type_template_id_12322794_scoped_true__WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  "12322794",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/vue/views/pages/pages/Create.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/vue/views/pages/pages/FormFields.vue":
/*!********************************************************!*\
  !*** ./resources/vue/views/pages/pages/FormFields.vue ***!
  \********************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _FormFields_vue_vue_type_template_id_c054ba96__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./FormFields.vue?vue&type=template&id=c054ba96 */ "./resources/vue/views/pages/pages/FormFields.vue?vue&type=template&id=c054ba96");
/* harmony import */ var _FormFields_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./FormFields.vue?vue&type=script&lang=js */ "./resources/vue/views/pages/pages/FormFields.vue?vue&type=script&lang=js");
/* harmony import */ var _FormFields_vue_vue_type_style_index_0_id_c054ba96_lang_scss__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./FormFields.vue?vue&type=style&index=0&id=c054ba96&lang=scss */ "./resources/vue/views/pages/pages/FormFields.vue?vue&type=style&index=0&id=c054ba96&lang=scss");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");



;


/* normalize component */

var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__["default"])(
  _FormFields_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"],
  _FormFields_vue_vue_type_template_id_c054ba96__WEBPACK_IMPORTED_MODULE_0__.render,
  _FormFields_vue_vue_type_template_id_c054ba96__WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/vue/views/pages/pages/FormFields.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/vue/views/pages/pages/WidgetAttributesModal.vue":
/*!*******************************************************************!*\
  !*** ./resources/vue/views/pages/pages/WidgetAttributesModal.vue ***!
  \*******************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _WidgetAttributesModal_vue_vue_type_template_id_1d5c776c_scoped_true__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./WidgetAttributesModal.vue?vue&type=template&id=1d5c776c&scoped=true */ "./resources/vue/views/pages/pages/WidgetAttributesModal.vue?vue&type=template&id=1d5c776c&scoped=true");
/* harmony import */ var _WidgetAttributesModal_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./WidgetAttributesModal.vue?vue&type=script&lang=js */ "./resources/vue/views/pages/pages/WidgetAttributesModal.vue?vue&type=script&lang=js");
/* harmony import */ var _WidgetAttributesModal_vue_vue_type_style_index_0_id_1d5c776c_scoped_true_lang_css__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./WidgetAttributesModal.vue?vue&type=style&index=0&id=1d5c776c&scoped=true&lang=css */ "./resources/vue/views/pages/pages/WidgetAttributesModal.vue?vue&type=style&index=0&id=1d5c776c&scoped=true&lang=css");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");



;


/* normalize component */

var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__["default"])(
  _WidgetAttributesModal_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"],
  _WidgetAttributesModal_vue_vue_type_template_id_1d5c776c_scoped_true__WEBPACK_IMPORTED_MODULE_0__.render,
  _WidgetAttributesModal_vue_vue_type_template_id_1d5c776c_scoped_true__WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  "1d5c776c",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/vue/views/pages/pages/WidgetAttributesModal.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/vue/views/pages/pages/Create.vue?vue&type=script&lang=js":
/*!****************************************************************************!*\
  !*** ./resources/vue/views/pages/pages/Create.vue?vue&type=script&lang=js ***!
  \****************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_laravel_mix_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Create_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Create.vue?vue&type=script&lang=js */ "./node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/pages/pages/Create.vue?vue&type=script&lang=js");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_laravel_mix_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Create_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/vue/views/pages/pages/FormFields.vue?vue&type=script&lang=js":
/*!********************************************************************************!*\
  !*** ./resources/vue/views/pages/pages/FormFields.vue?vue&type=script&lang=js ***!
  \********************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_laravel_mix_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_FormFields_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./FormFields.vue?vue&type=script&lang=js */ "./node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/pages/pages/FormFields.vue?vue&type=script&lang=js");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_laravel_mix_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_FormFields_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/vue/views/pages/pages/WidgetAttributesModal.vue?vue&type=script&lang=js":
/*!*******************************************************************************************!*\
  !*** ./resources/vue/views/pages/pages/WidgetAttributesModal.vue?vue&type=script&lang=js ***!
  \*******************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_laravel_mix_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_WidgetAttributesModal_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./WidgetAttributesModal.vue?vue&type=script&lang=js */ "./node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/pages/pages/WidgetAttributesModal.vue?vue&type=script&lang=js");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_laravel_mix_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_WidgetAttributesModal_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/vue/views/pages/pages/Create.vue?vue&type=template&id=12322794&scoped=true":
/*!**********************************************************************************************!*\
  !*** ./resources/vue/views/pages/pages/Create.vue?vue&type=template&id=12322794&scoped=true ***!
  \**********************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   render: () => (/* reexport safe */ _node_modules_laravel_mix_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_Create_vue_vue_type_template_id_12322794_scoped_true__WEBPACK_IMPORTED_MODULE_0__.render),
/* harmony export */   staticRenderFns: () => (/* reexport safe */ _node_modules_laravel_mix_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_Create_vue_vue_type_template_id_12322794_scoped_true__WEBPACK_IMPORTED_MODULE_0__.staticRenderFns)
/* harmony export */ });
/* harmony import */ var _node_modules_laravel_mix_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_Create_vue_vue_type_template_id_12322794_scoped_true__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Create.vue?vue&type=template&id=12322794&scoped=true */ "./node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/pages/pages/Create.vue?vue&type=template&id=12322794&scoped=true");


/***/ }),

/***/ "./resources/vue/views/pages/pages/FormFields.vue?vue&type=template&id=c054ba96":
/*!**************************************************************************************!*\
  !*** ./resources/vue/views/pages/pages/FormFields.vue?vue&type=template&id=c054ba96 ***!
  \**************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   render: () => (/* reexport safe */ _node_modules_laravel_mix_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_FormFields_vue_vue_type_template_id_c054ba96__WEBPACK_IMPORTED_MODULE_0__.render),
/* harmony export */   staticRenderFns: () => (/* reexport safe */ _node_modules_laravel_mix_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_FormFields_vue_vue_type_template_id_c054ba96__WEBPACK_IMPORTED_MODULE_0__.staticRenderFns)
/* harmony export */ });
/* harmony import */ var _node_modules_laravel_mix_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_FormFields_vue_vue_type_template_id_c054ba96__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./FormFields.vue?vue&type=template&id=c054ba96 */ "./node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/pages/pages/FormFields.vue?vue&type=template&id=c054ba96");


/***/ }),

/***/ "./resources/vue/views/pages/pages/WidgetAttributesModal.vue?vue&type=template&id=1d5c776c&scoped=true":
/*!*************************************************************************************************************!*\
  !*** ./resources/vue/views/pages/pages/WidgetAttributesModal.vue?vue&type=template&id=1d5c776c&scoped=true ***!
  \*************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   render: () => (/* reexport safe */ _node_modules_laravel_mix_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_WidgetAttributesModal_vue_vue_type_template_id_1d5c776c_scoped_true__WEBPACK_IMPORTED_MODULE_0__.render),
/* harmony export */   staticRenderFns: () => (/* reexport safe */ _node_modules_laravel_mix_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_WidgetAttributesModal_vue_vue_type_template_id_1d5c776c_scoped_true__WEBPACK_IMPORTED_MODULE_0__.staticRenderFns)
/* harmony export */ });
/* harmony import */ var _node_modules_laravel_mix_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_WidgetAttributesModal_vue_vue_type_template_id_1d5c776c_scoped_true__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./WidgetAttributesModal.vue?vue&type=template&id=1d5c776c&scoped=true */ "./node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/pages/pages/WidgetAttributesModal.vue?vue&type=template&id=1d5c776c&scoped=true");


/***/ }),

/***/ "./resources/vue/views/pages/pages/FormFields.vue?vue&type=style&index=0&id=c054ba96&lang=scss":
/*!*****************************************************************************************************!*\
  !*** ./resources/vue/views/pages/pages/FormFields.vue?vue&type=style&index=0&id=c054ba96&lang=scss ***!
  \*****************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_laravel_mix_node_modules_style_loader_dist_cjs_js_node_modules_laravel_mix_node_modules_css_loader_dist_cjs_js_clonedRuleSet_12_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_laravel_mix_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_12_use_2_node_modules_sass_loader_dist_cjs_js_clonedRuleSet_12_use_3_node_modules_vue_loader_lib_index_js_vue_loader_options_FormFields_vue_vue_type_style_index_0_id_c054ba96_lang_scss__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/laravel-mix/node_modules/style-loader/dist/cjs.js!../../../../../node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-12.use[1]!../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../node_modules/laravel-mix/node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-12.use[2]!../../../../../node_modules/sass-loader/dist/cjs.js??clonedRuleSet-12.use[3]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./FormFields.vue?vue&type=style&index=0&id=c054ba96&lang=scss */ "./node_modules/laravel-mix/node_modules/style-loader/dist/cjs.js!./node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-12.use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/laravel-mix/node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-12.use[2]!./node_modules/sass-loader/dist/cjs.js??clonedRuleSet-12.use[3]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/pages/pages/FormFields.vue?vue&type=style&index=0&id=c054ba96&lang=scss");


/***/ }),

/***/ "./resources/vue/views/pages/pages/Create.vue?vue&type=style&index=0&id=12322794&scoped=true&lang=css":
/*!************************************************************************************************************!*\
  !*** ./resources/vue/views/pages/pages/Create.vue?vue&type=style&index=0&id=12322794&scoped=true&lang=css ***!
  \************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_laravel_mix_node_modules_style_loader_dist_cjs_js_node_modules_laravel_mix_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_laravel_mix_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_Create_vue_vue_type_style_index_0_id_12322794_scoped_true_lang_css__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/laravel-mix/node_modules/style-loader/dist/cjs.js!../../../../../node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../node_modules/laravel-mix/node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Create.vue?vue&type=style&index=0&id=12322794&scoped=true&lang=css */ "./node_modules/laravel-mix/node_modules/style-loader/dist/cjs.js!./node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/laravel-mix/node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/pages/pages/Create.vue?vue&type=style&index=0&id=12322794&scoped=true&lang=css");


/***/ }),

/***/ "./resources/vue/views/pages/pages/WidgetAttributesModal.vue?vue&type=style&index=0&id=1d5c776c&scoped=true&lang=css":
/*!***************************************************************************************************************************!*\
  !*** ./resources/vue/views/pages/pages/WidgetAttributesModal.vue?vue&type=style&index=0&id=1d5c776c&scoped=true&lang=css ***!
  \***************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_laravel_mix_node_modules_style_loader_dist_cjs_js_node_modules_laravel_mix_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_laravel_mix_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_WidgetAttributesModal_vue_vue_type_style_index_0_id_1d5c776c_scoped_true_lang_css__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/laravel-mix/node_modules/style-loader/dist/cjs.js!../../../../../node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../node_modules/laravel-mix/node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./WidgetAttributesModal.vue?vue&type=style&index=0&id=1d5c776c&scoped=true&lang=css */ "./node_modules/laravel-mix/node_modules/style-loader/dist/cjs.js!./node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/laravel-mix/node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/pages/pages/WidgetAttributesModal.vue?vue&type=style&index=0&id=1d5c776c&scoped=true&lang=css");


/***/ }),

/***/ "./node_modules/vue-prism-editor/dist/prismeditor.esm.js":
/*!***************************************************************!*\
  !*** ./node_modules/vue-prism-editor/dist/prismeditor.esm.js ***!
  \***************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   PrismEditor: () => (/* binding */ PrismEditor)
/* harmony export */ });
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.esm.js");


function _extends() {
  _extends = Object.assign || function (target) {
    for (var i = 1; i < arguments.length; i++) {
      var source = arguments[i];

      for (var key in source) {
        if (Object.prototype.hasOwnProperty.call(source, key)) {
          target[key] = source[key];
        }
      }
    }

    return target;
  };

  return _extends.apply(this, arguments);
}

var KEYCODE_ENTER = 13;
var KEYCODE_TAB = 9;
var KEYCODE_BACKSPACE = 8;
var KEYCODE_Y = 89;
var KEYCODE_Z = 90;
var KEYCODE_M = 77;
var KEYCODE_PARENS = 57;
var KEYCODE_BRACKETS = 219;
var KEYCODE_QUOTE = 222;
var KEYCODE_BACK_QUOTE = 192;
var KEYCODE_ESCAPE = 27;
var HISTORY_LIMIT = 100;
var HISTORY_TIME_GAP = 3000;
var isWindows = typeof window !== 'undefined' && navigator && /*#__PURE__*/ /Win/i.test(navigator.platform);
var isMacLike = typeof window !== 'undefined' && navigator && /*#__PURE__*/ /(Mac|iPhone|iPod|iPad)/i.test(navigator.platform);
var PrismEditor = /*#__PURE__*/vue__WEBPACK_IMPORTED_MODULE_0__["default"].extend({
  props: {
    lineNumbers: {
      type: Boolean,
      "default": false
    },
    autoStyleLineNumbers: {
      type: Boolean,
      "default": true
    },
    readonly: {
      type: Boolean,
      "default": false
    },
    value: {
      type: String,
      "default": ''
    },
    highlight: {
      type: Function,
      required: true
    },
    tabSize: {
      type: Number,
      "default": 2
    },
    insertSpaces: {
      type: Boolean,
      "default": true
    },
    ignoreTabKey: {
      type: Boolean,
      "default": false
    },
    placeholder: {
      type: String,
      "default": ''
    }
  },
  data: function data() {
    return {
      capture: true,
      history: {
        stack: [],
        offset: -1
      },
      lineNumbersHeight: '20px',
      codeData: ''
    };
  },
  watch: {
    value: {
      immediate: true,
      handler: function handler(newVal) {
        if (!newVal) {
          this.codeData = '';
        } else {
          this.codeData = newVal;
        }
      }
    },
    content: {
      immediate: true,
      handler: function handler() {
        var _this = this;

        if (this.lineNumbers) {
          this.$nextTick(function () {
            _this.setLineNumbersHeight();
          });
        }
      }
    },
    lineNumbers: function lineNumbers() {
      var _this2 = this;

      this.$nextTick(function () {
        _this2.styleLineNumbers();

        _this2.setLineNumbersHeight();
      });
    }
  },
  computed: {
    isEmpty: function isEmpty() {
      return this.codeData.length === 0;
    },
    content: function content() {
      var result = this.highlight(this.codeData) + '<br />'; // todo: VNode support?

      return result;
    },
    lineNumbersCount: function lineNumbersCount() {
      var totalLines = this.codeData.split(/\r\n|\n/).length;
      return totalLines;
    }
  },
  mounted: function mounted() {
    this._recordCurrentState();

    this.styleLineNumbers();
  },
  methods: {
    setLineNumbersHeight: function setLineNumbersHeight() {
      this.lineNumbersHeight = getComputedStyle(this.$refs.pre).height;
    },
    styleLineNumbers: function styleLineNumbers() {
      if (!this.lineNumbers || !this.autoStyleLineNumbers) return;
      var $editor = this.$refs.pre;
      var $lineNumbers = this.$el.querySelector('.prism-editor__line-numbers');
      var editorStyles = window.getComputedStyle($editor);
      this.$nextTick(function () {
        var btlr = 'border-top-left-radius';
        var bblr = 'border-bottom-left-radius';
        if (!$lineNumbers) return;
        $lineNumbers.style[btlr] = editorStyles[btlr];
        $lineNumbers.style[bblr] = editorStyles[bblr];
        $editor.style[btlr] = '0';
        $editor.style[bblr] = '0';
        var stylesList = ['background-color', 'margin-top', 'padding-top', 'font-family', 'font-size', 'line-height'];
        stylesList.forEach(function (style) {
          $lineNumbers.style[style] = editorStyles[style];
        });
        $lineNumbers.style['margin-bottom'] = '-' + editorStyles['padding-top'];
      });
    },
    _recordCurrentState: function _recordCurrentState() {
      var input = this.$refs.textarea;
      if (!input) return; // Save current state of the input

      var value = input.value,
          selectionStart = input.selectionStart,
          selectionEnd = input.selectionEnd;

      this._recordChange({
        value: value,
        selectionStart: selectionStart,
        selectionEnd: selectionEnd
      });
    },
    _getLines: function _getLines(text, position) {
      return text.substring(0, position).split('\n');
    },
    _applyEdits: function _applyEdits(record) {
      // Save last selection state
      var input = this.$refs.textarea;
      var last = this.history.stack[this.history.offset];

      if (last && input) {
        this.history.stack[this.history.offset] = _extends({}, last, {
          selectionStart: input.selectionStart,
          selectionEnd: input.selectionEnd
        });
      } // Save the changes


      this._recordChange(record);

      this._updateInput(record);
    },
    _recordChange: function _recordChange(record, overwrite) {
      if (overwrite === void 0) {
        overwrite = false;
      }

      var _this$history = this.history,
          stack = _this$history.stack,
          offset = _this$history.offset;

      if (stack.length && offset > -1) {
        // When something updates, drop the redo operations
        this.history.stack = stack.slice(0, offset + 1); // Limit the number of operations to 100

        var count = this.history.stack.length;

        if (count > HISTORY_LIMIT) {
          var extras = count - HISTORY_LIMIT;
          this.history.stack = stack.slice(extras, count);
          this.history.offset = Math.max(this.history.offset - extras, 0);
        }
      }

      var timestamp = Date.now();

      if (overwrite) {
        var last = this.history.stack[this.history.offset];

        if (last && timestamp - last.timestamp < HISTORY_TIME_GAP) {
          var _this$_getLines$pop, _this$_getLines$pop2;

          // A previous entry exists and was in short interval
          // Match the last word in the line
          var re = /[^a-z0-9]([a-z0-9]+)$/i; // Get the previous line

          var previous = (_this$_getLines$pop = this._getLines(last.value, last.selectionStart).pop()) === null || _this$_getLines$pop === void 0 ? void 0 : _this$_getLines$pop.match(re); // Get the current line

          var current = (_this$_getLines$pop2 = this._getLines(record.value, record.selectionStart).pop()) === null || _this$_getLines$pop2 === void 0 ? void 0 : _this$_getLines$pop2.match(re);

          if (previous && current && current[1].startsWith(previous[1])) {
            // The last word of the previous line and current line match
            // Overwrite previous entry so that undo will remove whole word
            this.history.stack[this.history.offset] = _extends({}, record, {
              timestamp: timestamp
            });
            return;
          }
        }
      } // Add the new operation to the stack


      this.history.stack.push(_extends({}, record, {
        timestamp: timestamp
      }));
      this.history.offset++;
    },
    _updateInput: function _updateInput(record) {
      var input = this.$refs.textarea;
      if (!input) return; // Update values and selection state

      input.value = record.value;
      input.selectionStart = record.selectionStart;
      input.selectionEnd = record.selectionEnd;
      this.$emit('input', record.value); // this.props.onValueChange(record.value);
    },
    handleChange: function handleChange(e) {
      var _e$target = e.target,
          value = _e$target.value,
          selectionStart = _e$target.selectionStart,
          selectionEnd = _e$target.selectionEnd;

      this._recordChange({
        value: value,
        selectionStart: selectionStart,
        selectionEnd: selectionEnd
      }, true);

      this.$emit('input', value); // this.props.onValueChange(value);
    },
    _undoEdit: function _undoEdit() {
      var _this$history2 = this.history,
          stack = _this$history2.stack,
          offset = _this$history2.offset; // Get the previous edit

      var record = stack[offset - 1];

      if (record) {
        // Apply the changes and update the offset
        this._updateInput(record);

        this.history.offset = Math.max(offset - 1, 0);
      }
    },
    _redoEdit: function _redoEdit() {
      var _this$history3 = this.history,
          stack = _this$history3.stack,
          offset = _this$history3.offset; // Get the next edit

      var record = stack[offset + 1];

      if (record) {
        // Apply the changes and update the offset
        this._updateInput(record);

        this.history.offset = Math.min(offset + 1, stack.length - 1);
      }
    },
    handleKeyDown: function handleKeyDown(e) {
      // console.log(navigator.platform);
      var tabSize = this.tabSize,
          insertSpaces = this.insertSpaces,
          ignoreTabKey = this.ignoreTabKey;

      if (this.$listeners.keydown) {
        // onKeyDown(e);
        this.$emit('keydown', e);

        if (e.defaultPrevented) {
          return;
        }
      }

      if (e.keyCode === KEYCODE_ESCAPE) {
        e.target.blur();
        this.$emit('blur', e);
      }

      var _e$target2 = e.target,
          value = _e$target2.value,
          selectionStart = _e$target2.selectionStart,
          selectionEnd = _e$target2.selectionEnd;
      var tabCharacter = (insertSpaces ? ' ' : '\t').repeat(tabSize);

      if (e.keyCode === KEYCODE_TAB && !ignoreTabKey && this.capture) {
        // Prevent focus change
        e.preventDefault();

        if (e.shiftKey) {
          // Unindent selected lines
          var linesBeforeCaret = this._getLines(value, selectionStart);

          var startLine = linesBeforeCaret.length - 1;
          var endLine = this._getLines(value, selectionEnd).length - 1;
          var nextValue = value.split('\n').map(function (line, i) {
            if (i >= startLine && i <= endLine && line.startsWith(tabCharacter)) {
              return line.substring(tabCharacter.length);
            }

            return line;
          }).join('\n');

          if (value !== nextValue) {
            var startLineText = linesBeforeCaret[startLine];

            this._applyEdits({
              value: nextValue,
              // Move the start cursor if first line in selection was modified
              // It was modified only if it started with a tab
              selectionStart: startLineText.startsWith(tabCharacter) ? selectionStart - tabCharacter.length : selectionStart,
              // Move the end cursor by total number of characters removed
              selectionEnd: selectionEnd - (value.length - nextValue.length)
            });
          }
        } else if (selectionStart !== selectionEnd) {
          // Indent selected lines
          var _linesBeforeCaret = this._getLines(value, selectionStart);

          var _startLine = _linesBeforeCaret.length - 1;

          var _endLine = this._getLines(value, selectionEnd).length - 1;

          var _startLineText = _linesBeforeCaret[_startLine];

          this._applyEdits({
            value: value.split('\n').map(function (line, i) {
              if (i >= _startLine && i <= _endLine) {
                return tabCharacter + line;
              }

              return line;
            }).join('\n'),
            // Move the start cursor by number of characters added in first line of selection
            // Don't move it if it there was no text before cursor
            selectionStart: /\S/.test(_startLineText) ? selectionStart + tabCharacter.length : selectionStart,
            // Move the end cursor by total number of characters added
            selectionEnd: selectionEnd + tabCharacter.length * (_endLine - _startLine + 1)
          });
        } else {
          var updatedSelection = selectionStart + tabCharacter.length;

          this._applyEdits({
            // Insert tab character at caret
            value: value.substring(0, selectionStart) + tabCharacter + value.substring(selectionEnd),
            // Update caret position
            selectionStart: updatedSelection,
            selectionEnd: updatedSelection
          });
        }
      } else if (e.keyCode === KEYCODE_BACKSPACE) {
        var hasSelection = selectionStart !== selectionEnd;
        var textBeforeCaret = value.substring(0, selectionStart);

        if (textBeforeCaret.endsWith(tabCharacter) && !hasSelection) {
          // Prevent default delete behaviour
          e.preventDefault();

          var _updatedSelection = selectionStart - tabCharacter.length;

          this._applyEdits({
            // Remove tab character at caret
            value: value.substring(0, selectionStart - tabCharacter.length) + value.substring(selectionEnd),
            // Update caret position
            selectionStart: _updatedSelection,
            selectionEnd: _updatedSelection
          });
        }
      } else if (e.keyCode === KEYCODE_ENTER) {
        // Ignore selections
        if (selectionStart === selectionEnd) {
          // Get the current line
          var line = this._getLines(value, selectionStart).pop();

          var matches = line === null || line === void 0 ? void 0 : line.match(/^\s+/);

          if (matches && matches[0]) {
            e.preventDefault(); // Preserve indentation on inserting a new line

            var indent = '\n' + matches[0];

            var _updatedSelection2 = selectionStart + indent.length;

            this._applyEdits({
              // Insert indentation character at caret
              value: value.substring(0, selectionStart) + indent + value.substring(selectionEnd),
              // Update caret position
              selectionStart: _updatedSelection2,
              selectionEnd: _updatedSelection2
            });
          }
        }
      } else if (e.keyCode === KEYCODE_PARENS || e.keyCode === KEYCODE_BRACKETS || e.keyCode === KEYCODE_QUOTE || e.keyCode === KEYCODE_BACK_QUOTE) {
        var chars;

        if (e.keyCode === KEYCODE_PARENS && e.shiftKey) {
          chars = ['(', ')'];
        } else if (e.keyCode === KEYCODE_BRACKETS) {
          if (e.shiftKey) {
            chars = ['{', '}'];
          } else {
            chars = ['[', ']'];
          }
        } else if (e.keyCode === KEYCODE_QUOTE) {
          if (e.shiftKey) {
            chars = ['"', '"'];
          } else {
            chars = ["'", "'"];
          }
        } else if (e.keyCode === KEYCODE_BACK_QUOTE && !e.shiftKey) {
          chars = ['`', '`'];
        } // console.log(isMacLike, "navigator" in global && /(Mac|iPhone|iPod|iPad)/i.test(navigator.platform));
        // If text is selected, wrap them in the characters


        if (selectionStart !== selectionEnd && chars) {
          e.preventDefault();

          this._applyEdits({
            value: value.substring(0, selectionStart) + chars[0] + value.substring(selectionStart, selectionEnd) + chars[1] + value.substring(selectionEnd),
            // Update caret position
            selectionStart: selectionStart,
            selectionEnd: selectionEnd + 2
          });
        }
      } else if ((isMacLike ? // Trigger undo with ⌘+Z on Mac
      e.metaKey && e.keyCode === KEYCODE_Z : // Trigger undo with Ctrl+Z on other platforms
      e.ctrlKey && e.keyCode === KEYCODE_Z) && !e.shiftKey && !e.altKey) {
        e.preventDefault();

        this._undoEdit();
      } else if ((isMacLike ? // Trigger redo with ⌘+Shift+Z on Mac
      e.metaKey && e.keyCode === KEYCODE_Z && e.shiftKey : isWindows ? // Trigger redo with Ctrl+Y on Windows
      e.ctrlKey && e.keyCode === KEYCODE_Y : // Trigger redo with Ctrl+Shift+Z on other platforms
      e.ctrlKey && e.keyCode === KEYCODE_Z && e.shiftKey) && !e.altKey) {
        e.preventDefault();

        this._redoEdit();
      } else if (e.keyCode === KEYCODE_M && e.ctrlKey && (isMacLike ? e.shiftKey : true)) {
        e.preventDefault(); // Toggle capturing tab key so users can focus away

        this.capture = !this.capture;
      }
    }
  },
  render: function render(h) {
    var _this3 = this;

    var lineNumberWidthCalculator = h('div', {
      attrs: {
        "class": 'prism-editor__line-width-calc',
        style: 'height: 0px; visibility: hidden; pointer-events: none;'
      }
    }, '999');
    var lineNumbers = h('div', {
      staticClass: 'prism-editor__line-numbers',
      style: {
        'min-height': this.lineNumbersHeight
      },
      attrs: {
        'aria-hidden': 'true'
      }
    }, [lineNumberWidthCalculator, Array.from(Array(this.lineNumbersCount).keys()).map(function (_, index) {
      return h('div', {
        attrs: {
          "class": 'prism-editor__line-number token comment'
        }
      }, "" + ++index);
    })]);
    var textarea = h('textarea', {
      ref: 'textarea',
      on: {
        input: this.handleChange,
        keydown: this.handleKeyDown,
        click: function click($event) {
          _this3.$emit('click', $event);
        },
        keyup: function keyup($event) {
          _this3.$emit('keyup', $event);
        },
        focus: function focus($event) {
          _this3.$emit('focus', $event);
        },
        blur: function blur($event) {
          _this3.$emit('blur', $event);
        }
      },
      staticClass: 'prism-editor__textarea',
      "class": {
        'prism-editor__textarea--empty': this.isEmpty
      },
      attrs: {
        spellCheck: 'false',
        autocapitalize: 'off',
        autocomplete: 'off',
        autocorrect: 'off',
        'data-gramm': 'false',
        placeholder: this.placeholder,
        'data-testid': 'textarea',
        readonly: this.readonly
      },
      domProps: {
        value: this.codeData
      }
    });
    var preview = h('pre', {
      ref: 'pre',
      staticClass: 'prism-editor__editor',
      attrs: {
        'data-testid': 'preview'
      },
      domProps: {
        innerHTML: this.content
      }
    });
    var editorContainer = h('div', {
      staticClass: 'prism-editor__container'
    }, [textarea, preview]);
    return h('div', {
      staticClass: 'prism-editor-wrapper'
    }, [this.lineNumbers && lineNumbers, editorContainer]);
  }
});


//# sourceMappingURL=prismeditor.esm.js.map


/***/ })

}]);