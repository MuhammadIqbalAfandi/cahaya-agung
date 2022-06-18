"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_pages_Customers_useCreate_js"],{

/***/ "./resources/js/components/useFormErrorReset.js":
/*!******************************************************!*\
  !*** ./resources/js/components/useFormErrorReset.js ***!
  \******************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "useFormErrorReset": () => (/* binding */ useFormErrorReset)
/* harmony export */ });
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.esm-bundler.js");
/* harmony import */ var _inertiajs_inertia_vue3__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @inertiajs/inertia-vue3 */ "./node_modules/@inertiajs/inertia-vue3/dist/index.js");


function useFormErrorReset(form) {
  var errors = (0,vue__WEBPACK_IMPORTED_MODULE_0__.computed)(function () {
    return (0,_inertiajs_inertia_vue3__WEBPACK_IMPORTED_MODULE_1__.usePage)().props.value.errors;
  });
  (0,vue__WEBPACK_IMPORTED_MODULE_0__.watch)(errors, function () {
    form.clearErrors();
  });
}

/***/ }),

/***/ "./resources/js/pages/Customers/useCreate.js":
/*!***************************************************!*\
  !*** ./resources/js/pages/Customers/useCreate.js ***!
  \***************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "useCreate": () => (/* binding */ useCreate)
/* harmony export */ });
/* harmony import */ var _inertiajs_inertia_vue3__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @inertiajs/inertia-vue3 */ "./node_modules/@inertiajs/inertia-vue3/dist/index.js");
/* harmony import */ var _components_useFormErrorReset__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @/components/useFormErrorReset */ "./resources/js/components/useFormErrorReset.js");


function useCreate() {
  var form = (0,_inertiajs_inertia_vue3__WEBPACK_IMPORTED_MODULE_0__.useForm)({
    name: null,
    address: null,
    phone: null,
    npwp: null
  });
  (0,_components_useFormErrorReset__WEBPACK_IMPORTED_MODULE_1__.useFormErrorReset)(form);

  var onSubmit = function onSubmit() {
    form.post(route('customers.store'), {
      onSuccess: function onSuccess() {
        return form.reset();
      }
    });
  };

  return {
    onSubmit: onSubmit,
    form: form
  };
}

/***/ })

}]);