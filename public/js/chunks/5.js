(window.webpackJsonp=window.webpackJsonp||[]).push([[5],{129:function(e,t,n){var i=n(213);"string"==typeof i&&(i=[[e.i,i,""]]);var o={hmr:!0,transform:void 0,insertInto:void 0};n(17)(i,o);i.locals&&(e.exports=i.locals)},212:function(e,t,n){"use strict";n(129)},213:function(e,t,n){(e.exports=n(16)(!1)).push([e.i,"\n.image {\n  width: 150px;\n  height: 150px;\n  background-size: cover;\n  cursor: pointer;\n  margin: 10px;\n  border-radius: 3px;\n}\n",""])},31:function(e,t,n){e.exports=function(){"use strict";function e(t){return(e="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(e){return typeof e}:function(e){return e&&"function"==typeof Symbol&&e.constructor===Symbol&&e!==Symbol.prototype?"symbol":typeof e})(t)}var t={props:{images:{type:Array,required:!0},index:{type:Number,required:!1,default:null}},data:function(){return{imgIndex:this.index,image:null,galleryXPos:0,thumbnailWidth:120}},computed:{imageUrl:function(){var e=this.images[this.imgIndex];return"string"==typeof e?e:e.url},alt:function(){var t=this.images[this.imgIndex];return"object"===e(t)?t.alt:""},isMultiple:function(){return this.images.length>1}},watch:{index:function(e,t){var n=this;this.imgIndex=e,null==t&&null!=e&&this.$nextTick((function(){n.updateThumbails()}))}},mounted:function(){var e=this;window.addEventListener("keydown",(function(t){37===t.keyCode?e.onPrev():39===t.keyCode?e.onNext():27===t.keyCode&&e.close()}))},methods:{close:function(){var e={imgIndex:this.imgIndex};this.imgIndex=null,this.$emit("close",e)},onPrev:function(){null!==this.imgIndex&&(this.imgIndex>0?this.imgIndex--:this.imgIndex=this.images.length-1,this.updateThumbails())},onNext:function(){null!==this.imgIndex&&(this.imgIndex<this.images.length-1?this.imgIndex++:this.imgIndex=0,this.updateThumbails())},onClickThumb:function(e,t){this.imgIndex=t,this.updateThumbails()},updateThumbails:function(){if(this.$refs.gallery){var e=this.$refs.gallery.clientWidth,t=this.imgIndex*this.thumbnailWidth,n=this.images.length*this.thumbnailWidth,i=Math.floor(e/(2*this.thumbnailWidth))*this.thumbnailWidth;n<e||(t<i?this.galleryXPos=0:t>this.images.length*this.thumbnailWidth-e+i?this.galleryXPos=-(this.images.length*this.thumbnailWidth-e-20):this.galleryXPos=-this.imgIndex*this.thumbnailWidth+i)}}}};function n(e,t,n,i,o,s,a,r,l,d){"boolean"!=typeof a&&(l=r,r=a,a=!1);const c="function"==typeof n?n.options:n;let u;if(e&&e.render&&(c.render=e.render,c.staticRenderFns=e.staticRenderFns,c._compiled=!0,o&&(c.functional=!0)),i&&(c._scopeId=i),s?(u=function(e){(e=e||this.$vnode&&this.$vnode.ssrContext||this.parent&&this.parent.$vnode&&this.parent.$vnode.ssrContext)||"undefined"==typeof __VUE_SSR_CONTEXT__||(e=__VUE_SSR_CONTEXT__),t&&t.call(this,l(e)),e&&e._registeredComponents&&e._registeredComponents.add(s)},c._ssrRegister=u):t&&(u=a?function(e){t.call(this,d(e,this.$root.$options.shadowRoot))}:function(e){t.call(this,r(e))}),u)if(c.functional){const e=c.render;c.render=function(t,n){return u.call(n),e(t,n)}}else{const e=c.beforeCreate;c.beforeCreate=e?[].concat(e,u):[u]}return n}const i="undefined"!=typeof navigator&&/msie [6-9]\\b/.test(navigator.userAgent.toLowerCase());function o(e){return(e,t)=>function(e,t){const n=i?t.media||"default":e,o=a[n]||(a[n]={ids:new Set,styles:[]});if(!o.ids.has(e)){o.ids.add(e);let n=t.source;if(t.map&&(n+="\n/*# sourceURL="+t.map.sources[0]+" */",n+="\n/*# sourceMappingURL=data:application/json;base64,"+btoa(unescape(encodeURIComponent(JSON.stringify(t.map))))+" */"),o.element||(o.element=document.createElement("style"),o.element.type="text/css",t.media&&o.element.setAttribute("media",t.media),void 0===s&&(s=document.head||document.getElementsByTagName("head")[0]),s.appendChild(o.element)),"styleSheet"in o.element)o.styles.push(n),o.element.styleSheet.cssText=o.styles.filter(Boolean).join("\n");else{const e=o.ids.size-1,t=document.createTextNode(n),i=o.element.childNodes;i[e]&&o.element.removeChild(i[e]),i.length?o.element.insertBefore(t,i[e]):o.element.appendChild(t)}}}(e,t)}let s;const a={};return n({render:function(){var e=this,t=e.$createElement,n=e._self._c||t;return n("transition",{attrs:{name:"modal"}},[null!==e.imgIndex?n("div",{staticClass:"vgs",on:{click:e.close}},[n("button",{staticClass:"vgs__close",attrs:{type:"button"},on:{click:e.close}},[e._v("\n      ×\n    ")]),e._v(" "),e.isMultiple?n("button",{staticClass:"vgs__prev",attrs:{type:"button"},on:{click:function(t){return t.stopPropagation(),e.onPrev(t)}}},[e._v("\n      ‹\n    ")]):e._e(),e._v(" "),e.images?n("div",{staticClass:"vgs__container",on:{click:function(t){return t.stopPropagation(),e.onNext(t)}}},[n("img",{staticClass:"vgs__container__img",attrs:{src:e.imageUrl,alt:e.alt},on:{click:function(t){return t.stopPropagation(),e.onNext(t)}}}),e._v(" "),e._t("default")],2):e._e(),e._v(" "),e.isMultiple?n("button",{staticClass:"vgs__next",attrs:{type:"button"},on:{click:function(t){return t.stopPropagation(),e.onNext(t)}}},[e._v("\n      ›\n    ")]):e._e(),e._v(" "),e.isMultiple?n("div",{ref:"gallery",staticClass:"vgs__gallery"},[e.images?n("div",{staticClass:"vgs__gallery__title"},[e._v("\n        "+e._s(e.imgIndex+1)+" / "+e._s(e.images.length)+"\n      ")]):e._e(),e._v(" "),e.images?n("div",{staticClass:"vgs__gallery__container",style:{transform:"translate("+e.galleryXPos+"px, 0)"}},e._l(e.images,(function(t,i){return n("img",{key:i,staticClass:"vgs__gallery__container__img",class:{"vgs__gallery__container__img--active":i===e.imgIndex},attrs:{src:"string"==typeof t?t:t.url,alt:"string"==typeof t?"":t.alt},on:{click:function(n){return n.stopPropagation(),e.onClickThumb(t,i)}}})})),0):e._e()]):e._e()]):e._e()])},staticRenderFns:[]},(function(e){e&&e("data-v-e9cc33d2_0",{source:".vgs{transition:opacity .2s ease;position:fixed;z-index:9998;top:0;left:0;width:100%;min-height:100%;height:100vh;background-color:rgba(0,0,0,.8);display:table}.vgs__close{color:#fff;position:absolute;top:0;right:0;background-color:transparent;border:none;font-size:25px;width:50px;height:50px;cursor:pointer;z-index:999}.vgs__close:focus{outline:0}.vgs__next,.vgs__prev{position:absolute;top:50%;margin-top:-25px;width:50px;height:50px;z-index:999;cursor:pointer;font-size:40px;color:#fff;background-color:transparent;border:none}.vgs__next:focus,.vgs__prev:focus{outline:0}.vgs__prev{left:0}.vgs__next{right:0}.vgs__container{position:absolute;overflow:hidden;cursor:pointer;overflow:hidden;max-width:100vh;margin:.5rem auto 0;left:.5rem;right:.5rem;height:60vh;border-radius:12px;background-color:#000}@media (max-width:767px){.vgs__container{width:100%;max-width:100%;top:50%;margin-top:-140px;left:0;right:0;border-radius:0;height:280px}}.vgs__container__img{width:100%;height:100%;object-fit:contain}.vgs__gallery{overflow-x:hidden;overflow-y:hidden;position:absolute;bottom:10px;margin:auto;max-width:100vh;white-space:nowrap;left:.5rem;right:.5rem}@media (max-width:767px){.vgs__gallery{display:none}}.vgs__gallery__title{color:#fff;margin-bottom:.5rem}.vgs__gallery__container{overflow:visible;display:block;height:100px;white-space:nowrap;transition:all .2s ease-in-out;width:100%}.vgs__gallery__container__img{width:100px;height:100px;object-fit:cover;display:inline-block;float:none;margin-right:20px;cursor:pointer;opacity:.6;border-radius:8px}.vgs__gallery__container__img--active{width:100px;display:inline-block;float:none;opacity:1}.modal-enter{opacity:0}.modal-leave-active{opacity:0}",map:void 0,media:void 0})}),t,void 0,!1,void 0,!1,o,void 0,void 0)}()},521:function(e,t,n){"use strict";n.r(t);var i=n(2),o=n.n(i),s=n(31),a={name:"EditUser",components:{VueGallerySlideshow:n.n(s).a},props:{caption:{type:String,default:"User id"}},data:function(){return{name:"",mobile:"",identity:"",password:"",showMessage:!1,message:"",alertColor:"",dismissSecs:7,dismissCountDown:0,showDismissibleAlert:!1,images:[],files:[],imageIndex:null,progress:0,deleteProgress:0}},methods:{goBack:function(){this.$router.go(-1)},fleetInfo:function(){var e=this;o.a.get("/api/fleets/"+e.$route.params.id+"/edit?token="+localStorage.getItem("api_token")).then((function(t){console.log(t.data.fleet.files),e.name=t.data.fleet.name,e.mobile=t.data.fleet.mobile,e.identity=t.data.fleet.identity,e.password=t.data.fleet.password,e.files=t.data.fleet.files,e.images=[],t.data.fleet.files.map((function(t){e.images.push(t.file_path)}))})).catch((function(t){console.log(t),e.alertColor="danger",e.message="unexpected error occurred in loading the fleet info.",e.showAlert()}))},update:function(){var e=this;o.a.post("/api/fleets/"+e.$route.params.id+"?token="+localStorage.getItem("api_token"),{_method:"PUT",name:e.name,mobile:e.mobile,identity:e.identity,password:e.password}).then((function(t){e.alertColor="success",e.message="Successfully updated user.",e.showAlert()})).catch((function(t){console.log(t),e.alertColor="danger",e.message="unexpected error occurred in Editing the fleet.",e.showAlert()}))},countDownChanged:function(e){this.dismissCountDown=e},showAlert:function(){this.dismissCountDown=this.dismissSecs},deleteFile:function(e){var t=this;o.a.post("/api/fleets/deleteFile/"+e+"?token="+localStorage.getItem("api_token"),{},{onUploadProgress:function(e){this.deleteProgress=parseInt(Math.round(100*e.loaded/e.total))}.bind(this)}).then((function(){t.fleetInfo(),t.deleteProgress=0})).catch((function(e){console.log(e)}))},handleFileUpload:function(e,t){var n=this,i=new FormData;i.append("file",e[0]),o.a.post("/api/fleets/addFile/"+n.$route.params.id+"?token="+localStorage.getItem("api_token"),i,{headers:{"Content-Type":"multipart/form-data"},onUploadProgress:function(e){this.progress=parseInt(Math.round(100*e.loaded/e.total))}.bind(this)}).then((function(){n.fleetInfo(),n.progress=0})).catch((function(e){console.log(e)}))},imageClick:function(e){this.imageIndex=this.images.indexOf(e)}},mounted:function(){this.fleetInfo()}},r=(n(212),n(1)),l=Object(r.a)(a,(function(){var e=this,t=e.$createElement,n=e._self._c||t;return n("CRow",[n("CCol",{attrs:{col:"12",lg:"6"}},[n("CCard",{attrs:{"no-header":""}},[n("CCardBody",[n("CForm",[n("template",{slot:"header"},[e._v("\n            Edit Fleet id:  "+e._s(e.$route.params.id)+"\n          ")]),e._v(" "),n("CAlert",{attrs:{show:e.dismissCountDown,color:"primary",fade:""},on:{"update:show":function(t){e.dismissCountDown=t}}},[e._v("\n            ("+e._s(e.dismissCountDown)+") "+e._s(e.message)+"\n          ")]),e._v(" "),n("CInput",{attrs:{type:"text",label:"Name",placeholder:"Name"},model:{value:e.name,callback:function(t){e.name=t},expression:"name"}}),e._v(" "),n("CInput",{attrs:{type:"text",label:"Mobile",placeholder:"Mobile"},model:{value:e.mobile,callback:function(t){e.mobile=t},expression:"mobile"}}),e._v(" "),n("CInput",{attrs:{type:"text",label:"Identity",placeholder:"Identity"},model:{value:e.identity,callback:function(t){e.identity=t},expression:"identity"}}),e._v(" "),n("CInput",{attrs:{type:"text",label:"Password",placeholder:"Password"},model:{value:e.password,callback:function(t){e.password=t},expression:"password"}}),e._v(" "),n("CButton",{attrs:{color:"primary"},on:{click:function(t){return e.update()}}},[e._v("Save")]),e._v(" "),n("CButton",{attrs:{color:"danger"},on:{click:e.goBack}},[e._v("Back")])],2)],1)],1)],1),e._v(" "),n("CCol",{attrs:{col:"12",lg:"6"}},[n("CCard",{attrs:{"no-header":""}},[n("CCardBody",[n("CForm",[n("template",{slot:"header"},[e._v("\n            Set Images:  "+e._s(e.$route.params.id)+"\n          ")]),e._v(" "),n("CAlert",{attrs:{show:e.dismissCountDown,color:"primary",fade:""},on:{"update:show":function(t){e.dismissCountDown=t}}},[e._v("\n            ("+e._s(e.dismissCountDown)+") "+e._s(e.message)+"\n          ")]),e._v(" "),n("CIcon",{attrs:{content:e.$options.plusIcon}}),e._v(" "),n("CIcon",{attrs:{content:e.$options.fileIcon}}),e._v(" "),n("CInputFile",{attrs:{type:"file",placeholder:"New file"},on:{change:e.handleFileUpload}})],2),e._v(" "),n("CProgress",{staticClass:"mb-2",attrs:{value:e.progress,color:"success",striped:"",animated:!0}})],1)],1),e._v(" "),n("CCard",{attrs:{"no-header":""}},[n("CCardBody",[n("CProgress",{staticClass:"mb-2",attrs:{value:e.deleteProgress,color:"warning",striped:"",animated:!0}}),e._v(" "),n("CRow",e._l(e.files,(function(t){return n("CCol",{key:t.id,attrs:{col:"4"}},[n("img",{staticClass:"image",attrs:{src:t.file_path},on:{click:function(n){return e.imageClick(t.file_path)}}}),e._v(" "),n("CButton",{staticClass:"btn btn-danger",on:{click:function(n){return e.deleteFile(t.id)}}},[e._v("delete")])],1)})),1),e._v(" "),n("vue-gallery-slideshow",{attrs:{images:e.images,index:e.imageIndex},on:{close:function(t){e.imageIndex=null}}})],1)],1)],1)],1)}),[],!1,null,null,null);t.default=l.exports}}]);