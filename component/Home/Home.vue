<template>
  <div class="home p-y-5 bg-primary"
       style="background-image: url('{{base}}asset/vastn3.png'); background-size: contain; background-position: center center; background-repeat: no-repeat; min-height: 90vh; background-attachment: fixed">
    <div class="bg-primary-75 p-b-5">
      <div class="container bg-white-90 b-rounded p-5" style="opacity: 0">
        <p class="m-y-1 font-md text-primary">
          Based on neoan3 and VueJS, this environment enables you to build <strong class="font-strong">hybrid</strong>
          applications with server side routes (SSR) that deliver
          a single-page application (SPA). The goal is to enable SEO-friendly content that doesn't suffer from any of the
          downsides during client execution.
          The result is a seamless application delivering the best of both worlds while limiting development time as well
          as server-requests.

        </p>
      </div>
      <div class="grid ">
        <img src="{{base}}asset/vastn3.png" alt="logo" class="w-75p place-x-center">
      </div>
      <div class="container m-y-5" >
        <div class="grid md:grid-6-6">
          <div class="bg-white-90 b-rounded m-2 p-4">
            <h1>What is vast-n3?</h1>
            <hr>
            <ul class="list">
              <li>Provides SSR routes for SEO relevant pages</li>
              <li>Speeds up delivery & development through innovative shared front-/back-end store</li>
              <li>Requires no build-/deployment-process</li>
              <li>Seamless takeover of user-friendly SPA</li>
            </ul>
          </div>
          <div class="bg-white-90 b-rounded m-2 p-4">
            <h1>What is included?</h1>
            <hr>
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
    </div>
    <div class="p-t-5" style="background:linear-gradient(180deg, rgba(0,121,107,.75) 0%, rgba(0,121,107,0) 100%);">&nbsp;</div>



    <div class="container bg-white-90 b-rounded p-5 m-y-5" style="margin-top: 30vh">
      <h2>Understanding Vast-n3</h2>
      <h3>Installation</h3>
      <p>
        After cloning the repository, installing dependencies via yarn/npm as well as composer, run the following command
      </p>
      <ui-code>neoan3 develop</ui-code>
      <p class="font-sm m-t-2">
        Should you encounter problems, make sure you have the newest version of the neoan3-cli installed and debug potential PATH issues.
      </p>
      <p>
        In order to familiarize yourself with vast-n3, let's have a look at the following
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
        <pre>
          &lt;a href="&#123;{base}}" @click.prevent="$router.push('/')">HOME&lt;/a>
        </pre>
      </ui-code>
      <p class="m-t-2">
        The variable <span class="font-strong">base</span> refers to the project's root (so localhost:8080 in development) and
        will be replaced server-side at the time of rendering. This allows for absolute, SEO friendly links in the source code.
        <br>Once the SPA has taken over, the user will navigate within the app using vue-router.
      </p>
      <p>
        Registering routes is easiest done via the @import notation found in our script:
      </p>
      <ui-code class="m-b-3" lang="html">
        <pre>
          @import({"routes":[{"products":"/products"},{"home":"/"},{"product":"/product/:id"},{"ui":"/ui"}]})
        </pre>
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
        Vast-n3's magic is tied to the reactive state called neoanStore. Defining global store objects can be done by adding
        onto the array located in the <span class="font-strong">constants</span>-method in the file <span class="font-strong">frame/VastN3/VastN3.php</span>
        or at a component being present on all routes (like the header).
        Defining the stores in your Vue-components requires a particular markup. Let's look at an example:
      </p>
      <div class="grid md:grid-4-8">
        <div>
          <ui-code>
            <pre>
              @import({
                "store":{
                  "generic":{"get":"auto,preload","post":"auto"},
                  "products":{"get":"/products"}}
              })
            </pre>
          </ui-code>
          <ui-alert color="warning">
            It is NOT necessary to double-implement store definitions in <span class="font-strong">constants AND markup</span>.
            The reason why this is done in the initial setup is for reference purposes only.
          </ui-alert>
        </div>

        <article class="md:m-l-4">
          <p>
            As you can see, the store is implemented in the same way routes are. Dissecting the structure, we can see that the our example JSON format starts with
            having the keys "generic" and "products". This alone defines the existence of the store.
            The value-object then describes behavior for the backend. We start with the method. In order for this to work, we have to create a model "generic".
            To do so, run
          </p>
          <ui-code>neoan3 new model generic</ui-code>
          <p class="m-t-3">
            Now, assuming you are running the dev server, visit <span class="font-strong">http://localhost:8080/migrate</span>, choose "generic" and define your model.
            When done, click on <span class="font-strong">write out</span> and afterwards run
          </p>
          <ui-code>neoan3 migrate models up</ui-code>
          <p class="m-t-3">
            In order to sync the model definition to your database. As we have set both methods to "auto", there is no further step we need to do:
            our frontend can now interact with the store and retrieve & store information (check out Store Methods). The keyword "preload" ensures that data is loaded at the time
            of initializing the SPA rather than on the first request of the information.
          </p>
        </article>
      </div>
      <p>
        The "products" store behaves differently to show you that there are no bottlenecks to be expected: <br>
        You can always define your API-endpoint yourself by indicating the desired endpoint with a <span class="font-strong">/</span>.
        <a href="https://neoan3.rocks">neoan3.rocks</a> will give you a deeper insight into how to create API routes in neoan3.
      </p>
      <h3>Store Methods</h3>
      <div class="grid md:grid-6-6">
        <ui-code lang="javascript">
          <pre>
            export&nbsp;default {
              ...
              data:()=>({generic:[]})
              inject:['neoanStore'],
              async mounted() {
                this.generic = await neoanStore.getAll('generic');
              }
            }
          </pre>
        </ui-code>
        <article class="md:m-l-4">
          <p>
            As you can see, <span class="font-strong">neoanStore</span> is provided and can be injected into any
            component. Doing so allows you to bind a store object to a local state. Reactivity is automatically taken care of,
            your values will update accordingly.
          </p>
          <ui-alert color="primary">
            Due to the rendering process, working with "setup" as recommended in the Vue3 docs is neither necessary
            nor currently possible without side effects in certain situations.
          </ui-alert>
        </article>

      </div>
      <ul class="list">
        <li>neoanStore.getAll()</li>
      </ul>
      <div class="grid md:grid-6-6">
        <p class="md:m-r-4">
          This asynchronous method retrieves everything from the store object and per default only asks the backend API
          for data if the store object is empty.
        </p>
        <ui-code lang="javascript">
        <pre>
          this.products = await neoanStore.getAll('products');
        </pre>
        </ui-code>
      </div>
      <ul class="list">
        <li>neoanStore.find()</li>
      </ul>
      <div class="grid md:grid-6-6">
        <p class="md:m-r-4">
          The find method returns a search method after the store has ensured
          availability of the store contents. This allows for the search itself to
          be synchronous.
        </p>
        <ui-code lang="javascript">
        <pre>
          this.neoanStore.find('products').then(search => {
            this.product = search('id', parseInt(this.$route.params.id))[0];
          })
        </pre>
        </ui-code>
      </div>
      <ul class="list">
        <li>neoanStore.post()</li>
      </ul>
      <div class="grid md:grid-6-6">
        <p class="md:m-r-4">
          The post method posts a new object to the database and retrieves the result (usually the same object but
          with a unique id) to the store. Should you have bound that store to a local state, you should not require any additional
          steps to ensure updating the view.
        </p>
        <ui-code lang="javascript">
        <pre>
          this.neoanStore.post('products', newProduct)
        </pre>
        </ui-code>
      </div>
      <h3>Authentication & security</h3>
      <h3>SSR rendering</h3>
      <p>
        By preloading store data, we bypass the necessity to make a request when the route is visited externally (e.g. organic search or external link).
        <br>Also, by providing the entities to the main hook, we can iterate server-side using <span class="font-strong">neoan3's n-for additionally to using Vue's v-for</span>.
        <br>The advantage is clear: we can output source-code that already contains all the information we want search-engines (and users!) to see, before the SPA takes over.
        <br>In our products Vue component's template, this is easy to achieve:
      </p>
      <ui-code>
        <pre>
           &lt;div n-for="products as product" v-for="product in products">...&lt;/div>
        </pre>
      </ui-code>
      <p>
        The result is a <span class="font-strong text-primary">flicker-free, lightning fast and highly optimized</span>
        output.
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