<template>
    <v-row>
        <v-col cols="12">
            <h1 class="text-center">Libros</h1>
        </v-col>
        <v-col class="d-flex justify-end aling-center">
            <v-btn size="small" variant="outlined" color="success" @click="openModalAddBook()"
                >Agregar</v-btn
            >
        </v-col>
        <v-col cols="12">
            <v-data-table
                :loading="isLoadingTable"
                :headers="headers"
                :items="books"
                :items-per-page="5"
                class="elevation-1"
                items-per-page-text="Filas por página"
            >
                <template v-slot:item.writers="{ item }">
                    <ul>
                        <li v-for="writer in item.writers" :key="writer.id">
                            {{ writer.name }}
                        </li>
                    </ul>
                </template>
                <template v-slot:item.actions="{ item }">
                    <v-btn small fab @click="openModalUpdateBook(item)"
                        ><v-icon color="primary"> mdi-pencil </v-icon></v-btn
                    >
                    <v-btn small fab @click="deleteBook(item.id)"
                        ><v-icon color="red"> mdi-delete </v-icon></v-btn
                    >
                </template>
            </v-data-table>
        </v-col>

        <v-dialog v-model="dialogAddOrUpdateBook" persistent width="500">
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
                                        v-model="book.title"
                                        label="Títutlo*"
                                        variant="outlined"
                                        :rules="[
                                            (v) => !!v || 'Título es requerido',
                                        ]"
                                        required
                                    ></v-text-field>
                                </v-col>
                                <v-col cols="12" class="my-0 py-0">
                                    <v-select
                                        v-model="book.category_id"
                                        :items="categories"
                                        item-text="name"
                                        item-title="name"
                                        item-value="id"
                                        label="Categoria"
                                        :rules="[
                                            (v) =>
                                                !!v || 'Categoría es requerida',
                                        ]"
                                        required
                                    ></v-select>
                                </v-col>
                                <v-col cols="12" class="my-0 py-0">
                                    <v-text-field
                                        v-model="book.quantity"
                                        label="Cantidad*"
                                        variant="outlined"
                                        :rules="[
                                            (v) =>
                                                !!v || 'Cantidad es requerida',
                                        ]"
                                        required
                                    ></v-text-field>
                                </v-col>
                                <v-col cols="12" class="my-0 py-0">
                                    <v-select
                                        v-model="book.editorial_id"
                                        :items="editorials"
                                        item-text="name"
                                        item-title="name"
                                        item-value="id"
                                        label="Editorial"
                                        :rules="[
                                            (v) =>
                                                !!v || 'Editorial es requerida',
                                        ]"
                                        required
                                    ></v-select>
                                </v-col>
                                <v-col cols="12" class="my-0 py-0">
                                    <v-select
                                        v-model="book.writers"
                                        :items="writers"
                                        item-text="name"
                                        item-title="name"
                                        item-value="id"
                                        label="Escritor"
                                        :rules="[
                                            (v) =>
                                                !!v || 'Escritor es requerida',
                                        ]"
                                        required
                                        multiple
                                    ></v-select>
                                </v-col>
                            </v-row>
                        </v-container>
                    </v-form>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                        v-if="!isLoadingAddUpdateBook"
                        color="blue-darken-1"
                        variant="text"
                        @click="closeModalAddBook()"
                    >
                        Cerrar
                    </v-btn>
                    <v-btn
                        color="success"
                        variant="text"
                        :loading="isLoadingAddUpdateBook"
                        @click="isAddOrUpdateBook()"
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
    name: "book",
    mounted() {
        this.getBooks();
        this.getCategories();
        this.getEditorials();
        this.getWriters();
    },
    data() {
        return {
            isLoadingTable: false,
            isLoadingAddUpdateBook: false,
            books: [],
            categories: [],
            editorials: [],
            writers: [],
            book: {
                id: null,
                title: "",
                category_id: 0,
                quantity: 0,
                editorial_id: 0,
            },
            dialogAddOrUpdateBook: false,
            headers: [
                {
                    text: "Título",
                    align: "start",
                    sortable: false,
                    value: "title",
                },
                {
                    text: "Categoría",
                    align: "start",
                    sortable: false,
                    value: "category.name",
                },
                {
                    text: "Cantidad",
                    align: "start",
                    sortable: false,
                    value: "quantity",
                },
                {
                    text: "Editorial",
                    align: "start",
                    sortable: false,
                    value: "editorial.name",
                },
                {
                    text: "Escritores",
                    align: "start",
                    sortable: false,
                    value: "writers",
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
        getBooks() {
            this.isLoadingTable = true;
            this.$axios
                .get("/get-books")
                .then((response) => {
                    this.books = response.data.books;
                })
                .catch((error) => {})
                .finally(() => {
                    this.isLoadingTable = false;
                });
        },
        getCategories() {
            this.$axios
                .get("/get-categories")
                .then((response) => {
                    this.categories = response.data.categories;
                })
                .catch((error) => {})
                .finally(() => {});
        },
        getEditorials() {
            this.$axios
                .get("/get-editorials")
                .then((response) => {
                    this.editorials = response.data.editorials;
                })
                .catch((error) => {})
                .finally(() => {});
        },
        getWriters() {
            this.$axios
                .get("/get-writers")
                .then((response) => {
                    this.writers = response.data.writers;
                })
                .catch((error) => {})
                .finally(() => {});
        },
        closeModalAddBook() {
            this.dialogAddOrUpdateBook = false;
            this.book = {
                id: null,
                title: "",
                category_id: 0,
                quantity: 0,
                editorial_id: 0,
            };
        },
        openModalAddBook() {
            this.dialogAddOrUpdateBook = true;
        },
        isAddOrUpdateBook() {
            if (this.book.id) {
                this.updateBook();
            } else {
                this.saveBook();
            }
        },
        openModalUpdateBook(book) {
            const ids_writers = book.writers.map(writer => writer.id);

            this.book = {
                id: book.id,
                title: book.title,
                category_id: book.category_id,
                quantity: book.quantity,
                editorial_id: book.editorial_id,
                writers: ids_writers
            };
            this.openModalAddBook();
        },
        async saveBook() {
            // const { valid } = await this.$refs.form.validate();
            // if (!valid) {
            //     return;
            // }

            if (this.isLoadingAddUpdateBook) {
                return;
            }

            this.isLoadingAddUpdateBook = true;

            this.$axios
                .post("/create-book", {
                    title: this.book.title,
                    category_id: this.book.category_id,
                    quantity: this.book.quantity,
                    editorial_id: this.book.editorial_id,
                    writers: this.book.writers,
                })
                .then((response) => {
                    this.getBooks();
                    this.closeModalAddBook();
                })
                .catch((error) => {})
                .finally(() => {
                    this.isLoadingAddUpdateBook = false;
                });
        },
        updateBook() {
            this.isLoadingTable = true;
            this.$axios
                .put(`/update-book/${this.book.id}`, {
                    title: this.book.title,
                    category_id: this.book.category_id,
                    quantity: this.book.quantity,
                    editorial_id: this.book.editorial_id,
                    writers: this.book.writers,
                })
                .then((response) => {
                    this.getBooks();
                    this.closeModalAddBook();
                })
                .catch((error) => {})
                .finally(() => {
                    this.isLoadingTable = false;
                });
        },
        deleteBook(id) {
            this.isLoadingTable = true;
            this.$axios
                .delete(`/delete-book/${id}`)
                .then((response) => {
                    this.getBooks();
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
