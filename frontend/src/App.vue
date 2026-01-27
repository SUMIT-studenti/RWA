<template>
  <v-app id="app">
    <NavBar v-if="$route.path != '/login' && $route.path != '/register'"></NavBar>
    <v-main>
      <v-snackbar v-model="snackbar" timeout="4000" :color="snackbarColor" top right class="mt-10">
        <v-icon class="mdi mdi-information-variant-circle-outline"></v-icon>
          {{snackbarMessage}}
        </v-snackbar>
      <router-view />
    </v-main>
  </v-app>
</template>

<script>
import NavBar from './components/NavBar.vue'
import EventBus, { ACTIONS } from './EventBus/index.js';

export default {
  name: "App",
  components: {
    NavBar,
  },
  data: () => ({
      snackbar: false,
      snackbarMessage: '',
      snackbarColor: ''
    }),
    mounted() {
      EventBus.$on(ACTIONS.SNACKBAR, ({ message, color }) => {
        this.snackbarMessage = message;
        this.snackbarColor = color;
        this.snackbar = true;
      });
    },
   
};
</script>

