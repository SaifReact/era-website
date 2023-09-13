<template>
    <div>
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Assets</h3>
                </div>
                <div class="card-body">
                    <file-manager></file-manager>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
    export default {
        name: 'Asset',
        mounted() {
            this.gridView();
        },
        methods: {
            gridView() {
                document.querySelector('button[title="Grid"]').click();
            }
        }
    }
</script>
