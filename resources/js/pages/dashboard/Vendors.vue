<template>
    <div class="d-flex jc-between ai-center">
        <h2>All Vendors</h2>
        <TheButton @click="addModal = true">Add new</TheButton>
    </div>

    <!--Table-->
    <table class="mt-4">
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
                    <img src="/img/trash.png" alt="" class="action-icon action-icon--delete ml-3">
                </td>
            </tr>
        </tbody>
    </table>

    <!--modal-->
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
</template>

<script>
import axios from 'axios'
import TheButton from '../../components/TheButton.vue'
import TheModal from '../../components/TheModal.vue'
export default {
    data: () => ({
        addModal: false,
        addVendor: {
            name: '',
            description: ''
        },
        addLoading: false,
        vendors: []

    }),
    components: {
        TheButton,
        TheModal
    },
    mounted() {
        this.getVendors();
    },
    methods: {
        resetData(){
            this.addVendor = { name: '', description: ''};
        },
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
                this.addVendor)
            .then(res =>{
                this.$eventBus.emit('toast',{
                type: 'Success',
                message: res.data.message
                });

                this.addModal = false;
                this.resetData();

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

        getVendors(){
            axios.get("http://127.0.0.1:8000/api/vendor")
            .then(res =>{
                // console.log(res);
                this.vendors = res.data.data
                // console.log(this.vendors);

            }).catch(err => {
                let errorMessage = 'Something went wrong';
                if(err.response){
                errorMessage = err.response.data.message;
                }

                this.$eventBus.emit('toast',{
                type: 'Error',
                message: errorMessage
                });

            })
        }
    }
}
</script>