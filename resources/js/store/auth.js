import { OK, CREATED, UNPROCESSABLE_ENTITY } from '../util'

const state = {
  user: null,
  apiStatus: null,
  loginErrorMessages: null,
  registerErrorMessages: null,
}

const getters = {
  check: state => !! state.user,
  username: state => state.user ? state.user.name : ''
}

const mutations = {
  setUser(state, user) {
    state.user = user
  },
  setApiStatus(state, status) {
    state.apiStatus = status
  },
  setLoginErrorMessages(state, messages) {
    state.loginErrorMessages = messages
  },
  setRegisterErrorMessages(state, messages) {
    state.registerErrorMessages = messages
  },
}

const actions = {
  // 会員登録
  async register(context, data) {
    context.commit('setApiStatus', null)
    const response = await axios.post('/api/register', data)
    console.log(response)
    
    if(response.status === CREATED) {
      context.commit('setApiStatus', true)
      context.commit('setUser', response.data)
      return
    }
    
    context.commit('setApiStatus', false)
    if(response.status === UNPROCESSABLE_ENTITY) {
      context.commit('setRegisterErrorMessages', response.data.errors)
    } else {
      context.commit('error/setCode', response.status, { root: true })
    }

  },
  // ログイン
  async login(context, data) {
    context.commit('setApiStatus', null)
    const response = await axios.post('/api/login', data)
    console.log(response)
    
    if(response.status === OK) {
      context.commit('setApiStatus', true)
      context.commit('setUser', response.data)
      return false
    }

    context.commit('setApiStatus', false)
    if(response.status === UNPROCESSABLE_ENTITY) {
      context.commit('setLoginErrorMessages', response.data.errors)
    } else {
      context.commit('error/setCode', response.status, { root: true })
    }
  },
  // ログアウト
  async logout(context) {
    context.commit('setApiStatus', null)
    const response = await axios.post('/api/logout')
    console.log(response)
    
    if(response.status === OK) {
      context.commit('setApiStatus', true)
      context.commit('setUser', null)
      return false
    }
    
    context.commit('setApiStatus', false)
    context.commit('error/setCode', response.status, { root: true })
  },
  // ログインユーザー
  async currentUser(context) {
    context.commit('setApiStatus', null)
    const response = await axios.get('/api/user')
    console.log(response)
    const user = response.data || null
    
    if(response.status === OK) {
      context.commit('setApiStatus', true)
      context.commit('setUser', user)
      return false
    }
    
    context.commit('setApiStatus', false)
    context.commit('error/setCode', response.status, { root: true })
  }
}

export default {
  namespaced: true,
  state,
  getters,
  mutations, 
  actions
}