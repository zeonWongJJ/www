webpackJsonp([38],{ASqH:function(t,i){},UMBv:function(t,i){},WIVl:function(t,i,e){"use strict";Object.defineProperty(i,"__esModule",{value:!0});var s=e("P9l9"),o=e("UtaA"),r=e("M6W8"),n=e("qfJ3"),a={components:{headRi:o.a,orderState:r.a,renderAppointedRow:n.a},data:function(){return{canIreceipt:!1,rishow:!1,distri:!1,cancel_x:!1,isshow:!1,fgshow:!1,list_distri:[],uploadFileUrl:s.a.uploadFileUrl+"/",distri_num:[],orderState:"",indexs:"",order_sn:"",tabs:[{name:"全部",id:99},{name:"待付款",id:0},{name:"待确认",id:1},{name:"待服务",id:1},{name:"服务中",id:2}],num:0,numlist:0,numlist2:0,inishow:!1,ids:"",list_com:[],unapplication:[],fglist:[{name:"支付宝",imgs:e("K0f0")},{name:"微信",imgs:e("K0f0")},{name:"银行",imgs:e("K0f0")}],token:"",item_id:"",order_sn_ok:"",cancel_reason:"",user_id:this.$store.state.user_id}},created:function(){},mounted:function(){this.canIdo(),this.tab(this.num),this.token=this.$store.state.token},methods:{canIdo:function(){var t=this;this.$fetch("can_i_use",{node_key:"Store.changeOrderStatus.receipt"}).then(function(i){t.canIreceipt=!0})},replaceStyle:function(t){return t.replace(/<[^<>]+>/g,"")},orishow:function(){this.rishow=!1},onClickRight:function(){this.rishow=!this.rishow},distri_list:function(){var t=this;this.$fetch("staff_get_allocation",{},this.order_sn_ok).then(function(i){i.forEach(function(i,e){i.staff_assigned&&t.distri_num.push(i.id)}),t.list_distri=i})},f_distri:function(t,i){this.order_sn_ok=t.order_detail.order_sn,this.list_distri=[],this.distri_num=[],this.distri_list(),this.distri=!0},xg_distri:function(t,i){this.distri=!0,this.order_sn_ok=t.order_detail.order_sn},o_distri:function(){this.distri=!1},tab_distri:function(t,i){var e=this.distri_num.indexOf(t.id);e>-1?this.distri_num.splice(e,1):this.distri_num.push(t.id)},o_distri_ok:function(){var t=this;this.$fetch("appointed_order",{appointed_uid:this.distri_num},this.order_sn_ok).then(function(i){t.distri=!1,t.tab(t.num)})},o_cancel:function(t,i){this.cancel_reason="",this.order_sn_ok=t.order_detail.order_sn,this.cancel_x=!0},spilits_cancel:function(){var t=this,i=this,e={};e.cancel_reason=i.cancel_reason,i.$fetch("order_cancel",e,i.order_sn_ok).then(function(e){i.cancel_x=!1,i.cancel_reason="",t.tab(t.num)}).catch(function(t){i.cancel_x=!1})},dad:function(t,i){this.ids=t.id,1==t.id?1==this.inishow?this.inishow=!1:this.inishow=!this.inishow:3==t.id?1==this.inishow?this.inishow=!1:this.inishow=!this.inishow:this.inishow=!1},sureOrder:function(t,i){var e=this;this.$dialog.alert({title:"提示",message:"确认要接单吗",showCancelButton:!0}).then(function(){e.$fetch("order_change_status_receipt",{},t.order_detail.order_sn).then(function(t){e.tab(e.num)})}).catch(function(){})},startServer:function(t,i){var e=this,s=this;s.$dialog.alert({title:"提示",message:"确定要开始服务吗",showCancelButton:!0}).then(function(){var i=t.order_detail.order_sn+("-"+t.order_detail.order_sub_sn||"");s.$fetch("order_change_status_begin",{},i).then(function(t){e.tab(e.num)})}).catch(function(){})},completed:function(t,i){var e=this,s=this;s.$dialog.alert({title:"提示",message:"确认要完成成订单吗",showCancelButton:!0}).then(function(){var i=t.order_detail.order_sn+("-"+t.order_detail.order_sub_sn||"");s.$fetch("order_change_status_completed",{},i).then(function(t){e.tab(e.num)})}).catch(function(){})},onClickLeft:function(){this.$router.back(-1),this.$store.commit("store_show",!1)},detailst:function(t){this.$router.push({path:"/orderDetails_x",query:{its:t,usertype:3}})},tab:function(t){var i=this,e={rows:500};i.num=t,1==t?(e.condition={order_state:0,"order_type <> ":3},i.$fetch("store_order_list",e).then(function(t){i.list_com=t})):2==t?(e.condition={order_state:1,"order_type <> ":3},i.$fetch("store_order_list",e).then(function(t){i.list_com=t})):3==t?(e.condition={order_state:2,"order_type <> ":3},i.$fetch("store_order_list",e).then(function(t){i.list_com=t})):4==t?(e.condition={order_state:3,"order_type <> ":3},i.$fetch("store_order_list",e).then(function(t){i.list_com=t})):i.$fetch("store_order_list").then(function(t){i.list_com=t})},menvaluate:function(t,i){this.$router.push({path:"/menvaluate",query:{its:t}})},shows:function(t,i){this.isshow=!0,this.indexs=i,this.order_sn=t.order_detail.order_sn},spilits:function(){var t=this,i=this;s.a.store_delete_order,i.order_sn;i.$fetch("store_delete_order",{},i.order_sn).then(function(e){i.isshow=!1,i.$toast("删除成功"),i.list_com.splice(i.indexs,1),t.tab(t.num)})},xbut_cancel:function(){this.cancel_x=!1},xbut_cancel_x:function(){},xbut:function(){this.isshow=!1},fgbut:function(){this.fgshow=!1},fgxuz:function(t,i){this.num=i},getTime:function(t){var i=new Date(t);return i?i.getFullYear()+"-"+this.add0(i.getMonth()+1)+"-"+this.add0(i.getDate())+" "+this.add0(i.getHours())+":"+this.add0(i.getMinutes()):""},add0:function(t){return(t=Number(t))<10&&(t="0"+t),t},getComment:function(t){this.$router.push({path:"/myeval",query:{order_comment_id:t}})}}},_={render:function(){var t=this,i=t.$createElement,s=t._self._c||i;return s("div",{staticClass:"find"},[s("div",{staticClass:"find_top"},[s("van-nav-bar",{attrs:{title:"店铺的订单","left-arrow":""},on:{"click-left":t.onClickLeft}})],1),t._v(" "),s("div",{directives:[{name:"show",rawName:"v-show",value:t.rishow,expression:"rishow"}],staticStyle:{position:"fixed","z-index":"9999",top:"0",right:"0",left:"0",bottom:"0",background:"rgba(0,0,0,0)"},on:{click:function(i){i.stopPropagation(),t.orishow()}}},[s("div",{staticStyle:{position:"absolute","z-index":"9999",top:".45rem",right:"0",width:"1rem",background:"rgba(0,0,0,.2)"}},[s("head-ri")],1)]),t._v(" "),s("ul",{staticClass:"top_nav_ul"},t._l(t.tabs,function(i,e){return s("li",{class:{li_style:e==t.num},on:{click:function(i){t.tab(e)}}},[s("div",{staticClass:"top_nav_img",on:{click:function(s){t.dad(i,0==e||2==e)}}},[t._v("\n\t\t\t\t\t"+t._s(i.name)+"\n\t\t\t\t")])])})),t._v(" "),s("div",{staticClass:"top_nav"},[s("div",{staticClass:"commodity"},[s("ul",t._l(t.list_com,function(i,o){return s("li",{staticClass:"list_coms",class:"state_"+i.order_status,on:{click:function(e){t.detailst(i.order_detail.order_sn)}}},[s("div",{staticClass:"com_tit"},[s("div",{staticClass:"com_tit_img"},[s("div",[t._v("\n\t\t\t\t\t\t\t\t\t订单编号："+t._s(i.order_detail.order_sn)+"\n\t\t\t\t\t\t\t\t")])]),t._v(" "),s("order-state",{attrs:{order_info:i,is_store_page:!0}})],1),t._v(" "),s("div",{staticClass:"com_com"},[s("div",{staticStyle:{position:"relative"}},[i.order_detail.is_sys_order?s("div",{staticClass:"sys",staticStyle:{position:"absolute",top:"0",right:"0",background:"#f00",color:"#fff","font-size":".12rem"}},[t._v("周期")]):t._e(),t._v(" "),""==i.order_detail.order_pic?s("img",{attrs:{src:e("y8yI")}}):s("img",{attrs:{src:t.uploadFileUrl+i.order_detail.order_pic[0]}})]),t._v(" "),s("div",{staticClass:"com_com_x"},[s("div",{staticClass:"com_com_x_tit",staticStyle:{"font-weight":"bold"}},[t._v("\n\t\t\t\t\t\t\t\t\t"+t._s(i.order_detail.order_name)+"\n\t\t\t\t\t\t\t\t")]),t._v(" "),s("div",{staticClass:"com_com_x_ov",domProps:{innerHTML:t._s(t.replaceStyle(i.order_detail.order_info))}}),t._v(" "),s("div",{staticClass:"com_com_x_ov",staticStyle:{width:"2.6rem",overflow:"hidden","text-overflow":"ellipsis","white-space":"nowrap"}},[t._v("\n\t\t\t\t\t\t\t\t\t"+t._s(i.server_info.address_name)),"无门牌号"!=i.server_info.house_number?s("span",[t._v(t._s(i.server_info.house_number))]):t._e()]),t._v(" "),s("div",{staticClass:"com_com_x_score2"},[s("div",[t._v("\n\t\t\t\t\t\t\t\t\t\t￥"+t._s(i.payment.order_amount)+"\n\t\t\t\t\t\t\t\t\t")])])])]),t._v(" "),i.server_info.appointed_row?s("div",{staticClass:"director"},[s("div",{staticClass:"right"},[s("div",[t._v("下单时间:"+t._s(i.time_record.pay_time))]),t._v(" "),s("div",[t._v("服务时间:"+t._s(i.time_record.contact_appointment_at))])]),t._v(" "),i.time_record.next_order_at?s("div",{staticStyle:{"margin-left":".1rem"}},[t._v("下期服务时间:"+t._s(i.time_record.next_order_at))]):t._e(),t._v(" "),s("div",{staticStyle:{display:"flex","border-bottom":"0.01rem solid #f8f8f8",padding:"0.08rem .1rem"}},[s("div",{staticClass:"left"},t._l(i.server_info.appointed_row,function(i,e){return s("span",{staticStyle:{display:"flex"}},[s("span",{staticStyle:{width:".3rem",height:"0.3rem","line-height":".3rem","border-radius":"50%",overflow:"hidden","align-items":"center","flex-wrap":"wrap"}},[s("img",{staticStyle:{width:".3rem",height:".3rem"},attrs:{src:t.uploadFileUrl+i.user_pic,alt:""}})]),t._v(" "),s("span",{class:{i_item:0==e},staticStyle:{height:"0.3rem","line-height":".3rem","margin-left":"0.05rem"}},[t._v(t._s(i.staff_name))])])}))])]):t._e(),t._v(" "),s("div",{staticClass:"but_coms"},[0==i.order_detail.order_is_peddling&&1==i.order_detail.order_state&&0==i.server_info.appointed_uid?s("div",{staticClass:"but_coms_but3",on:{click:function(e){e.stopPropagation(),t.sureOrder(i,o)}}},[t._v("\n\t\t\t\t\t\t\t\t确认接单\n\t\t\t\t\t\t\t")]):t._e(),t._v(" "),4==i.order_detail.order_state||5==i.order_detail.order_state?s("div",{staticClass:"but_coms_but1",on:{click:function(e){e.stopPropagation(),t.shows(i,o)}}},[t._v("\n\t\t\t\t\t\t\t\t删除订单\n\t\t\t\t\t\t\t")]):t._e(),t._v(" "),t.canIreceipt&&0==i.order_detail.order_is_peddling&&2==i.order_detail.order_state&&i.server_info.appointed_uid==t.user_id?s("div",{staticClass:"but_coms_but2",on:{click:function(e){e.stopPropagation(),t.startServer(i,o)}}},[t._v("\n\t\t\t\t\t\t\t\t开始服务\n\t\t\t\t\t\t\t")]):t._e(),t._v(" "),0==i.order_detail.order_rate&&3==i.order_detail.order_state?s("div",{staticClass:"but_coms_but2",on:{click:function(e){e.stopPropagation(),t.completed(i,o)}}},[t._v("\n\t\t\t\t\t\t\t\t已完成\n\t\t\t\t\t\t\t")]):t._e(),t._v(" "),0==i.order_detail.order_is_peddling&&i.server_info.appointed_row.length>0&&0==i.order_detail.order_rate&&0==i.time_record.order_sm_at?s("div",{staticClass:"but_coms_but2",on:{click:function(e){e.stopPropagation(),t.f_distri(i,o)}}},[t._v("\n\t\t\t\t\t\t\t\t修改分配\n\t\t\t\t\t\t\t")]):t._e(),t._v(" "),0==i.order_detail.order_is_peddling&&0==i.server_info.appointed_row.length&&-1!=i.order_detail.order_rate&&2==i.order_detail.order_state?s("div",{staticClass:"but_coms_but2",on:{click:function(e){e.stopPropagation(),t.f_distri(i,o)}}},[t._v("\n\t\t\t\t\t\t\t\t分配人员\n\t\t\t\t\t\t\t")]):t._e(),t._v(" "),0==i.order_detail.order_is_peddling&&0==i.order_detail.order_state||1==i.order_detail.order_state||2==i.order_detail.order_state?s("div",{staticClass:"but_coms_but1",on:{click:function(e){e.stopPropagation(),t.o_cancel(i,o)}}},[t._v("\n\t\t\t\t\t\t\t\t取消订单\n\t\t\t\t\t\t\t")]):t._e(),t._v(" "),0==i.order_detail.order_is_peddling&&1==i.order_detail.order_rate&&0!=i.order_detail.order_comment_id?s("div",{staticClass:"but_coms_but2",on:{click:function(e){e.stopPropagation(),t.getComment(i.order_detail.order_comment_id)}}},[t._v("查看评价")]):t._e()])])}))])]),t._v(" "),s("div",{directives:[{name:"show",rawName:"v-show",value:t.distri,expression:"distri"}],staticClass:"distri_box",on:{click:function(i){return i.stopPropagation(),t.o_distri(i)}}},[s("transition",{attrs:{name:"slide-fade"}},[s("div",{staticClass:"distri_biv"},[s("div",{staticClass:"distri_biv_div1"},[s("div",{staticStyle:{color:"#B2B2B2","font-size":".12rem"},on:{click:function(i){return i.stopPropagation(),t.o_distri(i)}}},[t._v("\n\t\t\t\t\t\t\t返回\n\t\t\t\t\t\t")]),t._v(" "),s("div",{staticStyle:{"font-size":".14rem"}},[t._v("\n\t\t\t\t\t\t\t可分配人员\n\t\t\t\t\t\t")]),t._v(" "),s("div",{staticStyle:{color:"#18B4ED","font-size":".12rem"}},[s("span",{on:{click:function(i){return i.stopPropagation(),t.o_distri_ok(i)}}},[t._v("确定")])])]),t._v(" "),s("div",{staticClass:"distri_biv_div2"},[s("ul",[t.list_distri.length<0?s("li",[t._v("\n\t\t\t\t\t\t\t\t暂无人员分配\n\t\t\t\t\t\t\t")]):t._e(),t._v(" "),t._l(t.list_distri,function(i,e){return i.can_assign?s("li",{directives:[{name:"else",rawName:"v-else"}]},[s("span",{class:{distri_biv_div_span:t.distri_num.indexOf(i.id)>-1},on:{click:function(s){s.stopPropagation(),t.tab_distri(i,e)}}},[t._v(t._s(i.staff_name))])]):t._e()})],2)])])])],1),t._v(" "),s("div",{directives:[{name:"show",rawName:"v-show",value:t.cancel_x,expression:"cancel_x"}],staticClass:"po_box",on:{click:function(i){return i.stopPropagation(),t.xbut_cancel_x(i)}}},[s("div",{staticClass:"po_box_div2"},[s("div",{staticClass:"po_box_div_tit"},[t._v("提示")]),t._v(" "),s("div",{staticStyle:{height:"1rem","border-bottom":"0.01rem solid #eee"}},[s("div",{staticStyle:{margin:".2rem .2rem 0 .2rem"}},[t._v("\n\t\t\t\t\t\t确定要取消此订单？\n\t\t\t\t\t")]),t._v(" "),s("div",{staticStyle:{margin:".2rem"}},[t._v("\n\t\t\t\t\t\t取消原因 : "),s("input",{directives:[{name:"model",rawName:"v-model",value:t.cancel_reason,expression:"cancel_reason"}],attrs:{type:"text"},domProps:{value:t.cancel_reason},on:{input:function(i){i.target.composing||(t.cancel_reason=i.target.value)}}})])]),t._v(" "),s("div",{staticClass:"po_box_but"},[s("div",{on:{click:function(i){return i.stopPropagation(),t.xbut_cancel(i)}}},[t._v("取消")]),t._v(" "),s("div",{on:{click:function(i){return i.stopPropagation(),t.spilits_cancel(i)}}},[t._v("确认")])])])]),t._v(" "),s("div",{directives:[{name:"show",rawName:"v-show",value:t.isshow,expression:"isshow"}],staticClass:"po_box",on:{click:function(i){return i.stopPropagation(),t.xbut(i)}}},[s("div",{staticClass:"po_box_div"},[s("div",{staticClass:"po_box_div_tit"},[t._v("提示")]),t._v(" "),s("div",{staticClass:"po_box_div_com"},[t._v("\n\t\t\t\t\t确定要删除此订单？\n\t\t\t\t")]),t._v(" "),s("div",{staticClass:"po_box_but"},[s("div",{on:{click:function(i){return i.stopPropagation(),t.xbut(i)}}},[t._v("取消")]),t._v(" "),s("div",{on:{click:function(i){return i.stopPropagation(),t.spilits(i)}}},[t._v("确认")])])])])])},staticRenderFns:[]};var d=e("VU/8")(a,_,!1,function(t){e("ASqH"),e("UMBv")},"data-v-2e84af93",null);i.default=d.exports}});