import { login } from '@/api/user'
export default {
  state: {
    access: '',
    token: sessionStorage.getItem('USER_TOKEN') || '',
    hasGetInfo: false
  },
  mutations: {
    SET_ACCESS (state, access) {
      state.access = access
    },
    SET_TOKEN (state, token) {
      state.token = token
      sessionStorage.setItem('USER_TOKEN', token)
    }
  },
  actions: {
    handleLogin ({ commit }, {userName, password}) {
      userName = userName.trim()
      return new Promise((resolve, reject) => {
        login({
          userName,
          password
        }).then(token => {
          commit('SET_TOKEN', token)
          resolve(token)
        }).catch(e => {
          reject(e)
        })
      })
    }
  }
}
