webpackJsonp([43],{J5nh:function(t,e,s){"use strict";Object.defineProperty(e,"__esModule",{value:!0});s("P9l9");var o={components:{Protocol:s("i4aD").a},data:function(){return{showFooter:!0,phone:"",sms:"",time:60,count_text:"获取验证码",canSMS:!0,isGetSMS:!0,checked:!1,bind:this.$route.query.bind}},mounted:function(){var t=this;window.onSMSReceiveSuccess=function(e){e.code&&(t.sms=e.code)}},methods:{toggleLogo:function(){this.showFooter=!1},onClickLeft:function(){this.$router.push({path:"/login"})},getSMS:function(){var t=this;if(this.canSMS){/^(13[0-9]|14[579]|15[0-3,5-9]|16[6]|17[0135678]|18[0-9]|19[89])\d{8}$/.test(this.phone)?this.$fetch("user_code_send",{user_phone:this.phone}).then(function(e){t.$toast("验证码已发送"),t.countDown(),t.canSMS=!1,t.isGetSMS=!0}).catch(function(e){t.canSMS=!1}):this.$toast("手机号码不合法")}else this.$toast("请勿频繁操作")},countDown:function(){this.count_text=this.time+"秒",0===this.time?(this.count_text="获取验证码",this.time=60,this.canSMS=!0):(this.count_text=this.time--+"秒",setTimeout(this.countDown,1e3))},login:function(){var t=this;if(/^(13[0-9]|14[579]|15[0-3,5-9]|16[6]|17[0135678]|18[0-9]|19[89])\d{8}$/.test(this.phone))if(this.isGetSMS)if(4!==this.sms.length)this.$toast("验证码不合法");else if(this.checked){var e="user_login_msn",s={};s.verify_code=this.sms,this.bind?(e="user_bind_phone",s.user_phone=this.phone):s.mobile=this.phone,this.$fetch(e,s).then(function(e){t.$store.commit("login",e.token),t.$router.replace({path:"/home"}),t.$fetch("user_info_get",{},"","GET").then(function(e){t.$store.commit("user_info",e),t.$store.commit("user_id",e.user_id)}).catch(function(t){})}).catch(function(t){})}else this.$toast("请勾选并同意帮家洁平台相关协议");else this.$toast("请先获取验证码");else this.$toast("手机号码不合法")}}},i={render:function(){var t=this,e=t.$createElement,o=t._self._c||e;return o("div",{staticClass:"loginByMobile"},[o("van-nav-bar",{staticClass:"white",attrs:{title:t.bind?"手机绑定":"手机登录(免注册)","left-arrow":""},on:{"click-left":t.onClickLeft}}),t._v(" "),o("div",{staticClass:"main",staticStyle:{position:"relative"}},[o("van-cell-group",{staticStyle:{position:"absolute","z-index":"999",width:"100%"},attrs:{border:!1}},[o("van-field",{attrs:{center:"",clearable:"",label:"+86",placeholder:"输入手机号"},model:{value:t.phone,callback:function(e){t.phone=e},expression:"phone"}}),t._v(" "),o("van-field",{attrs:{center:"",clearable:"",label:"验证码",placeholder:"输入验证码"},model:{value:t.sms,callback:function(e){t.sms=e},expression:"sms"}},[o("van-button",{staticClass:"plain",attrs:{slot:"button",size:"small"},on:{click:t.getSMS},slot:"button"},[t._v(t._s(t.count_text))])],1),t._v(" "),o("div",{staticClass:"protocol"},[o("i",{staticClass:"iconfont",class:[t.checked?"icon-checkoutline02":"icon-check02"],on:{click:function(e){t.checked=!t.checked}}}),t._v(" "),o("Protocol",{attrs:{showTip:"2"}})],1),t._v(" "),o("van-button",{staticClass:"blue",attrs:{round:"",size:"large"},on:{click:t.login}},[t._v("登录")])],1)],1),t._v(" "),o("div",{directives:[{name:"show",rawName:"v-show",value:t.showFooter,expression:"showFooter"}],staticClass:"footer"},[o("img",{attrs:{src:s("y8yI")}}),t._v(" "),o("div",{staticClass:"logo_name"},[t._v("广州柒度信息科技有限公司")])])],1)},staticRenderFns:[]};var n=s("VU/8")(o,i,!1,function(t){s("Nczv"),s("hOtr")},"data-v-0514279c",null);e.default=n.exports},Nczv:function(t,e){},hOtr:function(t,e){}});