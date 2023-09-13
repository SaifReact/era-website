<template>
    <div>
        <button type="button" v-for="item in JSON.parse(name)['buttons']" :class="buttonType(item)" @click="click(data, item.name)">
            <i :class="item.iconClass" ></i><!--{{item.name}}-->
        </button>
    </div>
</template>

<script>
    import { EDIT, DELETE } from '../../../repositories/ActionButtonsRepository';
    import _ from 'lodash';

export default {
    name: 'ActionButtonGroup',
    props: {
        data: {},
        name: {},
        click: {
            type: Function,
            default: () => {}
        },
        classes: {
            type: Object,
            default: () => ({
                'btn': true,
            }),
        },
    },
    methods: {
        buttonType(item) {
            let klasses = {};
            klasses = _.cloneDeep(this.classes);

            if (item.name === EDIT) {
                klasses['bg-primary'] = true;
                klasses['text-white'] = true;
                return klasses;
            } else if (item.name === DELETE) {
                klasses['bg-danger'] = true;
                klasses['text-white'] = true;
                return klasses;
            }

            return klasses;
        }
    }
}
</script>
