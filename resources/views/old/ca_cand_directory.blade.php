
@extends('layouts.bookNew')
@php ($book_side_nav_active = 'candidates')


@section('title', 'Candidate Directory | California Target Book')

@section('content')

    <div class='container-fluid pt-lg'>
        <div class='row'>
            <div class='col-lg-12'>
                <h2>Lookup California Candidate</h2>

                  <div class="row mt-md">
                    <div class="form-group col-sm-6 col-md-4 col-lg-3">
                      <input type="text"
                              placeholder="Search..."
                              class="form-control"
                              onkeyup="showHint(this.value)">
                    </div>
                  </div>
                  <div class="responsive_tablee">
                    <div id='txtHint'></div>
                  </div>
                


                <p align='center'><span id="txtHint"></span></p>

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

      function formhandler(option) {
        switch (option) {
          case "CA_All":
            //alert("Triggered All CA Candidates");


            $.ajax({
              url: "/book/get_ca_roster",
              type: 'GET',
              dataType: 'json',
              success: function (data) {
                if (data.success) {
                  $('#txtHint').html(data.content);
                }
                else {
                  alert();  // Handle error
                }
              }
            });

            break;
          case "CA_Inc":
            //alert("Triggered All CA Incumbents");

            $.ajax({
              url: "/book/get_ca_roster?type=inc",
              type: 'GET',
              dataType: 'json',
              success: function (data) {
                if (data.success) {
                  $('#txtHint').html(data.content);
                }
                else {
                  alert();  // Handle error
                }
              }
            });

            break;
          case "US_All":
            //alert("Triggered All US Candidates");

            $.ajax({
              url: "/book/get_us_roster",
              type: 'GET',
              dataType: 'json',
              success: function (data) {
                if (data.success) {
                  $('#txtHint').html(data.content);
                }
                else {
                  alert();  // Handle error
                }
              }
            });
            break;
          case "US_Inc":
            //alert("Triggered All US Incumbents");

            $.ajax({
              url: "/book/get_us_roster?type=inc",
              type: 'GET',
              dataType: 'json',
              success: function (data) {
                if (data.success) {
                  $('#txtHint').html(data.content);
                }
                else {
                  alert();  // Handle error
                }
              }
            });
            break;
          default:
            //DO NOTHING
            break;
        }
      }

      function showHint(str) {
          var xmlhttp = new XMLHttpRequest();
          xmlhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
              document.getElementById("txtHint").innerHTML = this.responseText;
            }
          };
          xmlhttp.open("GET", "/book/ca_cand_autocomplete?q=" + str, true);
          xmlhttp.send();
      }

      $("#state").change(function () {
        $.ajax({
          url: "get_cds?id=" + $(this).val(),
          type: 'GET',
          dataType: 'json',
          success: function (data) {
            if (data.success) {
              $('#dist').html(data.options);
            }
            else {
              alert();  // Handle error
            }
          }
        });
      });

      $(document).ready(function () {
        formhandler('CA_All');
      });

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
<style type="text/css">

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