<?php

if (isset($_GET['id'])) {
    $fourcode = $_GET['id'];
} else {
    $fourcode = '';
}
?>

@extends('layouts.master')

@section('title', 'U.S. House of Representatives Districts | California Target Book')

@section('content')
    <div class='container'>


        

        <form id="form" name="form" onsubmit="return false" method="post">
            <div id="containerdiv" width="100%" style="text-align: center; margin-left: auto; margin-right: auto;">

                <select id="state" align="center" name="state">
                    <option value="">SELECT STATE</option>
                    <option value="AL">Alabama</option>
                    <option value="AK">Alaska</option>
                    <option value="AZ">Arizona</option>
                    <option value="AR">Arkansas</option>
                    <option value="CA">California</option>
                    <option value="CO">Colorado</option>
                    <option value="CT">Connecticut</option>
                    <option value="DE">Delaware</option>
                    <option value="DC">District Of Columbia</option>
                    <option value="FL">Florida</option>
                    <option value="GA">Georgia</option>
                    <option value="HI">Hawaii</option>
                    <option value="ID">Idaho</option>
                    <option value="IL">Illinois</option>
                    <option value="IN">Indiana</option>
                    <option value="IA">Iowa</option>
                    <option value="KS">Kansas</option>
                    <option value="KY">Kentucky</option>
                    <option value="LA">Louisiana</option>
                    <option value="ME">Maine</option>
                    <option value="MD">Maryland</option>
                    <option value="MA">Massachusetts</option>
                    <option value="MI">Michigan</option>
                    <option value="MN">Minnesota</option>
                    <option value="MS">Mississippi</option>
                    <option value="MO">Missouri</option>
                    <option value="MT">Montana</option>
                    <option value="NE">Nebraska</option>
                    <option value="NV">Nevada</option>
                    <option value="NH">New Hampshire</option>
                    <option value="NJ">New Jersey</option>
                    <option value="NM">New Mexico</option>
                    <option value="NY">New York</option>
                    <option value="NC">North Carolina</option>
                    <option value="ND">North Dakota</option>
                    <option value="OH">Ohio</option>
                    <option value="OK">Oklahoma</option>
                    <option value="OR">Oregon</option>
                    <option value="PA">Pennsylvania</option>
                    <option value="RI">Rhode Island</option>
                    <option value="SC">South Carolina</option>
                    <option value="SD">South Dakota</option>
                    <option value="TN">Tennessee</option>
                    <option value="TX">Texas</option>
                    <option value="UT">Utah</option>
                    <option value="VT">Vermont</option>
                    <option value="VA">Virginia</option>
                    <option value="WA">Washington</option>
                    <option value="WV">West Virginia</option>
                    <option value="WI">Wisconsin</option>
                    <option value="WY">Wyoming</option>
                </select>

                <select name="dist" id="dist" class="distval showonselect">
                    <option value=''>Choose District</option>
                </select>
                <button id="submitbutton" type="button" onclick="formhandler();">Get District</button>

                or Lookup 2018 Candidate/Incumbent: <input type="text" onkeyup="showHint(this.value)">


            </div>
        </form>


        <p align='center'><span id="txtHint"></span></p>

        <div id="hiddendiv" class="holds-the-iframe" style="display: none;"
             style="background-image: url('/img/spinner.gif');">
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
          xmlhttp.open("GET", "fec_cand_autocomplete.php?q=" + str, true);
          xmlhttp.send();
        }
      }

      $("#state").change(function () {
        $.ajax({
          url: "get_cds.php?id=" + $(this).val(),
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
        document.getElementById("hiddendiv").style["display"] = "inline-block";
        var URL = "get_fed_page_t.php?id=" + document.form.state.value + document.form.dist.value;
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