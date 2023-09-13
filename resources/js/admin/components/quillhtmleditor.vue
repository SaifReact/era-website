<template>
    <div>
        <vue-editor v-model="content" ref="editor" :editor-options="toolbarOptions" @text-change="updateValue"></vue-editor>
        <!--<vue-editor v-model="content" ref="editor" :editor-options="toolbarOptions" @text-change="updateValue" useCustomImageHandler @imageAdded="uploadImage"></vue-editor>-->
    </div>
</template>

<script>
    import Vue from "vue";
    import axios from 'axios'
    let VueEditor, Quill;
    if (process.browser) {
        VueEditor = require("vue2-editor").VueEditor;
        Quill = require("vue2-editor").Quill;
    }

    export default {
        props: ["value"],
        data() {
            let toolbarOptions = {
                modules: {
                    toolbar: {
                        container: [
                            [{ font: [] }],
                            [{ header: [false, 1, 2, 3, 4, 5, 6] }],
                            ["bold", "italic", "underline", "strike"],
                            [{ align: [] }],
                            ["blockquote", "code-block"],
                            [{ list: "ordered" }, { list: "bullet" }, { list: "check" }],
                            [{ indent: "-1" }, { indent: "+1" }],
                            [{ color: [] }, { background: [] }],
                            ["link", "image", "video"],
                            ["clean"],
                            ["showHtml"]
                        ],
                        handlers: {
                            showHtml: () => {
                                if (this.txtArea.style.display === "") {
                                    const html = this.txtArea.value;
                                    if (html === '<p><br/></p>') {
                                        this.html = null;
                                    } else {
                                        this.html = html.replace(new RegExp('<p><br/>', 'g'), '<p>')
                                    }
                                    this.quill.pasteHTML(html);
                                }
                                this.txtArea.style.display =
                                    this.txtArea.style.display === "none" ? "" : "none";
                            }
                        }
                    }
                }
            };
            return {
                toolbarOptions,
                content: "",
                rawContent: ""
            };
        },
        components: {
            VueEditor
        },
        mounted() {
            this.quill = this.$refs.editor.quill;
            this.txtArea = document.createElement("textarea");
            /*this.txtArea.style.cssText =
                "width: 100%;height:100%;margin: 0px;background: rgb(29, 29, 29);box-sizing: border-box;color: rgb(204, 204, 204);font-size: 15px;outline: none;padding: 20px;line-height: 24px;font-family: Consolas, Menlo, Monaco, &quot;Courier New&quot;, monospace;position: absolute;top: 0;bottom: 0;border: none;display:none;resize: none;";*/
            this.txtArea.style.cssText =
                "width: 100%;margin: 0px;background: rgb(29, 29, 29);box-sizing: border-box;color: rgb(204, 204, 204);font-size: 15px;outline: none;padding: 20px;line-height: 24px;font-family: Consolas, Menlo, Monaco, &quot;Courier New&quot;, monospace;position: absolute;top: 0;bottom: 0;border: none;display:none;resize: none;";

            const htmlEditor = this.quill.addContainer("ql-custom");
            htmlEditor.appendChild(this.txtArea);

            this.quill.on("text-change", (delta, oldDelta, source) => {
                var html = this.quill.getHTML();
                this.txtArea.value = html;
            });

            this.content = this.value;
        },
        watch: {
            content() {
                this.rawContent = this.content;
            },
            rawContent() {
                this.content = this.rawContent;
            }
        },
        methods: {
            updateValue () {
                this.$emit('input', this.$refs.editor.quill.getHTML())
            },
            async uploadImage(file, Editor, cursorLocation, resetUploader) {
                const fd = new window.FormData()
                fd.append('file', file)
                fd.append('upload_preset', 'vxjellmt')
                fd.append('folder', 'outorah')

                const { data } = await axios.post("https://api.cloudinary.com/v1_1/ouinternal/image/upload", fd, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                })

                let url = `https://res.cloudinary.com/ouinternal/image/upload/${data.public_id}`
                Editor.insertEmbed(cursorLocation, "image", url)
                resetUploader()
            }
        }
    };
</script>

<style>
    .quillWrapper {
        line-height: normal;
    }
    span.ql-formats:first-child > .ql-picker,
    span.ql-header.ql-picker {
        border: 1px solid #ddd;
        display: flex;
        height: 100%;
        padding: 2px;
        box-shadow: inset 0 1px 1px -1px rgba(0, 0, 0, 0.2);
        background: white;
    }
    .ql-toolbar.ql-snow {
        border: 1px solid #eee !important;
        background: #f5f5f58c;
        border-radius: 0 0 4px 4px;
    }
    .ql-container.ql-snow {
        background: #fff;
        width: 100%;
        min-height: 200px;
        border-top: 0 !important;
        border-left: 1px solid #ddd !important;
        border-right: 1px solid #ddd !important;
        border-bottom: 1px solid #ddd !important;
    }
    .ql-stroke {
        stroke: #555d66 !important;
    }
    .ql-snow .ql-fill,
    .ql-snow .ql-stroke.ql-fill {
        fill: #555d66 !important;
    }
    .ql-editor.ql-blank::before {
        color: rgba(0, 0, 0, 0.3) !important;
        font-style: normal !important;
    }
    .ql-editor {
        min-height: 300px;
        font-size: 15px;
        font-family: Arial;
        line-height: 24px;
    }
    .ql-container {
        font-size: 15px;
        font-family: Arial;
        line-height: 24px;
    }
    .ql-container p {
        margin-bottom: 10px;
    }
    .ql-formats button:hover,
    .ql-formats .ql-picker:hover {
        background: #abd4ff73 !important;
    }
    .ql-formats .ql-header.ql-picker:hover,
    .ql-formats .ql-font.ql-picker:hover {
        background: white !important;
        border-color: #b4b9be;
    }
    .ql-picker-label {
        display: flex !important;
    }
    .ql-align.ql-picker.ql-icon-picker .ql-picker-label {
        display: block !important;
    }

    .ql-showHtml:after {
        content: "[source]";
    }
    button.ql-showHtml {
        width: 100% !important;
    }
</style>
