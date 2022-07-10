<template>
  <div class="container">

    <n-data-table
      ref="dataTableInst"
      :columns="fields"
      :data="clientes"
      :pagination="pagination"
    />

    <router-link class="btn btn-primary mb-3" to="/clientes/gerenciar/">+ Novo cliente</router-link>
    <b-table
        primary-key="clientes.id"
        striped
        hover
        responsive="sm"
        :items="clientes"
        :fields="fields"
        :sort-by="sortBy"
        :sort-desc="sortDesc"
        id="my-table"
        sort-icon-left>
        <template v-slot:cell(acao)="{ item }">
            <router-link class="btn btn-primary btn-sm" :to="{ name: 'clientes-formulario', params: { id: item.id }}">Editar</router-link>
            <button class="btn btn-danger btn-sm mx-2" @click="excluirCliente(item.id)">Excluir</button>
        </template>
    </b-table>

    <b-pagination
        v-model="currentPage"
        :total-rows="50"
        :per-page="5"
        aria-controls="my-table"
    ></b-pagination>
  </div>
</template>

<script>
    import { computed } from "vue";
    import { useStore } from "vuex";
    import axios from "axios";
    import Swal from 'sweetalert2'
    import init from '../helpers/init'
    export default {
        setup() {
            const store = useStore();

            const clientes = computed(() => store.state.cliente.clientes);

            function excluirCliente(cliente_id) {

                var $this = this;
                axios.get('/api/clientes/exclusao/' + cliente_id).then(function (response) {
                    Swal.fire('Feito!', 'Cliente excluido com sucesso!', 'success')
                }).catch(function (error) {
                    Swal.fire('Opa!', 'Erro ao excluir o cliente!', 'error')
                    console.error(error);
                });

                init();

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
                pagination: { pageSize: 20 }
            };
        },
    };
</script>

<style lang="scss" scoped>
</style>
