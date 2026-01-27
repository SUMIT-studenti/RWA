<template>
  <div>
    <v-app-bar app color="white" dark height="110" flat>
      <v-app-bar-title class="ml-5">
        <router-link to="/">
          <v-img contain src="../assets/logo.png" height="80" transition="scale-transition" to="/"/>
        </router-link>
      </v-app-bar-title>
      <v-spacer></v-spacer>

      <v-toolbar-items id="nav" class="hidden-sm-and-down">
        <div>
          <router-link to="/">Naslovnica</router-link>
          <router-link to="/projects">Projekti</router-link>
          <router-link to="/students">Studenti</router-link>
        </div>
      </v-toolbar-items>

      <v-spacer></v-spacer>
      <v-btn color="primary" rounded class="text-capitalize hidden-sm-and-down" height="45" width="auto" to="/login"
        v-if="!user">Prijavi se</v-btn>
      <!-- <v-btn color="primary" rounded class="text-capitalize hidden-sm-and-down" height="45" width="auto" 
        v-if="!user">Prijavi se</v-btn> -->
      <div class=" hidden-sm-and-down" v-if="user">
        <v-menu offset-y rounded="lg">
          <template v-slot:activator="{ on, attrs }">
            <div v-bind="attrs" v-on="on" class="d-flex align-center justify-center">
              <v-avatar size="40px"
                style="background-color: transparent; border: 2px solid #084776; border-radius: 50px;">
                <v-row justify="center" >
                  <v-col cols="12" class="text-center">
                    <div class="font-weight-medium" style="color: #084776">
                      {{ user.first_name.charAt(0) + user.last_name.charAt(0) }}
                    </div>
                  </v-col>
                </v-row>
              </v-avatar>
              <p class="pl-2 mr-n3 secondary--text my-auto">{{ user.first_name }} {{ user.last_name }}
              </p>
              <v-btn fab color="grey darken-1" icon>
                <v-icon>
                  mdi-chevron-down
                </v-icon>
              </v-btn>
            </div>
          </template>
          <v-list>
            <v-list-item style="min-height: 35px;" to='/profile'>
              <v-icon class="pr-2" small>mdi mdi-account</v-icon>
              <v-list-item-title>Profil</v-list-item-title>
            </v-list-item>
            <v-list-item style="min-height: 35px;" to="/my_projects">
              <v-icon class="pr-2" small>mdi-file-document-multiple</v-icon>
              <v-list-item-title>Moji projekti</v-list-item-title>
            </v-list-item>
            <v-list-item style="min-height: 35px;"  to='/dashboard' v-if="user.is_admin">
              <v-icon class="pr-2" small>mdi-application-cog</v-icon>
              <v-list-item-title>Upravljaj projektima</v-list-item-title>
            </v-list-item>
            <v-list-item style="min-height: 35px;" @click="logout">
              <v-icon class="pr-2" small>mdi mdi-logout</v-icon>
              <v-list-item-title>Odjava</v-list-item-title>
            </v-list-item>
          </v-list>
        </v-menu>
      </div>

      <v-btn icon @click="drawer = !drawer" large class="mr-5">
        <v-app-bar-nav-icon color="primary" class="hidden-md-and-up"></v-app-bar-nav-icon>
      </v-btn>
    </v-app-bar>

    <v-navigation-drawer v-model="drawer" left app temporary>
      <v-list>
        <v-list-item style="background-color: #094776; margin-top: -9px" class="d-flex justify-center">
          <v-list-item-icon class="mx-auto">
            <img src="../assets/sum-white.png" height="55px" />
          </v-list-item-icon>
        </v-list-item>
      </v-list>

      <v-list nav>
        <v-list-item-group v-model="group" active-class="primary--text text--accent-1">
          <v-list-item to="/">
            <v-list-item-icon>
              <v-icon>mdi-home</v-icon>
            </v-list-item-icon>
            <v-list-item-title>Naslovnica</v-list-item-title>
          </v-list-item>

          <v-list-item to="/projects">
            <v-list-item-icon>
              <v-icon>mdi-file-document-multiple</v-icon>
            </v-list-item-icon>
            <v-list-item-title>Projekti</v-list-item-title>
          </v-list-item>

          <v-list-item to="/students">
            <v-list-item-icon>
              <v-icon>mdi mdi-account</v-icon>
            </v-list-item-icon>
            <v-list-item-title>Studenti</v-list-item-title>
          </v-list-item>

          <v-divider style="border: 1px solid rgb(192, 191, 191)" class="my-5"></v-divider>

          <v-list-item v-if="!user">
            <v-btn color="primary" rounded class="text-capitalize" height="40" width="auto" to="/login">Prijavi
              se</v-btn>
          </v-list-item>
        </v-list-item-group>
      </v-list>

      <v-menu offset-y rounded="lg" v-if="user">
        <template v-slot:activator="{ on, attrs }">
          <div v-bind="attrs" v-on="on" class="d-flex align-center justify-start ml-3 mt-n3">
            <v-avatar size="40px" style="background-color: transparent; border: 2px solid #084776; border-radius: 50px;">
              <v-row justify="center" align="top">
                <v-col cols="12" class="text-center">
                  <div class="font-weight-medium" style="color: #084776">
                    {{ user.first_name.charAt(0) + user.last_name.charAt(0) }}
                  </div>
                </v-col>
              </v-row>
            </v-avatar>
            <p class="pl-2 mr-n3 secondary--text my-auto">{{ user.first_name }} {{ user.last_name }}
            </p>
            <v-btn fab color="grey darken-1" icon>
              <v-icon>
                mdi-chevron-down
              </v-icon>
            </v-btn>
          </div>
        </template>
        <v-list>
          <v-list-item style="min-height: 35px;" to='/profile'>
            <v-icon class="pr-2" small>mdi mdi-account</v-icon>
            <v-list-item-title>Profil</v-list-item-title>
          </v-list-item>
          <v-list-item style="min-height: 35px;" to="my_projects">
            <v-icon class="pr-2" small>mdi-file-document-multiple</v-icon>
            <v-list-item-title>Moji projekti</v-list-item-title>
          </v-list-item>
          <v-list-item style="min-height: 35px;"  to='/dashboard' v-if="user.is_admin">
              <v-icon class="pr-2" small>mdi-application-cog</v-icon>
              <v-list-item-title>Upravljaj projektima</v-list-item-title>
            </v-list-item>
          <v-list-item style="min-height: 35px;" @click="logout">
            <v-icon class="pr-2" small>mdi mdi-logout</v-icon>
            <v-list-item-title>Odjava</v-list-item-title>
          </v-list-item>
        </v-list>
      </v-menu>
    </v-navigation-drawer>
  </div>
</template>

<script>
import { useAuthStore } from '../../store/auth'

export default {
  name: "App",

  data: () => ({
    drawer: false,
    group: null,
    items: [
      { title: 'Profil', icon: 'mdi mdi-account', to: '/profile' },
      { title: 'Moji projekti', icon: 'mdi-file-document-multiple' },
    ],
  }),

  methods: {
    logout: function () {
      this.$router.push('/')
      return useAuthStore().logout();
    },
  },

  computed: {
    user() {
      return useAuthStore().user;
    },
  },

  async mounted(){
    await useAuthStore().getUser();
  }
};
</script>

<style>
#app {
  font-family: "Poppins", sans-serif;
}

#nav {
  display: flex;
  align-items: center;
}

#nav a {
  font-weight: 500;
  color: #094776;
  text-decoration: none;
  margin-left: 15px;
}

#nav a.router-link-exact-active {
  background-color: #d8d8d8;
  border-radius: 30px;
  padding: 10px 20px 10px 20px;
}
</style>
