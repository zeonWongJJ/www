webpackJsonp([31],{GEBV:function(a,s){},SrnF:function(a,s,t){"use strict";Object.defineProperty(s,"__esModule",{value:!0});t("P9l9");var i={data:function(){return{id:0,balance:{}}},mounted:function(){if(this.id=this.$route.query.id,this.id){var a=this;a.$fetch("user_balance_get",{},a.id).then(function(s){a.balance=s})}},methods:{onClickLeft:function(){window.history.go(-1)}}},n={render:function(){var a=this,s=a.$createElement,t=a._self._c||s;return t("div",{staticClass:"balance_more"},[t("van-nav-bar",{staticClass:"white",attrs:{title:"余额明细","left-arrow":""},on:{"click-left":a.onClickLeft}}),a._v(" "),t("div",{staticClass:"body"},[t("div",{staticClass:"pay"},[a._v(a._s(1==a.balance.ub_type?"+"+a.balance.ub_money:"-"+a.balance.ub_money))]),a._v(" "),t("div",{staticClass:"row"},[t("div",{staticClass:"span"},[a._v("订单号：")]),a._v(" "),t("div",{staticClass:"span"},[a._v(a._s(a.balance.ub_number))])]),a._v(" "),t("div",{staticClass:"row"},[t("div",{staticClass:"span"},[a._v("类型：")]),a._v(" "),t("div",{staticClass:"span"},[a._v(a._s(a.balance.ub_item))])]),a._v(" "),t("div",{staticClass:"row"},[t("div",{staticClass:"span"},[a._v(a._s(1==a.balance.ub_type?"收入：":"支出："))]),a._v(" "),t("div",{staticClass:"span span_pay"},[a._v(a._s(a.balance.ub_money))])]),a._v(" "),a.balance.ub_pay_way?t("div",{staticClass:"row"},[t("div",{staticClass:"span"},[a._v("支付方式：")]),a._v(" "),t("div",{staticClass:"span"},[a._v(a._s(a.balance.ub_pay_way))])]):a._e(),a._v(" "),t("div",{staticClass:"row"},[t("div",{staticClass:"span"},[a._v("时间：")]),a._v(" "),t("div",{staticClass:"span"},[a._v(a._s(a.balance.ub_time))])]),a._v(" "),t("div",{staticClass:"row"},[t("div",{staticClass:"span"},[a._v("余额：")]),a._v(" "),t("div",{staticClass:"span"},[a._v(a._s(a.balance.ub_balance))])]),a._v(" "),t("div",{staticClass:"row"},[t("div",{staticClass:"span"},[a._v("备注：")]),a._v(" "),t("div",{staticClass:"span",staticStyle:{flex:"1","text-align":"right"}},[a._v(a._s(a.balance.ub_description))])])])],1)},staticRenderFns:[]};var e=t("VU/8")(i,n,!1,function(a){t("Wkxy"),t("GEBV")},"data-v-5abfa280",null);s.default=e.exports},Wkxy:function(a,s){}});