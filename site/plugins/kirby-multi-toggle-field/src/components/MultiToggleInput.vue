<template>
  <div
    :data-show-text-label="textLabels ? '' : false"
    :style="'--options:' + options.length"
    :class="{'k-multi-toggle-input': true, 'k-multi-toggle-input--equalize': equalize}"
  >
    <ul>
      <li
        v-for="(option, index) in options"
        :key="index"
      >
        <input
          :id="id + '-' + index"
          :value="option.value"
          :name="id"
          :checked="value === option.value"
          type="radio"
          @change="onInput(option.value)"
        />
        <label
          :for="id + '-' + index"
          :title="!textLabels ? option.text : null"
        >
          <k-icon
            v-if="option.icon"
            :type="option.icon"
          />
          <span
            v-if="textLabels"
            class="k-multi-toggle-text"
          >
            {{ option.text }}
          </span>
        </label>
      </li>
    </ul>
    <k-button
      v-if="value && reset && !required"
      @click="onReset()"
      :tooltip="$t('fabianmichael.multi-toggle.reset')"
    ><k-icon type="undo" /></k-button>
  </div>
</template>

<script>
import { required } from "vuelidate/lib/validators";

export default {
  inheritAttrs: false,
  props: {
    autofocus: Boolean,
    disabled: Boolean,
    id: {
      type: [Number, String],
      default() {
        return this._uid;
      }
    },
    options: Array,
    required: Boolean,
    textLabels: Boolean,
    reset: Boolean,
    equalize: Boolean,
    value: [String, Number, Boolean],
  },
  watch: {
    value() {
      this.onInvalid();
    }
  },
  mounted() {
    this.onInvalid();

    if (this.$props.autofocus) {
      this.focus();
    }
  },
  methods: {
    focus() {
      (this.$el.querySelector("input[checked]") || this.$el.querySelector("input")).focus();
    },
    onInput(value) {
      this.$emit("input", value);
    },
    onInvalid() {
      this.$emit("invalid", this.$v.$invalid, this.$v);
    },
    select() {
      this.focus();
    },
    onReset() {
      this.$emit("reset");
    }
  },
  validations() {
    return {
      value: {
        required: this.required ? required : true
      }
    };
  }
};
</script>

<style lang="scss">

.k-multi-toggle-input {
  --border-radius: 3px;
  --color-focus-text-light: #a1b7d3;
  --col-width: auto;

  display: inline-flex;
  line-height: 1;
}

.k-multi-toggle-input--equalize {
  --col-width: 1fr;
}

.k-multi-toggle-input ul {
  border: 1px solid var(--color-border);
  border-radius: var(--border-radius);
  display: inline-grid;
  grid-template-columns: repeat(var(--options), var(--col-width));
  overflow: hidden;
  text-align: center;
}

.k-multi-toggle-field .k-input[data-invalid] ul {
  box-shadow: 0 0 3px 2px var(--color-negative-outline);
}

.k-multi-toggle-input ul + .k-button {
  margin-left: 1rem;
}

.k-multi-toggle-field .k-input[data-invalid]:focus-within {
  border: 0 !important;
  box-shadow: none !important;
}

.k-multi-toggle-field .k-input[data-invalid]:focus-within ul {
  border: 1px solid var(--color-negative);
  box-shadow: 0 0 0 2px var(--color-negative-outline);
}

.k-multi-toggle-input:focus-within ul {
  border: 1px solid var(--color-focus);
  box-shadow: 0 0 0 2px var(--color-focus-outline);
}

.k-multi-toggle-input li {
  position: relative;
}

.k-multi-toggle-input input {
  appearance: none;
  height: 0;
  opacity: 0;
  position: absolute;
  width: 0;
}

.k-multi-toggle-input label {
  align-items: center;
  background: #fff;
  cursor: pointer;
  display: flex;
  font-size: var(--font-size-small);
  justify-content: center;
  line-height: 1.25rem;
  height: 100%;
  padding: .5rem .75rem;
}

.k-multi-toggle-input li + li label {
  border-left: 1px solid var(--color-border);
}

.k-multi-toggle-input .k-icon + .k-multi-toggle-text {
  margin-left: .5rem;
}

.k-multi-toggle-input input + label {
  color: var(--color-text);
}

.k-multi-toggle-input input:checked + label {
  background: var(--color-text);
  color: #fff;
}

.k-multi-toggle-input:focus-within input:checked + label {
  color: var(--color-focus-text-light);
}

.k-multi-toggle-input .k-button {
  font-size: .8125rem;
}

</style>
