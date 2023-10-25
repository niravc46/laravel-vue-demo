<template>
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <div class="row my-4">
                    <div class="col-10">
                        <div
                            class="page-title-box d-sm-flex align-items-center justify-content-between"
                        >
                            <h4 class="mb-sm-0 font-size-18">
                                Add New Property
                            </h4>
                        </div>
                    </div>
                    <div class="col-2">
                        <router-link
                            :to="{ name: 'Property' }"
                            class="btn btn-success"
                            >Go Back</router-link
                        >
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body">
                                <form
                                    @submit.prevent="addProperty"
                                    enctype="multipart/form-data"
                                >
                                    <div
                                        class="row mb-4"
                                        :class="{
                                            'form-group--error':
                                                v$.name.$errors.length,
                                        }"
                                    >
                                        <label
                                            for="horizontal-firstname-input"
                                            class="col-sm-2 col-form-label text-end"
                                            >Name</label
                                        >
                                        <div class="col-sm-8">
                                            <input
                                                type="text"
                                                class="form-control"
                                                placeholder="Enter Name"
                                                :class="{
                                                    'border-danger':
                                                        v$.name.$errors.length,
                                                }"
                                                id="horizontal-firstname-input"
                                                v-model.trim="v$.name.$model"
                                            />
                                            <div
                                                v-for="error of v$.name.$errors"
                                                :key="error.$uid"
                                            >
                                                <div class="form-error-text">
                                                    {{ error.$message }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div
                                        class="row mb-4"
                                        :class="{
                                            'form-group--error':
                                                v$.details.$errors.length,
                                        }"
                                    >
                                        <label
                                            for="horizontal-firstname-input"
                                            class="col-sm-2 col-form-label text-end"
                                            >Details</label
                                        >
                                        <div class="col-sm-8">
                                            <textarea
                                                rows="3"
                                                class="form-control"
                                                placeholder="Enter Property Details.."
                                                v-model.trim="v$.details.$model"
                                            ></textarea>
                                            <div
                                                v-for="error of v$.details
                                                    .$errors"
                                                :key="error.$uid"
                                            >
                                                <div class="form-error-text">
                                                    {{ error.$message }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div
                                        class="row mb-4"
                                        :class="{
                                            'form-group--error':
                                                v$.address.$errors.length,
                                        }"
                                    >
                                        <label
                                            for="horizontal-firstname-input"
                                            class="col-sm-2 col-form-label text-end"
                                            >Address</label
                                        >
                                        <div class="col-sm-8">
                                            <textarea
                                                rows="3"
                                                class="form-control"
                                                placeholder="Enter Property Details.."
                                                v-model.trim="v$.address.$model"
                                            ></textarea>
                                            <div
                                                v-for="error of v$.address
                                                    .$errors"
                                                :key="error.$uid"
                                            >
                                                <div class="form-error-text">
                                                    {{ error.$message }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div
                                        class="row mb-4"
                                        :class="{
                                            'form-group--error':
                                                v$.type.$errors.length,
                                        }"
                                    >
                                        <label
                                            for="horizontal-firstname-input"
                                            class="col-sm-2 col-form-label text-end"
                                            >Types(s)</label
                                        >
                                        <div class="col-sm-8">
                                            <VueMultiselect
                                                :options="property_type"
                                                v-model="v$.type.$model"
                                                track-by="id"
                                                label="name"
                                                placeholder="Select Property Type..."
                                                :multiple="false"
                                                :searchable="true"
                                                :showLabels="false"
                                                :taggable="false"
                                                :close-on-select="true"
                                                openDirection="bottom"
                                            >
                                                <template #noResult>
                                                    <div
                                                        class="multiselect__noResult text-center"
                                                    >
                                                        No results found
                                                    </div>
                                                </template>
                                                <template #noOptions>
                                                    <div
                                                        class="multiselect__noOptions text-center"
                                                    >
                                                        No data available
                                                    </div>
                                                </template>
                                            </VueMultiselect>
                                            <div
                                                v-if="
                                                    v$.type.$errors.length > 0
                                                "
                                            >
                                                <div class="form-error-text">
                                                    {{
                                                        v$.type.$errors[0]
                                                            .$message
                                                    }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div
                                        v-if="
                                            property_form_data.type.id ==
                                            'residential'
                                        "
                                        class="row mb-4"
                                        :class="{
                                            'form-group--error':
                                                v$.size.$errors.length,
                                        }"
                                    >
                                        <label
                                            for="horizontal-firstname-input"
                                            class="col-sm-2 col-form-label text-end"
                                            >Size(s)</label
                                        >
                                        <div class="col-sm-8">
                                            <VueMultiselect
                                                :options="property_size"
                                                v-model="v$.size.$model"
                                                track-by="name"
                                                label="name"
                                                placeholder="Select Property Size..."
                                                :multiple="true"
                                                :searchable="true"
                                                :showLabels="false"
                                                :taggable="true"
                                                :close-on-select="true"
                                                openDirection="bottom"
                                            >
                                                <template #noResult>
                                                    <div
                                                        class="multiselect__noResult text-center"
                                                    >
                                                        No results found
                                                    </div>
                                                </template>
                                                <template #noOptions>
                                                    <div
                                                        class="multiselect__noOptions text-center"
                                                    >
                                                        No data available
                                                    </div>
                                                </template>
                                            </VueMultiselect>
                                            <div
                                                v-if="
                                                    v$.size.$errors.length > 0
                                                "
                                            >
                                                <div class="form-error-text">
                                                    {{
                                                        v$.size.$errors[0]
                                                            .$message
                                                    }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div
                                        class="row mb-4"
                                        :class="{
                                            'form-group--error':
                                                v$.amenity_id.$errors.length,
                                        }"
                                    >
                                        <label
                                            for="horizontal-firstname-input"
                                            class="col-sm-2 col-form-label text-end"
                                            >Amenity(s)</label
                                        >
                                        <div class="col-sm-8">
                                            <VueMultiselect
                                                :options="amenities"
                                                v-model="v$.amenity_id.$model"
                                                track-by="id"
                                                label="name"
                                                placeholder="Select Amenities..."
                                                :multiple="true"
                                                :searchable="true"
                                                :showLabels="false"
                                                :taggable="true"
                                                :close-on-select="true"
                                                openDirection="bottom"
                                            >
                                                <template #noResult>
                                                    <div
                                                        class="multiselect__noResult text-center"
                                                    >
                                                        No results found
                                                    </div>
                                                </template>
                                                <template #noOptions>
                                                    <div
                                                        class="multiselect__noOptions text-center"
                                                    >
                                                        No data available
                                                    </div>
                                                </template>
                                            </VueMultiselect>
                                            <div
                                                v-if="
                                                    v$.amenity_id.$errors
                                                        .length > 0
                                                "
                                            >
                                                <div class="form-error-text">
                                                    {{
                                                        v$.amenity_id.$errors[0]
                                                            .$message
                                                    }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div
                                        class="row mb-4"
                                        :class="{
                                            'form-group--error':
                                                v$.brochure.$errors.length,
                                        }"
                                    >
                                        <label
                                            for="horizontal-firstname-input"
                                            class="col-sm-2 col-form-label text-end"
                                            >Upload Brochure</label
                                        >
                                        <div class="col-sm-8">
                                            <input
                                                type="file"
                                                class="form-input"
                                                id="file"
                                                name="file"
                                                @change="onChangeBrochure"
                                            />
                                            <div
                                                v-if="
                                                    v$.brochure.$errors.length >
                                                    0
                                                "
                                            >
                                                <div class="form-error-text">
                                                    {{
                                                        v$.brochure.$errors[0]
                                                            .$message
                                                    }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-2"></div>
                                        <div class="col-sm-8">
                                            <div>
                                                <button
                                                    type="submit"
                                                    class="btn btn-primary w-md mr-3"
                                                >
                                                    Submit
                                                </button>
                                                <button
                                                    type="button"
                                                    class="btn btn-danger w-md"
                                                >
                                                    CANCEL
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { reactive, ref, computed } from "@vue/reactivity";
import VueMultiselect from "vue-multiselect";
import "vue-multiselect/dist/vue-multiselect.css";
import { onMounted } from "@vue/runtime-core";
import { useRouter } from "vue-router";
import useVuelidate from "@vuelidate/core";
import _ from "lodash";
import { UserStore } from "../../stores/UserStore";
import { PropertyStore } from "../../stores/PropertyStore";
import {
    required,
    minLength,
    maxLength,
    helpers,
    requiredIf
} from "@vuelidate/validators";
import { storeToRefs } from "pinia";
const propertyStore = PropertyStore();
const property_type = reactive([
    {
        id: "residential",
        name: "Residential",
    },
    {
        id: "commercial",
        name: "Commercial",
    },
]);
const { amenities } = storeToRefs(propertyStore);
const { getAminityList } = propertyStore;
const property_size = reactive([{ name: "2BHK" }, { name: "3BHK" }]);
const router = useRouter();

let property_form_data=reactive({
            name: "",
            details: "",
            type: [],
            size: [],
            address: "",
            brochure: "",
            amenity_id: []
        });

const property_form_data_rules = {

        name: {
            required: helpers.withMessage(
                "Please enter a property name",
                required
            ),
            minLength: helpers.withMessage(
                "Please do not enter less than 3 characters in name",
                minLength(3)
            ),
            maxLength: helpers.withMessage(
                "Please do not enter more than 20 characters in name",
                maxLength(20)
            ),
        },
        details: {
            required: helpers.withMessage("Please enter a Details", required),
            minLength: helpers.withMessage(
                "Please do not enter less than 10 characters in details",
                minLength(10)
            ),
            maxLength: helpers.withMessage(
                "Please do not enter more than 255 characters in details",
                maxLength(255)
            ),
        },
        type: {
            required: helpers.withMessage(
                "Please select property type",
                required
            ),
        },
        size: {
            required: requiredIf(function () {
                return property_form_data.type.id == "residential";
            }),
        },
        amenity_id: {
            required: helpers.withMessage("Please select amenity", required),
        },
        address: {
            required: helpers.withMessage(
                "Please enter address details",
                required
            ),
            minLength: helpers.withMessage(
                "Please do not enter less than 5 characters in address",
                minLength(5)
            ),
            maxLength: helpers.withMessage(
                "Please do not enter more than 255 characters in address",
                maxLength(255)
            ),
        },
        brochure: {
            required: helpers.withMessage("Please select brochure", required),
        },
    // };
    };

const v$ = useVuelidate(property_form_data_rules, property_form_data);

// broucher upload
let onChangeBrochure = (e) => {
    let file = e.target.files[0];
    property_form_data.brochure = file;
};
const registerUser = UserStore();

let axiosConfig = {
    headers: {
        accept: "application/vnd.api+json",
        "Content-Type": "application/vnd.api+json+multipart/form-data",
        Authorization: "Bearer " + registerUser.token,
    },
};
getAminityList(axiosConfig);

let addProperty = async () => {
    const is_valid = await v$.value.$validate();
    if (is_valid) {
        propertyStore.addProperty(property_form_data,axiosConfig);
        setTimeout(() => {
            router.push({ name: "Property" });   
        }, 1000);
    }
};
</script>

<style scoped></style>
