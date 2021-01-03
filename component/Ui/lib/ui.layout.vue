<template>
  <div v-if="design === 'left'" class="grid-12  md:grid-3-9 lg:grid-2-10">
    <div class="b-r-1 b-gray-light p-2">
      <slot name="menu">
        <p>Side menu slot #menu</p>
      </slot>
    </div>
    <div class="bg-gray-lighter">
      <slot></slot>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    design: {
      type: String,
      default: 'left'
    }
  },
  template: `{{template}}`
}
</script>
