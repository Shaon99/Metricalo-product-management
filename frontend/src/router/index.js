import { createRouter, createWebHistory } from "vue-router";
import Login from "../components/auth/Login.vue";
import Register from "../components/auth/Register.vue";
import Dashboard from "../components/Dashboard.vue";
import NotFound from "../components/NotFound.vue";
import Products from "../components/product/List.vue";
import Customers from "../components/customer/List.vue";
import Orders from "../components/order/List.vue";
import CreateOrder from "../components/order/CreateOrder.vue";
import OrderDetails from "../components/order/OrderDetails.vue";
import EditOrder from "../components/order/EditOrder.vue";
import { useAuthStore } from "../stores/authStore";

const routes = [
  {
    path: "/",
    name: "Login",
    component: Login,
    meta: { requiresAuth: false },
  },
  {
    path: "/register",
    name: "Register",
    component: Register,
    meta: { requiresAuth: false },
  },
  {
    path: "/dashboard",
    name: "Dashboard",
    component: Dashboard,
    meta: { requiresAuth: true },
  },
  {
    path: "/products",
    name: "Products",
    component: Products,
    meta: { requiresAuth: true },
  },
  {
    path: "/customers",
    name: "Customers",
    component: Customers,
    meta: { requiresAuth: true },
  },
  {
    path: "/orders",
    name: "Orders",
    component: Orders,
    meta: { requiresAuth: true },
  },
  {
    path: "/create-order",
    name: "createOrder",
    component: CreateOrder,
    meta: { requiresAuth: true },
  },
  {
    path: "/order-details/:id",
    name: "OrderDetails",
    component: OrderDetails,
    meta: { requiresAuth: true },
  },
  {
    path: "/order-edit/:id",
    name: "EditOrder",
    component: EditOrder,
    meta: { requiresAuth: true },
  },
  {
    path: "/:catchAll(.*)",
    component: NotFound,
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

router.beforeEach(async (to, from, next) => {
  const authStore = useAuthStore();
  authStore.formErrors = {};

  if (to.meta.requiresAuth) {
    if (!authStore.token) {
      return next({ name: "Login" });
    }

    if (!authStore.user) {
      await authStore.getUser();
    }
    
  } else if (authStore.token) {
    if (to.name === "Login" || to.name === "Register") {
      return next({ name: "Dashboard" });
    }
  }
  next();
});

export default router;
