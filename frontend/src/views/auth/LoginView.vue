<template>
  <div class="blue lighten-5" style="min-height: 100vh;">
    <v-container>
      <v-row class="align-center justify-center d-flex" style="min-height: 100vh;">
        <v-col cols="12" sm="10">
          <v-card class="elevation-6 my-10 py-10 mx-3" shaped>
            <v-row>
              <v-col cols="12" md="6" class="align-center d-flex">
                <v-card-text>
                  <h2 class="text-center">Prijava</h2>
                  <h5 class="text-center  grey--text ">Prijavite se putem GitHub ili korisnickog racuna</h5>
                  <v-row align="center" justify="center">
                    <v-col cols="12" sm="8">
                      <v-text-field v-model="email" label="Email" shaped outlined
                        prepend-inner-icon="mdi-email-fast-outline" class="mt-4"></v-text-field>
                      <v-text-field v-model="password" label="Lozinka" shaped outlined class="mt-n3"
                        prepend-inner-icon="mdi-key-chain-variant" autocomplete="false" type="password" />
                      <div class="mt-n4 mb-1 d-flex justify-space-between">
                        <v-checkbox label="Zapamti me" class="ma-0 pa-0"></v-checkbox>
                      </div>
                      <v-btn color="primary" dark block class="rounded-xl mt-n3 text-none" @click="handleLogin()" :loading="loading">
                        <v-icon left>
                          mdi-login
                        </v-icon>
                        Prijavi se
                      </v-btn>
                      <v-btn color="primary" dark block outlined class="mt-3 rounded-xl text-none" @click="redirectToGitHubLogin">
                        <v-icon left>
                          mdi-github
                        </v-icon>
                        Github prijava
                      </v-btn>
                      <div class="d-flex align-center mt-5">
                        <div style="height: 1px; background-color: rgb(22, 31, 148); width: 48%; margin-left: 10px;">
                        </div>
                        <span class="mx-2">ili</span>
                        <div style="height: 1px; background-color: rgb(22, 31, 148); width: 48%;  margin-right: 10px;">
                        </div>
                      </div>
                      <v-btn color="primary" dark block outlined class="mt-5 rounded-xl text-none"
                        to="/register">
                        <v-icon left>
                          mdi-account-plus-outline
                        </v-icon>
                        Registriraj se
                      </v-btn>
                    </v-col>
                  </v-row>
                </v-card-text>
                <v-divider vertical></v-divider>
              </v-col>
              <v-col cols="12" md="6" class="align-center d-flex flex-column">
                <v-alert dense outlined text type="error" class="mx-4" v-if="errorMessage && $vuetify.breakpoint.xsOnly">
                  {{ errorMessage }}
                </v-alert>
                <v-img src="../../assets/images/login.png" class="my-8" contain></v-img>
                <v-alert dense outlined text type="error" class="mx-4" v-if="errorMessage && $vuetify.breakpoint.smAndUp">
                  {{ errorMessage }}
                </v-alert>
              </v-col>
            </v-row>
          </v-card>
        </v-col>
      </v-row>
    </v-container>
  </div>
</template>
  
<script>
import { useAuthStore } from '../../../store/auth.js';

export default {
  name: 'LoginView',
  data() {
    return {
      email: '',
      password: '',
      errorMessage: '',
      loading: false,
    };
  },
  methods: {
    redirectToGitHubLogin() {
      window.location.href = 'http://127.0.0.1:8000/api/login/github';
    },
    async handleLogin() {
      this.loading = true
      try {
        await useAuthStore().login(this.email, this.password);
        await useAuthStore().getUser();
        this.loading = false
        this.$router.push('/');
      } catch (error) {
        this.errorMessage = error.response.data.message;
        setTimeout(() => {
          this.errorMessage = null
        }, 3000);
        this.loading = false
      }
    },
  },
};
</script>
  