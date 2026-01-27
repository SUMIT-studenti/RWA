<template>
    <v-img src="../../assets/background.jpg">
      <v-container>
        <div class="mb-4 mt-3 mx-3">
          <h1 class="display-2 font-weight-bold mb-3 text-center" style="color: #094776">Moji Projekti</h1>
        </div>
        <div
          style="height: 1px; margin-bottom: 40px; background: linear-gradient(90deg, rgb(255, 255, 255), rgb(8, 71, 118), rgb(255, 255, 255))">
        </div>
        <v-card outlined elevation="11" style="max-width: 1500px;" class="mx-auto">
          <v-card-title>
            <div class="v-card__title align-start mt-n5">
              <div
                class="overflow-hidden mt-n7 mb-n4 transition-swing v-card--material__sheet v-sheet primary elevation-7 rounded"
                style="max-width: 100%">
                <div class="pa-7">
                  <i aria-hidden="true" class="v-icon notranslate mdi mdi-clipboard-text theme--dark"> </i>
                </div>
              </div>
              <h3 class="font-weight-medium primary--text pl-3">Projekti</h3>
            </div>
            <v-spacer></v-spacer>
            <!-- Table Search bar -->
            <v-text-field v-model="search" class="mt-3 mt-md-0" prepend-inner-icon="mdi-magnify" label="Search" hide-details
              style="max-width: 400px"></v-text-field>
          </v-card-title>
          <v-data-table :headers="headers" :search="search" :items="projects" :items-per-page="5" class="elevation-1"
            mobile-breakpoint="0">
            <!-- Table Name column -->
            <template v-slot:[`item.name`]="{ item }">
              <td class="text-lg-left font-weight-medium body-1" style="white-space: nowrap">
                <div class="d-flex align-center">
                  <img src="../../assets/images/no_project.jpg" width="110px" height="70px" class="mr-4 my-3 rounded-lg"
                    style="vertical-align: middle;" />
                  <span> {{ item.name }} </span>
                </div>
              </td>
            </template>
            <!-- Table Date column -->
            <template v-slot:[`item.enrollments`]="{ item }">
              <td class="body-1" style="white-space: nowrap;">
                {{ formatDate(item.enrollments[0].enrollment_term_date) }}
              </td>
            </template>
            <!-- Table Status column -->
            <template v-slot:[`item.status`]="{ item }">
              <td class="body-1">
                <v-chip color="red" outlined small v-if="item.status === 'Odbijen'">
                  {{ item.status }}
                </v-chip>
                <v-chip :color="item.status === 'Prijavljen' ? 'orange' : 'green'" outlined small v-else>
                  {{ item.status }}
                </v-chip> 
              </td>
            </template>
            <!-- Table GitHub column -->
            <template v-slot:[`item.github_link`]="{ item }">
              <td class="body-1 text-center">
                <v-btn color="primary" elevation="6" icon outlined class="my-auto" target="_blank"
                  :href="item.github_link"><v-icon> mdi
                    mdi-github</v-icon></v-btn>
              </td>
            </template>
            <template v-slot:[`item.web_link`]="{ item }">
              <td class="body-1 text-center">
                <v-btn color="primary" elevation="6" icon outlined class="my-auto" target="_blank"
                  :href="item.web_link"><v-icon> mdi-web</v-icon></v-btn>
              </td>
            </template>
          </v-data-table>
        </v-card>
      </v-container>
      <ProjectDialog v-on:getProjects="getProjects"></ProjectDialog>
    </v-img>
  </template>
  
  <script>
  import ProjectDialog from '../../components/ProjectDialog.vue'
  
  export default {
    components: {
    ProjectDialog
  },
    data: () => ({
      search: "",
      headers: [
        {
          text: "Projekt",
          align: "start",
          sortable: false,
          value: "name",
          class: "subtitle-1 primary--text font-weight-bold title",
        },
        {
          text: "Datum obrane",
          value: "enrollments",
          class: "subtitle-1 primary--text font-weight-bold title",
        },
        {
          text: "Status",
          value: "status",
          class: "subtitle-1 primary--text font-weight-bold title",
        },
        {
          text: "Github link",
          value: "github_link",
          align: "center",
          sortable: false,
          class: "subtitle-1 primary--text font-weight-bold title",
        },
        {
          text: "Web link",
          value: "web_link",
          align: "center",
          sortable: false,
          class: "subtitle-1 primary--text font-weight-bold title",
        },
      ],
      projects: [],
    }),
  
    mounted() {
      this.getUserProjects()
    },
  
    methods: {
      getUserProjects() {
        this.axios
          .get("/user_projects")
          .then((response) => {
            this.projects = response.data
          })
          .catch((error) => {
            console.error("Error occurred:", error);
          })
      },
  
      formatDate(dateString) {
        const date = new Date(dateString);
        return date.toLocaleDateString();
      },
    }
  };
  </script>
  
  <style>
  .v-application .body-1 {
    font-family: "Poppins" !important;
  }
  </style>
  