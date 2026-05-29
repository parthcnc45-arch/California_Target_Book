
@extends('layouts.book')
@php ($book_side_nav_active = 'candidates')

@section('title', '2026 Candidate Directory | California Target Book')

@section('content')

    <div class="book-page-head row m-n">
        <h2>Lookup 2026 Candidate/Incumbent</h2>
    </div>

    <div class='container-fluid pt-lg'>


        <div class='row '>
            <div class='col-lg-12'>


                <div class="radio-tabs" v-ctb-radio-tabs>
                    <label for="ca_all" class="active">
                        <input id="ca_all" type='radio' name='select_roster' value='ca_all' checked>
                        All 2026 CA Candidates
                    </label>
                    <label for="ca_inc">
                        <input id="ca_inc" type='radio' name='select_roster' value='ca_inc'>
                        CA Incumbents
                    </label>

                    <label for="us_all">
                        <input id="us_all" type='radio' name='select_roster' value='us_all'>
                        US House Candidates
                    </label>

                    <label for="us_inc">
                        <input id="us_inc" type='radio' name='select_roster' value='us_inc'>
                        US House Incumbents
                    </label>

                </div>

                <div class="row mt-md">
                    <div class="form-group col-sm-6 col-md-4 col-lg-3">
                        <input type="text"
                                id="rosterSearch"
                                name="search"
                                placeholder="Search..."
                                class="form-control" />
                    </div>
                    <div id="loader" class="col-xs-2 hidden">
                        <ctb-loader></ctb-loader>
                        {{--<div class="loader"></div>--}}
                    </div>
                </div>

                <div id='txtHint'></div>

                <div id="hiddendiv" class="holds-the-iframe" style="display: none;"
                     style="background-image: url('/img/spinner.gif');">
                </div>
            </div>

        </div>
    </div>
@endsection

@section('scripts')
    <script>gtag('set', { 'book_category': 'candidates' });</script>
    <script language="javascript">

      (function () {

        var currentType;
        var urlMap = {
          'ca_all': '/book/get_ca_roster?year=2026',
          'ca_inc': '/book/get_ca_roster?year=2026&type=inc',
          'us_all': '/book/get_us_roster?year=2026',
          'us_inc': '/book/get_us_roster?year=2026&type=inc',
        };

        updateTableType('ca_all');

        function updateTableType(type) {
          if (type === currentType) return;
          currentType = type;

          $('#loader').removeClass('hidden');

          $.ajax({
            url: urlMap[type],
            type: 'GET',
            dataType: 'json',
            success: function (data) {
              if (data.success) {
                var TableComponent = Vue.extend({ template: data.content });
                // console.lo
                var component = new TableComponent().$mount();
                $('#txtHint').html(component.$el);

                var table = $('#roster').DataTable();

                $('#rosterSearch').on('keyup', function () {
                  table.search(this.value).draw();
                });
                $('#rosterSearch').trigger('keyup')
              }
              $('#loader').addClass('hidden');
            }
          });

        }

        $('input[type=radio][name=select_roster]').on('change', function() {
          $('#txtHint').html('');
          if (this.checked) updateTableType(this.value);
        });



      }());



      function showHint(str) {
        if (str.length == 0) {
          document.getElementById("txtHint").innerHTML = "";
          return;
        } else {
          var xmlhttp = new XMLHttpRequest();
          xmlhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
              document.getElementById("txtHint").innerHTML = this.responseText;
            }
          };
          xmlhttp.open("GET", "/book/all_cand_autocomplete?q=" + str, true);
          xmlhttp.send();
        }
      }

      // $("#state").change(function () {
      //   $.ajax({
      //     url: "/book/get_cds?id=" + $(this).val(),
      //     type: 'GET',
      //     dataType: 'json',
      //     success: function (data) {
      //       if (data.success) {
      //         $('#dist').html(data.options);
      //       }
      //       else {
      //         alert();  // Handle error
      //       }
      //     }
      //   });
      // });
      //
      // $(document).ready(function () {
      //   formhandler('ca_all');
      // });

      /*
       function formhandler(form){

       closeiframe();
       var link = "/img/spinner.gif";
       window.content.location.href=link;
       document.getElementById("hiddendiv").style["display"] = "inline-block";
       var URL = "/ctb-legacy/get_fed_page_t?id=" + document.form.state.value + document.form.dist.value;
       //alert(URL);
       window.content.location.href=URL;
       return false;


       }

       */

      function resizeIframe(obj) {
        obj.style.height = obj.contentWindow.document.body.scrollHeight + 'px';
      }

      function closeiframe(type) {
        removeiframes();
        var link = "/img/spinner.gif";
        var iframe = document.createElement('iframe');
        iframe.frameBorder = 0;
        iframe.scrolling = 'no';
        iframe.setAttribute("onload", "resizeIframe(this)");
        iframe.width = "1048px";
        iframe.height = "1280px";
        iframe.id = "hiddeniframe";
        iframe.name = "content";
        iframe.setAttribute("src", link);
        iframe.setAttribute("background-color", "white");
        document.getElementById("hiddendiv").appendChild(iframe);
        return false;
      }

      function removeiframes() {
        var iframes = document.querySelectorAll('iframe');
        for (var i = 0; i < iframes.length; i++) {
          iframes[i].parentNode.removeChild(iframes[i]);
        }
      }

    </script>
@endsection



@section('styles')
<style>

    body, html, form, select, option {
        font-family: 'Lato';

    }

    .holds-the-iframe {
        background: url('/img/spinner.gif') center center no-repeat;

    }

    #dropdown {
        text-align: center;
        margin-left: auto;
        margin-right: auto;
    }

    select {
        display: inline-block;
        margin: 0 auto;
    }
</style>
@endsection