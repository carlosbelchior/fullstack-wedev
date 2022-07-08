import { createRouter, createWebHistory } from "vue-router";

// Views
import Dashboard from "../pages/Dashboard.vue";
import Clientes from "../pages/Clientes.vue";
import ClientesFormulario from "../pages/ClientesFormulario.vue";
import Produtos from "../pages/Produtos.vue";
import Pedidos from "../pages/Pedidos.vue";

// WebHistory
const history = createWebHistory();

const routes = [
    {
        path: "/",
        component: Dashboard,
        name: "dashboard",
        meta: {
            title: "Dashboard",
        },
    },
    {
        path: "/clientes",
        component: Clientes,
        name: "clientes",
        meta: {
            title: "Clientes",
        },
    },
    {
        path: "/clientes/gerenciar/:id?",
        component: ClientesFormulario,
        name: "clientes-formulario",
        meta: {
            title: "Gerenciar Cliente",
        },
    },
    {
        path: "/produtos",
        component: Produtos,
        name: "produtos",
        meta: {
            title: "Produtos",
        },
    },
    {
        path: "/posts",
        component: Pedidos,
        name: "pedidos",
        meta: {
            title: "Pedidos",
        },
    },
];

const router = createRouter({
    history,
    routes,
});

export default router;
