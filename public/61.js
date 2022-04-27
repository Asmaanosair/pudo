(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[61],{

/***/ "./frontend/src/views/cities/Edit.vue":
/*!********************************************!*\
  !*** ./frontend/src/views/cities/Edit.vue ***!
  \********************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _Edit_vue_vue_type_template_id_7ccb8616___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Edit.vue?vue&type=template&id=7ccb8616& */ "./frontend/src/views/cities/Edit.vue?vue&type=template&id=7ccb8616&");
/* harmony import */ var _Edit_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Edit.vue?vue&type=script&lang=js& */ "./frontend/src/views/cities/Edit.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _Edit_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _Edit_vue_vue_type_template_id_7ccb8616___WEBPACK_IMPORTED_MODULE_0__["render"],
  _Edit_vue_vue_type_template_id_7ccb8616___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "frontend/src/views/cities/Edit.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./frontend/src/views/cities/Edit.vue?vue&type=script&lang=js&":
/*!*********************************************************************!*\
  !*** ./frontend/src/views/cities/Edit.vue?vue&type=script&lang=js& ***!
  \*********************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Edit_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./Edit.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./frontend/src/views/cities/Edit.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Edit_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./frontend/src/views/cities/Edit.vue?vue&type=template&id=7ccb8616&":
/*!***************************************************************************!*\
  !*** ./frontend/src/views/cities/Edit.vue?vue&type=template&id=7ccb8616& ***!
  \***************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Edit_vue_vue_type_template_id_7ccb8616___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib??vue-loader-options!./Edit.vue?vue&type=template&id=7ccb8616& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./frontend/src/views/cities/Edit.vue?vue&type=template&id=7ccb8616&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Edit_vue_vue_type_template_id_7ccb8616___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Edit_vue_vue_type_template_id_7ccb8616___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./frontend/src/views/cities/Edit.vue?vue&type=script&lang=js&":
/*!*****************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./frontend/src/views/cities/Edit.vue?vue&type=script&lang=js& ***!
  \*****************************************************************************************************************************************************************/
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
//
//
//
//
//
//
//
//
//
//
//
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
  name: "EditUser",
  props: {
    caption: {
      type: String,
      "default": "User id"
    }
  },
  data: function data() {
    return {
      name: "",
      active: "",
      countries: {},
      countryId: '',
      geometry: "",
      message: "",
      dismissSecs: 7,
      dismissCountDown: 0,
      showDismissibleAlert: false
    };
  },
  methods: {
    goBack: function goBack() {
      this.$router.go(-1); // this.$router.replace({path: '/users'})
    },
    cityInfo: function cityInfo() {
      var self = this;
      axios__WEBPACK_IMPORTED_MODULE_0___default.a.post("/api/city/" + self.$route.params.id + "/edit?token=" + localStorage.getItem("api_token")).then(function (response) {
        self.name = response.data.city.name, self.geometry = response.data.city.geom, self.active = response.data.city.active;
        self.countryId = response.data.city.country_id;
      })["catch"](function (error) {
        console.log(error);
        self.alertColor = "danger";
        self.message = "unexpected error occurred in loading the City info.";
        self.showAlert();
      });
    },
    update: function update() {
      var self = this;
      var formData = new FormData();
      formData.append("name", this.name);
      formData.append("geometry", this.geometry);
      formData.append("countryId", this.countryId);
      formData.append("active", this.active);
      axios__WEBPACK_IMPORTED_MODULE_0___default.a.post("/api/update-city/" + self.$route.params.id + "?token=" + localStorage.getItem("api_token"), formData).then(function (response) {
        self.message = "Successfully created City.";
        self.showAlert();
        self.goBack();
      })["catch"](function (error) {
        self.message = "unexpected";
        self.showAlert();
      });
    },
    countDownChanged: function countDownChanged(dismissCountDown) {
      this.dismissCountDown = dismissCountDown;
    },
    showAlert: function showAlert() {
      this.dismissCountDown = this.dismissSecs;
    },
    getcountries: function getcountries() {
      this.loading = true;
      var self = this;
      this.items = [];
      axios__WEBPACK_IMPORTED_MODULE_0___default.a.get("/api/cities?page=" + self.activePage + "&token=" + localStorage.getItem("api_token")).then(function (response) {
        console.log(response);
        self.countries = response.data.countries;
      })["catch"](function (error) {
        console.log(error);
        self.loading = false;
        self.alertColor = "danger";
        self.message = "unexpected error occurred in getting countries.";
        self.showAlert();
      });
    }
  },
  mounted: function mounted() {
    this.cityInfo();
    this.getcountries();
  }
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./frontend/src/views/cities/Edit.vue?vue&type=template&id=7ccb8616&":
/*!*********************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./frontend/src/views/cities/Edit.vue?vue&type=template&id=7ccb8616& ***!
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
    "CRow",
    [
      _c(
        "CCol",
        { attrs: { col: "6", lg: "6" } },
        [
          _c(
            "CCard",
            { attrs: { "no-header": "" } },
            [
              _c(
                "CCardBody",
                [
                  _c("h3", { staticClass: "text-center" }, [
                    _vm._v("Edit City " + _vm._s(_vm.name) + " ")
                  ]),
                  _vm._v(" "),
                  _c(
                    "CAlert",
                    {
                      attrs: {
                        show: _vm.dismissCountDown,
                        color: "primary",
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
                        "\n          (" +
                          _vm._s(_vm.dismissCountDown) +
                          ") " +
                          _vm._s(_vm.message) +
                          "\n        "
                      )
                    ]
                  ),
                  _vm._v(" "),
                  _c("CInput", {
                    attrs: {
                      label: "Name",
                      type: "text",
                      id: "title",
                      placeholder: "Name..."
                    },
                    model: {
                      value: _vm.name,
                      callback: function($$v) {
                        _vm.name = $$v
                      },
                      expression: "name"
                    }
                  }),
                  _vm._v(" "),
                  _c("label", [_vm._v("EWKT")]),
                  _vm._v(" "),
                  _c("textarea", {
                    directives: [
                      {
                        name: "model",
                        rawName: "v-model",
                        value: _vm.geometry,
                        expression: "geometry"
                      }
                    ],
                    staticClass: "form-control",
                    attrs: { rows: "10", placeholder: "EWKT.." },
                    domProps: { value: _vm.geometry },
                    on: {
                      input: function($event) {
                        if ($event.target.composing) {
                          return
                        }
                        _vm.geometry = $event.target.value
                      }
                    }
                  }),
                  _vm._v(" "),
                  _c("div", { staticClass: "form-group" }, [
                    _c("p", [_vm._v("Country")]),
                    _vm._v(" "),
                    _c(
                      "select",
                      {
                        directives: [
                          {
                            name: "model",
                            rawName: "v-model",
                            value: _vm.countryId,
                            expression: "countryId"
                          }
                        ],
                        class: {
                          "form-control": true
                        },
                        attrs: { type: "text" },
                        on: {
                          change: function($event) {
                            var $$selectedVal = Array.prototype.filter
                              .call($event.target.options, function(o) {
                                return o.selected
                              })
                              .map(function(o) {
                                var val = "_value" in o ? o._value : o.value
                                return val
                              })
                            _vm.countryId = $event.target.multiple
                              ? $$selectedVal
                              : $$selectedVal[0]
                          }
                        }
                      },
                      _vm._l(_vm.countries, function(country, index) {
                        return _c(
                          "option",
                          { key: index, domProps: { value: country.id } },
                          [
                            _vm._v(
                              "\n              " +
                                _vm._s(country.name) +
                                "\n            "
                            )
                          ]
                        )
                      }),
                      0
                    )
                  ]),
                  _vm._v(" "),
                  _c("label", { attrs: { for: "" } }, [_vm._v("Status")]),
                  _vm._v(" "),
                  _c(
                    "select",
                    {
                      directives: [
                        {
                          name: "model",
                          rawName: "v-model",
                          value: _vm.active,
                          expression: "active"
                        }
                      ],
                      staticClass: "form-control mb-2",
                      on: {
                        change: function($event) {
                          var $$selectedVal = Array.prototype.filter
                            .call($event.target.options, function(o) {
                              return o.selected
                            })
                            .map(function(o) {
                              var val = "_value" in o ? o._value : o.value
                              return val
                            })
                          _vm.active = $event.target.multiple
                            ? $$selectedVal
                            : $$selectedVal[0]
                        }
                      }
                    },
                    [
                      _c("option", { attrs: { value: "true" } }, [
                        _vm._v(" Active ")
                      ]),
                      _vm._v(" "),
                      _c("option", { attrs: { value: "false" } }, [
                        _vm._v(" Not Active ")
                      ])
                    ]
                  ),
                  _vm._v(" "),
                  _c(
                    "CButton",
                    {
                      attrs: { color: "primary" },
                      on: {
                        click: function($event) {
                          return _vm.update()
                        }
                      }
                    },
                    [_vm._v("Update")]
                  ),
                  _vm._v(" "),
                  _c(
                    "CButton",
                    { attrs: { color: "primary" }, on: { click: _vm.goBack } },
                    [_vm._v("Back")]
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