<template>
    <div class="card mb-3">
        <div class="card-header">Price calculator</div>
        <div class="card-body">
            <div class="form-group">
                <label for="packaging-id">Packaging</label>
                <select class="form-control" @change="calculatePrices" v-model="packaging" name="packaging_id"
                        id="packaging-id">
                    <option value=" ">-- select an option --</option>
                    <option v-for="packaging in packagings" :value="packaging">
                        {{ packaging.quantity }} {{ packaging.type }} x {{ packaging.capacity / 100 }}l
                    </option>
                </select>
            </div>

            <div class="form-row">
                <div class="form-group col-sm">
                    <label for="horeca">Horeca</label>
                    <div class="input-group">
                        <div class="input-group-prepend"><span class="input-group-text">€</span></div>
                        <input class="form-control" @input="calculateHorecaUnitPrice" v-model="horeca.total"
                               type="number" name="horeca" id="horeca" min="0" step=".01">
                    </div>
                </div>

                <div class="form-group col-sm">
                    <label for="horeca-unit">Horeca / Unit</label>
                    <div class="input-group">
                        <div class="input-group-prepend"><span class="input-group-text">€</span></div>
                        <input class="form-control" @input="calculateHorecaTotalPrice" v-model="horeca.unit"
                               type="number" name="horeca_unit" id="horeca-unit" min="0" step=".01">
                    </div>
                    <small class="form-text text-muted">Price per liter: € {{ horecaLiter }}</small>
                </div>

                <div class="form-group col-sm">
                    <label for="discount">Discount</label>
                    <div class="input-group">
                        <input class="form-control" @input="calculatePurchasePricesFromDiscount" v-model="discount"
                               type="number" name="discount" id="discount" min="0" max="100">
                        <div class="input-group-append"><span class="input-group-text">%</span></div>
                    </div>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-sm">
                    <label for="purchase">Purchase</label>
                    <div class="input-group">
                        <div class="input-group-prepend"><span class="input-group-text">€</span></div>
                        <input class="form-control" @input="calculatePurchaseUnitPrice" v-model="purchase.total"
                               type="number" name="purchase" id="purchase" min="0" step=".01">
                    </div>
                </div>

                <div class="form-group col-sm">
                    <label for="purchase-unit">Purchase / Unit</label>
                    <div class="input-group">
                        <div class="input-group-prepend"><span class="input-group-text">€</span></div>
                        <input class="form-control" @input="calculatePurchaseTotalPrice" v-model="purchase.unit"
                               type="number" name="purchase_unit" id="purchase-unit" min="0" step=".01">
                    </div>
                    <small class="form-text text-muted">Price per liter: € {{ purchaseLiter }}</small>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-sm">
                    <label for="distribution">Distribution</label>
                    <div class="input-group">
                        <div class="input-group-prepend"><span class="input-group-text">€</span></div>
                        <input class="form-control" @input="calculateDistributionUnitPrice()"
                               v-model="distribution.total" :disabled="fixedMargin" type="number" name="distribution"
                               id="distribution" min="0" step=".01">
                    </div>
                </div>

                <div class="form-group col-sm">
                    <label for="distribution-unit">Distribution / Unit</label>
                    <div class="input-group">
                        <div class="input-group-prepend"><span class="input-group-text">€</span></div>
                        <input class="form-control" @input="calculateDistributionTotalPrice"
                               v-model="distribution.unit" :disabled="fixedMargin" type="number"
                               name="distribution_unit" id="distribution-unit" min="0" step=".01">
                    </div>
                    <small class="form-text text-muted">Price per liter: € {{ distributionLiter }}</small>
                </div>

                <div class="form-group col-sm">
                    <label for="margin">Margin</label>
                    <div class="input-group">
                        <div class="input-group-prepend"><div class="input-group-text">
                            <input type="checkbox" v-model="fixedMargin" name="fixed_margin" id="fixed-margin">
                        </div></div>
                        <input class="form-control" @input="calculateDistributionPricesFromMargin" v-model="margin" type="number"
                               :disabled=" ! fixedMargin" name="margin" id="margin" min="0" max="100">
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

        computed: {
            horecaLiter: function () {
                return this.calculateLiterPrice(this.horeca);
            },

            purchaseLiter: function () {
                return this.calculateLiterPrice(this.purchase);
            },

            distributionLiter: function () {
                return this.calculateLiterPrice(this.distribution);
            },
        },

        /* ----------------------------------------------------------------------------------------------------------
           Data
           ---------------------------------------------------------------------------------------------------------- */

        data() {
            return {
                packaging: null,
                discount: null,
                fixedMargin: null,
                margin: null,

                horeca: {
                    total: null,
                    unit: null,
                },

                purchase: {
                    total: null,
                    unit: null,
                },

                distribution: {
                    total: null,
                    unit: null,
                }
            }
        },

        /* ----------------------------------------------------------------------------------------------------------
           Methods
           ---------------------------------------------------------------------------------------------------------- */

        methods: {
            calculatePrices() {
                if (this.horeca.total) {
                    this.calculateHorecaUnitPrice();

                    return;
                }

                if (this.horeca.unit) {
                    this.calculateHorecaTotalPrice();

                    return;
                }

                if (this.purchase.total) {
                    this.calculatePurchaseUnitPrice();

                    return;
                }

                if (this.purchase.unit) {
                    this.calculatePurchaseTotalPrice();
                }
            },

            calculateHorecaTotalPrice() {
                this.calculateTotalPrice(this.horeca);

                if (this.discount) {
                    this.calculatePurchasePricesFromDiscount();
                }
            },

            calculateHorecaUnitPrice() {
                this.calculateUnitPrice(this.horeca);

                if (this.discount) {
                    this.calculatePurchasePricesFromDiscount();
                }
            },

            calculatePurchasePricesFromDiscount() {
                if ( ! this.horeca.total) {
                    return;
                }

                this.purchase.total = (this.horeca.total - (this.horeca.total * this.discount / 100)).toFixed(2);
                this.calculatePurchaseUnitPrice();
            },

            calculatePurchaseTotalPrice() {
                this.calculateTotalPrice(this.purchase);

                if (this.fixedMargin) {
                    this.calculateDistributionPricesFromMargin()
                }
            },

            calculatePurchaseUnitPrice() {
                this.calculateUnitPrice(this.purchase);

                if (this.fixedMargin) {
                    this.calculateDistributionPricesFromMargin()
                }
            },

            calculateDistributionPricesFromMargin() {
                if ( ! this.purchase.total) {
                    return;
                }

                this.distribution.total = (this.purchase.total * 100 / (100 - this.margin)).toFixed(2);
                this.calculateDistributionUnitPrice();
            },

            calculateDistributionTotalPrice() {
                this.calculateTotalPrice(this.distribution);

                if ( ! this.fixedMargin) {
                    this.calculateMarginFromDistributionPrice();
                }
            },

            calculateDistributionUnitPrice() {
                this.calculateUnitPrice(this.distribution);

                if ( ! this.fixedMargin) {
                    this.calculateMarginFromDistributionPrice();
                }
            },

            calculateMarginFromDistributionPrice() {
                this.margin = (((this.distribution.total - this.purchase.total) / this.distribution.total) * 100).toFixed(2);
            },

            /* ----- Helper functions ----- */

            calculateUnitPrice(prices) {
                prices.unit = (prices.total / this.packaging.quantity).toFixed(2);
            },

            calculateTotalPrice(prices) {
                prices.total = (prices.unit * this.packaging.quantity).toFixed(2);
            },

            calculateLiterPrice(prices) {
                if ( ! this.packaging) {
                    return 0.00;
                }

                return (prices.unit / (this.packaging.capacity / 100)).toFixed(2);
            }
        },

        /* ----------------------------------------------------------------------------------------------------------
           Callbacks
           ---------------------------------------------------------------------------------------------------------- */

        mounted() {
            this.packaging = this.beer.packaging;
            this.fixedMargin = this.packaging.fixed_margin;
        }
    }
</script>

<style scoped>

</style>