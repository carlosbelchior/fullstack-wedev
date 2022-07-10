<template>
  <div class="container">

    <router-link class="btn btn-primary mb-3" to="/produtos/gerenciar/">+ Novo produto</router-link>
    <b-table
        striped
        hover
        responsive="sm"
        :items="produtos"
        :fields="fields"
        :sort-by.sync="sortBy"
        :sort-desc.sync="sortDesc"
        sort-icon-left>
        <template v-slot:cell(acao)="{ item }">
            <router-link class="btn btn-primary btn-sm" :to="{ name: 'produtos-formulario', params: { id: item.id }}">Editar</router-link>
            <button class="btn btn-danger btn-sm mx-2" @click="excluirProduto(item.id)">Excluir</button>
        </template>
    </b-table>
  </div>
</template>

<script>
    import { computed } from "vue";
    import { useStore } from "vuex";
    import axios from "axios";
    import Swal from 'sweetalert2'
    import init from '../helpers/init';
    export default {
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
                sortBy: 'id',
                sortDesc: false,
                fields: [
                    { key: 'id', label: 'ID', sortable: true },
                    { key: 'nome', label: 'Nome', sortable: true },
                    { key: 'cod_barras', label: 'Código de barras', sortable: true },
                    { key: 'valor_unitario', label: 'Valor', sortable: true },
                    { key: 'acao',label: 'Ação', sortable: false }
                ],
                produtos,
                excluirProduto,
            };
        },
    };
</script>

<style lang="scss" scoped>
</style>
