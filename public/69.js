(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[69],{

/***/ "./frontend/src/views/fleets/ChatComposer.vue":
/*!****************************************************!*\
  !*** ./frontend/src/views/fleets/ChatComposer.vue ***!
  \****************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _ChatComposer_vue_vue_type_template_id_064ea132___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./ChatComposer.vue?vue&type=template&id=064ea132& */ "./frontend/src/views/fleets/ChatComposer.vue?vue&type=template&id=064ea132&");
/* harmony import */ var _ChatComposer_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./ChatComposer.vue?vue&type=script&lang=js& */ "./frontend/src/views/fleets/ChatComposer.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _ChatComposer_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _ChatComposer_vue_vue_type_template_id_064ea132___WEBPACK_IMPORTED_MODULE_0__["render"],
  _ChatComposer_vue_vue_type_template_id_064ea132___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "frontend/src/views/fleets/ChatComposer.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./frontend/src/views/fleets/ChatComposer.vue?vue&type=script&lang=js&":
/*!*****************************************************************************!*\
  !*** ./frontend/src/views/fleets/ChatComposer.vue?vue&type=script&lang=js& ***!
  \*****************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ChatComposer_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./ChatComposer.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./frontend/src/views/fleets/ChatComposer.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ChatComposer_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./frontend/src/views/fleets/ChatComposer.vue?vue&type=template&id=064ea132&":
/*!***********************************************************************************!*\
  !*** ./frontend/src/views/fleets/ChatComposer.vue?vue&type=template&id=064ea132& ***!
  \***********************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ChatComposer_vue_vue_type_template_id_064ea132___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib??vue-loader-options!./ChatComposer.vue?vue&type=template&id=064ea132& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./frontend/src/views/fleets/ChatComposer.vue?vue&type=template&id=064ea132&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ChatComposer_vue_vue_type_template_id_064ea132___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ChatComposer_vue_vue_type_template_id_064ea132___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./frontend/src/views/fleets/ChatComposer.vue?vue&type=script&lang=js&":
/*!*************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./frontend/src/views/fleets/ChatComposer.vue?vue&type=script&lang=js& ***!
  \*************************************************************************************************************************************************************************/
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

/* harmony default export */ __webpack_exports__["default"] = ({
  props: ["chats", "userid", "friendid"],
  data: function data() {
    return {
      chat: "",
      myLang: ""
    };
  },
  methods: {
    x: function x() {
      alert("hi");
    },
    sendChat: function sendChat(e) {
      if (this.chat != "") {
        var data = {
          chat: this.chat,
          friend_id: this.friendid,
          user_id: this.userid,
          curr: new Date().toLocaleString(this.myLang)
        };
        this.chat = "";
        this.chats.push(data);
        var mySound = document.getElementById("chat-sound");
        mySound.play();
        mySound.currentTime = 0;
        axios__WEBPACK_IMPORTED_MODULE_0___default.a.post("/api/chat/send_chat" + "?token=" + localStorage.getItem("api_token"), data).then(function (response) {});
      }
    },
    getLocale: function getLocale() {
      var locale;
      locale = localStorage.getItem("locale") || "en";
      this.myLang = locale;
    }
  },
  mounted: function mounted() {
    this.getLocale();
  }
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./frontend/src/views/fleets/ChatComposer.vue?vue&type=template&id=064ea132&":
/*!*****************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./frontend/src/views/fleets/ChatComposer.vue?vue&type=template&id=064ea132& ***!
  \*****************************************************************************************************************************************************************************************************************/
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
  return _c("div", { staticClass: "pannel-block field d-flex" }, [
    _c("input", {
      directives: [
        {
          name: "model",
          rawName: "v-model",
          value: _vm.chat,
          expression: "chat"
        }
      ],
      staticClass: "message-input",
      attrs: {
        type: "text",
        placeholder:
          _vm.myLang == "ar" ? "أكتب رسالة هنا ..." : "Write Messages Here..."
      },
      domProps: { value: _vm.chat },
      on: {
        keyup: function($event) {
          if (
            !$event.type.indexOf("key") &&
            _vm._k($event.keyCode, "enter", 13, $event.key, "Enter")
          ) {
            return null
          }
          return _vm.sendChat($event)
        },
        input: function($event) {
          if ($event.target.composing) {
            return
          }
          _vm.chat = $event.target.value
        }
      }
    }),
    _vm._v(" "),
    _c(
      "button",
      {
        staticClass: "message-sbt send-message",
        attrs: { id: "send" },
        on: { click: _vm.sendChat }
      },
      [
        _vm._v(
          "\n    " + _vm._s(_vm.myLang == "ar" ? " ارسال" : "Send") + "\n  "
        )
      ]
    )
  ])
}
var staticRenderFns = []
render._withStripped = true



/***/ })

}]);