<template>
    <v-app>
        <v-navigation-drawer permanent app>
            <v-list>
                <v-list-item class="px-2">
                    <v-list-item-avatar>
                        <v-img src="https://scontent.fmex28-1.fna.fbcdn.net/v/t39.30808-6/319057891_1251975962023404_6235656447917589793_n.jpg?_nc_cat=107&ccb=1-7&_nc_sid=09cbfe&_nc_eui2=AeG83CgJKFo5wsWSO9pQseze-HXf2xxPsVr4dd_bHE-xWrQf54mNBP9S30V9oS1ZxoaLUEVNyezYazxSZYLHg37F&_nc_ohc=S6xv2gSo3gcAX8F3lAD&_nc_ht=scontent.fmex28-1.fna&oh=00_AfCnos20tLTFcZ8p095u7CRsyft4XKoj0kE029yVYXfokA&oe=647C13DC"></v-img>
                    </v-list-item-avatar>
                </v-list-item>

                <v-list-item link>
                    <v-list-item-content>
                        <v-list-item-title class="text-h6">
                            Prueba Semilleros 2
                        </v-list-item-title>
                        <v-list-item-subtitle>Gerente Betungas</v-list-item-subtitle>
                    </v-list-item-content>
                </v-list-item>
            </v-list>

            <v-divider></v-divider>

            <v-list nav dense>
<!--                <v-list-item link :to="{ name: 'dashboard' }">-->
<!--                    <v-list-item-icon>-->
<!--                        <v-icon>mdi-folder</v-icon>-->
<!--                    </v-list-item-icon>-->
<!--                    <v-list-item-title>Principal</v-list-item-title>-->
<!--                </v-list-item>-->
            </v-list>

        </v-navigation-drawer>
        <v-main class="w-100">
            <v-container fluid>
                <router-view>
                </router-view>
            </v-container>
        </v-main>
    </v-app>
</template>

<script>

export default {
    name: "AppVue",
}
</script>

<style scoped>

</style>
