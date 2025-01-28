/* global panel */

import './panel.css'

import SharePreviewSection from './components/SharePreviewSection.vue'
import TitlePreviewField from './components/TitlePreviewField.vue'
import MetaView from './components/MetaView.vue'

panel.plugin('fabianmichael/meta', {
  components: {
    'k-meta-view': MetaView
  },
  fields: {
    'meta-title-preview': TitlePreviewField,
    'meta-robots-index-toggles': {
      extends: 'k-toggles-field'
    }
  },
  sections: {
    'meta-share-preview': SharePreviewSection
  },
  icons: {
    'meta-true': '<path d="M10 15.2 19.2 6l1.4 1.4L10 18l-6.4-6.4L5 10.2l5 5Z"/>',
    'meta-false': '<path d="m12 10.6 5-5 1.4 1.5-5 4.9 5 5-1.5 1.4-4.9-5-5 5L5.6 17l5-5-5-5L7 5.7l5 5Z"/>',
    'meta-searcheye': '<path d="m18 16.6 4.3 4.3-1.4 1.4-4.3-4.3a9 9 0 1 1 1.4-1.4Zm-2-.7A7 7 0 0 0 11 4a7 7 0 1 0 4.9 12l.1-.1Zm-3.8-8.7a2 2 0 1 0 2.6 2.6 4 4 0 1 1-2.6-2.6Z"/>',
    'meta-robots': '<path d="M13.5 2c0 .444-.193.843-.5 1.118V5h5a3 3 0 0 1 3 3v10a3 3 0 0 1-3 3H6a3 3 0 0 1-3-3V8a3 3 0 0 1 3-3h5V3.118A1.5 1.5 0 1 1 13.5 2ZM6 7a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V8a1 1 0 0 0-1-1H6Zm-4 3H0v6h2v-6Zm20 0h2v6h-2v-6ZM9 14.5a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3Zm6 0a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3Z" />',
    'meta-eye-off': '<path d="M17.883 19.297A10.949 10.949 0 0 1 12 21c-5.392 0-9.878-3.88-10.818-9A10.982 10.982 0 0 1 4.52 5.935L1.394 2.808l1.414-1.414 19.799 19.798-1.414 1.415-3.31-3.31ZM5.936 7.35A8.965 8.965 0 0 0 3.223 12a9.005 9.005 0 0 0 13.201 5.838l-2.028-2.028A4.5 4.5 0 0 1 8.19 9.604L5.936 7.35Zm6.978 6.978-3.242-3.241a2.5 2.5 0 0 0 3.241 3.241Zm7.893 2.265-1.431-1.431A8.935 8.935 0 0 0 20.778 12 9.005 9.005 0 0 0 9.552 5.338L7.974 3.76C9.221 3.27 10.58 3 12 3c5.392 0 9.878 3.88 10.819 9a10.947 10.947 0 0 1-2.012 4.593Zm-9.084-9.084a4.5 4.5 0 0 1 4.769 4.769l-4.77-4.77Z"/>',
    'meta-eye': '<path d="M12 3c5.392 0 9.878 3.88 10.819 9-.94 5.12-5.427 9-10.819 9-5.392 0-9.878-3.88-10.818-9C2.122 6.88 6.608 3 12 3Zm0 16a9.005 9.005 0 0 0 8.778-7 9.005 9.005 0 0 0-17.555 0A9.005 9.005 0 0 0 12 19Zm0-2.5a4.5 4.5 0 1 1 0-9 4.5 4.5 0 0 1 0 9Zm0-2a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z"/>'
  }
})
