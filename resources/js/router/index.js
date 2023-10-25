import { createRouter, createWebHistory } from "vue-router";
import routes from "./routes";
import { UserStore } from "../stores/UserStore";

const router = createRouter({
    history: createWebHistory(),
    routes,
});

router.beforeEach((to, from) => {
    const store = UserStore();

    if (to.meta.requiresAuth && store.token == 0) {
        return { name: "Login" };
    }
    if (to.meta.requiresAuth == false && store.token != 0) {
        return { name: "Dashboard" };
    }
});

export default router;
