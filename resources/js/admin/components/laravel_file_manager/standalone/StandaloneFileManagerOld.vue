<template>
    <button :id="btnId" :class="btnCls">{{label}}</button>
</template>
<script>
    export default {
        name: 'StandaloneFileManager',
        props: ['btnId', 'btnCls', 'label', 'attachedField'],
        data() {
            return {
                windowURL: '/file-manager/fm-button',
                fileManager: 'fm',
                windowSize: 'width=1400,height=800'
            }

        },
        mounted() {
            console.log('mounted standalone!');
            this.setUpStandaloneLfm();
        },
        methods: {
            init() {
                let that = this;
                document.addEventListener('DOMContentLoaded', function() {
                    // Add callback to file manager
                    that.$store.commit('fm/setFileCallBack', function(fileUrl) {
                        console.log(fileUrl);
                        window.opener.fmSetLink(fileUrl);
                        window.close();
                    });
                });
            },

            setUpStandaloneLfm() {
                this.standaloneButtonAction(this.btnId, this.attachedField);
            },

            standaloneButtonAction(standaloneButton, standaloneInputField) {
                let that = this;
                document.getElementById(standaloneButton).addEventListener('click', (event) => {
                    event.preventDefault();
                    /*setStandaloneInputFieldId(standaloneInputField);*/

                    window.open(that.windowURL, that.fileManager, that.windowSize);
                });
            },
        }
    }
</script>
