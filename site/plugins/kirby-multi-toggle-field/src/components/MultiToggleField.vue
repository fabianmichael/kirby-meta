<template>
  <k-field
    v-bind="$props"
    class="k-multi-toggle-field"
  >
    <k-input
      :id="_uid"
      ref="input"
      v-bind="$props"
      type="multi-toggle"
      v-on="$listeners"
      @reset="onInput('')"
    />
  </k-field>
</template>

<script>
export default {
  props: {
    label: String,
    options: Array,
    textLabels: Boolean,
    value: String,
    help: String,
    disabled: Boolean,
    required: Boolean,
    reset: Boolean,
    equalize: Boolean,
  },

  methods: {
    focus() {
      this.$refs.input.focus();
    },
    onInput(value) {
      this.$emit("input", value);
    },
  },
}
</script>

<style lang="scss">

.k-multi-toggle-field .k-input[data-invalid] {
  box-shadow: none;
}

.k-multi-toggle-field .k-input,
.k-multi-toggle-field .k-input-element {
  display: inline-flex;
}

</style>
