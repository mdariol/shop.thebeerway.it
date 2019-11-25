<template>
    <div>
        <div class="table-responsive">
            <table class="table">
                <thead>
                <tr>
                    <th>Birra</th>
                    <th>Packaging</th>
                    <th>Quantità</th>
                    <th>Prezzo</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="line in lines">
                    <td class="align-middle">{{ line.beer.name }}</td>
                    <td class="align-middle">{{ line.beer.packaging.name }}</td>
                    <td class="align-middle">
                        <input v-if="edit" type="number" class="form-control" v-model="line.qty"
                               @change="update(line)" style="max-width: 5rem">
                        <span v-else>{{ line.qty }}</span>
                    </td>
                    <td class="align-middle">€ {{ line.unit_price }}</td>
                </tr>
                </tbody>
            </table>
        </div>

        <p class="text-right" v-if="Object.keys(lines).length" style="font-size: 1.3rem">
            <strong>Tot. <br> € {{ tot }}</strong>
        </p>
        <p v-else>Nessuna birra nel carrello...</p>
    </div>
</template>

<script>
    export default {
        name: "Cart",

        props: {
            cart: Object,
            edit: Boolean,
        },

        computed: {
            tot() {
                let tot = Object.values(this.lines).reduce((tot, line) => tot + Number(line.price), 0);

                return tot.toFixed(2);
            },
        },

        data() {
            return {
                csfr: document.head.querySelector('meta[name="csrf-token"]').content,
                lines: {}
            }
        },

        methods: {
            update(line) {
                if (line.qty < 1) {
                    axios.post(`/lines/${line.id}`, {_method: 'delete'}).then(response => {
                        Vue.delete(this.lines, line.id, line);
                    });
                }

                if (line.qty > 0) {
                    let data = {
                        _method: 'PATCH',
                        beer_id: line.beer.id,
                        qty: line.qty,
                    };

                    axios.post(`/lines/${line.id}`, data).then(response => {
                        Vue.set(this.lines, line.id, response.data);
                    })
                }
            },
        },

        mounted() {
            this.cart.lines.forEach(line => {
                Vue.set(this.lines, line.id, line);
            });
        },
    }
</script>

<style scoped>
    table tr:last-child td {
        border-bottom: 1px solid #dee2e6;
    }
</style>
