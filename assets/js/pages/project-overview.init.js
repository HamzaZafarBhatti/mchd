/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!*****************************************************!*\
  !*** ./resources/js/pages/project-overview.init.js ***!
  \*****************************************************/
/*
Template Name: MCHD Manager - Admin & Dashboard Template
Author: Themesbrand
Website: https://Themesbrand.com/
Contact: Themesbrand@gmail.com
File: Project overview init js
*/
// favourite btn
var favouriteBtn = document.querySelectorAll(".favourite-btn");

if (favouriteBtn) {
  document.querySelectorAll(".favourite-btn").forEach(function (item) {
    item.addEventListener("click", function (event) {
      this.classList.toggle("active");
    });
  });
}
/******/ })()
;
