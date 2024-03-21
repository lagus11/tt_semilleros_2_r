<template>
    <v-row>
        <v-col>
            <v-card
                class="mx-auto pa-12 pb-8 mt-12"
                elevation="8"
                max-width="448"
                rounded="lg"
            >
                <div class="text-subtitle-1 text-medium-emphasis">Email</div>

                <v-text-field
                    v-model="email"
                    density="compact"
                    placeholder="Email"
                    prepend-inner-icon="mdi-email-outline"
                    variant="outlined"
                ></v-text-field>

                <div
                    class="text-subtitle-1 text-medium-emphasis d-flex align-center justify-space-between"
                >
                    Contraseña
                </div>

                <v-text-field
                    v-model="password"
                    type="password"
                    density="compact"
                    placeholder="Ingresa tu contraseña"
                    prepend-inner-icon="mdi-lock-outline"
                    variant="outlined"
                ></v-text-field>

                <v-card class="mb-12" color="surface-variant" variant="tonal">
                </v-card>

                <v-btn
                    class="mb-8"
                    color="blue"
                    size="large"
                    variant="tonal"
                    block
                    :loading="isLoading"
                    @click="login()"
                >
                    Ingresar
                </v-btn>
            </v-card>
        </v-col>
    </v-row>
</template>

<script>
export default {
    name: "login",
    data(){
        return {
            isLoading: false,
            email: "",
            password: "",
        }
    },
    methods: {
        login(){
            if(!this.isLoading){
                this.isLoading = true;
                this.$axios
                    .post("/authenticate", {
                        email: this.email,
                        password: this.password,
                    })
                    .then((response) => {
                        window.location.href="/";
                    })
                    .catch((error) =>{
                      alert("Usuario y/o contraseña incorrecta");
                    })
                    .finally(() => {
                        this.isLoading = false;
                    });
            }
        }
    }

};
</script>

<style scoped></style>
