<template>
    <div class="container-fluid mt-3">
        <button @click="$router.back()" class="btn btn-sm btn-secondary mb-3">Back</button>
        <div class="row mb-3">
            <h3 class="h3">Items Out</h3>
        </div>
        <div class="row mb-3">
            <div class="col-md-3 mb-2">
                <input v-model="item.item_no" id="batch-item-no" class="form-control form-control-sm shadow-sm" type="text" placeholder="Item no." required autofocus="autofocus" inputmode="none">
            </div>
            <div class="col-md-3 mb-2">
                <input v-model="item.count" id="batch-item-quantity"  class="form-control form-control-sm shadow-sm" type="number" placeholder="Quantity" required>
            </div>
            <div class="col-md-3 mb-2">
                <button @click="updateCount" class="btn btn-primary btn-sm btn-primary shadow-sm">Create</button>
            </div>
        </div>
        <div class="row mb-3">
            <div v-if="batch.items" class="table-responsive">
                <table class="table table-sm table-striped">
                    <thead>
                    <tr>
                        <th scope="col">No.</th>
                        <th scope="col">Name</th>
                        <th scope="col">Scanned Quantity</th>
                        <th scope="col">Variance</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="item in batch.items" :class="(item.count_1 === item.count_2) ? 'table-success' : (item.count_2 && item.count_1 !== item.count_2) ? 'table-danger' : 'table-warning'">
                        <td>{{ item.item_no }}</td>
                        <td>{{ item.name }}</td>
                        <td>{{ item.count_2 }}</td>
                        <td>{{ (item.count_2 && item.count_1 !== item.count_2) ? item.count_1 - item.count_2 : '' }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'Dispatch',
    data() {
        return {
            batchId: null,
            item: [],
            batch: []
        }
    },
    mounted() {
        this.batchId = this.$route.params.id;
        this.getBatch()
    },
    methods: {
        async getBatch() {
            await axios.get('/api/batches/' + this.batchId).then(res => {
                this.batch = res.data
            })
        },
        async updateCount() {
            await axios.put('/api/batches/' + this.batchId + '/items/' + this.item.item_no + '/items-out', {
                count: this.item.count
            })

            await this.getBatch()

            this.item = []
            document.getElementById('batch-item-no').focus()
        }
    }
}
</script>
