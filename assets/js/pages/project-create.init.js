/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!***************************************************!*\
  !*** ./resources/js/pages/project-create.init.js ***!
  \***************************************************/
/*
Template Name: MCHD Manager - Admin & Dashboard Template
Author: Themesbrand
Website: https://Themesbrand.com/
Contact: Themesbrand@gmail.com
File: Project create init js
*/
// ckeditor

var dropzonePreviewNode = document.querySelector("#dropzone-preview-list");

if (dropzonePreviewNode) {
  dropzonePreviewNode.id = "";
  var previewTemplate = dropzonePreviewNode.parentNode.innerHTML;
  dropzonePreviewNode.parentNode.removeChild(dropzonePreviewNode);
  var dropzone = new Dropzone(".dropzone", {
    url: 'https://httpbin.org/post',
    method: "post",
    previewTemplate: previewTemplate,
    previewsContainer: "#dropzone-preview"
  });
}
/******/ })()
;
