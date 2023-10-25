<template>
    <div class="page-content">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <router-link
                v-if="useStore.token != 0"
                class="navbar-brand"
                :to="{ name: 'Dashboard' }"
                >Dashboard</router-link
            >
            <router-link
                v-if="useStore.token == 0"
                class="navbar-brand"
                :to="{ name: 'Home' }"
                >Home</router-link
            >
            <button
                class="navbar-toggler"
                type="button"
                data-toggle="collapse"
                data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent"
                aria-expanded="false"
                aria-label="Toggle navigation"
            >
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active" v-if="useStore.token != 0">
                        <router-link
                            class="navbar-brand"
                            :to="{ name: 'Property' }"
                            >Demo</router-link
                        >
                    </li>
                </ul>

                <form class="form-inline my-2 my-lg-0">
                    <router-link  v-if="useStore.token == 0" class="navbar-brand" :to="{ name: 'Register' }"
                        >Register</router-link
                    >
                    <router-link  v-if="useStore.token == 0" class="navbar-brand" :to="{ name: 'Login' }"
                        >Login</router-link
                    >
                    <button
                        class="my-2 my-sm-0"
                        type="submit"
                        v-if="useStore.token != 0"
                        @click="logout"
                    >
                        Logout
                    </button>
                </form>
            </div>
        </nav>
        <router-view></router-view>
    </div>
</template>
<script setup>
import toastr from "toastr";
import "toastr/toastr.scss";
import { UserStore } from "../stores/UserStore";
import { useRouter } from "vue-router";

const useStore = UserStore();
const router = useRouter();

let logout = () => {
    useStore.removeToken();
    router.push({ name: "Home" });
    toastr.success("Successfully Logout..", "Success");
};
</script>
<style>
.page-content {
    position: relative;
    overflow: hidden;
}
.logout {
    cursor: pointer;
}
</style>
