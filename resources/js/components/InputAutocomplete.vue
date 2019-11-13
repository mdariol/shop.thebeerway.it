<template>
    <div class="form-group">
        <label v-if="label" for="search">{{ label }}</label>

        <div class="selector" tabindex="0" @focusout="disable" @focusin="enable">
            <span class="badge badge-primary" tabindex="0" v-for="value in values">{{ value[optionLabel] }}</span>

            <input :class="['form-control', 'p-0', 'border-0', hasValue ? 'mb-1' : 'd-block']"
                   type="text" v-model="string" id="search" @input="search" placeholder="Cerca">

            <ul class="list-unstyled mb-0">
                <li v-if=" ! options.length" class="text-muted bg-light">Nessun elemento trovato...</li>
                <li :class="[values[option[optionId]] ? 'bg-primary text-white' : '']" tabindex="0"
                    v-for="option in options" @click="toggle(option)">
                    <slot v-bind:option="option">{{ option[optionLabel] }}</slot>
                </li>
            </ul>
        </div>

        <span v-if="error" class="invalid-feedback d-block"><strong>{{ error }}</strong></span>
        <small v-else="description" class="form-text text-muted">{{ description }}</small>

        <select :name="multiple ? `${name}[]` : name" :multiple="multiple" class="d-none">
            <option v-for="value in values" :value="value[optionId]" selected>{{ value[optionLabel] }}</option>
        </select>
    </div>
</template>

<script>
    export default {
        name: "InputAutocomplete",

        props: {
            route: String,
            name: String,
            label: String,
            multiple: {type: Boolean, default: false},
            searchBy: {type: String, default: 'name'},
            optionId: {type: String, default: 'id'},
            optionLabel: {type: String, default: 'name'},
            description: String,
            error: String,
        },

        computed: {
            hasValue: function () {
                return Object.keys(this.values).length;
            }
        },

        data() {
            return {
                string: '',
                options: [],
                values: {},
            }
        },

        methods: {
            search: _.debounce(function () {
                if ( ! this.string) {
                    return this.options = [];
                }

                axios.get(`${this.route}?${this.searchBy}=${this.string}`)
                    .then((response) => {this.options = response.data;});
                }, 300),

            toggle(option) {
                if (this.values[option[this.optionId]]) {
                    return Vue.delete(this.values, option[this.optionId]);
                }

                if ( ! this.multiple) {
                    this.values = {}
                }

                Vue.set(this.values, option[this.optionId], option);
            },

            enable() {
                let element = this.$el.querySelector('.selector');

                element.classList.add('selector--active');
                element.querySelector('input').focus();
            },

            disable() {
                let element = this.$el.querySelector('.selector');

                if (element.contains(event.relatedTarget)) {
                    return;
                }

                element.classList.remove('selector--active');
                this.string = '';
            },
        },
    }
</script>

<style scoped>

</style>
