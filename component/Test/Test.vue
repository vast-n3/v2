<template id="test">
  <p>{{test}}</p>
</template>

<script>
app.component('test-me',{
  template: '#test',
  data(){
    return {
      test: 'Vue test'
    }
  }
})
</script>

<style lang="scss">

</style>