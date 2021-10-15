(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[0],{

/***/ "./node_modules/vue-keypress/src/index.vue":
/*!*************************************************!*\
  !*** ./node_modules/vue-keypress/src/index.vue ***!
  \*************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _index_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./index.vue?vue&type=script&lang=js& */ "./node_modules/vue-keypress/src/index.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../../vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");
var render, staticRenderFns




/* normalize component */

var component = Object(_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_1__["default"])(
  _index_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"],
  render,
  staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "node_modules/vue-keypress/src/index.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./node_modules/vue-keypress/src/index.vue?vue&type=script&lang=js&":
/*!**************************************************************************!*\
  !*** ./node_modules/vue-keypress/src/index.vue?vue&type=script&lang=js& ***!
  \**************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _vue_loader_lib_index_js_vue_loader_options_index_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../vue-loader/lib??vue-loader-options!./index.vue?vue&type=script&lang=js& */ "./node_modules/vue-loader/lib/index.js?!./node_modules/vue-keypress/src/index.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_vue_loader_lib_index_js_vue_loader_options_index_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./node_modules/vue-loader/lib/index.js?!./node_modules/vue-keypress/src/index.vue?vue&type=script&lang=js&":
/*!****************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib??vue-loader-options!./node_modules/vue-keypress/src/index.vue?vue&type=script&lang=js& ***!
  \****************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);

const supportedModifiers = ['altKey', 'metaKey', 'ctrlKey', 'shiftKey']

/* harmony default export */ __webpack_exports__["default"] = ({
  props: {
    keyEvent: {
      type: String,
      default: 'keyup',
    },

    // Only for single key code:
    keyCode: {
      type: Number,
      default: null,
    },
    modifiers: {
      type: Array, // ['shiftKey', 'ctrlKey', 'altKey', 'metaKey']
      default: () => [],
    },
    preventDefault: {
      type: Boolean,
    },

    // Only for multiple key codes:
    multipleKeys: {
      type: Array,
      default: () => [],
    },
  },
  data: () => ({
    keyListeners: [],
  }),
  mounted() {
    this.setupListeners()
  },
  destroyed() {
    for (const { keyEvent, listener } of this.keyListeners) {
      window.removeEventListener(keyEvent, listener)
    }
  },
  methods: {
    /** Initial Setup of the listeners */
    /** ****************************** */
    setupListeners() {
      const expectedEvent = {
        keyEvent: this.keyEvent,

        // If single:
        keyCode: this.keyCode,
        preventDefault: this.preventDefault,
        modifiers: this.modifiers,
        // If multiple:
        multipleKeys: this.multipleKeys,
      }
      this.addEventListener(expectedEvent)
    },
    addEventListener(expectedEvent) {
      let listener = this.eventHandler(expectedEvent)
      window.addEventListener(expectedEvent.keyEvent, listener)
      this.keyListeners.push({ expectedEvent, listener })
    },

    /** Handling per keypress event */
    /** *************************** */
    eventHandler(expectedEvent) {
      return (event) => {
        const emitResponse = (emitEvent, message) => {
          this.$emit(emitEvent, {
            event,
            expectedEvent,
            message,
          })
        }
        // Emit the emitEvent '@any' in any case:
        emitResponse('any', 'Any key was pressed.')

        const inMultipleKeysMode = expectedEvent.multipleKeys.length > 0

        // In "any key" mode, emit '@success' and return
        const inAnyKeyMode = !expectedEvent.keyCode && !inMultipleKeysMode
        if (inAnyKeyMode) {
          emitResponse('success', 'Any key was pressed.')
          return
        }

        // Set expected inputs array respective to props bein "single" or "multiple"
        let expectedInputs = [expectedEvent]
        if (inMultipleKeysMode) {
          expectedInputs = expectedEvent.multipleKeys
        }

        for (const expectedInput of expectedInputs) {
          // Check if the correct keys have been clicked:
          const correctKeyPressed = expectedInput.keyCode === event.keyCode
          if (!correctKeyPressed) continue

          // Get modifiers:
          let hasModifiers = expectedInput.modifiers.length > 0

          // Check if only the specified modifiers were pressed
          if (hasModifiers) {
            const modifiersPressed = supportedModifiers.every(
              (x) => event[x] == (expectedInput.modifiers.indexOf(x) !== -1)
            )
            if (!modifiersPressed) continue
          }

          // SUCCESS -> if it got to here, this was the correct key.

          // Set Prevent-Default
          if (expectedEvent.preventDefault) {
            event.preventDefault()
          }
          emitResponse('success', 'Correct key(s) pressed.')
          return
        }

        // FAILURE: If it got to here, the correct key wasn't pressed:
        emitResponse('wrong', 'Wrong key(s) pressed.')
      }
    },
  },
  render: () => null,
});


/***/ })

}]);