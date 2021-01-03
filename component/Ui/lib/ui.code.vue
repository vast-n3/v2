<template>
  <div class="grid">
      <code class="bg-gray-dark text-white p-2 b-rounded b-1 b-primary">
        <slot></slot>
      </code>
  </div>

</template>

<script>
export default {
  data(){
    return {
      tag: 'bubu'
    }
  },
  template: `{{template}}`
}
</script>
