<template>
  <div class="container">

    <router-link class="btn btn-primary mb-3" to="/pedidos/gerenciar/">+ Novo pedido</router-link>

    <VTable class="table table-striped table-responsive table-bordered"
        :data="pedidos"
        :filters="filters"
        :page-size="20"
        v-model:currentPage="currentPage"
        @totalPagesChanged="totalPages = $event"
        >
            <template #head>
                <tr>
                    <VTh class="col-1" sortKey="id">ID</VTh>
                    <VTh class="col-2" sortKey="nome">Data</VTh>
                    <VTh class="col-4" sortKey="nome">Nome</VTh>
                    <VTh class="col-1" sortKey="cpf">Total</VTh>
                    <VTh class="col-2" sortKey="email">Status</VTh>
                    <th class="col-2">Ação</th>
                </tr>
            </template>
            <template #body="{rows}">
                <tr>
                    <td><input type="text" class="form-control form-control-sm" autocomplete="false" v-model="filters.id.value"/></td>
                    <td><input type="text" class="form-control form-control-sm" autocomplete="false" v-model="filters.data.value"/></td>
                    <td><input type="text" class="form-control form-control-sm" autocomplete="false" v-model="filters.nome.value"/></td>
                    <td><input type="text" class="form-control form-control-sm" autocomplete="false" v-model="filters.total.value"/></td>
                    <td><input type="text" class="form-control form-control-sm" autocomplete="false" v-model="filters.status.value"/></td>
                    <td></td>
                </tr>
                <tr v-for="row in rows" :key="row.id">
                    <td>{{ row.id }}</td>
                    <td>{{ moment(row.data_pedido).format('DD/MM/YYYY') }}</td>
                    <td>{{ row.cliente.nome }} - <router-link target="_blank" class="" :to="{ name: 'clientes-formulario', params: { id: row.cliente_id }}">Ver cliente</router-link></td>
                    <td>{{ totalPedido[row.id].toFixed(2) }}</td>
                    <td>{{ row.status === 1 ? 'Em aberto' : row.status === 2 ? 'Pago' : 'Cancelado' }}</td>
                    <td>
                        <router-link class="btn btn-primary btn-sm" :to="{ name: 'pedidos-formulario', params: { id: row.id }}">Editar</router-link>
                        <button class="btn btn-danger btn-sm mx-2" @click="excluirPedido(row.id)">Excluir</button>
                    </td>
                </tr>
            </template>
        </VTable>

        <VTPagination v-model:currentPage="currentPage" :total-pages="totalPages" :boundary-links="true"/>

  </div>
</template>

<script>
    import { computed } from "vue";
    import { useStore } from "vuex";
    import axios from "axios";
    import Swal from 'sweetalert2'
    import moment from 'moment';
    export default {
        data: () => ({
            filters: {
                id: { value: '', keys: ['id'] },
                data: { value: '', keys: ['data'] },
                nome: { value: '', keys: ['nome'] },
                total: { value: '', keys: ['total'] },
                status: { value: '', keys: ['status'] },
            },
            totalPages: 1,
            currentPage: 1
        }),

        setup() {
            const store = useStore();

            const pedidos = computed(() => store.state.pedido.pedidos);

            function excluirPedido(pedido_id) {

                axios.get('/api/pedidos/exclusao/' + pedido_id).then(function (response) {
                    Swal.fire('Feito!', 'Pedido excluido com sucesso!', 'success')
                    store.commit("pedido/fetchPedidos");
                }).catch(function (error) {
                    Swal.fire('Opa!', 'Erro ao excluir o pedido!', 'error')
                    store.commit("pedido/fetchPedidos");
                });

            }

            const totalPedido = computed(() => {
                let t = [];
                if(store.state.pedido.pedidos.length > 0)
                    store.state.pedido.pedidos.map(function(value, key)
                    {
                        t[value.id] = 0;
                        value.produtos.map(function(v, k){
                            t[value.id] += parseFloat(v.valor_unitario) * parseFloat(v.pivot.quantidade);
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
