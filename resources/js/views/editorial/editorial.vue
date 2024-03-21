<template>
    <v-row>
        <v-col cols="12">
            <h1 class="text-center">Editoriales</h1>
        </v-col>
        <v-col class="d-flex justify-end aling-center">
            <v-btn
                color="success"
                size="small"
                variant="outlined"
                @click="openModalAddEditorial()"
                >Agregar</v-btn
            >
        </v-col>
        <v-col cols="12">
            <v-data-table
                :loading="isLoadingTable"
                :headers="headers"
                :items="editorials"
                :items-per-page="5"
                class="elevation-1"
                items-per-page-text="Filas por página"
            >
                <template v-slot:item.actions="{ item }">
                    <v-btn small fab @click="openModalUpdateEditorial(item)"
                        ><v-icon color="primary"> mdi-pencil </v-icon></v-btn
                    >
                    <v-btn small fab @click="deleteEditorial(item.id)"
                        ><v-icon color="red"> mdi-delete </v-icon></v-btn
                    >
                </template>
            </v-data-table>
        </v-col>

        <v-dialog v-model="dialogAddOrUpdateEditorial" persistent width="500">
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
                                        v-model="editorial.name"
                                        label="Nombre*"
                                        variant="outlined"
                                        :rules="[
                                            (v) => !!v || 'Nombre es requerido',
                                        ]"
                                        required
                                    ></v-text-field>
                                </v-col>
                            </v-row>
                        </v-container>
                    </v-form>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                        v-if="!isLoadingAddUpdateEdit"
                        color="blue-darken-1"
                        variant="text"
                        @click="closeModalAddEditorial()"
                    >
                        Cerrar
                    </v-btn>
                    <v-btn
                        color="success"
                        variant="text"
                        :loading="isLoadingAddUpdateEdit"
                        @click="isAddOrUpdateEditorial()"
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
    name: "editorial",
    mounted() {
        this.getEditorials();
    },
    data() {
        return {
            isLoadingTable: false,
            isLoadingAddUpdateEdit: false,
            editorials: [],
            editorial: {
                id: null,
                name: "",
            },
            dialogAddOrUpdateEditorial: false,
            headers: [
                {
                    text: "Nombre",
                    align: "start",
                    sortable: false,
                    value: "name",
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
        getEditorials() {
            this.isLoadingTable = true;
            this.$axios
                .get("/get-editorials")
                .then((response) => {
                    this.editorials = response.data.editorials;
                })
                .catch((error) => {})
                .finally(() => {
                    this.isLoadingTable = false;
                });
        },
        closeModalAddEditorial() {
            this.dialogAddOrUpdateEditorial = false;
            this.editorial = {
                id: null,
                name: "",
            };
        },
        openModalAddEditorial() {
            this.dialogAddOrUpdateEditorial = true;
        },
        isAddOrUpdateEditorial() {
            if (this.editorial.id) {
                this.updateEditorial();
            } else {
                this.saveEditorial();
            }
        },
        openModalUpdateEditorial(editorial) {
            this.editorial = {
                id: editorial.id,
                name: editorial.name,
            };
            this.openModalAddEditorial();
        },
        async saveEditorial() {
            // const { valid } = await this.$refs.form.validate();
            // if (!valid) {
            //     return;
            // }

            if (this.isLoadingAddUpdateEdit) {
                return;
            }

            this.isLoadingAddUpdateEdit = true;

            this.$axios
                .post("/create-editorial", {
                    name: this.editorial.name,
                })
                .then((response) => {
                    this.getEditorials();
                    this.closeModalAddEditorial();
                })
                .catch((error) => {})
                .finally(() => {
                    this.isLoadingAddUpdateEdit = false;
                });
        },    
        updateEditorial() {
            this.isLoadingTable = true;
            this.$axios
                .put(`/update-editorial/${this.editorial.id}`, {
                    name: this.editorial.name,
                })
                .then((response) => {
                    this.getEditorials();
                    this.closeModalAddEditorial();
                })
                .catch((error) => {})
                .finally(() => {
                    this.isLoadingTable = false;
                });
        },
        deleteEditorial(id) {
            this.isLoadingTable = true;
            this.$axios
                .delete(`/delete-editorial/${id}`)
                .then((response) => {
                    this.getEditorials();
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
