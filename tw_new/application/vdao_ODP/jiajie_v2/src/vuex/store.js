import Vue from 'vue'
import Vuex from 'vuex'


Vue.use(Vuex)

const store = new Vuex.Store({
  // 定义状态
  	state: { // 状态
  		token:  localStorage.getItem('token'), // 数据持久化
      title: '',
      user_id:  localStorage.getItem('user_id'),
      lat: sessionStorage.getItem('lat'),
      lng: sessionStorage.getItem('lng'),
      path:{},
  	},
 	// actions : api,
	mutations : {
		login : (state, data) => {
		    localStorage.token = data;
		    document.cookie = data;
		    state.token = data;
		},
		logout : (state) => {
		    localStorage.removeItem('token');
		    state.token = null;
		},
		title : (state, data) => {
		    state.title = data;
		},
		goodsListPage : (state, page ) => {
			state.goodsListPage = page;
		},
		goodsAttrPage : (state , page ) => {
			state.goodsAttrPage = page;
		},
		userPhone : (state , data ) => {
			state.userPhone = data;
		},
		store_status : (state , data ) => {
			state.store_status = data;
		},
		path : (state , data ) => {
			state.path = data;
		},
		lng : (state , data ) => {
			sessionStorage.setItem('lng',data);
			state.lng = data;
		},
		lat : (state , data ) => {
			sessionStorage.setItem('lat',data);
			state.lat = data;
		},
		user_id : (state , data ) => {
			localStorage.user_id = data;
			state.user_id = data;
		},
	},
  getters: {
    token: state => {
      return state.token
    },
    	user_id : state  => {
			 return  state.user_id
		},
  }
})

export default store
