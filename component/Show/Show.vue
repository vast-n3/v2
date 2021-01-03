<template>
  <div>
    <h2>Greetings</h2>
    <div>show component</div>
  </div>
</template>

<script>
export default {
  mounted(){
    console.log('attached: show')
  },
  template: `{{template}}`,
}
</script>
<style scoped>
h1{
  color: red;
}
</style>