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

            <template #cell(total)="data">
                {{ totalPedido[data.item.id - 1] }}
            </template>

            <template #cell(status)="data">
                {{ data.item.status === 1 ? 'Em aberto' : data.item.status === 2 ? 'Pago' : 'Cancelado' }}
            </template>

            <template v-slot:cell(acao)="{ item }">
                <router-link class="btn btn-primary btn-sm" :to="{ name: 'pedidos-formulario', params: { id: item.id }}">Editar</router-link>
                <button class="btn btn-danger btn-sm mx-2" @click="excluirPedido(item.id)">Excluir</button>
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

            const totalPedido = computed(() => {
                let t = [];
                store.state.pedido.pedidos.map(function(value, key){
                    t[key] = 0;
                    value.produtos.map(function(v, k){
                        t[key] += parseFloat(v.valor_unitario) * parseFloat(v.pivot.quantidade);
                    });
                });
                return t;
            });

            return {
                sortBy: 'id',
                sortDesc: false,
                fields: [
                    { key: 'id', label: 'ID', sortable: true },
                    { key: 'data_pedido', label: 'Data', sortable: true },
                    { key: 'cliente', label: 'Cliente', sortable: true },
                    { key: 'total', label: 'Total', sortable: true },
                    { key: 'status', label: 'Status', sortable: true },
                    { key: 'acao',label: 'Ação', sortable: false }
                ],
                pedidos,
                excluirPedido,
                moment,
                totalPedido
            };
        },
    };
</script>

<style lang="scss" scoped>
</style>
