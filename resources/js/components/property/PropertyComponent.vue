<template>
    <div class="d-flex justify-content-between">
        <div class="card-header mb-4">
            <router-link class="btn btn-success" to="/property/create"
                >Add New Property</router-link
            >
        </div>
        <!-- sorting -->
        <div class="d-flex justify-content-end">
            <div class="form-gorup mb-2 mr-2">
                <label for="sel1">Select Column</label>
                <select v-model="filter.sortby" class="form-control mb-2">
                    <option
                        selected
                        v-for="(column, index) in columnName"
                        :key="index"
                        :value="column"
                    >
                        {{ column }}
                    </option>
                </select>
            </div>
            <div class="form-gorup mb-2 mr-2">
                <label for="sel1">Select Order Type</label>
                <select
                    v-model="filter.direction"
                    class="form-control mb-2"
                >
                    <option
                        selected
                        v-for="(sort, index) in sortType"
                        :key="index"
                        :value="sort"
                    >
                        {{ sort }}
                    </option>
                </select>
            </div>
            <button @click="sortData()" class="btn btn-primary mt-4 mb-4">
                Sort Data
            </button>
        </div>
    </div>

    <!-- search  -->
    <div class="ui icon input my-2" style="width: 100%">
        <span class="m-6px">Search </span>
        <input
            type="text"
            class="border border-primary rounded-2"
            placeholder="Search..."
            v-model="filter.search"
        />
        <i class="search icon"></i>
    </div>

    <div class="row">
        <div class="col-xl-12">
            <table class="table table-hover table-lg">
                <thead class="bg-dark text-light">
                    <tr>
                        <th
                            href="#"
                            width="50"
                            class="text-center cursor:pointer"
                        >
                            ID
                        </th>
                        <th href="#" class="text-center cursor:pointer">
                            Name
                        </th>
                        <th href="#" class="text-center cursor:pointer">
                            Details
                        </th>
                        <th href="#" class="text-center cursor:pointer">
                            Type
                        </th>
                        <th href="#" class="text-center cursor:pointer">
                            Size
                        </th>
                        <th href="#" class="text-center cursor:pointer">
                            Address
                        </th>
                        <th class="text-center" width="120">Brochure</th>
                        <th href="#" class="text-center cursor:pointer">
                            Amenities
                        </th>
                        <th class="text-center" width="200">Actions</th>
                    </tr>
                </thead>
                <propertyListIteams
                    v-for="(property_data, index) in properties.data"
                    :key="index"
                    :property_iteam="property_data"
                    @deleted-property="deletedProperty"
                >
                </propertyListIteams>
            </table>
        </div>
    </div>
    <div>
        <pagination
            :pagination="properties"
            :offset="3"
            @paginate="paginateProperty"
        ></pagination>

        <!-- <delete-property-modal
            v-if="is_show_delete_modal"
            @close-modal="is_show_delete_modal = false"
            @delete-account-user="deleteAccountUser"
        /> -->
    </div>
</template>

<script setup>
import { reactive, ref } from "@vue/reactivity";
import _ from "lodash";
import { onMounted, watch } from "@vue/runtime-core";
import Pagination from "../../utilities/PaginationComponent.vue";
import propertyListIteams from "./PropertyListIteams.vue";
import { UserStore } from "../../stores/UserStore";
import { PropertyStore } from "../../stores/PropertyStore";
import { storeToRefs } from "pinia";

let columnName = ref(["name", "details", "address", "type", "size"]);
let sortType = ref(["asc", "desc"]);
const registerUser = UserStore();
const propertyStore = PropertyStore();

let properties = null;
let pagination = null;
({ properties } = storeToRefs(propertyStore));
({ pagination } = storeToRefs(propertyStore));

let filter = reactive({
    search: "",
    sortby: "",
    direction: ""
});

let axiosConfig = {
  headers: {
    accept: "application/vnd.api+json",
    "Content-Type": "application/vnd.api+json",
    Authorization: "Bearer " + registerUser.token,
  },
};

// get list of property
const getProperties = async () => {
    pagination.searchQuery = filter.search;
    pagination.sortby = filter.sortby;
    pagination.direction = filter.direction;
    await propertyStore.getPropertyList(pagination, axiosConfig);
};

// delete Property element without reload all list
let deletedProperty = (deleted_property_id = "") => {
    if (deleted_property_id) {
        let found_index = _.findIndex(properties.value.data, (o) => {
            return o.id === deleted_property_id;
        });
        if (found_index >= 0) {
            properties.value.data.splice(found_index, 1);
        }
    }
};

// let updatePropertyElement = (updated_peoperty = {}) => {
//     if (!_.isEmpty(updated_peoperty)) {
//         let found_index = _.findIndex(
//             properties.value.data,
//             (o) => {
//                 return o.id === updated_peoperty.id;
//             }
//         );
//         if (found_index >= 0) {
//             properties.value.data[found_index] =
//             updated_peoperty;
//         }
//     }
// };

let paginateProperty = (page) => {
    propertyStore.current_pagination_page = page;
    getProperties();
}

// Update Property element without reload all list

onMounted(() => {
    getProperties();
});

//sorting
let sortData = () => {
    getProperties();
};

let timer = null;
watch(
    () => filter.search,
    () => {
        if (timer) {
            clearTimeout(timer);
            timer = null;
        }
        timer = setTimeout(() => {
            getProperties();
        }, 500);
    }
);
</script>

<style></style>
