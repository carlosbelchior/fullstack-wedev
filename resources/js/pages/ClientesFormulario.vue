<template>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">

            <b-alert show dismissible variant="danger" v-if="cliente.erro">Cliente não encontrado!</b-alert>

            <div class="card">
                <div class="card-header">
                    Gerenciar cliente
                </div>

                <div class="card-body">
                    <form method="POST">

                        <div class="row mb-3">
                            <label class="col-md-3 col-form-label text-md-end">Nome</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="nome" required autocomplete="false" autofocus v-model="cliente.nome">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-md-3 col-form-label text-md-end">CPF</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="cpf" required autocomplete="false" autofocus v-model="cliente.cpf">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-md-3 col-form-label text-md-end">E-mail</label>
                            <div class="col-md-6">
                                <input type="email" class="form-control" name="email" required autocomplete="false" autofocus  v-model="cliente.email">
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
    import { computed, onBeforeMount, onMounted } from "vue";
    import { useRoute } from "vue-router";
    import { useStore } from "vuex";
    export default {
    setup() {
        //   posts are loaded from init function
        const store = useStore();
        const route = useRoute();
        const cliente = computed(() => {
            if(store.state.cliente.clientes.find(todo => todo.id == route.params.id))
                return store.state.cliente.clientes.find(todo => todo.id == route.params.id)
            else
                return { nome: '', cpf: '', email: '', erro: true }
        })
        return {
            cliente,
            route
        };
    },
    };
</script>

<style lang="scss" scoped>
</style>
