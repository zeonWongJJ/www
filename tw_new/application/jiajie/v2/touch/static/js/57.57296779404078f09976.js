webpackJsonp([57],{"8JJH":function(e,t){},R6Jh:function(e,t,a){"use strict";Object.defineProperty(t,"__esModule",{value:!0});var i=a("fZjL"),n=a.n(i),s=(a("P9l9"),a("oAV5")),o={data:function(){return{bindtype:0,wechat:{wx_nickname:sessionStorage.getItem("wechat_nickname")||"",wx_openid:sessionStorage.getItem("wechat_openid")||""},alipay:{alipay_realname:"",alipay_number:""},union:{bank_realname:"",bank_number:"",bank_name:"",bank_province:"",bank_city:"",sub_bank:""}}},mounted:function(){var e=this;if(this.bindtype=this.$route.query.bindtype,1==this.bindtype){var t=s.a.getUrlParam("is_completed");if(s.a.is_weixin()&&"true"!=t)window.location.href="http://jiajie-server.7dugo.com/wechat.get.userinfo?refer=http://jiajie-touch.7dugo.com&route=binding_next?bindtype=1";else{var a=decodeURIComponent(s.a.getUrlParam("user_name")),i=s.a.getUrlParam("open_id");sessionStorage.setItem("wechat_nickname",a),sessionStorage.setItem("wechat_openid",i),this.wechat.wx_nickname=a,this.wechat.wx_openid=i}s.a.is_android()&&android.wxAuthorizationLogin(),s.a.is_ios()&&window.webkit.messageHandlers.wxAuthorizationLogin.postMessage({}),window.wxAuthorizationLoginSuccess=function(t){e.wechat.wx_nickname=t.nickname,e.wechat.wx_openid=t.openid}}},methods:{onClickLeft:function(){window.history.go(-1)},sure3:function(){var e=this,t=0;if(n()(e.union).forEach(function(a){0!==e.union[a].length&&t++}),6===t){var a=e.union;e.$fetch("user_bind_bank",a).then(function(t){e.$toast("绑定成功"),setTimeout(function(){e.$router.push({path:"/setCash"})},1e3)})}else e.$toast("请填写必填项！")},sure2:function(){var e=this;if(0!=e.alipay.alipay_realname.length)if(0!=e.alipay.alipay_number.length){var t=e.alipay;e.$fetch("user_bind_alipay",t).then(function(t){e.$toast("绑定成功"),setTimeout(function(){e.$router.push({path:"/setCash"})},1e3)})}else e.$toast("请填写支付宝收款账号！");else e.$toast("请填写支付宝收款人真实名字！")},sure1:function(){var e=this;if(0==this.wechat.wx_nickname.length||0==this.wechat.wx_openid.length)return this.$toast("请先绑定微信！");var t=this.wechat;e.$fetch("user_bind_wechat",t).then(function(t){e.$toast("绑定成功"),e.$router.push({path:"/setCash"})})}}},l={render:function(){var e=this,t=e.$createElement,a=e._self._c||t;return a("div",{staticClass:"binding_next"},[a("van-nav-bar",{staticClass:"white",attrs:{title:3==e.bindtype?"绑定银行卡":2==e.bindtype?"绑定支付宝":"绑定微信","left-arrow":""},on:{"click-left":e.onClickLeft}}),e._v(" "),3==e.bindtype?a("div",{staticClass:"body"},[a("div",{staticClass:"top"},[e._v("请绑定需要提现的银行卡")]),e._v(" "),a("div",{staticClass:"center"},[a("div",{staticClass:"label"},[a("div",{staticClass:"left"},[e._v("姓名")]),e._v(" "),a("div",{staticClass:"right"},[a("input",{directives:[{name:"model",rawName:"v-model",value:e.union.bank_realname,expression:"union.bank_realname"}],attrs:{type:"text",placeholder:"请输入收款人姓名"},domProps:{value:e.union.bank_realname},on:{input:function(t){t.target.composing||e.$set(e.union,"bank_realname",t.target.value)}}})])]),e._v(" "),a("div",{staticClass:"label"},[a("div",{staticClass:"left"},[e._v("卡号")]),e._v(" "),a("div",{staticClass:"right"},[a("input",{directives:[{name:"model",rawName:"v-model",value:e.union.bank_number,expression:"union.bank_number"}],attrs:{type:"text",placeholder:"请输入银行卡账号"},domProps:{value:e.union.bank_number},on:{input:function(t){t.target.composing||e.$set(e.union,"bank_number",t.target.value)}}})])]),e._v(" "),a("div",{staticClass:"label"},[a("div",{staticClass:"left"},[e._v("开户行名称")]),e._v(" "),a("div",{staticClass:"right"},[a("input",{directives:[{name:"model",rawName:"v-model",value:e.union.bank_name,expression:"union.bank_name"}],attrs:{type:"text",placeholder:"请输入开户行名称"},domProps:{value:e.union.bank_name},on:{input:function(t){t.target.composing||e.$set(e.union,"bank_name",t.target.value)}}})])]),e._v(" "),a("div",{staticClass:"label"},[a("div",{staticClass:"left"},[e._v("开户行所在省")]),e._v(" "),a("div",{staticClass:"right"},[a("input",{directives:[{name:"model",rawName:"v-model",value:e.union.bank_province,expression:"union.bank_province"}],attrs:{type:"text",placeholder:"请输入开户行所在省"},domProps:{value:e.union.bank_province},on:{input:function(t){t.target.composing||e.$set(e.union,"bank_province",t.target.value)}}})])]),e._v(" "),a("div",{staticClass:"label"},[a("div",{staticClass:"left"},[e._v("开户行所在地区")]),e._v(" "),a("div",{staticClass:"right"},[a("input",{directives:[{name:"model",rawName:"v-model",value:e.union.bank_city,expression:"union.bank_city"}],attrs:{type:"text",placeholder:"请输入开户行所在地区"},domProps:{value:e.union.bank_city},on:{input:function(t){t.target.composing||e.$set(e.union,"bank_city",t.target.value)}}})])]),e._v(" "),a("div",{staticClass:"label"},[a("div",{staticClass:"left"},[e._v("开户支行名称")]),e._v(" "),a("div",{staticClass:"right"},[a("input",{directives:[{name:"model",rawName:"v-model",value:e.union.sub_bank,expression:"union.sub_bank"}],attrs:{type:"text",placeholder:"请输入开户支行名称"},domProps:{value:e.union.sub_bank},on:{input:function(t){t.target.composing||e.$set(e.union,"sub_bank",t.target.value)}}})])])]),e._v(" "),a("div",{staticClass:"btn",on:{click:e.sure3}},[e._v("确定")])]):e._e(),e._v(" "),2==e.bindtype?a("div",{staticClass:"body"},[a("div",{staticClass:"top"},[e._v("请仔细核对您的支付宝账号，以确保能成功提现")]),e._v(" "),a("div",{staticClass:"center"},[a("div",{staticClass:"label"},[a("div",{staticClass:"left"},[e._v("姓名")]),e._v(" "),a("div",{staticClass:"right"},[a("input",{directives:[{name:"model",rawName:"v-model",value:e.alipay.alipay_realname,expression:"alipay.alipay_realname"}],attrs:{type:"text",placeholder:"请输入收款人姓名"},domProps:{value:e.alipay.alipay_realname},on:{input:function(t){t.target.composing||e.$set(e.alipay,"alipay_realname",t.target.value)}}})])]),e._v(" "),a("div",{staticClass:"label"},[a("div",{staticClass:"left"},[e._v("提现账户")]),e._v(" "),a("div",{staticClass:"right"},[a("input",{directives:[{name:"model",rawName:"v-model",value:e.alipay.alipay_number,expression:"alipay.alipay_number"}],attrs:{type:"text",placeholder:"请输入支付宝账号"},domProps:{value:e.alipay.alipay_number},on:{input:function(t){t.target.composing||e.$set(e.alipay,"alipay_number",t.target.value)}}})])])]),e._v(" "),a("div",{staticClass:"btn",on:{click:e.sure2}},[e._v("确定")])]):e._e(),e._v(" "),1==e.bindtype?a("div",{staticClass:"body"},[a("div",{staticClass:"top"},[e._v("请仔细核对您的微信账号，以确保能成功提现")]),e._v(" "),a("div",{staticClass:"center"},[a("div",{staticClass:"label"},[a("div",{staticClass:"left"},[e._v("微信名")]),e._v(" "),a("div",{staticClass:"right"},[a("input",{directives:[{name:"model",rawName:"v-model",value:e.wechat.wx_nickname,expression:"wechat.wx_nickname"}],attrs:{id:"wechat_nickname",type:"text",placeholder:"请点击绑定获取微信名",readonly:""},domProps:{value:e.wechat.wx_nickname},on:{input:function(t){t.target.composing||e.$set(e.wechat,"wx_nickname",t.target.value)}}})])]),e._v(" "),a("div",{staticClass:"label"},[a("div",{staticClass:"left"},[e._v("提现账号")]),e._v(" "),a("div",{staticClass:"right"},[a("input",{directives:[{name:"model",rawName:"v-model",value:e.wechat.wx_openid,expression:"wechat.wx_openid"}],attrs:{id:"wechat_openid",type:"text",placeholder:"请点击绑定获取微信账号",readonly:""},domProps:{value:e.wechat.wx_openid},on:{input:function(t){t.target.composing||e.$set(e.wechat,"wx_openid",t.target.value)}}})])])]),e._v(" "),a("div",{staticClass:"btn",on:{click:e.sure1}},[e._v("确定")])]):e._e()],1)},staticRenderFns:[]};var r=a("VU/8")(o,l,!1,function(e){a("8JJH")},"data-v-540f149e",null);t.default=r.exports}});