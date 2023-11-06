import { eventBus } from './eventBus'

export const showErrorMessage = (error)=>{
    let errorMessage = error || "Something went wrong!";

    if(error.response){
        errorMessage = error.response.data.message;
    }

    eventBus.emit('toast',{
        type: 'Error',
        message: errorMessage
    });
}


export const showSuccessMessage = (success)=>{
    let successMessage = success || "Success";

    if(success.data){
        successMessage = success.data.message;
    }

    eventBus.emit('toast',{
        type: 'Success',
        message: successMessage
    });
}