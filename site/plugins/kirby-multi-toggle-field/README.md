# Multi-Toggle field for Kirby 3

An exploration of a new UI element/field for Kirby CMS, resembling the multi-toggles ususally found in desktop software for things, such as text alignment and various other settings. Could especially be useful for the blocks/layout fields, because it’s way more compact and visually appearing, than radio buttons. Could also be a handy alternative for the select field in many cases, because it requires only one click to select an option and all options are visible at first glance.

Unlike most Kirby fields, the multi-toggle does not cover the whole available width, to give it a lighter appearance. But it has a min-height set, so it won’t look weird, when placed next to another field in a multi-column layout.

![Field preview](preview.gif)

## Installation

Either download this repo, extract and copy into `site/plugins` or install using composer:

```bash
composer require fabianmichael/kirby-multi-toggle-field
```

## Blueprint usage

```yaml

# Icons and text labels
textAlign:
  type: multi-toggle
  label: Text alignment
  textLabels: true
  required: true # reset button is automatically disabled, when field is required
  equalize: true # Equalize items’ widths (default: true)
  options:
    - value: normal
      text: Left
      icon: align-left
    - value: center
      text: Center
      icon: align-center
    - value: right
      text: Right
      icon: align-right
    - value: justify
      text: Justify
      icon: align-justify

# Text labels only
width:
  type: multi-toggle
  label: Width
  textLabels: true
  equalize: false # Disable equalization of item widths
  reset: false # reset button can also be disabled for non-required fields.
  options:
    third: 33%
    half: 50%
    full: 100%

#  Icons only
level:
  type: multi-toggle
  label: Heading level
  textLabels: false
  width: 1/2
  options:
    - value: h1
      text: h1
      icon: heading-1
    - value: h2
      text: h2
      icon: heading-2
    - value: h3
      text: h3
      icon: heading-3
    - value: h4
      text: h4
      icon: heading-4
    - value: h5
      text: h5
      icon: heading-5
    - value: h6
      text: h6
      icon: heading-6
```

## System Requirements

- Kirby 3.5+
- PHP 7.3+

## Caveats

The field layout could lead to problems on very small screens. The developer is responsible for not adding too many options. One solution could be to collapse the field on mobile or replacing it with a select box, when not enough space is available.

## License

This plugin is licensed under the MIT license with the exception of the included icons from the Nucleo set. See src/index.js for further information on the icons’ license.
