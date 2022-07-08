<template>
  <div class="container">

    <router-link class="btn btn-primary mb-3" to="/clientes/gerenciar/">+ Novo cliente</router-link>
    <b-table
        striped
        hover
        responsive="sm"
        :items="clientes"
        :fields="fields"
        :sort-by.sync="sortBy"
        :sort-desc.sync="sortDesc"
        sort-icon-left>
        <template v-slot:cell(acao)="{ item }">
            <router-link class="btn btn-primary btn-sm" :to="{ name: 'clientes-formulario', params: { id: item.id }}">Editar</router-link>
            <button class="btn btn-danger btn-sm" @click="excluirCliente(item.id)">Excluir</button>
        </template>
    </b-table>
  </div>
</template>

<script>
    import { computed } from "vue";
    import { useStore } from "vuex";
    import axios from "axios";
    import Swal from 'sweetalert2'
    export default {
        setup() {
            const store = useStore();

            const clientes = computed(() => store.state.cliente.clientes);

            function excluirCliente(cliente_id) {

                var $this = this;
                axios.get('/api/clientes/exclusao/' + cliente_id).then(function (response) {
                    Swal.fire('Feito!', 'Cliente excluido com sucesso!', 'success')
                    store.commit("cliente/fetchClientes");
                }).catch(function (error) {
                    Swal.fire('Opa!', 'Erro ao excluir o cliente!', 'danger')
                    console.error(error);
                    store.commit("cliente/fetchClientes");
                });

            }

            return {
                sortBy: 'id',
                sortDesc: false,
                fields: [
                    { key: 'id', label: 'ID', sortable: true },
                    { key: 'nome', label: 'Nome', sortable: true },
                    { key: 'cpf', label: 'CPF', sortable: true },
                    { key: 'email', label: 'E-mail', sortable: true },
                    { key: 'acao',label: 'Ação', sortable: false }
                ],
                clientes,
                excluirCliente,
            };
        },
    };
</script>

<style lang="scss" scoped>
</style>
