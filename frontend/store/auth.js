import { defineStore } from 'pinia';
import axios from 'axios';

export const useAuthStore = defineStore('auth', {
  state: () => ({
    authUser: null,
    authToken: null
  }),

  getters: {
    user: (state) => state.authUser,
    token: (state) => state.authToken,
  },

  actions: {
    async getUser() {
      if(localStorage.getItem('token')){
        let token = localStorage.getItem('token')
        axios.defaults.headers.common['Authorization']='Bearer ' + token;
        const response = await axios.get('auth/user');
        this.authUser = response.data;
      }
    },
    async login(email, password){
      let response = await axios.post('auth/login', {
        email: email,
        password: password
      })
      axios.defaults.headers.common['Authorization']='Bearer ' + response.data.access_token;
      localStorage.setItem('token', response.data.access_token);
      this.authToken = response.data.access_token
    },
    async logout(){
      await axios.get('auth/logout');
      localStorage.removeItem('token');
      this.authUser = null;
      this.authToken = null;
    },
    async register(data){
      let response = await axios.post('auth/register', data);
      localStorage.setItem('token', response.data.access_token);
      axios.defaults.headers.common['Authorization']='Bearer ' + response.data.access_token;
      this.authUser = response.data;
    }
  }
});
