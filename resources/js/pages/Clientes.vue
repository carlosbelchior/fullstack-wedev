<template>
    <div class="container">

        <router-link class="btn btn-primary mb-3" to="/clientes/gerenciar/">+ Novo cliente</router-link>

        <VTable class="table table-striped table-responsive table-bordered"
        :data="clientes"
        :filters="filters"
        :page-size="20"
        v-model:currentPage="currentPage"
        @totalPagesChanged="totalPages = $event"
        >
            <template #head>
                <tr>
                    <VTh class="col-1" sortKey="id">ID</VTh>
                    <VTh class="col-3" sortKey="nome">Nome</VTh>
                    <VTh class="col-2" sortKey="cpf">CPF</VTh>
                    <VTh class="col-4" sortKey="email">E-mail</VTh>
                    <th class="col-2">Ação</th>
                </tr>
            </template>
            <template #body="{rows}">
                <tr>
                    <td><input type="text" class="form-control form-control-sm" autocomplete="false" v-model="filters.id.value"/></td>
                    <td><input type="text" class="form-control form-control-sm" autocomplete="false" v-model="filters.nome.value"/></td>
                    <td><input type="text" class="form-control form-control-sm" autocomplete="false" v-model="filters.cpf.value"/></td>
                    <td><input type="text" class="form-control form-control-sm" autocomplete="false" v-model="filters.email.value"/></td>
                    <td></td>
                </tr>
                <tr v-for="row in rows" :key="row.id">
                    <td>{{ row.id }}</td>
                    <td>{{ row.nome }}</td>
                    <td>{{ row.cpf }}</td>
                    <td>{{ row.email }}</td>
                    <td>
                        <router-link class="btn btn-primary btn-sm" :to="{ name: 'clientes-formulario', params: { id: row.id }}">Editar</router-link>
                        <button class="btn btn-danger btn-sm mx-2" @click="excluirCliente(row.id)">Excluir</button>
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
    export default {
        data: () => ({
            filters: {
                id: { value: '', keys: ['id'] },
                nome: { value: '', keys: ['nome'] },
                cpf: { value: '', keys: ['cpf'] },
                email: { value: '', keys: ['email'] },
            },
            totalPages: 1,
            currentPage: 1
        }),

        setup() {
            const store = useStore();

            const clientes = computed(() => store.state.cliente.clientes);

            function excluirCliente(cliente_id) {

                var $this = this;
                let resposta = axios.get('/api/clientes/exclusao/' + cliente_id).then(function (response) {
                    Swal.fire('Feito!', 'Cliente excluido com sucesso!', 'success')
                    store.commit("cliente/fetchClientes");
                    store.commit("pedido/fetchPedidos");
                }).catch(function (error) {
                    Swal.fire('Opa!', 'Erro ao excluir o cliente!', 'error')
                    console.error(error);
                    store.commit("cliente/fetchClientes");
                    store.commit("pedido/fetchPedidos");
                });

                console.log(resposta)

            }

            return {
                clientes,
                excluirCliente
            };
        },
    };
</script>

<style lang="scss" scoped>
</style>
