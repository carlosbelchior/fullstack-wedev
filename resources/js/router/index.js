import { createRouter, createWebHistory } from "vue-router";

// Views
import Dashboard from "../pages/Dashboard.vue";
import Clientes from "../pages/Clientes.vue";
import ClientesFormulario from "../pages/ClientesFormulario.vue";
import Produtos from "../pages/Produtos.vue";
import ProdutosFormulario from "../pages/ProdutosFormulario.vue";
import Pedidos from "../pages/Pedidos.vue";
import PedidosFormulario from "../pages/PedidosFormulario.vue";

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
        path: "/produtos/gerenciar/:id?",
        component: ProdutosFormulario,
        name: "produtos-formulario",
        meta: {
            title: "Gerenciar Produto",
        },
    },
    {
        path: "/pedidos",
        component: Pedidos,
        name: "pedidos",
        meta: {
            title: "Pedidos",
        },
    },
    {
        path: "/pedidos/gerenciar/:id?",
        component: PedidosFormulario,
        name: "pedidos-formulario",
        meta: {
            title: "Gerenciar Pedido",
        },
    },
];

const router = createRouter({
    history,
    routes,
});

export default router;
