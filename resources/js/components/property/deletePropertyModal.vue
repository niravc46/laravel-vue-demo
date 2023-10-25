<template>
    <Teleport to="body">
        <Modal
            :show="delete_property.show_modal"
            :show_close_icon="delete_property.show_close_icon"
            @close-modal="closeModal"
        >
            <template #default>
                <div class="text-center mlr-auto mb30 pt20">
                    <img
                        :src="JS_APP_URL + '/images/warning.svg'"
                        alt=""
                        title=""
                        class="warning-icon-modal"
                    />
                </div>
                <h2
                    class="font-24 font_semibold blueog--text line-normal text-center mb20"
                >
                    Whoa!
                </h2>
                <p
                    class="text-center font-16 gray_checkmark--text line-normal mb30"
                >
                    Are you sure you want to delete this Property?
                </p>
                <div class="flex flex-wrap items-center justify-center pb40">
                    <button
                        :disabled="delete_property.is_btn_disabled"
                        @click="closeModal"
                        class="btn-cancel-outline mx5"
                    >
                        CANCEL
                    </button>
                    <button
                        :disabled="delete_property.is_btn_disabled"
                        @click="deletePropertySubmit"
                        class="btn-primary btn-width-136 mx5 px30 mt-xs-20"
                    >
                        YES DELETE!
                    </button>
                </div>
            </template>
        </Modal>
    </Teleport>
</template>
<script setup>
import { reactive } from "vue";
import Modal from "../Shared/Modal.vue";

const JS_APP_URL = import.meta.env.VITE_APP_URL;

let delete_property = reactive({
    show_modal: true,
    show_close_icon: true,
    is_btn_disabled: false,
});
const emit = defineEmits(["close-modal", "delete-property"]);
let closeModal = () => {
    emit("close-modal");
};

let deletePropertySubmit = () => {
    (delete_property.is_btn_disabled = true), emit("delete-property");
};
</script>
