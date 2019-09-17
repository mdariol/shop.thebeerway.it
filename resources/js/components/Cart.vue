<template>
    <div>
        <div class="form-group">
            <label for="company-id">Azienda</label>
            <multiselect @select="onCompanyChange" v-model="company" :options="filtered_options" label="business_name" track-by="business_name" :closeOnSelect="true" placeholder="Seleziona un indirizzo di fatturazione" ></multiselect>
             <select  name="company_id" id="company-id" class="d-none" >
                <option :value="company.id" selected>{{ company.business_name }}</option>
            </select>
        </div>

        <div class="form-group">
            <label for="shipping_address-id">Indirizzo di Spedizione</label>
            <multiselect  v-model="shipping_address" :options="filtered_shipping_addresses" label="name" track-by="name" :closeOnSelect="true" placeholder="Seleziona un indirizzo di spedizione" ></multiselect>
            <select name="shipping_address_id" id="shipping_address-id" class="d-none">
                <option :value="shipping_address.id" selected>{{ shipping_address.name }}</option>
            </select>
        </div>
    </div>
</template>

<script>
    import Multiselect from 'vue-multiselect';

    Vue.component('multiselect', Multiselect);

    export default {
        name: "Cart",

        components: { Multiselect },

        props: {
            options: Array,
            shipping_addresses: Array,
            default_company: Object,
        },


        data () {
            return {
                company: {},
                shipping_address: {},
                filtered_shipping_addresses:  [],
                filtered_options:  []
            }
        },

        methods: {
            onCompanyChange: function (event) {
                this.shipping_address = {};
                this.filtered_shipping_addresses = this.shipping_addresses.filter((address) => {
                    return address.company_id  === event.id;
                });

                // assegna l'unico indirizzo di spedizione presente
                //
                if (this.filtered_shipping_addresses.length == 1) {
                    this.shipping_address = this.filtered_shipping_addresses[0];
                } else {
                    // assegna indirizzo di spedizione di default
                    //
                    axios.get('/api/companies/' + event.id + '/shipping-address').then(response => {
                        this.shipping_address = response.data;
                    });
                }
            }
        },

        mounted() {
            this.filtered_options = this.options;
            this.company = this.default_company;
            this.onCompanyChange(this.default_company);
        }
    }
</script>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
