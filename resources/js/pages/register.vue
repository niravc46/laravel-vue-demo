<template>
    <div class="container">
        <div class="row jutify-content-center">
            <div class="col-md-8">
                <div class="card card-default">
                    <div class="card-header"><h5>Register New User</h5></div>
                    <div class="card-body">
                        <form @submit.prevent="register">
                            <div
                                class="form-group row m-2"
                                :class="{
                                    'form-group--error':
                                        v$.first_name.$errors.length,
                                }"
                            >
                                <label
                                    for="first_name"
                                    class="col-sm-4 col-form-label text-md-right"
                                    >First Name</label
                                >
                                <div class="col-md-8">
                                    <input
                                        id="first_name"
                                        type="text"
                                        class="form-control"
                                        v-model.trim="v$.first_name.$model"
                                        :class="{
                                            'border-danger':
                                                v$.first_name.$errors.length,
                                        }"
                                        autofocus
                                        autocomplete="off"
                                        placeholder="Enter your first name"
                                    />
                                    <div
                                        v-for="error of v$.first_name.$errors"
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
                                        v$.last_name.$errors.length,
                                }"
                            >
                                <label
                                    for="last_name"
                                    class="col-sm-4 col-form-label text-md-right"
                                    >Last Name</label
                                >
                                <div class="col-md-8">
                                    <input
                                        id="last_name"
                                        type="text"
                                        class="form-control"
                                        v-model.trim="v$.last_name.$model"
                                        :class="{
                                            'border-danger':
                                                v$.last_name.$errors.length,
                                        }"
                                        autofocus
                                        autocomplete="off"
                                        placeholder="Enter your last name"
                                    />
                                    <div
                                        v-for="error of v$.last_name.$errors"
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
                                        type="email"
                                        class="form-control"
                                        v-model.trim="v$.email.$model"
                                        :class="{
                                            'border-danger':
                                                v$.email.$errors.length,
                                        }"
                                        autofocus
                                        autocomplete="off"
                                        placeholder="Enter valid email"
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
                                    for="password"
                                    class="col-sm-4 col-form-label text-md-right"
                                    >Password</label
                                >
                                <div class="col-md-8">
                                    <input
                                        id="password"
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

                            <div
                                class="form-group row m-2"
                                :class="{
                                    'form-group--error':
                                        v$.password_confirmation.$errors.length,
                                }"
                            >
                                <label
                                    for="password_confirmation"
                                    class="col-sm-4 col-form-label text-md-right"
                                    >Confirm Password</label
                                >
                                <div class="col-md-8">
                                    <input
                                        id="password_confirmation"
                                        type="password"
                                        class="form-control"
                                        v-model.trim="
                                            v$.password_confirmation.$model
                                        "
                                        :class="{
                                            'border-danger':
                                                v$.password_confirmation.$errors
                                                    .length,
                                        }"
                                        autofocus
                                        autocomplete="off"
                                        placeholder="Enter Confirm Password"
                                    />
                                    <div
                                        v-for="error of v$.password_confirmation.$errors"
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
                                        Register
                                    </button>
                                </div>
                            </div>

                            <div class="row mt-1">
                                <div class="col-md-8 offset-md-4">
                                    <small class="text-muted">
                                        Have an account? Please
                                        <router-link to="/login"
                                            >login</router-link
                                        >
                                    </small>
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
    sameAs
} from "@vuelidate/validators";

let register_form_data = reactive({
    first_name: "",
    last_name: "",
    email: "",
    password: "",
    password_confirmation: "",
});

const register_form_data_rules = computed(() => {
    return {
        first_name: {
        required: helpers.withMessage("Please enter a first name", required),
        minLength: helpers.withMessage(
            "Please do not enter less than 3 characters in first name",
            minLength(3)
        ),
        maxLength: helpers.withMessage(
            "Please do not enter more than 20 characters in first name",
            maxLength(20)
        ),
    },
    last_name: {
        required: helpers.withMessage(
            "Please enter a first last name",
            required
        ),
        minLength: helpers.withMessage(
            "Please do not enter less than 3 characters in last name",
            minLength(3)
        ),
        maxLength: helpers.withMessage(
            "Please do not enter more than 20 characters in last name",
            maxLength(20)
        ),
    },
    email: {
        required: helpers.withMessage(
            "Please enter a first last name",
            required
        ),
        email: helpers.withMessage("Please enter valid email address", email),
    },
    password: {
        required: helpers.withMessage("Please enter a password", required),
        minLength: helpers.withMessage(
            "Please enter atleast 6 character",
            minLength(6)
        ),
    },
    password_confirmation: {
        required: helpers.withMessage("Please enter a password", required),
        sameAs: helpers.withMessage(
            "Password and confirm password should be same",
            sameAs(register_form_data.password)
        ),
    },
    }
});

const v$ = useVuelidate(register_form_data_rules, register_form_data);

let axiosConfig = {
    headers: {
        accept: "application/vnd.api+json",
        "Content-Type": "application/vnd.api+json",
    },
};

const router = useRouter();
const registerUser = UserStore();

let register = async () => {
    const is_valid = await v$.value.$validate();
    if (is_valid) {
        await registerUser.registerUser(register_form_data, axiosConfig);
        await router.push({ name: "Login" });
    }
};
</script>
