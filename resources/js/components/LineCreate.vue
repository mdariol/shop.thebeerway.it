<template>
<div>
    <div class="card bg-light mb-3">
        <div class="card-header">
            <a href="#beers" class="d-block text-secondary" data-toggle="collapse">Birra</a>
        </div>
        <div class="card-body collapse" id="beers">
            <input-autocomplete ref="autocomplete" :route="'/beers'" :search-by="'name'" :multiple="true"
                                :default="defaults" :description="'Seleziona le birre che vuoi aggiungere.'">
                <template v-slot:option="{option}">
                    <span :class="{strike: ! option.in_stock}">
                        {{ option.name }} <span class="ml-1 text-muted">{{ option.brewery.name }}</span> <br>
                        <small>{{ option.packaging.name }} - Disponibili {{ option.stock }}</small>
                    </span>
                </template>
            </input-autocomplete>

            <span class="btn btn-primary" style="cursor: pointer" @click="add">Aggiungi</span>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table">
            <thead>
            <tr>
                <th>Birra</th>
                <th class="d-none d-md-table-cell">Birrificio</th>
                <th>Packaging</th>
                <th>Quantità</th>
                <th>Prezzo</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="line in lines">
                <td class="align-middle">
                    {{ line.beer.name }}
                    <input class="d-none" type="number" :name="`lines[${line.beer.id}][beer_id]`"
                           id="beer-id" :value="line.beer.id">
                </td>
                <td class="d-none d-md-table-cell align-middle">{{ line.beer.brewery.name }}</td>
                <td class="align-middle">{{ line.beer.packaging.name }}</td>
                <td class="align-middle">
                    <input style="max-width: 5rem" type="number" :name="`lines[${line.beer.id}][qty]`"
                           class="form-control" v-model="line.quantity" id="beer-quantity" @change="check(line)">
                </td>
                <td class="align-middle">
                    <div class="input-group text-nowrap" style="flex-wrap: nowrap">
                        <div class="input-group-prepend">
                            <div class="input-group-text">€</div>
                        </div>
                        <input class="form-control" type="number" :name="`lines[${line.beer.id}][unit_price]`"
                               step=".01" :value="line.price" style="max-width: 6rem; width: 6rem;" required readonly>
                    </div>

                    <input type="number" :name="`lines[${line.beer.id}][price]`"  class="form-control d-none"
                           :value="line.price * line.quantity" required readonly>
                </td>
            </tr>
            </tbody>
        </table>
    </div>

    <p class="text-right" v-if="lines.length" style="font-size: 1.3rem"><strong>Tot. <br> € {{ tot }}</strong></p>
    <p v-else :class="['ml-2', errors.lines ? 'text-danger' : '']">Nessuna birra nel carrello...</p>
</div>
</template>

<script>
    import InputAutocomplete from "./InputAutocomplete";

    export default {
        name: "LineCreate",

        components: { InputAutocomplete },

        props: {
            errors: Object,
            defaults: Array,
        },

        data() {
            return {
                lines: []
            }
        },

        computed: {
            tot() {
                let tot = this.lines.reduce((tot, line) => tot + (line.price * line.quantity), 0);

                return tot.toFixed(2);
            },
        },

        methods: {
            add() {
                let ids = Object.keys(this.$refs.autocomplete.values);

                ids.forEach(id => {
                    let beer = this.$refs.autocomplete.values[id];
                    let line = this.lines.find(line => {return beer.id === line.beer.id;});

                    if ( ! line) {
                        return this.lines.push({
                            beer: beer,
                            quantity: 1,
                            price: beer.price.distribution,
                        })
                    }

                    Vue.set(line, line.quantity, line.quantity++);
                });

                this.$refs.autocomplete.values = {};
            },

            remove(line) {
                this.lines.splice(this.lines.indexOf(line), 1);
            },

            check(line) {
                if (line.quantity < 1) {
                    this.remove(line);
                }
            },
        },

        mounted() {
            console.log(this.defaults);
        }
    }
</script>

<style scoped>
.strike {
    text-decoration: line-through;
}

table tr:last-child td {
    border-bottom: 1px solid #dee2e6;
}
</style>
