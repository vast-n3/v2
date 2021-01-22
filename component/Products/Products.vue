<template>
  <div class="container">
    <h2 class="p-3">
      Fastest shop in the world?
    </h2>
    <transition name="slide-fade">
      <ui-input v-if="products.length>0" v-model:value="search" placeholder="search..."></ui-input>
    </transition>

    <section>
        <div class="grid-12 md:grid-6-6 lg:grid-4-4-4">
          <div class="m-4 b-1 b-rounded p-5 d-flex d-column" style="flex-direction: column" n-for="products as product" v-for="product in filteredProducts">
            <div class="grid-6-6 cursor-pointer" @click="$router.push('/product/'+product.id)">
              <img class="w-100p " src="{{product.image.src}}" :src="product.image.src" alt="">
              <div class="p-l-2">
                <h3 >{{product.title}}</h3>
              </div>
            </div>
            <div class="grid f-1">
              <ui-button class="place-x-end place-y-end font-md" @click.prevent="$router.push('/product/'+product.id)" href="{{base}}product/{{product.id}}">US$ {{product.price}}</ui-button>
            </div>
          </div>
        </div>
    </section>
  </div>


</template>

<script>
import uiButton from '/vue/ui/lib/ui.button';
import uiInput from '/vue/ui/lib/ui.input';



export default {
  name: 'nProducts',
  components:{
    uiButton,
    uiInput
  },
  inject: ['neoanStore'],
  data:()=>({
    products:[],
    filteredProducts:[],
    search:'n'
  }),
  async mounted() {
    this.products = await this.neoanStore.getAll('products');
    this.search = '';
  },
  watch:{
    search(newVal){
      this.filteredProducts = this.products.filter(p => {
        return p.title.toLowerCase().includes(newVal.toLowerCase()) || newVal === ''
      })
    }

  },

  template: `{{template}}`,
}
</script>