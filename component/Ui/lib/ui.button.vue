<template>
  <button :disabled="disabled" style="line-height: 1" :class="classes" class="b-rounded p-x-2 p-y-1 b-1">
    <slot></slot>
  </button>
</template>

<script>


export default {

  props: {
    disabled: {
      type: Boolean,
      default: false
    },
    color: {
      type: String,
      default: 'primary'
    }
  },
  inject: ['theming'],
  computed: {
    classes(){
      return this.theming(this.color, this.disabled);
    }
  },
  /*watch:{
    disabled(){
      this.calcClasses()
    },
    color(){
      this.calcClasses()
    }
  },
  mounted(){
    this.calcClasses()
  },
  methods:{
    calcClasses(){
      this.classes = conditions(this.color, this.disabled);
    }
  },*/
  template: `{{template}}`
}
</script>

<style scoped>

</style>