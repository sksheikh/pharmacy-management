import { axiosPrivate } from './axiosinstance';


export default {
    getVendors(){
        return axiosPrivate.get('/vendor');
    },

    addVendor(payload){
        return axiosPrivate.post('/vendor', payload);
    },

    editVendor(payload){
        return axiosPrivate.put('/vendor/'+ payload.id, payload);
    },

    deleteVendor(payload){
        return axiosPrivate.delete('/vendor/delete/'+ payload.id);
    }
}