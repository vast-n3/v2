<template>
  <header class="p-3 b-b-accent b-b-1">
    <div class="grid grid-2-10">
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
    </div>
  </header>
</template>

<script>
import uiButton from '/vue/ui/lib/ui.button';
import uiIcon from '/vue/ui/lib/ui.icon';
@import([{"products":"/products"},{"home":"/"},{"product":"/product/:id"},{"ui":"/ui"}])



export default {
  components: {
    uiButton,
    uiIcon
  },
  name:'nHeader',
  methods: {
    navigate(to){
      this.$router.push(to)
    }
  },
  template: `{{template}}`,
}
</script>