import store from "../store";

const init = () => {
    store.commit("cliente/fetchClientes");
    store.commit("produto/fetchProdutos");
};

export default init;
