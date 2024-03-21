<template>
    <v-row>
        <v-col cols="12">
            <h1 class="text-center">Prestamos</h1>
        </v-col>
        <v-col class="d-flex justify-end aling-center">
            <v-btn
                color="success"
                size="small"
                variant="outlined"
                @click="openModalAddLoan()"
                >Agregar</v-btn
            >
        </v-col>
        <v-col cols="12">
            <v-data-table
                :loading="isLoadingTable"
                :headers="headers"
                :items="loans"
                :items-per-page="5"
                class="elevation-1"
                items-per-page-text="Filas por página"
            >
                <template v-slot:item.actions="{ item }">
                    <v-btn small fab @click="openModalUpdateLoan(item)"
                        ><v-icon color="primary"> mdi-pencil </v-icon></v-btn
                    >
                </template>
                <template v-slot:item.desired="{ item }">
                    {{ item.desired == 1 ? "Si" : "No" }}
                </template>
            </v-data-table>
        </v-col>

        <v-dialog v-model="dialogAddOrUpdateLoan" persistent width="500">
            <v-card>
                <v-card-title>
                    <span class="text-h5">Llena los datos</span>
                </v-card-title>
                <v-card-text>
                    <v-form ref="form">
                        <v-container>
                            <v-row>
                                <v-col cols="12" class="my-0 py-0">
                                    <v-select
                                        v-model="loan.client_id"
                                        :items="clients"
                                        item-text="name"
                                        item-title="name"
                                        item-value="id"
                                        label="Cliente"
                                        :rules="[
                                            (v) =>
                                                !!v || 'Cliente es requerido',
                                        ]"
                                        required
                                    ></v-select>
                                </v-col>
                                <v-col cols="12" class="my-0 py-0">
                                    <v-select
                                        v-model="loan.book_id"
                                        :items="books"
                                        item-text="title"
                                        item-title="tile"
                                        item-value="id"
                                        label="Libro"
                                        :rules="[
                                            (v) => !!v || 'Libro es requerido',
                                        ]"
                                        required
                                    ></v-select>
                                </v-col>
                                <v-col cols="12" class="my-0 py-0">
                                    <v-checkbox
                                        v-model="loan.desired"
                                        label="Deseado"
                                    ></v-checkbox>
                                </v-col>
                                <v-col cols="12" class="my-0 py-0">
                                    <v-text-field
                                        v-model="loan.start_date"
                                        label="Fecha Inicio*"
                                        variant="outlined"
                                        :rules="[
                                            (v) =>
                                                !!v || 'La fecha es requerida',
                                        ]"
                                        required
                                        type="date"
                                    ></v-text-field>
                                </v-col>
                                <v-col cols="12" class="my-0 py-0">
                                    <v-text-field
                                        v-model="loan.end_date"
                                        label="Fecha Final*"
                                        variant="outlined"
                                        :rules="[
                                            (v) =>
                                                !!v || 'La fecha es requerida',
                                        ]"
                                        required
                                        type="date"
                                    ></v-text-field>
                                </v-col>
                                <v-col cols="12" class="my-0 py-0">
                                    <v-text-field
                                        v-model="loan.return_date"
                                        label="Fecha Retorno"
                                        variant="outlined"
                                        type="date"
                                    ></v-text-field>
                                </v-col>
                                <v-col cols="12" class="my-0 py-0">
                                    <v-text-field
                                        v-model="loan.amount"
                                        label="Pago"
                                        variant="outlined"
                                        type="number"
                                        :rules="[
                                            (v) =>
                                                !!v || 'El pago es requerido',
                                        ]"
                                        prefix="$"
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
                        v-if="!isLoadingAddUpdateLoan"
                        color="blue-darken-1"
                        variant="text"
                        @click="closeModalAddLoan()"
                    >
                        Cerrar
                    </v-btn>
                    <v-btn
                        color="success"
                        variant="text"
                        :loading="isLoadingAddUpdateLoan"
                        @click="isAddOrUpdateLoan()"
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
    name: "loan",
    mounted() {
        this.getLoans();
        this.getClients();
        this.getBooks();
    },
    data() {
        return {
            isLoadingTable: false,
            isLoadingAddUpdateLoan: false,
            loans: [],
            clients: [],
            books: [],
            loan: {
                id: null,
                client_id: 0,
                book_id: 0,
                desired: false,
                start_date: "",
                end_date: "",
                return_date: "",
                amount: 0,
            },
            dialogAddOrUpdateLoan: false,
            headers: [
                {
                    text: "Cliente",
                    align: "start",
                    sortable: false,
                    value: "client.name",
                },
                {
                    text: "Libro",
                    align: "start",
                    sortable: false,
                    value: "book.title",
                },
                {
                    text: "Deseado",
                    align: "start",
                    sortable: false,
                    value: "desired",
                },
                {
                    text: "Fecha Inicio",
                    align: "start",
                    sortable: false,
                    value: "start_date",
                },
                {
                    text: "Fecha Final",
                    align: "start",
                    sortable: false,
                    value: "start_date",
                },
                {
                    text: "Fecha Retorno",
                    align: "start",
                    sortable: false,
                    value: "return_date",
                },
                {
                    text: "Cantidad",
                    align: "start",
                    sortable: false,
                    value: "payment.amount",
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
        getLoans() {
            this.isLoadingTable = true;
            this.$axios
                .get("/get-loans")
                .then((response) => {
                    this.loans = response.data.loans;
                })
                .catch((error) => {})
                .finally(() => {
                    this.isLoadingTable = false;
                });
        },
        getClients() {
            this.$axios
                .get("/get-clients")
                .then((response) => {
                    this.clients = response.data.clients;
                })
                .catch((error) => {})
                .finally(() => {});
        },
        getBooks() {
            this.$axios
                .get("/get-books")
                .then((response) => {
                    this.books = response.data.books;
                })
                .catch((error) => {})
                .finally(() => {});
        },
        getClients() {
            this.$axios
                .get("/get-clients")
                .then((response) => {
                    this.clients = response.data.clients;
                })
                .catch((error) => {})
                .finally(() => {});
        },
        closeModalAddLoan() {
            this.dialogAddOrUpdateLoan = false;
            this.loan = {
                id: null,
                client_id: 0,
                book_id: 0,
                desired: false,
                start_date: "",
                end_date: "",
                return_date: "",
                amount: 0,
            };
        },
        openModalAddLoan() {
            this.dialogAddOrUpdateLoan = true;
        },
        isAddOrUpdateLoan() {
            if (this.loan.id) {
                this.updateLoan();
            } else {
                this.saveLoan();
            }
        },
        openModalUpdateLoan(loan) {
            this.loan = {
                id: loan.id,
                client_id: loan.client_id,
                book_id: loan.book_id,
                desired: loan.desired,
                start_date: loan.start_date,
                end_date: loan.end_date,
                return_date: loan.return_date,
                amount: loan.payment.amount,
            };
            this.openModalAddLoan();
        },
        async saveLoan() {
            // const { valid } = await this.$refs.form.validate();
            // if (!valid) {
            //     return;
            // }

            if (this.isLoadingAddUpdateLoan) {
                return;
            }

            this.isLoadingAddUpdateLoan = true;

            this.$axios
                .post("/create-loan", {
                    client_id: this.loan.client_id,
                    book_id: this.loan.book_id,
                    desired: this.loan.desired,
                    start_date: this.loan.start_date,
                    end_date: this.loan.end_date,
                    return_date: this.loan.return_date,
                    amount: this.loan.amount,
                })
                .then((response) => {
                    this.getLoans();
                    this.closeModalAddLoan();
                    let nuevaVentana = window.open('', '_blank');
                    nuevaVentana.document.write(response.data.ticket);

                })
                .catch((error) => {})
                .finally(() => {
                    this.isLoadingAddUpdateLoan = false;
                });
        },
        updateLoan() {
            this.isLoadingTable = true;
            this.$axios
                .put(`/update-loan/${this.loan.id}`, {
                    client_id: this.loan.client_id,
                    book_id: this.loan.book_id,
                    desired: this.loan.desired,
                    start_date: this.loan.start_date,
                    end_date: this.loan.end_date,
                    return_date: this.loan.return_date,
                    amount: this.loan.amount,
                })
                .then((response) => {
                    this.getLoans();
                    this.closeModalAddLoan();
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
