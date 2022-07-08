import axios from "axios";

const state = {
    loading: false,
    clientes: [],
};

const getters = {
    getCliente: (state) => (id) => {
        return state.clientes.find(todo => todo.id === id)
    }
}

const mutations = {
    async fetchClientes(state) {
        axios.get("/api/clientes/todos")
            .then((response) => {
                state.clientes = response.data.cliente;
            })
            .catch((err) => console.log(err));
    },
};

export default {
    namespaced: true,
    state,
    mutations,
    getters
};
