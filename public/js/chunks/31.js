(window.webpackJsonp=window.webpackJsonp||[]).push([[31],{532:function(e,o,t){"use strict";t.r(o);var s=t(2),a=t.n(s),n={name:"Creat",data:function(){return{myLang:"",company_name:"",email:"",phone:"",newPassword:"",oldPassword:"",changePasswordShow:!0,password:"",imageIndex:null,showMessage:!1,number_of_products:0,message:"",alertColor:"",dismissSecs:7,dismissCountDown:0,showDismissibleAlert:!1}},methods:{changePassword:function(){this.changePasswordShow=!1},getProfile:function(){this.loading=!0;var e=this;a.a.post("/api/profile?token="+localStorage.getItem("api_token")).then((function(o){console.log(o.data),e.company_name=o.data.user.company_name,e.phone=o.data.user.phone,e.email=o.data.user.email})).catch((function(o){console.log(o),e.loading=!1,e.alertColor="danger",e.message="unexpected error occurred in getting fleets.",e.showAlert()}))},back:function(){this.changePasswordShow=!0},goBack:function(){this.$router.go(-1),this.$router.replace({path:"/driver-applications"})},storePassword:function(){var e=this,o=new FormData;o.append("old_password",e.oldPassword),o.append("new_password",e.newPassword),a.a.post("/api/reset-password?token="+localStorage.getItem("api_token"),o,{headers:{"Content-Type":"multipart/form-data"}}).then((function(o){e.alertColor="success",e.message="Successfully Uptaded Password.",e.showAlert()})).catch((function(o){console.log(o),e.alertColor="danger",e.message="your old Password is wrong.",e.showAlert()}))},store:function(){var e=this,o=new FormData;o.append("company_name",e.company_name),o.append("phone",e.phone),o.append("email",e.email),a.a.post("/api/edit-profile?token="+localStorage.getItem("api_token"),o,{headers:{"Content-Type":"multipart/form-data"}}).then((function(o){e.alertColor="success",e.message="Successfully Uptaded Company.",e.showAlert()})).catch((function(o){console.log(o),e.alertColor="danger",e.message="unexpected error occurred in creating new fleet.",e.showAlert()}))},countDownChanged:function(e){this.dismissCountDown=e},showAlert:function(){this.dismissCountDown=this.dismissSecs},getLocale:function(){var e;e=localStorage.getItem("locale")||"en",this.myLang=e}},mounted:function(){this.getProfile(),this.getLocale()}},r=t(1),l=Object(r.a)(n,(function(){var e=this,o=e.$createElement,t=e._self._c||o;return t("CRow",[t("CCol",{style:["ar"==e.myLang?{direction:"rtl","text-align":"right"}:""],attrs:{col:"12",lg:"6"}},[t("CCard",{attrs:{"no-header":""}},[1==e.changePasswordShow?t("CCardBody",[t("h1",{staticClass:"text-center"},[e._v(e._s(e.$t("presonal_information")))]),e._v(" "),t("template",{slot:"header"}),e._v(" "),t("CAlert",{attrs:{show:e.dismissCountDown,color:e.alertColor,fade:""},on:{"update:show":function(o){e.dismissCountDown=o}}},[e._v("\n          ("+e._s(e.dismissCountDown)+") "+e._s(e.message)+"\n        ")]),e._v(" "),t("p",{attrs:{for:""}},[e._v(e._s(e.$t("company_name")))]),e._v(" "),t("CInput",{attrs:{type:"text",placeholder:e.$t("company_name")+"..."},model:{value:e.company_name,callback:function(o){e.company_name=o},expression:"company_name"}}),e._v(" "),t("p",{attrs:{for:""}},[e._v(e._s(e.$t("company_mobile")))]),e._v(" "),t("CInput",{attrs:{type:"text",placeholder:e.$t("company_mobile")+"..."},model:{value:e.phone,callback:function(o){e.phone=o},expression:"phone"}}),e._v(" "),t("p",{attrs:{for:""}},[e._v(e._s(e.$t("email")))]),e._v(" "),t("CInput",{attrs:{type:"text",placeholder:e.$t("email")+"..."},model:{value:e.email,callback:function(o){e.email=o},expression:"email"}}),e._v(" "),t("CButton",{attrs:{color:"success"},on:{click:function(o){return e.store()}}},[e._v(e._s(e.$t("save")))]),e._v(" "),t("CButton",{attrs:{color:"info"},on:{click:function(o){return e.changePassword()}}},[e._v(e._s(e.$t("change_password")))])],2):t("CCardBody",[t("h1",{staticClass:"text-center"},[e._v(e._s(e.$t("change_password")))]),e._v(" "),t("template",{slot:"header"}),e._v(" "),t("CAlert",{attrs:{show:e.dismissCountDown,color:e.alertColor,fade:""},on:{"update:show":function(o){e.dismissCountDown=o}}},[e._v("\n          ("+e._s(e.dismissCountDown)+") "+e._s(e.message)+"\n        ")]),e._v(" "),t("p",[e._v(e._s(e.$t("old_password")))]),e._v(" "),t("CInput",{attrs:{type:"text",placeholder:e.$t("old_password")+"..."},model:{value:e.oldPassword,callback:function(o){e.oldPassword=o},expression:"oldPassword"}}),e._v(" "),t("p",[e._v(e._s(e.$t("new_password")))]),e._v(" "),t("CInput",{attrs:{type:"text",placeholder:e.$t("new_password")+"..."},model:{value:e.newPassword,callback:function(o){e.newPassword=o},expression:"newPassword"}}),e._v(" "),t("CButton",{attrs:{color:"success"},on:{click:function(o){return e.storePassword()}}},[e._v(e._s(e.$t("save")))]),e._v(" "),t("CButton",{attrs:{color:"info"},on:{click:function(o){return e.back()}}},[e._v(e._s(e.$t("back")))])],2)],1)],1)],1)}),[],!1,null,null,null);o.default=l.exports}}]);