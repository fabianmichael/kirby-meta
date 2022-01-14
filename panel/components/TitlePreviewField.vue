<template>
  <k-field
    v-bind="$props"
    class="k-meta-title-preview"
  >
    <div class="k-meta-title-preview__content">
        <img
          alt=""
          width="16"
          height="16"
          class="k-k-meta-title-separator-preview__favicon"
          @error="showFavicon = false"
          @load="showFavicon = true"
          :src="$urls.site + '/favicon.ico'"
          :hidden="!showFavicon"
        />
        <k-icon
          type="globe"
          v-if="!showFavicon"
        />
        <div class="k-meta-title-preview__title">
          <span>{{ title }}</span>
          &#32;
          <span v-if="!isHomePage" class="k-meta-title-preview__separator">{{ separatorPreview }}</span>
          &#32;
          <span v-if="!isHomePage">{{ siteTitle }}</span>
        </div>
    </div>
  </k-field>
</template>

<script>

export default {
  data() {
    return {
      showFavicon: false,
    };
  },
  props: {
    siteTitle: String,
    separator: String,
    label: String,
    modelTitle: String,
    isHomePage: Boolean,
    theme: {
      default: () => 'field',
      type: String,
    },
  },
  computed: {
    separatorPreview() {
      const values = this.$store.getters["content/values"]();
      return values.meta_title_separator || this.separator;
    },
    title() {
      const values = this.$store.getters["content/values"]();
      return this.isHomePage
        ? values.meta_title || this.siteTitle
        : values.meta_title || this.modelTitle || this.$t("fabianmichael.meta.page_title.placeholder");
    },
  },
};

</script>

<style type="css">

.k-meta-title-preview__content {
  background: var(--color-gray-300);
  border: var(--color-white);
  border-radius: var(--rounded-sm);
  padding: var(--field-input-padding);
  display: grid;
  align-items: center;
  gap: .75ch;
  grid-template-columns: min-content 1fr;
}

.k-k-meta-title-separator-preview__favicon {
  border-radius: 2px;
}

.k-meta-title-preview__title {
  overflow: hidden;
  text-overflow: ellipsis;
  font-size: var(--text-sm);
  height: var(--field-input-line-height);
  position: relative;
  top: .07em;
  white-space: nowrap;
}

</style>

