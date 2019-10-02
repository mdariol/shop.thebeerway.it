<template>
    <div>
        <div class="form-row">
            <div class="form-group col-md">
                <label for="route">Indirizzo</label>
                <input type="text" name="route" id="route" class="form-control" required :value="route">
            </div>

            <div class="form-group col-md-3">
                <label for="postal-code">Codice Postale</label>
                <input type="text" name="postal_code" id="postal-code" class="form-control"
                       required :value="postal_code">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-12 col-md">
                <label for="city">Città</label>
                <input type="text" name="city" id="city" class="form-control" required :value="city">
            </div>

            <div class="form-group col-6 col-md">
                <label for="district">Provincia</label>
                <input type="text" name="district" id="district" class="form-control"
                       required :value="district">
            </div>

            <div class="form-group col-6 col-md-3">
                <label for="country">Stato</label>
                <input type="text" name="country" id="country" class="form-control" required
                       readonly :value="country">
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Place",

        /* ----------------------------------------------------------------------------------------------------------
           Props & Data
           ---------------------------------------------------------------------------------------------------------- */

        props: {
            'address': Object
        },

        data() {
            return {
                'route': null,
                'postal_code': null,
                'city': null,
                'district': null,
                'country': 'Italia',
            }
        },

        /* ----------------------------------------------------------------------------------------------------------
           Methods
           ---------------------------------------------------------------------------------------------------------- */

        methods: {
            /**
             * Fill the address form with the given place.
             *
             * @param {array} place
             */
            fillAddressForm(place) {
                let route = this.getPlaceComponent('route', place);
                let street_number = this.getPlaceComponent('street_number', place);

                if (street_number) {
                    route = route.concat(', ', street_number);
                }

                this.route = route;
                this.postal_code = this.getPlaceComponent('postal_code', place);
                this.city = this.getPlaceComponent('city', place);
                this.district = this.getPlaceComponent('district', place);
                this.country = this.getPlaceComponent('country', place, 'long_name');
            },

            /**
             * Get the specified component of a given place.
             *
             * @param {string} component
             * @param {array} place
             * @param {string} name
             * 
             * @returns {string}
             */
            getPlaceComponent(component, place, name = 'short_name') {
                let values = {
                    'route': 'route',
                    'street_number': 'street_number',
                    'postal_code': 'postal_code',
                    'city': 'administrative_area_level_3',
                    'district': 'administrative_area_level_2',
                    'country': 'country',
                };

                let value = '';

                place.address_components.forEach((address_component) => {
                    if (address_component.types.includes(values[component])) {
                        value = address_component[name];
                    }
                });

                return value;
            }
        },

        mounted() {
            if (this.address) {
                this.route = this.address.route;
                this.postal_code = this.address.postal_code;
                this.city = this.address.city;
                this.district = this.address.district;
                this.country = this.address.country;
            }

            let input = this.$el.querySelector('#route');
            let autocomplete = new google.maps.places.Autocomplete(input, {
                types: ['address'],
                componentRestrictions: {'country': 'IT'},
            });

            autocomplete.setFields(['address_component']);

            input.addEventListener('keydown', (event) => {
                if (event.keyCode === 13) {
                    event.preventDefault();
                }
            });

            autocomplete.addListener('place_changed', () => {
                let place = autocomplete.getPlace();

                if ( ! place.address_components) {
                    input.setCustomValidity('L\'indirizzo inserito non è valido.');
                } else {
                    input.setCustomValidity('');
                    this.fillAddressForm(place);
                }
            });
        },
    }
</script>

<style scoped>

</style>
