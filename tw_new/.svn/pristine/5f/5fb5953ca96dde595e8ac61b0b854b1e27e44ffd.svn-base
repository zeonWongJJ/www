import Vue from 'vue'
import Vuex from 'vuex'
//import UserModule from './modules/usermodule'
//import pageModule from './modules/page'


Vue.use(Vuex)

const store = new Vuex.Store({
	// 定义模块
//	modules : {
//		user : UserModule,
//		page : pageModule
//	},
  // 定义状态
  	state: {
  		token:null,
  		department_name:'',
  		real_name:'',
        title: '',
        member_id:'',
        task_id:'',//任务id
        department:'',//部门，任务详情里保存。。当前评论部门
        pageNums : 10,		//分页条数
        goodsListPage : 1,	//商品列表 页码
        goodsAttrPage : 1,	// 商品属性 页码
       
  	},
// 	 actions : api,
	mutations : {
		task_id:(state, task_id)=>{
			state.task_id = task_id;
			localStorage.task_id = task_id;
			    
		},
		department:(state, department)=>{
			state.department = department;
			localStorage.department = department;
			  
		},
		real_name:(state, real_name)=>{
			state.real_name = real_name;
			localStorage.real_name = real_name;
			  
		},
		department_name: (state, department_id) => {
		  	state.department_id = department_id;
			 localStorage.department_id = department_id;
		},
		member_id: (state, member_id) => {
		  	state.member_id = member_id;
			 localStorage.member_id = member_id;
		},
//		department_del: (state,) => {
//		  	   state.department_name = '';
//		    localStorage.removeItem('department_name') 
//		},
		set_token: (state, data) => {
  			localStorage.token = data;
		    document.cookie = data;
		    state.token = data;
		},
		del_token : (state) => {		    
		    state.token = null;
		    localStorage.removeItem('token') 
		},
		title : (state, data) => {
		    state.title = data;
		},
		goodsListPage : (state, page ) => {
			state.goodsListPage = page;
		},
		goodsAttrPage : (state , page ) => {
			state.goodsAttrPage = page;
		}
},


})


export default store