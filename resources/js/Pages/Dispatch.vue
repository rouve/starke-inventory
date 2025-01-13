<template>
    <div class="container-fluid mt-3">
        <button @click="$router.back()" class="btn btn-sm btn-secondary mb-3">Back</button>
        <div class="row">
            <h3 class="h3">Dispatch</h3>
        </div>
        <span v-if="batch.items" class="text-muted">{{batch.company_name}}</span>
        <div class="row mb-3">
            <div class="col-md-3 mb-2">
                <input v-model="item.item_no" id="batch-item-no" class="form-control form-control-sm shadow-sm" type="text" placeholder="Item no." required autofocus="autofocus" inputmode="none">
            </div>
            <div class="col-md-3 mb-2">
                <button @click="updateCount" class="btn btn-primary btn-sm btn-primary shadow-sm">Create</button>
            </div>
        </div>
        <validation-errors :errors></validation-errors>
        <div class="row mb-3">
            <div v-if="batch.items" class="table-responsive">
                <table class="table table-sm table-striped">
                    <thead>
                    <tr>
                        <th scope="col">No.</th>
                        <th scope="col">Name</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">Scanned Quantity</th>
                        <th scope="col">Variance</th>
                        <th scope="col">-</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="item in batch.items" :class="(item.count_1 === item.quantity) ? 'table-success' : (item.count_1 && item.count_1 !== item.quantity) ? 'table-danger' : 'table-warning'">
                        <td>{{ item.item_no }}</td>
                        <td>{{ item.name }}</td>
                        <td>{{ item.quantity }}</td>
                        <td>{{ item.count_1 }} <a @click="deleteCount(item.item_no)" v-if="item.count_1 > 0" href="#" class="link-dark">clear</a></td>
                        <td>{{ (item.count_1 && item.count_1 !== item.quantity) ? item.count_1 - item.quantity : '' }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
import ValidationErrors from "../ValidationErrors.vue";
import data from "bootstrap/js/src/dom/data.js";

export default {
    name: 'Dispatch',
    components: {ValidationErrors},
    data() {
        return {
            batchId: null,
            item: [],
            batch: [],
            errors: []
        }
    },
    async mounted() {
        this.batchId = this.$route.params.id;
        await this.getBatch()
    },
    methods: {
        async getBatch(){
            await axios.get('/api/batches/' + this.batchId).then(res => {
                this.batch = res.data
            }).catch(err => {
                this.errors.push(err.response.data.message)
            })
        },
        async updateCount(){
            this.clearErrors()

            await axios.put('/api/batches/'+this.batchId+'/dispatch', {
                item_no: this.item.item_no,
            }).then(res => {
                if(res.data === 0) this.errors.push('Invalid Item')
            }).catch(err => {
                this.errors.push(err.response.data.message)
            })

            await this.getBatch()

            this.item = []
            document.getElementById('batch-item-no').focus()
        },
        async deleteCount(item_no){
            if(confirm("Are you sure you would like to reset count?")) {
                await axios.delete('/api/batches/' + this.batchId + '/dispatch', {
                    params: {
                        item_no: item_no
                    }
                })

                await this.getBatch()
            }
        },
        clearErrors(){
            this.errors = []
        },
    }
}
</script>
