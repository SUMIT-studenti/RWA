<template>
    <div>
        <v-tooltip left>
            <template v-slot:activator="{ on, attrs }">
                <v-btn dark color="primary" fab bottom right fixed v-bind="attrs" v-on="on" @click="show_dialog = true">
                    <v-icon dark> mdi-calendar-plus-outline </v-icon>
                </v-btn>
            </template>
            <span>Dodaj novi datum obrane</span>
        </v-tooltip>
        <v-dialog transition="dialog-top-transition" max-width="600" v-model="show_dialog"
            @click:outside="show_dialog = false">
            <v-card>
                <v-toolbar color="primary" dark>
                    <v-app-bar-nav-icon>
                        <v-img contain src="../assets/sum-white.png" height="20" class="ml-5" />
                    </v-app-bar-nav-icon>
                    <v-toolbar-title>
                        <span style="font-size: 19px">Datum obrane</span>
                    </v-toolbar-title>
                </v-toolbar>
                <v-card-text>
                    <v-form class="mt-5" ref="form" @submit.prevent="submitForm">
                        <v-menu offset-y>
                            <template v-slot:activator="{ on, attrs }">
                                <v-btn color="primary" block outlined dark v-bind="attrs" v-on="on">
                                    Datumi obrane
                                </v-btn>
                            </template>
                            <v-list>
                                <v-list-item v-for="(item, index) in enrollment_terms" :key="index">
                                    <v-list-item-title>{{ item.enrollment_term_date }}</v-list-item-title>
                                </v-list-item>
                            </v-list>
                        </v-menu>
                        <v-menu v-model="menu" :close-on-content-click="false" :nudge-right="40"
                            transition="scale-transition" offset-y min-width="auto" class="my-5">
                            <template v-slot:activator="{ on, attrs }">
                                <v-text-field v-model="date" label="Dodaj datum obrane" prepend-icon="mdi-calendar" readonly
                                    v-bind="attrs" v-on="on"></v-text-field>
                            </template>
                            <v-date-picker v-model="date" @input="menu = false"></v-date-picker>
                        </v-menu>
                    </v-form>
                    <div
                        style="height: 1px; background: linear-gradient(90deg, rgb(255, 255, 255), rgb(8, 71, 118), rgb(255, 255, 255)); margin-bottom: 8px;">
                    </div>
                </v-card-text>
                <v-card-actions class="justify-center mt-n5">
                    <v-btn class="text-capitalize" color="primary" @click="show_dialog = false" outlined rounded><v-icon
                            left dark>
                            mdi-close </v-icon>Zatvori</v-btn>
                    <v-btn class="text-capitalize" color="primary" @click="setEnrollmentTermDate()" :loading="loading" rounded> <v-icon left dark>
                            mdi-cloud-upload </v-icon>Dodaj datum</v-btn>
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
        menu: false,
        enrollment_terms: null,
        date: null,
        loading: false
    }),

    mounted() {
        this.getEnrollmentTermDates()
    },

    methods: {
        getEnrollmentTermDates() {
            this.axios
                .get("/enrollments")
                .then((response) => {
                    this.enrollment_terms = response.data
                })
                .catch((error) => {
                    console.error("Error occurred:", error);

                });
        },
        setEnrollmentTermDate() {
            this.loading = true
            this.axios
                .post("/enrollment", {enrollment_term_date: this.date})
                .then(() => {
                        this.show_dialog = false
                        this.$emit("getProjects");
                        showSnackbar("Datum obrane uspješno dodan", "green");
                    })
                .catch((error) => {
                    console.error("Error occurred:", error);
                    showSnackbar("Nešto je pošlo krivo", "red");
                }).finally(() => {
                    this.loading = false
                    this.show_dialog = false
                });

        }
    },
};
</script>
