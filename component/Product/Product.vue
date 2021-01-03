<template>
  <div class="container m-t-5">
    <h1>{{ product.title }}</h1>
    <div class="grid md:grid-6-6">
      <div v-if="product.image">
        <img @click="modal(product.image.src)" src="{{product.image.src}}" :src="product.image.src" class="w-100p cursor-pointer"/>
        <div class="grid-3-3-3-3">
          <ui-button  v-for="image in product.images" @click="modal(image.src)">
            <img class="w-100p" :src="image.src" alt="">
          </ui-button>
        </div>
      </div>
      <section class="p-l-3">
        <h3>{{product.title}}</h3>
        <ui-input type="select" v-model:value="selectedVariant">
          <option disabled selected>choose</option>
<!--          Notice the markup with n-for as well as v-for -->
<!--          This enables the backend to render the options before Vue takes over for the client -->
          <option n-for="product.variants as variant" v-for="variant in product.variants" :value="variant.id">{{variant.title}}</option>
        </ui-input>
        <div class="m-5">
          <ui-button @click="showNotification=true" color="primary-filled">
            Buy for US$ {{product.price}}
          </ui-button>
          <ui-button class="m-l-5" @click="$router.push('/products')" color="accent">
            Back to products
          </ui-button>
          <div class="m-t-5" v-show="showNotification">
            <ui-alert color="warning">
              <div class="grid-10-2">
                Hate to disappoint you, but you can't really buy this.
                <ui-button class="place-x-end" color="warning-light" @click="showNotification=false">
                  <ui-icon>close</ui-icon>
                </ui-button>
              </div>


            </ui-alert>
          </div>
        </div>
      </section>
    </div>
    <ui-modal :show="open" @close="open =! open">
      <p class="m-4">{{product.title}}</p>

      <img class="w-100p" :src="currentImage" alt="loading">
    </ui-modal>
  </div>
</template>

<script>


import uiModal from '/vue/ui/lib/ui.modal';
import uiButton from '/vue/ui/lib/ui.button';
import uiInput from '/vue/ui/lib/ui.input';
import uiAlert from '/vue/ui/lib/ui.alert';
import uiIcon from '/vue/ui/lib/ui.icon';


export default {
  name: 'nProduct',
  components: {
    uiModal,
    uiButton,
    uiInput,
    uiAlert,
    uiIcon
  },
  inject: ['neoanStore'],
  data:()=>({
    product:{},
    selectedVariant:null,
    currentImage:null,
    open:false,
    showNotification:false
  }),
  async mounted() {
    this.neoanStore.find('products').then(search => {
      this.product = search('id', parseInt(this.$route.params.id))[0];
      this.currentImage = this.product.image.src;
    })

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
    }
  },

  template: `{{template}}`,
}
</script>