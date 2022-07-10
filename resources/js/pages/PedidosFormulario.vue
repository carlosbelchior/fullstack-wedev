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
                                <select class="form-select" name="cliente" required v-model="form.cliente_id">
                                    <option value="">Selecione um cliente</option>
                                    <option v-for="cli in clientes" :value="cli.id">{{ cli.nome }}</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <label class="col-md-3 col-form-label text-md-end">Data <span class="text-danger">*</span></label>
                            <div class="col-md-6">
                                <input type="date" class="form-control" name="nome" required autocomplete="false" autofocus v-model="form.data_pedido">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-md-3 col-form-label text-md-end">Status <span class="text-danger">*</span></label>
                            <div class="col-md-6">
                                <select class="form-select" name="cliente" required v-model="form.status">
                                    <option value="1">Em aberto</option>
                                    <option value="2">Pago</option>
                                    <option value="3">Cancelado</option>
                                </select>
                            </div>
                        </div>

                        <hr class="mb-4" style="height:5px">

                        <div class="row mb-3">
                            <div class="col-sm-5">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label text-md-end">Produto <span class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        <select class="form-select" name="produto" v-model="formProduto.produto_id">
                                            <option value="">Selecione um produto</option>
                                            <option v-for="prod in produtos" :value="prod.id">{{ prod.nome }}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group row">
                                    <label class="col-md-6 col-form-label text-md-end">Quantidade <span class="text-danger">*</span></label>
                                    <div class="col-md-6">
                                        <input type="number" min="1" class="form-control" name="quantidade" autocomplete="false" autofocus  v-model="formProduto.quantidade">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3 text-md-end">
                                <button type="button" class="btn btn-primary" @click="adicionaProduto()">
                                    Adicionar produto
                                </button>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <b-table
                            striped
                            hover
                            responsive="sm"
                            :fields="fields"
                            :items="form.produtos_pedido">

                                <template #cell(nome)="data">
                                    {{ data.item.nome }}  - <router-link target="_blank" class="" :to="{ name: 'produtos-formulario', params: { id: data.item.id }}">Ver produto</router-link>
                                </template>

                                <template #cell(cod_barras)="data">
                                    {{ data.item.cod_barras }}
                                </template>

                                <template #cell(valor)="data">
                                    {{ data.item.valor_unitario }}
                                </template>

                                <template #cell(quantidade)="data">
                                    {{ data.item.pivot.quantidade }}
                                </template>

                                <template #cell(total)="data">
                                    {{ (data.item.pivot.quantidade * data.item.valor_unitario).toFixed(2) }}
                                </template>

                                <template v-slot:cell(acao)="{ item }">
                                    <button type="button" class="btn btn-danger btn-sm" @click="removeProduto(item)">Excluir</button>
                                </template>
                            </b-table>
                        </div>

                        <div class="row mb-5">
                            <div class="col-md-12 text-center">
                                <b>Total do pedido: {{ totalPedido }}</b>
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-12 text-center">
                                <button type="submit" class="btn btn-success">
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
                cliente_id: '',
                data_pedido: '',
                status: 1,
                produtos_pedido: [],
                erro: false,
                erroValidacao: null
            })

            const formProduto = reactive({
                produto_id: '',
                quantidade: 1
            })

            const clientes = computed(() => store.state.cliente.clientes);
            const produtos = computed(() => store.state.produto.produtos);

            const totalPedido = computed(() => {
                let t = 0;
                form.produtos_pedido.map(function(value, key){
                    t += value.valor_unitario * value.pivot.quantidade;
                });
                return t;
            });

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
                    form.data_pedido = store.getters['pedido/getPedido'](parseInt(route.params.id)).data_pedido;
                    form.status = store.getters['pedido/getPedido'](parseInt(route.params.id)).status;
                    form.produtos_pedido = store.getters['pedido/getPedido'](parseInt(route.params.id)).produtos;
                }
                else
                    form.erro = true;
            })

            function adicionaProduto() {
                if(formProduto.produto_id === '')
                    Swal.fire('Opa!', 'Selecione um produto para adicioná-lo na lista!', 'error')
                else
                {
                    // Verifica se já foi adicionado um produto igual
                    let item_lista = form.produtos_pedido.map(p => p.nome).indexOf(
                        store.getters['produto/getProduto'](parseInt(formProduto.produto_id)).nome
                    );
                    if(!item_lista)
                        Swal.fire('Opa!', 'Este produto já foi adicionado!', 'error')
                    else
                    {
                        let prod_cad = store.getters['produto/getProduto'](parseInt(formProduto.produto_id));
                        form.produtos_pedido.push(
                            {
                                "id": prod_cad.id,
                                "nome": prod_cad.nome,
                                "valor_unitario": prod_cad.valor_unitario,
                                "cod_barras": prod_cad.cod_barras,
                                "pivot": {
                                    "produto_id": formProduto.produto_id,
                                    "quantidade": formProduto.quantidade,
                                }
                            }
                        );
                    }
                }
            }

            function removeProduto(item) {
                let produto = form.produtos_pedido.indexOf(item);
                form.produtos_pedido.splice(produto, 1);
            }

            function salvarPedido() {

                var $this = this;
                form.erroValidacao = null;
                form.erro = false;

                if(!this.form.id)
                    axios.post('/api/pedidos/cadastro', this.form).then(function (response) {
                        $this.form.id = '';
                        $this.form.cliente_id = '';
                        $this.form.data_pedido = '';
                        $this.form.produtos_pedido = [];
                        Swal.fire('Feito!', 'Pedido cadastrado com sucesso!', 'success')
                        store.commit("pedido/fetchPedidos");
                    }).catch(function (error) {
                        $this.form.erroValidacao = error.response.data.mensagem
                    });
                else
                    axios.post('/api/pedidos/atualizar/' + this.form.id, this.form).then(function (response) {
                        Swal.fire('Feito!', 'Pedido atualizado com sucesso!', 'success')
                        store.commit("pedido/fetchPedidos");
                    }).catch(function (error) {
                        $this.form.erroValidacao = error.response.data.mensagem
                    });
			}

            return {
                store,
                form,
                fields: [
                    { key: 'nome', label: 'Produto', sortable: true },
                    { key: 'cod_barras', label: 'Código de barras', sortable: true },
                    { key: 'valor_unitario', label: 'Valor', sortable: true },
                    { key: 'quantidade', label: 'Quantidade', sortable: true },
                    { key: 'total', label: 'Total', sortable: true },
                    { key: 'acao',label: 'Ação', sortable: false }
                ],
                clientes,
                produtos,
                pedido,
                route,
                adicionaProduto,
                removeProduto,
                salvarPedido,
                formProduto,
                totalPedido
            };
        },
    };
</script>

<style lang="scss" scoped>
</style>
