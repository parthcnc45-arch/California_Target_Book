'use strict';

$(function() {
  
  const $nav = $('.dist-side-nav'),
    $sections = $nav.find('.dropdown-menu').parent('li');

    // Register events
  $sections
    .on('click', function(e) {
      e.stopPropagation();
      let $level = $(this).parent('ul');
      $level.find(' > li').removeClass('open')
      $(this).addClass('open');
    });


    // Initialize
    let $activeEl = $nav.find(`li a[href="${window.location.pathname}"]`);
    $activeEl.addClass('active');
    $activeEl.parents('li').addClass('open');

});