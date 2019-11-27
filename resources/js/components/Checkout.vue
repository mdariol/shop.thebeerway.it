<template>
    <div>
        <div class="d-flex breadcrumb justify-content-center mb-4">
            <div v-for="(step, index) in nodes" class="mx-3 d-flex flex-column pt-1">
                <div :class="[++index <= current ? 'bg-primary' : 'bg-secondary', { 'active-step': isCurrentStep(index) },'rounded-circle', 'mx-auto', 'd-flex']" style="width: 3rem; height: 3rem">
                    <span class="align-self-center text-white mx-auto"><strong>{{ index }}</strong></span>
                </div>
                <div class="text-center mt-2">{{ step.dataset.title }}</div>
            </div>
        </div>

        <section v-show="isCurrentStep(1)" data-title="Fatturazione">
            <h1>Fatturazione & Spedizione</h1>
            <p>Selezione un indirizzo di spedizione e un profilo di fatturazione.</p>

            <billing-shipping :billing-profiles="billingProfiles" :billing-profile.sync="billingProfile"
                              :shipping-address.sync="shippingAddress" :errors="errors"></billing-shipping>

            <div class="form-group">
                <label for="delivery-note">Note di Spedizione</label>
                <textarea v-model="deliveryNote" name="deliverynote" id="delivery-note"
                          cols="30" rows="5" class="form-control"></textarea>
                <small class="text-form text-muted">Comunica le tue preferenze.</small>
            </div>

            <div class="card mb-3">
                <div class="card-header">
                    <a href="#policy" class="d-block text-secondary" data-toggle="collapse">Condizioni di Vendita</a>
                </div>
                <div class="card-body collapse overflow-auto" id="policy" style="height: 250px">
                    {{ policy.content }}
                </div>
            </div>

            <div class="form-group form-check">
                <input type="checkbox" name="policy_id" :value="policy.id" id="policy-id" required
                       :class="['form-check-input', errors.policy_id ? 'is-invalid' : '']">
                <label for="policy-id" class="form-check-label">Accetto le Condizioni di Vendita</label>
                <small v-if="errors.policy_id" class="invalid-feedback">{{ errors.policy_id }}</small>
                <small v-else class="text-form text-muted d-block">Dichiaro di aver letto e accettato le condizioni di vendita.</small>
            </div>
        </section>

        <section v-show="isCurrentStep(2)" data-title="Riepilogo">
            <h1>Riepilogo ordine</h1>
            <p>Controlla gli indirizzi e il contenuto del carrello, quindi conferma l'ordine.</p>

            <div class="row">
                <div class="col-md mb-3">
                    <div class="card">
                        <h5 class="card-header">Fatturare a...</h5>
                        <div class="card-body">
                            <div v-if="billingProfile">
                                <h4 class="text-truncate">
                                    {{ billingProfile.name }}
                                    <small class="text-muted ml-2">IT-{{ billingProfile.vat_number }}</small>
                                </h4>
                                <p class="mb-0">{{ billingProfile.address }}</p>
                            </div>
                            <p v-else class="mb-0">Nessun indirizzo di fatturazione selezionato.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md mb-3">
                    <div class="card">
                        <h5 class="card-header">Spedire a...</h5>
                        <div class="card-body">
                            <div v-if="shippingAddress">
                                <h4 class="text-truncate">
                                    {{ shippingAddress.name }}
                                </h4>
                                <p class="mb-0">{{ shippingAddress.address }}</p>
                            </div>
                            <p v-else class="mb-0">Nessun indirizzo di spedizione selezionato.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div v-if="deliveryNote" class="card bg-light mb-3 overflow-auto" style="max-height: 150px">
                <div class="card-body">
                    <h5>Note di Spedizione</h5>
                    <p class="mb-0">{{ deliveryNote }}</p>
                </div>
            </div>

            <h3>Carrello</h3>
            <cart :cart="cart" :edit="false"></cart>
        </section>

        <span v-if=" ! isLastStep" class="btn btn-primary" style="cursor: pointer" @click="nextStep">Continua</span>
        <button v-if="isLastStep" class="btn btn-primary">Acquista</button>
        <span v-if=" ! isFirstStep" class="btn btn-link" style="cursor: pointer" @click="prevStep">Precedente</span>
    </div>
</template>

<script>
    import BillingShipping from "./BillingShipping";
    import Cart from "./Cart";

    export default {
        name: "Checkout",

        components: { BillingShipping, Cart },

        props: {
            billingProfiles: Array,
            policy: Object,
            cart: Object,
            errors: [Object, Array],
        },

        computed: {
            isFirstStep() { return this.current === 1; },
            isLastStep() { return this.current === this.steps; },
        },

        data() {
            return {
                current: 1,
                steps: 1,
                billingProfile: null,
                shippingAddress: null,
                deliveryNote: '',
                nodes: null,
            }
        },

        methods: {
            isCurrentStep(step) {
                return step === this.current;
            },

            nextStep() {
                if (document.forms['checkout'].reportValidity()) {
                    this.current++;
                }
            },

            prevStep() {
                this.current--;
            }
        },

        mounted() {
            this.nodes = this.$el.querySelectorAll('section');
            this.steps = this.$el.querySelectorAll('section').length;
        },
    }
</script>

<style scoped>
    .active-step {
        box-shadow: 0 0 0 0.2rem rgba(52, 144, 220, 0.25);
    }

    .breadcrumb > div:first-child {
        margin-left: 0 !important;
    }

    .breadcrumb > div:last-child {
        margin-right: 0 !important;
    }
</style>
