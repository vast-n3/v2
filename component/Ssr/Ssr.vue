<template>
  <div>ssr</div>
</template>

<script>
export default {
  mounted(){
    console.log('attached: ssr')
  },
  template: `{{template}}`,
}
</script>