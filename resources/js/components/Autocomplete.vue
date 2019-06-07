<template>
    <div>
        <multiselect v-model="value" :options="options" label="name" track-by="name"></multiselect>
    </div>
</template>

<script>

    import Multiselect from 'vue-multiselect';

    // register globally
    Vue.component('multiselect', Multiselect);

    export default {
        name: "Autocomplete",

        components: { Multiselect },

        props: {
            'styles': Array
        },

        data () {
            return {
                value: null,
                options: this.styles
            }
        },

        mounted() {
            console.log(this.styles);
        }
    }
</script>

<style scoped>

</style>