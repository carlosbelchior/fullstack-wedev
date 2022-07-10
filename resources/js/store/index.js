import { createStore } from "vuex";

import titles from "./modules/titles";
import cliente from "./modules/cliente";
import produto from "./modules/produto";
import pedido from "./modules/pedido";

const store = createStore({
    modules: {
        titles,
        cliente,
        produto,
        pedido,
    },
});

export default store;
