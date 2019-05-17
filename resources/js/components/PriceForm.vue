<template>
    <div class="card">
        <div class="card-header">Price</div>
        <div class="card-body">
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
                        <input class="form-control" type="number" name="purchase" id="purchase" min="0" step=".01">
                    </div>
                </div>

                <div class="form-group col-sm">
                    <label for="purchase-unit">Purchase / Unit</label>
                    <div class="input-group">
                        <div class="input-group-prepend"><span class="input-group-text">€</span></div>
                        <input class="form-control" type="number" name="purchase_unit" id="purchase-unit" min="0" step=".01">
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
           Data
           ---------------------------------------------------------------------------------------------------------- */

        data() {
            return {
                packaging: null,
            }
        },

        /* ----------------------------------------------------------------------------------------------------------
           Methods
           ---------------------------------------------------------------------------------------------------------- */

        methods: {
            getPackaging(packaging_id) {
                axios.get('/api/packagings/' + packaging_id).then(response => {
                    return this.packaging = response.data;
                });
            }
        },

        /* ----------------------------------------------------------------------------------------------------------
           Callbacks
           ---------------------------------------------------------------------------------------------------------- */

        mounted() {
            const select = document.querySelector('#packaging-id');
            this.getPackaging(select.value);

            select.addEventListener('change', (event) => {
                this.getPackaging(event.target.value);
            });
        }
    }
</script>

<style scoped>

</style>