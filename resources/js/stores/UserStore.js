import { defineStore } from "pinia";
import axios from "axios";
import NProgress from "nprogress";
import toastr from "toastr";
import "toastr/toastr.scss";

export const UserStore = defineStore({
    id: "UserStoreId",
    state: () => ({
        token: localStorage.getItem("token") || 0,
    }),     

    getters: {
        getToken: (state) => state.token,
    },
    actions: {
        async registerUser(register_form_data, axiosConfig) {
            NProgress.start();
            console.log(register_form_data, axiosConfig);
            await axios
                .post("/api/register", register_form_data, axiosConfig)
                .then((response) => {
                    if (response.data.status == "Error") {
                        if (response.data.data.length > 0) {
                            toastr.error(
                                response.data.data.join("</br>"),
                                "Error"
                            );
                        } else {
                            toastr.error(response.data.message, "Error");
                        }
                    } else {
                        toastr.success(response.data.message, "Success");
                    }
                })
                .catch((e) => {
                    if (e.response.status === 422) {
                        strError.value = e.response.data.errors;
                    }
                })
                .then(() => {
                    NProgress.done();
                });
        },
        async loginUser(login_form_data, axiosConfig) {
            NProgress.start();
            await axios
                .post("/api/login", login_form_data, axiosConfig)
                .then((response) => {
                    if (response.data.status == "Error") {
                        if (response.data.data.length > 0) {
                            toastr.error(
                                response.data.data.join("</br>"),
                                "Error"
                            );
                        } else {
                            toastr.error(response.data.message, "Error");
                        }
                    } else {
                        this.setToken(response.data.data.token);
                        toastr.success(response.data.message, "Success");
                    }
                })
                .catch((e) => {
                    console.log("error catch", e.response.data.message);
                    if (e.response.status === 401) {
                        toastr.error(e.response.data.message, "Error");
                    }
                })
                .then(() => {
                    NProgress.done();
                });
        },
        setToken: function (token) {
            this.token = token;
            localStorage.setItem("token", token);
        },
        removeToken: function () {
            this.token = 0;
            localStorage.removeItem("token");
        },
    },
});
