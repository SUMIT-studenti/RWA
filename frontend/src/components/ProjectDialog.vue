<template>
    <div>
        <v-tooltip left>
            <template v-slot:activator="{ on, attrs }">
                <v-btn dark color="primary" fab bottom right fixed v-bind="attrs" v-on="on" @click="show_dialog = true">
                    <v-icon dark> mdi-plus </v-icon>
                </v-btn>
            </template>
            <span>Dodaj novi projekt</span>
        </v-tooltip>
        <v-dialog transition="dialog-top-transition" max-width="600" v-model="show_dialog"
            @click:outside="show_dialog = false">
            <v-card>
                <v-toolbar color="primary" dark>
                    <v-app-bar-nav-icon>
                        <v-img contain src="../assets/sum-white.png" height="20" class="ml-5" />
                    </v-app-bar-nav-icon>
                    <v-toolbar-title>
                        <span style="font-size: 19px">Prijava projekta</span>
                    </v-toolbar-title>
                </v-toolbar>
                <v-card-text>
                    <v-form class="mt-5" ref="form" @submit.prevent="submitForm">
                        <v-text-field v-model="projectName" :rules="nameRules" label="Naziv projekta" outlined shaped
                            dense></v-text-field>
                        <v-select label="Datum obrane" no-data-text="Nema dostupnih rokova" v-model="enrollment_id" :items="enrollment_terms"
                            item-text="enrollment_term_date" :rules="dateRules" item-value="id" outlined shaped dense></v-select>
                        <v-text-field v-model="projectLink" :rules="projectLinkRules" label="Link projekta" outlined shaped
                            dense></v-text-field>
                        <v-text-field v-model="github_link" :rules="projectLinkRules" label="GitHub Link" outlined shaped
                            dense></v-text-field>
                    </v-form>
                    <div
                        style="height: 1px; background: linear-gradient(90deg, rgb(255, 255, 255), rgb(8, 71, 118), rgb(255, 255, 255)); margin-bottom: 8px;">
                    </div>
                </v-card-text>
                <v-card-actions class="justify-center mt-n5">
                    <v-btn class="text-capitalize" color="primary" @click="show_dialog = false" outlined rounded><v-icon
                            left dark>
                            mdi-close </v-icon>Zatvori</v-btn>
                    <v-btn class="text-capitalize" color="primary" @click="submitForm()" rounded> <v-icon left dark>
                            mdi-cloud-upload </v-icon> Prijavi projekt</v-btn>
                            
                </v-card-actions>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
import { showSnackbar } from '../globalActions/index.js';

export default {
    data: () => ({
        show_dialog: false,
        projectName: "",
        projectLink: "",
        github_link: "",
        enrollment_id: null,
        enrollment_terms: [],
        projectLinkRules: [(v) => !!v || "Project Link is required", (v) => /^(ftp|http|https):\/\/[^ "]+$/.test(v) || "Project Link mora biti validan URL"],
        nameRules: [(v) => !!v || "Ime projekta je obavezno polje"],
        dateRules: [(v) => !!v || "Datum obrane je obavezno polje"],
    }),

    mounted() {
        this.getEnrollmentTermDates()
    },

    methods: {
        submitForm() {
            if (this.$refs.form.validate()) {
                let project = {
                    name: this.projectName,
                    status: "Prijavljen",
                    web_link: this.projectLink,
                    github_link: this.github_link,
                    enrollment_id: this.enrollment_id,
                };
                this.axios
                    .post("/projects/create", project)
                    .then(() => {
                        this.show_dialog = false
                        this.$emit("getProjects");
                        showSnackbar("Projekt uspješno prijavljen", "green");
                    })
                    .catch((error) => {
                        console.error("Error occurred:", error);
                        if (error.response.status == 401) {
                            this.$router.push("/login");
                        }
                        showSnackbar(error, "red");
                    });
            }
        },
        getEnrollmentTermDates(){
            this.axios.get("/enrollments").then((response) => {
                const current_date = new Date();
                for(let i = 0; i < response.data.length; i++){
                    const date = new Date(response.data[i].enrollment_term_date)
                    if(date > current_date){
                        this.enrollment_terms.push(response.data[i])
                    }
                }
                })
                .catch((error) => {
                    console.error("Error occurred:", error);
                });
        }
    },
};
</script>
