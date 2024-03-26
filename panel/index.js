/* global panel */

import "./panel.css";

import SharePreviewSection from "./components/SharePreviewSection.vue";
import TitlePreviewField from "./components/TitlePreviewField.vue";
import MetaView from "./components/MetaView.vue";

panel.plugin("fabianmichael/meta", {
  // use: [
  //   function (Vue) {
  //     const original = Vue.component("k-model-tabs");
  //     console.log("prop", original);

  //     Vue.component('k-model-tabs', {
  //       render: original.options.render,
  //       props: {
  //         ...original.options.props,
  //       },
  //       computed: {
  //         ...original.options.computed,
  //         withBadges() {
  //           let tabs = original.options.computed.withBadges.call(this);
  //           console.log("tabs", tabs);

  //           tabs = tabs.map((tab) => {
  //             if (tab.name === 'meta') {
  //               // tab.icon = "status-listed"
  //               tab.badge = '×';
  //             }

  //             return tab;
  //           });

  //           return tabs;
  //         }
  //       },
  //     });
  //   },
  // ],

  components: {
    "k-meta-view": MetaView,
  },
  fields: {
    "meta-title-preview": TitlePreviewField,
    "meta-robots-index-toggles": {
      extends: "k-toggles-field"
    },
  },
  sections: {
    "meta-share-preview": SharePreviewSection,
  },
  icons: {
    "meta-true": '<path d="M10 15.2 19.2 6l1.4 1.4L10 18l-6.4-6.4L5 10.2l5 5Z"/>',
    "meta-false": '<path d="m12 10.6 5-5 1.4 1.5-5 4.9 5 5-1.5 1.4-4.9-5-5 5L5.6 17l5-5-5-5L7 5.7l5 5Z"/>',
    "meta-searcheye": '<path d="m18 16.6 4.3 4.3-1.4 1.4-4.3-4.3a9 9 0 1 1 1.4-1.4Zm-2-.7A7 7 0 0 0 11 4a7 7 0 1 0 4.9 12l.1-.1Zm-3.8-8.7a2 2 0 1 0 2.6 2.6 4 4 0 1 1-2.6-2.6Z"/>',
    "meta-robots": `<path d="M13.5 2c0 .444-.193.843-.5 1.118V5h5a3 3 0 0 1 3 3v10a3 3 0 0 1-3 3H6a3 3 0 0 1-3-3V8a3 3 0 0 1 3-3h5V3.118A1.5 1.5 0 1 1 13.5 2ZM6 7a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V8a1 1 0 0 0-1-1H6Zm-4 3H0v6h2v-6Zm20 0h2v6h-2v-6ZM9 14.5a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3Zm6 0a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3Z" />`,
  }
});
