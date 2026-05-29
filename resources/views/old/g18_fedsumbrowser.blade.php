
@php ($book_side_nav_active = 'finance')
@extends('layouts.book')

@section('title', 'Federal Campaign Finance Browser - 2018 | California Target Book')

@section('content')
    <div class="container-fluid">

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
                <button id="submitbutton" type="button" onclick="formhandler();">Submit</button>
            </div>
        </form>


        <!--
        <div id="hiddendiv" class="holds-the-iframe iframe-container" style="display: none;" style="background-image: url('/img/spinner.gif');" >
        </div>

        -->


        <div id="hiddendiv" class="holds-the-iframe iframe-container" style="display: none;"
                style="background-image: url('/img/spinner.gif');"></div>


        @endsection

        @section('styles')

            <script language="javascript">


              function formhandler(form) {

                closeiframe();
                var link = "/img/spinner.gif";
                window.content.location.href = link;
                document.getElementById("hiddendiv").style["display"] = "inline-block";
                var URL = "g18_fedspend_bystate?id=" + document.form.state.value;
//alert(URL);
                window.content.location.href = URL;
                return false;


              }

              function closeiframe(type) {
                removeiframes();
                var link = "/img/spinner.gif";
                var iframe = document.createElement('iframe');
                iframe.frameBorder = 0;
                iframe.width = "1024px";
                iframe.height = "1280px";
                iframe.id = "hiddeniframe";
                iframe.name = "content";
                iframe.class = 'embed-responsive-item';
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


                #dropdown {
                    text-align: center;
                    margin-left: auto;
                    margin-right: auto;
                }

                .iframe-container {
                    position: relative;
                    width: 100%;
                    padding-bottom: 100%;

                }

                .iframe-container > * {
                    display: block;
                    position: absolute;
                    top: 0;
                    right: 0;
                    bottom: 0;
                    left: 0;
                    margin: 0;
                    padding: 0;
                    height: 100%;
                    width: 100%;
                }

                select {
                    display: inline-block;
                    margin: 0 auto;
                }

            </style>
@endsection
