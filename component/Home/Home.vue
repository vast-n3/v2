<template>
  <div class="home p-y-5 bg-black"
       style="background-image: url('{{base}}asset/vastn3.png'); background-size: cover; background-position: center center; min-height: 90vh; background-attachment: fixed">
    <div class="container bg-white-90 b-rounded p-5">


      <p class="m-y-1 font-md text-primary">
        Based on neoan3 and VueJS, this environment enables you to build <strong class="font-strong">hybrid</strong>
        applications with server side routes (SSR) that deliver
        a single-page application (SPA). The goal is to enable SEO-friendly content that doesn't suffer from any of the
        downsides during client execution.
        The result is a seamless application delivering the best of both worlds while limiting development time as well
        as server-requests.

      </p>
    </div>
    <div class="container bg-white-90 b-rounded p-5 m-y-5" style="margin-top: 50vh">
      <div class="grid md:grid-6-6">
        <div>
          <h2>What problems does it solve?</h2>
          <ul class="list">
            <li>Provides SSR routes for SEO relevant pages</li>
            <li>Speeds up delivery & development through innovative shared front-/back-end store</li>
            <li>Requires no build-/deployment-process</li>
            <li>Seamless takeover of user-friendly SPA</li>
          </ul>
        </div>
        <div>
          <h2>What is included?</h2>
          <ul class="list">
            <li>Customizable <a href="{{base}}ui">UI system</a> based on Gaudiamus CSS</li>
            <li>Preloading automation while maintaining structural freedom</li>
            <li>REST API</li>
            <li>Store solution</li>
            <li>Cache for even faster delivery</li>
          </ul>
        </div>
      </div>

    </div>
    <div class="container bg-white-90 b-rounded p-5 m-y-5" style="margin-top: 30vh">
      <h2>Understanding Vast-n3</h2>
      <p>
        After cloning the repository, installing dependencies via yarn/npm as well as composer, run the following command
      </p>
      <ui-code>neoan3 develop</ui-code>
      <p class="font-sm">
        Should you encounter problems, make sure you have the newest version of the neoan3-cli installed and debug potential PATH issues.
      </p>
      <p>
        In order to familiarize yourself with vast-n3, let's have a look at the following concepts:
      </p>
      <h3>Header</h3>
      <p>
        In the file <span class="font-strong">/component/Header/Header.vue</span> you will find the following concepts.
      </p>
      <ul class="list m-y-5">
        <li>Navigation</li>
      </ul>
      <p>
        Note how both a regular <span class="font-strong">href on links</span> as well as <span class="font-strong">$router.push</span> is present on navigation elements.
      </p>
      <ui-code>
        &lt;a href=&#123;{base}}" @click.prevent="$router.push('/')">HOME&lt;/a>
      </ui-code>
      <p class="m-t-2">
        The variable <span class="font-strong">base</span> refers to the project's root (so localhost:8080 in development) and
        will be replaced server-side at the time of rendering. This allows for absolute, SEO friendly links in the source code.
        <br>Once the SPA has taken over, the user will navigate within the app using vue-router.
      </p>
      <p>
        Registering routes is easiest done via the @import notation found in our script:
      </p>
      <ui-code class="m-b-3">
        @import({"routes":[{"products":"/products"},{"home":"/"},{"product":"/product/:id"},{"ui":"/ui"}]})
      </ui-code>
      <p>
        This will register SPA routes and no further server request is required when navigating.
        <span class="font-strong">Make sure to use JSON rather than object notation!</span>
      </p>
      <ui-alert color="accent" class="m-t-5">
        NOTE: Which component is used as header is defined in the overwrite of the method <span class="font-strong">output</span>
        in the frame (<span class="font-strong">/frame/VastN3/VastN3.php</span>)
      </ui-alert>
      <ul class="list m-y-5">
        <li>Store</li>
      </ul>
      <p>
        The general definition of what store objects exist is controlled via the render constants. Please have a look at the method <span class="font-strong">constants</span>
        in <span class="font-strong">/frame/VastN3/VastN3.php</span>. In order to use it, simply follow the simple array-definition of the example "products".
      </p>
      <p>
        Defining a store goes hand in hand with creating an API endpoint with the same name.
        In most cases, a store property is also a route and a component. Have a look at <span class="font-strong">/component/Products/ProductsController.php</span>.
        <br>You will find a method <span class="font-strong">getProducts</span> (neoan3 api route) which retrieves fake products.
        <br>Likewise, you might notice the the following three lines in the init method:
      </p>
      <ui-code>
        <p>
          // get all fake products <br>
          $products = $this->getProducts();<br>
          // provide products to the front-end store <br>
          $this->renderer->storeObject('products', $products);<br>
          // iterate & render products server side <br>
          $this->hook('main', 'products', ['products' => $products]);
        </p>
      </ui-code>
      <p>
        By passing the products to the store, we bypass the necessity to make a request when the route is visited externally (e.g. organic search or external link).
        <br>Finally, by providing the products to the main hook, we can iterate server-side using <span class="font-strong">neoan3's n-for additionally to using Vue's v-for</span>.
        <br>The advantage is clear: we can output source-code that already contains all the information we want search-engines (and users!) to see, before the SPA takes over.
        <br>In our products Vue component's template, this is easy to achieve:
      </p>
      <ui-code>
        &lt;div n-for="products as product" v-for="product in products">...&lt;/div>
      </ui-code>
      <p>
        The result is a <span class="font-strong text-primary">flicker-free, lightning fast and highly optimized</span>
        output.
      </p>
      <p>
        The store itself is provided to components and you can <span class="font-strong">inject neoanStore</span> following Vue 3's guidance
        (Have a look at our Products.vue again and see how to interact with the store).
      </p>
      <ul class="list m-y-5">
        <li>Scalability & Performance</li>
      </ul>
      <p>
        Hold on: Does that mean that models will be generally written to the DOM and the more data I handle the slower/bigger the app becomes?
        <br>No! Vast-n3 prerenders & preloads data based on the entry point into the SPA. The store is asynchronous to account for cases where
        data is not existent and needs to be fetched via AJAX.
        Regardless of how you navigated here, opening the source code in your browser (actual source, not interpreted as in your browser's "inspect"),
        you will notice that no product information is attached written to the source code.
        If you do the same on the route <a href="{{base}}products" @click.prevent="$router.push('/products')">/products</a> and search for
        <span class="font-strong">storeObjects.products.state</span>, you will see that entering the application on <span class="font-strong">/products</span>
        will lead to products already being attached to the store. <br>

        However, when you follow the pattern, <span class="font-strong">this is something you never have to think about while developing</span>.
      </p>
    </div>
  </div>


</template>

<script>
import uiCode from '/vue/ui/lib/ui.code';
import uiAlert from '/vue/ui/lib/ui.alert';

export default {
  components: {uiCode, uiAlert},
  mounted() {
    console.log('attached: home')
  },
  template: `{{template}}`,
}
</script>