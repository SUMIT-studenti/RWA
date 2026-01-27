<template>
  <v-img src="../assets/background.jpg" style="min-height: 100vh;">
    <v-container>
      <div class="mb-10 mx-3">
        <h1 class="display-2 font-weight-bold mb-3 text-center" style="color: #094776">Studenti</h1>
        <p class="text-h6 text--secondary font-weight-regular text-center">
              U sekciji ispod unosom GitHub username studenta možete pronaći detaljne informacije o projektima svakog studenta.</p>
        <v-text-field v-model="user" label="Unesite GitHub username studenta" hint="Unesite točan GitHub username" shaped outlined
          class=" font-weight-medium mx-auto" append-icon="mdi-magnify" style="max-width: 800px"
          v-on:keyup.enter="getUserInfo(), getUserProjects()"
          @click:append="getUserInfo(), getUserProjects()" :disabled="true"></v-text-field>
        <div
          style="height: 1px; background: linear-gradient(90deg, rgb(255, 255, 255), rgb(8, 71, 118), rgb(255, 255, 255));">
        </div>
      </div>
      <v-alert v-model="alert" text prominent type="error" icon="mdi-alert">
        Došlo je do greške. Pogrešan unos ili problem sa slanjem zahtjeva. Provjerite unesene podatke ili probajte kasnije.
      </v-alert>
      <!-- GitHub account details -->
      <v-card class="pa-5" elevation="0" v-if="show" style="background: transparent;">
        <v-row>
          <v-col lg="3" sm="12" class="d-flex align-start justify-center mb-5">
            <v-card class="v-card-profile" elevation="20" outlined width="400" shaped>
              <v-card-title class="d-flex justify-center">
                <v-avatar color="primary" size="200"><v-img :src=this.userInfo.avatar_url></v-img></v-avatar>
              </v-card-title>
              <v-card-text class="text-center">
                <h2 class="font-weight-light mb-4 black--text">{{ this.userInfo.login }}</h2>
                <div justify="center">
                  <v-icon class="mr-1"> mdi mdi-account-multiple-outline </v-icon>
                  <span class="subheading mr-2">{{ this.userInfo.followers }} Followers</span>
                  <v-icon class="mr-1"> mdi mdi-account </v-icon>
                  <span class="subheading">{{ this.userInfo.following }} Following</span>
                </div>
              </v-card-text>
  
              <v-card-actions class="mx-6 mb-3">
                <v-btn color="primary" target="_blank" :href=this.userInfo.html_url block> <v-icon left dark> mdi mdi-github
                  </v-icon>Posjeti GitHub </v-btn>
              </v-card-actions>
            </v-card>
          </v-col>
          <v-col cols="12" lg="9">
            <v-row dense>
              <v-col cols="12" lg="6" md="6" v-for="(project, index) in displayedProjects" :key="index">
                <v-card outlined elevation="2">
                  <v-card-title class="text-subtitle-1 font-weight-bold primary--text mb-3">
                    <span>{{ project.name }}</span>
                    <v-spacer></v-spacer>
                    <v-chip outlined small color="primary">{{ project.visibility }}</v-chip>
                  </v-card-title>
                  <v-card-subtitle class="font-weight-medium"> {{ project.description }}</v-card-subtitle>
                  <v-card-actions class="ml-1 mt-n1">
                    <v-badge inline left dot class="text-subtitle-2"><span>{{ project.language }}</span></v-badge>
                    <v-spacer></v-spacer>
                    <v-btn color="primary" small rounded :href=project.html_url target="_blank"> <v-icon left dark> mdi
                        mdi-github </v-icon>GitHub Link </v-btn>
                  </v-card-actions>
                </v-card>
              </v-col>
            </v-row>
            <v-pagination class="mt-3" circle v-model="currentPage" :length="totalPages"></v-pagination>
          </v-col>
        </v-row>
      </v-card>
    </v-container>
  </v-img>
  </template>
  
  <script>
  export default {
    data: () => ({
      user: "",
      show: false,
      alert: false,
      userInfo: [],
      userProjects: [],
      currentPage: 1,
      cardsPerPage: 8
    }),
    methods: {
      async getUserInfo() {
        this.axios.defaults.withCredentials = false;
        await this.axios
          .get("https://api.github.com/users/" + this.user)
          .then((response) => {
            this.userInfo = response.data;
            this.show = true;
            this.getUserProjects()
          })
          .catch((error) => {
            console.error("Error occurred:", error);
            this.alert = true
            setTimeout(() => {
              this.alert = false
            }, "6000");
          }).finally(() => (this.axios.defaults.withCredentials = true));
      },
      async getUserProjects() {
        this.axios.defaults.withCredentials = false;
        await this.axios.get("https://api.github.com/users/" + this.user + "/repos").then((response) => {
          this.userProjects = response.data
          this.show = true
        }).catch((error) => {
            console.error("Error occurred:", error);
            this.alert = true
            setTimeout(() => {
              this.alert = false
            }, "6000");
          })
      }
    },
    computed: {
      displayedProjects() {
        const startIndex = (this.currentPage - 1) * this.cardsPerPage;
        const endIndex = startIndex + this.cardsPerPage;
        return this.userProjects.slice(startIndex, endIndex);
      },
      totalPages() {
        return Math.ceil(this.userProjects.length / this.cardsPerPage);
      }
    }
  };
  </script>
  