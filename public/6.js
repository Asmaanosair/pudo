(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[6],{

/***/ "./frontend/node_modules/@codinglabs/laravel-asset/asset.js":
/*!******************************************************************!*\
  !*** ./frontend/node_modules/@codinglabs/laravel-asset/asset.js ***!
  \******************************************************************/
/*! exports provided: asset */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* WEBPACK VAR INJECTION */(function(process) {/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "asset", function() { return asset; });
const asset = (path) => {
    // default to MIX_ASSET_URL
    let prefix = process.env.MIX_ASSET_URL

    if (!prefix) {
        // fallback to determining ASSET_URL from meta tag
        prefix = document.head.querySelector('meta[name="asset-url"]').content
    }

    return prefix + '/' + path.replace(/^\/+/, '')
}

/* WEBPACK VAR INJECTION */}.call(this, __webpack_require__(/*! ./../../../../node_modules/process/browser.js */ "./node_modules/process/browser.js")))

/***/ }),

/***/ "./frontend/node_modules/v-offline/dist/v-offline.esm.js":
/*!***************************************************************!*\
  !*** ./frontend/node_modules/v-offline/dist/v-offline.esm.js ***!
  \***************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
function createCommonjsModule(fn, basedir, module) {
	return module = {
	  path: basedir,
	  exports: {},
	  require: function (path, base) {
      return commonjsRequire(path, (base === undefined || base === null) ? module.path : base);
    }
	}, fn(module, module.exports), module.exports;
}

function commonjsRequire () {
	throw new Error('Dynamic requires are not currently supported by @rollup/plugin-commonjs');
}

var ping = createCommonjsModule(function (module, exports) {
/**
 * Creates a Ping instance.
 * @returns {Ping}
 * @constructor
 */
var Ping = function(opt) {
    this.opt = opt || {};
    this.favicon = this.opt.favicon || "/favicon.ico";
    this.timeout = this.opt.timeout || 0;
    this.logError = this.opt.logError || false;
};

/**
 * Pings source and triggers a callback when completed.
 * @param source Source of the website or server, including protocol and port.
 * @param callback Callback function to trigger when completed. Returns error and ping value.
 * @param timeout Optional number of milliseconds to wait before aborting.
 */
Ping.prototype.ping = function(source, callback) {
    var self = this;
    self.wasSuccess = false;
    self.img = new Image();
    self.img.onload = onload;
    self.img.onerror = onerror;

    var timer;
    var start = new Date();

    function onload(e) {
        self.wasSuccess = true;
        pingCheck.call(self, e);
    }

    function onerror(e) {
        self.wasSuccess = false;
        pingCheck.call(self, e);
    }

    if (self.timeout) {
        timer = setTimeout(function() {
            pingCheck.call(self, undefined);
    }, self.timeout); }


    /**
     * Times ping and triggers callback.
     */
    function pingCheck() {
        if (timer) { clearTimeout(timer); }
        var pong = new Date() - start;

        if (typeof callback === "function") {
            // When operating in timeout mode, the timeout callback doesn't pass [event] as e.
            // Notice [this] instead of [self], since .call() was used with context
            if (!this.wasSuccess) {
                if (self.logError) { console.error("error loading resource"); }
                return callback("error", pong);
            }
            return callback(null, pong);
        }
    }

    self.img.src = source + self.favicon + "?" + (+new Date()); // Trigger image load with cache buster
};

{
    if ( module.exports) {
        module.exports = Ping;
    }
}
});

var ping_js = ping;

var EVENTS = ['online', 'offline', 'load'];
var script = {
  name: 'VOffline',
  props: {
    slotName: {
      type: String,
      required: false,
      "default": 'online'
    },
    onlineClass: {
      type: String,
      required: false,
      "default": ''
    },
    offlineClass: {
      type: String,
      required: false,
      "default": ''
    },
    pingUrl: {
      type: String,
      required: false,
      "default": 'https://google.com'
    }
  },
  data: function data() {
    return {
      isOnline: navigator.onLine || false
    };
  },
  computed: {
    computedClass: function computedClass() {
      return this.isOnline ? this.onlineClass : this.offlineClass;
    }
  },
  created: function created() {
    var _this = this;

    EVENTS.forEach(function (event) {
      return window.addEventListener(event, _this.updateOnlineStatus);
    });
  },
  beforeDestroy: function beforeDestroy() {
    var _this2 = this;

    EVENTS.forEach(function (event) {
      return window.removeEventListener(event, _this2.updateOnlineStatus);
    });
  },
  methods: {
    updateOnlineStatus: function updateOnlineStatus() {
      var t = this;
      var p = new ping_js();
      p.ping(t.pingUrl, function (err) {
        if (err || !navigator.onLine) {
          t.isOnline = false;
          t.$emit('detected-condition', t.isOnline);
        } else {
          t.isOnline = true;
          t.$emit('detected-condition', t.isOnline);
        }
      });
    }
  }
};

function normalizeComponent(template, style, script, scopeId, isFunctionalTemplate, moduleIdentifier /* server only */, shadowMode, createInjector, createInjectorSSR, createInjectorShadow) {
    if (typeof shadowMode !== 'boolean') {
        createInjectorSSR = createInjector;
        createInjector = shadowMode;
        shadowMode = false;
    }
    // Vue.extend constructor export interop.
    const options = typeof script === 'function' ? script.options : script;
    // render functions
    if (template && template.render) {
        options.render = template.render;
        options.staticRenderFns = template.staticRenderFns;
        options._compiled = true;
        // functional template
        if (isFunctionalTemplate) {
            options.functional = true;
        }
    }
    // scopedId
    if (scopeId) {
        options._scopeId = scopeId;
    }
    let hook;
    if (moduleIdentifier) {
        // server build
        hook = function (context) {
            // 2.3 injection
            context =
                context || // cached call
                    (this.$vnode && this.$vnode.ssrContext) || // stateful
                    (this.parent && this.parent.$vnode && this.parent.$vnode.ssrContext); // functional
            // 2.2 with runInNewContext: true
            if (!context && typeof __VUE_SSR_CONTEXT__ !== 'undefined') {
                context = __VUE_SSR_CONTEXT__;
            }
            // inject component styles
            if (style) {
                style.call(this, createInjectorSSR(context));
            }
            // register component module identifier for async chunk inference
            if (context && context._registeredComponents) {
                context._registeredComponents.add(moduleIdentifier);
            }
        };
        // used by ssr in case component is cached and beforeCreate
        // never gets called
        options._ssrRegister = hook;
    }
    else if (style) {
        hook = shadowMode
            ? function (context) {
                style.call(this, createInjectorShadow(context, this.$root.$options.shadowRoot));
            }
            : function (context) {
                style.call(this, createInjector(context));
            };
    }
    if (hook) {
        if (options.functional) {
            // register for functional component in vue file
            const originalRender = options.render;
            options.render = function renderWithStyleInjection(h, context) {
                hook.call(context);
                return originalRender(h, context);
            };
        }
        else {
            // inject component registration as beforeCreate hook
            const existing = options.beforeCreate;
            options.beforeCreate = existing ? [].concat(existing, hook) : [hook];
        }
    }
    return script;
}

/* script */
const __vue_script__ = script;

/* template */
var __vue_render__ = function() {
  var _vm = this;
  var _h = _vm.$createElement;
  var _c = _vm._self._c || _h;
  return _c("div", { class: _vm.computedClass }, [_vm._t(_vm.slotName)], 2)
};
var __vue_staticRenderFns__ = [];
__vue_render__._withStripped = true;

  /* style */
  const __vue_inject_styles__ = undefined;
  /* scoped */
  const __vue_scope_id__ = undefined;
  /* module identifier */
  const __vue_module_identifier__ = undefined;
  /* functional template */
  const __vue_is_functional_template__ = false;
  /* style inject */
  
  /* style inject SSR */
  
  /* style inject shadow dom */
  

  
  const __vue_component__ = /*#__PURE__*/normalizeComponent(
    { render: __vue_render__, staticRenderFns: __vue_staticRenderFns__ },
    __vue_inject_styles__,
    __vue_script__,
    __vue_scope_id__,
    __vue_is_functional_template__,
    __vue_module_identifier__,
    false,
    undefined,
    undefined,
    undefined
  );

/* harmony default export */ __webpack_exports__["default"] = (__vue_component__);


/***/ }),

/***/ "./frontend/src/containers/Menu.vue":
/*!******************************************!*\
  !*** ./frontend/src/containers/Menu.vue ***!
  \******************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _Menu_vue_vue_type_template_id_5df79c42___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Menu.vue?vue&type=template&id=5df79c42& */ "./frontend/src/containers/Menu.vue?vue&type=template&id=5df79c42&");
/* harmony import */ var _Menu_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Menu.vue?vue&type=script&lang=js& */ "./frontend/src/containers/Menu.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _Menu_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _Menu_vue_vue_type_template_id_5df79c42___WEBPACK_IMPORTED_MODULE_0__["render"],
  _Menu_vue_vue_type_template_id_5df79c42___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "frontend/src/containers/Menu.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./frontend/src/containers/Menu.vue?vue&type=script&lang=js&":
/*!*******************************************************************!*\
  !*** ./frontend/src/containers/Menu.vue?vue&type=script&lang=js& ***!
  \*******************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Menu_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib??ref--4-0!../../../node_modules/vue-loader/lib??vue-loader-options!./Menu.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./frontend/src/containers/Menu.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Menu_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./frontend/src/containers/Menu.vue?vue&type=template&id=5df79c42&":
/*!*************************************************************************!*\
  !*** ./frontend/src/containers/Menu.vue?vue&type=template&id=5df79c42& ***!
  \*************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Menu_vue_vue_type_template_id_5df79c42___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../node_modules/vue-loader/lib??vue-loader-options!./Menu.vue?vue&type=template&id=5df79c42& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./frontend/src/containers/Menu.vue?vue&type=template&id=5df79c42&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Menu_vue_vue_type_template_id_5df79c42___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Menu_vue_vue_type_template_id_5df79c42___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./frontend/src/containers/TheContainer.vue":
/*!**************************************************!*\
  !*** ./frontend/src/containers/TheContainer.vue ***!
  \**************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _TheContainer_vue_vue_type_template_id_2705e673_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./TheContainer.vue?vue&type=template&id=2705e673&scoped=true& */ "./frontend/src/containers/TheContainer.vue?vue&type=template&id=2705e673&scoped=true&");
/* harmony import */ var _TheContainer_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./TheContainer.vue?vue&type=script&lang=js& */ "./frontend/src/containers/TheContainer.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _TheContainer_vue_vue_type_style_index_0_id_2705e673_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./TheContainer.vue?vue&type=style&index=0&id=2705e673&scoped=true&lang=css& */ "./frontend/src/containers/TheContainer.vue?vue&type=style&index=0&id=2705e673&scoped=true&lang=css&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");






/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__["default"])(
  _TheContainer_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _TheContainer_vue_vue_type_template_id_2705e673_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"],
  _TheContainer_vue_vue_type_template_id_2705e673_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  "2705e673",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "frontend/src/containers/TheContainer.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./frontend/src/containers/TheContainer.vue?vue&type=script&lang=js&":
/*!***************************************************************************!*\
  !*** ./frontend/src/containers/TheContainer.vue?vue&type=script&lang=js& ***!
  \***************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_TheContainer_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib??ref--4-0!../../../node_modules/vue-loader/lib??vue-loader-options!./TheContainer.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./frontend/src/containers/TheContainer.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_TheContainer_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./frontend/src/containers/TheContainer.vue?vue&type=style&index=0&id=2705e673&scoped=true&lang=css&":
/*!***********************************************************************************************************!*\
  !*** ./frontend/src/containers/TheContainer.vue?vue&type=style&index=0&id=2705e673&scoped=true&lang=css& ***!
  \***********************************************************************************************************/
/*! no static exports found */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_TheContainer_vue_vue_type_style_index_0_id_2705e673_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/style-loader!../../../node_modules/css-loader??ref--6-1!../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../node_modules/postcss-loader/src??ref--6-2!../../../node_modules/vue-loader/lib??vue-loader-options!./TheContainer.vue?vue&type=style&index=0&id=2705e673&scoped=true&lang=css& */ "./node_modules/style-loader/index.js!./node_modules/css-loader/index.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./frontend/src/containers/TheContainer.vue?vue&type=style&index=0&id=2705e673&scoped=true&lang=css&");
/* harmony import */ var _node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_TheContainer_vue_vue_type_style_index_0_id_2705e673_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_TheContainer_vue_vue_type_style_index_0_id_2705e673_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0__);
/* harmony reexport (unknown) */ for(var __WEBPACK_IMPORT_KEY__ in _node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_TheContainer_vue_vue_type_style_index_0_id_2705e673_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0__) if(["default"].indexOf(__WEBPACK_IMPORT_KEY__) < 0) (function(key) { __webpack_require__.d(__webpack_exports__, key, function() { return _node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_TheContainer_vue_vue_type_style_index_0_id_2705e673_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0__[key]; }) }(__WEBPACK_IMPORT_KEY__));


/***/ }),

/***/ "./frontend/src/containers/TheContainer.vue?vue&type=template&id=2705e673&scoped=true&":
/*!*********************************************************************************************!*\
  !*** ./frontend/src/containers/TheContainer.vue?vue&type=template&id=2705e673&scoped=true& ***!
  \*********************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TheContainer_vue_vue_type_template_id_2705e673_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../node_modules/vue-loader/lib??vue-loader-options!./TheContainer.vue?vue&type=template&id=2705e673&scoped=true& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./frontend/src/containers/TheContainer.vue?vue&type=template&id=2705e673&scoped=true&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TheContainer_vue_vue_type_template_id_2705e673_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TheContainer_vue_vue_type_template_id_2705e673_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./frontend/src/containers/TheFooter.vue":
/*!***********************************************!*\
  !*** ./frontend/src/containers/TheFooter.vue ***!
  \***********************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _TheFooter_vue_vue_type_template_id_e0469dce___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./TheFooter.vue?vue&type=template&id=e0469dce& */ "./frontend/src/containers/TheFooter.vue?vue&type=template&id=e0469dce&");
/* harmony import */ var _TheFooter_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./TheFooter.vue?vue&type=script&lang=js& */ "./frontend/src/containers/TheFooter.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _TheFooter_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _TheFooter_vue_vue_type_template_id_e0469dce___WEBPACK_IMPORTED_MODULE_0__["render"],
  _TheFooter_vue_vue_type_template_id_e0469dce___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "frontend/src/containers/TheFooter.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./frontend/src/containers/TheFooter.vue?vue&type=script&lang=js&":
/*!************************************************************************!*\
  !*** ./frontend/src/containers/TheFooter.vue?vue&type=script&lang=js& ***!
  \************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_TheFooter_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib??ref--4-0!../../../node_modules/vue-loader/lib??vue-loader-options!./TheFooter.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./frontend/src/containers/TheFooter.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_TheFooter_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./frontend/src/containers/TheFooter.vue?vue&type=template&id=e0469dce&":
/*!******************************************************************************!*\
  !*** ./frontend/src/containers/TheFooter.vue?vue&type=template&id=e0469dce& ***!
  \******************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TheFooter_vue_vue_type_template_id_e0469dce___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../node_modules/vue-loader/lib??vue-loader-options!./TheFooter.vue?vue&type=template&id=e0469dce& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./frontend/src/containers/TheFooter.vue?vue&type=template&id=e0469dce&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TheFooter_vue_vue_type_template_id_e0469dce___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TheFooter_vue_vue_type_template_id_e0469dce___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./frontend/src/containers/TheHeader.vue":
/*!***********************************************!*\
  !*** ./frontend/src/containers/TheHeader.vue ***!
  \***********************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _TheHeader_vue_vue_type_template_id_9de1d5ea___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./TheHeader.vue?vue&type=template&id=9de1d5ea& */ "./frontend/src/containers/TheHeader.vue?vue&type=template&id=9de1d5ea&");
/* harmony import */ var _TheHeader_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./TheHeader.vue?vue&type=script&lang=js& */ "./frontend/src/containers/TheHeader.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _TheHeader_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./TheHeader.vue?vue&type=style&index=0&lang=css& */ "./frontend/src/containers/TheHeader.vue?vue&type=style&index=0&lang=css&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");






/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__["default"])(
  _TheHeader_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _TheHeader_vue_vue_type_template_id_9de1d5ea___WEBPACK_IMPORTED_MODULE_0__["render"],
  _TheHeader_vue_vue_type_template_id_9de1d5ea___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "frontend/src/containers/TheHeader.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./frontend/src/containers/TheHeader.vue?vue&type=script&lang=js&":
/*!************************************************************************!*\
  !*** ./frontend/src/containers/TheHeader.vue?vue&type=script&lang=js& ***!
  \************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_TheHeader_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib??ref--4-0!../../../node_modules/vue-loader/lib??vue-loader-options!./TheHeader.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./frontend/src/containers/TheHeader.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_TheHeader_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./frontend/src/containers/TheHeader.vue?vue&type=style&index=0&lang=css&":
/*!********************************************************************************!*\
  !*** ./frontend/src/containers/TheHeader.vue?vue&type=style&index=0&lang=css& ***!
  \********************************************************************************/
/*! no static exports found */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_TheHeader_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/style-loader!../../../node_modules/css-loader??ref--6-1!../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../node_modules/postcss-loader/src??ref--6-2!../../../node_modules/vue-loader/lib??vue-loader-options!./TheHeader.vue?vue&type=style&index=0&lang=css& */ "./node_modules/style-loader/index.js!./node_modules/css-loader/index.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./frontend/src/containers/TheHeader.vue?vue&type=style&index=0&lang=css&");
/* harmony import */ var _node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_TheHeader_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_TheHeader_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_0__);
/* harmony reexport (unknown) */ for(var __WEBPACK_IMPORT_KEY__ in _node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_TheHeader_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_0__) if(["default"].indexOf(__WEBPACK_IMPORT_KEY__) < 0) (function(key) { __webpack_require__.d(__webpack_exports__, key, function() { return _node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_TheHeader_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_0__[key]; }) }(__WEBPACK_IMPORT_KEY__));


/***/ }),

/***/ "./frontend/src/containers/TheHeader.vue?vue&type=template&id=9de1d5ea&":
/*!******************************************************************************!*\
  !*** ./frontend/src/containers/TheHeader.vue?vue&type=template&id=9de1d5ea& ***!
  \******************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TheHeader_vue_vue_type_template_id_9de1d5ea___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../node_modules/vue-loader/lib??vue-loader-options!./TheHeader.vue?vue&type=template&id=9de1d5ea& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./frontend/src/containers/TheHeader.vue?vue&type=template&id=9de1d5ea&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TheHeader_vue_vue_type_template_id_9de1d5ea___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TheHeader_vue_vue_type_template_id_9de1d5ea___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./frontend/src/containers/TheHeaderDropdownAccnt.vue":
/*!************************************************************!*\
  !*** ./frontend/src/containers/TheHeaderDropdownAccnt.vue ***!
  \************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _TheHeaderDropdownAccnt_vue_vue_type_template_id_5ed6505b_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./TheHeaderDropdownAccnt.vue?vue&type=template&id=5ed6505b&scoped=true& */ "./frontend/src/containers/TheHeaderDropdownAccnt.vue?vue&type=template&id=5ed6505b&scoped=true&");
/* harmony import */ var _TheHeaderDropdownAccnt_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./TheHeaderDropdownAccnt.vue?vue&type=script&lang=js& */ "./frontend/src/containers/TheHeaderDropdownAccnt.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _TheHeaderDropdownAccnt_vue_vue_type_style_index_0_id_5ed6505b_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./TheHeaderDropdownAccnt.vue?vue&type=style&index=0&id=5ed6505b&scoped=true&lang=css& */ "./frontend/src/containers/TheHeaderDropdownAccnt.vue?vue&type=style&index=0&id=5ed6505b&scoped=true&lang=css&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");






/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__["default"])(
  _TheHeaderDropdownAccnt_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _TheHeaderDropdownAccnt_vue_vue_type_template_id_5ed6505b_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"],
  _TheHeaderDropdownAccnt_vue_vue_type_template_id_5ed6505b_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  "5ed6505b",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "frontend/src/containers/TheHeaderDropdownAccnt.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./frontend/src/containers/TheHeaderDropdownAccnt.vue?vue&type=script&lang=js&":
/*!*************************************************************************************!*\
  !*** ./frontend/src/containers/TheHeaderDropdownAccnt.vue?vue&type=script&lang=js& ***!
  \*************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_TheHeaderDropdownAccnt_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib??ref--4-0!../../../node_modules/vue-loader/lib??vue-loader-options!./TheHeaderDropdownAccnt.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./frontend/src/containers/TheHeaderDropdownAccnt.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_TheHeaderDropdownAccnt_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./frontend/src/containers/TheHeaderDropdownAccnt.vue?vue&type=style&index=0&id=5ed6505b&scoped=true&lang=css&":
/*!*********************************************************************************************************************!*\
  !*** ./frontend/src/containers/TheHeaderDropdownAccnt.vue?vue&type=style&index=0&id=5ed6505b&scoped=true&lang=css& ***!
  \*********************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_TheHeaderDropdownAccnt_vue_vue_type_style_index_0_id_5ed6505b_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/style-loader!../../../node_modules/css-loader??ref--6-1!../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../node_modules/postcss-loader/src??ref--6-2!../../../node_modules/vue-loader/lib??vue-loader-options!./TheHeaderDropdownAccnt.vue?vue&type=style&index=0&id=5ed6505b&scoped=true&lang=css& */ "./node_modules/style-loader/index.js!./node_modules/css-loader/index.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./frontend/src/containers/TheHeaderDropdownAccnt.vue?vue&type=style&index=0&id=5ed6505b&scoped=true&lang=css&");
/* harmony import */ var _node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_TheHeaderDropdownAccnt_vue_vue_type_style_index_0_id_5ed6505b_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_TheHeaderDropdownAccnt_vue_vue_type_style_index_0_id_5ed6505b_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0__);
/* harmony reexport (unknown) */ for(var __WEBPACK_IMPORT_KEY__ in _node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_TheHeaderDropdownAccnt_vue_vue_type_style_index_0_id_5ed6505b_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0__) if(["default"].indexOf(__WEBPACK_IMPORT_KEY__) < 0) (function(key) { __webpack_require__.d(__webpack_exports__, key, function() { return _node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_TheHeaderDropdownAccnt_vue_vue_type_style_index_0_id_5ed6505b_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0__[key]; }) }(__WEBPACK_IMPORT_KEY__));


/***/ }),

/***/ "./frontend/src/containers/TheHeaderDropdownAccnt.vue?vue&type=template&id=5ed6505b&scoped=true&":
/*!*******************************************************************************************************!*\
  !*** ./frontend/src/containers/TheHeaderDropdownAccnt.vue?vue&type=template&id=5ed6505b&scoped=true& ***!
  \*******************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TheHeaderDropdownAccnt_vue_vue_type_template_id_5ed6505b_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../node_modules/vue-loader/lib??vue-loader-options!./TheHeaderDropdownAccnt.vue?vue&type=template&id=5ed6505b&scoped=true& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./frontend/src/containers/TheHeaderDropdownAccnt.vue?vue&type=template&id=5ed6505b&scoped=true&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TheHeaderDropdownAccnt_vue_vue_type_template_id_5ed6505b_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TheHeaderDropdownAccnt_vue_vue_type_template_id_5ed6505b_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./frontend/src/containers/TheSidebar.vue":
/*!************************************************!*\
  !*** ./frontend/src/containers/TheSidebar.vue ***!
  \************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _TheSidebar_vue_vue_type_template_id_1463ee4e___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./TheSidebar.vue?vue&type=template&id=1463ee4e& */ "./frontend/src/containers/TheSidebar.vue?vue&type=template&id=1463ee4e&");
/* harmony import */ var _TheSidebar_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./TheSidebar.vue?vue&type=script&lang=js& */ "./frontend/src/containers/TheSidebar.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _TheSidebar_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _TheSidebar_vue_vue_type_template_id_1463ee4e___WEBPACK_IMPORTED_MODULE_0__["render"],
  _TheSidebar_vue_vue_type_template_id_1463ee4e___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "frontend/src/containers/TheSidebar.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./frontend/src/containers/TheSidebar.vue?vue&type=script&lang=js&":
/*!*************************************************************************!*\
  !*** ./frontend/src/containers/TheSidebar.vue?vue&type=script&lang=js& ***!
  \*************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_TheSidebar_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib??ref--4-0!../../../node_modules/vue-loader/lib??vue-loader-options!./TheSidebar.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./frontend/src/containers/TheSidebar.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_TheSidebar_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./frontend/src/containers/TheSidebar.vue?vue&type=template&id=1463ee4e&":
/*!*******************************************************************************!*\
  !*** ./frontend/src/containers/TheSidebar.vue?vue&type=template&id=1463ee4e& ***!
  \*******************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TheSidebar_vue_vue_type_template_id_1463ee4e___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../node_modules/vue-loader/lib??vue-loader-options!./TheSidebar.vue?vue&type=template&id=1463ee4e& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./frontend/src/containers/TheSidebar.vue?vue&type=template&id=1463ee4e&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TheSidebar_vue_vue_type_template_id_1463ee4e___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TheSidebar_vue_vue_type_template_id_1463ee4e___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./frontend/src/containers/Menu.vue?vue&type=script&lang=js&":
/*!***************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./frontend/src/containers/Menu.vue?vue&type=script&lang=js& ***!
  \***************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var axios__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! axios */ "./frontend/node_modules/axios/index.js");
/* harmony import */ var axios__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(axios__WEBPACK_IMPORTED_MODULE_0__);
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//

/* harmony default export */ __webpack_exports__["default"] = ({
  name: 'Menu',
  data: function data() {
    return {
      //minimize: false,
      nav: [],
      //show: true,
      buffor: []
    };
  },
  methods: {
    dropdown: function dropdown(data) {
      var result = {
        _name: 'CSidebarNavDropdown',
        name: data['name'],
        route: data['href'],
        icon: data['icon'],
        _children: []
      };

      for (var i = 0; i < data['elements'].length; i++) {
        if (data['elements'][i]['slug'] == 'dropdown') {
          result._children.push(this.dropdown(data['elements'][i]));
        } else {
          result._children.push({
            _name: 'CSidebarNavItem',
            name: data['elements'][i]['name'],
            to: data['elements'][i]['href'],
            icon: data['elements'][i]['icon']
          });
        }
      }

      return result;
    },
    rebuildData: function rebuildData(data) {
      this.buffor = [];

      for (var k = 0; k < data.length; k++) {
        switch (data[k]['slug']) {
          case 'link':
            if (data[k]['href'].indexOf('http') !== -1) {
              this.buffor.push({
                _name: 'CSidebarNavItem',
                name: data[k]['name'],
                href: data[k]['href'],
                icon: data[k]['icon'],
                target: '_blank'
              });
            } else {
              this.buffor.push({
                _name: 'CSidebarNavItem',
                name: data[k]['name'],
                to: data[k]['href'],
                icon: data[k]['icon']
              });
            }

            break;

          case 'title':
            this.buffor.push({
              _name: 'CSidebarNavTitle',
              _children: [data[k]['name']]
            });
            break;

          case 'dropdown':
            this.buffor.push(this.dropdown(data[k]));
            break;
        }
      }

      return this.buffor;
    }
  },
  mounted: function mounted() {
    var self = this;
    var locale = 'en';

    if (typeof localStorage.locale !== 'undefined') {
      locale = localStorage.getItem("locale");
    }

    axios__WEBPACK_IMPORTED_MODULE_0___default.a.get('/api/menu?token=' + localStorage.getItem("api_token") + '&menu=' + 'top_menu' + '&locale=' + locale).then(function (response) {
      self.nav = self.rebuildData(response.data);
    })["catch"](function (error) {
      console.log(error);
      self.$router.push({
        path: '/login'
      });
    });
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./frontend/src/containers/TheContainer.vue?vue&type=script&lang=js&":
/*!***********************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./frontend/src/containers/TheContainer.vue?vue&type=script&lang=js& ***!
  \***********************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _TheSidebar__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./TheSidebar */ "./frontend/src/containers/TheSidebar.vue");
/* harmony import */ var _TheHeader__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./TheHeader */ "./frontend/src/containers/TheHeader.vue");
/* harmony import */ var _TheFooter__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./TheFooter */ "./frontend/src/containers/TheFooter.vue");
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//


 // import TheAside from './TheAside'

/* harmony default export */ __webpack_exports__["default"] = ({
  name: 'TheContainer',
  components: {
    TheSidebar: _TheSidebar__WEBPACK_IMPORTED_MODULE_0__["default"],
    TheHeader: _TheHeader__WEBPACK_IMPORTED_MODULE_1__["default"],
    TheFooter: _TheFooter__WEBPACK_IMPORTED_MODULE_2__["default"] // TheAside

  },
  data: function data() {
    return {
      locale: 'en'
    };
  },
  methods: {
    changeLocale: function changeLocale(value) {
      this.locale = value;
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./frontend/src/containers/TheFooter.vue?vue&type=script&lang=js&":
/*!********************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./frontend/src/containers/TheFooter.vue?vue&type=script&lang=js& ***!
  \********************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
//
//
//
//
/* harmony default export */ __webpack_exports__["default"] = ({
  name: 'TheFooter'
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./frontend/src/containers/TheHeader.vue?vue&type=script&lang=js&":
/*!********************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./frontend/src/containers/TheHeader.vue?vue&type=script&lang=js& ***!
  \********************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _TheHeaderDropdownAccnt__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./TheHeaderDropdownAccnt */ "./frontend/src/containers/TheHeaderDropdownAccnt.vue");
/* harmony import */ var v_offline__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! v-offline */ "./frontend/node_modules/v-offline/dist/v-offline.esm.js");
/* harmony import */ var _Menu__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./Menu */ "./frontend/src/containers/Menu.vue");
/* harmony import */ var axios__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! axios */ "./frontend/node_modules/axios/index.js");
/* harmony import */ var axios__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(axios__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var _codinglabs_laravel_asset__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @codinglabs/laravel-asset */ "./frontend/node_modules/@codinglabs/laravel-asset/asset.js");
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
 // import TheHeaderDropdownNotif from './TheHeaderDropdownNotif'
// import TheHeaderDropdownTasks from './TheHeaderDropdownTasks'
// import TheHeaderDropdownMssgs from './TheHeaderDropdownMssgs'





/* harmony default export */ __webpack_exports__["default"] = ({
  name: "TheHeader",
  components: {
    TheHeaderDropdownAccnt: _TheHeaderDropdownAccnt__WEBPACK_IMPORTED_MODULE_0__["default"],
    // TheHeaderDropdownNotif,
    // TheHeaderDropdownTasks,
    // TheHeaderDropdownMssgs,
    CMenu: _Menu__WEBPACK_IMPORTED_MODULE_2__["default"],
    VOffline: v_offline__WEBPACK_IMPORTED_MODULE_1__["default"]
  },
  data: function data() {
    var locale = localStorage.getItem("locale") || "en";
    return {
      langs: [],
      locale: locale,
      onLine: null,
      onlineText: "",
      onlineSlot: "online",
      offlineSlot: "offline",
      logoImg: Object(_codinglabs_laravel_asset__WEBPACK_IMPORTED_MODULE_4__["asset"])("/img/logo.jpg")
    };
  },
  methods: {
    handleChange: function handleChange(event) {
      localStorage.setItem("locale", event.target.value);
      window.location.reload();
    },
    selectLocale: function selectLocale(option) {
      localStorage.setItem("locale", option);
      this.$i18n.set(option); //location.reload()

      this.$emit("change-locale", option);
    },
    amIOnline: function amIOnline(e) {
      this.onLine = e;

      if (e === true) {
        if (this.myLang == "en") {
          this.onlineText = "OnLine";
        } else {
          this.onlineText = "متصل";
        }
      } else {
        if (this.myLang == "en") {
          this.onlineText = "OffLine";
        } else {
          this.onlineText = "خامل";
        }
      }
    },
    handleSideBar: function handleSideBar() {
      var sideBar = document.getElementById("my-sidebar");
      sideBar.classList.toggle("c-sidebar-show");
    },
    getLocale: function getLocale() {
      var locale;
      locale = localStorage.getItem("locale") || "en";
      this.myLang = locale;
    }
  },
  mounted: function mounted() {
    var self = this;

    if (typeof localStorage.locale !== "undefined") {
      this.locale = localStorage.getItem("locale");
    }

    axios__WEBPACK_IMPORTED_MODULE_3___default.a.get("/api/langlist?token=" + localStorage.getItem("api_token")).then(function (response) {
      console.log(response.data);
      self.langs = [];

      for (var i = 0; i < response.data.length; i++) {
        self.langs.push({
          value: response.data[i].short_name,
          label: response.data[i].name
        });
      }
    })["catch"](function (error) {
      console.log(error);
      self.$router.push({
        path: "/login"
      });
    });
    this.getLocale();
  },
  created: function created() {
    var self = this;
    this.$pusher.connection.bind("unavailable", function () {
      console.log(self.onLine); // if (self.onLine === true || self.onLine === null) {
      //   window.open("https://soc.twistfleet.com:6001", "_blank");
      //   location.reload();
      // }

      setInterval(function () {}, 500);
    });
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./frontend/src/containers/TheHeaderDropdownAccnt.vue?vue&type=script&lang=js&":
/*!*********************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./frontend/src/containers/TheHeaderDropdownAccnt.vue?vue&type=script&lang=js& ***!
  \*********************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var axios__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! axios */ "./frontend/node_modules/axios/index.js");
/* harmony import */ var axios__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(axios__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _codinglabs_laravel_asset__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @codinglabs/laravel-asset */ "./frontend/node_modules/@codinglabs/laravel-asset/asset.js");
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//


/* harmony default export */ __webpack_exports__["default"] = ({
  name: 'TheHeaderDropdownAccnt',
  data: function data() {
    return {
      itemsCount: 42,
      avatarImg: Object(_codinglabs_laravel_asset__WEBPACK_IMPORTED_MODULE_1__["asset"])('img/avatars/1.png')
    };
  },
  methods: {
    logout: function logout() {
      var self = this;
      axios__WEBPACK_IMPORTED_MODULE_0___default.a.post('/api/logout?token=' + localStorage.getItem("api_token"), {}).then(function (response) {
        localStorage.removeItem("api_token");
        self.$router.push({
          path: '/login'
        });
      })["catch"](function (error) {
        console.log(error);
      });
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./frontend/src/containers/TheSidebar.vue?vue&type=script&lang=js&":
/*!*********************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./frontend/src/containers/TheSidebar.vue?vue&type=script&lang=js& ***!
  \*********************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var axios__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! axios */ "./frontend/node_modules/axios/index.js");
/* harmony import */ var axios__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(axios__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _codinglabs_laravel_asset__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @codinglabs/laravel-asset */ "./frontend/node_modules/@codinglabs/laravel-asset/asset.js");
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//


/* harmony default export */ __webpack_exports__["default"] = ({
  name: 'TheSidebar',
  props: ['locale'],
  data: function data() {
    return {
      minimize: true,
      nav: [],
      show: 'responsive',
      buffor: [],
      logoImg: Object(_codinglabs_laravel_asset__WEBPACK_IMPORTED_MODULE_1__["asset"])('/img/logo1.png'),
      sideBarImg: Object(_codinglabs_laravel_asset__WEBPACK_IMPORTED_MODULE_1__["asset"])('/img/img_sidebar.jpg')
    };
  },
  methods: {
    dropdown: function dropdown(data) {
      var result = {
        _name: 'CSidebarNavDropdown',
        name: data['name'],
        route: data['href'],
        icon: data['icon'],
        _children: []
      };

      for (var i = 0; i < data['elements'].length; i++) {
        if (data['elements'][i]['slug'] == 'dropdown') {
          result._children.push(this.dropdown(data['elements'][i]));
        } else {
          result._children.push({
            _name: 'CSidebarNavItem',
            name: data['elements'][i]['name'],
            to: data['elements'][i]['href'],
            icon: data['elements'][i]['icon']
          });
        }
      }

      return result;
    },
    rebuildData: function rebuildData(data) {
      this.buffor = [{
        _name: 'CSidebarNav',
        _children: []
      }];

      for (var k = 0; k < data.length; k++) {
        switch (data[k]['slug']) {
          case 'link':
            if (data[k]['href'].indexOf('http') !== -1) {
              this.buffor[0]._children.push({
                _name: 'CSidebarNavItem',
                name: data[k]['name'],
                href: data[k]['href'],
                icon: data[k]['icon'],
                target: '_blank'
              });
            } else {
              this.buffor[0]._children.push({
                _name: 'CSidebarNavItem',
                name: data[k]['name'],
                to: data[k]['href'],
                icon: data[k]['icon']
              });
            }

            break;

          case 'title':
            this.buffor[0]._children.push({
              _name: 'CSidebarNavTitle',
              _children: [data[k]['name']]
            });

            break;

          case 'dropdown':
            this.buffor[0]._children.push(this.dropdown(data[k]));

            break;
        }
      }

      return this.buffor;
    },
    downloadSidebarData: function downloadSidebarData() {
      var self = this;
      var locale = 'en';

      if (typeof localStorage.locale !== 'undefined') {
        locale = localStorage.getItem("locale");
      }

      axios__WEBPACK_IMPORTED_MODULE_0___default.a.get('/api/menu?token=' + localStorage.getItem("api_token") + '&locale=' + this.locale).then(function (response) {
        self.nav = self.rebuildData(response.data);
        console.log("nav" + response.data);
      })["catch"](function (error) {
        console.log(error);
        self.$router.push({
          path: '/login'
        });
      });
    }
  },
  watch: {
    locale: function locale(newVal, oldVal) {
      // watch it
      this.downloadSidebarData();
    }
  },
  mounted: function mounted() {
    var _this = this;

    this.$root.$on('toggle-sidebar', function () {
      var sidebarOpened = _this.show === true || _this.show === 'responsive';
      _this.show = sidebarOpened ? false : 'responsive';
    });
    this.$root.$on('toggle-sidebar-mobile', function () {
      var sidebarClosed = _this.show === 'responsive' || _this.show === false;
      _this.show = sidebarClosed ? true : 'responsive';
    });
    this.downloadSidebarData();
  }
});

/***/ }),

/***/ "./node_modules/css-loader/index.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./frontend/src/containers/TheContainer.vue?vue&type=style&index=0&id=2705e673&scoped=true&lang=css&":
/*!******************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader??ref--6-1!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src??ref--6-2!./node_modules/vue-loader/lib??vue-loader-options!./frontend/src/containers/TheContainer.vue?vue&type=style&index=0&id=2705e673&scoped=true&lang=css& ***!
  \******************************************************************************************************************************************************************************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(/*! ../../../node_modules/css-loader/lib/css-base.js */ "./node_modules/css-loader/lib/css-base.js")(false);
// imports


// module
exports.push([module.i, "\n.fade-enter-active[data-v-2705e673],\n.fade-leave-active[data-v-2705e673] {\n  -webkit-transition: opacity 0.3s;\n  transition: opacity 0.3s;\n}\n.fade-enter[data-v-2705e673],\n.fade-leave-to[data-v-2705e673] {\n  opacity: 0;\n}\n", ""]);

// exports


/***/ }),

/***/ "./node_modules/css-loader/index.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./frontend/src/containers/TheHeader.vue?vue&type=style&index=0&lang=css&":
/*!***************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader??ref--6-1!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src??ref--6-2!./node_modules/vue-loader/lib??vue-loader-options!./frontend/src/containers/TheHeader.vue?vue&type=style&index=0&lang=css& ***!
  \***************************************************************************************************************************************************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(/*! ../../../node_modules/css-loader/lib/css-base.js */ "./node_modules/css-loader/lib/css-base.js")(false);
// imports


// module
exports.push([module.i, "\n.offline {\n  background-color: #fc9842;\n  background-image: linear-gradient(315deg, #fc9842 0%, #fe5f75 74%);\n}\n.online {\n  background-color: #00b712;\n  background-image: linear-gradient(315deg, #00b712 0%, #5aff15 74%);\n}\n.offline,\n.online {\n  padding: 10px;\n  border-radius: 20px;\n  color: white;\n}\n", ""]);

// exports


/***/ }),

/***/ "./node_modules/css-loader/index.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./frontend/src/containers/TheHeaderDropdownAccnt.vue?vue&type=style&index=0&id=5ed6505b&scoped=true&lang=css&":
/*!****************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader??ref--6-1!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src??ref--6-2!./node_modules/vue-loader/lib??vue-loader-options!./frontend/src/containers/TheHeaderDropdownAccnt.vue?vue&type=style&index=0&id=5ed6505b&scoped=true&lang=css& ***!
  \****************************************************************************************************************************************************************************************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(/*! ../../../node_modules/css-loader/lib/css-base.js */ "./node_modules/css-loader/lib/css-base.js")(false);
// imports


// module
exports.push([module.i, "\n.c-icon[data-v-5ed6505b] {\n  margin-right: 0.3rem;\n}\n", ""]);

// exports


/***/ }),

/***/ "./node_modules/style-loader/index.js!./node_modules/css-loader/index.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./frontend/src/containers/TheContainer.vue?vue&type=style&index=0&id=2705e673&scoped=true&lang=css&":
/*!**********************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader!./node_modules/css-loader??ref--6-1!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src??ref--6-2!./node_modules/vue-loader/lib??vue-loader-options!./frontend/src/containers/TheContainer.vue?vue&type=style&index=0&id=2705e673&scoped=true&lang=css& ***!
  \**********************************************************************************************************************************************************************************************************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {


var content = __webpack_require__(/*! !../../../node_modules/css-loader??ref--6-1!../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../node_modules/postcss-loader/src??ref--6-2!../../../node_modules/vue-loader/lib??vue-loader-options!./TheContainer.vue?vue&type=style&index=0&id=2705e673&scoped=true&lang=css& */ "./node_modules/css-loader/index.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./frontend/src/containers/TheContainer.vue?vue&type=style&index=0&id=2705e673&scoped=true&lang=css&");

if(typeof content === 'string') content = [[module.i, content, '']];

var transform;
var insertInto;



var options = {"hmr":true}

options.transform = transform
options.insertInto = undefined;

var update = __webpack_require__(/*! ../../../node_modules/style-loader/lib/addStyles.js */ "./node_modules/style-loader/lib/addStyles.js")(content, options);

if(content.locals) module.exports = content.locals;

if(false) {}

/***/ }),

/***/ "./node_modules/style-loader/index.js!./node_modules/css-loader/index.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./frontend/src/containers/TheHeader.vue?vue&type=style&index=0&lang=css&":
/*!*******************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader!./node_modules/css-loader??ref--6-1!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src??ref--6-2!./node_modules/vue-loader/lib??vue-loader-options!./frontend/src/containers/TheHeader.vue?vue&type=style&index=0&lang=css& ***!
  \*******************************************************************************************************************************************************************************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {


var content = __webpack_require__(/*! !../../../node_modules/css-loader??ref--6-1!../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../node_modules/postcss-loader/src??ref--6-2!../../../node_modules/vue-loader/lib??vue-loader-options!./TheHeader.vue?vue&type=style&index=0&lang=css& */ "./node_modules/css-loader/index.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./frontend/src/containers/TheHeader.vue?vue&type=style&index=0&lang=css&");

if(typeof content === 'string') content = [[module.i, content, '']];

var transform;
var insertInto;



var options = {"hmr":true}

options.transform = transform
options.insertInto = undefined;

var update = __webpack_require__(/*! ../../../node_modules/style-loader/lib/addStyles.js */ "./node_modules/style-loader/lib/addStyles.js")(content, options);

if(content.locals) module.exports = content.locals;

if(false) {}

/***/ }),

/***/ "./node_modules/style-loader/index.js!./node_modules/css-loader/index.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./frontend/src/containers/TheHeaderDropdownAccnt.vue?vue&type=style&index=0&id=5ed6505b&scoped=true&lang=css&":
/*!********************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader!./node_modules/css-loader??ref--6-1!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src??ref--6-2!./node_modules/vue-loader/lib??vue-loader-options!./frontend/src/containers/TheHeaderDropdownAccnt.vue?vue&type=style&index=0&id=5ed6505b&scoped=true&lang=css& ***!
  \********************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {


var content = __webpack_require__(/*! !../../../node_modules/css-loader??ref--6-1!../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../node_modules/postcss-loader/src??ref--6-2!../../../node_modules/vue-loader/lib??vue-loader-options!./TheHeaderDropdownAccnt.vue?vue&type=style&index=0&id=5ed6505b&scoped=true&lang=css& */ "./node_modules/css-loader/index.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./frontend/src/containers/TheHeaderDropdownAccnt.vue?vue&type=style&index=0&id=5ed6505b&scoped=true&lang=css&");

if(typeof content === 'string') content = [[module.i, content, '']];

var transform;
var insertInto;



var options = {"hmr":true}

options.transform = transform
options.insertInto = undefined;

var update = __webpack_require__(/*! ../../../node_modules/style-loader/lib/addStyles.js */ "./node_modules/style-loader/lib/addStyles.js")(content, options);

if(content.locals) module.exports = content.locals;

if(false) {}

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./frontend/src/containers/Menu.vue?vue&type=template&id=5df79c42&":
/*!*******************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./frontend/src/containers/Menu.vue?vue&type=template&id=5df79c42& ***!
  \*******************************************************************************************************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "render", function() { return render; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return staticRenderFns; });
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "CHeaderNav",
    { staticClass: "d-md-down-none mr-auto" },
    _vm._l(_vm.nav, function(n) {
      return _c(
        "CHeaderNavItem",
        { key: n.name },
        [
          n._name == "CSidebarNavItem"
            ? _c("CHeaderNavLink", { attrs: { href: "#" + n.href } }, [
                _vm._v("\n      " + _vm._s(n.name) + "\n    ")
              ])
            : _vm._e(),
          _vm._v(" "),
          n._name == "CSidebarNavDropdown"
            ? _c(
                "CDropdown",
                {
                  attrs: { color: "link", caret: false },
                  scopedSlots: _vm._u(
                    [
                      {
                        key: "toggler-content",
                        fn: function() {
                          return [
                            _c("a", { staticClass: "c-header-nav-link" }, [
                              _vm._v(
                                "\n          " + _vm._s(n.name) + "\n        "
                              )
                            ])
                          ]
                        },
                        proxy: true
                      }
                    ],
                    null,
                    true
                  )
                },
                [
                  _vm._v(" "),
                  _vm._l(n._children, function(d) {
                    return _c(
                      "CDropdownItem",
                      { key: d.name, attrs: { href: "#" + d.to } },
                      [_vm._v("\n        " + _vm._s(d.name) + "\n      ")]
                    )
                  })
                ],
                2
              )
            : _vm._e()
        ],
        1
      )
    }),
    1
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./frontend/src/containers/TheContainer.vue?vue&type=template&id=2705e673&scoped=true&":
/*!***************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./frontend/src/containers/TheContainer.vue?vue&type=template&id=2705e673&scoped=true& ***!
  \***************************************************************************************************************************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "render", function() { return render; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return staticRenderFns; });
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "div",
    {
      staticClass: "c-app",
      class: { "c-dark-theme": _vm.$store.state.darkMode }
    },
    [
      _c("TheSidebar", { attrs: { locale: _vm.locale } }),
      _vm._v(" "),
      _c(
        "CWrapper",
        [
          _c("TheHeader", { on: { "change-locale": _vm.changeLocale } }),
          _vm._v(" "),
          _c(
            "div",
            { staticClass: "c-body" },
            [
              _c(
                "main",
                { staticClass: "c-main" },
                [
                  _c(
                    "CContainer",
                    { attrs: { fluid: "" } },
                    [
                      _c(
                        "transition",
                        { attrs: { name: "fade" } },
                        [_c("router-view")],
                        1
                      )
                    ],
                    1
                  )
                ],
                1
              ),
              _vm._v(" "),
              _c("TheFooter")
            ],
            1
          )
        ],
        1
      )
    ],
    1
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./frontend/src/containers/TheFooter.vue?vue&type=template&id=e0469dce&":
/*!************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./frontend/src/containers/TheFooter.vue?vue&type=template&id=e0469dce& ***!
  \************************************************************************************************************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "render", function() { return render; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return staticRenderFns; });
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div")
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./frontend/src/containers/TheHeader.vue?vue&type=template&id=9de1d5ea&":
/*!************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./frontend/src/containers/TheHeader.vue?vue&type=template&id=9de1d5ea& ***!
  \************************************************************************************************************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "render", function() { return render; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return staticRenderFns; });
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "CHeader",
    { attrs: { "with-subheader": "" } },
    [
      _c("CToggler", {
        staticClass: "ml-3 d-lg-none",
        attrs: { "in-header": "" },
        on: {
          click: function($event) {
            return _vm.handleSideBar()
          }
        }
      }),
      _vm._v(" "),
      _c("CToggler", {
        staticClass: "ml-3 d-md-down-none",
        attrs: { "in-header": "" },
        on: {
          click: function($event) {
            return _vm.$store.commit("toggleSidebarDesktop")
          }
        }
      }),
      _vm._v(" "),
      _c(
        "CHeaderBrand",
        { staticClass: "mx-auto d-lg-none", attrs: { to: "/" } },
        [_c("CIcon", { attrs: { name: "logo", height: "48", alt: "Logo" } })],
        1
      ),
      _vm._v(" "),
      _c("CHeaderNav", [
        _c(
          "select",
          {
            directives: [
              {
                name: "model",
                rawName: "v-model",
                value: _vm.locale,
                expression: "locale"
              }
            ],
            staticClass: "custom-select",
            on: {
              change: [
                function($event) {
                  var $$selectedVal = Array.prototype.filter
                    .call($event.target.options, function(o) {
                      return o.selected
                    })
                    .map(function(o) {
                      var val = "_value" in o ? o._value : o.value
                      return val
                    })
                  _vm.locale = $event.target.multiple
                    ? $$selectedVal
                    : $$selectedVal[0]
                },
                function($event) {
                  return _vm.handleChange($event)
                }
              ]
            }
          },
          [
            _c("option", { attrs: { value: "en" } }, [_vm._v("English")]),
            _vm._v(" "),
            _c("option", { attrs: { value: "ar" } }, [_vm._v("عربى")])
          ]
        )
      ]),
      _vm._v(" "),
      _c(
        "div",
        {
          staticClass:
            "mr-auto text-center my-desc d-flex justify-content-center"
        },
        [
          _c("img", {
            staticClass: "mylogo-bar",
            attrs: { hidden: "", src: _vm.logoImg }
          })
        ]
      ),
      _vm._v(" "),
      _c(
        "CHeaderNav",
        [
          _c("CHeaderNavItem", { staticClass: "px-3" }, [
            _c(
              "button",
              {
                staticClass: "c-header-nav-btn",
                on: {
                  click: function() {
                    return _vm.$store.commit("toggle", "darkMode")
                  }
                }
              },
              [
                _vm.$store.state.darkMode
                  ? _c("CIcon", { attrs: { name: "cil-sun" } })
                  : _c("CIcon", { attrs: { name: "cil-moon" } })
              ],
              1
            )
          ]),
          _vm._v(" "),
          _c("TheHeaderDropdownAccnt")
        ],
        1
      )
    ],
    1
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./frontend/src/containers/TheHeaderDropdownAccnt.vue?vue&type=template&id=5ed6505b&scoped=true&":
/*!*************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./frontend/src/containers/TheHeaderDropdownAccnt.vue?vue&type=template&id=5ed6505b&scoped=true& ***!
  \*************************************************************************************************************************************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "render", function() { return render; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return staticRenderFns; });
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "CDropdown",
    {
      staticClass: "c-header-nav-items",
      attrs: { inNav: "", placement: "bottom-end", "add-menu-classes": "pt-0" },
      scopedSlots: _vm._u([
        {
          key: "toggler",
          fn: function() {
            return [
              _c("CHeaderNavLink", [
                _c("div", { staticClass: "c-avatar" }, [
                  _c("img", {
                    staticClass: "c-avatar-img ",
                    attrs: { src: _vm.avatarImg }
                  })
                ])
              ])
            ]
          },
          proxy: true
        }
      ])
    },
    [
      _vm._v(" "),
      _c(
        "CDropdownItem",
        {
          on: {
            click: function($event) {
              return _vm.logout()
            }
          }
        },
        [
          _c("CIcon", { attrs: { name: "cil-lock-locked" } }),
          _vm._v(" Logout\n    ")
        ],
        1
      )
    ],
    1
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./frontend/src/containers/TheSidebar.vue?vue&type=template&id=1463ee4e&":
/*!*************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./frontend/src/containers/TheSidebar.vue?vue&type=template&id=1463ee4e& ***!
  \*************************************************************************************************************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "render", function() { return render; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return staticRenderFns; });
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "CSidebar",
    {
      attrs: {
        id: "my-sidebar",
        minimize: _vm.minimize,
        unfoldable: "",
        show: _vm.show
      },
      on: {
        "update:show": function(value) {
          return _vm.$store.commit("set", ["sidebarShow", value])
        }
      }
    },
    [
      _c(
        "CSidebarBrand",
        { staticClass: "d-md-down-none", attrs: { to: "/" } },
        [_c("img", { staticClass: "the-logo", attrs: { src: _vm.logoImg } })]
      ),
      _vm._v(" "),
      _c("CRenderFunction", { attrs: { flat: "", contentToRender: _vm.nav } })
    ],
    1
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ })

}]);