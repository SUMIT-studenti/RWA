<template>
  <v-img src="../assets/background.jpg">
    <div class="text-center px-5 py-4">
      <h1 class="primary--text">Korisnički profil</h1>
      <div v-if="user" class="text-center">
        <div style="max-width: 900px; margin: 20px auto;">
          <v-avatar size="140px" class=""
            style="background-color: transparent; border: 2px solid #084776; border-radius: 150px;">
            <v-row justify="center" align="center" style="height: 100%">
              <v-col cols="12" class="text-center">
                <div class="text-h4 font-weight-medium" style="color: #084776">
                  {{ user.first_name.charAt(0) + user.last_name.charAt(0) }}
                </div>
              </v-col>
            </v-row>
          </v-avatar>
          <div style="background-color: #084776;" class="pa-4 white--text mt-4 rounded-lg">
            {{ user.first_name + " " + user.last_name }}
          </div>
          <v-alert dense outlined text type="info" class=" mt-3" v-if="response_message">
            {{ response_message }}
          </v-alert>
          <v-row class="mt-3">
            <v-col cols="12" sm="6" class="mb-n9">
              <div class="text-left d-flex mb-1 ml-1">
                <v-icon color="primary">
                  mdi-account
                </v-icon>
                <div class="primary--text pl-1">Ime:</div>
              </div>
              <v-text-field v-model="form.first_name" outlined :disabled="disabled"></v-text-field>
            </v-col>
            <v-col cols="12" sm="6" class="mb-n9">
              <div class="text-left d-flex mb-1 ml-1">
                <v-icon color="primary">
                  mdi-account
                </v-icon>
                <div class="primary--text pl-1">Prezime:</div>
              </div>
              <v-text-field v-model="form.last_name" outlined :disabled="disabled"></v-text-field>
            </v-col>
            <v-col cols="12" sm="6" class="mb-n9">
              <div class="text-left d-flex mb-1 ml-1">
                <v-icon color="primary">
                  mdi-email
                </v-icon>
                <div class="primary--text pl-1">Email:</div>
              </div>
              <v-text-field v-model="form.email" outlined :disabled="disabled"></v-text-field>
            </v-col>
            <v-col cols="12" sm="6" class="mb-n9">
              <div class="text-left d-flex mb-1 ml-1">
                <v-icon color="primary">
                  mdi-phone
                </v-icon>
                <div class="primary--text pl-1">Broj mobitela:</div>
              </div>
              <v-text-field v-model="form.phone_number" :placeholder="user.phone_number === null ? '---' : ''" outlined
                :disabled="disabled"></v-text-field>
            </v-col>
            <v-col cols="12" class="d-flex justify-start align-center flex-wrap">
              <v-btn @click="disabled = !disabled" class="rounded-xl mr-2 mb-2 mb-sm-0" color="primary"
                style="text-transform: none;">
                <v-icon left small dark>mdi-pencil</v-icon>
                Uredi podatke
              </v-btn>
              <v-btn v-if="disabled === false" @click="updateUser" class="rounded-xl" color="primary" outlined
                style="text-transform: none;" :loading="loading">
                <v-icon left small dark>mdi mdi-content-save-edit</v-icon>
                Spremi promjene
              </v-btn>
            </v-col>
          </v-row>
          
        </div>
      </div>
      <div v-if="!user">
        <h1>Not logged in</h1>
      </div>
    </div>
  </v-img>
</template>
  
<script>
import { useAuthStore } from '../../store/auth'

export default {
  name: 'ProfileView',
  data() {
    return {
      disabled: true,
      form: null,
      response_message: '',
      loading: false,
    };
  },
  methods: {
    async updateUser() {
      this.loading = true
      await this.axios.put("/auth/user", this.form)
        .then((response) => {
          console.log(response)
          useAuthStore().getUser();
          this.response_message = "Uspješno spremljene promjene"
        })
        .catch((error) => {
          console.log(error)
          this.response_message = error.response.data.message
        });
        setTimeout(() => {
          this.response_message = null
        }, 3000);
      this.disabled = !this.disabled
      this.loading = false
    },
  },
  computed: {
    user() {
      return useAuthStore().user;
    },
  },
  mounted() {
    useAuthStore().getUser();
    this.form = this.user
    if(!this.user){
      this.$router.push('/')
    }
  },
};
</script>
  
<style>
.v-application .body-1 {
  font-family: "Poppins" !important;
}
</style>
  