<template>
  <header class="p-3 b-b-accent b-b-1">
    <div class="grid grid-2-8-2">
      <figure>
        <a href="{{base}}" @click.prevent="navigate('/')">
          <img class="w-25p b-primary b-1 b-rounded raise-1-accent" src="{{base}}asset/vastn3-sm.png" alt="logo">
        </a>
      </figure>
      <div class="place-x-end place-y-center">
        <ui-button @click.prevent="navigate('/ui')" class="m-r-2" >
          <a style="color:inherit" href="{{base}}ui">UI</a>
        </ui-button>
        <ui-button @click.prevent="navigate('/products')"  class="m-r-2">
          <ui-icon>storefront</ui-icon>
          <a style="color:inherit" href="{{base}}products"> "shop"</a>

        </ui-button>




      </div>
      <div class="place-x-end place-y-center position-relative">
        <div title="user" class="cursor-pointer " v-if="user.userId" @click="showUserMenu=!showUserMenu">
          <img class="b-rounded w-25px" src="{{auth.picture}}" :src="user.picture" alt="user">
        </div>
        <ui-button @click="login" v-else >
          Login
        </ui-button>
        <transition name="swipe">
          <div class="position-absolute bg-white-90 p-5 b-rounded" style="right: 0" v-if="showUserMenu">
            <div n-if="auth.email==='impossible'">{{user.email}}</div>
            <div class="menu-button" @click="logout">logout</div>
          </div>
        </transition>

      </div>
    </div>
  </header>
</template>

<script>
import uiButton from '/vue/ui/lib/ui.button';
import uiIcon from '/vue/ui/lib/ui.icon';
@import({
  "routes":[{"products":"/products"},{"home":"/"},{"product":"/product/:id"},{"ui":"/ui"}],
  "store":{"auth":{"get":"/auth,preload"}}
})



export default {
  components: {
    uiButton,
    uiIcon
  },
  data:()=>({
    user: {},
    showUserMenu: false
  }),
  name:'nHeader',
  inject:['neoanStore'],
  async mounted() {
    this.user = await neoanStore.getAll('auth');
    console.log(this.user)
  },
  methods: {
    navigate(to){
      this.$router.push(to)
    },
    async logout(){
      const {data} = await API.delete('/auth')
      window.location.href = data.url;
    },
    login(){
      window.location.href = this.user.url
    }
  },
  template: `{{template}}`,
}
</script>