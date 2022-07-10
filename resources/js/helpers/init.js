import store from "../store";

const init = () => {
    store.commit("cliente/fetchClientes");
    store.commit("produto/fetchProdutos");
    store.commit("pedido/fetchPedidos");
};

export default init;
