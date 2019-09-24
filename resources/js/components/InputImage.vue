<template>
    <div class="d-flex form-group">
        <div class="preview mr-3">
            <img :src="src" alt="">
        </div>

        <div class="flex-grow-1 position-relative">
            <label :for="name">{{ label }}</label>
            <span class="clear-input px-2" @click="clear">×</span>
            <input type="file" :class="['form-control-file', 'pr-4', {'is-invalid': error}]"
                   :name="name" :id="name" @change="preview">
            <span v-if="error" class="invalid-feedback"><strong>{{ error }}</strong></span>
        </div>
    </div>
</template>

<script>
    export default {
        name: "InputImage",

        props: {
            name: { type: String, required: true },
            label: { type: String, required: true },
            error: String,
            default: String,
        },

        data() {
            return {
                src: this.default,
            }
        },

        methods: {
            preview(event) {
                let reader = new FileReader();

                reader.onload = event => {
                    this.src = event.target.result;
                };

                reader.readAsDataURL(event.target.files[0]);
            },

            clear(event) {
                let input = event.target.nextElementSibling;

                if ( ! input.value) {
                    return;
                }

                input.value = '';
                this.src = this.default;
            }
        }
    }
</script>

<style scoped>
    .preview {
        height: 4rem;
        width: 4rem;
        position: relative;
        border-radius: .25rem;
        background-color: rgba(0, 0, 0, .03);
        overflow: hidden;
    }

    .preview img {
        width: auto;
        height: auto;
        max-width: 100%;
        max-height: 100%;
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        margin: auto;
    }

    .clear-input {
        position: absolute;
        top: 0;
        right: 0;
        margin-top: 2rem;
        cursor: pointer;
    }
</style>
