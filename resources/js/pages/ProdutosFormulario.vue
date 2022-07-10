<template>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">

            {{ produto }}

            <b-alert show dismissible variant="danger" v-if="form.erro">Produto não encontrado!</b-alert>

            <b-alert show dismissible variant="danger" v-if="form.erroValidacao" v-for="erro in form.erroValidacao">{{ erro[0] }}</b-alert>

            <div class="card">
                <div class="card-header">
                    Gerenciar produto
                </div>

                <div class="card-body">
                    <form method="POST" @submit.prevent="salvarproduto()">

                        <div class="row mb-3">
                            <label class="col-md-3 col-form-label text-md-end">Nome <span class="text-danger">*</span></label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="nome" required autocomplete="false" autofocus v-model="form.nome">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-md-3 col-form-label text-md-end">Código de barras <span class="text-danger">*</span></label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" minlength="20" maxlength="20" name="cod_barras" required autocomplete="false" autofocus v-model="form.cod_barras">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-md-3 col-form-label text-md-end">Preço <span class="text-danger">*</span></label>
                            <div class="col-md-6">
                                <input class="form-control" minlength="20" maxlength="20" name="preco" required autocomplete="false" autofocus v-model.lazy="form.valor_unitario" v-money3="config">
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-12 text-center">
                                <button type="submit" class="btn btn-success">
                                    Salvar produto
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
    import { computed, onMounted, reactive } from "vue";
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
                nome: '',
                cod_barras: '',
                valor_unitario: '',
                erro: false,
                erroValidacao: null
            })

            const produto = computed(() => {
                form.erroValidacao = null;
                form.erro = false;

                if(route.params.id === ""){}
                else if(route.params.id != "" && store.state.produto.produtos.find(todo => todo.id == route.params.id))
                {
                    form.id = store.state.produto.produtos.find(todo => todo.id == route.params.id).id;
                    form.nome = store.state.produto.produtos.find(todo => todo.id == route.params.id).nome;
                    form.cod_barras = store.state.produto.produtos.find(todo => todo.id == route.params.id).cod_barras;
                    form.valor_unitario = store.state.produto.produtos.find(todo => todo.id == route.params.id).valor_unitario;
                }
                else
                    form.erro = true;
            })

            function salvarproduto() {

                var $this = this;
                form.erroValidacao = null;
                form.erro = false;

                if(!this.form.id)
                    axios.post('/api/produtos/cadastro', this.form).then(function (response) {
                        $this.form.id = '';
                        $this.form.nome = '';
                        $this.form.cod_barras = '';
                        $this.form.valor_unitario = '';
                        Swal.fire('Feito!', 'Produto cadastrado com sucesso!', 'success')
                        store.commit("produto/fetchProdutos");
                    }).catch(function (error) {
                        $this.form.erroValidacao = error.response.data.mensagem
                    });
                else
                    axios.post('/api/produtos/atualizar/' + this.form.id, this.form).then(function (response) {
                        Swal.fire('Feito!', 'Produto atualizado com sucesso!', 'success')
                        store.commit("produto/fetchProdutos");
                    }).catch(function (error) {
                        $this.form.erroValidacao = error.response.data.mensagem
                    });
			}

            return {
                store,
                form,
                produto,
                route,
                salvarproduto,
                config: {
                    prefix: '',
                    suffix: '',
                    thousands: '',
                    decimal: '.',
                    precision: 2,
                    disableNegative: true,
                    disabled: false,
                    min: 0.00,
                    max: 9999999999.99,
                    allowBlank: false,
                    minimumNumberOfCharacters: 1,
                }
            };
        },

    };
</script>

<style lang="scss" scoped>
</style>
