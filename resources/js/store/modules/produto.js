import axios from "axios";

const state = {
    loading: false,
    produtos: [],
};

const getters = {
    getProduto: (state) => (id) => {
        return state.produtos.find(todo => todo.id === id)
    }
}

const mutations = {
    async fetchProdutos(state) {
        axios.get("/api/produtos/todos")
            .then((response) => {
                state.produtos = response.data.produto;
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
