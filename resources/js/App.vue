<template>
    <router-view></router-view>

    <!--toast component-->
    <!-- <div class="toasts"> -->
      <TransitionGroup name="slide-left" tag="div" class="toasts">
        <TheToast
          v-for="(toast,i) in toasts" :key="i"
          :toastType="toast.type"
          :toastMessage="toast.message">
        </TheToast>
    </TransitionGroup>

    <!-- </div> -->

  </template>

  <script>
  import Login from './pages/Login.vue';
  import TheToast from './components/TheToast.vue';
  export default{
    data: () =>({
      toasts: [
        // {
        //   type: 'Success',
        //   message: 'Successfully done'
        // },
        // {
        //   type: 'Error',
        //   message: 'Something went wrong'
        // }
      ]
    }),
    mounted(){
      this.$eventBus.on('toast', (data) => {
        this.toasts.push(data);
        this.removeOneToast();

      } )
    },
    methods: {
      removeOneToast(){
        setTimeout(() => {
            this.toasts.shift();
        }, 2000);
      }
    },
    components:{
      Login,
      TheToast
    }
  }
  </script>

  <style>
  .slide-left-enter-active,
  .slide-left-leave-active {
    transition: all 0.25s ease;
  }
  .slide-left-enter-from,
  .slide-left-leave-to {
    opacity: 0;
    transform: translateX(30px);
  }
  </style>
