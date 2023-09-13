<template>
    <div>
        <slot name="trigger"></slot>
        <slot name="target"></slot>
    </div>
</template>
<script>
    import Vue from 'vue';
    import { Modal } from "bootstrap";

    export default {
        name: 'BootstrapModal',
        data() {
            return {
                bootstrapModal: null,
            };
        },
        mounted() {
            this.setUpModal();
        },
        methods: {
            setUpModal() {
                let that = this;
                let trigger = this.$slots['trigger'][0].elm;
                let target = this.$slots['target'][0].elm;

                trigger.addEventListener('click', ()=> {
                    that.bootstrapModal = new Modal(target, {
                        centered: true,
                        backdrop: 'static',
                        keyboard: true,
                        focus: true,
                        close: true,
                    });
                    that.bootstrapModal.show();
                    document.querySelector('button[title="Grid"]').click();

                    that.$store.commit('fm/setFileCallBack', function(fileUrl) {
                        console.log(fileUrl);
                        that.$emit('sendFileUrl', fileUrl);
                        that.bootstrapModal.hide();
                    });
                });
            },
        },
    }
</script>
