
@extends('layouts.book')
@php ($book_side_nav_active = 'elections')

@section('title', 'City Detail Browser')

@section('content')
    <div class='container-fluid pt-lg'>
        <div class='row'>
            <div class='col-lg-12'>

                <form id="form" name="form" onsubmit="return false" method="post">
                    <div id="containerdiv" width="100%"
                         style="text-align: center; margin-left: auto; margin-right: auto;">

                        <select id="state" align="center" name="state">
                            <option value="">SELECT COUNTY</option>
                            <option value="Alameda">Alameda</option>
                            <option value="Alpine">Alpine</option>
                            <option value="Amador">Amador</option>
                            <option value="Butte">Butte</option>
                            <option value="Calaveras">Calaveras</option>
                            <option value="Colusa">Colusa</option>
                            <option value="Contra Costa">Contra Costa</option>
                            <option value="Del Norte">Del Norte</option>
                            <option value="El Dorado">El Dorado</option>
                            <option value="Fresno">Fresno</option>
                            <option value="Glenn">Glenn</option>
                            <option value="Humboldt">Humboldt</option>
                            <option value="Imperial">Imperial</option>
                            <option value="Inyo">Inyo</option>
                            <option value="Kern">Kern</option>
                            <option value="Kings">Kings</option>
                            <option value="Lake">Lake</option>
                            <option value="Lassen">Lassen</option>
                            <option value="Los Angeles">Los Angeles</option>
                            <option value="Madera">Madera</option>
                            <option value="Marin">Marin</option>
                            <option value="Mariposa">Mariposa</option>
                            <option value="Mendocino">Mendocino</option>
                            <option value="Merced">Merced</option>
                            <option value="Modoc">Modoc</option>
                            <option value="Mono">Mono</option>
                            <option value="Monterey">Monterey</option>
                            <option value="Napa">Napa</option>
                            <option value="Nevada">Nevada</option>
                            <option value="Orange">Orange</option>
                            <option value="Placer">Placer</option>
                            <option value="Plumas">Plumas</option>
                            <option value="Riverside">Riverside</option>
                            <option value="Sacramento">Sacramento</option>
                            <option value="San Benito">San Benito</option>
                            <option value="San Bernardino">San Bernardino</option>
                            <option value="San Diego">San Diego</option>
                            <option value="San Francisco">San Francisco</option>
                            <option value="San Joaquin">San Joaquin</option>
                            <option value="San Luis Obispo">San Luis Obispo</option>
                            <option value="San Mateo">San Mateo</option>
                            <option value="Santa Barbara">Santa Barbara</option>
                            <option value="Santa Clara">Santa Clara</option>
                            <option value="Santa Cruz">Santa Cruz</option>
                            <option value="Shasta">Shasta</option>
                            <option value="Sierra">Sierra</option>
                            <option value="Siskiyou">Siskiyou</option>
                            <option value="Solano">Solano</option>
                            <option value="Sonoma">Sonoma</option>
                            <option value="Stanislaus">Stanislaus</option>
                            <option value="Sutter">Sutter</option>
                            <option value="Tehama">Tehama</option>
                            <option value="Trinity">Trinity</option>
                            <option value="Tulare">Tulare</option>
                            <option value="Tuolumne">Tuolumne</option>
                            <option value="Ventura">Ventura</option>
                            <option value="Yolo">Yolo</option>
                            <option value="Yuba">Yuba</option>
                        </select>

                        <select name="dist" id="dist" class="distval showonselect">
                            <option value=''>Choose Sub-Division</option>
                        </select>
                        <button id="submitbutton" type="button" onclick="formhandler();">Retrieve Results</button>


                    </div>
                </form>


                <p align='center'><span id="txtHint"></span></p>

                <div id="hiddendiv" class="holds-the-iframe center-block" style="display: none;"
                     style="background-image: url('/img/spinner.gif');">
                </div>


            </div>
        </div>
    </div>
@endsection

@section('scripts')

    <script language="javascript">

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
          xmlhttp.open("GET", "/book/get_city_autocomplete?q=" + str, true);
          xmlhttp.send();
        }
      }

      $("#state").change(function () {
        $.ajax({
          url: "get_subdivisions?id=" + $(this).val(),
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

      function formhandler(form) {

        closeiframe();
        var link = "/img/spinner.gif";
        window.content.location.href = link;
        document.getElementById("hiddendiv").style["display"] = "block";

        var test = document.form.dist.value;
        if (test.indexOf('Supervisorial') >= 0) {
          // Found world
          var lastChar = test.substr(test.length - 1); // => "1"
          var URL = "/book/get_supe_dist?id=" + document.form.state.value + "&sub=" + lastChar;
          //alert(URL);
        } else {

          var URL = "/book/get_county_sub2?id=" + document.form.state.value + "&sub=" + encodeURI(document.form.dist.value);
        }


//alert(URL);
        window.content.location.href = URL;
        return false;


      }

      function resizeIframe(obj) {
        obj.style.height = obj.contentWindow.document.body.scrollHeight + 'px';
      }

      function closeiframe(type) {
        removeiframes();
        var link = "/img/spinner.gif";
        var iframe = document.createElement('iframe');
        //iframe.frameBorder=0;
        //iframe.scrolling='no';
        iframe.setAttribute("onload", "resizeIframe(this)");
        iframe.width = "1048px";
        iframe.height = "1600px";
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

  .holds-the-iframe {
      background: url('/img/spinner.gif') center center no-repeat;
      display: block;
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
    iframe {
        margin: 0 auto;
    }

</style>
@endsection
