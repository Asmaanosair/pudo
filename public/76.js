(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[76],{

/***/ "./frontend/src/views/orders/Order.vue":
/*!*********************************************!*\
  !*** ./frontend/src/views/orders/Order.vue ***!
  \*********************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _Order_vue_vue_type_template_id_13d9b08f___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Order.vue?vue&type=template&id=13d9b08f& */ "./frontend/src/views/orders/Order.vue?vue&type=template&id=13d9b08f&");
/* harmony import */ var _Order_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Order.vue?vue&type=script&lang=js& */ "./frontend/src/views/orders/Order.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _Order_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _Order_vue_vue_type_template_id_13d9b08f___WEBPACK_IMPORTED_MODULE_0__["render"],
  _Order_vue_vue_type_template_id_13d9b08f___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "frontend/src/views/orders/Order.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./frontend/src/views/orders/Order.vue?vue&type=script&lang=js&":
/*!**********************************************************************!*\
  !*** ./frontend/src/views/orders/Order.vue?vue&type=script&lang=js& ***!
  \**********************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Order_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./Order.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./frontend/src/views/orders/Order.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Order_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./frontend/src/views/orders/Order.vue?vue&type=template&id=13d9b08f&":
/*!****************************************************************************!*\
  !*** ./frontend/src/views/orders/Order.vue?vue&type=template&id=13d9b08f& ***!
  \****************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Order_vue_vue_type_template_id_13d9b08f___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib??vue-loader-options!./Order.vue?vue&type=template&id=13d9b08f& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./frontend/src/views/orders/Order.vue?vue&type=template&id=13d9b08f&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Order_vue_vue_type_template_id_13d9b08f___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Order_vue_vue_type_template_id_13d9b08f___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./frontend/src/views/orders/Order.vue?vue&type=script&lang=js&":
/*!******************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./frontend/src/views/orders/Order.vue?vue&type=script&lang=js& ***!
  \******************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var axios__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! axios */ "./frontend/node_modules/axios/index.js");
/* harmony import */ var axios__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(axios__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var leaflet__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! leaflet */ "./frontend/node_modules/leaflet/dist/leaflet-src.js");
/* harmony import */ var leaflet__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(leaflet__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var vue2_leaflet__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! vue2-leaflet */ "./frontend/node_modules/vue2-leaflet/dist/vue2-leaflet.es.js");
/* harmony import */ var _coreui_icons__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @coreui/icons */ "./frontend/node_modules/@coreui/icons/js/index.js");
function _slicedToArray(arr, i) { return _arrayWithHoles(arr) || _iterableToArrayLimit(arr, i) || _unsupportedIterableToArray(arr, i) || _nonIterableRest(); }

function _nonIterableRest() { throw new TypeError("Invalid attempt to destructure non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); }

function _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }

function _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) { arr2[i] = arr[i]; } return arr2; }

function _iterableToArrayLimit(arr, i) { if (typeof Symbol === "undefined" || !(Symbol.iterator in Object(arr))) return; var _arr = []; var _n = true; var _d = false; var _e = undefined; try { for (var _i = arr[Symbol.iterator](), _s; !(_n = (_s = _i.next()).done); _n = true) { _arr.push(_s.value); if (i && _arr.length === i) break; } } catch (err) { _d = true; _e = err; } finally { try { if (!_n && _i["return"] != null) _i["return"](); } finally { if (_d) throw _e; } } return _arr; }

function _arrayWithHoles(arr) { if (Array.isArray(arr)) return arr; }

function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); if (enumerableOnly) symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; }); keys.push.apply(keys, symbols); } return keys; }

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i] != null ? arguments[i] : {}; if (i % 2) { ownKeys(Object(source), true).forEach(function (key) { _defineProperty(target, key, source[key]); }); } else if (Object.getOwnPropertyDescriptors) { Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)); } else { ownKeys(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } } return target; }

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
  name: "Order",
  data: function data() {
    return {
      myOrder: {},
      message: "",
      showMessage: false,
      alertColor: "",
      dismissSecs: 3,
      dismissCountDown: 0,
      delivery_lng: '',
      delivery_lat: '',
      order: [],
      files: [],
      products: [],
      branch: [],
      fleet: [],
      paymentMethods: ["CASH_ON_DELIVERY", "Prepaid"],
      paymentTypes: ["PAY_CASH", "PAY_BY_DRIVER_WALLET", "NOT_PAY", "PAY_ON_PICKUP"],
      reasons: ["Client_Canceled_Before_Pickup ", "Store_Is_Closed", "Wrong_Pickup_Location", "App_Issues", "Client_Canceled_On_The_Way", "Driver_Refused_To_Deliver_Or_Late", "Car_Issues", "Abnormal_Weather", "Customer_Refused_To_Take_The_Order_Because_Of_Driver", "Customer_Refused_To_Take_The_Order_Because_Of_Client", //New Order
      "Customer_Canceled_New_Order", "Client_Canceled_New_Order", //Assign Order
      "Driver_Refused_To_Deliver_Assign_Order", "Driver_Canceled_Assign_Order", "Car_Issues_Assign_Order", "Abnormal_Weather_Assign_Order", "Order_Disappeared_From_The_Driver_App_Assign_Order", "Mistake_In_Dispatching_Logic_Assign_Order", "Driver_Is_Not_Responding_Assign_Order", //On_The_Way_To_Pickup
      "Customer_Canceled_On_The_Way_To_Pickup", "Client_Canceled_On_The_Way_To_Pickup", "Driver_Refused_To_Deliver_On_The_Way_To_Pickup", "Driver_Canceled_On_The_Way_To_Pickup", "Car_Issues_On_The_Way_To_Pickup", "Abnormal_Weather_On_The_Way_To_Pickup", "Mistake_In_Dispatching_Logic_On_The_Way_To_Pickup", "Missing_Order_Information_In_The_Driver_App_On_The_Way_To_Pickup", "Driver_Stopped_By_The_Police_On_The_Way_To_Pickup", "Traffic_On_The_Way_To_Pickup", "Order_Disappeared_From_The_Driver_App_On_The_Way_To_Pickup" //Reach_Pickup_location
      ],
      productFields: ["name", "quantity", "note"],
      fields: [{
        key: "key"
      }, {
        key: "value"
      }],
      zoomSnap: 0.5
    };
  },
  methods: {
    getLatLng2: function getLatLng2(event) {
      var link = event.target.value;
      var linkSplit = link.split("@");
      var linkVal = linkSplit[1];
      var linkVal2 = linkVal.split(",");
      this.delivery_lat = linkVal2[0];
      this.delivery_lng = linkVal2[1];
      this.flagOption2 = true;
      this.mapPicker2();
    },
    mapPicker2: function mapPicker2() {
      var self = this;
      var map2;
      var marker2;
      var myLatlng2 = new google.maps.LatLng(self.delivery_lat, self.delivery_lng);

      function initialize() {
        var mapOptions2 = {
          zoom: 17,
          center: myLatlng2
        };
        map2 = new google.maps.Map(document.getElementById("myMap2"), mapOptions2);
        marker2 = new google.maps.Marker({
          map: map2,
          position: myLatlng2,
          draggable: true
        });
      }

      initialize();
    },
    centerUpdate: function centerUpdate(center) {
      this.currentCenter = center;
    },
    innerClick: function innerClick() {
      alert("Click!");
    },
    showAlert: function showAlert() {
      this.dismissCountDown = this.dismissSecs;
    },
    getOrderDetails: function getOrderDetails() {
      var self = this;
      axios__WEBPACK_IMPORTED_MODULE_0___default.a.get("/api/order/" + self.$route.params.id + "?token=" + localStorage.getItem("api_token")).then(function (response) {
        var orderInfo = _objectSpread({}, response.data.order);

        self.myOrder = response.data.order;
        self.delivery_lat = response.data.order.delivery_lat;
        self.delivery_lng = response.data.order.delivery_lng;
        self.files = response.data.order.invoice;
        self.mapPicker2();
        console.log(self.myOrder);

        if (response.data.order.reason) {
          var reason_description = self.reasons[response.data.order.reason];
          orderInfo.reason_description = reason_description;
        }

        if (response.data.order.payment_method) {
          var payment_method = self.paymentMethods[response.data.order.payment_method - 1];
          orderInfo.payment_method = payment_method;
        }

        if (response.data.order.payment_type) {
          var payment_type = self.paymentTypes[response.data.order.payment_type - 1];
          orderInfo.payment_type = payment_type;
        }

        delete orderInfo.products;
        delete orderInfo.branch;
        delete orderInfo.fleet;
        delete orderInfo.deleted_at;
        delete orderInfo.pick_up_lng;
        delete orderInfo.pick_up_lat;
        delete orderInfo.delivery_lng;
        delete orderInfo.delivery_lat;
        var items = Object.entries(orderInfo);
        self.order = items.map(function (_ref) {
          var _ref2 = _slicedToArray(_ref, 2),
              key = _ref2[0],
              value = _ref2[1];

          return {
            key: key,
            value: value
          };
        }); //products

        if (response.data.order.products !== null) self.products = response.data.order.products; //branch

        if (response.data.order.branch !== null) {
          var branchInfo = _objectSpread({}, response.data.order.branch);

          delete branchInfo.user_id;
          delete branchInfo.manager_id;
          delete branchInfo.city_id;
          delete branchInfo.created_at;
          delete branchInfo.updated_at;
          var statusArr = Object.entries(branchInfo);
          self.branch = statusArr.map(function (_ref3) {
            var _ref4 = _slicedToArray(_ref3, 2),
                key = _ref4[0],
                value = _ref4[1];

            return {
              key: key,
              value: value
            };
          });
        } //driver =


        if (response.data.order.fleet !== null) {
          var fleetInfo = _objectSpread({}, response.data.order.fleet);

          delete fleetInfo.user_id;
          delete fleetInfo.created_at;
          delete fleetInfo.updated_at;
          var fleetArr = Object.entries(fleetInfo);
          self.fleet = fleetArr.map(function (_ref5) {
            var _ref6 = _slicedToArray(_ref5, 2),
                key = _ref6[0],
                value = _ref6[1];

            return {
              key: key,
              value: value
            };
          });
        }
      })["catch"](function (error) {
        console.log(error);
        self.alertColor = "danger";
        self.message = "unexpected error occurred.";
        self.showAlert();
      });
    },
    goBack: function goBack() {
      this.$router.go(-1);
    }
  },
  mounted: function mounted() {
    this.getOrderDetails();
  }
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./frontend/src/views/orders/Order.vue?vue&type=template&id=13d9b08f&":
/*!**********************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./frontend/src/views/orders/Order.vue?vue&type=template&id=13d9b08f& ***!
  \**********************************************************************************************************************************************************************************************************/
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
            [
              _c("CCardHeader", [
                _vm._v(" Order id: " + _vm._s(_vm.$route.params.id) + " ")
              ]),
              _vm._v(" "),
              _c(
                "CCardBody",
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
                        "\n          (" +
                          _vm._s(_vm.dismissCountDown) +
                          ") " +
                          _vm._s(_vm.message) +
                          "\n        "
                      )
                    ]
                  ),
                  _vm._v(" "),
                  _c("CDataTable", {
                    attrs: {
                      striped: "",
                      small: "",
                      fixed: "",
                      items: _vm.order,
                      fields: _vm.fields
                    }
                  })
                ],
                1
              ),
              _vm._v(" "),
              _c(
                "CCardFooter",
                [
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
          ),
          _vm._v(" "),
          _c(
            "CCard",
            [
              _c("CCardHeader", [_vm._v(" Order Time Line Information ")]),
              _vm._v(" "),
              _c("table", { staticClass: "table table-striped table-fixed" }, [
                _c("tbody", [
                  _c("tr", { staticClass: "p-3" }, [
                    _c("td", { staticClass: "p-3 d-block" }, [
                      _vm._v(
                        "\n              New Order ID : " +
                          _vm._s(_vm.myOrder.id) +
                          " created at\n              " +
                          _vm._s(
                            new Date(_vm.myOrder.created_at).toLocaleString(
                              "en"
                            )
                          ) +
                          "\n            "
                      )
                    ])
                  ]),
                  _vm._v(" "),
                  _vm.myOrder.last_driver_name
                    ? _c("tr", { staticClass: "d-block" }, [
                        _c("td", { staticClass: "p-3 d-block" }, [
                          _vm._v(
                            "\n              Order ID :\n              " +
                              _vm._s(_vm.myOrder.id) +
                              " assigned to driver\n              " +
                              _vm._s(
                                _vm.myOrder.last_driver_name != null
                                  ? _vm.myOrder.last_driver_name
                                  : "....."
                              ) +
                              "\n              at\n              " +
                              _vm._s(
                                _vm.myOrder.assign_order != null
                                  ? new Date(
                                      _vm.myOrder.assign_order
                                    ).toLocaleString("en")
                                  : "....."
                              ) +
                              "\n            "
                          )
                        ])
                      ])
                    : _vm._e(),
                  _vm._v(" "),
                  _c("tr", { staticClass: "d-block" }, [
                    _c("td", { staticClass: "p-3 d-block" }, [
                      _vm._v(
                        "\n              Order ID : " +
                          _vm._s(_vm.myOrder.id) +
                          "\n              "
                      ),
                      _vm.myOrder.last_driver_name
                        ? _c("span", [_vm._v(" reassigned ")])
                        : _c("span", [_vm._v("assigned")]),
                      _vm._v(
                        " to driver\n              " +
                          _vm._s(
                            _vm.myOrder.current_driver_name != null
                              ? _vm.myOrder.current_driver_name
                              : "....."
                          ) +
                          "\n              at\n              " +
                          _vm._s(
                            _vm.myOrder.reassign_order != null
                              ? new Date(
                                  _vm.myOrder.reassign_order
                                ).toLocaleString("en")
                              : "....."
                          ) +
                          "\n            "
                      )
                    ])
                  ]),
                  _vm._v(" "),
                  _c("tr", { staticClass: "d-block" }, [
                    _c("td", { staticClass: "p-3 d-block" }, [
                      _vm._v(
                        "\n              Driver :\n              " +
                          _vm._s(
                            _vm.myOrder.current_driver_name != null
                              ? _vm.myOrder.current_driver_name
                              : "....."
                          ) +
                          "\n              on the way to pick up at\n              " +
                          _vm._s(
                            _vm.myOrder.on_the_way_to_pickup != null
                              ? new Date(
                                  _vm.myOrder.on_the_way_to_pickup
                                ).toLocaleString("en")
                              : "....."
                          ) +
                          "\n            "
                      )
                    ])
                  ]),
                  _vm._v(" "),
                  _c("tr", { staticClass: "d-block" }, [
                    _c("td", { staticClass: "p-3 d-block" }, [
                      _vm._v(
                        "\n              Driver :\n              " +
                          _vm._s(
                            _vm.myOrder.current_driver_name != null
                              ? _vm.myOrder.current_driver_name
                              : "....."
                          ) +
                          "\n              near pikup location at\n              " +
                          _vm._s(
                            _vm.myOrder.near_pikup_location != null
                              ? new Date(
                                  _vm.myOrder.near_pikup_location
                                ).toLocaleString("en")
                              : "....."
                          ) +
                          "\n            "
                      )
                    ])
                  ]),
                  _vm._v(" "),
                  _c("tr", { staticClass: "d-block" }, [
                    _c("td", { staticClass: "p-3 d-block" }, [
                      _vm._v(
                        "\n              Driver :\n              " +
                          _vm._s(
                            _vm.myOrder.current_driver_name != null
                              ? _vm.myOrder.current_driver_name
                              : "....."
                          ) +
                          "\n              reach pickup location at\n              " +
                          _vm._s(
                            _vm.myOrder.reach_pickup_location != null
                              ? new Date(
                                  _vm.myOrder.reach_pickup_location
                                ).toLocaleString("en")
                              : "....."
                          ) +
                          "\n            "
                      )
                    ])
                  ]),
                  _vm._v(" "),
                  _c("tr", { staticClass: "d-block" }, [
                    _c("td", { staticClass: "p-3 d-block" }, [
                      _vm._v(
                        "\n              Driver :\n              " +
                          _vm._s(
                            _vm.myOrder.current_driver_name != null
                              ? _vm.myOrder.current_driver_name
                              : "....."
                          ) +
                          "\n              picked up at\n              " +
                          _vm._s(
                            _vm.myOrder.picked_up_at != null
                              ? new Date(
                                  _vm.myOrder.picked_up_at
                                ).toLocaleString("en")
                              : "....."
                          ) +
                          "\n            "
                      )
                    ])
                  ]),
                  _vm._v(" "),
                  _c("tr", { staticClass: "d-block" }, [
                    _c("td", { staticClass: "p-3 d-block" }, [
                      _vm._v(
                        "\n              Driver :\n              " +
                          _vm._s(
                            _vm.myOrder.current_driver_name != null
                              ? _vm.myOrder.current_driver_name
                              : "....."
                          ) +
                          "\n              on the way to dropoff at\n              " +
                          _vm._s(
                            _vm.myOrder.on_the_way_to_dropoff != null
                              ? new Date(
                                  _vm.myOrder.on_the_way_to_dropoff
                                ).toLocaleString("en")
                              : "....."
                          ) +
                          "\n            "
                      )
                    ])
                  ]),
                  _vm._v(" "),
                  _c("tr", { staticClass: "d-block" }, [
                    _c("td", { staticClass: "p-3 d-block" }, [
                      _vm._v(
                        "\n              Driver :\n              " +
                          _vm._s(
                            _vm.myOrder.current_driver_name != null
                              ? _vm.myOrder.current_driver_name
                              : "....."
                          ) +
                          "\n              near dropoff location at\n              " +
                          _vm._s(
                            _vm.myOrder.near_dropoff_location != null
                              ? new Date(
                                  _vm.myOrder.near_dropoff_location
                                ).toLocaleString("en")
                              : "....."
                          ) +
                          "\n            "
                      )
                    ])
                  ]),
                  _vm._v(" "),
                  _c("tr", { staticClass: "d-block" }, [
                    _c("td", { staticClass: "p-3 d-block" }, [
                      _vm._v(
                        "\n              Driver :\n              " +
                          _vm._s(
                            _vm.myOrder.current_driver_name != null
                              ? _vm.myOrder.current_driver_name
                              : "....."
                          ) +
                          "\n              reached customer " +
                          _vm._s(_vm.myOrder.customer_name) +
                          " at\n              " +
                          _vm._s(
                            _vm.myOrder.reach_customer != null
                              ? new Date(
                                  _vm.myOrder.reach_customer
                                ).toLocaleString("en")
                              : "....."
                          ) +
                          "\n            "
                      )
                    ])
                  ]),
                  _vm._v(" "),
                  _c("tr", { staticClass: "d-block" }, [
                    _c("td", { staticClass: "p-3 d-block" }, [
                      _vm._v(
                        "\n              Order Id :\n              " +
                          _vm._s(_vm.myOrder.id) +
                          " is delivered at\n              " +
                          _vm._s(
                            _vm.myOrder.reach_customer != null
                              ? new Date(
                                  _vm.myOrder.delivered_at
                                ).toLocaleString("en")
                              : "....."
                          ) +
                          "\n            "
                      )
                    ])
                  ])
                ])
              ]),
              _vm._v(" "),
              _c("CCardFooter")
            ],
            1
          ),
          _vm._v(" "),
          _c(
            "CCard",
            [
              _c("CCardHeader", [_vm._v(" Invoice    ")]),
              _vm._v(" "),
              _vm._l(_vm.files, function(file) {
                return _c("CCol", { key: file.id, attrs: { col: "4" } }, [
                  _c("img", {
                    staticClass: "image",
                    staticStyle: { height: "200px" },
                    attrs: { src: file.file_path },
                    on: {
                      click: function($event) {
                        return _vm.imageClick(file.file_path)
                      }
                    }
                  }),
                  _vm._v(" "),
                  _c(
                    "a",
                    {
                      staticClass: " btn btn-success",
                      attrs: {
                        href: file.file_path,
                        download: "",
                        target: "_blank"
                      }
                    },
                    [_vm._v("Show")]
                  )
                ])
              })
            ],
            2
          )
        ],
        1
      ),
      _vm._v(" "),
      _c(
        "CCol",
        { attrs: { col: "12", lg: "6" } },
        [
          _c(
            "CCard",
            [
              _c("CCardHeader", [_vm._v(" Maps ")]),
              _vm._v(" "),
              _c("CCardBody", [
                _c("div", {
                  staticClass: "my-4 mt-5",
                  staticStyle: { height: "500px", width: "100%" },
                  attrs: { id: "myMap2" }
                })
              ])
            ],
            1
          ),
          _vm._v(" "),
          _c(
            "CCard",
            [
              _c("CCardHeader", [_vm._v(" Branch Information ")]),
              _vm._v(" "),
              _c(
                "CCardBody",
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
                        "\n          (" +
                          _vm._s(_vm.dismissCountDown) +
                          ") " +
                          _vm._s(_vm.message) +
                          "\n        "
                      )
                    ]
                  ),
                  _vm._v(" "),
                  _c("CDataTable", {
                    attrs: {
                      striped: "",
                      small: "",
                      fixed: "",
                      items: _vm.branch,
                      fields: _vm.fields
                    }
                  })
                ],
                1
              ),
              _vm._v(" "),
              _c("CCardFooter")
            ],
            1
          ),
          _vm._v(" "),
          _c(
            "CCard",
            [
              _c("CCardHeader", [_vm._v(" Driver Information ")]),
              _vm._v(" "),
              _c(
                "CCardBody",
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
                        "\n          (" +
                          _vm._s(_vm.dismissCountDown) +
                          ") " +
                          _vm._s(_vm.message) +
                          "\n        "
                      )
                    ]
                  ),
                  _vm._v(" "),
                  _c("CDataTable", {
                    attrs: {
                      striped: "",
                      small: "",
                      fixed: "",
                      items: _vm.fleet,
                      fields: _vm.fields
                    }
                  })
                ],
                1
              ),
              _vm._v(" "),
              _c("CCardFooter")
            ],
            1
          )
        ],
        1
      ),
      _vm._v(" "),
      _c(
        "CCol",
        { attrs: { col: "12", lg: "12" } },
        [
          _c(
            "CCard",
            [
              _c("CCardHeader", [_vm._v(" Products Information ")]),
              _vm._v(" "),
              _c(
                "CCardBody",
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
                        "\n          (" +
                          _vm._s(_vm.dismissCountDown) +
                          ") " +
                          _vm._s(_vm.message) +
                          "\n        "
                      )
                    ]
                  ),
                  _vm._v(" "),
                  _c("CDataTable", {
                    attrs: {
                      striped: "",
                      small: "",
                      fixed: "",
                      items: _vm.products,
                      fields: _vm.productFields
                    }
                  })
                ],
                1
              ),
              _vm._v(" "),
              _c(
                "CCardFooter",
                [
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