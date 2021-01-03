<template>
  <div class="home p-y-5"
       style="background-image: url('{{base}}asset/vastn3.png'); background-size: cover; background-position: center center; min-height: 90vh">
    <div class="container bg-see-through-light b-rounded p-5">
      <h1>Vast-n3</h1>
      <p>
        Welcome to the new vast-n3 environment.
      </p>
      <p class="m-y-2 text-primary">
        With VueJS, PHP and neoan3 publishing new main versions in late 2020, it was time to modernize the approach and
        provide an easy & fast development environment for the SSR enthusiast.
      </p>
      <p class="m-y-1 font-md">
        Based on neoan3 and VueJS, this environment enables you to build <strong class="font-strong">hybrid</strong>
        applications with server side routes (SSR) that deliver
        a single-page application (SPA). The goal is to enable SEO-friendly content that doesn't suffer from any of the
        downsides during client execution.
        The result is a seamless application delivering the best of both worlds while limiting development time as well
        as server-requests.

      </p>
    </div>
    <div class="container bg-see-through-light b-rounded p-5 m-y-5">
      <div class="grid-6-6">
        <div>
          <h2>What problems does it solve?</h2>
          <ul>
            <li>Provides SSR routes for SEO relevant pages</li>
            <li>Speeds up delivery & development through innovative shared front-/back-end store</li>
            <li>Requires no build-/deployment-process</li>
            <li>Seamless takeover of user-friendly SPA</li>
          </ul>
        </div>
        <div>
          <h2>What is included?</h2>
          <ul>
            <li>Customizable <a href="{{base}}ui">UI system</a> based on Gaudiamus CSS</li>
            <li>Preloading automation while maintaining structural freedom</li>
            <li>REST API</li>
            <li>Store solution</li>
            <li>Cache for even faster delivery</li>
          </ul>
        </div>
      </div>

    </div>
  </div>


</template>

<script>
import uiCode from '/vue/ui/lib/ui.code';

export default {
  components: {uiCode},
  mounted() {
    console.log('attached: home')
  },
  template: `{{template}}`,
}
</script>