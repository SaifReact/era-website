<template>
    <div>
        <button :id="btnId" :class="btnCls" type="button" :data-bs-toggle="dataBsTarget" :data-bs-target="'#'+dataBsTarget">{{label}}</button>

        <div :class="dataBsTarget+' fade'" :id="dataBsTarget" tabindex="-1" :aria-labelledby="dataBsTarget+'Label'" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" :id="dataBsTarget+'Label'">Modal title</h5>
                        <button type="button" class="btn-close" :data-bs-dismiss="dataBsTarget" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        ...
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" :data-bs-dismiss="dataBsTarget">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        name: 'StandaloneFileManager',
        props: ['btnId', 'btnCls', 'label', 'dataBsTarget'],
        data() {
            return {};
        },
        mounted() {
            this.setUpModal();
        },
        methods: {
            setUpModal() {
                var fmModal = document.getElementById('exampleModal');
                fmModal.addEventListener('shown.bs.modal', function () {
                    console.log('here');
                });
            }
        },
    }
</script>
