// import files
import './styles/app.css';
import $ from 'jquery';
import 'bootstrap';
import '@fortawesome/fontawesome-free/js/all.js';

require("bootstrap-datepicker");
// translate datepiker to ar-TN
$.fn.datepicker.dates["ar-tn"] = {
    days: ["الأحد", "الاثنين", "الثلاثاء", "الأربعاء", "الخميس", "الجمعة", "السبت", "الأحد"],
    daysShort: ["أحد", "اثنين", "ثلاثاء", "أربعاء", "خميس", "جمعة", "سبت", "أحد"],
    daysMin: ["ح", "ن", "ث", "ع", "خ", "ج", "س", "ح"],
    months: ["جانفي", "فيفري", "مارس", "أفريل", "ماي", "جوان", "جويليه", "أوت", "سبتمبر", "أكتوبر", "نوفمبر", "ديسمبر"],
    monthsShort: ["جانفي", "فيفري", "مارس", "أفريل", "ماي", "جوان", "جويليه", "أوت", "سبتمبر", "أكتوبر", "نوفمبر", "ديسمبر"],
    today: "هذا اليوم",
    rtl: !0
};
//  enable datepiker
$('.datepicker').datepicker({
    format: 'yyyy/mm/dd',
    language: 'ar-tn',
    autoclose: true,
});
// enable tooltip
$(function () {
    $('[data-toggle="tooltip"]').tooltip();
});
// add class css to element
$('form[name="search_form"]').addClass("float-left col-md-3");
$('form[name="reset_password_request_form"]').addClass("user");
$('form[name="change_password_form"]').addClass("user");
// enable link to tab
let url = document.location.toString();
if (url.match('#')) {
    $('.nav-tabs a[href="#' + url.split('#')[1] + '"]').tab('show');
}
// Change hash for page-reload
$('.nav-tabs a').on('shown.bs.tab', function (e) {
    window.location.hash = e.target.hash;
})
// javascript for theme
$(function () {
    "use strict";
    if (localStorage.getItem("toggled") === "close") {
        $("body").toggleClass("sidebar-toggled");
        $(".sidebar").toggleClass("toggled");
    }
    $("#sidebarToggle, #sidebarToggleTop").on('click', function (e) {
        if (localStorage.getItem("toggled") === "close") {
            localStorage.setItem("toggled", "open");
            $("body").removeClass("sidebar-toggled");
            $(".sidebar").removeClass("toggled");
        } else {
            localStorage.setItem("toggled", "close");
            $("body").toggleClass("sidebar-toggled");
            $(".sidebar").toggleClass("toggled");

        }
    });
    // Close any open menu accordions when window is resized below 768px
    $(window).resize(function () {
        if ($(window).width() < 768) {
            $('.sidebar .collapse').collapse('hide');
        }
        // Toggle the side navigation when window is resized below 480px
        if ($(window).width() < 480 && !$(".sidebar").hasClass("toggled")) {
            $("body").addClass("sidebar-toggled");
            $(".sidebar").addClass("toggled");
            $('.sidebar .collapse').collapse('hide');
        }
    });
    // Prevent the content wrapper from scrolling when the fixed side navigation hovered over
    $('body.fixed-nav .sidebar').on('mousewheel DOMMouseScroll wheel', function (e) {
        if ($(window).width() > 768) {
            var e0 = e.originalEvent,
                delta = e0.wheelDelta || -e0.detail;
            this.scrollTop += (delta < 0 ? 1 : -1) * 30;
            e.preventDefault();
        }
    });
    // Scroll to top button appear
    $(document).on('scroll', function () {
        var scrollDistance = $(this).scrollTop();
        if (scrollDistance > 100) {
            $('.scroll-to-top').fadeIn();
        } else {
            $('.scroll-to-top').fadeOut();
        }
    });
    // Smooth scrolling using jQuery easing
    $(document).on('click', 'a.scroll-to-top', function (e) {
        var $anchor = $(this);
        $('html, body').stop().animate({
            scrollTop: ($($anchor.attr('href')).offset().top)
        }, 1000, 'easeInOutExpo');
        e.preventDefault();
    });
});
