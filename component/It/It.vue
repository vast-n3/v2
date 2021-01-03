<template>
  <div>
    <ui-button>bubu</ui-button>
  </div>
</template>

<script>
import uiButton from '/vue/ui/lib/ui.button';
export default {
  components:{
    uiButton
  },
  mounted(){
    console.log('attached: it')
  },
  template: `{{template}}`,
}
</script>