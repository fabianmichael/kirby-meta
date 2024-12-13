(function(){"use strict";var B="",p=function(){var t=this,i=t.$createElement,e=t._self._c||i;return e("k-section",{staticClass:"k-meta-sharing-preview"},[e("div",{staticClass:"k-meta-sharing-preview__label k-field-label"},[e("k-icon",{attrs:{type:"share"}}),e("k-label",[t._v(t._s(t.headline))])],1),e("div",{staticClass:"k-meta-sharing-preview__box"},[e("div",{staticClass:"k-meta-sharing-preview__image-container",attrs:{"data-image-missing":!t.og_image,"data-image-missing-text":t.$t("fabianmichael.meta.og_image.missing")}},[t.og_image?e("img",{staticClass:"k-meta-sharing-preview__preview-image",attrs:{src:t.og_image}}):t._e(),t.og_image_source?e("span",{staticClass:"k-meta-sharing-preview__source-badge"},[t._v(t._s(t.og_image_source))]):t._e()]),e("div",{staticClass:"k-meta-sharing-preview__content-container"},[e("span",{staticClass:"k-meta-sharing-preview__site-name"},[t._v(t._s(t.site_name))]),e("h2",{staticClass:"k-meta-sharing-preview__preview-headline"},[t._v(" "+t._s(t.title)+" ")]),e("p",{staticClass:"k-meta-sharing-preview__preview-paragraph"},[t._v(" "+t._s(t.description)+" ")])])])])},v=[],I="";function c(t,i,e,a,n,_,o,V){var s=typeof t=="function"?t.options:t;i&&(s.render=i,s.staticRenderFns=e,s._compiled=!0),a&&(s.functional=!0),_&&(s._scopeId="data-v-"+_);var r;if(o?(r=function(l){l=l||this.$vnode&&this.$vnode.ssrContext||this.parent&&this.parent.$vnode&&this.parent.$vnode.ssrContext,!l&&typeof __VUE_SSR_CONTEXT__!="undefined"&&(l=__VUE_SSR_CONTEXT__),n&&n.call(this,l),l&&l._registeredComponents&&l._registeredComponents.add(o)},s._ssrRegister=r):n&&(r=V?function(){n.call(this,(s.functional?this.parent:this).$root.$options.shadowRoot)}:n),r)if(s.functional){s._injectStyles=r;var H=s.render;s.render=function(O,d){return r.call(d),H(O,d)}}else{var u=s.beforeCreate;s.beforeCreate=u?[].concat(u,r):[r]}return{exports:t,options:s}}const k={props:{blueprint:String,lock:[Boolean,Object],help:String,name:String,parent:String,timestamp:Number},data(){return{headline:"Basic Meta Information",metadata_og_image:null,metadata_og_image_field:null,page_is_homepage:null,page_title:null,page_metadata_description:null,site_meta_description:null,site_name:null,site_og_image:null,site_title:null,title_separator:null,url:null,og_title_prefix:null,og_image:null,og_image_source:null}},async created(){const t=await this.load();this.headline=t.headline,this.metadata_og_image=t.metadata_og_image,this.metadata_og_image_field=t.metadata_og_image_field,this.page_is_homepage=t.page_is_homepage,this.page_title=t.page_title,this.page_metadata_description=t.page_metadata_description,this.site_meta_description=t.site_meta_description,this.site_name=t.site_name,this.site_og_image=t.site_og_image,this.site_title=t.site_title,this.title_separator=t.title_separator,this.og_title_prefix=t.og_title_prefix,this.url=t.url,this.updateOgImage()},computed:{title(){const{og_title:t,meta_title:i}=this.$store.getters["content/values"](),e=this.og_title_prefix||"",a=this.page_is_homepage?t||i||this.site_name:t||i||this.page_title;return e+a},description(){const{og_description:t,meta_description:i}=this.$store.getters["content/values"]();return t||i||this.page_metadata_description||this.site_meta_description||this.$t("fabianmichael.meta.description_missing")},store_image(){return this.$store.getters["content/values"]().og_image}},watch:{store_image:{handler(){this.updateOgImage()},immediate:!0}},methods:{load(){return this.$api.get(this.parent+"/sections/"+this.name)},updateOgImage(){this.store_image.length>0?this.$api.files.get(this.$store.getters["content/model"]().api,this.store_image[0].filename,{view:"compact"}).then(t=>{this.og_image=t.url,this.og_image_source=this.$t("fabianmichael.meta.source.og_image")}):this.metadata_og_image!==null?(this.og_image=this.metadata_og_image.url,this.og_image_source=this.$t("fabianmichael.meta.source.metadata")):this.site_og_image!==null?(this.og_image=this.site_og_image.url,this.og_image_source=this.$t("fabianmichael.meta.source.site")):this.og_image=null}}},m={};var f=c(k,p,v,!1,y,null,null,null);function y(t){for(let i in m)this[i]=m[i]}var C=function(){return f.exports}(),w=function(){var t=this,i=t.$createElement,e=t._self._c||i;return e("k-field",t._b({staticClass:"k-meta-title-preview"},"k-field",t.$props,!1),[e("div",{staticClass:"k-meta-title-preview__content"},[e("img",{staticClass:"k-k-meta-title-separator-preview__favicon",attrs:{alt:"",width:"16",height:"16",src:t.$urls.site+"/favicon.ico",hidden:!t.showFavicon},on:{error:function(a){t.showFavicon=!1},load:function(a){t.showFavicon=!0}}}),t.showFavicon?t._e():e("k-icon",{attrs:{type:"globe"}}),e("div",{staticClass:"k-meta-title-preview__title"},[e("span",[t._v(t._s(t.title))]),t._v(" "),t.isHomePage?t._e():e("span",{staticClass:"k-meta-title-preview__separator"},[t._v(t._s(t.separatorPreview))]),t._v(" "),t.isHomePage?t._e():e("span",[t._v(t._s(t.siteTitle))])])],1)])},$=[],z="";const b={data(){return{showFavicon:!1}},props:{siteTitle:String,separator:String,label:String,modelTitle:String,isHomePage:Boolean,theme:{default:()=>"field",type:String}},computed:{separatorPreview(){return this.$store.getters["content/values"]().meta_title_separator||this.separator},title(){const t=this.$store.getters["content/values"]();return this.isHomePage?t.meta_title||this.siteTitle:t.meta_title||this.modelTitle||this.$t("fabianmichael.meta.page_title.placeholder")}}},h={};var x=c(b,w,$,!1,S,null,null,null);function S(t){for(let i in h)this[i]=h[i]}var L=function(){return x.exports}(),R=function(){var t=this,i=t.$createElement,e=t._self._c||i;return e("k-inside",[e("k-header",{scopedSlots:t._u([{key:"buttons",fn:function(){return[e("k-button",{attrs:{text:"Validate internal links",icon:"wand",disabled:t.isBusy},on:{click:t.checkInternalLinks}}),e("k-languages-dropdown")]},proxy:!0}])},[t._v(" Metadata ")]),e("table",{staticClass:"k-meta"},[e("thead",[e("tr",[e("th",[e("span",{staticClass:"k-meta-title"},[e("span",{staticClass:"k-meta-caps"},[t._v("Title Override")])])]),e("th",[e("span",{staticClass:"k-meta-title"},[e("span",{staticClass:"k-meta-caps"},[t._v("Meta Description")])])]),e("th",[e("span",{staticClass:"k-meta-title"},[e("span",{staticClass:"k-meta-caps"},[t._v("Share Title")])])]),e("th",{staticStyle:{width:"14rem"}},[e("span",{staticClass:"k-meta-title"},[e("span",{staticClass:"k-meta-caps"},[t._v("Share Description")])])]),e("th",{staticClass:"k-meta-thumbnail-col"},[e("k-icon",{attrs:{type:"image"}})],1),e("th",{staticStyle:{width:"14rem"}},[e("span",{staticClass:"k-meta-title"},[e("k-icon",{attrs:{type:"image"}}),e("span",{staticClass:"k-meta-caps"},[t._v("Alt")])],1)]),e("th",{staticStyle:{width:"3rem","text-align":"center"}},[e("span",{staticClass:"sr-only"},[t._v("Robots")]),e("k-icon",{staticStyle:{"margin-inline":"auto"},attrs:{type:"meta-searcheye"}})],1),e("th",{staticStyle:{width:"3rem","text-align":"center"}},[e("span",{staticClass:"sr-only"},[t._v("Link validation")]),e("k-icon",{staticStyle:{"margin-inline":"auto"},attrs:{type:"url"}})],1)])]),e("tbody",[t._l(t.pages,function(a,n){return[e("tr",{key:n+"_head",attrs:{"data-is-indexible":a.is_indexible}},[e("th",{staticClass:"k-meta-page-header-col",attrs:{colspan:"8"}},[e("div",{staticClass:"k-meta-page-header"},[e("div",{staticClass:"k-meta-status-wrap"},[e("k-status-icon",{attrs:{status:a.status}})],1),e("k-link",{attrs:{to:a.panelUrl}},[t._v(t._s(a.title))]),e("a",{staticClass:"k-meta-infozone",attrs:{href:a.url,target:"_blank",rel:"noopener"}},[e("k-icon",{attrs:{type:"url"}}),e("span",[t._v(t._s(a.shortUrl))])],1),e("span",{staticClass:"k-meta-infozone"},[e("k-icon",{attrs:{type:a.icon||"page"}}),e("span",[t._v(t._s(a.template))])],1)],1)])]),e("tr",{key:n+"_content",attrs:{"data-is-indexible":a.is_indexible}},[e("td",[a.meta_title?e("div",{staticClass:"k-meta-text-xs k-meta-max-3-lines"},[t._v(t._s(a.meta_title))]):[t._v("\u2014")]],2),e("td",[a.meta_description?e("div",{staticClass:"k-meta-text-xs k-meta-max-3-lines"},[t._v(t._s(a.meta_description))]):[t._v("\u2014")]],2),e("td",[a.og_title?e("div",{staticClass:"k-meta-text-xs k-meta-max-3-lines"},[t._v(t._s(a.og_title))]):[t._v("\u2014")]],2),e("td",[a.og_description?e("div",{staticClass:"k-meta-text-xs k-meta-max-3-lines"},[t._v(t._s(a.og_description))]):a.meta_description?e("div",{staticClass:"k-meta-text-xs k-meta-max-3-lines",staticStyle:{opacity:"0.5"}},[t._v("[Meta description]")]):[t._v("\u2014")]],2),e("td",{staticClass:"k-meta-thumbnail-col"},[a.og_image_url?e("k-image",{attrs:{src:a.og_image_url,cover:!0,ratio:"1200/630",back:"pattern"}}):e("div",{staticStyle:{"text-align":"center"}},[t._v("\u2014")])],1),e("td",[a.og_image_alt?e("div",{staticClass:"k-meta-text-xs k-meta-max-3-lines"},[t._v(t._s(a.og_image_alt))]):[t._v("\u2014")]],2),e("td",{staticStyle:{"text-align":"center"}},[e("k-icon",{staticStyle:{"margin-inline":"auto"},attrs:{type:a.is_indexible?"meta-true":"meta-false"}})],1),e("td",{staticStyle:{"text-align":"center"}},[a.internalLinksResult?e("k-icon",{staticStyle:{"margin-inline":"auto"},attrs:{type:a.internalLinksResult&&a.internalLinksResult.message?"meta-false":"meta-true"}}):[t._v("\u2014")]],2)]),a.internalLinksResult&&a.internalLinksResult.message?e("tr",{key:n+"_internal_links_result"},[e("td",{staticClass:"k-meta-result",attrs:{colspan:"8"}},[e("k-box",{attrs:{theme:"negative"}},[e("k-text",{attrs:{size:"tiny"}},[e("p",[t._v(t._s(a.internalLinksResult.message))]),a.internalLinksResult.brokenLinks?e("ul",t._l(a.internalLinksResult.brokenLinks,function(_,o){return e("li",{key:o,domProps:{innerHTML:t._s(_)}})}),0):t._e()])],1)],1)]):t._e()]})],2)])],1)},M=[],E="";const T={props:{dir:String,sort:String,pages:Object},data(){return{isBusy:!1}},methods:{async checkInternalLinks(){this.isBusy=!0;for(let t=0,i=this.pages.length;t<i;t++){const e=this.pages[t];e.internalLinksResult=null,this.$set(this.pages,t,e)}for(let t=0,i=this.pages.length;t<i;t++){const e=this.pages[t],a=e.id,n=await window.panel.api.get("meta/check-internal-links",{id:a,language:this.$multilang?this.$language.code:null});e.internalLinksResult=n,this.$set(this.pages,t,e)}this.isBusy=!1}}},g={};var F=c(T,R,M,!1,P,null,null,null);function P(t){for(let i in g)this[i]=g[i]}var Z=function(){return F.exports}();panel.plugin("fabianmichael/meta",{components:{"k-meta-view":Z},fields:{"meta-title-preview":L,"meta-robots-index-toggles":{extends:"k-toggles-field"}},sections:{"meta-share-preview":C},icons:{"meta-true":'<path d="M10 15.2 19.2 6l1.4 1.4L10 18l-6.4-6.4L5 10.2l5 5Z"/>',"meta-false":'<path d="m12 10.6 5-5 1.4 1.5-5 4.9 5 5-1.5 1.4-4.9-5-5 5L5.6 17l5-5-5-5L7 5.7l5 5Z"/>',"meta-searcheye":'<path d="m18 16.6 4.3 4.3-1.4 1.4-4.3-4.3a9 9 0 1 1 1.4-1.4Zm-2-.7A7 7 0 0 0 11 4a7 7 0 1 0 4.9 12l.1-.1Zm-3.8-8.7a2 2 0 1 0 2.6 2.6 4 4 0 1 1-2.6-2.6Z"/>',"meta-robots":'<path d="M13.5 2c0 .444-.193.843-.5 1.118V5h5a3 3 0 0 1 3 3v10a3 3 0 0 1-3 3H6a3 3 0 0 1-3-3V8a3 3 0 0 1 3-3h5V3.118A1.5 1.5 0 1 1 13.5 2ZM6 7a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V8a1 1 0 0 0-1-1H6Zm-4 3H0v6h2v-6Zm20 0h2v6h-2v-6ZM9 14.5a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3Zm6 0a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3Z" />'}})})();
