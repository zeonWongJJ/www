import Vue from 'vue'
import Vuex from 'vuex'


Vue.use(Vuex)

const store = new Vuex.Store({
  // 定义状态
  	state: { // 状态
  		token:  localStorage.getItem('token'), // 数据持久化
      username: localStorage.getItem('username'),
      title: '',
      user_id:  localStorage.getItem('user_id'),
      lat: sessionStorage.getItem('lat'),
      lng: sessionStorage.getItem('lng'),
      path:{},
  	},
 	// actions : api,
	mutations : {
    login: (state, data) => {
      localStorage.token = data.token;
      document.cookie = data.token;
      state.token = data.token;
      // localStorage.username = data.fullname;
      // state.username = data.fullname;
      localStorage.user_id = data.member_id;
      state.user_id = data.member_id

		},
    token: (state, data) => {
      localStorage.token = data;
      document.cookie = data;
      state.token = data;
    },
		logout: (state) => {
		    localStorage.removeItem('token');
		    state.token = null;
		},
    username: (state,data) => {
      localStorage.username = data;
      state.username = data;
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
