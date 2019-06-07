<template>
        <div>


                <div class="form-group row">
                        <label for="is-horeca" class="col-md-4 col-form-label text-md-right">{{ (' ') }}</label>
                        <div class="custom-control custom-switch col-md-6">
                                <input class="custom-control-input" type="checkbox"  v-model="ishoreca" name="is_horeca" id="is-horeca">
                                <label class="custom-control-label" for="is-horeca" >Utente Ho.Re.Ca. </label>
                        </div>
                </div>
                <div class="form-group row">
                        <label for="horecaname" class="col-md-4 col-form-label text-md-right">{{ ('Nome Ho.Re.Ca.') }}</label>
                        <div class="col-md-6">
                                <input  class="form-control" type="text" :readonly=" ! ishoreca" name="horecaname" id="horecaname" >
                        </div>
                </div>
                <div class="form-group row">
                        <label for="vatnumber" class="col-md-4 col-form-label text-md-right">{{ ('Partita IVA') }}</label>
                        <div class="col-md-6">
                                <input class="form-control" v-model="form.vat_id" type="text" :readonly=" ! ishoreca" name="vatnumber" id="vatnumber" @keyup="checkVatId">
                                <p class="error" v-if="vatError">{{vatErrorMsg}}</p>
                        </div>
                </div>
        </div>

</template>

<script>
    export default {
        name: "HorecaUser",

    /* ----------------------------------------------------------------------------------------------------------
    Data
    ---------------------------------------------------------------------------------------------------------- */

        data() {
            return {
                ishoreca: false,
                horecaname: null,
                vatnumber: null,
                vatError: null,
                vatErrorMsg: null,
                form: {}
            }
        },
  /* ----------------------------------------------------------------------------------------------------------
   Methods
   ---------------------------------------------------------------------------------------------------------- */

    methods: {
            checkVatId() {
                    var vatIdRegex =  new RegExp("^(IT)?[0-9]{11}$");
                    if (this.form.vat_id === '') {
                            this.vatError = true;
                            this.vatErrorMsg = "La Partita IVA è obbligatoria";
                    } else if(!vatIdRegex.test(this.form.vat_id)) {
                            // Run when user input is not matched with vat id regex.
                            this.vatError = true;
                            this.vatErrorMsg = "Indicare una partita iva valida.";
                    } else {
                            this.vatError = false;
                    }
            }
        }

    }
</script>

<style scoped>

</style>