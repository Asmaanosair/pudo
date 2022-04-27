(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[73],{

/***/ "./frontend/src/views/maxShipment/Edit.vue":
/*!*************************************************!*\
  !*** ./frontend/src/views/maxShipment/Edit.vue ***!
  \*************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _Edit_vue_vue_type_template_id_3b206af4___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Edit.vue?vue&type=template&id=3b206af4& */ "./frontend/src/views/maxShipment/Edit.vue?vue&type=template&id=3b206af4&");
/* harmony import */ var _Edit_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Edit.vue?vue&type=script&lang=js& */ "./frontend/src/views/maxShipment/Edit.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _Edit_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _Edit_vue_vue_type_template_id_3b206af4___WEBPACK_IMPORTED_MODULE_0__["render"],
  _Edit_vue_vue_type_template_id_3b206af4___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "frontend/src/views/maxShipment/Edit.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./frontend/src/views/maxShipment/Edit.vue?vue&type=script&lang=js&":
/*!**************************************************************************!*\
  !*** ./frontend/src/views/maxShipment/Edit.vue?vue&type=script&lang=js& ***!
  \**************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Edit_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./Edit.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./frontend/src/views/maxShipment/Edit.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Edit_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./frontend/src/views/maxShipment/Edit.vue?vue&type=template&id=3b206af4&":
/*!********************************************************************************!*\
  !*** ./frontend/src/views/maxShipment/Edit.vue?vue&type=template&id=3b206af4& ***!
  \********************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Edit_vue_vue_type_template_id_3b206af4___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib??vue-loader-options!./Edit.vue?vue&type=template&id=3b206af4& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./frontend/src/views/maxShipment/Edit.vue?vue&type=template&id=3b206af4&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Edit_vue_vue_type_template_id_3b206af4___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Edit_vue_vue_type_template_id_3b206af4___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./frontend/src/views/maxShipment/Edit.vue?vue&type=script&lang=js&":
/*!**********************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./frontend/src/views/maxShipment/Edit.vue?vue&type=script&lang=js& ***!
  \**********************************************************************************************************************************************************************/
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
//
//

/* harmony default export */ __webpack_exports__["default"] = ({
  data: function data() {
    return {
      max_number: "",
      showMessage: false,
      message: "",
      alertColor: "",
      dismissSecs: 7,
      dismissCountDown: 0,
      showDismissibleAlert: false
    };
  },
  methods: {
    goBack: function goBack() {
      this.$router.go(-1);
    },
    store: function store() {
      var self = this;
      var formData = new FormData();
      formData.append("max_number", this.max_number);
      axios__WEBPACK_IMPORTED_MODULE_0___default.a.post("/api/shipping-labels" + "?token=" + localStorage.getItem("api_token"), formData, {
        headers: {
          "Content-Type": "multipart/form-data"
        }
      }).then(function (response) {
        self.alertColor = "success";
        self.message = "Successfully updated .";
        self.showAlert();
      })["catch"](function (error) {
        console.log(error);
        self.alertColor = "danger";
        self.message = "unexpected error occurred in Editing .";
        self.showAlert();
      });
    },
    countDownChanged: function countDownChanged(dismissCountDown) {
      this.dismissCountDown = dismissCountDown;
    },
    showAlert: function showAlert() {
      this.dismissCountDown = this.dismissSecs;
    },
    getFleets: function getFleets() {
      this.loading = true;
      var self = this;
      this.items = [];
      axios__WEBPACK_IMPORTED_MODULE_0___default.a.get("/api/shipping-labels" + "?token=" + localStorage.getItem("api_token")).then(function (response) {
        self.max_number = response.data[0].role.max_number;
      })["catch"](function (error) {
        console.log(error);
        self.loading = false;
        self.alertColor = "danger";
        self.message = "unexpected error occurred in getting data.";
        self.showAlert();
      });
    },
    getLocale: function getLocale() {
      var locale;
      locale = localStorage.getItem("locale") || "en";
      this.myLang = locale;
    }
  },
  mounted: function mounted() {
    this.getFleets();
  }
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./frontend/src/views/maxShipment/Edit.vue?vue&type=template&id=3b206af4&":
/*!**************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./frontend/src/views/maxShipment/Edit.vue?vue&type=template&id=3b206af4& ***!
  \**************************************************************************************************************************************************************************************************************/
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
            { attrs: { "no-header": "" } },
            [
              _c(
                "CCardBody",
                [
                  _c("h1", { staticClass: "text-center" }, [
                    _vm._v("\n      Max Number of shipping labels\n        ")
                  ]),
                  _vm._v(" "),
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
                        "\n          " +
                          _vm._s(_vm.dismissCountDown) +
                          " " +
                          _vm._s(_vm.message) +
                          "\n        "
                      )
                    ]
                  ),
                  _vm._v(" "),
                  _c("div", { staticClass: "form-group" }, [
                    _c("label", [_vm._v("Max Number")]),
                    _vm._v(" "),
                    _c("input", {
                      directives: [
                        {
                          name: "model",
                          rawName: "v-model",
                          value: _vm.max_number,
                          expression: "max_number"
                        }
                      ],
                      class: {
                        "form-control": true
                      },
                      attrs: { type: "text", placeholder: "min" + "..." },
                      domProps: { value: _vm.max_number },
                      on: {
                        input: function($event) {
                          if ($event.target.composing) {
                            return
                          }
                          _vm.max_number = $event.target.value
                        }
                      }
                    })
                  ]),
                  _vm._v(" "),
                  _c(
                    "CButton",
                    {
                      attrs: { color: "primary" },
                      on: {
                        click: function($event) {
                          return _vm.store()
                        }
                      }
                    },
                    [_vm._v(_vm._s(_vm.$t("save")))]
                  ),
                  _vm._v(" "),
                  _c(
                    "CButton",
                    { attrs: { color: "primary" }, on: { click: _vm.goBack } },
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