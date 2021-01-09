<template>
  <div class="grid position-relative" :style="{height}">
      <code
          class="code-tag bg-gray-dark text-white p-2 b-rounded b-1 b-primary position-absolute"
          style="overflow-x: auto; width: calc(100% - 1rem)">
        <slot></slot>
      </code>
  </div>

</template>

<script>
export default {
  data:()=>({
    height: 0
  }),
  mounted(){
    this.$nextTick(()=>{
      this.height = this.$el.querySelector('.code-tag').clientHeight + 'px';
      console.log(this.height)
    })

  },
  template: `{{template}}`
}
</script>
