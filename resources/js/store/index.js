import { createStore } from "vuex";

import titles from "./modules/titles";
import cliente from "./modules/cliente";
import produto from "./modules/produto";

const store = createStore({
    modules: {
        titles,
        cliente,
        produto,
    },
});

export default store;
