$(document).ready(function () {
  $(document).trigger("enhance.tablesaw");

  var visasm = true, vissen = true, viscon = true, visinc = true, vischa = true, visdem = true, visrep = true, visoth = true, visret = true, sortalpha = true, sortdist = false;
  var p16vis = true, offvis = true, g14vis = false, p14vis = false, g12vis = false, p12vis = false, biglist = false;

  var toggleList = function () {

    showAll();
    if (biglist == false)
      sortList();
    else {
      sortBigList();
    }

    if (visasm == false && vissen == false && viscon == false) {
      visasm = true;
      vissen = true;
      viscon = true;
      $('.asmtog').prop('checked', true);
      $('.sentog').prop('checked', true);
      $('.contog').prop('checked', true);
    }

    if (visinc == false && vischa == false) {
      visinc == true;
      vischa == true;
      $('.inctog').prop('checked', true);
      $('.chatog').prop('checked', true);
    }

    if (visdem == false && visrep == false && visoth == false) {
      visdem = true;
      visrep = true;
      visorg = true;
      $('.reptog').prop('checked', true);
      $('.demtog').prop('checked', true);
      $('.othtog').prop('checked', true);
    }

    if (visasm == false) {
      hideAsm();
    }

    if (vissen == false) {
      hideSen();
    }

    if (viscon == false) {
      hideCon();
    }

    if (visdem == false) {
      hideDem();
    }

    if (visrep == false) {
      hideRep();
    }

    if (visoth == false) {
      hideOth();
    }

    if (visinc == false) {
      hideInc();
    }

    if (vischa == false) {
      hideChal();
    }

    if (visret == false) {
      hideRet();
    }

  }

  var getKeys = function (obj) {
    var keys = [];
    for (var key in obj) {
      keys.push(key);
    }
    console.log("keys: " + keys);
    return keys;
  }

  function compare(a, b) {
    if (a.getElementsByTagName('div')[3].innerHTML < b.getElementsByTagName('div')[3].innerHTML)
      return -1;
    if (a.getElementsByTagName('div')[3].innerHTML > b.getElementsByTagName('div')[3].innerHTML)
      return 1;
    return 0;

  }

  function compalpha(a, b) {
    if (a.getElementsByTagName('div')[1].innerHTML < b.getElementsByTagName('div')[1].innerHTML)
      return -1;
    if (a.getElementsByTagName('div')[1].innerHTML > b.getElementsByTagName('div')[1].innerHTML)
      return 1;
    return 0;

  }

  function bigcompare(a, b) {
    if (a.getElementsByTagName('div')[7].innerHTML < b.getElementsByTagName('div')[7].innerHTML)
      return -1;
    if (a.getElementsByTagName('div')[7].innerHTML > b.getElementsByTagName('div')[7].innerHTML)
      return 1;
    return 0;

  }

  function bigcompalpha(a, b) {
    if (a.getElementsByTagName('div')[0].innerHTML < b.getElementsByTagName('div')[0].innerHTML)
      return -1;
    if (a.getElementsByTagName('div')[0].innerHTML > b.getElementsByTagName('div')[0].innerHTML)
      return 1;
    return 0;

  }

  /* var sortList = function() {

   var pageDivs = document.getElementsByClassName("candidate");
   var newContainer =new Array;
   var tempArray = new Array;
   var po = ""
   var pos = 0;

   for(i=0; i<pageDivs.length;i++) {
   po = pageDivs[i].getElementsByTagName('div')[3].innerHTML;
   if (i>0) {
   var result = compare(pageDivs[i],pageDivs[i-1]);
   pos = i + result
   }
   tempArray.push(pageDivs[i]);
   }

   if (sortdist == true ) {

   for(i=0; i<pageDivs.length;i++) {
   tempArray.sort(compare);
   }

   $('.listall').append(tempArray);

   }

   if (sortalpha == true) {
   for(i=0; i<pageDivs.length;i++) {
   tempArray.sort(compalpha);

   }
   $('.listall').append(tempArray);

   }
   $('.listall').attr('align', 'center');
   }*/

  var sortList = function () {

    var pageDivs = document.getElementsByClassName("candidate");
    var newContainer = new Array;
    var tempArray = new Array;
    var po = ""
    var pos = 0;

    for (i = 0; i < pageDivs.length; i++) {
      po = pageDivs[i].getElementsByTagName('div')[3].innerHTML;
      if (i > 0) {
        var result = compare(pageDivs[i], pageDivs[i - 1]);
        pos = i + result
      }
      tempArray.push(pageDivs[i]);
    }

    if (sortdist == true) {

      for (i = 0; i < pageDivs.length; i++) {
        tempArray.sort(compare);
      }

      $('.listall').append(tempArray);

    }

    if (sortalpha == true) {
      for (i = 0; i < pageDivs.length; i++) {
        tempArray.sort(compalpha);

      }
      $('.listall').append(tempArray);

    }
    $('.listall').attr('align', 'center');
  }


  var sortMe = function (a, b) {
    return a < b;
  }

  var sortBigList = function () {

    var pageDivs = document.getElementsByClassName("btcandidate");
    var newContainer = new Array;
    var tempArray = new Array;
    var po = "";
    var pos = 0;

    for (i = 0; i < pageDivs.length; i++) {
      //po = pageDivs[i].getElementsByTagName('div')[0].innerHTML;
      po = pageDivs[i].getElementsByTagName('div').innerHTML;

      if (i > 0) {
        var result = bigcompalpha(pageDivs[i], pageDivs[i - 1]);
        pos = i + result
      }
      tempArray.push(pageDivs[i]);
    }

    if (sortdist == true) {

      for (i = 0; i < pageDivs.length; i++) {
        tempArray.sort(bigcompare);
      }

      $('.biglist').append(tempArray);

    }

    if (sortalpha == true) {
      for (i = 0; i < pageDivs.length; i++) {
        tempArray.sort(bigcompalpha);

      }
      $('.biglist').append(tempArray);

    }
    $('.biglist').attr('align', 'center');
  }


  var sortMe = function (a, b) {
    return a < b;
  }


  var showAll = function () {
    $('.asm').show(300);
    $('.sen').show(300);
    $('.con').show(300);
    $('.dem').show(300);
    $('.rep').show(300);
    $('.inc').show(300);
    $('.oth').show(300);
    $('.chal').show(300);
    $('.termed').show(300);

  }

  var hideAll = function () {
    $('.asm').hide(300);
    $('.sen').hide(300);
    $('.con').hide(300);
    $('.dem').hide(300);
    $('.rep').hide(300);
    $('.inc').hide(300);
    $('.oth').hide(300);
    $('.chal').hide(300);
    $('.termed').hide(300);

  }

  var hideAsm = function () {
    $('.asm').hide(200);
  }

  var hideSen = function () {
    $('.sen').hide(200);
  }

  var hideCon = function () {
    $('.cong').hide(200);
  }

  var hideDem = function () {
    $('.dem').hide(200);
  }

  var hideRep = function () {
    $('.rep').hide(200);
  }

  var hideOth = function () {
    $('.oth').hide(200);
  }

  var hideInc = function () {
    $('.inc').hide(200);
  }

  var hideChal = function () {
    $('.chal').hide(200);
  }

  var hideRet = function () {
    $('.termed').hide(200);
  }


  $('.alpha').on('click', function () {
    if ($(this).is(":checked")) {
      sortalpha = true;
      sortdist = false;
      toggleList();
    }
  });

  $('.bydist').on('click', function () {
    if ($(this).is(":checked")) {
      sortdist = true;
      sortalpha = false;

      toggleList();
    }
  });

  $('.bigalpha').on('click', function () {
    if ($(this).is(":checked")) {
      sortalpha = true;
      sortdist = false;
      biglist = true;
      toggleList();
    }
  });

  $('.bigdist').on('click', function () {
    if ($(this).is(":checked")) {
      sortdist = true;
      sortalpha = false;
      biglist = true;
      toggleList();
    }
  });


  $('.asmtog').on('click', function () {
    if ($(this).is(":checked")) {
      visasm = true;
      toggleList();
    } else {
      visasm = false;
      toggleList();
    }
  });

  $('.sentog').on('click', function () {
    if ($(this).is(":checked")) {
      vissen = true;
      toggleList();
    } else {
      vissen = false;
      toggleList();
    }
  });

  $('.contog').on('click', function () {
    if ($(this).is(":checked")) {
      viscon = true;
      toggleList();
    } else {
      viscon = false;
      toggleList();
    }
  });

  $('.demtog').on('click', function () {
    if ($(this).is(":checked")) {
      visdem = true;
      toggleList();
    } else {
      visdem = false;
      toggleList();
    }
  });

  $('.reptog').on('click', function () {
    if ($(this).is(":checked")) {
      visrep = true;
      toggleList();
    } else {
      visrep = false;
      toggleList();
    }
  });

  $('.othtog').on('click', function () {
    if ($(this).is(":checked")) {
      visoth = true;
      toggleList();
    } else {
      visoth = false;
      toggleList();
    }
  });

  $('.inctog').on('click', function () {
    if ($(this).is(":checked")) {
      visinc = true;
      toggleList();
    } else {
      visinc = false;
      toggleList();
    }
  });

  $('.chatog').on('click', function () {
    if ($(this).is(":checked")) {
      vischa = true;
      toggleList();
    } else {
      vischa = false;
      toggleList();
    }
  });

  $('.rettog').on('click', function () {
    if ($(this).is(":checked")) {
      visret = true;
      toggleList();
    } else {
      visret = false;
      toggleList();
    }
  });

  $('input#id_search').quicksearch('.listall .candidate');
  $('input#bt_search').quicksearch('table .clickable-row');
  $('input#id_search').quicksearch('.clickable-row2');
  $('input#id_search').quicksearch('.altroster2 .altrow');
  $('input#db_search').quicksearch('.searchdbrost', {'delay': 100, 'stripeRows': ['odd', 'even']});
  $('input#id_search').quicksearch('#txtroster2 tr');
  $('input#leg_search').quicksearch('.rowsearch');
  $('input#people_search').quicksearch('.rowsearch');

  $('#altroster2').listnav();
  $('#txtroster2').listnav();

  /*

   $('input#search').quicksearch('table tbody tr', {
   'delay': 100,
   'selector': 'th',
   'stripeRows': ['odd', 'even'],
   'loader': 'span.loading',
   'noResults': 'tr#noresults',
   'bind': 'keyup keydown',
   'minValLength': 2,

   */


});


$('select[name=report]').on('change', function () {
  if ($(this).val() == 'vdetail' || $(this).val() == 'veth' || $(this).val() == 'vparty' || $(this).val() == 'vage' || $(this).val() == 'vcensus' || $(this).val() == 'vcf') {
    $('#districttype').show();
    $('#adlist').show();
    $('#fademe').fadeOut();
  } else {
    $('.showonselect').hide();
    $('#fademe').fadeIn();

  }
});

$('select[name=districttype]').on('change', function () {
  if ($(this).val() == 'addist') {
    $('#adlist').show();
    $('#sdlist').hide();
    $('#cdlist').hide();
    $('#countylist').hide();
  } else if ($(this).val() == 'sddist') {
    $('#sdlist').show();
    $('#adlist').hide();
    $('#cdlist').hide();
    $('#countylist').hide();
  } else if ($(this).val() == 'cddist') {
    $('#cdlist').show();
    $('#sdlist').hide();
    $('#adlist').hide();
    $('#countylist').hide();
  } else if ($(this).val() == 'county') {
    $('#countylist').show();
    $('#adlist').hide();
    $('#cdlist').hide();
    $('#sdlist').hide();
  } else {
    $('#sdlist').hide();
    $('#cdlist').hide();
    $('#adlist').hide();
    $('#countylists').hide();
  }
});


$('#loading_spinner').show();

$.tablesorter.addParser({
  id: 'thousands',
  is: function (s) {
    return false;
  },
  format: function (s) {
    return s.replace('$', '').replace(/,/g, '');
  },
  type: 'numeric'
});


$.tablesorter.addParser({
  id: "currency",
  is: function (s) {
    return /^[£$€?.]/.test(s);
  },
  format: function (s) {
    s = s.replace('.', '');
    return $.tablesorter.formatFloat(s.replace(new RegExp(/[^0-9.]/g), ""));
  },
  type: "numeric"
});

//window.open($(this).attr("href"), '_blank');

$(".sortclass").on('click', function () {
  window.location.href = $(this).val();
});

$(document).ready(function () {

  $('ul.tabs li').on('click', function () {
    var tab_id = $(this).attr('data-tab');

    $('ul.tabs li').removeClass('current');
    $('.tab-content').removeClass('current');

    $(this).addClass('current');
    $("#" + tab_id).addClass('current');
  })

});

$(document).ready(function () {

  $('ul.tabs2 li').on('click', function () {
    var tab_id = $(this).attr('data-tab');

    $('ul.tabs2 li').removeClass('current');
    $('.tab-content').removeClass('current');

    $(this).addClass('current');
    $("#" + tab_id).addClass('current');
  })

});

$(document).ready(function () {
  $notice = $('.notice');

  $notice.find('i').on('click', function() {
    $notice.removeClass('visible');
    $notice.addClass('hidden');
  });

  $notice.addClass('visible');

});
