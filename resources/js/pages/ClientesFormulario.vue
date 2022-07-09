<template>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">

            {{ cliente }}

            <b-alert show dismissible variant="danger" v-if="form.erro">Cliente não encontrado!</b-alert>

            <b-alert show dismissible variant="danger" v-if="form.erroValidacao" v-for="erro in form.erroValidacao">{{ erro[0] }}</b-alert>

            <div class="card">
                <div class="card-header">
                    Gerenciar cliente
                </div>

                <div class="card-body">
                    <form method="POST" @submit.prevent="salvarCliente()">

                        <div class="row mb-3">
                            <label class="col-md-3 col-form-label text-md-end">Nome <span class="text-danger">*</span></label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="nome" required autocomplete="false" autofocus v-model="form.nome">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-md-3 col-form-label text-md-end">CPF <span class="text-danger">*</span></label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="cpf" required autocomplete="false" autofocus v-model="form.cpf">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-md-3 col-form-label text-md-end">E-mail</label>
                            <div class="col-md-6">
                                <input type="email" class="form-control" name="email" autocomplete="false" autofocus v-model="form.email">
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-3 offset-md-5">
                                <button type="submit" class="btn btn-primary">
                                    Salvar cliente
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
    import Swal from 'sweetalert2'
    export default {
        setup() {
            //   posts are loaded from init function
            const store = useStore();
            const route = useRoute();

            const form = reactive({
                id: '',
                nome: '',
                cpf: '',
                email: '',
                erro: false,
                erroValidacao: null
            })

            const cliente = computed(() => {
                form.erroValidacao = null;
                form.erro = false;

                if(route.params.id === ""){}
                else if(route.params.id != "" && store.state.cliente.clientes.find(todo => todo.id == route.params.id))
                {
                    form.id = store.state.cliente.clientes.find(todo => todo.id == route.params.id).id;
                    form.nome = store.state.cliente.clientes.find(todo => todo.id == route.params.id).nome;
                    form.cpf = store.state.cliente.clientes.find(todo => todo.id == route.params.id).cpf;
                    form.email = store.state.cliente.clientes.find(todo => todo.id == route.params.id).email;
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
                cliente,
                route,
                salvarCliente,
            };
        },
    };
</script>

<style lang="scss" scoped>
</style>
