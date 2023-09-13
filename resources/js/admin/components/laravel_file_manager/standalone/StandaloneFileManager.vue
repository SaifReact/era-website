<template>
    <BootstrapModal @sendFileUrl="getFileUrl($event)" :id="bootstrapModalId">
        <button :id="btnId" :class="btnCls" type="button" :data-bs-toggle="dataBsTarget" :data-bs-target="'#'+dataBsTarget" slot="trigger">
            <i class="bi bi-cloud-upload"></i>
        </button>
        <div :class="dataBsModal+' fade'" :id="dataBsTarget" tabindex="-1" :aria-labelledby="dataBsTarget+'Label'" aria-hidden="true" slot="target">
            <div class="modal-dialog modal-fullscreen">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" :id="dataBsTarget+'Label'">{{modalTitle}}</h5>
                        <button type="button" class="btn-close" :data-bs-dismiss="dataBsModal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <file-manager></file-manager>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" :data-bs-dismiss="dataBsModal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </BootstrapModal>
</template>
<script>
    import BootstrapModal from "./BootstrapModal";
    export default {
        name: 'StandaloneFileManager',
        props: ['bootstrapModalId', 'btnId', 'btnCls', 'label', 'dataBsTarget', 'dataBsModal', 'modalTitle'],
        data() {
            return {
                bootstrapModal: null,
            };
        },
        components: {
            'BootstrapModal': BootstrapModal,
        },
        mounted() {},
        methods: {
            getFileUrl(fileUrl) {
                this.$emit('passFileUrl', fileUrl);
            }
        },
    }
</script>
