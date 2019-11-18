<template>
    <div class="row">
        <div class="col-md mb-3">
            <div class="card">
                <h5 class="card-header">
                    Fatturare a...
                </h5>
                <div class="card-body">
                    <div class="form-group">
                        <label for="billing-profile" class="d-none">Profilo di Fatturazione</label>
                        <select :class="['form-control', errors.billing_profile_id ? 'is-invalid' : '']"
                                id="billing-profile" v-model="billingProfile" @change="update">
                            <option value selected> -- seleziona un valore -- </option>
                            <option v-for="billingProfile in billingProfiles" :value="billingProfile">{{ billingProfile.name }}</option>
                        </select>
                        <small v-if="errors.billing_profile_id" class="invalid-feedback">{{ errors.billing_profile_id[0] }}</small>
                        <small v-else class="form-text text-muted">Seleziona un profilo di fatturazione.</small>

                        <input class="d-none" type="number" name="billing_profile_id" :value="billingProfile.id">
                    </div>

                    <hr>

                    <div v-if="billingProfile">
                        <h4 class="text-truncate">
                            {{ billingProfile.name }}
                            <small class="text-muted ml-2">IT-{{ billingProfile.vat_number }}</small>
                        </h4>
                        <p>{{ billingProfile.address }}</p>
                    </div>
                    <p v-else>Nessun indirizzo di fatturazione selezionato.</p>
                </div>
            </div>
        </div>

        <div class="col-md mb-3">
            <div class="card">
                <h5 class="card-header">
                    Spedire a...
                </h5>

                <div class="card-body">
                    <div class="form-group">
                        <label for="shipping-address" class="d-none">Indirizzo di Spedizione</label>
                        <select :class="['form-control', errors.shipping_address_id ? 'is-invalid' : '']"
                                id="shipping-address" v-model="shippingAddress">
                            <option value selected> -- seleziona un valore -- </option>
                            <option v-for="shippingAddress in shippingAddresses" :value="shippingAddress">{{ shippingAddress.name }}</option>
                        </select>
                        <small v-if="errors.shipping_address_id" class="invalid-feedback">{{ errors.shipping_address_id[0] }}</small>
                        <small v-else class="form-text text-muted">Seleziona un indirizzo di spedizione.</small>

                        <input class="d-none" type="number" name="shipping_address_id" :value="shippingAddress.id">
                    </div>

                    <hr>

                    <div v-if="shippingAddress">
                        <h4 class="text-truncate">
                            {{ shippingAddress.name }}
                        </h4>
                        <p>{{ shippingAddress.address }}</p>
                    </div>
                    <div v-else>
                        <p>Nessun indirizzo di spedizione selezionato.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "BillingShipping",

        props: {
            billingProfiles: Array,
            errors: Object,
        },

        data() {
            return {
                shippingAddresses: [],
                shippingAddress: '',
                billingProfile: '',
            }
        },

        mounted() {
            this.billingProfile = this.billingProfiles.find(item => {
                return item.is_default;
            });

            this.update();
        },

        methods: {
            update() {
                if ( ! this.billingProfile) {
                    this.shippingAddress = '';
                    this.billingProfile = '';

                    return this.shippingAddresses = [];
                }

                axios.get(`/billing-profiles/${this.billingProfile.id}/shipping-addresses`).then(response => {
                    this.shippingAddresses = response.data;

                    this.shippingAddress = this.shippingAddresses.find(item => {
                        return item.is_default;
                    });

                    if ( ! this.shippingAddress) this.shippingAddress = '';
                });
            }
        }
    }
</script>

<style scoped>

</style>
