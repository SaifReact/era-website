<template>
    <div>
        <ckeditor :editor="editor" v-model="editorData" :config="editorConfig"></ckeditor>
        <button class="btn btn-light-primary btn-block" @click.prevent="emptyEditor"><i class="bi bi-trash"></i>CLEAR EDITOR</button>
    </div>
</template>

<script>
    import ClassicEditor from '@ckeditor/ckeditor5-build-classic';

    export default {
        data() {
            return {
                editor: ClassicEditor,
                editorData: '',
                editorConfig: {
                    // The configuration of the editor.
                },
            };
        },

        mounted(){
            console.log('Component mounted.')
        },
        methods: {
            emptyEditor() {
                this.editorData = '';
            },
            displayEditorResult(){
                document.getElementById('resultingText').innerHTML = this.editorData;
            }
        }
    }
</script>
