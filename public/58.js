(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[58],{

/***/ "./frontend/src/views/catStatus/Edit.vue":
/*!***********************************************!*\
  !*** ./frontend/src/views/catStatus/Edit.vue ***!
  \***********************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _Edit_vue_vue_type_template_id_aa231b88___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Edit.vue?vue&type=template&id=aa231b88& */ "./frontend/src/views/catStatus/Edit.vue?vue&type=template&id=aa231b88&");
/* harmony import */ var _Edit_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Edit.vue?vue&type=script&lang=js& */ "./frontend/src/views/catStatus/Edit.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _Edit_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _Edit_vue_vue_type_template_id_aa231b88___WEBPACK_IMPORTED_MODULE_0__["render"],
  _Edit_vue_vue_type_template_id_aa231b88___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "frontend/src/views/catStatus/Edit.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./frontend/src/views/catStatus/Edit.vue?vue&type=script&lang=js&":
/*!************************************************************************!*\
  !*** ./frontend/src/views/catStatus/Edit.vue?vue&type=script&lang=js& ***!
  \************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Edit_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./Edit.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./frontend/src/views/catStatus/Edit.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Edit_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./frontend/src/views/catStatus/Edit.vue?vue&type=template&id=aa231b88&":
/*!******************************************************************************!*\
  !*** ./frontend/src/views/catStatus/Edit.vue?vue&type=template&id=aa231b88& ***!
  \******************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Edit_vue_vue_type_template_id_aa231b88___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib??vue-loader-options!./Edit.vue?vue&type=template&id=aa231b88& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./frontend/src/views/catStatus/Edit.vue?vue&type=template&id=aa231b88&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Edit_vue_vue_type_template_id_aa231b88___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Edit_vue_vue_type_template_id_aa231b88___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./frontend/src/views/catStatus/Edit.vue?vue&type=script&lang=js&":
/*!********************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./frontend/src/views/catStatus/Edit.vue?vue&type=script&lang=js& ***!
  \********************************************************************************************************************************************************************/
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

/* harmony default export */ __webpack_exports__["default"] = ({
  name: "EditCatStatus",
  props: {
    caption: {
      type: String
    }
  },
  data: function data() {
    return {
      name2: "",
      classn: "",
      catId: "",
      allStatus: {},
      phone: "",
      myLang: "",
      showMessage: false,
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
    getFleets: function getFleets() {
      this.loading = true;
      var self = this;
      this.items = [];
      axios__WEBPACK_IMPORTED_MODULE_0___default.a.get("/api/cat" + "?token=" + localStorage.getItem("api_token")).then(function (response) {
        console.log(response);
        self.allStatus = response.data.cat;
        console.log("res" + response);
      })["catch"](function (error) {
        console.log(error);
        self.loading = false;
        self.message = "unexpected error occurred in getting .";
        self.showAlert();
      });
    },
    update: function update() {
      var self = this;
      axios__WEBPACK_IMPORTED_MODULE_0___default.a.post("/api/cat/" + self.$route.params.id + "?token=" + localStorage.getItem("api_token"), {
        _method: "PUT",
        name2: self.name2,
        catId: self.catId,
        classn: self.classn
      }).then(function (response) {
        self.message = "Successfully updated user.";
        self.showAlert();
      })["catch"](function (error) {
        console.log(error);
        self.$router.push({
          path: "/login"
        });
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
    this.getFleets();
    var self = this;
    axios__WEBPACK_IMPORTED_MODULE_0___default.a.get("/api/cat/" + self.$route.params.id + "/edit?token=" + localStorage.getItem("api_token")).then(function (response) {
      self.name2 = response.data.name;
      self.catId = response.data.category_id;
      self.classn = response.data["class"];
      console.log(response.data["class"]);
    })["catch"](function (error) {
      console.log(error);
      self.$router.push({
        path: "/login"
      });
    });
  }
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./frontend/src/views/catStatus/Edit.vue?vue&type=template&id=aa231b88&":
/*!************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./frontend/src/views/catStatus/Edit.vue?vue&type=template&id=aa231b88& ***!
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
    "CRow",
    {
      style: [
        _vm.myLang == "ar" ? { direction: "rtl", "text-align": "right" } : ""
      ]
    },
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
                  [
                    _c("h6", [
                      _vm._v("\n            Create   status\n          ")
                    ])
                  ],
                  _vm._v(" "),
                  _c(
                    "CAlert",
                    {
                      attrs: { show: _vm.dismissCountDown, fade: "" },
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
                    attrs: { type: "text", label: "Name", placeholder: "Name" },
                    model: {
                      value: _vm.name2,
                      callback: function($$v) {
                        _vm.name2 = $$v
                      },
                      expression: "name2"
                    }
                  }),
                  _vm._v(" "),
                  _c("label", { attrs: { for: "" } }, [_vm._v("Class ")]),
                  _vm._v(" "),
                  _c(
                    "select",
                    {
                      directives: [
                        {
                          name: "model",
                          rawName: "v-model",
                          value: _vm.classn,
                          expression: "classn"
                        }
                      ],
                      staticClass: "form-control",
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
                          _vm.classn = $event.target.multiple
                            ? $$selectedVal
                            : $$selectedVal[0]
                        }
                      }
                    },
                    [
                      _c("option", { attrs: { value: "success" } }, [
                        _vm._v(" success ")
                      ]),
                      _vm._v(" "),
                      _c("option", { attrs: { value: "info " } }, [
                        _vm._v(" info ")
                      ]),
                      _vm._v(" "),
                      _c("option", { attrs: { value: "primary" } }, [
                        _vm._v("primary")
                      ]),
                      _vm._v(" "),
                      _c("option", { attrs: { value: "warning " } }, [
                        _vm._v(" warning ")
                      ]),
                      _vm._v(" "),
                      _c("option", { attrs: { value: "danger " } }, [
                        _vm._v(" danger ")
                      ]),
                      _vm._v(" "),
                      _c("option", { attrs: { value: "secondary " } }, [
                        _vm._v(" secondary ")
                      ])
                    ]
                  ),
                  _vm._v(" "),
                  _c(
                    "div",
                    { staticClass: "form-group", attrs: { role: "group" } },
                    [
                      _c("label", {}, [_vm._v(" Category  ")]),
                      _vm._v(" "),
                      _c(
                        "select",
                        {
                          directives: [
                            {
                              name: "model",
                              rawName: "v-model",
                              value: _vm.catId,
                              expression: "catId"
                            }
                          ],
                          staticClass: "form-control",
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
                              _vm.catId = $event.target.multiple
                                ? $$selectedVal
                                : $$selectedVal[0]
                            }
                          }
                        },
                        _vm._l(_vm.allStatus, function(status, index) {
                          return _c(
                            "option",
                            { key: index, domProps: { value: status.id } },
                            [
                              _vm._v(
                                "\n              " +
                                  _vm._s(status.name) +
                                  "\n            "
                              )
                            ]
                          )
                        }),
                        0
                      )
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
                    [_vm._v("Save")]
                  )
                ],
                2
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