<template>
  <div class="grid position-relative" :style="{height}">
      <div
          class="code-tag bg-gray-dark text-white p-2 b-rounded b-1 b-primary position-absolute"
          style="overflow-x: auto; width: calc(100% - 1rem)">
        <pre v-html="slotContent"></pre>
        <slot v-if="!slotContent"></slot>
      </div>
  </div>

</template>

<script>
export default {
  props:{
    lang:{
      type: String,
    }
  },
  data:()=>({
    height: 0,
    slotContent: null
  }),
  mounted(){
    this.$nextTick(()=>{
      this.height = this.$el.querySelector('.code-tag').clientHeight + 'px';
      this.interpolate(this.$slots.default()[0].el)
      this.basicHighlight(this.$slots.default()[0].el);
    })

  },

  methods:{
    interpolate(el){
      if(el.tagName === 'PRE'){
        const countSpaces = (el.innerText.match(/\s*/)[0].length);
        this.slotContent = el.innerHTML.replace(/\n\n/,"<br>\n")
        const regEx = new RegExp('^\\s{0,'+countSpaces+'}','gm');
        this.slotContent = this.slotContent.replace(regEx,'')
      }
    },
    basicHighlight(el){
      if(el.tagName === 'PRE'){
        const tags = /&lt;\/*[a-z0-9\s\n=":/[{}\]',._-]+(&gt;|>)/gmi;
        this.slotContent = this.slotContent.replace(tags, match => highlightTemplate(match, 'accent-lighter'))

        const quotes = /(?!.*hl)"[a-z0-9\s\n=:/[{}\]',._-]+"/gmi;
        this.slotContent = this.slotContent.replace(quotes, match => highlightTemplate(match, 'success-light'))

        //language specific
        if(this.lang === 'js'){
          const keyWords = /(^|\s)(import|export|function|from|default)\s/g;
          this.slotContent = this.slotContent.replace(keyWords, match => highlightTemplate(match, 'accent-light'))
          const quotes = /(?!.*hl)'[a-z0-9\s\n=:/[{}\]",._-]+'/gmi;
          this.slotContent = this.slotContent.replace(quotes, match => highlightTemplate(match, 'success-light'))
        }

        // final strip
        this.slotContent = this.slotContent.replace(/&amp;/g,'&').replace(/&lt;br&gt;/g,'<br>');
      }

    }
  },
  template: `{{template}}`
}

const highlightTemplate = (match, color)=>{
  const newEl = document.createElement('span');
  newEl.className = 'hl text-'+ color;
  newEl.innerText = match;
  return newEl.outerHTML;
}
</script>
