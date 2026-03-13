<template>
  <k-button
    class="k-meta-force-no-index-view-button"
    icon="meta-seo"
    variant="filled"
    theme="warning"
    size="sm"
    @click="applause"
  >
    {{ $t('fabianmichael.meta.robots.forceNoIndex.button') }}
  </k-button>
</template>

<script>
export default {
  props: {
    praise: String
  },
  methods: {
    applause() {
      this.$panel.dialog.open({
        component: 'k-text-dialog',
        props: {
          class: 'k-meta-force-no-index-view-button-dialog',
          size: 'medium',
          text: this.$t('fabianmichael.meta.robots.forceNoIndex.infoText'),
          cancelButton: {
            text: this.$t('fabianmichael.meta.robots.forceNoIndex.close'),
          },
          submitButton: false,
        },
      });
    },
  },
};
</script>

<style>

.k-meta-force-no-index-view-button {
  font-weight: 500;
  background: repeating-linear-gradient(
    135deg,
    var(--color-yellow-500) 0 .5rem,
    var(--color-orange-500) .5rem 1rem);
    color: var(--color-orange-950);


  & .k-icon {
    color: inherit;
  }
}

</style>
