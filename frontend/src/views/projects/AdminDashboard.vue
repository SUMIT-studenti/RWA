<template>
    <div>
        <v-img src="../../assets/background.jpg" v-if="user.is_admin">
            <v-container>
                <div class="mb-4 mt-3 mx-3">
                    <h1 class="display-2 font-weight-bold mb-3 text-center" style="color: #094776">Prijavljeni Projekti</h1>
                    <p class="text-h6 text--secondary font-weight-regular text-center">Prikaz svih prijavljenih studentskih
                        projekata.
                    </p>
                </div>
                <div
                    style="height: 1px; margin-bottom: 40px; background: linear-gradient(90deg, rgb(255, 255, 255), rgb(8, 71, 118), rgb(255, 255, 255))">
                </div>
                <v-card outlined elevation="11" style="max-width: 1500px;" class="mx-auto">
                    <v-card-title>
                        <div class="v-card__title align-start mt-n5">
                            <div class="overflow-hidden mt-n7 mb-n4 transition-swing v-card--material__sheet v-sheet primary elevation-7 rounded"
                                style="max-width: 100%">
                                <div class="pa-7">
                                    <i aria-hidden="true" class="v-icon notranslate mdi mdi-clipboard-text theme--dark">
                                    </i>
                                </div>
                            </div>
                            <h3 class="font-weight-medium primary--text pl-3">Projekti</h3>
                        </div>
                        <v-spacer></v-spacer>
                        <!-- Table Search bar -->
                        <v-text-field v-model="search" class="mt-3 mt-md-0" prepend-inner-icon="mdi-magnify" label="Search"
                            hide-details style="max-width: 400px"></v-text-field>
                    </v-card-title>
                    <v-data-table :headers="headers" :search="search" :items="projects" :items-per-page="5"
                        class="elevation-1" mobile-breakpoint="0">
                        <!-- Table Name column -->
                        <template v-slot:[`item.name`]="{ item }">
                            <td class="text-lg-left font-weight-medium body-1" style="white-space: nowrap">
                                <div class="d-flex align-center">
                                    <img src="../../assets/images/no_project.jpg" width="110px" height="70px"
                                        class="mr-4 my-3 rounded-lg" style="vertical-align: middle;" />
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
                        <template v-slot:[`item.users`]="{ item }">
                            <td class="body-1">
                                <div v-if="item.users.length > 1" style="white-space: nowrap;">
                                    {{ item.users[0].first_name + ' ' + item.users[0].last_name }} <br>
                                    {{ item.users[1].first_name + ' ' + item.users[1].last_name }}
                                </div>
                                <div v-else>
                                    {{ item.users[0].first_name + ' ' + item.users[0].last_name }}
                                </div>

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
                        <template v-slot:[`item.options`]="{ item }">

                            <v-tooltip bottom>
                                <template v-slot:activator="{ on, attrs }">
                                    <v-btn color="primary" @click="manageProject(item, 'Odobren')" icon v-bind="attrs" v-on="on">
                                        <v-icon>mdi-checkbox-multiple-marked-circle</v-icon>
                                    </v-btn>
                                </template>
                                <span>Prihvati</span>
                            </v-tooltip>

                            <v-tooltip bottom>
                                <template v-slot:activator="{ on, attrs }">
                                    <v-btn @click="manageProject(item, 'Odbijen')" color="red" icon v-bind="attrs" v-on="on">
                                        <v-icon>mdi-close-circle-multiple</v-icon>
                                    </v-btn>
                                </template>
                                <span>Odbij</span>
                            </v-tooltip>
                        </template>
                    </v-data-table>
                </v-card>
            </v-container>
            <!-- Dialog -->
            <EnrollmentTermDialog></EnrollmentTermDialog>
        </v-img>
    </div>
</template>

<script>
import EnrollmentTermDialog from '../../components/EnrollmentTermDialog.vue'
import { useAuthStore } from '../../../store/auth'
import { showSnackbar } from '../../globalActions/index.js';

export default {
    components: {
        EnrollmentTermDialog
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
                text: "Studenti",
                value: "users",
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
            {
                text: "Opcije",
                value: "options",
                align: "center",
                sortable: false,
                class: "subtitle-1 primary--text font-weight-bold title",
            },
        ],
        projects: [],
    }),

    mounted() {
         this.getProjects()
    },
    
    computed: {
        user() {
            return useAuthStore().user;
        },
    },

    methods: {
        manageProject(item, status) {
            console.log(item.id, status)
            this.axios
                .post("/projects/" + item.id, {status:status})
                .then(() => {
                    this.getProjects()
                    if(status === 'Odobren'){
                        showSnackbar("Projekt odobren", "green");
                    }else{
                        showSnackbar("Projekt odbijen", "red");
                    }
                })
                .catch((error) => {
                    console.error("Error occurred:", error);
                })
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