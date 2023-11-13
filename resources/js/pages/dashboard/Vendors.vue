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

                    <!--edit btn-->
                    <img src="/img/edit.png" alt="" class="action-icon"
                    @click="selectedVendor = vendor, editModal = true">
                    
                    <!--delete btn-->
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

     <!--edit modal-->
     <TheModal v-model="editModal" heading="Edit vendor">
        <form @submit.prevent="editVendor">
            <!--vendor name-->
            <div class="form-group">
                <label class="block">Vendor Name</label>
                <input type="text" 
                    placeholder="Enter vendor name" 
                    class="mt-1 w-100"
                    v-model="selectedVendor.name"
                    ref="name" />
            </div>

             <!--vendor description-->
             <div class="form-group mt-3">
                <label class="block">Description</label>
                <input type="text" 
                placeholder="Write short description" 
                class="mt-1 w-100"
                v-model="selectedVendor.description"
                ref="description" />
            </div>

            <!--submit btn-->
            <TheButton :loading="editLoading" class="w-100 mt-3">
                Update changes
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
import { showErrorMessage, showSuccessMessage } from '../../utils/function';
import privateService from '../../Service/privateService';

export default {
    data: () => ({
        addModal: false,
        deletModal:false,
        editModal:false,
        addVendor: {
            name: '',
            description: ''
        },
        selectedVendor: {},
        addLoading: false,
        editLoading:false,
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
            //_________ check validation
            if(!this.addVendor.name){
                showErrorMessage('Name can\'t be empty!');
                this.$refs.name.focus();
                return;
            }

            if(!this.addVendor.description){
                showErrorMessage('Description can\'t be empty!');
                this.$refs.description.focus();
                return;
            }

            this.addLoading = true;
        
            privateService
            .addVendor(this.addVendor)
            .then(res =>{
                showSuccessMessage(res);
                this.addModal = false;
                this.resetData();
                this.getAllVendors();

            }).catch(err => {
                showErrorMessage(err);

            }).finally(()=>{
                this.addLoading = false;
            })
        },

        //_______get all vendors
        getAllVendors(){
            this.gettingVendors = true;

            privateService
            .getVendors()
            .then(res =>{
                this.vendors = res.data.data

            }).catch(err => {
                showErrorMessage(err);

            }).finally(()=>{
                this.gettingVendors = false;
            })
        },

        //_______delete vendor
        deleteVendor(){
            this.deleting = true;
            // axios.delete("http://127.0.0.1:8000/api/vendor/delete/"+this.selectedVendor.id,

            // {
            //     headers: {
            //         Authorization: localStorage.getItem("accessToken")
            //     }

            // })
            privateService
            .deleteVendor(this.selectedVendor)
            .then(res =>{
                showSuccessMessage(res);
                this.getAllVendors();

            }).catch(err => {
                showErrorMessage(err);

            }).finally(()=>{
                this.deletModal = false;
                this.deleting = false;
            })
        },

        //_______delete vendor method
        editVendor(){
            //______validation
            if(!this.selectedVendor.name){
                showErrorMessage('Name can\'t be empty!');
                this.$refs.name.focus();
                return;
            }

            if(!this.selectedVendor.description){
                showErrorMessage('Description can\'t be empty!')
                this.$refs.description.focus();
                return;
            }

            //______loader
            this.editLoading = true;

            //_____Api call
            privateService
            .editVendor(this.selectedVendor)
            .then(res =>{
                showSuccessMessage(res);

            }).catch(err => {
                showErrorMessage(err);

            }).finally(()=>{
                this.editModal = false;
                this.editLoading = false;
                this.getAllVendors();
            })
        }

    }
}
</script>
