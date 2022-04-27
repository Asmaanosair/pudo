(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[50],{

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

/***/ "./frontend/src/views/myOrders/Bulk.vue":
/*!**********************************************!*\
  !*** ./frontend/src/views/myOrders/Bulk.vue ***!
  \**********************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _Bulk_vue_vue_type_template_id_d9b1ed56___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Bulk.vue?vue&type=template&id=d9b1ed56& */ "./frontend/src/views/myOrders/Bulk.vue?vue&type=template&id=d9b1ed56&");
/* harmony import */ var _Bulk_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Bulk.vue?vue&type=script&lang=js& */ "./frontend/src/views/myOrders/Bulk.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _Bulk_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _Bulk_vue_vue_type_template_id_d9b1ed56___WEBPACK_IMPORTED_MODULE_0__["render"],
  _Bulk_vue_vue_type_template_id_d9b1ed56___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "frontend/src/views/myOrders/Bulk.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./frontend/src/views/myOrders/Bulk.vue?vue&type=script&lang=js&":
/*!***********************************************************************!*\
  !*** ./frontend/src/views/myOrders/Bulk.vue?vue&type=script&lang=js& ***!
  \***********************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Bulk_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./Bulk.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./frontend/src/views/myOrders/Bulk.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Bulk_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./frontend/src/views/myOrders/Bulk.vue?vue&type=template&id=d9b1ed56&":
/*!*****************************************************************************!*\
  !*** ./frontend/src/views/myOrders/Bulk.vue?vue&type=template&id=d9b1ed56& ***!
  \*****************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Bulk_vue_vue_type_template_id_d9b1ed56___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib??vue-loader-options!./Bulk.vue?vue&type=template&id=d9b1ed56& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./frontend/src/views/myOrders/Bulk.vue?vue&type=template&id=d9b1ed56&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Bulk_vue_vue_type_template_id_d9b1ed56___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Bulk_vue_vue_type_template_id_d9b1ed56___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./frontend/src/views/myOrders/Bulk.vue?vue&type=script&lang=js&":
/*!*******************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./frontend/src/views/myOrders/Bulk.vue?vue&type=script&lang=js& ***!
  \*******************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _codinglabs_laravel_asset__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @codinglabs/laravel-asset */ "./frontend/node_modules/@codinglabs/laravel-asset/asset.js");
/* harmony import */ var axios__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! axios */ "./frontend/node_modules/axios/index.js");
/* harmony import */ var axios__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(axios__WEBPACK_IMPORTED_MODULE_1__);
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
  name: "Creat",
  data: function data() {
    return {
      apiToken: "",
      imageIndex: null,
      showMessage: false,
      number_of_products: 0,
      message: "",
      alertColor: "",
      dismissSecs: 7,
      role: "",
      dismissCountDown: 0,
      showDismissibleAlert: false,
      file: Object(_codinglabs_laravel_asset__WEBPACK_IMPORTED_MODULE_0__["asset"])("/upload/pudoOrder.xlsx"),
      file2: Object(_codinglabs_laravel_asset__WEBPACK_IMPORTED_MODULE_0__["asset"])("/upload/pudoOrderClient.xlsx"),
      file3: Object(_codinglabs_laravel_asset__WEBPACK_IMPORTED_MODULE_0__["asset"])("/upload/pudoOrderManager.xlsx")
    };
  },
  methods: {
    goBack: function goBack() {
      this.$router.go(-1);
      this.$router.replace({
        path: "/driver-applications"
      });
    },
    showAlert: function showAlert() {
      this.dismissCountDown = this.dismissSecs;
    },
    getToken: function getToken() {
      this.apiToken = localStorage.getItem("api_token");
    },
    me: function me() {
      var self = this;
      axios__WEBPACK_IMPORTED_MODULE_1___default.a.post("/api/me?token=" + localStorage.getItem("api_token")).then(function (response) {
        self.role = response.data.user.menuroles;
      })["catch"](function (error) {
        console.log(error);
      });
    }
  },
  created: function created() {},
  mounted: function mounted() {
    this.getToken();
    this.me();
  }
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./frontend/src/views/myOrders/Bulk.vue?vue&type=template&id=d9b1ed56&":
/*!***********************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./frontend/src/views/myOrders/Bulk.vue?vue&type=template&id=d9b1ed56& ***!
  \***********************************************************************************************************************************************************************************************************/
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
    "CRow",
    [
      _c(
        "CCol",
        { attrs: { col: "12", lg: "6" } },
        [
          _c(
            "CCard",
            { staticClass: "p-4", attrs: { "no-header": "" } },
            [
              _c("h2", { staticClass: "text-center" }, [
                _vm._v(
                  "\n        " + _vm._s(_vm.$t("download_example")) + "\n      "
                )
              ]),
              _vm._v(" "),
              _c("div", { staticClass: "my-notes" }, [
                _c("h2", [_vm._v("Notes")]),
                _vm._v(" "),
                _c("p", [_vm._v("Payment Method Should be numbers 1 or 2")]),
                _vm._v(" "),
                _c("ul", [
                  _c("li", [
                    _vm._v("\n              1=> for COD\n            ")
                  ]),
                  _vm._v(" "),
                  _c("ul", [
                    _vm._v(
                      "\n              Payment Type Should be numbers 1 or 2 or 3\n              "
                    ),
                    _c("li", [_vm._v("  1 => Pay Cash")]),
                    _vm._v(" "),
                    _c("li", [_vm._v("   2 => Pay By Driver Wallet")]),
                    _vm._v(" "),
                    _c("li", [_vm._v("  3 => Not Paying")])
                  ]),
                  _vm._v(" "),
                  _c("li", [
                    _vm._v("\n              2=> for Prepaid\n            ")
                  ]),
                  _vm._v(" "),
                  _c("ul", [
                    _vm._v(
                      "\n              Payment Type Should be numbers 3 or 4\n              "
                    ),
                    _c("li", [_vm._v("  3 => Not Paying")]),
                    _vm._v(" "),
                    _c("li", [_vm._v("   4 =>  Paying on picked up")])
                  ])
                ])
              ]),
              _vm._v(" "),
              _vm.role == "client"
                ? _c(
                    "a",
                    {
                      staticClass: "text-center",
                      attrs: { href: _vm.file2, download: "" }
                    },
                    [
                      _c("img", {
                        staticClass: "excel-img",
                        attrs: {
                          src:
                            "https://www.freeiconspng.com/thumbs/xls-icon/excel-icon-15.png",
                          alt: ""
                        }
                      })
                    ]
                  )
                : _vm.role == "client-branch"
                ? _c(
                    "a",
                    {
                      staticClass: "text-center",
                      attrs: { href: _vm.file3, download: "" }
                    },
                    [
                      _c("img", {
                        staticClass: "excel-img",
                        attrs: {
                          src:
                            "https://www.freeiconspng.com/thumbs/xls-icon/excel-icon-15.png",
                          alt: ""
                        }
                      })
                    ]
                  )
                : _c(
                    "a",
                    {
                      staticClass: "text-center",
                      attrs: { href: _vm.file, download: "" }
                    },
                    [
                      _c("img", {
                        staticClass: "excel-img",
                        attrs: {
                          src:
                            "https://www.freeiconspng.com/thumbs/xls-icon/excel-icon-15.png",
                          alt: ""
                        }
                      })
                    ]
                  ),
              _vm._v(" "),
              _c(
                "CCardBody",
                { staticClass: "text-center" },
                [
                  _c(
                    "form",
                    {
                      attrs: {
                        action: "/api/import-excel",
                        method: "post",
                        enctype: "multipart/form-data"
                      }
                    },
                    [
                      _c("input", {
                        attrs: { type: "hidden", name: "token" },
                        domProps: { value: _vm.apiToken }
                      }),
                      _vm._v(" "),
                      _c("input", {
                        attrs: { required: "", type: "file", name: "file" }
                      }),
                      _vm._v(" "),
                      _c("input", {
                        staticClass: "btn btn-success",
                        attrs: { type: "submit" },
                        domProps: { value: _vm.$t("upload") }
                      })
                    ]
                  ),
                  _vm._v(" "),
                  _c(
                    "CButton",
                    {
                      staticClass: "mb-3",
                      attrs: { color: "primary" },
                      on: { click: _vm.goBack }
                    },
                    [_vm._v(_vm._s(_vm.$t("back")))]
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