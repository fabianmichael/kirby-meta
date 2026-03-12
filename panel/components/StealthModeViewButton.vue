<template>
  <k-button
    class="k-meta-stealth-mode-view-button"
    icon="meta-seo"
    variant="filled"
    theme="warning"
    size="sm"
    @click="applause"
  >
    {{ $t('fabianmichael.meta.stealthMode.button') }}
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
          class: 'k-meta-stealth-mode-view-button-dialog',
          size: 'medium',
          text: this.$t('fabianmichael.meta.stealthMode.infoText'),
          cancelButton: {
            text: this.$t('fabianmichael.meta.stealthMode.close'),
          },
          submitButton: false,
        },
      });
    },
  },
};
</script>

<style>

.k-meta-stealth-mode-view-button {
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
