<template>
    <div class="login-page">
        <div class="login-card">

            <div class="text-center">
                <img src="/img/lock.png" class="login-card__icon" alt="">
                <h2>User Login</h2>
            </div>

            <!--Form start-->
            <form action="#" @submit.prevent="handleSubmit">
                <!--Email-->
                <label class="block">Email</label>
                <input type="email" class="w-100"
                  placeholder="Enter your email"
                  v-model="formData.email"
                  ref="email"
                  required>

                <!--Password-->
                <label class="block mt-3">Password</label>
                <input type="password" class="w-100"
                  placeholder="Enter your password"
                  v-model="formData.password"
                  ref="password"
                  required>

                <!--submit btn-->
                <TheButton :block="true" :loading="loggingIn" class="mt-3">
                    Login
                </TheButton>

                <div class="d-flex jc-between mt-3">
                    <div>
                        <label >
                            <input type="checkbox">Remember me
                        </label>
                    </div>
                    <div>
                        <a href="#">Forgot password?</a>
                    </div>
                </div>
            </form>
            <!--Form end-->
        </div>
    </div>
</template>

<script>
import axios from 'axios'
import TheButton from '../components/TheButton.vue'
export default {
  data: () => ({

    formData: {
      email: '',
      password: '',
    },
    moveToRight: false,
    showing: false,
    loggingIn: false
  }),
  methods : {
    handleSubmit(){
    //   console.log(this.formData);
      // console.log(this.formData);
      if(!this.formData.email){
        // alert('Email can\'t be empty!');
        this.$eventBus.emit('toast',{
          type: 'Error',
          message: 'Email can\'t be empty!'
        });

        this.$refs.email.focus();

        return;
      }

      if(this.formData.password.length < 6){
        // alert('Password must be at least 6 character long!');
        this.$eventBus.emit('toast',{
          type: 'Error',
          message: 'Password must be at least 6 character long!'
        });

        this.$refs.password.focus();

        return;
      }

      this.loggingIn = true;
      //TODO: Call API
      axios.post("http://127.0.0.1:8000/api/login",this.formData)
      .then(res =>{
        // console.log(res.data.data.token);
        this.$eventBus.emit('toast',{
          type: 'Success',
          message: res.data.message
        });

        localStorage.setItem("accessToken", res.data.data.token)
        this.$router.push('/dashboard');
      }).catch(err => {
        // console.log(err.response.data);
        let errorMessage = 'Something went wrong';
        if(err.response){
          errorMessage = err.response.data.message;
        }

        this.$eventBus.emit('toast',{
          type: 'Error',
          message: errorMessage
        });

      }).finally(()=>{
        this.loggingIn = false;
      })
      // console.log(this.formData)


    }
  },
  components: {
    TheButton
  }
}
</script>

<style>
.box {
  width: 55px;
  height: 55px;
  background-color: greenyellow;
  margin-bottom: 22px;
  transition: all 0.5s;
}

.box--right {
  margin-left: 222px;
}

.box1 {
  width: 55px;
  height: 55px;
  background-color: greenyellow;
  margin-bottom: 22px;
  animation: showhide 1s ease-in;
}

.login-page {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  display: flex;
  justify-content: center;
  align-items: center;
  background-color: rgb(235, 235, 235);
}

.login-card {
  width: 400px;
  /* border: 1px solid gray; */
  min-height: 193px;
  box-shadow: 0px 2px 9px 4px #dfdfdf;
  background-color: #fff;
  border-radius: 5px;
  padding: 44px 33px;
}

.login-card input[type="text"],
.login-card input[type="password"] {
  width: 100%;
}

.login-card__icon {
  max-width: 77px;
  text-align: center;
}

/* button{
    background-color: #000 !important;
    color: #fff;
    padding: 10px 0;
    cursor: pointer;
} */

@keyframes showhide {
  0% {
    opacity: 0;
    transform: scale(0.5);
  }

  50% {
    opacity: 0.5;
    transform: scale(1.2);
  }

  100% {
    opacity: 1;
    transform: scale(1);
  }
}

.showhide-enter-active {
  animation: showhide 1s ease-in;
  /* transition: all 0.5s; */
}
.showhide-enter-from {
   /* opacity: 0;
 transform: scale(0.5); */
}

.showhide-enter-to {
 /* opacity: 1;
  transform: scale(1); */
}

.showhide-leave-active {
  animation: showhide 1s ease-in reverse;
  /* transition: all 0.5s; */
}
.showhide-leave-from {
  /* opacity: 1;
  transform: scale(1); */
}

.showhide-leave-to {
  /* opacity: 0;
  transform: scale(0.5); */
}
</style>
