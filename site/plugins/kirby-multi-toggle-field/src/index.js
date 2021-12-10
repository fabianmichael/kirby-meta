/* global panel */

import MultiToggleField from "./components/MultiToggleField.vue";
import MultiToggleInput from "./components/MultiToggleInput.vue";

panel.plugin("fabianmichael/multi-toggle-field", {
  components: {
    "k-multi-toggle-input": MultiToggleInput,
  },
  fields: {
    "multi-toggle": MultiToggleField,
  },
  icons: {
    /**
     * Copyright (C) Amber Creative Lab Ltd
     *
     * Version 1, 2 July 2018
     *
     * Nucleo Icons
     *
     * https://nucleoapp.com/
     *
     * The Nucleo icons are copyrighted. Redistribution is not permitted. Use in
     * source and binary forms, with or without modification, is permitted only if
     * you possess a Nucleo icons license.
     *
     * Please refer to the license for additional information https://nucleoapp.com/license
     */
    "align-left": '<rect y="1" width="16" height="2"></rect><rect data-color="color-2" y="5" width="10" height="2"></rect><rect y="9" width="16" height="2"></rect><rect data-color="color-2" y="13" width="10" height="2"></rect>',
    "align-center": '<rect y="1" width="16" height="2"></rect><rect data-color="color-2" x="3" y="5" width="10" height="2"></rect><rect y="9" width="16" height="2"></rect><rect data-color="color-2" x="3" y="13" width="10" height="2"></rect>',
    "align-right": '<rect y="1" width="16" height="2"></rect><rect data-color="color-2" x="6" y="5" width="10" height="2"></rect><rect y="9" width="16" height="2"></rect><rect data-color="color-2" x="6" y="13" width="10" height="2"></rect>',
    "align-justify": '<rect y="1" width="16" height="2"></rect> <rect data-color="color-2" y="5" width="16" height="2"></rect> <rect y="9" width="16" height="2"></rect> <rect data-color="color-2" y="13" width="16" height="2"></rect>',

    "heading-1": '<polygon points="8 3 6 3 6 7 3 7 3 3 1 3 1 13 3 13 3 9 6 9 6 13 8 13 8 3"></polygon><polygon points="14 13 12 13 12 5.929 10.606 7.124 9.304 5.605 12.345 3 14 3 14 13"></polygon>',
    "heading-2": '<path d="M16,13H9V11c2-1,5-3.356,5-4.84a1.381,1.381,0,0,0-1.424-1.516,4.6,4.6,0,0,0-2.622,1.02L8.923,3.95a6.24,6.24,0,0,1,3.653-1.306A3.3,3.3,0,0,1,16,6.115C16,7.987,14.08,9.756,12.479,11H16Zm-6-1.5h0Z"></path><polygon points="7 3 5 3 5 7 2 7 2 3 0 3 0 13 2 13 2 9 5 9 5 13 7 13 7 9 7 9 7 7 7 7 7 3"></polygon>',
    "heading-3": '<path d="M14.7,7.8a2.765,2.765,0,0,0,1-2.2c0-1.826-1.521-3.1-3.7-3.1A6.151,6.151,0,0,0,8.5,3.617l.969,1.731A4.621,4.621,0,0,1,12,4.5c.284,0,1.7.053,1.7,1.1C13.7,6.9,12.017,7,12,7H10.4V9h1C14,9,14,9.828,14,10.1c0,1.263-1.4,1.4-2,1.4a4.721,4.721,0,0,1-2.751-.858L8.285,12.4A6.939,6.939,0,0,0,12,13.5c2.393,0,4-1.366,4-3.4A2.637,2.637,0,0,0,14.7,7.8Z"></path><polygon points="7 3 5 3 5 7 2 7 2 3 0 3 0 13 2 13 2 9 5 9 5 13 7 13 7 9 7 9 7 7 7 7 7 3"></polygon>',
    "heading-4": '<polygon points="7 3 5 3 5 7 2 7 2 3 0 3 0 13 2 13 2 9 5 9 5 13 7 13 7 9 7 9 7 7 7 7 7 3"></polygon><path d="M15,13H13V11H8V9.143L13.026,3H15V9h1v2H15ZM10.7,9H13V6.19Z"></path>',
    "heading-5": '<polygon points="7 3 5 3 5 7 2 7 2 3 0 3 0 13 2 13 2 9 5 9 5 13 7 13 7 9 7 9 7 7 7 7 7 3"></polygon><path d="M11.881,13a7.058,7.058,0,0,1-3.1-.93l.877-1.8A4.564,4.564,0,0,0,11.948,11C13.22,11,14,10.432,14,9.518a1.364,1.364,0,0,0-1.537-1.4,18.553,18.553,0,0,0-3.088.308L10.014,3H16V5H11.792l-.14,1.193a5.876,5.876,0,0,1,.8-.071A3.333,3.333,0,0,1,16,9.518C16,11.592,14.3,13.038,11.881,13Z"></path>',
    "heading-6": '<polygon points="7 3 5 3 5 7 2 7 2 3 0 3 0 13 2 13 2 9 5 9 5 13 7 13 7 9 7 9 7 7 7 7 7 3"></polygon><path d="M12.5,13C10.808,13,9,11.949,9,9c0-4.959,2.719-6,5-6h1V5H14a2.828,2.828,0,0,0-2.853,1.545A1.829,1.829,0,0,1,12.5,6a3.5,3.5,0,0,1,0,7ZM11,9.045C11.015,10.8,11.861,11,12.5,11a1.5,1.5,0,0,0,0-3A1.673,1.673,0,0,0,11,9.045Z"></path>',
  },
});
