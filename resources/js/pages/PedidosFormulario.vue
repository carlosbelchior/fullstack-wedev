<template>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">

            {{ pedido }}

            <b-alert show dismissible variant="danger" v-if="form.erro">Pedido não encontrado!</b-alert>

            <b-alert show dismissible variant="danger" v-if="form.erroValidacao" v-for="erro in form.erroValidacao">{{ erro[0] }}</b-alert>

            <div class="card">
                <div class="card-header">
                    Gerenciar pedido
                </div>

                <div class="card-body">
                    <form method="POST" @submit.prevent="salvarPedido()">

                        <div class="row mb-3">
                            <label class="col-md-3 col-form-label text-md-end">Cliente <span class="text-danger">*</span></label>
                            <div class="col-md-6">
                                <select class="form-select" name="cliente" v-model="form.cliente_id">
                                    <option value="">Selecione um cliente</option>
                                    <option v-for="cli in clientes" :value="cli.id">{{ cli.nome }}</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-5">
                            <label class="col-md-3 col-form-label text-md-end">Data <span class="text-danger">*</span></label>
                            <div class="col-md-6">
                                <input type="date" class="form-control" name="nome" required autocomplete="false" autofocus v-model="form.data_pedido">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-5">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label text-md-end">Produto <span class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        <select class="form-select" name="produto">
                                            <option value="">Selecione um produto</option>
                                            <option v-for="prod in produtos" value="{{ prod.id }}">{{ prod.nome }}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group row">
                                    <label class="col-md-6 col-form-label text-md-end">Quantidade <span class="text-danger">*</span></label>
                                    <div class="col-md-6">
                                        <input type="number" min="1" class="form-control" name="quantidade" autocomplete="false" autofocus>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3 text-md-end">
                                <button type="button" class="btn btn-primary">
                                    Adicionar produto
                                </button>
                            </div>
                        </div>

                        <div class="row mb-5">
                            <b-table
                            striped
                            hover
                            responsive="sm"
                            :fields="fields"
                            :items="form.produtos_pedido">
                                <template #cell(id)="data">
                                    {{ data.item.id }}
                                </template>

                                <template #cell(nome)="data">
                                    {{ data.item.nome }}
                                </template>

                                <template #cell(cod_barras)="data">
                                    {{ data.item.cod_barras }}
                                </template>

                                <template #cell(quantidade)="data">
                                    {{ data.item.pivot.quantidade }}
                                </template>

                                <template v-slot:cell(acao)="{ item }">
                                    <button class="btn btn-danger btn-sm" @click="excluirProduto(item.id)">Excluir</button>
                                </template>
                            </b-table>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-3 offset-md-5">
                                <button type="submit" class="btn btn-primary">
                                    Salvar pedido
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</template>

<script>
    import { computed, reactive } from "vue";
    import { useRoute } from "vue-router";
    import { useStore } from "vuex";
    import axios from "axios";
    import Swal from 'sweetalert2';

    export default {
        setup() {
            //   posts are loaded from init function
            const store = useStore();
            const route = useRoute();

            const form = reactive({
                id: '',
                data_pedido: '',
                cliente_id: '',
                produtos_pedido: [],
                erro: false,
                erroValidacao: null
            })

            const clientes = computed(() => store.state.cliente.clientes);
            const produtos = computed(() => store.state.produto.produtos);

            const pedido = computed(() => {
                form.id = '';
                form.data_pedido = '';
                form.cliente_id = '';
                form.erroValidacao = null;
                form.erro = false;

                if(route.params.id === ""){}
                else if(route.params.id != "" && store.state.pedido.pedidos.find(todo => todo.id == route.params.id))
                {
                    form.id = store.getters['pedido/getPedido'](parseInt(route.params.id)).id;
                    form.cliente_id = store.getters['pedido/getPedido'](parseInt(route.params.id)).cliente_id;
                    form.produtos_pedido = store.getters['pedido/getPedido'](parseInt(route.params.id)).produtos;
                    console.log(store.getters['pedido/getPedido'](parseInt(route.params.id)).produtos);
                    form.data_pedido = store.getters['pedido/getPedido'](parseInt(route.params.id)).data_pedido;
                }
                else
                    form.erro = true;
            })

            function salvarCliente() {

                var $this = this;
                form.erroValidacao = null;
                form.erro = false;

                if(!this.form.id)
                    axios.post('/api/clientes/cadastro', this.form).then(function (response) {
                        $this.form.id = '';
                        $this.form.nome = '';
                        $this.form.cpf = '';
                        $this.form.email = '';
                        Swal.fire('Feito!', 'Cliente cadastrado com sucesso!', 'success')
                        store.commit("cliente/fetchClientes");
                    }).catch(function (error) {
                        $this.form.erroValidacao = error.response.data.mensagem
                    });
                else
                    axios.post('/api/clientes/atualizar/' + this.form.id, this.form).then(function (response) {
                        Swal.fire('Feito!', 'Cliente atualizado com sucesso!', 'success')
                        store.commit("cliente/fetchClientes");
                    }).catch(function (error) {
                        $this.form.erroValidacao = error.response.data.mensagem
                    });

                console.log($this.form.sucessoAtualizacao);
			}

            return {
                store,
                form,
                clientes,
                produtos,
                pedido,
                route,
                salvarCliente,
                fields: [
                    { key: 'id', label: 'ID', sortable: true },
                    { key: 'nome', label: 'Nome', sortable: true },
                    { key: 'cod_barras', label: 'Código de barras', sortable: true },
                    { key: 'quantidade', label: 'Quantidade', sortable: true },
                    { key: 'acao',label: 'Ação', sortable: false }
                ],
            };
        },
    };
</script>

<style lang="scss" scoped>
</style>
