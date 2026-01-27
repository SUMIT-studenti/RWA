<template>
    <div class="blue lighten-5" style="min-height: 100vh;">
        <v-container>
            <v-row class="align-center justify-center d-flex" style="min-height: 100vh;">
                <v-col cols="12" sm="10">
                    <v-card class="elevation-6 my-10 py-10 mx-3" shaped>
                        <v-row>
                            <v-col cols="12" md="6">
                                <v-card-text class="mt-12">
                                    <h2 class="text-center mb-2">Registracija</h2>
                                    <h5 class="text-center  grey--text">Registrirajte se ukoliko ne posjedujete korisnički
                                        račun</h5>
                                    <v-row align="center" justify="center" class="mt-1 px-3">
                                        <v-col cols="12" sm="8">
                                            <v-row>
                                                <v-col cols="12" sm="6" class="pr-3 pr-sm-1">
                                                    <v-text-field v-model="first_name" label="Ime" shaped dense
                                                        outlined></v-text-field>
                                                </v-col>
                                                <v-col cols="12" sm="6" class="pl-3 pl-sm-1">
                                                    <v-text-field v-model="last_name" label="Prezime" dense shaped outlined
                                                        class="mt-n6 mt-sm-0"></v-text-field>
                                                </v-col>
                                            </v-row>
                                            <v-text-field v-model="email" label="Email" dense shaped outlined
                                                prepend-inner-icon="mdi-email-fast-outline"></v-text-field>
                                            <v-text-field v-model="password" label="Lozinka" dense shaped outlined
                                                prepend-inner-icon="mdi-key-chain-variant"></v-text-field>
                                            <v-row class="mt-n7">
                                                <v-col cols="12">
                                                    <v-btn class="caption blue--text text-none pl-0" text to="/login">Imate
                                                        korisnički račun? Prijavite se</v-btn>
                                                </v-col>
                                            </v-row>
                                            <v-btn color="primary" class="rounded-xl mt-2 text-none" block tile
                                                @click="handleRegistration()">
                                                <v-icon left>
                                                    mdi-account-plus-outline
                                                </v-icon>
                                                Registriraj se
                                            </v-btn>

                                        </v-col>
                                    </v-row>
                                </v-card-text>
                            </v-col>
                            <v-divider vertical v-if="$vuetify.breakpoint.smAndUp"></v-divider>
                            <v-col cols="12" md="6" class="justify-center d-flex flex-column">
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
    name: 'RegistrationView',
    data() {
        return {
            first_name: '',
            last_name: '',
            email: '',
            password: '',
            errorMessage: null,
        };
    },
    methods: {
        async handleRegistration() {
            let data = {
                email: this.email,
                first_name: this.first_name,
                last_name: this.last_name,
                password: this.password,
                uid: 2,
                branch: "branch"
            }
            try {
                await useAuthStore().register(data);
                await useAuthStore().getUser();
                this.$router.push('/');
            } catch (error) {
                this.errorMessage = error.response.data.message;
                setTimeout(() => {
                    this.errorMessage = null
                }, 5000);
            }
        },
    },
};
</script>
    