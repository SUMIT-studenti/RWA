<template>
  <div>
    <v-container>
      <!-- Hero section -->
      <v-row no-gutters style="min-height: 90vh">
        <v-col cols="12" lg="6" class="d-flex align-center justify-center">
          <div>
            <v-divider class="my-8 hidden-md-and-down" style="border: 1px solid rgb(192, 191, 191)"></v-divider>
            <div class="my-8 hidden-lg-and-up"></div>
            <h1 class="display-2 font-weight-bold mb-3 text-center" style="color: #094776">SUM Studentski Projekti</h1>
            <p class="text-h6 text--secondary font-weight-regular text-center" style="max-width: 500px">
              Dobrodošli na web stranicu Sveučilišta u Mostaru. <br />
              Na ovom dijelu sustava možete pronaći detaljne informacije o studentskim projektima.
            </p>
            <div class="text-center">
              <v-btn class="text-capitalize font-weight-medium" depressed color="primary" elevation="24" rounded
                height="50" width="150" @click="$vuetify.goTo(target, options)">Saznaj više</v-btn>
            </div>
            <v-divider class="my-8" style="border: 1px solid rgb(192, 191, 191)"></v-divider>
          </div>
        </v-col>
        <v-col cols="12" lg="6" class="d-flex align-center justify-center">
          <v-img :aspect-ratio="16 / 9" id="hero_image" src="../assets/images/landing/hero_image.jpg" alt=""
            transition="scale-transition" />
        </v-col>
      </v-row>
      <!-- Recent projects section -->
      <div class="mx-auto mt-10 mt-lg-0 px-1" style="max-width: 1400px">
        <div class="text-center">
          <h1 class="display-2 font-weight-medium text-center mb-2 primary--text">Projekti</h1>
          <p class="text-h6 text--secondary font-weight-regular">Na sekciji ispod nalazi se prikaz posljednjih projekata.
          </p>
        </div>
        <div
          style="height: 1px; background: linear-gradient(90deg, rgb(255, 255, 255), rgb(8, 71, 118), rgb(255, 255, 255)); margin: 35px 0px 35px 0px">
        </div>
        <v-row>
          <v-col cols="12" lg="4" sm="6" v-for="project in projects" :key="project.id">
            <v-card outlined elevation="10" rounded="lg">
              <div class="px-4 py-3">
                <div class="d-flex">
                  <v-avatar color="primary rounded-lg" size="75" style="width: 100px;">
                    <!-- gradient="to top right, rgba(0,0,0,0.3), rgba(0,0,0,0.3)" -->
                    <v-img src="../assets/images/no_project.jpg" cover />
                  </v-avatar>
                  <div class="mx-4 my-auto">
                    <h6 class="text-h6 font-weight-bold mb-0" style="color: #344767;">{{ project.name }}</h6>
                    <div class="d-flex flex-column" v-for="user in project.users" :key="user.id">
                      <p class="ml-1 my-auto text-subtitle-2 text--secondary">{{ user.first_name }} {{ user.last_name }}
                      </p>
                    </div>
                  </div>
                  <v-spacer></v-spacer>
                  <v-btn color="primary" :href="project.web_link" target="_blank" elevation="6" icon outlined
                    class="my-auto"><v-icon> mdi
                      mdi-web</v-icon></v-btn>
                </div>
                <v-divider class="mt-5"></v-divider>
                <div class="d-flex mt-5 justify-space-between">
                  <div>
                    <h5 class="text-center" style="color: #344767">{{ project.users.length }}</h5>
                    <p class="text-subtitle-2 text--secondary">Sudionici</p>
                  </div>
                  <div>
                    <h5 style="color: #344767" class="text-center">{{ formatDate(project.created_at) }}</h5>
                    <p class="text-subtitle-2 text--secondary">Datum objave</p>
                  </div>
                  <div>
                    <h5 style="color: #344767" class="text-center">{{ project.status }}</h5>
                    <p class="text-subtitle-2 text--secondary text-center">Status</p>
                  </div>
                </div>
              </div>
            </v-card>
          </v-col>
        </v-row>
        <div
          style="height: 1px; background: linear-gradient(90deg, rgb(255, 255, 255), rgb(8, 71, 118), rgb(255, 255, 255)); margin: 35px 0px 25px 0px">
        </div>
        <div class="text-center">
          <v-btn class="text-capitalize font-weight-medium" color="primary" elevation="24" rounded height="45"
            to="/projects">Vidi sve projekte</v-btn>
        </div>
      </div>
    </v-container>
    <!-- Footer section -->
    <v-row style="min-height: 500px; margin-top: 100px; background-color: #094776" class="footer">
      <v-col cols="12" class="d-flex align-center justify-center px-5">
        <div style="max-width: 1200px">
          <v-img contain class="mb-8" src="../assets/sum-white.png" transition="scale-transition" height="80" />
          <p class="text-white font-weight-regular text-center" style="color: #ffffff; font-size: larger">
            <b>SUM Studentski projekti</b> je web stranica koja omogućava pretraživanje, pregled i prijavu projekata
            napravljenih od strane studenata Sveučilišta u Mostaru.
            Na stranicu se možete prijaviti pomoću eduID korisničkog računa.
          </p>
          <div class="text-center mt-5">
            <v-btn color="white" rounded outlined class="text-capitalize mr-2" height="47" width="auto"
              to="/projects">Pretraži projekte</v-btn>
            <v-btn color="white" rounded class="text-capitalize" height="47" width="auto">Prijavi se</v-btn>
          </div>
        </div>
      </v-col>
    </v-row>
  </div>
</template>

<style scoped>
@media screen and (max-width: 1263px) {
  #hero_image {
    max-width: 600px;
  }
}

.footer {
  background-image: url('../assets/footer.png');
  background-size: contain;
  background-repeat: repeat repeat;
}
</style>

<script>
import { useAuthStore } from '../../store/auth.js';

export default {
  name: "HomeView",
  data: () => ({
    projects: []
  }),
  computed: {
    target() {
      return "button";
    },
    options() {
      return {
        duration: 600,
        offset: -2500,
      };
    },
  },

  mounted() {
    this.getProjects(),
    this.getUser();
  },

  methods: {
    getQueryParam(name) {
      const urlParams = new URLSearchParams(window.location.search);
      return urlParams.get(name);
    },
    getProjects() {
      this.axios
        .get("/projects")
        .then((response) => {
          this.projects = response.data
        })
        .catch((error) => {
          console.error("Error occurred:", error);
        })
    },
    async getUser() {
      const token = this.getQueryParam('token');
      if (token) {
        localStorage.setItem('token', token)
      }
      await useAuthStore().getUser();
    },
    formatDate(dateString) {
      const date = new Date(dateString);
      return date.toLocaleDateString();
    },
  }
};
</script>
