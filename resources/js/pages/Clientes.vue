<template>
  <div class="container">
    <router-link class="btn btn-primary mb-3" to="/clientes/gerenciar/">+ Novo cliente</router-link>
    <b-table
        striped
        hover
        responsive="sm"
        :items="clientes"
        :fields="fields"
        :sort-by.sync="sortBy"
        :sort-desc.sync="sortDesc"
        sort-icon-left>
        <template v-slot:cell(acao)="{ item }">
            <router-link class="btn btn-primary btn-sm" :to="{ name: 'clientes-formulario', params: { id: item.id }}">Editar</router-link>
        </template>
    </b-table>
  </div>
</template>

<script>
import { computed, onBeforeMount, onMounted } from "vue";
import { useStore } from "vuex";
export default {
  setup() {
    //   posts are loaded from init function
    const store = useStore();
    const clientes = computed(() => store.state.cliente.clientes);
    onMounted(() => {});
    return {
        sortBy: 'id',
        sortDesc: false,
        fields: [
          { key: 'id', label: 'ID', sortable: true },
          { key: 'nome', label: 'Nome', sortable: true },
          { key: 'cpf', label: 'CPF', sortable: true },
          { key: 'email', label: 'E-mail', sortable: true },
          { key: 'acao',label: 'Ação', sortable: false }
        ],
        clientes
    };
  },
};
</script>

<style lang="scss" scoped>
</style>
