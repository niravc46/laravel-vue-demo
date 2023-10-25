<template>
    <tbody>
        <tr>
            <!-- <td class="text-center">{{ index + 1 }}.</td> -->
            <td>{{ props.property_iteam.id }}</td>
            <td>{{ props.property_iteam.name }}</td>
            <td>{{ props.property_iteam.details }}</td>
            <td>{{ (props.property_iteam.type == 'residential') ? "Residential" : "Commercial" }}</td>
            <td v-if="props.property_iteam.type == 'residential'">
                <span v-for="(size, index) in props.property_iteam.size">
                    {{ size.name }}<br />
                </span>
            </td>
            <td v-else>
                -
            </td>
            <td>{{ props.property_iteam.address }}</td>
            <td class="text-center">
                <a :href="property_iteam.brochure_path">{{
                    props.property_iteam.brochure
                }}</a>
            </td>
            <td>
                <div
                    class="overflow-auto"
                    v-for="amenity in props.property_iteam.amenities"
                    :key="amenity.id"
                >
                    <p>{{ amenity.name }},</p>
                </div>
            </td>
            <td class="text-center">
                <router-link
                    :to="{
                        name: 'EditProperty',
                        params: { id: props.property_iteam.id },
                    }"
                    class="btn btn-warning mr-2"
                    >Edit</router-link
                >
                <button
                    class="btn btn-danger"
                    @click="is_delete_property_modal_open = true"
                >
                    Delete
                </button>
            </td>
        </tr>
    </tbody>
    <deletePropertyModal
      v-if="is_delete_property_modal_open"
     @close-modal="is_delete_property_modal_open = false"
     @delete-property = "removeProperty(props.property_iteam.id)"
    />
</template>
<script setup>
import {  ref } from "@vue/reactivity";
import { UserStore } from "../../stores/UserStore";
import { PropertyStore } from "../../stores/PropertyStore";
const propertyStore = PropertyStore();
import deletePropertyModal from "./deletePropertyModal.vue";

let is_delete_property_modal_open = ref(false);
const props = defineProps(["property_iteam"]);

const emit = defineEmits(["deleted-property"]);
const registerUser = UserStore();
let axiosConfig = {
  headers: {
    accept: "application/vnd.api+json",
    "Content-Type": "application/vnd.api+json",
    Authorization: "Bearer " + registerUser.token,
  },
};

// delete property
const removeProperty = async (property_id) => {
    propertyStore.deleteProperty(property_id, axiosConfig);
    is_delete_property_modal_open.value = false;
};
</script>
