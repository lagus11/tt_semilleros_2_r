<template>
    <v-row>
        <v-col cols="12">
            <h1 class="text-center">Escritores</h1>
        </v-col>
        <v-col class="d-flex justify-end aling-center">
            <v-btn
                color="success"
                size="small"
                variant="outlined"
                @click="openModalAddWriter()"
                >Agregar</v-btn
            >
        </v-col>
        <v-col cols="12">
            <v-data-table
                :loading="isLoadingTable"
                :headers="headers"
                :items="writers"
                :items-per-page="5"
                class="elevation-1"
                items-per-page-text="Filas por página"
            >
                <template v-slot:item.actions="{ item }">
                    <v-btn small fab @click="openModalUpdateWriter(item)"
                        ><v-icon color="primary"> mdi-pencil </v-icon></v-btn
                    >
                    <v-btn small fab @click="deleteWriter(item.id)"
                        ><v-icon color="red"> mdi-delete </v-icon></v-btn
                    >
                </template>
            </v-data-table>
        </v-col>

        <v-dialog v-model="dialogAddOrUpdateWriter" persistent width="500">
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
                                        v-model="writer.name"
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
                        v-if="!isLoadingAddUpdateWriter"
                        color="blue-darken-1"
                        variant="text"
                        @click="closeModalAddWriter()"
                    >
                        Cerrar
                    </v-btn>
                    <v-btn
                        color="success"
                        variant="text"
                        :loading="isLoadingAddUpdateWriter"
                        @click="isAddOrUpdateWriter()"
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
    name: "writer",
    mounted() {
        this.getWriters();
    },
    data() {
        return {
            isLoadingTable: false,
            isLoadingAddUpdateWriter: false,
            writers: [],
            writer: {
                id: null,
                name: "",
            },
            dialogAddOrUpdateWriter: false,
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
        getWriters() {
            this.isLoadingTable = true;
            this.$axios
                .get("/get-writers")
                .then((response) => {
                    this.writers = response.data.writers;
                })
                .catch((error) => {})
                .finally(() => {
                    this.isLoadingTable = false;
                });
        },
        closeModalAddWriter() {
            this.dialogAddOrUpdateWriter = false;
            this.writer = {
                id: null,
                name: "",
            };
        },
        openModalAddWriter() {
            this.dialogAddOrUpdateWriter = true;
        },
        isAddOrUpdateWriter() {
            if (this.writer.id) {
                this.updateWriter();
            } else {
                this.saveWriter();
            }
        },
        openModalUpdateWriter(writer) {
            this.writer = {
                id: writer.id,
                name: writer.name,
            };
            this.openModalAddWriter();
        },
        async saveWriter() {
            // const { valid } = await this.$refs.form.validate();
            // if (!valid) {
            //     return;
            // }

            if (this.isLoadingAddUpdateWriter) {
                return;
            }

            this.isLoadingAddUpdateWriter = true;

            this.$axios
                .post("/create-writer", {
                    name: this.writer.name,
                })
                .then((response) => {
                    this.getWriters();
                    this.closeModalAddWriter();
                })
                .catch((error) => {})
                .finally(() => {
                    this.isLoadingAddUpdateWriter = false;
                });
        },    
        updateWriter() {
            this.isLoadingTable = true;
            this.$axios
                .put(`/update-writer/${this.writer.id}`, {
                    name: this.writer.name,
                })
                .then((response) => {
                    this.getWriters();
                    this.closeModalAddWriter();
                })
                .catch((error) => {})
                .finally(() => {
                    this.isLoadingTable = false;
                });
        },
        deleteWriter(id) {
            this.isLoadingTable = true;
            this.$axios
                .delete(`/delete-writer/${id}`)
                .then((response) => {
                    this.getWriters();
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
