@extends('layouts.iframe')

@section('title', 'Map Nav | California Target Book')

@section('content')


    


    <form action="" enctype="text/plain" method="post" onsubmit="return valForm(this);">

        <div class='newseg container' style='display: inline-block; margin-left: auto; margin-right: auto;'>

            <div class='inner' style='margin-left: auto; margin-right: auto;'>


                <div align='center'>

                    <select name="election" id="election" class="distval showonselect">
                        <option value=''>Select Election</option>
                        <option value='g16'>2016 General Election</option>
                        <option value='p16'>2016 Primary Election</option>
                        <option value='g14'>2014 General Election</option>
                        <option value='p14'>2014 Primary Election</option>
                        <option value='g12'>2012 General Election</option>
                        <option value='p12'>2012 Primary Election</option>
                        <option value='g08'>2008 General Election</option>
                        <option value='g04'>2004 General Election</option>
                    </select>

                    <select name="datavis" id="datavis" class="distval showonselect">
                        <option value=''>Select Layer Colorization Option</option>
                        <option value='REG'>By Registration</option>
                        <option value='LAT'>By Latino Registration Heatmap</option>
                        <option value='ASN'>By Asian Registration Heatmap</option>
                        <option value='POP'>By Population Heatmap</option>
                        <option value='VOT'>By Voter Turnout Heatmap</option>
                        <option value='AD'>By Candidate For Assembly</option>
                        <option value='SD'>By Candidate For State Senate</option>
                        <option value='CD'>By Candidate For Congress</option>
                        <option value='GOV'>By Candidate For Governor</option>
                        <option value='LTG'>By Candidate For Lt. Governor</option>
                        <option value='ATG'>By Candidate For Attorney General</option>
                        <option value='SOS'>By Candidate For Secretary of State</option>
                        <option value='TRS'>By Candidate For Treasurer</option>
                        <option value='CON'>By Candidate For Controller</option>
                        <option value='INS'>By Candidate For Insurance Commissioner</option>
                        <option value='SPI'>By Candidate For Superintendent of Public Instruction</option>
                        <option value='SEN'>By Candidate For U.S. Senate</option>
                        <option value='PRS'>By Presidential Candidate (General Election)</option>
                        <option value='DPP'>By Democratic Presidential Primary Candidate</option>
                        <option value='RPP'>By Republican Presidential Primary Candidate</option>
                    </select>

                    <input type="submit" value="Generate Map">
                </div>

            </div>

        </div>

    </form>

    <div id="hiddendiv" class="holds-the-iframe" style="display: none;"
         style="background-image: url('/img/spinner.gif');">
    </div>


@endsection

@section('scripts')
    <script>

        <?php

        $fourcode = $_GET['id'];

        ?>


        function valForm(form) {

          var type, datavisappend, electionappend, fourcode, e1, e2, URL, error = '';

          var x = $("input[name=scope]:checked").val();


          if (form.datavis.value) {
            datavisappend = '&vis=' + form.datavis.value;
          } else {
            datavisappend = '&vis=REG';
          }

          if (form.election.value) {
            electionappend = '&election=' + form.election.value;
          } else {
            electionappend = '&election=g16';
          }


          if (error) {
            //alert(URL);
            //alert(error);
            return false;
          } else {
            closeiframe();

            var URL = "/book/precinct_test_t?id=<?php echo $fourcode; ?>" + datavisappend + electionappend;
            var link = "/img/spinner.gif";
            alert(URL);
            window.content.location.href = link;
            document.getElementById("hiddendiv").style["display"] = "inline-block";
            window.content.location.href = URL;
            return false;
          }


        }

        function closeiframe(type) {
          removeiframes();
          var link = "/img/spinner.gif";
          var iframe = document.createElement('iframe');
          iframe.frameBorder = 0;
          iframe.width = "850px";
          iframe.height = "850px";
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

    body {
        background-color: white;
    }

    .holds-the-iframe {
        background: url('/img/spinner.gif') no-repeat;

    }

</style>
@endsection