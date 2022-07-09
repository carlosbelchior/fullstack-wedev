<template>
  <div class="container">

    <router-link class="btn btn-primary mb-3" to="/pedidos/gerenciar/">+ Novo pedido</router-link>
    <b-table
        striped
        hover
        primary-key="{ item.id }"
        responsive="sm"
        :items="pedidos"
        :fields="fields"
        :sort-by.sync="sortBy"
        :sort-desc.sync="sortDesc"
        sort-icon-left>
            <template #cell(id)="data">
                {{ data.item.id }}
            </template>

            <template #cell(data_pedido)="data">
                {{ moment(data.item.data_pedido).format('DD/MM/YYYY') }}
            </template>

            <template #cell(cliente)="data">
                {{ data.value.nome }} - <router-link target="_blank" class="" :to="{ name: 'clientes-formulario', params: { id: data.item.cliente_id }}">Ver cliente</router-link>
            </template>

            <template v-slot:cell(acao)="{ item }">
                <router-link class="btn btn-primary btn-sm" :to="{ name: 'pedidos-formulario', params: { id: item.id }}">Editar</router-link>
                <button class="btn btn-danger btn-sm" @click="excluirPedido(item.id)">Excluir</button>
            </template>
    </b-table>
  </div>
</template>

<script>
    import { computed } from "vue";
    import { useStore } from "vuex";
    import axios from "axios";
    import Swal from 'sweetalert2'
    import moment from 'moment';
    export default {
        setup() {
            const store = useStore();

            const pedidos = computed(() => store.state.pedido.pedidos);

            function excluirPedido(pedido_id) {

                var $this = this;
                axios.get('/api/pedidos/exclusao/' + pedido_id).then(function (response) {
                    Swal.fire('Feito!', 'Pedido excluido com sucesso!', 'success')
                    store.commit("pedido/fetchPedidos");
                }).catch(function (error) {
                    Swal.fire('Opa!', 'Erro ao excluir o pedido!', 'error')
                    console.error(error);
                    store.commit("pedido/fetchPedidos");
                });

            }

            return {
                sortBy: 'id',
                sortDesc: false,
                fields: [
                    { key: 'id', label: 'ID', sortable: true },
                    { key: 'data_pedido', label: 'Data', sortable: true },
                    { key: 'cliente', label: 'Cliente', sortable: true },
                    { key: 'acao',label: 'Ação', sortable: false }
                ],
                pedidos,
                excluirPedido,
                moment
            };
        },
    };
</script>

<style lang="scss" scoped>
</style>
