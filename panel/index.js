/* global panel */

import "./panel.css";

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
    "meta-share-preview": SharePreviewSection,
  },
  icons: {
    "meta-true": '<path d="M10 15.2 19.2 6l1.4 1.4L10 18l-6.4-6.4L5 10.2l5 5Z"/>',
    "meta-false": '<path d="m12 10.6 5-5 1.4 1.5-5 4.9 5 5-1.5 1.4-4.9-5-5 5L5.6 17l5-5-5-5L7 5.7l5 5Z"/>',
    "meta-searcheye": '<path d="m18 16.6 4.3 4.3-1.4 1.4-4.3-4.3a9 9 0 1 1 1.4-1.4Zm-2-.7A7 7 0 0 0 11 4a7 7 0 1 0 4.9 12l.1-.1Zm-3.8-8.7a2 2 0 1 0 2.6 2.6 4 4 0 1 1-2.6-2.6Z"/>',
  }
});
