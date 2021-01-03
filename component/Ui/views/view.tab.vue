<template>
  <section>
    <h1>Tab</h1>
    <p>
      Tabs are a great way to organize content without scrolling. Our simple tabs can help you out.
    </p>
    <div class="grid-6-6 m-t-3">
      <div class="p-3">
        <ui-tabs :tabs="['ONE','TWO','THREE']" v-model:selected="selectedTab" ></ui-tabs>
        <div class="m-3">
          Content {{selectedTab+1}}
        </div>

      </div>
      <div>
        <ui-code style="overflow-x: auto">
          <pre>
          &lt;ui-tabs :tabs="['ONE','TWO']" v-model:selected="selectedTab" >&lt;/ui-tabs>
          &lt;div class="m-3" v-if="selectedTab===0">
            Content one
          &lt;/div>
          &lt;div class="m-3" v-if="selectedTab===1">
            Content two
          &lt;/div>
          </pre>
        </ui-code>
      </div>

    </div>

  </section>

</template>

<script>
import UiTabs from '/vue/ui/lib/ui.tabs';
import UiCode from '/vue/ui/lib/ui.code';

export default {
  name: "viewTab",
  components: {
    UiTabs,
    UiCode
  },
  data: () => ({
    selectedTab: 0
  }),
  template: `{{template}}`
}
</script>

<style scoped>

</style>