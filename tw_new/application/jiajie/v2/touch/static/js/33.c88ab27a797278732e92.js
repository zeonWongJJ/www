webpackJsonp([33],{"/vkH":function(t,s,i){"use strict";Object.defineProperty(s,"__esModule",{value:!0});var e=i("P9l9"),n=i("oAV5"),a={data:function(){return{index:0,page:1,end:!1,firstFinish:!1,uploadFileUrl:e.a.uploadFileUrl+"/",layBox:!1,serShow:!1,dealShow:!1,ser_Show:0,deal_Show:0,nav:[{data:"综合排序"},{data:"服务类别"},{data:"离我最近"}],rest:[{name:"全部"},{name:"价格高到低"},{name:"价格低到高"}],liststs:[],category_list:[],lal:""}},mounted:function(){var t=this;this.init(),n.a.is_android()&&android.locationCurrentPosition(),n.a.is_ios()&&window.webkit.messageHandlers.locationCurrentPosition.postMessage({}),window.locationSuccess=function(s){t.lal=s.longitude+","+s.latitude}},methods:{init:function(){var t=this,s={condition:{"b.order_is_pay":1,"b.order_belong_store_id":0}};s.page=this.page,this.$fetch("demand_list",s).then(function(s){t.page++,t.liststs=s,10!=s.length?(t.end=!0,t.$refs.scroller_liststs.finishInfinite(!0)):t.$refs.scroller_liststs.finishInfinite(!1),t.firstFinish=!0}).catch(function(s){t.$refs.scroller_liststs.finishInfinite(!1)}),this.getCategoryList()},infinite:function(t){if(this.firstFinish){if(this.end)return void setTimeout(function(){t(!0)},1500);0==index?this.serOs(0,t):1==index?this.getDemandByCategoryId(0,t):this.serju(0,t)}},layShow:function(){this.layBox=!this.layBox},serShows:function(){this.serShow=!this.serShow},navFun:function(t,s){this.index=t,1==t?(this.layBox=!0,this.serShow=!1):0==t?(this.serShow=!0,this.layBox=!1):(this.layBox=!1,this.serShow=!1,this.serju(1))},getCategoryList:function(){var t=this,s={condition:{parent_id:0}};this.$fetch("category_list",s).then(function(s){t.category_list=s})},setCategoryId:function(t,s){this.ser_Show=s,this.layBox=!this.layBox,this.getDemandByCategoryId(1)},getDemandByCategoryId:function(t,s){var i=this;t&&(this.page=1);var e={};e.condition={"a.demand_level_1":this.category_list[this.ser_Show].id,"b.order_is_pay":1,"b.order_belong_store_id":0},e.page=this.page,this.$fetch("demand_list",e).then(function(e){i.page++,i.liststs=t?e:i.liststs.concat(e),10!=e.length?(s?setTimeout(function(){s(!0)}):i.$refs.scroller_liststs.finishInfinite(!0),i.end=!0):s?setTimeout(function(){s()}):i.$refs.scroller_liststs.finishInfinite(!1)}).catch(function(t){s?setTimeout(function(){s(!0)}):i.$refs.scroller_liststs.finishInfinite(!1)})},setRest:function(t,s){this.deal_Show=s,this.serShow=!this.serShow,this.serOs(1)},serOs:function(t,s){var i=this;t&&(this.page=1);var e={};e.page=this.page,e.condition={"b.order_is_pay":1,"b.order_belong_store_id":0},1==this.deal_Show?e.sort={"a.demand_remuneration":"desc"}:2==this.deal_Show&&(e.sort={"a.demand_remuneration":"asc"}),this.$fetch("demand_list",e).then(function(e){i.page++,i.liststs=t?e:i.liststs.concat(e),10!=e.length?(s?setTimeout(function(){s(!0)}):i.$refs.scroller_liststs.finishInfinite(!0),that.end=!0):s?setTimeout(function(){s()}):i.$refs.scroller_liststs.finishInfinite(!1)}).catch(function(t){s?setTimeout(function(){s(!0)}):i.$refs.scroller_liststs.finishInfinite(!1)})},serju:function(t,s){var i=this;if(t&&(this.page=1,n.a.is_android()&&android.locationCurrentPosition(),n.a.is_ios()&&window.webkit.messageHandlers.locationCurrentPosition.postMessage({})),this.lal){var e={};e.locate_info=this.lal,e.page=this.page,this.$fetch("demand_list_lal",e).then(function(e){i.page++,i.liststs=t?e:i.liststs.concat(e),10!=e.length?(s?setTimeout(function(){s(!0)}):i.$refs.scroller_liststs.finishInfinite(!0),that.end=!0):s?setTimeout(function(){s()}):i.$refs.scroller_liststs.finishInfinite(!1)}).catch(function(t){s?setTimeout(function(){s(!0)}):i.$refs.scroller_liststs.finishInfinite(!1)})}else this.$toast("定位出错")},goDeatil:function(t,s){this.$router.push({path:"detailDem",query:{item_id:t.id}})}}},o={render:function(){var t=this,s=t.$createElement,e=t._self._c||s;return e("div",{staticClass:"fomd_job"},[e("van-nav-bar",{staticClass:"head",attrs:{title:"赚钱"}}),t._v(" "),e("van-tabs",{on:{click:t.navFun}},t._l(t.nav,function(t,s){return e("van-tab",{key:s,attrs:{title:t.data}})})),t._v(" "),e("div",{directives:[{name:"show",rawName:"v-show",value:t.layBox,expression:"layBox"}],staticClass:"lay",on:{click:t.layShow}},[e("div",{staticClass:"serviceType"},t._l(t.category_list,function(s,i){return e("a",{class:{serCur:i==t.ser_Show},on:{click:function(e){e.stopPropagation(),t.setCategoryId(s,i)}}},[t._v(t._s(s.cat_name))])}))]),t._v(" "),e("div",{directives:[{name:"show",rawName:"v-show",value:t.serShow,expression:"serShow"}],staticClass:"lay",on:{click:t.serShows}},[e("div",{staticClass:"serviceType"},t._l(t.rest,function(s,i){return e("a",{class:{serCur:i==t.deal_Show},on:{click:function(e){e.stopPropagation(),t.setRest(s,i)}}},[t._v(t._s(s.name))])}))]),t._v(" "),e("div",{staticClass:"list_container"},[e("scroller",{ref:"scroller_liststs",attrs:{"on-infinite":t.infinite}},[t.liststs?e("ul",{staticClass:"list_container_ul"},t._l(t.liststs,function(s,n){return e("li",{staticClass:"list_li",attrs:{id:s.id},on:{click:function(i){t.goDeatil(s,n)}}},[s.demand_img?e("div",{staticClass:"list_left"},[""==s.demand_img?e("img",{attrs:{src:i("y8yI")}}):e("img",{attrs:{src:t.uploadFileUrl+s.demand_img[0]}})]):t._e(),t._v(" "),e("div",{staticClass:"list_right"},[e("div",[e("span",[t._v(t._s(s.subject_title))])]),t._v(" "),e("div",[e("span",[t._v(t._s(s.demand_info))]),t._v(" "),e("img",{attrs:{src:i("vC+O"),alt:""}})]),t._v(" "),e("div",[e("span",[t._v("¥"+t._s(s.demand_remuneration))])])])])})):t._e()])],1)],1)},staticRenderFns:[]};var r=i("VU/8")(a,o,!1,function(t){i("hx+5"),i("7Hn6")},"data-v-3fae0cfb",null);s.default=r.exports},"7Hn6":function(t,s){},"hx+5":function(t,s){}});