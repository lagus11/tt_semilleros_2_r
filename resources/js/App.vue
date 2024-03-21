<template>
    <v-app>
        <v-navigation-drawer permanent app v-if="$route.meta.showNavbar">
            <v-list>
                <v-list-item class="px-2">
                    <v-list-item-avatar>
                        <v-img
                            src="https://scontent.fmex28-1.fna.fbcdn.net/v/t39.30808-6/319057891_1251975962023404_6235656447917589793_n.jpg?_nc_cat=107&ccb=1-7&_nc_sid=09cbfe&_nc_eui2=AeG83CgJKFo5wsWSO9pQseze-HXf2xxPsVr4dd_bHE-xWrQf54mNBP9S30V9oS1ZxoaLUEVNyezYazxSZYLHg37F&_nc_ohc=S6xv2gSo3gcAX8F3lAD&_nc_ht=scontent.fmex28-1.fna&oh=00_AfCnos20tLTFcZ8p095u7CRsyft4XKoj0kE029yVYXfokA&oe=647C13DC"
                        ></v-img>
                    </v-list-item-avatar>
                </v-list-item>

                <v-list-item link>
                    <v-list-item-content>
                        <v-list-item-title class="text-h6">
                            Prueba Semilleros 2
                        </v-list-item-title>
                        <v-list-item-subtitle>{{
                            !!user.name ? user.name : ""
                        }}</v-list-item-subtitle>
                        <v-list-item-subtitle>{{
                            !!user.email ? user.email : ""
                        }}</v-list-item-subtitle>
                    </v-list-item-content>
                </v-list-item>
            </v-list>

            <v-divider></v-divider>

            <v-list nav dense>

                <v-list-item link to="/">
                    <v-list-item-title>Inicio</v-list-item-title>
                </v-list-item>

                <v-list-item v-if="user.rol == 'Admin'" link to="/category">
                    <v-list-item-title>Categoria</v-list-item-title>
                </v-list-item>

                <v-list-item v-if="user.rol == 'Admin'" link to="/editorial">
                    <v-list-item-title>Editorial</v-list-item-title>
                </v-list-item>

                <v-list-item v-if="user.rol == 'Admin'" link to="/writer">
                    <v-list-item-title>Escritores</v-list-item-title>
                </v-list-item>

                <v-list-item v-if="user.rol == 'Admin'" link to="/book">
                    <v-list-item-title>Libros</v-list-item-title>
                </v-list-item>

                <v-list-item v-if="user.rol == 'Admin'" link to="/user">
                    <v-list-item-title>Usuarios</v-list-item-title>
                </v-list-item>

                <v-list-item v-if="user.rol == 'Admin'" link to="/loan">
                    <v-list-item-title>Prestamos</v-list-item-title>
                </v-list-item>

                <v-list-item link to="/search-books">
                    <v-list-item-title>Buscar Libros</v-list-item-title>
                </v-list-item>
                
                <v-list-item link @click="logout()">
                    <v-list-item-title>Cerrar Sesión</v-list-item-title>
                </v-list-item>

            </v-list>
        </v-navigation-drawer>
        <v-main class="w-100">
            <v-container fluid>
                <router-view> </router-view>
            </v-container>
        </v-main>
    </v-app>
</template>

<script>
export default {
    name: "AppVue",
    mounted() {
        this.getUser();
    },
    data() {
        return {
            isLoading: true,
            user: {
                name: "",
                email: "",
                rol: "Cliente",
            },
        };
    },
    methods: {
        getUser() {
            this.$axios
                .get("/get-user")
                .then((response) => {
                    this.user = response.data.user;
                })
                .catch((error) => {})
                .finally(() => {
                    this.isLoading = false;
                });
        },
        logout(){
            this.$axios
                .post("/logout")
                .then((response) => {
                    window.location.href="/login";
                })
                .catch((error) => {})
                .finally(() => {
                });
        }
    },
};
</script>

<style scoped></style>
