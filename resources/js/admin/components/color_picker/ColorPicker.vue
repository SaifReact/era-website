<template>
    <div class="input-group color-picker" ref="colorpicker">
        <input type="text" :id="id" :name="name" :class="klass" v-model="colorValue" @focus="showPicker()"
               @input="updateFromInput" autocomplete="off"/>
        <span class="input-group-addon color-picker-container">
            <span class="current-color" :style="'background-color: ' + colorValue" @click="togglePicker()"></span>
            <chrome-picker :value="colors" @input="updateFromPicker" v-if="displayPicker"/>
	    </span>
    </div>
</template>

<script>
    import {Material, Compact, Swatches, Slider, Sketch, Chrome, Photoshop} from 'vue-color';

    export default {
        name: 'ColorPicker',
        props: ['color', 'klass', 'id', 'name'],
        components: {
            'material-picker': Material,
            'compact-picker': Compact,
            'swatches-picker': Swatches,
            'slider-picker': Slider,
            'sketch-picker': Sketch,
            'chrome-picker': Chrome,
            'photoshop-picker': Photoshop
        },
        data() {
            return {
                colors: {
                    hex: '#000000',
                },
                colorValue: '',
                displayPicker: false,
            }
        },
        mounted() {
            this.setColor(this.color || '#000000');
        },
        methods: {
            setColor(color) {
                this.updateColors(color);
                this.colorValue = color;
            },
            updateColors(color) {
                if (color.slice(0, 1) === '#') {
                    this.colors = {
                        hex: color
                    };
                } else if (color.slice(0, 4) === 'rgba') {
                    var rgba = color.replace(/^rgba?\(|\s+|\)$/g, '').split(','),
                        hex = '#' + ((1 << 24) + (parseInt(rgba[0]) << 16) + (parseInt(rgba[1]) << 8) + parseInt(rgba[2])).toString(16).slice(1);
                    this.colors = {
                        hex: hex,
                        a: rgba[3],
                    }
                }
            },
            showPicker() {
                document.addEventListener('click', this.documentClick);
                this.displayPicker = true;
            },
            hidePicker() {
                document.removeEventListener('click', this.documentClick);
                this.displayPicker = false;
            },
            togglePicker() {
                this.displayPicker ? this.hidePicker() : this.showPicker();
            },
            updateFromInput() {
                this.updateColors(this.colorValue);
            },
            updateFromPicker(color) {
                this.colors = color;
                if (color.rgba.a === 1) {
                    this.colorValue = color.hex;
                } else {
                    this.colorValue = 'rgba(' + color.rgba.r + ', ' + color.rgba.g + ', ' + color.rgba.b + ', ' + color.rgba.a + ')';
                }
            },
            documentClick(e) {
                var el = this.$refs.colorpicker,
                    target = e.target;
                if (el !== target && !el.contains(target)) {
                    this.hidePicker()
                }
            }
        },
        watch: {
            colorValue(val) {
                if (val) {
                    this.updateColors(val);
                    this.$emit('input', val);
                }
            },
            color(val) {
                this.colorValue = val;
            }
        },
    }
</script>

<style>
    .vc-material,
    .vc-compact,
    .vc-swatches,
    .vc-slider,
    .vc-sketch,
    .vc-chrome,
    .vc-photoshop {
        position: absolute;
        top: 60px;
        right: 0;
        z-index: 9;
    }

    .current-color {
        display: inline-block;
        width: 60px;
        height: 100%;
        background-color: #000;
        cursor: pointer;
    }

    .color-picker input:read-only {
        background-color: #ffffff;
    }
</style>
