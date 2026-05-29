@extends('layouts.iframe')

@section('title', 'Overlap Nav | California Target Book')

@section('content')


    <style type="text/css">

        body {
            background-color: white;
        }

        .holds-the-iframe {
            background: url('/img/spinner.gif') no-repeat;

        }

    </style>

    <script>

document.addEventListener("DOMContentLoaded", function(){
  load_run(); // Handler when the DOM is fully loaded

});
      </script>


    <form action="" enctype="text/plain" method="post" onsubmit="return valForm(this);">

        <div class='newseg container' style='display: inline-block; margin-left: auto; margin-right: auto;'>

                <div class='inner' style='margin: 20px; padding: 5px; float: left; border: 2px solid black; '>
                    <p align='center'>DISTRICT 1</p>


                    <div>
                        <input type="radio" class="toggle" name="scope1" value="co1"> County<br>
                        <input type="radio" class="toggle" name="scope1" value="ad1"> Assembly District<br>
                        <input type="radio" class="toggle" name="scope1" value="sd1"> Senate District<br>
                        <input type="radio" class="toggle" name="scope1" value="cd1"> Congressional District<br>
                        </p>
                    </div>

                    <div align='center' style='margin-bottom: 20px;'>
                        <select name="ad1" class="distval showonselect" style="display: none;" id="ad1">
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

                        <select name="cd1" class="distval showonselect" id="cd1" style="display: none;">
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

                        <select name="sd1" id="sd1" class="distval showonselect" style="display: none;">
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

                        <select name="co1" id="co1" class="distval showonselect" style="display: none;">
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

                        <select name="sub1" id="sub1" style='display: none;' class="distval showonselect">
                            <option value=''>County Only</option>
                            <option value='1'>1st Supervisorial District</option>
                            <option value='2'>2nd Supervisorial District</option>
                            <option value='3'>3rd Supervisorial District</option>
                            <option value='4'>4th Supervisorial District</option>
                            <option value='5'>5th Supervisorial District</option>
                        </select>

                        <select name="sub_sf1" id="sub_sf1" style='display: none' class="distval showonselect">
                            <option value=''>County Only</option>
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

                        <select name="election1" id="election1" class="distval showonselect">
                            <option value='2010'>2012 - 2020 Boundaries</option>
                            <option value='2000'>2002 - 2010 Boundaries</option>
                            <option value='1990'>1992 - 2000 Boundaries</option>
                        </select>
                    </div>

                </div>


                <div class='inner' style='margin: 20px; padding: 5px; float: left; border: 2px solid black; '>
                    <p align='center'>DISTRICT 2</p>


                    <div>
                        <input type="radio" class="toggle" name="scope2" value="co2"> County<br>
                        <input type="radio" class="toggle" name="scope2" value="ad2"> Assembly District<br>
                        <input type="radio" class="toggle" name="scope2" value="sd2"> Senate District<br>
                        <input type="radio" class="toggle" name="scope2" value="cd2"> Congressional District<br>
                        </p>
                    </div>

                    <div align='center' style='margin-bottom: 20px;'>
                        <select name="ad2" class="distval showonselect" style="display: none;" id="ad2">
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

                        <select name="cd2" class="distval showonselect" id="cd2" style="display: none;">
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

                        <select name="sd2" id="sd2" class="distval showonselect" style="display: none;">
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

                        <select name="co2" id="co2" class="distval showonselect" style="display: none;">
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

                        <select name="sub2" id="sub2" style='display: none;' class="distval showonselect">
                            <option value=''>County Only</option>
                            <option value='1'>1st Supervisorial District</option>
                            <option value='2'>2nd Supervisorial District</option>
                            <option value='3'>3rd Supervisorial District</option>
                            <option value='4'>4th Supervisorial District</option>
                            <option value='5'>5th Supervisorial District</option>
                        </select>

                        <select name="sub_sf2" id="sub_sf2" style='display: none' class="distval showonselect">
                            <option value=''>County Only</option>
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

                        <select name="election2" id="election2" class="distval showonselect">
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

      function load_run() {
            runme1();
            runme2();
          }

          function runme1() {
            $('input[name="scope1"]').click(function () {
              if (this.value == 'ad1') {
                $('#ad1').show();
              } else {
                $('#ad1').hide();
                document.getElementsByName('ad1').value = '';
                document.getElementById("ad1").value = '';
              }

              if (this.value == 'cd1') {
                $('#cd1').show();
              } else {
                $('#cd1').hide();
                document.getElementsByName('cd1').value = '';
                document.getElementById("cd1").value = '';
              }

              if (this.value == 'sd1') {
                $('#sd1').show();
              } else {
                $('#sd1').hide();
                document.getElementsByName('sd1').value = '';
                document.getElementById("sd1").value = '';
              }

              if (this.value == 'co1') {
                $('#co1').show();
              } else {
                $('#co1').hide();
                $('#sub1').val('');
                $('#sub_sf1').val('');
                $('#sub1').hide();
                $('#sub_sf1').hide();
                document.getElementsByName('co1').value = '';
                document.getElementById("co1").value = '';
                form.sub1.value = '';
                form.sub_sf1.value = '';

              }

            });

            $("#co1").change(function () {
              //alert("COUNTY SELECT HANDLER");
              if (this.value == "CO38") {
                $('#sub_sf1').show();
                $('#sub1').hide();
              } else {
                $('#sub1').show();
                $('#sub_sf1').hide();
              }
            });


          }

          function runme2() {
            $('input[name="scope2"]').click(function () {


              if (this.value == 'ad2') {
                $('#ad2').show();
              } else {
                $('#ad2').hide();
                document.getElementsByName('ad2').value = '';
                document.getElementById("ad2").value = '';
              }

              if (this.value == 'cd2') {
                $('#cd2').show();
              } else {
                $('#cd2').hide();
                document.getElementsByName('cd2').value = '';
                document.getElementById("cd2").value = '';
              }

              if (this.value == 'sd2') {
                $('#sd2').show();
              } else {
                $('#sd2').hide();
                document.getElementsByName('sd2').value = '';
                document.getElementById("sd2").value = '';
              }

              if (this.value == 'co2') {
                $('#co2').show();
              } else {
                $('#co2').hide();
                $('#sub2').val('');
                $('#sub_sf2').val('');
                $('#sub2').hide();
                $('#sub_sf2').hide();
                document.getElementsByName('co2').value = '';
                document.getElementById("co2").value = '';
                form.sub2.value = '';
                form.sub_sf2.value = '';

              }

            });

            $("#co2").change(function () {
              //alert("COUNTY SELECT HANDLER");
              if (this.value == "CO38") {
                $('#sub_sf2').show();
                $('#sub2').hide();
              } else {
                $('#sub2').show();
                $('#sub_sf2').hide();
              }
            });


          }

          function valForm(form) {

            var type, electionappend1, fourcode1, electionappend2, fourcode2, e1, e2, URL, error = '';

            var x1 = $("input[name=scope1]:checked").val();
            var x2 = $("input[name=scope2]:checked").val();


            if (form.election1.value) {
              electionappend1 = '&d1y=' + form.election1.value;
            } else {
              electionappend1 = '&d1y=2010';
            }


            if (x1 == "co1") {
              fourcode1 = form.co1.value;
              electionappend1 = '';

              if (form.sub1.value) {
                subappend1 = '&d1s=' + form.sub1.value;
              } else if (form.sub_sf1.value) {
                subappend1 = '&d1s=' + form.sub_sf1.value;
              } else {
                subappend1 = '';
              }

            } else {
              subappend1 = '';
            }

            if (x1 == "cd1") {
              fourcode1 = form.cd1.value;
            }

            if (x1 == "ad1") {
              fourcode1 = form.ad1.value;
            }

            if (x1 == "sd1") {
              fourcode1 = form.sd1.value;
            }


            if (form.election2.value) {
              electionappend2 = '&d2y=' + form.election2.value;
            } else {
              electionappend2 = '&d2y=2010';
            }


            if (x2 == "co2") {
              fourcode2 = form.co2.value;
              electionappend2 = '';

              if (form.sub2.value) {
                subappend2 = '&d2s=' + form.sub2.value;
              } else if (form.sub_sf2.value) {
                subappend2 = '&d2s=' + form.sub_sf2.value;
              } else {
                subappend2 = '';
              }

            } else {
              subappend2 = '';
            }

            if (x2 == "cd2") {
              fourcode2 = form.cd2.value;
            }

            if (x2 == "ad2") {
              fourcode2 = form.ad2.value;
            }

            if (x2 == "sd2") {
              fourcode2 = form.sd2.value;
            }


            if (error) {
              //alert(URL);
              alert(error);
              return false;
            } else {
              closeiframe();

              var URL = '/ctb-legacy/draw_overlap.php?d1f=' + fourcode1 + subappend1 + electionappend1 + '&d2f=' + fourcode2 + subappend2 + electionappend2;
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




