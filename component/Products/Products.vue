<template>
  <ui-layout>
    <template #menu>
      If you see this, then the SPA has taken over your experience. <br>
      The iteration of items happens on the server side as well, delivering a fast paint which search-engines will appreciate.
    </template>

    <h2 class="p-3">
      Fastest shop in the world?
    </h2>
    <section class="grid-12 md:grid-6-6">
      <div class="m-4 b-1 b-rounded p-5" n-for="products as product" v-for="product in products">
        <div class="grid-6-6">
          <img class="w-100p"  src="{{product.image.src}}" :src="product.image.src" alt="">
          <div class="p-l-2">
            <h2 class="cursor-pointer" @click="$router.push('/product/'+product.id)">{{product.title}}</h2>

            <div>
              <ui-button @click.prevent="$router.push('/product/'+product.id)" href="{{base}}product/{{product.id}}">US$ {{product.price}}</ui-button>
            </div>
          </div>
        </div>

      </div>
    </section>
  </ui-layout>

</template>

<script>
import uiLayout from '/vue/ui/lib/ui.layout';
import uiButton from '/vue/ui/lib/ui.button';
const {ref, inject} = Vue;

export default {
  name: 'nProducts',
  components:{
    uiLayout,
    uiButton
  },
  setup(){
    const products = ref([]);
    const store = inject('neoanStore');
    store.getAll('products').then(p => {
      products.value = p;
    })
    return {
      products,
    }
  },
  template: `{{template}}`,
}
</script>