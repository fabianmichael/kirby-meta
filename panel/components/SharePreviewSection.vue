<template>
  <k-section class="k-meta-sharing-preview">
    <div class="k-meta-sharing-preview__label k-field-label">
      <k-icon type="share"/>
      <k-label>{{ label }}</k-label>
    </div>
    <div class="k-meta-sharing-preview__box">
      <div
        v-if="og_image"
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
        <span class="k-meta-sharing-preview__site-name">{{ og_site_name }}</span>
        <h2 class="k-meta-sharing-preview__preview-headline">
          {{ title }}
        </h2>
        <p class="k-meta-sharing-preview__preview-paragraph">
          {{ description }}
        </p>
      </div>
    </div>
  </k-section>
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
      label: "Basic Meta Information",

      is_homepage: null,
      title_separator: null,

      override_og_title: null,
      override_og_description: null,
      override_og_image: null,

      default_og_title: null,
      default_og_description: null,
      default_og_image: null,

      site_og_description: null,
      og_site_name: null,
      site_og_image: null,

      // computed values
      og_image_source: null,
      og_image: null,
    };
  },
  async created() {
    const response = await this.load();

    this.label = response.label;

    this.is_homepage = response.is_homepage;
    this.title_separator = response.title_separator;

    this.override_og_title = response.override_og_title;
    this.override_og_description = response.override_og_description;
    this.override_og_image = response.override_og_image;

    this.default_og_title = response.default_og_title;
    this.default_og_description = response.default_og_description;
    this.default_og_image = response.default_og_image;

    this.site_og_description = response.site_og_description;
    this.og_site_name = response.og_site_name;
    this.site_og_image = response.site_og_image;

    this.updateOgImage();
  },
  computed: {
    title() {
      const { title, og_title, meta_title } = this.$panel.content.version('changes');
      return (this.override_og_title || og_title || meta_title || title)
    },
    description() {
      const { og_description, meta_description } = this.$panel.content.version('changes');
      return this.override_og_description || og_description || meta_description || this.site_og_description || this.$t("fabianmichael.meta.description_missing");
    },
    store_image() {
      return this.$panel.content.version('changes').og_image;
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
      if (this.override_og_image !== null) {
        this.og_image = this.og_image_override.url;
        this.og_image_source = this.$t("fabianmichael.meta.source.override");
      } else if (this.store_image.length > 0) {
        this.$api.files
          .get(
            this.parent,
            this.store_image[0].filename,
            { view: "compact", }
          ).then((response) => {
            this.og_image = response.url;
            this.og_image_source = this.$t("fabianmichael.meta.source.og_image");
          });
      } else if (this.default_og_image !== null) {
        console.log("default_og_image", this.default_og_image);
        this.og_image = this.default_og_image.url;
        this.og_image_source = this.$t("fabianmichael.meta.source.default");
      } else if (this.site_og_image !== null) {
        console.log("site_og_image", this.site_og_image);
        this.og_image = this.site_og_image.url;
        this.og_image_source = this.$t("fabianmichael.meta.source.site");
      } else {
        this.og_image = null;
        this.og_image_source = null;
      }
    },
  },
};
</script>

<style lang="css">

.k-meta-sharing-preview__label {
  display: flex;
  align-items: center;
  margin-block-end: var(--spacing-1);
}

.k-meta-sharing-preview__label > * + * {
  margin-left: var(--spacing-2);
  padding-top: var(--spacing-px);
}

.k-meta-sharing-preview__source-badge {
  background: var(--item-color-back);
  color: inherit;
  border-radius: var(--rounded);
  bottom: var(--spacing-2);
  box-shadow: var(--item-shadow);
  position: absolute;
  right: var(--spacing-2);
  font-size: .625rem;
  line-height: var(--leading-none);
  padding: var(--spacing-1) var(--spacing-2);
}

.k-meta-sharing-preview__box {
  background: var(--item-color-back);
  border-radius: var(--rounded);
  box-shadow: var(--shadow);
  display: flex;
  flex-direction: column;
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
  padding: var(--spacing-2) var(--spacing-3);
}

.k-meta-sharing-preview__site-name {
  color: var(--color-text-dimmed);
  font-size: var(--text-xs);
}

.k-meta-sharing-preview__url {
  color: var(--color-gray-500);
  font-size: var(--text-xs);
  margin-top: var(--spacing-3);
}

.k-meta-sharing-preview__preview-headline {
  color: var(--color-text);
  font-size: var(--text-base);
  line-height: var(--leading-tight);
  margin: var(--spacing-1) 0;
  padding: 0;
}

.k-meta-sharing-preview__preview-paragraph {
  color: var(--color-text-dimmed);
  font-size: var(--text-sm);
  line-height: var(--leading-normal);
  margin: 0;
  padding: 0;
}

</style>
