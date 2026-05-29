'use strict';

$(function() {
  let $nav = $('nav.navbar'),
    $booklink = $nav.find('.main-nav li.book a'),
    $mobileNav = $nav.find('.mobile-nav');

    // show under nav
    $booklink.on('mouseover', () => $nav.addClass('show-under'));

    // hide under nav on click away
    $('body').on('click', () => $nav.removeClass('show-under'));
    $nav.on('click', e => e.stopPropagation());


    // mobile menu
    $nav.find('.navbar-toggle')
      .on('click tap', () => $mobileNav.toggleClass('open'));

    $mobileNav.find('li.book-item a')
      .on('click tap', function() {
        $(this).siblings('div.sub-side-menu').addClass('open');
      });
    $mobileNav.find('li.book-item .sub-side-menu-back')
      .on('click tap', function() {
        $(this).parent('div.sub-side-menu').removeClass('open');
      });

})