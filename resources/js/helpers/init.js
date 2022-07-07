import store from "../store";

const init = () => {
    store.commit("cliente/fetchClientes");
};

export default init;
