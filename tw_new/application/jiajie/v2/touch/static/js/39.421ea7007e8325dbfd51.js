webpackJsonp([39],{"+deM":function(e,s){},XHJP:function(e,s,t){"use strict";Object.defineProperty(s,"__esModule",{value:!0});var i=t("P9l9"),n={data:function(){return{edit:0,list:[],service_list:[{service_name:"家洁清洁很干净",service_info:"我的服务超级棒，一级棒，不干净不收钱哦",img:"uploadfile/20181122211202_.jpeg",service_sold:"0",service_is_show:"1"},{service_name:"家洁清洁很干净",service_info:"我的服务超级棒，一级棒，不干净不收钱哦",img:"uploadfile/20181122211202_.jpeg",service_sold:"0",service_is_show:"1"}],store_list:[{store_name:"辉记清洁有限公司",store_region:"广东省广州市番禺区",store_address:"钟村街道长华创意谷1606",store_info:"我是傻逼",store_status:"1",store_level:"1",store_sold:"0",img:"uploadfile/20181122210703_.jpeg"},{store_name:"辉记清洁有限公司",store_region:"广东省广州市番禺区",store_address:"钟村街道长华创意谷1606",store_info:"我是傻逼",store_status:"1",store_level:"1",store_sold:"0",img:"uploadfile/20181122210703_.jpeg"}],checkeds:[],uploadFileUrl:i.a.uploadFileUrl+"/",navIndex:1}},mounted:function(){this.init()},watch:{edit:function(e){this.checkeds=[]}},methods:{init:function(){var e=this;this.$fetch("user_collect_list",{},"-service").then(function(s){e.service_list=s}),this.$fetch("user_collect_list",{},"-store").then(function(s){e.store_list=s})},sureCheck:function(e){var s=this,t=[];return e.forEach(function(e){s.checkeds.indexOf(e.id)>=0&&t.push(e.id)}),t.length==e.length?1:0},checkAll:function(e){var s=this;s.sureCheck(e)?e.forEach(function(e){var t=s.checkeds.indexOf(e.id);s.checkeds.splice(t,1)}):e.forEach(function(e){s.checkeds.push(e.id)})},checkOne:function(e){var s=this.checkeds.indexOf(e);s>=0?this.checkeds.splice(s,1):this.checkeds.push(e)},cancel:function(){this.checkeds=[]},remove:function(){var e=this,s={id:e.checkeds};e.$fetch("user_collect_signle",s).then(function(s){e.init(),e.edit=!1})},onClickLeft:function(){this.$router.back(-1)},getList:function(e){for(var s=[],t=0,i=e,n={storeName:"",shopList:""},c=0;c<i.length;c++){for(var a="",o=0;o<s.length;o++)if(s[o].storeName==i[c].store_name){t=1,a=o;break}if(1==t)s[a].shopList.push(i[c]),t=0;else 0==t&&((n={}).storeName=i[c].store_name,n.shopList=new Array,n.shopList.push(i[c]),s.push(n))}return s}}},c={render:function(){var e=this,s=e.$createElement,t=e._self._c||s;return t("div",{staticClass:"myColl body"},[t("van-nav-bar",{staticClass:"blue",attrs:{"right-text":e.edit?"完成":"管理","left-arrow":""},on:{"click-left":e.onClickLeft,"click-right":function(s){e.edit=!e.edit}}},[t("div",{staticClass:"navBox",attrs:{slot:"title"},slot:"title"},[t("div",{staticClass:"nav",class:{checked:1==e.navIndex},on:{click:function(s){e.navIndex=1,e.edit=!1}}},[e._v("服务收藏")]),e._v(" "),t("div",{staticClass:"nav",class:{checked:2==e.navIndex},on:{click:function(s){e.navIndex=2,e.edit=!1}}},[e._v("店铺收藏")])])]),e._v(" "),t("div",{staticClass:"list"},[t("transition",{attrs:{name:"service"}},[t("div",{directives:[{name:"show",rawName:"v-show",value:1==e.navIndex,expression:"navIndex == 1"}],staticClass:"list_container"},e._l(e.service_list,function(s,i){return t("div",{staticClass:"list_dd"},[t("label",{directives:[{name:"show",rawName:"v-show",value:e.edit,expression:"edit"}]},[t("input",{attrs:{type:"checkbox"},domProps:{checked:e.checkeds.indexOf(s.id)>=0},on:{click:function(t){e.checkOne(s.id)}}})]),e._v(" "),t("div",{staticClass:"listBox"},[t("div",{staticClass:"img"},[t("img",{attrs:{src:e.uploadFileUrl+s.img,alt:""}})]),e._v(" "),t("ul",{staticClass:"right"},[t("li",[t("span",[e._v(e._s(s.service_name))])]),e._v(" "),t("li",[e._v(e._s(s.service_info))])])])])}))]),e._v(" "),t("transition",{attrs:{name:"store"}},[t("div",{directives:[{name:"show",rawName:"v-show",value:2==e.navIndex,expression:"navIndex == 2"}],staticClass:"list_container"},e._l(e.store_list,function(s,i){return t("div",{staticClass:"list_dd"},[t("label",{directives:[{name:"show",rawName:"v-show",value:e.edit,expression:"edit"}]},[t("input",{attrs:{type:"checkbox"},domProps:{checked:e.checkeds.indexOf(s.id)>=0},on:{click:function(t){e.checkOne(s.id)}}})]),e._v(" "),t("div",{staticClass:"listBox"},[t("div",{staticClass:"img"},[t("img",{attrs:{src:e.uploadFileUrl+s.img,alt:""}})]),e._v(" "),t("ul",{staticClass:"right"},[t("li",[t("span",[e._v(e._s(s.store_name))])]),e._v(" "),t("li",[e._v(e._s(s.store_info))]),e._v(" "),t("li",[t("div",[t("span",[e._v("等级")]),e._v(" "),t("em",[e._v(e._s(s.store_level))])]),e._v(" "),t("div",[t("span",[e._v("已售")]),e._v(" "),t("em",[e._v(e._s(s.store_sold))])])])])])])}))])],1),e._v(" "),t("van-tabbar",{directives:[{name:"show",rawName:"v-show",value:e.edit,expression:"edit"}]},[t("van-tabbar-item",{on:{click:e.cancel}},[e._v("取消")]),e._v(" "),t("van-tabbar-item",{on:{click:e.remove}},[e._v("删除")])],1)],1)},staticRenderFns:[]};var a=t("VU/8")(n,c,!1,function(e){t("syyS"),t("+deM")},"data-v-2260c16a",null);s.default=a.exports},syyS:function(e,s){}});