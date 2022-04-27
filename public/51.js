(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[51],{

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

/***/ "./frontend/src/views/pages/Login.vue":
/*!********************************************!*\
  !*** ./frontend/src/views/pages/Login.vue ***!
  \********************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _Login_vue_vue_type_template_id_851b8bfa___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Login.vue?vue&type=template&id=851b8bfa& */ "./frontend/src/views/pages/Login.vue?vue&type=template&id=851b8bfa&");
/* harmony import */ var _Login_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Login.vue?vue&type=script&lang=js& */ "./frontend/src/views/pages/Login.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _Login_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _Login_vue_vue_type_template_id_851b8bfa___WEBPACK_IMPORTED_MODULE_0__["render"],
  _Login_vue_vue_type_template_id_851b8bfa___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "frontend/src/views/pages/Login.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./frontend/src/views/pages/Login.vue?vue&type=script&lang=js&":
/*!*********************************************************************!*\
  !*** ./frontend/src/views/pages/Login.vue?vue&type=script&lang=js& ***!
  \*********************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Login_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./Login.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./frontend/src/views/pages/Login.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Login_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./frontend/src/views/pages/Login.vue?vue&type=template&id=851b8bfa&":
/*!***************************************************************************!*\
  !*** ./frontend/src/views/pages/Login.vue?vue&type=template&id=851b8bfa& ***!
  \***************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Login_vue_vue_type_template_id_851b8bfa___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib??vue-loader-options!./Login.vue?vue&type=template&id=851b8bfa& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./frontend/src/views/pages/Login.vue?vue&type=template&id=851b8bfa&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Login_vue_vue_type_template_id_851b8bfa___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Login_vue_vue_type_template_id_851b8bfa___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./frontend/src/views/pages/Login.vue?vue&type=script&lang=js&":
/*!*****************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./frontend/src/views/pages/Login.vue?vue&type=script&lang=js& ***!
  \*****************************************************************************************************************************************************************/
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
  name: "Login",
  data: function data() {
    return {
      email: "",
      password: "",
      showMessage: false,
      message: "",
      alertColor: "",
      dismissCountDown: 3,
      logoImg: Object(_codinglabs_laravel_asset__WEBPACK_IMPORTED_MODULE_1__["asset"])("/img/logo.jpg")
    };
  },
  methods: {
    goRegister: function goRegister() {
      this.$router.push({
        path: "reset"
      });
    },
    login: function login() {
      var self = this;
      axios__WEBPACK_IMPORTED_MODULE_0___default.a.post("/api/login", {
        email: self.email,
        password: self.password
      }).then(function (response) {
        self.email = "";
        self.password = "";
        localStorage.setItem("api_token", response.data.access_token); // localStorage.setItem("role", response.data.menuroles);

        console.log("");
        console.log(response.data);
        self.$router.push({
          path: "/orders"
        });
      })["catch"](function (error) {
        self.alertColor = "danger";
        self.message = "Incorrect E-mail or password";
        self.showMessage = true;
        self.showAlert();
        console.log(error);
      });
    },
    countDownChanged: function countDownChanged(dismissCountDown) {
      this.dismissCountDown = dismissCountDown;
    },
    showAlert: function showAlert() {
      this.dismissCountDown = this.dismissSecs;
    }
  },
  mounted: function mounted() {
    var self = this;

    if (localStorage.getItem("api_token") !== null) {
      axios__WEBPACK_IMPORTED_MODULE_0___default.a.post("/api/refresh?token=" + localStorage.getItem("api_token")).then(function (response) {
        console.log(response);
        localStorage.setItem("api_token", response.data.access_token);
        self.$router.push({
          path: "/maps/show"
        });
      })["catch"](function (error) {
        localStorage.removeItem("api_token");
        self.$router.push({
          path: "/login"
        });
      });
    }
  }
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./frontend/src/views/pages/Login.vue?vue&type=template&id=851b8bfa&":
/*!*********************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./frontend/src/views/pages/Login.vue?vue&type=template&id=851b8bfa& ***!
  \*********************************************************************************************************************************************************************************************************/
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
    { staticClass: "min-vh-100" },
    [
      _c("h2", { staticClass: "py-4 text-center the-main-brand" }, [
        _c("img", { staticClass: "mylogo", attrs: { src: _vm.logoImg } })
      ]),
      _vm._v(" "),
      _c(
        "CContainer",
        { staticClass: "d-flex content-center mt-3 my-login" },
        [
          _c(
            "CRow",
            { staticStyle: { "padding-top": "5px !important" } },
            [
              _c(
                "CCol",
                { attrs: { col: "12", lg: "12" } },
                [
                  _c(
                    "CCardGroup",
                    [
                      _c(
                        "CCard",
                        { staticClass: "p-4 my-card" },
                        [
                          _c(
                            "CCardBody",
                            { staticStyle: { margin: "15px" } },
                            [
                              _c(
                                "CAlert",
                                {
                                  attrs: {
                                    show: _vm.dismissCountDown,
                                    color: _vm.alertColor,
                                    fade: ""
                                  },
                                  on: {
                                    "update:show": function($event) {
                                      _vm.dismissCountDown = $event
                                    }
                                  }
                                },
                                [
                                  _vm._v(
                                    "\n                  " +
                                      _vm._s(_vm.message) +
                                      "\n                "
                                  )
                                ]
                              ),
                              _vm._v(" "),
                              _c(
                                "CForm",
                                {
                                  attrs: { method: "POST" },
                                  on: {
                                    submit: function($event) {
                                      $event.preventDefault()
                                      return _vm.login($event)
                                    }
                                  }
                                },
                                [
                                  _c("h1", { staticClass: "my-login-text" }, [
                                    _vm._v("Login")
                                  ]),
                                  _vm._v(" "),
                                  _c(
                                    "p",
                                    { staticClass: "text-muted my-login-text" },
                                    [
                                      _vm._v(
                                        "\n                    Sign In to your account\n                  "
                                      )
                                    ]
                                  ),
                                  _vm._v(" "),
                                  _c("CInput", {
                                    attrs: {
                                      prependHtml:
                                        "<i class='cui-user '  ></i>",
                                      placeholder: "Username",
                                      autocomplete: "username email"
                                    },
                                    scopedSlots: _vm._u([
                                      {
                                        key: "prepend-content",
                                        fn: function() {
                                          return [
                                            _c("CIcon", {
                                              attrs: { name: "cil-user" }
                                            })
                                          ]
                                        },
                                        proxy: true
                                      }
                                    ]),
                                    model: {
                                      value: _vm.email,
                                      callback: function($$v) {
                                        _vm.email = $$v
                                      },
                                      expression: "email"
                                    }
                                  }),
                                  _vm._v(" "),
                                  _c("CInput", {
                                    attrs: {
                                      prependHtml:
                                        "<i class='cui-lock-locked'></i>",
                                      placeholder: "Password",
                                      type: "password",
                                      autocomplete: "curent-password"
                                    },
                                    scopedSlots: _vm._u([
                                      {
                                        key: "prepend-content",
                                        fn: function() {
                                          return [
                                            _c("CIcon", {
                                              attrs: { name: "cil-lock-locked" }
                                            })
                                          ]
                                        },
                                        proxy: true
                                      }
                                    ]),
                                    model: {
                                      value: _vm.password,
                                      callback: function($$v) {
                                        _vm.password = $$v
                                      },
                                      expression: "password"
                                    }
                                  }),
                                  _vm._v(" "),
                                  _c(
                                    "CRow",
                                    {
                                      staticStyle: {
                                        "padding-top": "10px !important"
                                      }
                                    },
                                    [
                                      _c(
                                        "CCol",
                                        {
                                          staticStyle: { margin: "10px" },
                                          attrs: { col: "6" }
                                        },
                                        [
                                          _c(
                                            "CButton",
                                            {
                                              staticClass:
                                                "my-bg-orange px-4 btn-block",
                                              attrs: { type: "submit" }
                                            },
                                            [_vm._v("Login")]
                                          )
                                        ],
                                        1
                                      ),
                                      _vm._v(" "),
                                      _c(
                                        "CCol",
                                        {
                                          staticClass: "text-right",
                                          attrs: { col: "6" }
                                        },
                                        [
                                          _c(
                                            "CButton",
                                            {
                                              staticClass: "px-0 my-forgot",
                                              on: {
                                                click: function($event) {
                                                  return _vm.goRegister()
                                                }
                                              }
                                            },
                                            [_vm._v("Forgot password?")]
                                          )
                                        ],
                                        1
                                      )
                                    ],
                                    1
                                  )
                                ],
                                1
                              )
                            ],
                            1
                          )
                        ],
                        1
                      )
                    ],
                    1
                  )
                ],
                1
              )
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



/***/ })

}]);