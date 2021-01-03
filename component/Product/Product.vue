<template>
  <div class="container m-t-5">
    <h1>{{ product.title }}</h1>
    <div class="grid grid-6-6">
      <div v-if="product.image">
        <img @click="modal(product.image.src)" src="{{product.image.src}}" :src="product.image.src" class="w-100p cursor-pointer"/>
        <div class="grid-3-3-3-3">
          <ui-button  v-for="image in product.images" @click="modal(image.src)">
            <img class="w-100p" :src="image.src" alt="">
          </ui-button>
        </div>
      </div>
      <section>
        <h3>{{product.title}}</h3>
        <ui-input type="select" v-model:value="selectedVariant">
          <option disabled selected>choose</option>
          <option n-for="product.variants as variant" v-for="variant in product.variants" :value="variant.id">{{variant.title}}</option>
        </ui-input>
      </section>
    </div>
    <ui-modal :show="open" @close="open =! open">
      <p class="m-4">some info about this product</p>
      <p class="m-4">some info about this product</p>
      <p class="m-4">some info about this product</p>
      <img class="w-100p" :src="currentImage" alt="loading">
    </ui-modal>
  </div>
</template>

<script>


import uiModal from '/vue/ui/lib/ui.modal';
import uiButton from '/vue/ui/lib/ui.button';
import uiIcon from '/vue/ui/lib/ui.icon';
import uiProgress from '/vue/ui/lib/ui.progress';
import uiInput from '/vue/ui/lib/ui.input';


export default {
  name: 'nProduct',
  components: {
    uiModal,
    uiButton,
    uiIcon,
    uiProgress,
    uiInput
  },
  inject: ['neoanStore'],
  data:()=>({
    product:{},
    selectedVariant:null,
    currentImage:null,
    open:false
  }),
  async mounted() {


    this.neoanStore.find('products').then(search => {
      this.product = search('id', parseInt(this.$route.params.id))[0];
      this.currentImage = this.product.image.src;
      console.log(JSON.parse(JSON.stringify(this.product)))
    })
    /*
    const products = await this.neoanStore.find('products');
    this.product = products('id', parseInt(this.$route.params.id))[0];*/
  },
  watch: {
    selectedVariant(newVal){
      console.log(newVal)
    }
  },
  methods:{
    modal(src){
      this.currentImage = src;
      this.open=true;
      console.log(this.currentImage)
      console.log(this.open)
    }
  },

  template: `{{template}}`,
}
</script>