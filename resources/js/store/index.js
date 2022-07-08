import { createStore } from "vuex";

import titles from "./modules/titles";
import cliente from "./modules/cliente";

const store = createStore({
    modules: {
        titles,
        cliente
    },
});

export default store;
