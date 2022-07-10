<template>
  <div class="container">

    <router-link class="btn btn-primary mb-3" to="/produtos/gerenciar/">+ Novo produto</router-link>

    <VTable class="table table-striped table-responsive table-bordered"
        :data="produtos"
        :filters="filters"
        :page-size="20"
        v-model:currentPage="currentPage"
        @totalPagesChanged="totalPages = $event"
        >
            <template #head>
                <tr>
                    <VTh class="col-1" sortKey="id">ID</VTh>
                    <VTh class="col-4" sortKey="nome">Nome</VTh>
                    <VTh class="col-4" sortKey="nome">Código de barras</VTh>
                    <VTh class="col-1" sortKey="cpf">Valor</VTh>
                    <th class="col-2">Ação</th>
                </tr>
            </template>
            <template #body="{rows}">
                <tr>
                    <td><input type="text" class="form-control form-control-sm" autocomplete="false" v-model="filters.id.value"/></td>
                    <td><input type="text" class="form-control form-control-sm" autocomplete="false" v-model="filters.nome.value"/></td>
                    <td><input type="text" class="form-control form-control-sm" autocomplete="false" v-model="filters.cod_barras.value"/></td>
                    <td><input type="text" class="form-control form-control-sm" autocomplete="false" v-model="filters.valor.value"/></td>
                    <td></td>
                </tr>
                <tr v-for="row in rows" :key="row.id">
                    <td>{{ row.id }}</td>
                    <td>{{ row.nome }}</td>
                    <td>{{ row.cod_barras }}</td>
                    <td>{{ row.valor_unitario }}</td>
                    <td>
                        <router-link class="btn btn-primary btn-sm" :to="{ name: 'produtos-formulario', params: { id: row.id }}">Editar</router-link>
                        <button class="btn btn-danger btn-sm mx-2" @click="excluirProduto(row.id)">Excluir</button>
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
    import init from '../helpers/init';
    export default {
        data: () => ({
            filters: {
                id: { value: '', keys: ['id'] },
                nome: { value: '', keys: ['nome'] },
                cod_barras: { value: '', keys: ['nome'] },
                valor: { value: '', keys: ['valor'] },
            },
            totalPages: 1,
            currentPage: 1
        }),

        setup() {
            const store = useStore();

            const produtos = computed(() => store.state.produto.produtos);

            function excluirProduto(produto_id) {

                var $this = this;
                axios.get('/api/produtos/exclusao/' + produto_id).then(function (response) {
                    Swal.fire('Feito!', 'Produto excluido com sucesso!', 'success')
                    store.commit("produto/fetchProdutos");
                }).catch(function (error) {
                    Swal.fire('Opa!', 'Erro ao excluir o produto!', 'danger')
                    console.error(error);
                    store.commit("produto/fetchProdutos");
                });

                init();
            }

            return {
                produtos,
                excluirProduto,
            };
        },
    };
</script>

<style lang="scss" scoped>
</style>
