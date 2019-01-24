webpackJsonp([52],{XNW1:function(t,a,s){"use strict";Object.defineProperty(a,"__esModule",{value:!0});s("P9l9");var i={data:function(){return{cashNum:0,cashType:[],show:!1,sum:0,rule:!1,withdraw_type_id:null,withdraw_name:"",withdraw_number:"",withdraw_realname:"",cash:null,password:"",showLoad:!1,blue:!1,toast:!1,way_type:""}},mounted:function(){this.cashNum=this.$route.query.cashNum,this.sum=this.$route.query.value,void 0!==this.$route.query.way_type&&(this.way_type=this.$route.query.way_type),this.init()},methods:{init:function(){var t=this;t.$fetch("user_withdraw_account",{}).then(function(a){t.cashType=a})},onClickLeft:function(){window.history.go(-1)},showSelect:function(){this.show=!0},selectType:function(t){this.withdraw_type_id=t.withdraw_type_id,this.withdraw_name=t.withdraw_name,this.withdraw_number=t.withdraw_number,this.withdraw_realname=t.withdraw_realname},toSetCash:function(){this.$router.push({path:"/setCash"})},finish:function(){this.blue&&(3==this.withdraw_type_id?Math.floor(100*(this.cash-1))/100<=0?this.$toast("扣除手续费后不能达到最小提现额度，提现失败！"):this.toast=!0:this.sure())},pointRule:function(){this.rule=!0},closeLay:function(){this.rule=!1},sure:function(){if(this.cash<.1)this.$toast("单笔最低提现金额0.1元");else if(this.showLoad=!0,1==this.cashNum){var t=this;(a={}).withdraw_account=t.withdraw_number,a.withdraw_name=t.withdraw_realname,a.payment_code=t.password,a.withdraw_money=t.cash,a.withdraw_type="bankcard","支付宝"==t.withdraw_name?a.withdraw_type="alipay":"微信"==t.withdraw_name&&(a.withdraw_type="wechat"),"store"===t.way_type&&(a.way_type="store"),t.$fetch("user_withdraw_withdraw_balance",a).then(function(a){t.$toast("提现成功！"),t.$router.push({path:"/member"})}).catch(function(a){t.showLoad=!1})}else{var a,s=this;(a={}).withdraw_account=s.withdraw_number,a.withdraw_name=s.withdraw_realname,a.payment_code=s.password,a.withdraw_score=s.cash,a.withdraw_type="bankcard","支付宝"==s.withdraw_name?a.withdraw_type="alipay":"微信"==s.withdraw_name&&(a.withdraw_type="wechat"),s.$fetch("user_withdraw_withdraw_score",a).then(function(t){s.$toast("提现成功！"),s.$router.push({path:"/member"})}).catch(function(t){s.showLoad=!1})}}},watch:{cash:function(t,a){t&&!/^([0-9]*)+(.[0-9]{1,2})?$/.test(t)&&(this.cash=0),t&&t>Number(this.sum)&&(this.cash=this.sum),t.length&&this.password&&this.withdraw_name?this.blue=!0:this.blue=!1},password:function(t,a){t.length&&this.cash&&this.withdraw_name?this.blue=!0:this.blue=!1},withdraw_name:function(t,a){t.length&&this.cash&&this.password?this.blue=!0:this.blue=!1}}},e={render:function(){var t=this,a=t.$createElement,s=t._self._c||a;return s("div",{staticClass:"balance_cash"},[s("van-nav-bar",{staticClass:"white",attrs:{title:1==t.cashNum?"余额提现":"积分提现","left-arrow":""},on:{"click-left":t.onClickLeft}}),t._v(" "),s("div",{staticClass:"body"},[s("div",{staticClass:"top"},[s("div",[t._v(t._s(1==t.cashNum?"可提现金额(元)":"可兑换提现积分(元)"))]),t._v(" "),s("div",{staticClass:"sum"},[t._v(t._s(t.sum))]),t._v(" "),s("span",{staticClass:"pointRule",on:{click:t.pointRule}},[t._v("提现说明 >")])]),t._v(" "),s("van-popup",{staticClass:"ruleBox",attrs:{position:"right"},model:{value:t.rule,callback:function(a){t.rule=a},expression:"rule"}},[s("van-nav-bar",{staticClass:"blue",attrs:{title:"提现说明","left-arrow":""},on:{"click-left":t.closeLay}}),t._v(" "),s("p",[t._v("1.帮家洁平台使用第三方支付方式进行提现，当前支持的提现方式包含：支付宝支付、微信支付、银联支付三种提现方式；")]),t._v(" "),s("p",[t._v("2.您的帮家洁账号余额，可以通过支付宝支付、微信支付、银联支付三种提现方式，由于（支付宝支付、微信支付、银联支付）第三方支付需要收取手续费，帮家洁平台将根据不同的第三方提现方式代扣手续费，手续费代扣标准请查看其他条款。")]),t._v(" "),s("p",[t._v("3.积分提现，您在帮家洁平台的积分达到500分或以上时，即可以提现，由于（支付宝支付、微信支付、银联支付）第三方支付需要收取手续费，帮家洁平台将根据不同的第三方提现方式代扣手续费，手续费代扣标准请查看其他条款。")]),t._v(" "),s("p",[t._v("4.提现手续费率：当前支付宝支付、微信支付手续费率为0.6%，最低0.1元；银联手续费率根据个人用户和企业用户不同，个人用户每笔1元，企业用户每笔2元。")])],1),t._v(" "),s("div",{staticClass:"center"},[s("div",{staticClass:"row"},[s("div",[t._v("收款账户")]),t._v(" "),s("div",{staticClass:"right",on:{click:t.showSelect}},[t.withdraw_type_id?s("div",{staticClass:"pull_right"},[s("div",{staticClass:"type",class:[{wechat:1==t.withdraw_type_id},{alipay:2==t.withdraw_type_id},{union:3==t.withdraw_type_id}]},[t._v("\n\t\t\t\t\t\t\t"+t._s(t.withdraw_number)+"\n\t\t\t\t\t\t")])]):s("div",[t.cashType?s("span",[t._v("\n\t\t\t\t\t\t\t请选择收款账户\n\t\t\t\t\t\t")]):s("span",[t._v("\n\t\t\t\t\t\t\t请添加收款账户\n\t\t\t\t\t\t")])])])]),t._v(" "),s("div",{staticClass:"row"},[s("div",[t._v("收款方式")]),t._v(" "),t.withdraw_type_id?s("div",{staticClass:"pull_right"},[t._v(t._s(t.withdraw_name))]):s("div",{staticClass:"color_gray"},[t._v("选择账户后会识别方式")])]),t._v(" "),s("div",{staticClass:"row"},[s("div",[t._v("姓名")]),t._v(" "),s("div",{staticClass:"color_gray"},[s("input",{directives:[{name:"model",rawName:"v-model",value:t.withdraw_realname,expression:"withdraw_realname"}],attrs:{type:"text",placeholder:"请输入收款人姓名",name:"username",id:"username",value:""},domProps:{value:t.withdraw_realname},on:{input:function(a){a.target.composing||(t.withdraw_realname=a.target.value)}}})])]),t._v(" "),s("div",{staticClass:"row"},[s("div",[t._v(t._s(1==t.cashNum?"提现金额":"提现积分"))]),t._v(" "),s("div",{staticClass:"color_gray"},[s("input",{directives:[{name:"model",rawName:"v-model",value:t.cash,expression:"cash"}],attrs:{type:"number",placeholder:"请输入提取金额",name:"cash",id:"cash",min:"0",max:t.sum},domProps:{value:t.cash},on:{input:function(a){a.target.composing||(t.cash=a.target.value)}}})])]),t._v(" "),s("div",{staticClass:"row"},[s("div",[t._v("提现密码")]),t._v(" "),s("div",{staticClass:"color_gray"},[s("input",{directives:[{name:"model",rawName:"v-model",value:t.password,expression:"password"}],attrs:{type:"password",placeholder:"输入您在本平台设置的支付密码",name:"password",id:"password",value:""},domProps:{value:t.password},on:{input:function(a){a.target.composing||(t.password=a.target.value)}}})])])]),t._v(" "),3==t.withdraw_type_id?s("div",{staticClass:"bg_gray"},[t._v("\n\t\t\t中国银联收取1元服务费\n\t\t")]):t._e(),t._v(" "),s("div",{staticClass:"bottom"},[s("div",{staticClass:"btn",class:{blue:t.blue},on:{click:t.finish}},[t._v("预计两小时内到账，确认提取")])])],1),t._v(" "),s("van-popup",{attrs:{position:"bottom"},model:{value:t.show,callback:function(a){t.show=a},expression:"show"}},[s("div",{staticClass:"selectTypeView"},[s("div",{staticClass:"btn"},[s("div",{staticClass:"finish",on:{click:function(a){t.show=!1}}},[t._v("完成")])]),t._v(" "),s("div",{staticClass:"ul"},[t._l(t.cashType,function(a){return s("div",{staticClass:"li",on:{click:function(s){t.selectType(a),t.show=!1}}},[t._v("\n\t\t\t\t\t"+t._s(a.withdraw_name+""+a.withdraw_number)+"\n\t\t\t\t")])}),t._v(" "),s("div",{staticClass:"li",on:{click:t.toSetCash}},[t._v("+管理提现账户")])],2)])]),t._v(" "),s("van-popup",{attrs:{position:"bottom"},model:{value:t.toast,callback:function(a){t.toast=a},expression:"toast"}},[s("div",{staticClass:"toastView"},[s("div",{staticClass:"title"},[s("div"),t._v(" "),s("div",[t._v("收费提示")]),t._v(" "),s("div",{staticClass:"cancel",on:{click:function(a){t.toast=!1}}})]),t._v(" "),s("div",{staticClass:"ul"},[s("div",{staticClass:"li"},[s("div",[t._v("实际到账金额如下")]),t._v(" "),s("div")]),t._v(" "),s("div",{staticClass:"li"},[s("div",{staticClass:"color_gray"},[t._v("到账金额")]),t._v(" "),s("div",{staticClass:"color_red"},[t._v(t._s(Math.floor(100*(t.cash-1))/100)+"元")])]),t._v(" "),s("div",{staticClass:"li"},[s("div",{staticClass:"color_gray"},[t._v("中国银联收取服务费")]),t._v(" "),s("div",[t._v("1.00元")])])]),t._v(" "),s("div",{staticClass:"btn",on:{click:function(a){t.sure(),t.toast=!1}}},[t._v("继续提现")])])]),t._v(" "),s("on-loading",{attrs:{show:t.showLoad}})],1)},staticRenderFns:[]};var r=s("VU/8")(i,e,!1,function(t){s("lPeT")},"data-v-6e8a0c71",null);a.default=r.exports},lPeT:function(t,a){}});