<template>
    <div class="card mb-3">
        <div class="card-header">Price</div>
        <div class="card-body">
            <div class="form-group">
                <label for="packaging-id">Packaging</label>
                <select class="form-control" v-model="packaging" name="packaging_id" id="packaging-id">
                    <option value=" ">-- select an option --</option>
                    <option v-for="packaging in packagings" :value="packaging">{{ packaging.quantity }} {{ packaging.name }} x {{ packaging.capacity / 100 }}l</option>
                </select>
            </div>

            <div class="form-row">
                <div class="form-group col-sm">
                    <label for="horeca">Horeca</label>
                    <div class="input-group">
                        <div class="input-group-prepend"><span class="input-group-text">€</span></div>
                        <input class="form-control" type="number" name="horeca" id="horeca" min="0" step=".01">
                    </div>
                </div>

                <div class="form-group col-sm">
                    <label for="horeca-unit">Horeca / Unit</label>
                    <div class="input-group">
                        <div class="input-group-prepend"><span class="input-group-text">€</span></div>
                        <input class="form-control" type="number" name="horeca_unit" id="horeca-unit" min="0" step=".01">
                    </div>
                </div>

                <div class="form-group col-sm">
                    <label for="horeca-liter">Horeca / Liter</label>
                    <div class="input-group">
                        <div class="input-group-prepend"><span class="input-group-text">€</span></div>
                        <input class="form-control" type="number" name="horeca_liter" id="horeca-liter" min="0" step=".01">
                    </div>
                </div>

                <div class="form-group col-sm">
                    <label for="discount">Discount</label>
                    <div class="input-group">
                        <input class="form-control" type="number" name="discount" id="discount" min="0" max="100">
                        <div class="input-group-append"><span class="input-group-text">%</span></div>
                    </div>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-sm">
                    <label for="purchase">Purchase</label>
                    <div class="input-group">
                        <div class="input-group-prepend"><span class="input-group-text">€</span></div>
                        <input class="form-control" v-model="purchase_price" type="number" name="purchase" id="purchase" min="0" step=".01">
                    </div>
                </div>

                <div class="form-group col-sm">
                    <label for="purchase-unit">Purchase / Unit</label>
                    <div class="input-group">
                        <div class="input-group-prepend"><span class="input-group-text">€</span></div>
                        <input class="form-control" v-on:change="calculatePurchasePrice" v-model="purchase_unit_price" type="number" name="purchase_unit" id="purchase-unit" min="0" step=".01">
                    </div>
                </div>

                <div class="form-group col-sm">
                    <label for="purchase-liter">Purchase / Liter</label>
                    <div class="input-group">
                        <div class="input-group-prepend"><span class="input-group-text">€</span></div>
                        <input class="form-control" type="number" name="purchase_liter" id="purchase-liter" min="0" step=".01">
                    </div>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-sm">
                    <label for="distribution">Distribution</label>
                    <div class="input-group">
                        <div class="input-group-prepend"><span class="input-group-text">€</span></div>
                        <input class="form-control" type="number" name="distribution" id="distribution" min="0" step=".01">
                    </div>
                </div>

                <div class="form-group col-sm">
                    <label for="distribution-unit">Distribution / Unit</label>
                    <div class="input-group">
                        <div class="input-group-prepend"><span class="input-group-text">€</span></div>
                        <input class="form-control" type="number" name="distribution_unit" id="distribution-unit" min="0" step=".01">
                    </div>
                </div>

                <div class="form-group col-sm">
                    <label for="distribution-liter">Distribution / Liter</label>
                    <div class="input-group">
                        <div class="input-group-prepend"><span class="input-group-text">€</span></div>
                        <input class="form-control" type="number" name="distribution_liter" id="distribution-liter" min="0" step=".01">
                    </div>
                </div>

                <div class="form-group col-sm">
                    <label for="margin">Margin</label>
                    <div class="input-group">
                        <input class="form-control" type="number" name="margin" id="margin" min="0" max="100">
                        <div class="input-group-append"><span class="input-group-text">%</span></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "PriceForm",

        /* ----------------------------------------------------------------------------------------------------------
           Props
           ---------------------------------------------------------------------------------------------------------- */

        props: {
            'packagings': Array,
            'beer': Object,
        },

        /* ----------------------------------------------------------------------------------------------------------
           Data
           ---------------------------------------------------------------------------------------------------------- */

        data() {
            return {
                packaging: null,
                purchase_price: null,
                purchase_unit_price: null,
            }
        },

        /* ----------------------------------------------------------------------------------------------------------
           Methods
           ---------------------------------------------------------------------------------------------------------- */

        methods: {
            calculatePurchasePrice() {
                this.purchase_price = this.purchase_unit_price * this.packaging.quantity;
            }
        },

        /* ----------------------------------------------------------------------------------------------------------
           Callbacks
           ---------------------------------------------------------------------------------------------------------- */

        mounted() {
            this.packaging = this.beer.packaging;

            /*
            axios.get('/api/packagings').then(response => {
                this.packagings = response.data;
            });

            const select = document.querySelector('#packaging-id');
            this.getPackaging(select.value);

            select.addEventListener('change', (event) => {
                this.getPackaging(event.target.value);
            });
            */
        }
    }
</script>

<style scoped>

</style>