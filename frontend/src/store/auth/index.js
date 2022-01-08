import router from '../../router/index' // Vue router instance
import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'

export default {
  namespaced: true,

  state: {
    user: null,
  },
  getters: {
    user(state) {
      return state.user
    },
  },
  mutations: {
    SET_USER(state, value) {
      state.user = value
      localStorage.setItem('user', JSON.stringify(value))
      axios.defaults.headers.common['Authorization'] = `Bearer ${value.token}`;
    },
  },
  actions: {
    async login({ commit, state, dispatch }, data) {
      await axios.post('/login', data).then(response => {
        commit('SET_USER', response.data.data);

        this._vm.$toast({
          component: ToastificationContent,
          props: {
            title: response.data.message,
            icon: 'EditIcon',
            variant: 'success',
          },
        })
        router.push({ name: 'dashboard' })
      }).catch(e => {
        console.log(e.response.data.message);
        this._vm.$toast({
          component: ToastificationContent,
          props: {
            title: e.response.data.message,
            icon: 'EditIcon',
            variant: 'danger',
          },
        })
      })
    },
    async checkToken({ commit, state }) {
      const user = JSON.parse(localStorage.getItem('user'))
      if(user) {
        commit('SET_USER', user);
        await axios.get('/me').then(async response => {
          if(router.history._startLocation !== '/dashboard')
            await router.push({ name: 'dashboard' })
        }).catch(async e => {
          if(router.history._startLocation !== '/')
            await router.push({ name: 'login '})
        });
      } else if(router.history._startLocation !== '/')
        await router.push({ name: 'login '})
    },
    async logout({ commit }) {
      await axios.get('/logout').then(async response => {
        this._vm.$toast({
          component: ToastificationContent,
          props: {
            title: response.data.message,
            icon: 'EditIcon',
            variant: 'success',
          },
        })
        router.push({ name: 'login' })
      })
    },
  },
}
