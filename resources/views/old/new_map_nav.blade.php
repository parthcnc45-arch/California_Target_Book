@extends('layouts.master')

@section('title', 'Copyright | California Target Book')

@section('content')


    


    <form action="" enctype="text/plain" method="post" onsubmit="return valForm(this);">

        <div class='newseg container' style='display: inline-block; margin-left: auto; margin-right: auto;'>

            <div class='inner' style='margin-left: auto; margin-right: auto;'>


                <div>
                    <input type="radio" class="toggle" name="scope" value="co"> County<br>
                    <input type="radio" class="toggle" name="scope" value="ad"> Assembly District<br>
                    <input type="radio" class="toggle" name="scope" value="sd"> Senate District<br>
                    <input type="radio" class="toggle" name="scope" value="cd"> Congressional District<br>
                    </p>
                </div>

                <div align='center' style='margin-bottom: 20px;'>
                    <select name="ad" class="distval showonselect" style="display: none;" id="ad">
                        <option value='ALL_AD'>All Assembly District</option>
                        <option value='AD01'>1</option>
                        <option value='AD02'>2</option>
                        <option value='AD03'>3</option>
                        <option value='AD04'>4</option>
                        <option value='AD05'>5</option>
                        <option value='AD06'>6</option>
                        <option value='AD07'>7</option>
                        <option value='AD08'>8</option>
                        <option value='AD09'>9</option>
                        <option value='AD10'>10</option>
                        <option value='AD11'>11</option>
                        <option value='AD12'>12</option>
                        <option value='AD13'>13</option>
                        <option value='AD14'>14</option>
                        <option value='AD15'>15</option>
                        <option value='AD16'>16</option>
                        <option value='AD17'>17</option>
                        <option value='AD18'>18</option>
                        <option value='AD19'>19</option>
                        <option value='AD20'>20</option>
                        <option value='AD21'>21</option>
                        <option value='AD22'>22</option>
                        <option value='AD23'>23</option>
                        <option value='AD24'>24</option>
                        <option value='AD25'>25</option>
                        <option value='AD26'>26</option>
                        <option value='AD27'>27</option>
                        <option value='AD28'>28</option>
                        <option value='AD29'>29</option>
                        <option value='AD30'>30</option>
                        <option value='AD31'>31</option>
                        <option value='AD32'>32</option>
                        <option value='AD33'>33</option>
                        <option value='AD34'>34</option>
                        <option value='AD35'>35</option>
                        <option value='AD36'>36</option>
                        <option value='AD37'>37</option>
                        <option value='AD38'>38</option>
                        <option value='AD39'>39</option>
                        <option value='AD40'>40</option>
                        <option value='AD41'>41</option>
                        <option value='AD42'>42</option>
                        <option value='AD43'>43</option>
                        <option value='AD44'>44</option>
                        <option value='AD45'>45</option>
                        <option value='AD46'>46</option>
                        <option value='AD47'>47</option>
                        <option value='AD48'>48</option>
                        <option value='AD49'>49</option>
                        <option value='AD50'>50</option>
                        <option value='AD51'>51</option>
                        <option value='AD52'>52</option>
                        <option value='AD53'>53</option>
                        <option value='AD54'>54</option>
                        <option value='AD55'>55</option>
                        <option value='AD56'>56</option>
                        <option value='AD57'>57</option>
                        <option value='AD58'>58</option>
                        <option value='AD59'>59</option>
                        <option value='AD60'>60</option>
                        <option value='AD61'>61</option>
                        <option value='AD62'>62</option>
                        <option value='AD63'>63</option>
                        <option value='AD64'>64</option>
                        <option value='AD65'>65</option>
                        <option value='AD66'>66</option>
                        <option value='AD67'>67</option>
                        <option value='AD68'>68</option>
                        <option value='AD69'>69</option>
                        <option value='AD70'>70</option>
                        <option value='AD71'>71</option>
                        <option value='AD72'>72</option>
                        <option value='AD73'>73</option>
                        <option value='AD74'>74</option>
                        <option value='AD75'>75</option>
                        <option value='AD76'>76</option>
                        <option value='AD77'>77</option>
                        <option value='AD78'>78</option>
                        <option value='AD79'>79</option>
                        <option value='AD80'>80</option>
                    </select>

                    <select name="cd" class="distval showonselect" id="cd" style="display: none;">
                        <option value='ALL_CD'>All Congressional Districts</option>
                        <option value='CD01'>1</option>
                        <option value='CD02'>2</option>
                        <option value='CD03'>3</option>
                        <option value='CD04'>4</option>
                        <option value='CD05'>5</option>
                        <option value='CD06'>6</option>
                        <option value='CD07'>7</option>
                        <option value='CD08'>8</option>
                        <option value='CD09'>9</option>
                        <option value='CD10'>10</option>
                        <option value='CD11'>11</option>
                        <option value='CD12'>12</option>
                        <option value='CD13'>13</option>
                        <option value='CD14'>14</option>
                        <option value='CD15'>15</option>
                        <option value='CD16'>16</option>
                        <option value='CD17'>17</option>
                        <option value='CD18'>18</option>
                        <option value='CD19'>19</option>
                        <option value='CD20'>20</option>
                        <option value='CD21'>21</option>
                        <option value='CD22'>22</option>
                        <option value='CD23'>23</option>
                        <option value='CD24'>24</option>
                        <option value='CD25'>25</option>
                        <option value='CD26'>26</option>
                        <option value='CD27'>27</option>
                        <option value='CD28'>28</option>
                        <option value='CD29'>29</option>
                        <option value='CD30'>30</option>
                        <option value='CD31'>31</option>
                        <option value='CD32'>32</option>
                        <option value='CD33'>33</option>
                        <option value='CD34'>34</option>
                        <option value='CD35'>35</option>
                        <option value='CD36'>36</option>
                        <option value='CD37'>37</option>
                        <option value='CD38'>38</option>
                        <option value='CD39'>39</option>
                        <option value='CD40'>40</option>
                        <option value='CD41'>41</option>
                        <option value='CD42'>42</option>
                        <option value='CD43'>43</option>
                        <option value='CD44'>44</option>
                        <option value='CD45'>45</option>
                        <option value='CD46'>46</option>
                        <option value='CD47'>47</option>
                        <option value='CD48'>48</option>
                        <option value='CD49'>49</option>
                        <option value='CD50'>50</option>
                        <option value='CD51'>51</option>
                        <option value='CD52'>52</option>
                        <option value='CD53'>53</option>
                    </select>

                    <select name="sd" id="sd" class="distval showonselect" style="display: none;">
                        <option value='ALL_SD'>All State Senate Districts</option>
                        <option value='SD01'>1</option>
                        <option value='SD02'>2</option>
                        <option value='SD03'>3</option>
                        <option value='SD04'>4</option>
                        <option value='SD05'>5</option>
                        <option value='SD06'>6</option>
                        <option value='SD07'>7</option>
                        <option value='SD08'>8</option>
                        <option value='SD09'>9</option>
                        <option value='SD10'>10</option>
                        <option value='SD11'>11</option>
                        <option value='SD12'>12</option>
                        <option value='SD13'>13</option>
                        <option value='SD14'>14</option>
                        <option value='SD15'>15</option>
                        <option value='SD16'>16</option>
                        <option value='SD17'>17</option>
                        <option value='SD18'>18</option>
                        <option value='SD19'>19</option>
                        <option value='SD20'>20</option>
                        <option value='SD21'>21</option>
                        <option value='SD22'>22</option>
                        <option value='SD23'>23</option>
                        <option value='SD24'>24</option>
                        <option value='SD25'>25</option>
                        <option value='SD26'>26</option>
                        <option value='SD27'>27</option>
                        <option value='SD28'>28</option>
                        <option value='SD29'>29</option>
                        <option value='SD30'>30</option>
                        <option value='SD31'>31</option>
                        <option value='SD32'>32</option>
                        <option value='SD33'>33</option>
                        <option value='SD34'>34</option>
                        <option value='SD35'>35</option>
                        <option value='SD36'>36</option>
                        <option value='SD37'>37</option>
                        <option value='SD38'>38</option>
                        <option value='SD39'>39</option>
                        <option value='SD40'>40</option>
                    </select>

                    <select name="co" id="co" class="distval showonselect" style="display: none;">
                        <option value='ALL_CO'>All Counties</option>
                        <option value='CO01'>Alameda</option>
                        <option value='CO02'>Alpine</option>
                        <option value='CO03'>Amador</option>
                        <option value='CO04'>Butte</option>
                        <option value='CO05'>Calaveras</option>
                        <option value='CO06'>Colusa</option>
                        <option value='CO07'>Contra Costa</option>
                        <option value='CO08'>Del Norte</option>
                        <option value='CO09'>El Dorado</option>
                        <option value='CO10'>Fresno</option>
                        <option value='CO11'>Glenn</option>
                        <option value='CO12'>Humboldt</option>
                        <option value='CO13'>Imperial</option>
                        <option value='CO14'>Inyo</option>
                        <option value='CO15'>Kern</option>
                        <option value='CO16'>Kings</option>
                        <option value='CO17'>Lake</option>
                        <option value='CO18'>Lassen</option>
                        <option value='CO19'>Los Angeles</option>
                        <option value='CO20'>Madera</option>
                        <option value='CO21'>Marin</option>
                        <option value='CO22'>Mariposa</option>
                        <option value='CO23'>Mendocino</option>
                        <option value='CO24'>Merced</option>
                        <option value='CO25'>Modoc</option>
                        <option value='CO26'>Mono</option>
                        <option value='CO27'>Monterey</option>
                        <option value='CO28'>Napa</option>
                        <option value='CO29'>Nevada</option>
                        <option value='CO30'>Orange</option>
                        <option value='CO31'>Placer</option>
                        <option value='CO32'>Plumas</option>
                        <option value='CO33'>Riverside</option>
                        <option value='CO34'>Sacramento</option>
                        <option value='CO35'>San Benito</option>
                        <option value='CO36'>San Bernardino</option>
                        <option value='CO37'>San Diego</option>
                        <option value='CO38'>San Francisco</option>
                        <option value='CO39'>San Joaquin</option>
                        <option value='CO40'>San Luis Obispo</option>
                        <option value='CO41'>San Mateo</option>
                        <option value='CO42'>Santa Barbara</option>
                        <option value='CO43'>Santa Clara</option>
                        <option value='CO44'>Santa Cruz</option>
                        <option value='CO45'>Shasta</option>
                        <option value='CO46'>Sierra</option>
                        <option value='CO47'>Siskiyou</option>
                        <option value='CO48'>Solano</option>
                        <option value='CO49'>Sonoma</option>
                        <option value='CO50'>Stanislaus</option>
                        <option value='CO51'>Sutter</option>
                        <option value='CO52'>Tehama</option>
                        <option value='CO53'>Trinity</option>
                        <option value='CO54'>Tulare</option>
                        <option value='CO55'>Tuolumne</option>
                        <option value='CO56'>Ventura</option>
                        <option value='CO57'>Yolo</option>
                        <option value='CO58'>Yuba</option>
                    </select>

                    <select name="sub" id="sub" style='display: none;' class="distval showonselect">
                        <option value=''>County Only</option>
                        <option value='ALL'>All Supervisorial Districts</option>
                        <option value='1'>1st Supervisorial District</option>
                        <option value='2'>2nd Supervisorial District</option>
                        <option value='3'>3rd Supervisorial District</option>
                        <option value='4'>4th Supervisorial District</option>
                        <option value='5'>5th Supervisorial District</option>
                    </select>

                    <select name="sub_sf" id="sub_sf" style='display: none' class="distval showonselect">
                        <option value=''>County Only</option>
                        <option value='ALL'>All Supervisorial Districts</option>
                        <option value='1'>1st Supervisorial District</option>
                        <option value='2'>2nd Supervisorial District</option>
                        <option value='3'>3rd Supervisorial District</option>
                        <option value='4'>4th Supervisorial District</option>
                        <option value='5'>5th Supervisorial District</option>
                        <option value='6'>6th Supervisorial District</option>
                        <option value='7'>7th Supervisorial District</option>
                        <option value='8'>8th Supervisorial District</option>
                        <option value='9'>9th Supervisorial District</option>
                        <option value='10'>10th Supervisorial District</option>
                        <option value='11'>11th Supervisorial District</option>
                    </select>


                </div>

                <div align='center'>

                    <select name="election" id="election" class="distval showonselect">
                        <option value='2010'>2012 - 2020 Boundaries</option>
                        <option value='2000'>2002 - 2010 Boundaries</option>
                        <option value='1990'>1992 - 2000 Boundaries</option>
                    </select>
                </div>


            </div>


            <div style='clear: both; margin-top: 20px; margin-bottom: 20px; margin-left: auto; margin-right: auto; padding: 10px;'
                 align='center'>
                <input type="submit" value="Generate Map">
            </div>

        </div>

    </form>

    <div id="hiddendiv" class="holds-the-iframe" style="display: none;"
         style="background-image: url('/img/spinner.gif');">
    </div>


@endsection

@section('scripts')
    <script>


      function runme() {
        $('input[type="radio"]').click(function () {
          if (this.value == 'ad') {
            $('#ad').show();
          } else {
            $('#ad').hide();
          }

          if (this.value == 'cd') {
            $('#cd').show();
          } else {
            $('#cd').hide();
            document.getElementsByName('cd').value = '';
            document.getElementById("cd").value = '';
          }

          if (this.value == 'sd') {
            $('#sd').show();
          } else {
            $('#sd').hide();
            document.getElementsByName('sd').value = '';
            document.getElementById("sd").value = '';
          }

          if (this.value == 'co') {
            $('#co').show();
          } else {
            $('#co').hide();
            $('#sub').val('');
            $('#sub_sf').val('');
            $('#sub').hide();
            $('#sub_sf').hide();
            document.getElementsByName('co').value = '';
            document.getElementById("co").value = '';
            form.sub.value = '';
            form.sub_sf.value = '';

          }

        });

        $("#co").change(function () {
          //alert("COUNTY SELECT HANDLER");
          if (this.value == "CO38") {
            $('#sub_sf').show();
            $('#sub').hide();
          } else {
            $('#sub').show();
            $('#sub_sf').hide();
          }
        });


      }

      function valForm(form) {

        var type, electionappend, fourcode, e1, e2, URL, error = '';

        var x = $("input[name=scope]:checked").val();


        if (form.election.value) {
          electionappend = '&year=' + form.election.value;
        } else {
          electionappend = '&year=2010';
        }


        if (x == "co") {
          fourcode = form.co.value;
          electionappend = '';

          if (form.sub.value) {
            subappend = '&sub=' + form.sub.value;
          } else if (form.sub_sf.value) {
            subappend = '&sub=' + form.sub_sf.value;
          } else {
            subappend = '';
          }

        } else {
          subappend = '';
        }

        if (x == "cd") {
          fourcode = form.cd.value;
        }

        if (x == "ad") {
          fourcode = form.ad.value;
        }

        if (x == "sd") {
          fourcode = form.sd.value;
        }


        if (error) {
          //alert(URL);
          alert(error);
          return false;
        } else {
          closeiframe();

          var URL = '/book/draw_leg?id=' + fourcode + subappend + electionappend;
          var link = "/img/spinner.gif";
          //alert(URL);
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
        iframe.width = "1030px";
        iframe.height = "800px";
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