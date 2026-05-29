
@php ($book_side_nav_active = 'finance')
@extends('layouts.book')

@section('title', 'Lookup CA IE Spending By Date/Election')

@section('content')

    <form id="form" name="form" onsubmit="return false" method="post">
        <div id="containerdiv" width="100%">
            <p>Period Start: <input type="text" name="pdstart" id="pdstart">
                Period End: <input type="text" name="pdend" id="pdend">&nbsp;OR&nbsp;


                <select id="election" name="election">
                    <option value="">SELECT ELECTION</option>

                    <option value="g16">2016 General - November 8th</option>
                    <option value="p16">2016 Primary-June 7th</option>

                    <option value="a14">2014-Both Primary & General</option>
                    <option value="p14">2014 Primary-June 3rd</option>
                    <option value="g14">2014 General-November 4th</option>
                    <option value="g14b">2014 General-November 4th (Last Two Months Only)</option>


                    <option value="a12">2012-Both Primary & General</option>
                    <option value="p12">2012 Primary-June 5th</option>
                    <option value="g12">2012 General-November 6th</option>
                    <option value="g12b">2012 General-November 6th (Last Two Months Only)</option>

                    <option value="a10">2010-Both Primary & General</option>
                    <option value="p10">2010 Primary-June 8th</option>
                    <option value="g10">2010 General-November 2nd</option>
                    <option value="g10b">2010 General-November 2nd (Last Two Months Only)</option>

                    <option value="a08">2008-Both Primary & General</option>
                    <option value="p08">2008 Primary-June 3rd</option>
                    <option value="g08">2008 General-November 4th</option>
                    <option value="g08b">2008 General-November 4th (Last Two Months Only)</option>

                    <option value="a06">2006-Both Primary & General</option>
                    <option value="p06">2006 Primary-June 6th</option>
                    <option value="g06">2006 General-November 7th</option>
                    <option value="g06b">2006 General-November 7th (Last Two Months Only)</option>

                </select>
                <button id="submitbutton" type="button" onclick="formhandler();">Retrieve</button>
            </p>
        </div>
    </form>
    <div id="hiddendiv" class="holds-the-iframe" style="display: none;"
         style="background-image: url('/img/spinner.gif');">
    </div>


@endsection

@section('scripts')
    <script>
      $(function () {
        $("#pdstart").datepicker({
          dateFormat: "yy-mm-dd"
        });
      });
      $(function () {
        $("#pdend").datepicker({
          dateFormat: "yy-mm-dd"
        });
      });
    </script>

    <script language="javascript">


      function formhandler(form) {

        var thedates = getdates(document.form.election.value);
        var ps = thedates[0];
        var pe = thedates[1];

        closeiframe();
        var link = "/img/spinner.gif";
        window.content.location.href = link;
        document.getElementById("hiddendiv").style["display"] = "inline-block";
        var URL = "iehist?ps=" + ps + "&pe=" + pe;
        if (document.form.election.value == "p16") {
          URL = "ca_ielist_p16";
        }

        if (document.form.election.value == "g16") {
          URL = "ca_ielist_g16";
        }
//alert(URL);
        window.content.location.href = URL;
        return false;


      }

      function getdates(value) {
        switch (value) {
          case "p14":
            ps = "2014-01-01";
            pe = "2014-06-03";
            break;
          case "g14":
            ps = "2014-06-04";
            pe = "2014-11-04";
            break;
          case "g14b":
            ps = "2014-09-04";
            pe = "2014-11-04";
            break;
          case "a14":
            ps = "2014-01-01";
            pe = "2014-11-04";
            break;

          case "p12":
            ps = "2012-01-01";
            pe = "2012-06-05";
            break;
          case "g12":
            ps = "2012-06-06";
            pe = "2012-11-06";
            break;
          case "g12b":
            ps = "2012-09-06";
            pe = "2012-11-06";
            break;
          case "a12":
            ps = "2012-01-01";
            pe = "2012-11-06";
            break;

          case "p10":
            ps = "2010-01-01";
            pe = "2010-06-08";
            break;
          case "g10":
            ps = "2010-06-09";
            pe = "2010-11-02";
            break;
          case "g10b":
            ps = "2010-09-02";
            pe = "2010-11-02";
            break;
          case "a10":
            ps = "2010-01-01";
            pe = "2010-11-02";
            break;

          case "p08":
            ps = "2008-01-01";
            pe = "2008-06-03";
            break;
          case "g08":
            ps = "2008-06-04";
            pe = "2008-11-04";
            break;
          case "g08b":
            ps = "2008-09-04";
            pe = "2008-11-04";
            break;
          case "a08":
            ps = "2008-01-01";
            pe = "2008-11-04";
            break;

          case "p06":
            ps = "2006-01-01";
            pe = "2006-06-06";
            break;
          case "g06":
            ps = "2006-06-07";
            pe = "2006-11-07";
            break;
          case "g06b":
            ps = "2006-09-07";
            pe = "2006-11-07";
            break;
          case "a06":
            ps = "2006-01-01";
            pe = "2006-11-07";
            break;

          default:
            ps = "";
            pe = "";

        }

        if (document.form.pdstart.value != "" && document.form.pdend.value != "") {
          ps = document.form.pdstart.value;
          pe = document.form.pdend.value;
        }
        return [ps, pe];
      }

      function closeiframe(type) {
        removeiframes();
        var link = "/img/spinner.gif";
        var iframe = document.createElement('iframe');
        iframe.frameBorder = 0;
        iframe.width = "1054px";
        iframe.height = "1200px";
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
