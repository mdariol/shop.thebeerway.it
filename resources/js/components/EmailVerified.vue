<template>
    <div class="d-inline">
        <span v-if="verified" class="far fa-check-circle text-success mx-1"></span>
        <span v-else class="far fa-times-circle text-danger mx-1" @click="toggle" style="cursor: pointer;"></span>

        <div class="card border-danger m-2 shadow" style="width: 17rem; z-index: 1;"
             :hidden="hidden" tabindex="-1" @focusout="close">
            <div class="card-body text-danger">
                <h4>E-mail non verificata</h4>
                <p class="mb-0">Per favore, utilizza il link di verifica che ti abbiamo mandato via e-mail. Se non lo hai ricevuto,
                    <a :href="url" class="text-danger font-weight-bold">clicca qui per riceverne un altro</a>.</p>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "EmailVerified",

        props: {
            verified: {type: Boolean, required: true},
            url: String,
        },

        data() {
            return {
                hidden: true,
                popper: null,
            }
        },

        methods: {
            toggle() {
                this.hidden = ! this.hidden;

                if ( ! this.hidden) {
                    this.popper.update();

                    Vue.nextTick(() => {
                        this.popper.popper.focus();
                    });
                }
            },

            close() {
                if (this.popper.popper.contains(event.relatedTarget)
                    || this.popper.reference === event.relatedTarget) {
                    return;
                }

                this.hidden = true;
            }
        },

        mounted() {
            if (this.verified) {
                return;
            }

            let reference = this.$el.querySelector('.fa-times-circle');
            let popover = this.$el.querySelector('.card');

            this.popper = new Popper(reference, popover);
        }
    }
</script>

<style scoped>

</style>
