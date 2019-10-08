<template>
    <div>
        <button class="btn btn-outline-primary" :disabled=" ! transitions.length" @click="toggle">{{ state }}</button>

        <div class="card m-2 shadow" style="z-index: 1;" tabindex="-1" @focusout="close" :hidden="hidden">
            <div class="card-body">
                <h4 class="card-title">{{ state }}</h4>
                <p>{{ message }}</p>

                <form method="POST" :action="action">
                    <input type="hidden" name="_token" :value="csfr">
                    <input type="hidden" name="_method" value="PATCH">

                    <button v-for="(transition, index) in transitions" :value="transition" name="transition"
                            :class="['btn', index ? 'btn-link' : 'btn-primary']">{{ transition }}</button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "StateMachine",

        props: {
            action: {type: String, required: true},
            state: {type: String, required: true},
            transitions: {type: Array, required: true},
            message: String
        },

        data() {
            return {
                csfr: document.head.querySelector('meta[name="csrf-token"]').content,
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
                    || event.relatedTarget === this.popper.reference) {
                    return;
                }

                this.hidden = true;
            },
        },

        mounted() {
            let reference = this.$el.querySelector('.btn');
            let popover = this.$el.querySelector('.card');

            this.popper = new Popper(reference, popover, {
                placement: 'left',
                modifiers: {
                    flip: {
                        behavior: ['left', 'bottom', 'top'],
                    },
                },
            });
        },
    }
</script>

<style scoped>
    .card {
        max-width: 17rem;
    }
    button[name="transition"],
    .card-title {
        text-transform: capitalize;
    }
</style>
