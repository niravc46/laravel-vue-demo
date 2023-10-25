<template>
    <div class="container">
        <div class="row jutify-content-center">
            <div class="col-md-8">
                <div class="card card-default">
                    <div class="card-header"><h5>Login Here</h5></div>
                    <div class="card-body">
                        <form @submit.prevent="login">
                            <div
                                class="form-group row m-2"
                                :class="{
                                    'form-group--error':
                                        v$.email.$errors.length,
                                }"
                            >
                                <label
                                    for="email"
                                    class="col-sm-4 col-form-label text-md-right"
                                    >Email</label
                                >
                                <div class="col-md-8">
                                    <input
                                        id="email"
                                        type="text"
                                        class="form-control"
                                        v-model.trim="v$.email.$model"
                                        :class="{
                                            'border-danger':
                                                v$.email.$errors.length,
                                        }"
                                        autofocus
                                        autocomplete="off"
                                        placeholder="Enter your email"
                                    />
                                    <div
                                        v-for="error of v$.email.$errors"
                                        :key="error.$uid"
                                    >
                                        <div class="form-error-text">
                                            {{ error.$message }}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div
                                class="form-group row m-2"
                                :class="{
                                    'form-group--error':
                                        v$.password.$errors.length,
                                }"
                            >
                                <label
                                    for="name"
                                    class="col-sm-4 col-form-label text-md-right"
                                    >Password</label
                                >
                                <div class="col-md-8">
                                    <input
                                        id="name"
                                        type="password"
                                        class="form-control"
                                        v-model.trim="v$.password.$model"
                                        :class="{
                                            'border-danger':
                                                v$.password.$errors.length,
                                        }"
                                        autofocus
                                        autocomplete="off"
                                        placeholder="Enter Password"
                                    />
                                    <div
                                        v-for="error of v$.password.$errors"
                                        :key="error.$uid"
                                    >
                                        <div class="form-error-text">
                                            {{ error.$message }}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row mt-1 mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button
                                        type="submit"
                                        class="btn btn-success"
                                    >
                                        Login
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script setup>
import { reactive, ref, computed } from "@vue/reactivity";
import axios from "axios";
import NProgress from "nprogress";
import toastr from "toastr";
import "toastr/toastr.scss";
import { useRouter } from "vue-router";
import useVuelidate from "@vuelidate/core";
import { UserStore } from "../stores/UserStore";
import {
    required,
    minLength,
    maxLength,
    helpers,
    email,
    sameAs,
} from "@vuelidate/validators";

let login_form_data = reactive({
    email: "",
    password: "",
});

const login_form_data_rules = computed(() => {
    return {
        email: {
            required: helpers.withMessage(
                "Please enter a first last name",
                required
            ),
            email: helpers.withMessage(
                "Please enter valid email address",
                email
            ),
        },
        password: {
            required: helpers.withMessage("Please enter a password", required),
            minLength: helpers.withMessage(
                "Please enter atleast 6 character",
                minLength(6)
            ),
        },
    };
});
const v$ = useVuelidate(login_form_data_rules, login_form_data);

let axiosConfig = {
    headers: {
        accept: "application/vnd.api+json",
        "Content-Type": "application/vnd.api+json",
    },
};

const router = useRouter();
const loginUser = UserStore();

let login = async () => {
    const is_valid = await v$.value.$validate();
    if (is_valid) {
        await loginUser.loginUser(login_form_data, axiosConfig);
        await router.push({ name: "Dashboard" });
    }
};
</script>
