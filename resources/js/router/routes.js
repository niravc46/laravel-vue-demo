import dashboard from "../pages/dashboard.vue";
import home from "../pages/home.vue";
import property from "../components/property/PropertyComponent.vue";
import AddProperty from "../components/property/AddPropertyComponent.vue";
import EditProperty from "../components/property/EditPropertyComponent.vue";
import Register from "../pages/register.vue";
import Login from "../pages/login.vue";

const routes = [
    {
        path: "/",
        name: "Home",
        component: home,
    },
    {
        path: "/dashboard",
        name: "Dashboard",
        component: dashboard,
        meta: {
            requiresAuth: true,
        },
    },
    {
        path: "/property",
        name: "Property",
        component: property,
        meta: {
            requiresAuth: true,
        },
    },
    {
        path: "/property/create",
        name: "AddProperty",
        component: AddProperty,
        meta: {
            requiresAuth: true,
        },
    },
    {
        path: "/property/edit/:id",
        name: "EditProperty",
        component: EditProperty,
        meta: {
            requiresAuth: true,
        },
    },
    {
        path: "/register",
        name: "Register",
        component: Register,
        meta: {
            requiresAuth: false,
        },
    },
    {
        path: "/login",
        name: "Login",
        component: Login,
        meta: {
            requiresAuth: false,
        },
    },
];
export default routes;
