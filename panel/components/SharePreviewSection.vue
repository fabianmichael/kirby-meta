<template>
  <div class="k-meta-sharing-preview">
    <div class="k-meta-sharing-preview__label k-field-label">
      <k-icon type="share"/>
      <span>{{ headline }}</span>
    </div>
    <div class="k-meta-sharing-preview__box">
      <div
        class="k-meta-sharing-preview__image-container"
        :data-image-missing="!og_image"
        :data-image-missing-text="$t('fabianmichael.meta.og_image.missing')"
      >
        <img
          v-if="og_image"
          :src="og_image"
          class="k-meta-sharing-preview__preview-image"
        />
        <span
          v-if="og_image_source"
          class="k-meta-sharing-preview__source-badge"
        >{{ og_image_source }}</span>
      </div>
      <div class="k-meta-sharing-preview__content-container">
        <span class="k-meta-sharing-preview__site-name">{{ site_name }}</span>
        <h2 class="k-meta-sharing-preview__preview-headline">
          {{ title }}
        </h2>
        <p class="k-meta-sharing-preview__preview-paragraph">
          {{ description }}
        </p>
      </div>
    </div>
  </div>
</template>

<script>

export default {
  props: {
    blueprint: String,
    lock: [Boolean, Object],
    help: String,
    name: String,
    parent: String,
    timestamp: Number
  },
  data() {
    return {
      headline: "Basic Meta Information",
      metadata_og_image: null,
      metadata_og_image_field: null,
      page_is_homepage: null,
      page_title: null,
      page_metadata_description: null,
      site_meta_description: null,
      site_name: null,
      site_og_image: null,
      site_title: null,
      title_separator: null,
      url: null,
      og_title_prefix: null,

      og_image: null,
      og_image_source: null,
    };
  },
  async created() {
    const response = await this.load();

    this.headline = response.headline;
    this.metadata_og_image = response.metadata_og_image;
    this.metadata_og_image_field = response.metadata_og_image_field;
    this.page_is_homepage = response.page_is_homepage;
    this.page_title = response.page_title;
    this.page_metadata_description = response.page_metadata_description;
    this.site_meta_description = response.site_meta_description;
    this.site_name = response.site_name;
    this.site_og_image = response.site_og_image;
    this.site_title = response.site_title;
    this.title_separator = response.title_separator;
    this.og_title_prefix = response.og_title_prefix;
    this.url = response.url;

    this.updateOgImage();
  },
  computed: {
    title() {
      const { og_title, meta_title } = this.$store.getters["content/values"]();
      const prefix = this.og_title_prefix || "";
      const title = this.page_is_homepage
        ? (og_title || meta_title || this.site_name)
        : (og_title || meta_title || this.page_title);

      return prefix + title;
    },
    description() {
      const { og_description, meta_description } = this.$store.getters["content/values"]();
      return og_description || meta_description || this.page_metadata_description || this.site_meta_description || this.$t("fabianmichael.meta.description_missing");
    },
    store_image() {
      return this.$store.getters["content/values"]().og_image;
    },
  },
  watch: {
    store_image: {
      handler() {
        this.updateOgImage();
      },
      immediate: true,
    },
  },
  methods: {
    load() {
      return this.$api.get(this.parent + "/sections/" + this.name);
    },
    updateOgImage() {
      if (this.store_image.length > 0) {
        this.$api.files
          .get(
            this.$store.getters["content/model"]().api,
            this.store_image[0].filename,
            { view: "compact", }
          ).then((response) => {
            this.og_image = response.url;
            this.og_image_source = this.$t("fabianmichael.meta.source.og_image");
          });
      } else if (this.metadata_og_image !== null) {
        this.og_image = this.metadata_og_image.url;
        this.og_image_source = this.$t("fabianmichael.meta.source.metadata");
      } else if (this.site_og_image !== null) {
        this.og_image = this.site_og_image.url
        this.og_image_source = this.$t("fabianmichael.meta.source.site");
      } else {
        this.og_image = null;
      }
    },
  },
};
</script>

<style lang="css">

.k-meta-sharing-preview__label {
  display: flex;
}

.k-meta-sharing-preview__label > * + * {
  margin-left: var(--spacing-2);
  padding-top: var(--spacing-px);
}

.k-meta-sharing-preview__source-badge {
  background: var(--color-gray-900);
  color: var(--color-white);
  border-radius: var(--rounded-sm);
  bottom: var(--spacing-2);
  position: absolute;
  right: var(--spacing-2);
  font-size: .625rem;
  line-height: var(--leading-none);
  padding: var(--spacing-1) var(--spacing-2);
}

.k-meta-sharing-preview__box {
  background: var(--color-white);
  border-radius: var(--rounded);
  box-shadow: var(--shadow);
  display: flex;
  flex-direction: column;
  max-width: 438px;
  overflow: hidden;
  position: relative;
  width: 100%;
}

.k-meta-sharing-preview__image-container {
  background: var(--bg-pattern) var(--color-gray-800);
  padding-bottom: 52.25%;
  position: relative;
  width: 100%;
}

.k-meta-sharing-preview__image-container[data-image-missing]::before {
  content: attr(data-image-missing-text);
  color: var(--color-white);
  position: absolute;
  font-size: 1.5em;
  top: 50%;
  left: 50%;
  width: 100%;
  text-align: center;
  transform: translate(-50%, -50%) rotate(-20deg);
}

.k-meta-sharing-preview__preview-image {
  position: absolute;
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.k-meta-sharing-preview__content-container {
  padding: var(--spacing-2) var(--spacing-3) var(--spacing-3);
}

.k-meta-sharing-preview__site-name {
  color: var(--color-gray-600);
  font-size: var(--text-xs);
}

.k-meta-sharing-preview__url {
  color: var(--color-gray-500);
  font-size: var(--text-xs);
  margin-top: var(--spacing-3);
}

.k-meta-sharing-preview__preview-headline {
  color: var(--color-dark);
  font-size: var(--text-base);
  line-height: var(--leading-tight);
  margin: var(--spacing-1) 0;
  padding: 0;
}

.k-meta-sharing-preview__preview-paragraph {
  color: var(--color-gray-600);
  font-size: var(--text-sm);
  line-height: var(--leading-normal);
  margin: 0;
  padding: 0;
}

</style>
