(function(){"use strict";var z="",d=function(){var t=this,s=t.$createElement,e=t._self._c||s;return e("div",{staticClass:"k-meta-sharing-preview"},[e("div",{staticClass:"k-meta-sharing-preview__label k-field-label"},[e("k-icon",{attrs:{type:"share"}}),e("span",[t._v(t._s(t.headline))])],1),e("div",{staticClass:"k-meta-sharing-preview__box"},[e("div",{staticClass:"k-meta-sharing-preview__image-container",attrs:{"data-image-missing":!t.og_image,"data-image-missing-text":t.$t("fabianmichael.meta.og_image.missing")}},[t.og_image?e("img",{staticClass:"k-meta-sharing-preview__preview-image",attrs:{src:t.og_image}}):t._e(),t.og_image_source?e("span",{staticClass:"k-meta-sharing-preview__source-badge"},[t._v(t._s(t.og_image_source))]):t._e()]),e("div",{staticClass:"k-meta-sharing-preview__content-container"},[e("span",{staticClass:"k-meta-sharing-preview__site-name"},[t._v(t._s(t.site_name))]),e("h2",{staticClass:"k-meta-sharing-preview__preview-headline"},[t._v(" "+t._s(t.title)+" ")]),e("p",{staticClass:"k-meta-sharing-preview__preview-paragraph"},[t._v(" "+t._s(t.description)+" ")])])])])},v=[],I="";function c(t,s,e,a,n,o,_,H){var i=typeof t=="function"?t.options:t;s&&(i.render=s,i.staticRenderFns=e,i._compiled=!0),a&&(i.functional=!0),o&&(i._scopeId="data-v-"+o);var l;if(_?(l=function(r){r=r||this.$vnode&&this.$vnode.ssrContext||this.parent&&this.parent.$vnode&&this.parent.$vnode.ssrContext,!r&&typeof __VUE_SSR_CONTEXT__!="undefined"&&(r=__VUE_SSR_CONTEXT__),n&&n.call(this,r),r&&r._registeredComponents&&r._registeredComponents.add(_)},i._ssrRegister=l):n&&(l=H?function(){n.call(this,(i.functional?this.parent:this).$root.$options.shadowRoot)}:n),l)if(i.functional){i._injectStyles=l;var O=i.render;i.render=function(B,p){return l.call(p),O(B,p)}}else{var u=i.beforeCreate;i.beforeCreate=u?[].concat(u,l):[l]}return{exports:t,options:i}}const k={props:{blueprint:String,lock:[Boolean,Object],help:String,name:String,parent:String,timestamp:Number},data(){return{headline:"Basic Meta Information",metadata_og_image:null,metadata_og_image_field:null,page_is_homepage:null,page_title:null,page_metadata_description:null,site_meta_description:null,site_name:null,site_og_image:null,site_title:null,title_separator:null,url:null,og_image:null,og_image_source:null}},async created(){const t=await this.load();this.headline=t.headline,this.metadata_og_image=t.metadata_og_image,this.metadata_og_image_field=t.metadata_og_image_field,this.page_is_homepage=t.page_is_homepage,this.page_title=t.page_title,this.page_metadata_description=t.page_metadata_description,this.site_meta_description=t.site_meta_description,this.site_name=t.site_name,this.site_og_image=t.site_og_image,this.site_title=t.site_title,this.title_separator=t.title_separator,this.url=t.url,this.updateOgImage()},computed:{title(){const{og_title:t,meta_title:s}=this.$store.getters["content/values"]();return this.page_is_homepage?t||s||this.site_name:t||s||this.page_title},description(){const{og_description:t,meta_description:s}=this.$store.getters["content/values"]();return t||s||this.page_metadata_description||this.site_meta_description||this.$t("fabianmichael.meta.description_missing")},store_image(){return this.$store.getters["content/values"]().og_image}},watch:{store_image:{handler(){this.updateOgImage()},immediate:!0}},methods:{load(){return this.$api.get(this.parent+"/sections/"+this.name)},updateOgImage(){this.store_image.length>0?this.$api.files.get(this.$store.getters["content/model"]().api,this.store_image[0].filename,{view:"compact"}).then(t=>{this.og_image=t.url,this.og_image_source=this.$t("fabianmichael.meta.source.og_image")}):this.metadata_og_image!==null?(this.og_image=this.metadata_og_image.url,this.og_image_source=this.$t("fabianmichael.meta.source.metadata")):this.site_og_image!==null?(this.og_image=this.site_og_image.url,this.og_image_source=this.$t("fabianmichael.meta.source.site")):this.og_image=null}}},m={};var f=c(k,d,v,!1,C,null,null,null);function C(t){for(let s in m)this[s]=m[s]}var w=function(){return f.exports}(),y=function(){var t=this,s=t.$createElement,e=t._self._c||s;return e("k-field",t._b({staticClass:"k-meta-title-preview"},"k-field",t.$props,!1),[e("div",{staticClass:"k-meta-title-preview__content"},[e("img",{staticClass:"k-k-meta-title-separator-preview__favicon",attrs:{alt:"",width:"16",height:"16",src:t.$urls.site+"/favicon.ico",hidden:!t.showFavicon},on:{error:function(a){t.showFavicon=!1},load:function(a){t.showFavicon=!0}}}),e("div",{staticClass:"k-meta-title-preview__title"},[e("span",[t._v(t._s(t.title))]),t._v(" "),t.isHomePage?t._e():e("span",{staticClass:"k-meta-title-preview__separator"},[t._v(t._s(t.separatorPreview))]),t._v(" "),t.isHomePage?t._e():e("span",[t._v(t._s(t.siteTitle))])])])])},$=[],U="";const b={data(){return{showFavicon:!1}},props:{siteTitle:String,separator:String,label:String,modelTitle:String,isHomePage:Boolean,theme:{default:()=>"field",type:String}},computed:{separatorPreview(){return this.$store.getters["content/values"]().meta_title_separator||this.separator},title(){const t=this.$store.getters["content/values"]();return this.isHomePage?t.meta_title||this.siteTitle:t.meta_title||this.modelTitle||this.$t("fabianmichael.meta.page_title.placeholder")}}},h={};var x=c(b,y,$,!1,S,null,null,null);function S(t){for(let s in h)this[s]=h[s]}var R=function(){return x.exports}(),L=function(){var t=this,s=t.$createElement,e=t._self._c||s;return e("k-inside",[e("k-view",[e("k-header",[t._v(" Metadata "),e("k-button-group",{attrs:{slot:"left"},slot:"left"},[e("k-button",{attrs:{text:"Validate internal links",icon:"wand",disabled:t.isBusy},on:{click:t.checkInternalLinks}}),e("k-languages-dropdown")],1)],1),e("table",{staticClass:"k-meta"},[e("thead",[e("tr",[e("th",[e("span",{staticClass:"k-meta-title"},[e("span",{staticClass:"k-meta-caps"},[t._v("Title Override")])])]),e("th",[e("span",{staticClass:"k-meta-title"},[e("span",{staticClass:"k-meta-caps"},[t._v("Meta Description")])])]),e("th",[e("span",{staticClass:"k-meta-title"},[e("k-icon",{attrs:{type:"share"}}),e("span",{staticClass:"k-meta-caps"},[t._v("Title")])],1)]),e("th",{staticStyle:{width:"14rem"}},[e("span",{staticClass:"k-meta-title"},[e("k-icon",{attrs:{type:"share"}}),e("span",{staticClass:"k-meta-caps"},[t._v("Description")])],1)]),e("th",{staticClass:"k-meta-thumbnail-col"},[e("k-icon",{attrs:{type:"image"}})],1),e("th",{staticStyle:{width:"14rem"}},[e("span",{staticClass:"k-meta-title"},[e("k-icon",{attrs:{type:"image"}}),e("span",{staticClass:"k-meta-caps"},[t._v("Alt")])],1)]),e("th",{staticStyle:{width:"3rem"}},[e("span",{staticClass:"sr-only"},[t._v("Robots")]),e("k-icon",{attrs:{type:"meta-robot"}})],1),e("th",{staticStyle:{width:"3rem"}},[e("span",{staticClass:"sr-only"},[t._v("Link validation")]),e("k-icon",{attrs:{type:"url"}})],1)])]),e("tbody",[t._l(t.pages,function(a,n){return[e("tr",{key:n+"_head",attrs:{"data-is-indexible":a.is_indexible}},[e("th",{staticClass:"k-meta-page-header-col",attrs:{colspan:"8"}},[e("div",{staticClass:"k-meta-page-header"},[e("div",{staticClass:"k-meta-status-wrap"},[e("k-status-icon",{attrs:{status:a.status}})],1),e("k-link",{attrs:{to:a.panelUrl}},[t._v(t._s(a.title))]),e("a",{staticClass:"k-meta-infozone",attrs:{href:a.url,target:"_blank",rel:"noopener"}},[e("k-icon",{attrs:{type:"url"}}),e("span",[t._v(t._s(a.shortUrl))])],1),e("span",{staticClass:"k-meta-infozone"},[e("k-icon",{attrs:{type:a.icon||"page"}}),e("span",[t._v(t._s(a.template))])],1)],1)])]),e("tr",{key:n+"_content",attrs:{"data-is-indexible":a.is_indexible}},[e("td",[a.meta_title?e("div",{staticClass:"k-meta-text-xs k-meta-max-3-lines"},[t._v(t._s(a.meta_title))]):[t._v("\u2014")]],2),e("td",[a.meta_description?e("div",{staticClass:"k-meta-text-xs k-meta-max-3-lines"},[t._v(t._s(a.meta_description))]):[t._v("\u2014")]],2),e("td",[a.og_title?e("div",{staticClass:"k-meta-text-xs k-meta-max-3-lines"},[t._v(t._s(a.og_title))]):[t._v("\u2014")]],2),e("td",[a.og_description?e("div",{staticClass:"k-meta-text-xs k-meta-max-3-lines"},[t._v(t._s(a.og_description))]):[t._v("\u2014")]],2),e("td",{staticClass:"k-meta-thumbnail-col"},[a.og_image?[e("k-link",{attrs:{to:a.og_image_panelUrl}},[e("k-image",t._b({attrs:{cover:!0,ratio:"1200/630",back:"pattern"}},"k-image",a.og_image,!1))],1)]:e("div",{staticClass:"k-meta-center"},[t._v("\u2014")])],2),e("td",[a.og_image_alt?e("div",{staticClass:"k-meta-text-xs k-meta-max-3-lines"},[t._v(t._s(a.og_image_alt))]):[t._v("\u2014")]],2),e("td",[e("div",{staticClass:"k-meta-center"},[e("k-icon",{attrs:{type:a.is_indexible?"meta-true":"meta-false"}})],1)]),e("td",[e("div",{staticClass:"k-meta-center"},[a.internalLinksResult?e("k-icon",{attrs:{type:a.internalLinksResult&&a.internalLinksResult.message?"meta-false":"meta-true"}}):[t._v("\u2014")]],2)])]),a.internalLinksResult&&a.internalLinksResult.message?e("tr",{key:n+"_internal_links_result"},[e("td",{staticClass:"k-meta-result",attrs:{colspan:"8"}},[e("k-box",{attrs:{theme:"negative"}},[e("k-text",{attrs:{size:"tiny"}},[e("p",[t._v(t._s(a.internalLinksResult.message))]),a.internalLinksResult.brokenLinks?e("ul",t._l(a.internalLinksResult.brokenLinks,function(o,_){return e("li",{key:_,domProps:{innerHTML:t._s(o)}})}),0):t._e()])],1)],1)]):t._e()]})],2)])],1)],1)},T=[],E="";const V={props:{dir:String,sort:String,pages:Object},data(){return{isBusy:!1}},methods:{async checkInternalLinks(){this.isBusy=!0;for(let t=0,s=this.pages.length;t<s;t++){const e=this.pages[t];e.internalLinksResult=null,this.$set(this.pages,t,e)}for(let t=0,s=this.pages.length;t<s;t++){const e=this.pages[t],a=e.id,n=await this.$api.get("meta/check-internal-links",{id:a,language:this.$multilang?this.$language.code:null});e.internalLinksResult=n,this.$set(this.pages,t,e)}this.isBusy=!1}}},g={};var M=c(V,L,T,!1,P,null,null,null);function P(t){for(let s in g)this[s]=g[s]}var F=function(){return M.exports}();panel.plugin("fabianmichael/meta",{components:{"k-meta-view":F},fields:{"meta-title-preview":R},sections:{"meta-share-preview":w},icons:{"meta-true":'<g fill="currentColor"><polygon points="12.4,6 11,4.6 7,8.6 5,6.6 3.6,8 7,11.4 "></polygon></g>',"meta-false":'<g fill="currentColor"><polygon points="10.1,4.5 8,6.6 5.9,4.5 4.5,5.9 6.6,8 4.5,10.1 5.9,11.5 8,9.4 10.1,11.5 11.5,10.1 9.4,8 11.5,5.9 "></polygon></g>',"meta-robot":'<g fill="currentColor"><path d="M10,0v2h2v2H4V2h2V0H0v2h2v2H0v12h16V4h-2V2h2V0H10z M14,14H2V6h2h8h2V14z"></path><rect x="4" y="7" width="3" height="2"></rect><rect x="9" y="7" width="3" height="2"></rect><rect x="5" y="10" width="6" height="3"></rect>'}})})();
