<template>
  <div class="k-meta">
    <div class="k-meta__headline">
      <k-headline>{{ headline }}</k-headline>
    </div>
    <ul>
      <li
        v-for="item in results"
        :key="item.id"
        class="k-meta__result"
      >
        <k-icon
          :type="item.icon"
          color="orange-600"
        />
        <div class="k-meta__result-text">{{ item.text }}</div>
      </li>
    </ul>
  </div>
</template>

<script>

import DescriptionCheck from "./checks/description.js";

const checks = [
  DescriptionCheck,
];

export default {
  data() {
    return {
      headline: "Metadata",
      // results: [],
    };
    // return {
    //   headline: "Basic Meta Information",
    //   site_title: null,
    //   page_title: null,
    //   url: null,
    //   twitter_image: null,
    // };
  },
  created: function() {
    this.load().then((response) => {
      this.headline = response.headline;
      // this.url = response.url;
      // this.page_title = response.title.value;
      // this.twitter_url = response.url;
    });
  },
  computed: {
    results() {
      const values = this.$store.getters["content/values"]();
      return checks.map((v) => {
        let item = v.test(values, this);

        item.icon = this.icon(item);
        item.color = this.color(item);

        return item;
      });
      // return [
      //   {
      //     "icon": "check",
      //     "theme": "positive",
      //     "text": "...",
      //   }
      // ];
      // console.log("update!");
      // return this.$store.getters["content/values"]().meta_description;
    },
  },
  methods: {
    icon(item) {
      if (item.icon) return item.icon;
      if (item.status === "success") return "check";
      if (item.status === "warn") return "alert";
      if (item.status === "info") return "info";
      if (item.status === "hint") return "meta-bulb";

      return "cancel";
    },
    color(item) {
      if (item.status === "success") return "positive";
      if (item.status === "warn") return "orange";
      if (item.status === "info") return "blue";
      if (item.status === "hint") return "gray";

      return "negative";
    },
  },
  // watch: {
  //   meta_description: {
  //     handler() {
  //       if (this.store_image.length === 0) {
  //         this.twitter_image = null;
  //       } else {
  //         this.$api.files
  //           .get(
  //             this.$store.getters["content/model"]().api,
  //             this.store_image[0].filename,
  //             {
  //               view: "compact",
  //             }
  //           )
  //           .then((response) => {
  //             this.twitter_image = response.url;
  //           });
  //       }
  //     },
  //     immediate: true,
  //   },
  // },
};
</script>

<style lang="css">

.k-meta {
  background: var(--color-white);
  border-radius: var(--rounded-sm);
  box-shadow: var(--shadow);
  /* padding: var(--spacing-3); */
}

.k-meta__headline {
  border-bottom: 1px solid var(--color-gray-200);
  padding: var(--spacing-2) var(--spacing-3);
  /* margin: 0 calc(-1 * var(--spacing-3)) var(--spacing-2); */
  /* padding: 0 var(--spacing-3) var(--spacing-2); */
}

.k-meta__result {
  display: grid;
  gap: var(--spacing-3);
  grid-template-columns: min-content 1fr;
  align-items: start;
  padding: var(--spacing-2) var(--spacing-3);
}

.k-meta__result + .k-meta__result {
  border-top: 1px solid var(--color-gray-200);
}

.k-meta__result > .k-icon {
  position: relative;
  top: 2px;
}

.k-meta__result-text {
  font-size: var(--text-sm);
  line-height: 1.25rem;
}

</style>
