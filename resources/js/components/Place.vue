<template>
    <div class="form-group">
        <label for="address">Indirizzo</label>
        <input type="text" name="address" id="address" class="form-control" required :value="value">
    </div>
</template>

<script>
    export default {
        name: "Place",

        props: {
            'value': String
        },

        mounted() {
            let input = this.$el.querySelector('#address');
            let autocomplete = new google.maps.places.Autocomplete(input, {
                types: ['address'],
                componentRestrictions: {'country': 'IT'},
            });

            input.addEventListener('keydown', (event) => {
                if (event.keyCode === 13) {
                    event.preventDefault();
                }
            });

            autocomplete.addListener('place_changed', () => {
                if (! autocomplete.getPlace().geometry) {
                    input.setCustomValidity('L\'indirizzo inserito non è valido.');
                } else {
                    input.setCustomValidity('');
                }
            });
        }
    }
</script>

<style scoped>

</style>
