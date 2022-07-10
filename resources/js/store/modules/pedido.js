import axios from "axios";

const state = {
    loading: false,
    pedidos: [],
};

const getters = {
    getPedido: (state) => (id) => {
        return state.pedidos.find(todo => todo.id === id)
    }
}

const mutations = {
    async fetchPedidos(state) {
        axios.get("/api/pedidos/todos")
            .then((response) => {
                state.pedidos = response.data.pedido;
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
