<template>
    <div class="row">
        <div class="col-md mb-3">
            <div class="card">
                <h5 class="card-header">Fatturare a...</h5>
                <div class="card-body">
                    <div class="form-group">
                        <label for="billing-profile" class="d-none">Profilo di Fatturazione</label>
                        <select :class="['form-control', errors.billing_profile_id ? 'is-invalid' : '']"
                                id="billing-profile" v-model="billingProfile_" @change="update">
                            <option value selected> -- seleziona un valore -- </option>
                            <option v-for="billingProfile in billingProfiles" :key="billingProfile.id"
                                    :value="billingProfile">{{ billingProfile.name }}</option>
                        </select>
                        <small v-if="errors.billing_profile_id" class="invalid-feedback">{{ errors.billing_profile_id[0] }}</small>
                        <small v-else class="form-text text-muted">Seleziona un profilo di fatturazione.</small>

                        <input class="d-none" type="number" name="billing_profile_id" :value="billingProfile_.id">
                    </div>

                    <hr>

                    <div v-if="billingProfile_">
                        <h4 class="text-truncate">
                            {{ billingProfile_.name }}
                            <small class="text-muted ml-2">IT-{{ billingProfile_.vat_number }}</small>
                        </h4>
                        <p class="mb-0">{{ billingProfile_.address }}</p>
                    </div>
                    <p v-else class="mb-0">Nessun indirizzo di fatturazione selezionato.</p>
                </div>
            </div>
        </div>

        <div class="col-md mb-3">
            <div class="card">
                <h5 class="card-header">Spedire a...</h5>
                <div class="card-body">
                    <div class="form-group">
                        <label for="shipping-address" class="d-none">Indirizzo di Spedizione</label>
                        <select :class="['form-control', errors.shipping_address_id ? 'is-invalid' : '']"
                                id="shipping-address" v-model="shippingAddress_">
                            <option value selected> -- seleziona un valore -- </option>
                            <option v-for="shippingAddress in shippingAddresses" :key="shippingAddress.id"
                                    :value="shippingAddress">{{ shippingAddress.name }}</option>
                        </select>
                        <small v-if="errors.shipping_address_id" class="invalid-feedback">{{ errors.shipping_address_id[0] }}</small>
                        <small v-else class="form-text text-muted">Seleziona un indirizzo di spedizione.</small>

                        <input class="d-none" type="number" name="shipping_address_id"
                               :value="shippingAddress_.id">
                    </div>

                    <hr>

                    <div v-if="shippingAddress_">
                        <h4 class="text-truncate">
                            {{ shippingAddress_.name }}
                        </h4>
                        <p class="mb-0">{{ shippingAddress_.address }}</p>
                    </div>
                    <p v-else class="mb-0">Nessun indirizzo di spedizione selezionato.</p>
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
            billingProfile: { type: Object|String, default: '' },
            shippingAddress: { type: Object|String, default: '' },
            errors: Object|Array,
        },

        data() {
            return {
                shippingAddresses: [],
                shippingAddress_: '',
                billingProfile_: '',
            }
        },

        watch: {
            billingProfile_: function (newValue, oldValue) {
                if (newValue.id !== oldValue.id) {
                    this.$emit('update:billingProfile', newValue);
                }
            },

            shippingAddress_: function (newValue, oldValue) {
                if (newValue.id !== oldValue.id) {
                    this.$emit('update:shippingAddress', newValue);
                }
            }
        },

        mounted() {
            this.billingProfile_ = this.billingProfiles.find(item => {
                if (this.billingProfile) {
                    return item.id === this.billingProfile.id;
                }

                return item.is_default;
            });

            if ( ! this.billingProfile_) return this.billingProfile_ = '';

            axios.get(`/billing-profiles/${this.billingProfile_.id}/shipping-addresses`).then(response => {
                this.shippingAddresses = response.data;

                this.shippingAddress_ = this.shippingAddresses.find(item => {
                    if (this.shippingAddress) {
                        return item.id === this.shippingAddress.id;
                    }

                    return item.is_default;
                });

                if ( ! this.shippingAddress_) this.shippingAddress_ = '';
            });
        },

        methods: {
            update() {
                if ( ! this.billingProfile_) {
                    this.shippingAddress_ = '';
                    this.billingProfile_ = '';

                    return this.shippingAddresses = [];
                }

                axios.get(`/billing-profiles/${this.billingProfile_.id}/shipping-addresses`).then(response => {
                    this.shippingAddresses = response.data;

                    this.shippingAddress_ = this.shippingAddresses.find(item => {
                        return item.is_default;
                    });

                    if ( ! this.shippingAddress_) this.shippingAddress_ = '';
                });
            },
        }
    }
</script>

<style scoped>

</style>
