var ChartColor = ["#5D62B4", "#54C3BE", "#EF726F", "#F9C446", "rgb(93.0, 98.0, 180.0)", "#21B7EC", "#04BCCC"];
var primaryColor = getComputedStyle(document.body).getPropertyValue('--primary');
var secondaryColor = getComputedStyle(document.body).getPropertyValue('--secondary');
var successColor = getComputedStyle(document.body).getPropertyValue('--success');
var warningColor = getComputedStyle(document.body).getPropertyValue('--warning');
var dangerColor = getComputedStyle(document.body).getPropertyValue('--danger');
var infoColor = getComputedStyle(document.body).getPropertyValue('--info');
var darkColor = getComputedStyle(document.body).getPropertyValue('--dark');
var lightColor = getComputedStyle(document.body).getPropertyValue('--light');

(function ($) {
  'use strict';
  $(function () {
    var body = $('body');
    var contentWrapper = $('.content-wrapper');
    var scroller = $('.container-scroller');
    var footer = $('.footer');
    var sidebar = $('.sidebar');

    //Add active class to nav-link based on url dynamically
    //Active class can be hard coded directly in html file also as required

    $(document).ready(function () {
      var currentUrl = window.location.href;
      var currentPath = window.location.pathname;

      function addActiveClass(element) {
        var href = element.attr('href');

        if (href === currentUrl || href === currentPath) {
          element.parents('.nav-item').last().addClass('active');

          if (element.parents('.sub-menu').length) {
            element.closest('.collapse').addClass('show');
            element.addClass('active');
          }

          if (element.parents('.submenu-item').length) {
            element.addClass('active');
          }
        }
      }

      $('#sidebar .nav li a').each(function () {
        var $this = $(this);
        addActiveClass($this);
      });
    });



    $('.horizontal-menu .nav li a').each(function () {
      var $this = $(this);
      addActiveClass($this);
    })

    //Close other submenu in sidebar on opening any

    sidebar.on('show.bs.collapse', '.collapse', function () {
      sidebar.find('.collapse.show').collapse('hide');
    });


    //Change sidebar and content-wrapper height
    applyStyles();

    function applyStyles() {
      //Applying perfect scrollbar
      if (!body.hasClass("rtl")) {
        if (body.hasClass("sidebar-fixed")) {
          var fixedSidebarScroll = new PerfectScrollbar('#sidebar .nav');
        }
      }
    }

    $('[data-toggle="minimize"]').on("click", function () {
      if ((body.hasClass('sidebar-toggle-display')) || (body.hasClass('sidebar-absolute'))) {
        body.toggleClass('sidebar-hidden');
      } else {
        body.toggleClass('sidebar-icon-only');
      }
    });

    //checkbox and radios
    $(".form-check label,.form-radio label").append('<i class="input-helper"></i>');

    //fullscreen
    $("#fullscreen-button").on("click", function toggleFullScreen() {
      if ((document.fullScreenElement !== undefined && document.fullScreenElement === null) || (document.msFullscreenElement !== undefined && document.msFullscreenElement === null) || (document.mozFullScreen !== undefined && !document.mozFullScreen) || (document.webkitIsFullScreen !== undefined && !document.webkitIsFullScreen)) {
        if (document.documentElement.requestFullScreen) {
          document.documentElement.requestFullScreen();
        } else if (document.documentElement.mozRequestFullScreen) {
          document.documentElement.mozRequestFullScreen();
        } else if (document.documentElement.webkitRequestFullScreen) {
          document.documentElement.webkitRequestFullScreen(Element.ALLOW_KEYBOARD_INPUT);
        } else if (document.documentElement.msRequestFullscreen) {
          document.documentElement.msRequestFullscreen();
        }
      } else {
        if (document.cancelFullScreen) {
          document.cancelFullScreen();
        } else if (document.mozCancelFullScreen) {
          document.mozCancelFullScreen();
        } else if (document.webkitCancelFullScreen) {
          document.webkitCancelFullScreen();
        } else if (document.msExitFullscreen) {
          document.msExitFullscreen();
        }
      }
    })
    if ($.cookie('purple-free-banner') != "true") {
      document.querySelector('#proBanner').classList.add('d-flex');
      document.querySelector('.navbar').classList.remove('fixed-top');
    }
    else {
      document.querySelector('#proBanner').classList.add('d-none');
      document.querySelector('.navbar').classList.add('fixed-top');
    }

    if ($(".navbar").hasClass("fixed-top")) {
      document.querySelector('.page-body-wrapper').classList.remove('pt-0');
      document.querySelector('.navbar').classList.remove('pt-5');
    }
    else {
      document.querySelector('.page-body-wrapper').classList.add('pt-0');
      document.querySelector('.navbar').classList.add('pt-5');
      document.querySelector('.navbar').classList.add('mt-3');

    }
    document.querySelector('#bannerClose').addEventListener('click', function () {
      document.querySelector('#proBanner').classList.add('d-none');
      document.querySelector('#proBanner').classList.remove('d-flex');
      document.querySelector('.navbar').classList.remove('pt-5');
      document.querySelector('.navbar').classList.add('fixed-top');
      document.querySelector('.page-body-wrapper').classList.add('proBanner-padding-top');
      document.querySelector('.navbar').classList.remove('mt-3');
      var date = new Date();
      date.setTime(date.getTime() + 24 * 60 * 60 * 1000);
      $.cookie('purple-free-banner', "true", { expires: date });
    });
  });
})(jQuery);

let sub_menu = document.querySelectorAll('.submenu-item .collapse');
let sub_menu_link = document.querySelectorAll('.submenu-item > .nav-link');
let sub_menu_arrow = document.querySelector('.submenu-item > .nav-link > i');
for (let index = 0; index < sub_menu_link.length; index++) {
  sub_menu_link[index].addEventListener('click', function () {
    let nmane = this.parentElement.lastElementChild.className;
    if (nmane === "collapse show") {
      sub_menu.forEach(sub_menu_element => {
        sub_menu_element.classList.remove('show');
      });

      this.lastElementChild.classList.remove('rotate-arrow')
      this.parentElement.lastElementChild.classList.remove('show');
    }
    if (nmane === "collapse") {
      sub_menu.forEach(sub_menu_element => {
        sub_menu_element.classList.remove('show');
      });
      sub_menu_arrow.classList.remove('rotate-arrow')
      this.lastElementChild.classList.add('rotate-arrow')
      this.parentElement.lastElementChild.classList.add('show');
    }

  })
}

let sub_sub_menu = document.querySelectorAll('.sub-submenu-item .collapse');
let sub_sub_menu_link = document.querySelectorAll('.sub-submenu-item > .nav-link');
let sub_sub_menu_arrow = document.querySelector('.sub-submenu-item > .nav-link > i');

for (let index = 0; index < sub_sub_menu_link.length; index++) {
  sub_sub_menu_link[index].addEventListener('click', function () {
    let nmane = this.parentElement.lastElementChild.className;
    if (nmane === "collapse show") {
      sub_sub_menu.forEach(sub_sub_menu_element => {
        sub_sub_menu_element.classList.remove('show');
      });

      this.lastElementChild.classList.remove('rotate-arrow')
      this.parentElement.lastElementChild.classList.remove('show');
    }
    if (nmane === "collapse") {
      sub_sub_menu.forEach(sub_sub_menu_element => {
        sub_sub_menu_element.classList.remove('show');
      });

      sub_sub_menu_arrow.classList.remove('rotate-arrow')
      this.lastElementChild.classList.add('rotate-arrow')
      this.parentElement.lastElementChild.classList.add('show');
    }

  })
}

if (document.querySelectorAll(".navbar-menu-wrapper .wallet-balance").length > 0) {
  document.querySelector('.navbar-nav-right').style.marginLeft = '10px';
}