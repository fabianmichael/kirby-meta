/* global panel */

import "./panel.css";

// import Section from "./components/Section.vue";
import SharePreviewSection from "./components/SharePreviewSection.vue";
import TitlePreviewField from "./components/TitlePreviewField.vue";
import MetaView from "./components/MetaView.vue";

panel.plugin("fabianmichael/meta", {
  components: {
    "k-meta-view": MetaView,
  },
  fields: {
    "meta-title-preview": TitlePreviewField,
  },
  sections: {
  //   meta: Section,
    "meta-share-preview": SharePreviewSection,
  },
  icons: {
    "meta-true": '<g fill="currentColor"><polygon points="12.4,6 11,4.6 7,8.6 5,6.6 3.6,8 7,11.4 "></polygon></g>',
    "meta-false": '<g fill="currentColor"><polygon points="10.1,4.5 8,6.6 5.9,4.5 4.5,5.9 6.6,8 4.5,10.1 5.9,11.5 8,9.4 10.1,11.5 11.5,10.1 9.4,8 11.5,5.9 "></polygon></g>',
    "meta-robot": '<g fill="currentColor"><path d="M10,0v2h2v2H4V2h2V0H0v2h2v2H0v12h16V4h-2V2h2V0H10z M14,14H2V6h2h8h2V14z"></path><rect x="4" y="7" width="3" height="2"></rect><rect x="9" y="7" width="3" height="2"></rect><rect x="5" y="10" width="6" height="3"></rect>',
  //   "meta-bulb": '<path d="M8,0C4.7,0,2,2.7,2,6c0,2.2,1.2,4.1,3,5.2V15c0,0.6,0.4,1,1,1h4c0.6,0,1-0.4,1-1v-3.8c1.8-1.1,3-3,3-5.2 C14,2.7,11.3,0,8,0z M7,14v-1h2v1H7z M9.6,9.7C9.2,9.8,9,10.2,9,10.6V12H7v-1.4c0-0.4-0.2-0.8-0.6-0.9C4.9,9,4,7.6,4,6 c0-2.2,1.8-4,4-4s4,1.8,4,4C12,7.6,11.1,9,9.6,9.7z"></path>',
  }
});
