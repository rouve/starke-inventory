<template>
    <div class="container-fluid mt-3">
        <div class="row mb-3">
            <h3 class="h3">Batches</h3>
        </div>
        <div class="row mb-3">
            <div class="col-md-3 mb-2">
                <input id="batch-name" v-model="batch.name" class="form-control form-control-sm shadow-sm" type="text" placeholder="Batch Name">
            </div>
            <div class="col-md-3 mb-2">
                <input id="batch-company-name" v-model="batch.company_name" class="form-control form-control-sm shadow-sm" type="text" placeholder="Company Name">
            </div>
            <div class="col-md-3 mb-2">
                <input id="batch-file" v-on:change="handleFileChanges" class="form-control form-control-sm shadow-sm" type="file">
            </div>
            <div class="col-md-3 mb-2">
                <button @click="createBatch" class="btn btn-primary btn-sm btn-primary shadow-sm">Create</button>
            </div>
        </div>
        <div v-if="loading" class="row mb-3">
            <div class="spinner-grow spinner-grow-sm" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
        <div class="row mb-3 justify-content-center">
            <button @click="getBatches" class="btn btn-secondary btn-sm shadow-sm col-10"><i class="bi bi-arrow-clockwise"></i> Refresh</button>
        </div>
        <div v-if="batches.total" class="row mb-3">
            <div class="table-responsive">
                <table class="table table-striped table-sm">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col" colspan="2">Progress</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="batch in batches.data">
                            <td class="align-middle">{{ batch.name }}</td>
                            <td>
                                <div class="multi-step checked">
                                    <ul class="multi-step-list">
                                        <li @click="openDispatch(batch.id)" :class="((batch.hasQuantityVariances) ? 'error current ': 'completed ') + 'multi-step-item active'">
                                            <div class="item-wrap">
                                                <p class="item-title">Dispatch</p>
                                            </div>
                                        </li>
                                        <li @click="openItemsOut(batch.id)" v-if="!batch.hasQuantityVariances" :class="((batch.hasCountVariances) ? 'error current ' : 'completed ') + 'multi-step-item active'">
                                            <div class="item-wrap">
                                                <p class="item-title">Items Out</p>
                                            </div>
                                        </li>
                                        <li>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                            <td class="align-middle">
                                <button @click="destroyBatch(batch.id)" class="btn btn-sm btn-danger"><i class="bi-trash-fill"></i></button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div v-else-if="!loading && !batches.length" class="row">
            <span class="text-muted">No Batches Created</span>
        </div>
    </div>
</template>

<script>
    import router from "../router.js";

    export default {
        name: 'Batches',
        data (){
            return {
                batch: [],
                batches: [],
                loading: false,
            }
        },
        mounted(){
            this.getBatches()
        },
        methods:{
            async getBatches(){
                this.loading = true

                await axios.get('/api/batches').then((res) => {
                    this.batches = res.data;
                })

                this.loading = false
            },
            async createBatch(){
                await axios.post('/api/batches', {
                    name: this.batch.name,
                    company_name: this.batch.company_name,
                    file: this.batch.file
                }, {
                    headers: {
                        'Content-Type':'multipart/form-data'
                    },
                }).then(() => {
                    this.getBatches()
                    this.batch = []
                })
            },
            destroyBatch(id){
                if(confirm('Are you sure you want to delete this batch?')){
                    axios.delete('/api/batches/'+id).then(() => {
                        this.getBatches()
                    })
                }
            },
            handleFileChanges(e){
                this.batch.file = e.target.files[0];
            },
            openDispatch(id){
                router.push('batches/'+id+'/dispatch');
            },
            openItemsOut(id){
                router.push('batches/'+id+'/items-out');
            }
        }
    }
</script>
