<template>
  <p class="p-3">
    Fastest shop in the world?
  </p>
  <section class="grid-4-4-4">
    <div class="m-4 b-1 b-rounded p-5" n-for="products as product" v-for="product in products">
      <h2 class="cursor-pointer" @click="$router.push('/product/'+product.id)">{{product.title}}</h2>
      <img class="w-100px"  src="{{product.image.src}}" :src="product.image.src" alt="">
      <a @click.prevent="$router.push('/product/'+product.id)" href="{{base}}product/{{product.id}}">besuchen</a>
    </div>
  </section>
</template>

<script>
const {ref, inject} = Vue;

export default {
  name: 'nProducts',
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