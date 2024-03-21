<template>
    <v-row>
        <v-col cols="12">
            <h1 class="text-center">Usuarios</h1>
        </v-col>
        <v-col class="d-flex justify-end aling-center">
            <v-btn
                color="success"
                size="small"
                variant="outlined"
                @click="openModalAddUser()"
                >Agregar</v-btn
            >
        </v-col>
        <v-col cols="12">
            <v-data-table
                :loading="isLoadingTable"
                :headers="headers"
                :items="users"
                :items-per-page="5"
                class="elevation-1"
                items-per-page-text="Filas por página"
            >
                <template v-slot:item.actions="{ item }">
                    <v-btn small fab @click="openModalUpdateUser(item)"
                        ><v-icon color="primary"> mdi-pencil </v-icon></v-btn
                    >
                    <v-btn small fab @click="deleteUser(item.id)"
                        ><v-icon color="red"> mdi-delete </v-icon></v-btn
                    >
                </template>
            </v-data-table>
        </v-col>

        <v-dialog v-model="dialogAddOrUpdateUser" persistent width="500">
            <v-card>
                <v-card-title>
                    <span class="text-h5">Llena los datos</span>
                </v-card-title>
                <v-card-text>
                    <v-form ref="form">
                        <v-container>
                            <v-row>
                                <v-col cols="12" class="my-0 py-0">
                                    <v-text-field
                                        v-model="user.name"
                                        label="Nombre*"
                                        variant="outlined"
                                        :rules="[
                                            (v) => !!v || 'Nombre es requerido',
                                        ]"
                                        required
                                    ></v-text-field>
                                    <v-text-field
                                        v-model="user.last_name"
                                        label="Primer Apellido*"
                                        variant="outlined"
                                        :rules="[
                                            (v) => !!v || 'Primer apellido es requerido',
                                        ]"
                                        required
                                    ></v-text-field>
                                    <v-text-field
                                        v-model="user.second_last_name"
                                        label="Segundo Apellido*"
                                        variant="outlined"
                                        :rules="[
                                            (v) => !!v || 'Segundo apellido es requerido',
                                        ]"
                                        required
                                    ></v-text-field>
                                    <v-text-field
                                        v-if="this.user.id == null"
                                        v-model="user.email"
                                        label="Correo*"
                                        variant="outlined"
                                        :rules="[
                                            (v) => !!v || 'Correo es requerido',
                                        ]"
                                        required
                                    ></v-text-field>
                                    <v-text-field
                                        v-model="user.password"
                                        label="Contraseña*"
                                        variant="outlined"
                                        :rules="[
                                            (v) => !!v || 'Contraseña es requerido',
                                        ]"
                                        required
                                        type="password"
                                    ></v-text-field>
                                    <v-select
                                        v-model="user.rol_id"
                                        :items="roles"
                                        item-text="name"
                                        item-title="name"
                                        item-value="id"
                                        label="Rol"
                                        :rules="[
                                            (v) =>
                                                !!v || 'Rol es requerida',
                                        ]"
                                        required
                                    ></v-select>
                                </v-col>
                            </v-row>
                        </v-container>
                    </v-form>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                        v-if="!isLoadingAddUpdateUser"
                        color="blue-darken-1"
                        variant="text"
                        @click="closeModalAddUser()"
                    >
                        Cerrar
                    </v-btn>
                    <v-btn
                        color="success"
                        variant="text"
                        :loading="isLoadingAddUpdateUser"
                        @click="isAddOrUpdateUser()"
                    >
                        Guardar
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </v-row>
</template>

<script>
export default {
    name: "user",
    mounted() {
        this.getUsers();
        this.getRoles();
    },
    data() {
        return {
            isLoadingTable: false,
            isLoadingAddUpdateUser: false,
            users: [],
            roles: [],
            user: {
                id: null,
                name: "",
                last_name: "",
                second_last_name: "",
                email: "",
                password: "",
                rol_id: 0,
            },
            dialogAddOrUpdateUser: false,
            headers: [
                {
                    text: "Nombre",
                    align: "start",
                    sortable: false,
                    value: "name",
                },
                {
                    text: "Primer Apellido",
                    align: "start",
                    sortable: false,
                    value: "last_name",
                },
                {
                    text: "Segundo Apellido",
                    align: "start",
                    sortable: false,
                    value: "second_last_name",
                },
                {
                    text: "Correo",
                    align: "start",
                    sortable: false,
                    value: "email",
                },
                {
                    text: "Rol",
                    align: "start",
                    sortable: false,
                    value: "role.name",
                },
                {
                    text: "Acciones",
                    align: "start",
                    sortable: false,
                    value: "actions",
                },
            ],
        };
    },
    methods: {
        getUsers() {
            this.isLoadingTable = true;
            this.$axios
                .get("/get-users")
                .then((response) => {
                    this.users = response.data.users;
                })
                .catch((error) => {})
                .finally(() => {
                    this.isLoadingTable = false;
                });
        },
        getRoles() {
            this.$axios
                .get("/get-roles")
                .then((response) => {
                    this.roles = response.data.roles;
                })
                .catch((error) => {})
                .finally(() => {
                });
        },
        closeModalAddUser() {
            this.dialogAddOrUpdateUser = false;
            this.user = {
                id: null,
                name: "",
                last_name: "",
                second_last_name: "",
                email: "",
                password: "",
                rol_id: 0,
            };
        },
        openModalAddUser() {
            this.dialogAddOrUpdateUser = true;
        },
        isAddOrUpdateUser() {
            if (this.user.id) {
                this.updateUser();
            } else {
                this.saveUser();
            }
        },
        openModalUpdateUser(user) {
            this.user = {
                id: user.id,
                name: user.name,
                last_name: user.last_name,
                second_last_name: user.second_last_name,
                email: "",
                password: "",
                rol_id: user.role_id,
            };
            this.openModalAddUser();
        },
        async saveUser() {
            // const { valid } = await this.$refs.form.validate();
            // if (!valid) {
            //     return;
            // }

            if (this.isLoadingAddUpdateUser) {
                return;
            }

            this.isLoadingAddUpdateUser = true;

            this.$axios
                .post("/create-user", {
                    name: this.user.name,
                    last_name: this.user.last_name,
                    second_last_name: this.user.second_last_name,
                    email: this.user.email,
                    password: this.user.password,
                    rol_id: this.user.rol_id,
                })
                .then((response) => {
                    this.getUsers();
                    this.closeModalAddUser();
                })
                .catch((error) => {})
                .finally(() => {
                    this.isLoadingAddUpdateUser = false;
                });
        },    
        updateUser() {
            this.isLoadingTable = true;
            this.$axios
                .put(`/update-user/${this.user.id}`, {
                    name: this.user.name,
                    last_name: this.user.last_name,
                    second_last_name: this.user.second_last_name,
                    password: this.user.password,
                    rol_id: this.user.rol_id,
                })
                .then((response) => {
                    this.getUsers();
                    this.closeModalAddUser();
                })
                .catch((error) => {})
                .finally(() => {
                    this.isLoadingTable = false;
                });
        },
        deleteUser(id) {
            this.isLoadingTable = true;
            this.$axios
                .delete(`/delete-user/${id}`)
                .then((response) => {
                    this.getUsers();
                })
                .catch((error) => {})
                .finally(() => {
                    this.isLoadingTable = false;
                });
        },
    },
};
</script>

<style scoped></style>
