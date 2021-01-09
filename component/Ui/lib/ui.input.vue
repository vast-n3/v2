<template>
  <label class="grid m-y-2" :class="{'grid-10-2':type === 'checkbox'}">
    <span class="text-accent m-y-1">
      <slot name="label">{{label}} <span v-if="label&&required">*</span></slot>
    </span>
    <textarea :required="required" @change="$emit('update:value', $event.target.value)" class="b-0 b-b-1 b-gray focus:b-primary p-b-2 w-100p" rows="3" v-if="type === 'textarea'"></textarea>
    <select v-else-if="type === 'select'" :required="required" class="b-0 b-b-1 b-gray focus:b-primary p-b-2  w-100p" @change="$emit('update:value', $event.target.value)">
      <option disabled selected v-if="placeholder">{{placeholder}}</option>
      <option v-for="option in options" :value="option[optionValue]">{{option[optionTitle]}}</option>
    </select>
    <span v-else-if="type === 'checkbox'"
          :required="required"
          class="b-1 b-gray b-rounded position-relative m-t-1 place-x-end"
          @click="$emit('update:value', !value)"
          style="width: 1rem; height: 1rem">
      <span class="material-icons position-absolute" style="top:-.3rem; left:-.1rem" v-show="value">done</span>
    </span>
    <input :required="required" v-else :type="type" :placeholder="placeholder" class="b-0 b-b-1 b-gray focus:b-primary p-b-2  w-100p" :value="value" @keyup="$emit('update:value', $event.target.value)" />

  </label>

</template>

<script>
export default {
  props: {
    required: {
      type:Boolean,
      default: false
    },
    value: {
      type:[String, Number, Boolean],
      default: ''
    },
    label: String,
    options: Array,
    optionValue: {
      type: String,
      default: 'id'
    },
    optionTitle: {
      type: String,
      default: 'title'
    },
    placeholder: String,
    type: {
      type: String,
      default: 'text'
    }
  },
  template: `{{template}}`
}
</script>

<style scoped>

</style>