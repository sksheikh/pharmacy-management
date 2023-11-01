<template>
    <div class="d-flex jc-between ai-center">
        <h2>All Vendors</h2>
        <TheButton @click="addModal = true">Add new</TheButton>
    </div>

    <!--Loading-->
    <div class="text-center" v-if="gettingVendors">Loading...</div>
    <!--Table-->
    <table class="mt-4" v-else>
        <!--thead-->
        <thead>
            <tr>
                <th>Name</th>
                <th>Description</th>
                <th>Action</th>
            </tr>
        </thead>

        <!--tbody-->
        <tbody>
            <tr v-for="vendor in vendors" :key="vendor.name">
                <td>{{ vendor.name }}</td>
                <td>{{ vendor.description }}</td>
                <td>
                    <img src="/img/edit.png" alt="" class="action-icon">
                    <img src="/img/trash.png" alt="" 
                        class="action-icon action-icon--delete ml-3"
                        @click="selectedVendor = vendor, deletModal = true">
                </td>
            </tr>
        </tbody>
    </table>

    <!--add new modal-->
    <TheModal v-model="addModal" heading="Add new vendor">
        <form @submit.prevent="addNew">
            <!--vendor name-->
            <div class="form-group">
                <label class="block">Vendor Name</label>
                <input type="text" 
                    placeholder="Enter vendor name" 
                    class="mt-1 w-100"
                    v-model="addVendor.name"
                    ref="name" />
            </div>

             <!--vendor description-->
             <div class="form-group mt-3">
                <label class="block">Description</label>
                <input type="text" 
                placeholder="Write short description" 
                class="mt-1 w-100"
                v-model="addVendor.description"
                ref="description" />
            </div>

            <!--submit btn-->
            <TheButton :loading="addLoading" class="w-100 mt-3">
                Add
            </TheButton>
        </form>
    </TheModal>

    <!--delete modal-->
    <TheModal v-model="deletModal" heading="Are your sure to delete?">
        <h3 class="mb-4">Confirm if you want to delete!</h3>
        <TheButton class="mr-2" @click="deleteVendor" :loading="deleting">Yes</TheButton>
        <TheButton class="ml-2" color="gray" @click="deletModal = false">No</TheButton>
    </TheModal>
</template>

<script>
import axios from 'axios'
import TheButton from '../../components/TheButton.vue'
import TheModal from '../../components/TheModal.vue'
export default {
    data: () => ({
        addModal: false,
        deletModal:false,
        addVendor: {
            name: '',
            description: ''
        },
        selectedVendor: {},
        addLoading: false,
        vendors: [],
        gettingVendors: false,
        deleting:false

    }),
    components: {
        TheButton,
        TheModal
    },
    mounted() {
        this.getAllVendors();
    },
    methods: {
        //_______reset input data 
        resetData(){
            this.addVendor = { name: '', description: ''};
        },
        //_______add new vendor 
        addNew(){
            // console.log(this.addVendor)

            if(!this.addVendor.name){
                this.$eventBus.emit('toast',{
                type: 'Error',
                message: 'Name can\'t be empty!'
                });

                this.$refs.name.focus();

                return;
            }

            if(!this.addVendor.description){
                this.$eventBus.emit('toast',{
                type: 'Error',
                message: 'Description can\'t be empty!'
                });

                this.$refs.description.focus();

                return;
            }

     

            this.addLoading = true;
            // //TODO: Call API
            axios.post("http://127.0.0.1:8000/api/vendor",
                this.addVendor,
                {
                    headers: {
                        Authorization: localStorage.getItem("accessToken")
                    }
                }
            )
            .then(res =>{
                this.$eventBus.emit('toast',{
                type: 'Success',
                message: res.data.message
                });

                this.addModal = false;
                this.resetData();
                this.getAllVendors();


                // localStorage.setItem("accessToken", res.data.data.token)
                // this.$router.push('/dashboard');
            }).catch(err => {
                let errorMessage = 'Something went wrong';
                if(err.response){
                errorMessage = err.response.data.message;
                }

                this.$eventBus.emit('toast',{
                type: 'Error',
                message: errorMessage
                });

            }).finally(()=>{
                this.addLoading = false;
            })
        },
        //_______get all vendors 
        getAllVendors(){
            this.gettingVendors = true;

            axios.get("http://127.0.0.1:8000/api/vendor",
            {
                headers: {
                    Authorization: localStorage.getItem("accessToken")
                }

            })
            .then(res =>{
                this.vendors = res.data.data

            }).catch(err => {
                let errorMessage = 'Something went wrong';
                if(err.response){
                errorMessage = err.response.data.message;
                }

                this.$eventBus.emit('toast',{
                type: 'Error',
                message: errorMessage
                });

            }).finally(()=>{
                this.gettingVendors = false;
            })
        },

        //_______delete vendor
        deleteVendor(){
            this.deleting = true;
            axios.delete("http://127.0.0.1:8000/api/vendor/delete/"+this.selectedVendor.id,

            {
                headers: {
                    Authorization: localStorage.getItem("accessToken")
                }

            })
            .then(res =>{
                this.$eventBus.emit('toast',{
                    type: 'Success',
                    message: res.data.message
                });

                
                this.getAllVendors();
                

            }).catch(err => {
                let errorMessage = 'Something went wrong';
                if(err.response){
                errorMessage = err.response.data.message;
                }

                this.$eventBus.emit('toast',{
                type: 'Error',
                message: errorMessage
                });

            }).finally(()=>{
                this.deletModal = false;
                this.deleting = false;
            })
        }
    }
}
</script>