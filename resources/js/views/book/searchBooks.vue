<template>
    <v-row>
        <v-col cols="12">
            <h1 class="text-center">Buscar Libros</h1>
        </v-col>
        <v-col cols="12" sm="4">
            <v-text-field
                v-model="searchBookInput"
                label="Buacar*"
                variant="outlined"
            ></v-text-field>
        </v-col>
        <v-col cols="12" sm="4">
            <v-select
                v-model="filterBook"
                :items="itemFilterBook"
                item-text="name"
                item-title="name"
                item-value="id"
                label="Busqueda por"
            ></v-select>
        </v-col cols="12" sm="4">
        <v-col class="d-flex justify-end aling-center">
            <v-btn color="success" size="small" variant="outlined" @click="searchBook()"
                >Buscar</v-btn
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
            </v-data-table>
        </v-col>
    </v-row>
</template>

<script>
export default {
    name: "searchBook",
    mounted() {},
    data() {
        return {
            isLoadingTable: false,
            searchBookInput: "",
            filterBook: 0,
            itemFilterBook: [
                {
                    id: 0,
                    name: "Título"
                },
                {
                    id: 1,
                    name: "Categoría"
                },
                {
                    id: 2,
                    name: "Editorial"
                },
            ],
            books: [],
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
            ],
        };
    },
    methods: {
        searchBook() {
            this.isLoadingTable = true;
            this.$axios
                .post("/get-search-books",{
                    searchBookInput: this.searchBookInput,
                    filterBook: this.filterBook
                })
                .then((response) => {
                    this.books = response.data.books;
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
