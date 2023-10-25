<script setup>
import { onMounted, onUnmounted } from "vue";
import CloseIcon from "./icons/CloseIcon.vue";
    const emit = defineEmits(['close-modal'])
    const props = defineProps({
        "show": {
            type: Boolean,
            default: false
        },
        "show_close_icon": {
            type: Boolean,
            default: true
        }
    })
    onMounted(() =>{ 
        document.body.classList.add('modal-open');
        window.addEventListener('keydown', (e) => {
            if (e.keyCode == 27 && props.show_close_icon) {
                emit("close-modal");
            }
        });
    });
    onUnmounted(() => {
        document.body.classList.remove('modal-open');
    });
</script>

<template>
    <Transition name="modal_transition">
        <div v-show="show" class="modal-mask">
            <div class="modal-wrapper animate__animated animate__zoomIn">
                <div class="modal-container">
                    <div v-show="show_close_icon" @click="$emit('close-modal')" class="cursor-pointer modal-close">
                        <CloseIcon />
                    </div>
                    <header>
                        <slot name="header"></slot>
                    </header>
                    <div class="modal-body">
                        <slot></slot>
                    </div>
                    <footer class="d-flex flex-wrap align-items-center justify-content-center pb-2">
                        <slot name="footer"></slot>
                    </footer>
                </div>
            </div>
        </div>
    </Transition>
</template>