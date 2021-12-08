/* global panel */

import "./panel.css";

// import Section from "./components/Section.vue";
import SharePreviewSection from "./components/SharePreviewSection.vue";
import TitlePreviewField from "./components/TitlePreviewField.vue";

panel.plugin("fabianmichael/meta", {
  fields: {
    "meta-title-preview": TitlePreviewField,
  },
  sections: {
  //   meta: Section,
    "meta-share-preview": SharePreviewSection,
  },
  // icons: {
  //   "meta-bulb": '<path d="M8,0C4.7,0,2,2.7,2,6c0,2.2,1.2,4.1,3,5.2V15c0,0.6,0.4,1,1,1h4c0.6,0,1-0.4,1-1v-3.8c1.8-1.1,3-3,3-5.2 C14,2.7,11.3,0,8,0z M7,14v-1h2v1H7z M9.6,9.7C9.2,9.8,9,10.2,9,10.6V12H7v-1.4c0-0.4-0.2-0.8-0.6-0.9C4.9,9,4,7.6,4,6 c0-2.2,1.8-4,4-4s4,1.8,4,4C12,7.6,11.1,9,9.6,9.7z"></path>',
  // }
});
