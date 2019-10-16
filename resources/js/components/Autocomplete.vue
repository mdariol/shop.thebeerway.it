<template>
    <div class="form-group">
        <label :for="name">{{ label }}</label>
        <multiselect v-model="values" :options="options" label="name" track-by="name" :closeOnSelect="false" placeholder="Seleziona un'opzione" :multiple="true">


                <template slot="singleLabel" slot-scope="props" v-if="name === 'brewery'">
                    <div>
                        <span>{{ props.option.name }}</span>
                    </div>
                </template>
                <template slot="option" slot-scope="props" v-if="name === 'brewery'">
                    <div>
                        <img class="option__image" :src="'/storage/' + props.option.logo" width="40px" alt="Immagine Birrificio">
                        <span>   {{ props.option.name }}</span>
                    </div>
                </template>

        </multiselect>
        <select :name="name+'[]'" multiple class="d-none">
            <option v-for="value in values" :value="value.name" selected>{{ value.name }}</option>
        </select>

    </div>
</template>

<script>

    import Multiselect from 'vue-multiselect';

    Vue.component('multiselect', Multiselect);

    export default {
        name: "Autocomplete",

        components: { Multiselect },

        props: {
            options: Array,
            name: String,
            label: String
        },

        data () {
            return {
                values: [],
                url: new URL(window.location)
            }
        },

        mounted() {
            var search = this.url.searchParams.getAll(this.name + '[]');

//            this.url.searchParams.has(this.name + '[]');
//            console.log(this.url.searchParams.getAll(this.name + '[]'));
//            console.log(this.options);

            search.forEach(item => {
                var result = this.options.find((option) => {
                    return option.name == item;
                });

                if (result) {
                    this.values.push(result);
                }
            });
        }
    }
</script>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>