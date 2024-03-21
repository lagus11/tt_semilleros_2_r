<template>
    <v-row>
        <v-col cols="12">
            <h1 class="text-center">Categorias</h1>
        </v-col>
        <v-col class="d-flex justify-end aling-center">
            <v-btn
                color="success"
                size="small"
                variant="outlined"
                @click="openModalAddCategory()"
                >Agregar</v-btn
            >
        </v-col>
        <v-col cols="12">
            <v-data-table
                :loading="isLoadingTable"
                :headers="headers"
                :items="categories"
                :items-per-page="5"
                class="elevation-1"
                items-per-page-text="Filas por página"
            >
                <template v-slot:item.actions="{ item }">
                    <v-btn small fab @click="openModalUpdateCategory(item)"
                        ><v-icon color="primary"> mdi-pencil </v-icon></v-btn
                    >
                    <v-btn small fab @click="deleteCategory(item.id)"
                        ><v-icon color="red"> mdi-delete </v-icon></v-btn
                    >
                </template>
            </v-data-table>
        </v-col>

        <v-dialog v-model="dialogAddOrUpdateCategory" persistent width="500">
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
                                        v-model="category.name"
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
                        v-if="!isLoadingAddUpdateCat"
                        color="blue-darken-1"
                        variant="text"
                        @click="closeModalAddCategory()"
                    >
                        Cerrar
                    </v-btn>
                    <v-btn
                        color="success"
                        variant="text"
                        :loading="isLoadingAddUpdateCat"
                        @click="isAddOrUpdateCategory()"
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
    name: "category",
    mounted() {
        this.getCategories();
    },
    data() {
        return {
            isLoadingTable: false,
            isLoadingAddUpdateCat: false,
            categories: [],
            category: {
                id: null,
                name: "",
            },
            dialogAddOrUpdateCategory: false,
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
        getCategories() {
            this.isLoadingTable = true;
            this.$axios
                .get("/get-categories")
                .then((response) => {
                    this.categories = response.data.categories;
                })
                .catch((error) => {})
                .finally(() => {
                    this.isLoadingTable = false;
                });
        },
        closeModalAddCategory() {
            this.dialogAddOrUpdateCategory = false;
            this.category = {
                id: null,
                name: "",
            };
        },
        openModalAddCategory() {
            this.dialogAddOrUpdateCategory = true;
        },
        isAddOrUpdateCategory() {
            if (this.category.id) {
                this.updateCategory();
            } else {
                this.saveCategory();
            }
        },
        openModalUpdateCategory(category) {
            this.category = {
                id: category.id,
                name: category.name,
            };
            this.openModalAddCategory();
        },
        async saveCategory() {
            // const { valid } = await this.$refs.form.validate();
            // if (!valid) {
            //     return;
            // }

            if (this.isLoadingAddUpdateCat) {
                return;
            }

            this.isLoadingAddUpdateCat = true;

            this.$axios
                .post("/create-category", {
                    name: this.category.name,
                })
                .then((response) => {
                    this.getCategories();
                    this.closeModalAddCategory();
                })
                .catch((error) => {})
                .finally(() => {
                    this.isLoadingAddUpdateCat = false;
                });
        },    
        updateCategory() {
            this.isLoadingTable = true;
            this.$axios
                .put(`/update-category/${this.category.id}`, {
                    name: this.category.name,
                })
                .then((response) => {
                    this.getCategories();
                    this.closeModalAddCategory();
                })
                .catch((error) => {})
                .finally(() => {
                    this.isLoadingTable = false;
                });
        },
        deleteCategory(id) {
            this.isLoadingTable = true;
            this.$axios
                .delete(`/delete-category/${id}`)
                .then((response) => {
                    this.getCategories();
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
